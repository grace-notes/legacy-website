<?php
$result = $mg->sendMessage($domain, array(
    'from'    		=> getenv('ORIGIN_EMAIL'),
    'to'      		=> $email,
    'subject' 		=> 'Titus 1',
    'text'    		=> file_get_contents(__DIR__.'/../titus/TITUS001.email.txt'),
    'html'    		=> file_get_contents(__DIR__.'/../titus/TITUS001.email.html'),
  ),
  array(
    'attachment' => array(
      array(
        'filePath' => __DIR__.'/../titus/titus001.pdf',
        'remoteName' => 'Titus01.pdf'
      ),
    )
  )
);
?>
