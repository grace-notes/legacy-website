<?php

require 'vendor/autoload.php';
use Mailgun\Mailgun;

Dotenv::load(__DIR__);

$mg = new Mailgun(getenv('MAILGUN_KEY'));
$domain = getenv('MAILGUN_DOMAIN');

$message = "";
$redirect = "/thank-you.shtml";
$isNew = false;
$email = '';

$errors = array();
print_r($_REQUEST);
if(!empty($_REQUEST['g-recaptcha-response'])) {
	$args = array('secret' => getenv('RECAPTCHA_SECRET_KEY'),
								'response' => $_REQUEST['g-recaptcha-response'],
								'remoteip' => $_SERVER['REMOTE_ADDR']);
	$result = file_get_contents('https://www.google.com/recaptcha/api/siteverify?'.http_build_query($args));
	print('<br>');
	print_r($result);
	$result = json_decode($result);
	if(!$result->success) {
		$errors[] = "Human validation failed.";
	}
} else {
	$errors[] = "Human validation failed.";
}

if(empty($_REQUEST['name']) || strlen($_REQUEST['name']) < 2) {
	$errors[] = "Name is not valid.";
}

if(empty($_REQUEST['email']) || !filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
	$errors[] = "Email is not valid.";
}

if($errors != "") {
	print implode("<br>", $errors);
	exit;
}

foreach ($_REQUEST as $key => $value) {
  if ($key === "_redirect") {
    $redirect = $value;
    continue;
  }
	if($key === "email") {
		$email = $value;
	}
	if($key === "first" and $value === "yes") {
		$isNew = true;
	}
  $message .= $key . ": " . $value . "\n\r";
}

print_r($_REQUEST);

// if($isNew) {
// 	$result = $mg->sendMessage($domain, array(
// 			'from'    		=> getenv('ORIGIN_EMAIL'),
// 	    'to'      		=> $email,
// 	    'subject' 		=> getenv('SUBJECT'),
// 	    'text'    		=> file_get_contents('newstudent.txt'),
// 			'html'    		=> file_get_contents('newstudent.html'),
// 		),
// 	  array(
// 			'attachment' => array(
// 				array(
// 					'filePath' => '../doctrine/doctrine_documents/doctrine101.pdf',
// 					'remoteName' => 'Doctrine101.pdf'
// 				),
// 				array(
// 					'filePath' => '../doctrine/doctrine_documents/doctrine101_quiz.pdf',
// 					'remoteName' => 'Doctrine101_quiz.pdf'
// 				),
// 				array(
// 					'filePath' => '../ruth/ruth01.pdf',
// 					'remoteName' => 'Ruth01.pdf'
// 				),
// 				array(
// 					'filePath' => '../titus/titus001.pdf',
// 					'remoteName' => 'Titus001.pdf'
// 				),
// 			)
// 	  )
// 	);
// }
//
// $mg->sendMessage($domain, array('from'    => getenv('ORIGIN_EMAIL'),
//                                 'to'      => getenv('DESTINATION_EMAIL'),
//                                 'subject' => getenv('SUBJECT'),
//                                 'text'    => $message ));
//
// header('Location: ' . $redirect);
