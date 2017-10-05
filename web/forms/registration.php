<?php


if (getenv("ENVIRONMENT") !== "production") {
  $dotenv = new Dotenv\Dotenv(__DIR__ . '/../..');
  $dotenv->load();
}

$mg = new Mailgun\Mailgun(getenv('MAILGUN_KEY'));
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

  $client = new GuzzleHttp\Client([
    'base_uri' => 'http://lessonmanager.doulos.iakob.com/',
    'headers'  => [
      'Authorization' => getenv('API_KEY')
    ],
  ]);

  if($isNew) {
    // since the person is new, email course instuctions
    include 'emailNewRegistration.php';

    try {

      $body = [
        "bibleTeaching" => $_REQUEST["bible_teaching"],
        "comments" => $_REQUEST["comments"],
        "collegeDegree" => $_REQUEST["college"],
        "churchName" => $_REQUEST["church_name"],
        "teachingType" => $_REQUEST["teaching"],
        "pastorBackground" => $_REQUEST["pastor_background"],
        "work" => $_REQUEST["work"],
        "averageAttendance" => $_REQUEST["attendance"],
        "address" => $_REQUEST["address"],
        "city" => $_REQUEST["city"],
        "hasHighSchool" => ($_REQUEST["hs"] == "YES" ? true : false),
        "ministryPrepare" => $_REQUEST["ministry_prepare"],
        "testimony" => $_REQUEST["testimony"],
        "email" => $_REQUEST["email"],
        "name" => $_REQUEST["name"]
      ];

      $response = $client->post('registrations', [ 'json' => $body ] );

    } catch (Exception $e) {
      echo $e->getMessage();
      die();
    }
  }

  if($course === "doc100-titus") {
    include 'emailIntro.php';
    try {

      $body = [
        "name" => $_REQUEST["name"],
        "email" => $_REQUEST["email"],
        "course" => "Doctrine 100"
      ];

      $client->post('courserequests', [ 'json' => $body ] );

      $body = [
        "name" => $_REQUEST["name"],
        "email" => $_REQUEST["email"],
        "course" => "Titus"
      ];

      $client->post('courserequests', [ 'json' => $body ] );


    } catch (Exception $e) {
      echo $e->getMessage();
    }
  } else {
    try {

      $body = [
        "name" => $_REQUEST["name"],
        "email" => $_REQUEST["email"],
        "course" => $_REQUEST["course"]
      ];

      $client->post('courserequests', [ 'json' => $body ] );


    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  // register for a specific course...
  //TODO add all the other ones here too that are commented out
  if($course === "Doctrine 100") { include 'emailDoc100.php'; }
  if($course === "Foundations 100") { include 'emailFoundations100.php'; }
  //if($course === "History 100") { include 'emailHistory100.php'; }
  if($course === "Ruth") { include 'emailRuth.php'; }
  if($course === "Titus") { include 'emailTitus.php'; }

  // if($course === "Doctrine 200") { include ''; }
  // if($course === "Ephesians") { include ''; }
  // if($course === "Foundations 200") { include ''; }
  // if($course === "Hosea") { include ''; }
  // if($course === "Mark") { include ''; }

  // if($course === "123John_Philemon_Jude") { include ''; }
  // if($course === "Doctrine 300") { include ''; }
  // if($course === "History 200") { include ''; }
  // if($course === "Luke") { include ''; }
  // if($course === "Romans") { include ''; }

  // if($course === "ACTS100") { include ''; }
  // if($course === "Doctrine 400") { include ''; }
  // if($course === "History 300") { include ''; }
  // if($course === "Joel_Jonah_Malachi") { include ''; }
  // if($course === "Life of Christ 100") { include ''; }

  // if($course === "1 Peter") { include ''; }
  // if($course === "Ecclesiastes") { include ''; }
  // if($course === "History 400") { include ''; }
  // if($course === "Life of Christ 200") { include ''; }
  // if($course === "Paul 100") { include ''; }
  // if($course === "Philippians") { include ''; }

  // if($course === "1 Peter") { include ''; }
  // if($course === "ACTS 200") { include ''; }
  // if($course === "Daniel") { include ''; }
  // if($course === "Esther") { include ''; }
  // if($course === "History 500") { include ''; }
  // if($course === "Paul 200") { include ''; }

  // if($course === "ACTS 300") { include ''; }
  // if($course === "Colossians") { include ''; }
  // if($course === "Genesis 100") { include ''; }
  // if($course === "History 600") { include ''; }
  // if($course === "John") { include ''; }
  // if($course === "Paul 300") { include ''; }

  // if($course === "1-2 Thessalonians") { include ''; }
  // if($course === "Exodus") { include ''; }
  // if($course === "Galations") { include ''; }
  // if($course === "Genesis 200") { include ''; }
  // if($course === "History 700") { include ''; }
  // if($course === "James") { include ''; }

  // if($course === "Leviticus") { include ''; }

  // emails the form to warren notifying a user's form submission
  $mg->sendMessage($domain, array('from'    => getenv('ORIGIN_EMAIL'),
    'to'      => getenv('DESTINATION_EMAIL'),
    'subject' => getenv('SUBJECT'),
    'text'    => $message ));

  ob_clean();
  header('Location: ' . $redirect);
  exit;
}
