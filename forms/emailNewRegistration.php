<?php

// Course Instructions
$result = $mg->sendMessage($domain, array(
    'from'    		=> getenv('ORIGIN_EMAIL'),
    'to'      		=> $email,
    'subject' 		=> 'Course Instructions',
    'text'    		=> file_get_contents(__DIR__.'/../course_instructions/course_instructions.email.txt'),
    'html'    		=> file_get_contents(__DIR__.'/../course_instructions/course_instructions.email.html'),
  )
);

// Doctine 101
$result = $mg->sendMessage($domain, array(
    'from'    		=> getenv('ORIGIN_EMAIL'),
    'to'      		=> $email,
    'subject' 		=> 'Doctrine 101',
    'text'    		=> file_get_contents(__DIR__.'/../doctrine/DOC101.email.txt'),
    'html'    		=> file_get_contents(__DIR__.'/../doctrine/DOC101.email.html'),
  ),
  array(
    'attachment' => array(
      array(
        'filePath' => __DIR__.'/../doctrine/doctrine_documents/doctrine101.pdf',
        'remoteName' => 'Doctrine101.pdf'
      ),
      array(
        'filePath' => __DIR__.'/../doctrine/doctrine_documents/doctrine101_quiz.pdf',
        'remoteName' => 'Doctrine101_quiz.pdf'
      ),
    )
  )
);

// Titus 1
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
