<?php
/**
 * Stan Gumeniuk i@vig.gs
 * Date: 18.02.14
 * Time: 15:15
 */

namespace ByteHandAPI;


final class smser implements Interfaces\smser
{

    private static $ssl = true;
    private static $port = 8443;

    private static $domain = "bytehand.com";

    private static $url = "https://bytehand.com:8443/";

    private static $instance;
    private static $config = false;


    /* set */

    public static function setPort($port = 0) {
        if ((int)$port > 0) {
            self::$port = $port;
        }
    }

    public static function setSsl($ssl = true) {
        self::$ssl = (bool)$ssl;
    }

    public static function setDomain($domain) {
        $parsed_url = parse_url($domain, PHP_URL_PATH);
        if (!$parsed_url['host']) {
            throw new \Exception('Wrong domain!');
        } else {
            self::$domain = $parsed_url['host'];
        }
    }

    public function setUrl($url) {
        $parsed_url = parse_url($url, PHP_URL_PATH);
        if (!$parsed_url['host']) {
            throw new \Exception('Wrong domain!');
        } else {
            self::$domain = $parsed_url['host'];
        }

        if ($parsed_url['sheme'] && $parsed_url['sheme'] == "https") {
            self::$ssl = true;
        }

        if ($parsed_url['port'] && (int)$parsed_url['port'] > 0) {
            self::$ssl = true;
        }
    }

    /* get */

    public function getUrl() {
        return self::$url;
    }

    /* init */

    public static function initUrl() {
        self::$url = "http" . (self::$ssl ? "s" : "") . "://" . self::$domain . ":" . self::$port . "/";
        return self::getUrl();
    }

    public static function init($config_array = false) {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        if ($config_array && !self::$config) {
            self::$config = self::checkConfigArray($config_array);
        } elseif ($config_array && self::$config) {
            throw new \Exception('Smser exist! Please delete it first!');
        }

        self::initUrl();

        return self::$instance;
    }

    /* --- */


    private function __construct() { /* ... @return Smser */ }

    private function __clone() { /* ... @return Smser */ }

    private function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }


    private static function checkConfigArray(Array $config = array()) {
        if (!$config['id'] || !$config['key'] || !$config['from']) {
            return false;
        }

        return array(
            'id' => $config['id'],
            'key' => $config['key'],
            'from' => $config['from'],
        );
    }

    private static function parseResponse($response) {
        $result = json_decode($response, true);
        return $result;
    }

    private static function getResponse($url, $post = false, $postMsg = false) {
        $ch = curl_init();

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => 'UTF-8',
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_URL => $url,
            CURLOPT_POST => $post,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
        );

        if ($postMsg) {
            $options[CURLOPT_POSTFIELDS] = $postMsg;
            $options[CURLOPT_HTTPHEADER] =
                array('Content-Type:application/json',
                    'Content-Length: ' . strlen($postMsg));
        }

        curl_setopt_array($ch, $options);

        $content = curl_exec($ch);


        if (curl_errno($ch)) {
            throw new \Exception("Curl error: ".curl_error($ch));
        } else {
            curl_close($ch);
        }


        return $content;
    }

    private static function parseTo($to) {
        return $to;
    }

    /* --- */

    public static function checkBalance() {
        $response = self::getResponse(self::getUrl() . 'balance?id=' . self::$config['id'] . '&key=' . self::$config['key']);
        $result = self::parseResponse($response);
        return $result;
    }

    public static function sendMessage($to, $text, $after = false) {
        $to = self::parseTo($to);
        $msgs = array(
            array(
                'to' => $to,
                'from' => self::$config['from'],
                'text' => $text
            ),
        );
        $msgs_json = json_encode($msgs);
        $response = self::getResponse(
            self::getUrl() . 'send_multi?id=' . self::$config['id'] . '&key=' . self::$config['key'],
            true,
            $msgs_json
        );

        $result = self::parseResponse($response);
        $result = end($result);
        return $result;
    }

    public static function checkMessageStatus($id){
        $response = self::getResponse(self::getUrl() . 'details?id=' . self::$config['id'] . '&key=' . self::$config['key']. '&message='.$id);
        $result = self::parseResponse($response);
        return $result;
    }


}