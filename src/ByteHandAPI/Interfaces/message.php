<?php
/**
 * Stan Gumeniuk i@vig.gs
 * Date: 22.02.14
 * Time: 21:22
 */

namespace ByteHandAPI\Interfaces;


interface message {


    /**
     * Set to whom we want send sms
     * @param $to
     * @return $this
     * @throws \Exception
     */
    public function to($to);


    /**
     * Set sms text
     * @param $text
     * @return $this
     * @throws \Exception
     */
    public function text($text);

    /**
     * @param $after
     * @return $this
     * @throws \Exception
     */
    public function after($after);

    /**
     * Send message
     * @return $this
     * @throws \Exception
     */
    public function send();

    /**
     * @return $this
     * @throws \Exception
     */
    public function checkStatus();
} 