<?php
$result = $mg->sendMessage($domain, array(
    'from'    		=> getenv('ORIGIN_EMAIL'),
    'to'      		=> $email,
    'subject' 		=> 'Ruth 1',
    'text'    		=> file_get_contents(__DIR__.'/../ruth/RUTH001.email.txt'),
    'html'    		=> file_get_contents(__DIR__.'/../ruth/RUTH001.email.html'),
  ),
  array(
    'attachment' => array(
      array(
        'filePath' => __DIR__.'/../ruth/ruth01.pdf',
        'remoteName' => 'Ruth01.pdf'
      ),
    )
  )
);
?>
