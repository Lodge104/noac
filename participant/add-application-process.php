<?php
include '../unitelections-info.php';

require __DIR__ . '../vendor/autoload.php';

date_default_timezone_set("America/New_York");


// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }


if (isset($_POST['bsa_id'])) {
  $bsa_id = $_POST['bsa_id'];
} else {
  die("No BSA id.");
}
if (isset($_POST['oalm_id'])) {
  $oalmID = $_POST['oalm_id'];
} else {
  die("No OALM id.");
}
if (isset($_POST['firstName'])) {
  $firstName = $_POST['firstName'];
} else {
  $firstName = "";
}
if (isset($_POST['lastName'])) {
  $lastName = $_POST['lastName'];
} else {
  $lastName = "";
}
if (isset($_POST['address_line1'])) {
  $address_line1 = $_POST['address_line1'];
} else {
  $address_line1 = "";
}
if (isset($_POST['address_line2'])) {
  $address_line2 = $_POST['address_line2'];
} else {
  $address_line2 = "";
}
if (isset($_POST['city'])) {
  $city = $_POST['city'];
} else {
  $city = "";
}
if (isset($_POST['state'])) {
  $state = $_POST['state'];
} else {
  $state = "";
}
if (isset($_POST['zip'])) {
  $zip = $_POST['zip'];
} else {
  $zip = "";
}
if (isset($_POST['email'])) {
  $email = $_POST['email'];
} else {
  $email = "";
}
if (isset($_POST['hphone'])) {
  $hphone = $_POST['hphone'];
} else {
  $hphone = "";
}
if (isset($_POST['cphone'])) {
  $cphone = $_POST['cphone'];
} else {
  $cphone = "";
}
if (isset($_POST['tshirt'])) {
  $tshirt = $_POST['tshirt'];
} else {
  $tshirt = "";
}
if (isset($_POST['text_agreement'])) {
  $text = $_POST['text_agreement'];
} else {
  $text = "";
}
if (isset($_POST['gender'])) {
  $gender = $_POST['gender'];
} else {
  $gender = "";
}
if (isset($_POST['chapter'])) {
  $chapter = $_POST['chapter'];
} else {
  $chapter = "";
}
if (isset($_POST['dob'])) {
  $dob = $_POST['dob'];
} else {
  $dob = "";
}
if (isset($_POST['level'])) {
  $level = $_POST['level'];
} else {
  $level = "";
}
if (isset($_POST['payment'])) {
  $payment = $_POST['payment'];
} else {
  $payment = "";
}
if (isset($_POST['aia_check'])) {
  $aiacheck = $_POST['aia_check'];
} else {
  $aiacheck = "";
}
if (isset($_POST['aia'])) {
  $aia = $_POST['aia'];
} else {
  $aia = "";
}
if (isset($_POST['signature'])) {
  $signature = $_POST['signature'];
} else {
  $signature = "";
}
if (isset($_POST['parent'])) {
  $parent = $_POST['parent'];
} else {
  $parent = "";
}

$d = date("m-d-Y h:i:sa");
$s = "0";


// $createAdult = $conn->prepare("INSERT INTO participants(bsa_id, oalm_id, firstName, lastName, address_line1, address_line2, city, state, zip, email, hphone, cphone, tshirt, text_agreement, gender, chapter, dob, level, payment, aia_check, aia, signature, parent, created, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
// $createAdult->bind_param("sssssssssssssssssssssssss", $bsa_id, $oalmID, $firstName, $lastName, $address_line1, $address_line2, $city, $state, $zip, $email, $hphone, $cphone, $tshirt, $text, $gender, $chapter, $dob, $level, $payment, $aiacheck, $aia, $signature, $parent, $d, $s);
// $createAdult->execute();
// $createAdult->close();

if ($payment == '1') {
  $poption = 'Option 1';
} else {
  $poption = 'Option 2';
}

//explode the date to get month, day and year
$birthDate = explode("-", $dob);
//get age from date or birthdate
$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
  ? ((date("Y") - $birthDate[2]) - 1)
  : (date("Y") - $birthDate[2]));

  include '../unitelections-info.php';

  require __DIR__ . '../vendor/autoload.php';


use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Variable;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;

$mailersend = new MailerSend(['api_key' => getenv('MAILERSEND')]);

$variables = [
  new Variable($email, [
    'age' => $age,
    'dob' => $dob,
    'zip' => $zip,
    'city' => $city,
    'bsaid' => $bsa_id,
    'level' => $level,
    'gender' => $gender,
    'chapter' => $chapter,
    'poption' => $poption,
    'street1' => $address_line1,
    'street2' => $address_line2,
    'lastName' => $lastName,
    'firstName' => $firstName
  ])
];

$recipients = [
  new Recipient($email, 'Nicholas Anderson'),
];

$emailParams = (new EmailParams())
->setFrom('noac@lodge104.com')
->setFromName('Occoneechee Lodge NOAC Leadership')
->setRecipients($recipients)
->setSubject('NOAC Application')
  ->setTemplateId('jy7zpl9pwpg5vx6k')
  ->setVariables($variables);

$mailersend->email->send($emailParams);

header("Location: check.php?bsaID=" . $bsa_id . "&status=2");
