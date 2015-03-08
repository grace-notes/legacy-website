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
$course = '';

$errors = array();
if(!empty($_REQUEST['g-recaptcha-response'])) {
	$args = array('secret' => getenv('RECAPTCHA_SECRET_KEY'),
								'response' => $_REQUEST['g-recaptcha-response'],
								'remoteip' => $_SERVER['REMOTE_ADDR']);
	$result = file_get_contents('https://www.google.com/recaptcha/api/siteverify?'.http_build_query($args));
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

if(!empty($errors)) {

  foreach ($errors as $error) {
    print '<div class="alert alert-danger">' . $error . '</div>';
  }

} else {

  foreach ($_REQUEST as $key => $value) {
    if ($key === "_redirect") {
      $redirect = $value;
      continue;
    }
    if ($key === "g-recaptcha-response") {
      continue;
    }
    if($key === "email") {
      $email = $value;
    }
    if($key === "first" and $value === "yes") {
      $isNew = true;
    }
		if($key === "course") {
			$course = $value;
		}
    $message .= $key . ": " . $value . "\n\r";
  }

  if($isNew) {
		// since the person is new, email titus doc100 and course instuctions
		include 'emailNewRegistration.php';
  } else {
		// register for specific course
		if($course === "doc100-titus") {
			include 'emailIntro.php';
		}
		if($course === "Ruth") {
			include 'emailRuth.php';
		}
	}

	// emails the form to warren notifying a user's form submission
	$mg->sendMessage($domain, array('from'    => getenv('ORIGIN_EMAIL'),
																	'to'      => getenv('DESTINATION_EMAIL'),
																	'subject' => getenv('SUBJECT'),
																	'text'    => $message ));

	ob_clean();
  header('Location: ' . $redirect);
	exit;
}
