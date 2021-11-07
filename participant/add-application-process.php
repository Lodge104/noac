<?php
include '../unitelections-info.php';

require '../vendor/autoload.php';

date_default_timezone_set("America/New_York");


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


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

// $mailersend = new MailerSend(['api_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYWRiOTEyNGQ2NWE0Zjk1YjNmMTljOTQ2YTNkNjNlZmZlZDcyNDg1ZDg0YjU1OWY3NDBlMzU1ZGQzNzZkODU3ZjkxZjZmMWYxNzFhYzZjYjkiLCJpYXQiOjE2MzYzMTkyMTcuODc5NjY2LCJuYmYiOjE2MzYzMTkyMTcuODc5NjcsImV4cCI6NDc5MTk5MjgxNy44MjY1NjcsInN1YiI6IjE1MjYyIiwic2NvcGVzIjpbImVtYWlsX2Z1bGwiXX0.QRmCze0blgfVdpc__Oti7GZoR5GdNLVF41z3LXGAeL_6OZ_eNTLQdKXS6aP4D0GOqJnJRRTOPRBiLAviD6v5TYceoCaZkvQV1SLSKnrN8pEe-8aiATj5w4dqnNqyPMsm7lRaQ5adBKfytl8RxvXo2Vc9y-5ZjzzXqtIrfT-KsCQ1wOqPdl8Axi8l5aAQ2mOLWRe0ZoqvvW9nb4aMld25jHMmV3PlQXq6LeI9Wd_eZyMQMfBRnQPltOHxRaT_6T14RjUix7tuiKtwsowlWyPEMKJ-dCBGrotfJx_bjgHvs_LfMctqx6HLQR4sidO_QM2kAcQVopOYbbQAlRRbA0rzIrV0sdhYwZ9l9RIQFs-XNOZoq5OO558peh3JWnc1wwSz_Gr3IJJKP6yvrUrb_JTmmOOUY8P8SgOTgfYdvI-aqZhGnnYTPPRI4bX6_FoH7nEplyNQ770PizgLGgz4iLDKjCQTx9CKILrNU1JHpF7eXLZMR_oCS4HE8YWVShS688jDs2kNyitk6ct47VGC6tUUuEyJGOcnbZSUqtGwFBTaUk5tnelLy-DfuCMCN-AJhMrWuEZD4ILh0jR0Mo34Fd2zbrbG5ETZSPz4DFhdyEhWBgEGfq3l0djoQv6MAwjeVTp_tQAoSVpxoaiuz9BqkjA4vQOUnzz6nwJXzQsoRaKHtow']);

// $variables = [
//     new Variable('nickanderson1998@gmail.com', [
//         'age' => '34',
//         'dob' => 'DOB',
//         'zip' => 'ZIP',
//         'city' => 'CITY',
//         'bsaid' => 'BSAID',
//         'level' => 'LEVEL',
//         'gender' => 'GENDER',
//         'chapter' => 'CHAPTER',
//         'poption' => 'POPTION',
//         'street1' => 'STREET1',
//         'street2' => 'STREET2',
//         'lastName' => 'LASTNAME',
//         'firstName' => 'FIRSTNAME'
//     ])
// ];

// $recipients = [
//     new Recipient('nickanderson1998@gmail.com', 'Nicholas Anderson'),
// ];

// $emailParams = (new EmailParams())
//     ->setFrom('noac@lodge104.net')
//     ->setFromName('Occoneechee Lodge NOAC Leadership')
//     ->setRecipients($recipients)
//     ->setSubject('NOAC Application')
//     ->setTemplateId('jy7zpl9pwpg5vx6k')
//     ->setVariables($variables);

//     try{
//       $mailersend->email->send($emailParams);
//   } catch(MailerSendValidationException $e){
//       // See src/Exceptions/MailerSendValidationException.php for more more info
//       print_r($e->getResponse()->getBody()->getContents());
//   }


  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, 'https://api.mailersend.com/v1/email');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"from\": {\n        \"email\": \"noac@lodge104.com\"\n    },\n    \"to\": [\n        {\n            \"email\": \"nickanderson1998@gmail.com\"\n        }\n    ],\n    \"variables\": [{\n        \"email\": \"nickanderson1998@gmail.com\",\n        \"substitutions\": [\n            {\n                \"var\": \"age\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"dob\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"zip\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"city\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"bsaid\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"level\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"gender\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"chapter\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"poption\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"street1\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"street2\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"lastName\",\n                \"value\": \"\"\n            },\n            {\n                \"var\": \"firstName\",\n                \"value\": \"\"\n            }\n        ]\n    }],\n    \"template_id\": \"jy7zpl9pwpg5vx6k\"\n}");
  
  $headers = array();
  $headers[] = 'Content-Type: application/json';
  $headers[] = 'X-Requested-With: XMLHttpRequest';
  $headers[] = 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYWRiOTEyNGQ2NWE0Zjk1YjNmMTljOTQ2YTNkNjNlZmZlZDcyNDg1ZDg0YjU1OWY3NDBlMzU1ZGQzNzZkODU3ZjkxZjZmMWYxNzFhYzZjYjkiLCJpYXQiOjE2MzYzMTkyMTcuODc5NjY2LCJuYmYiOjE2MzYzMTkyMTcuODc5NjcsImV4cCI6NDc5MTk5MjgxNy44MjY1NjcsInN1YiI6IjE1MjYyIiwic2NvcGVzIjpbImVtYWlsX2Z1bGwiXX0.QRmCze0blgfVdpc__Oti7GZoR5GdNLVF41z3LXGAeL_6OZ_eNTLQdKXS6aP4D0GOqJnJRRTOPRBiLAviD6v5TYceoCaZkvQV1SLSKnrN8pEe-8aiATj5w4dqnNqyPMsm7lRaQ5adBKfytl8RxvXo2Vc9y-5ZjzzXqtIrfT-KsCQ1wOqPdl8Axi8l5aAQ2mOLWRe0ZoqvvW9nb4aMld25jHMmV3PlQXq6LeI9Wd_eZyMQMfBRnQPltOHxRaT_6T14RjUix7tuiKtwsowlWyPEMKJ-dCBGrotfJx_bjgHvs_LfMctqx6HLQR4sidO_QM2kAcQVopOYbbQAlRRbA0rzIrV0sdhYwZ9l9RIQFs-XNOZoq5OO558peh3JWnc1wwSz_Gr3IJJKP6yvrUrb_JTmmOOUY8P8SgOTgfYdvI-aqZhGnnYTPPRI4bX6_FoH7nEplyNQ770PizgLGgz4iLDKjCQTx9CKILrNU1JHpF7eXLZMR_oCS4HE8YWVShS688jDs2kNyitk6ct47VGC6tUUuEyJGOcnbZSUqtGwFBTaUk5tnelLy-DfuCMCN-AJhMrWuEZD4ILh0jR0Mo34Fd2zbrbG5ETZSPz4DFhdyEhWBgEGfq3l0djoQv6MAwjeVTp_tQAoSVpxoaiuz9BqkjA4vQOUnzz6nwJXzQsoRaKHtow';
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
  $result = curl_exec($ch);
  if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
  }
  curl_close($ch);

$createAdult = $conn->prepare("INSERT INTO participants(bsa_id, oalm_id, firstName, lastName, address_line1, address_line2, city, state, zip, email, hphone, cphone, tshirt, text_agreement, gender, chapter, dob, level, payment, aia_check, aia, signature, parent, created, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$createAdult->bind_param("sssssssssssssssssssssssss", $bsa_id, $oalmID, $firstName, $lastName, $address_line1, $address_line2, $city, $state, $zip, $email, $hphone, $cphone, $tshirt, $text, $gender, $chapter, $dob, $level, $payment, $aiacheck, $aia, $signature, $parent, $d, $s);
$createAdult->execute();
$createAdult->close();

header("Location: check.php?bsaID=" . $bsa_id . "&status=2");
