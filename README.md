bytehand-api-php
=========

bytehand-api-php is a strang php script for sending sms via bytehand.

  - Sendind SMS 
  - Check balance
  - Check SMS status

About ByteHand
=========
[ByteHand](http://www.bytehand.com/?r=b773476a61167edd) - is a service for sending sms for global. Please, use my referral link [http://www.bytehand.com/?r=b773476a61167edd](http://www.bytehand.com/?r=b773476a61167edd)

Version
----

0.2

Tech
-----------

Specification:

* PHP 5.3 required

Installation
--------------
Just use composer



Use
--------------

```php
<?php

$config = array(
              'id' => 0000,
              'key' => "XXXXXXXXXXXXXXX",
              'from' => "SMS-INFO",
          );
ByteHandAPI\smser::init($config);



$message = new ByteHandAPI\message();
echo $message->to('cell number')->text("test message")->send()->getStatus();
$message_id = $message->getId();

$message_old = new ByteHandAPI\message($message_id);
echo $mmm->getStatus();



?>
```






    
