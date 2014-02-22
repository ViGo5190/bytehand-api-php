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


$config = require('config.php');



$sender = ByteHandAPI\smser::init($config);


//print_r( $sender::sendMessage('+10000000000','Hello!?') );
//
print_r( $sender::checkBalance() );
print_r( $sender::checkMessageStatus(67712275045867270) );


echo "test";