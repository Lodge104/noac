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
if (isset($_POST['rank'])) {
  $rank = $_POST['rank'];
} else {
  $rank = "";
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
if (isset($_POST['ecfn'])) {
  $ec_fn = $_POST['ecfn'];
} else {
  $ec_fn = "";
}
if (isset($_POST['ecln'])) {
  $ec_ln = $_POST['ecln'];
} else {
  $ec_ln = "";
}
if (isset($_POST['ecrelationship'])) {
  $ec_relationship = $_POST['ecrelationship'];
} else {
  $ec_relationship = "";
}
if (isset($_POST['ecemail'])) {
  $ec_email = $_POST['ecemail'];
} else {
  $ec_email = "";
}
if (isset($_POST['ecphone'])) {
  $ec_phone = $_POST['ecphone'];
} else {
  $ec_phone = "";
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
  
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.mailersend.com/v1/email');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"from\": {\n        \"email\": \"noac@lodge104.com\"\n    },\n    \"to\": [\n        {\n            \"email\": \"".$email."\"\n        }\n    ],\n  \"bcc\": [\n        {\n            \"email\": \"".$notify."\"\n        }\n    ],\n     \"variables\": [{\n        \"email\": \"".$email."\",\n        \"substitutions\": [\n            {\n                \"var\": \"age\",\n                \"value\": \"".$age."\"\n            },\n            {\n                \"var\": \"dob\",\n                \"value\": \"".$dob."\"\n            },\n            {\n                \"var\": \"zip\",\n                \"value\": \"".$zip."\"\n            },\n            {\n                \"var\": \"city\",\n                \"value\": \"".$city."\"\n            },\n            {\n                \"var\": \"bsaid\",\n                \"value\": \"".$bsa_id."\"\n            },\n            {\n                \"var\": \"level\",\n                \"value\": \"".$level."\"\n            },\n            {\n                \"var\": \"gender\",\n                \"value\": \"".$gender."\"\n            },\n            {\n                \"var\": \"chapter\",\n                \"value\": \"".$chapter."\"\n            },\n            {\n                \"var\": \"poption\",\n                \"value\": \"".$poption."\"\n            },\n            {\n                \"var\": \"street1\",\n                \"value\": \"".$address_line1."\"\n            },\n            {\n                \"var\": \"lastName\",\n                \"value\": \"".$lastName."\"\n            },\n            {\n                \"var\": \"firstName\",\n                \"value\": \"".$firstName."\"\n            }\n        ]\n    }],\n    \"template_id\": \"jy7zpl9pwpg5vx6k\"\n}");

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Authorization: Bearer ' . $mailersend;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$createAdult = $conn->prepare("INSERT INTO participants(bsa_id, oalm_id, firstName, lastName, address_line1, address_line2, city, state, zip, email, hphone, cphone, tshirt, text_agreement, gender, chapter, dob, bsa_rank, level, payment, aia_check, aia, ec_fn, ec_ln, ec_relationship, ec_email, ec_phone, signature, parent, created, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$createAdult->bind_param("sssssssssssssssssssssssssssssss", $bsa_id, $oalmID, $firstName, $lastName, $address_line1, $address_line2, $city, $state, $zip, $email, $hphone, $cphone, $tshirt, $text, $gender, $chapter, $dob, $rank, $level, $payment, $aiacheck, $aia, $ec_fn, $ec_ln, $ec_relationship, $ec_email, $ec_phone, $signature, $parent, $d, $s);
$createAdult->execute();
$createAdult->close();

header("Location: check.php?bsaID=" . $bsa_id . "&status=2");
