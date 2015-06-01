<?php
$result = $mg->sendMessage($domain, array(
    'from'    		=> getenv('ORIGIN_EMAIL'),
    'to'      		=> $email,
    'subject' 		=> 'FDN101: Foundations 100, Lesson 1',
    'text'    		=> file_get_contents(__DIR__.'/../foundations/foundation101.email.txt'),
    'html'    		=> file_get_contents(__DIR__.'/../foundations/foundation101.email.html'),
  ),
  array(
    'attachment' => array(
      array(
        'filePath' => __DIR__.'/../foundations/foundations_documents/fdn101.pdf',
        'remoteName' => 'FDN101.pdf'
      ),
      array(
        'filePath' => __DIR__.'/../foundations/foundations_documents/fdn101_quiz.pdf',
        'remoteName' => 'FDN101_quiz.pdf'
      ),
    )
  )
);
?>
