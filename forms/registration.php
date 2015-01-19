<?php

require 'vendor/autoload.php';
use Mailgun\Mailgun;

Dotenv::load(__DIR__);

$mg = new Mailgun(getenv('MAILGUN_KEY'));
$domain = getenv('MAILGUN_DOMAIN');

$message = "";
$redirect = "/thank-you.shtml";

foreach ($_REQUEST as $key => $value) {
  if ($key === "_redirect") {
    $redirect = $value;
    continue;
  }
  $message .= $key . ": " . $value . "\n\r";
}

$mg->sendMessage($domain, array('from'    => getenv('ORIGIN_EMAIL'), 
                                'to'      => getenv('DESTINATION_EMAIL'), 
                                'subject' => getenv('SUBJECT'), 
                                'text'    => $message ));

header('Location: ' . $redirect);
