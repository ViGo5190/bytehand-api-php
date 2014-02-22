<?php
/**
 * Stan Gumeniuk i@vig.gs
 * Date: 18.02.14
 * Time: 10:59
 */
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set ( 'Etc/GMT-4' );

require_once __DIR__.'/../vendor/autoload.php';

// INIT
$config = require('config.php');
ByteHandAPI\smser::init($config);



$message = new ByteHandAPI\message();
echo $message->to('cell number')->text("test 2")->send()->getStatus();
$message_id = $message->getId();

$message_old = new ByteHandAPI\message($message_id);
echo $mmm->getStatus();



