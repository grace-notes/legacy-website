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

if($isNew) {
	$result = $mg->sendMessage($domain, array(
			'from'    		=> getenv('ORIGIN_EMAIL'), 
	    'to'      		=> $email, 
	    'subject' 		=> getenv('SUBJECT'), 
	    'text'    		=> file_get_contents('newstudent.txt'),
			'html'    		=> file_get_contents('newstudent.html'),
		),
	  array(
			'attachment' => array(
				array(
					'filePath' => '../doctrine/doctrine_documents/doctrine101.pdf',
					'remoteName' => 'Doctrine101.pdf'
				),	
				array(
					'filePath' => '../doctrine/doctrine_documents/doctrine101_quiz.pdf',
					'remoteName' => 'Doctrine101_quiz.pdf'
				),	
				array(
					'filePath' => '../ruth/ruth01.pdf',
					'remoteName' => 'Ruth01.pdf'
				),	
				array(
					'filePath' => '../titus/titus001.pdf',
					'remoteName' => 'Titus001.pdf'
				),				
			)
	  )
	);
}

$mg->sendMessage($domain, array('from'    => getenv('ORIGIN_EMAIL'), 
                                'to'      => getenv('DESTINATION_EMAIL'), 
                                'subject' => getenv('SUBJECT'), 
                                'text'    => $message ));

header('Location: ' . $redirect);
