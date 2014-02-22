<?php
/**
 * Stan Gumeniuk i@vig.gs
 * Date: 18.02.14
 * Time: 12:00
 */

namespace ByteHandAPI\Interfaces;


interface smser {

    /**
     * Check balance
     *
     * @return mixed
     */
    public static function checkBalance();

    /**
     * @param $to
     * @param $text
     * @param bool $after
     * @return mixed
     */
    public static function sendMessage($to,$text,$after = false);

    /**
     * @param $id
     * @return mixed
     */
    public static function checkMessageStatus($id);
}