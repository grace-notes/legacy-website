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

?>
