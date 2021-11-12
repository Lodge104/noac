<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include 'unitelections-info.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['BSAID'])) { $bsa_id = $_POST['BSAID']; } else { die("No BSAID id."); }
if (isset($_POST['Option'])) { $option = $_POST['Option']; } else { die("No Option."); }


$updateParticipant = $conn->prepare("UPDATE participants SET status=? WHERE bsa_id = ?");
$updateParticipant->bind_param("ss", $option, $bsa_id);
$updateParticipant->execute();
$updateParticipant->close();

$getUnitElectionsQuery = $conn->prepare("SELECT * from participants where bsa_id = ?");
$getUnitElectionsQuery->bind_param("s", $bsa_id);
$getUnitElectionsQuery->execute();
$getUnitElectionsQ = $getUnitElectionsQuery->get_result();
if ($getUnitElectionsQ->num_rows > 0) {
$getUnitElections = $getUnitElectionsQ->fetch_assoc();

if ($option == '1' && $getUnitElections['payment'] == '2') {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.mailersend.com/v1/email');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"from\": {\n        \"email\": \"noac@lodge104.com\"\n    },\n    \"to\": [\n        {\n            \"email\": \"".$getUnitElections['email']."\"\n        }\n    ],\n    \"variables\": [{\n        \"email\": \"".$getUnitElections['email']."\",\n        \"substitutions\": [\n            {\n                \"var\": \"bsaid\",\n                \"value\": \"".$getUnitElections['bsa_id']."\"\n            },\n            {\n                \"var\": \"lastName\",\n                \"value\": \"".$getUnitElections['lastName']."\"\n            },\n            {\n                \"var\": \"firstName\",\n                \"value\": \"".$getUnitElections['firstName']."\"\n            }\n        ]\n    }],\n    \"template_id\": \"z3m5jgrj3d4dpyo6\"\n}");
    
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
}

elseif ($option == '1' && $getUnitElections['payment'] == '1'){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.mailersend.com/v1/email');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"from\": {\n        \"email\": \"noac@lodge104.com\"\n    },\n    \"to\": [\n        {\n            \"email\": \"".$getUnitElections['email']."\"\n        }\n    ],\n    \"variables\": [{\n        \"email\": \"".$getUnitElections['email']."\",\n        \"substitutions\": [\n            {\n                \"var\": \"bsaid\",\n                \"value\": \"".$getUnitElections['bsa_id']."\"\n            },\n            {\n                \"var\": \"lastName\",\n                \"value\": \"".$getUnitElections['lastName']."\"\n            },\n            {\n                \"var\": \"firstName\",\n                \"value\": \"".$getUnitElections['firstName']."\"\n            }\n        ]\n    }],\n    \"template_id\": \"351ndgwdjnlzqx8k\"\n}");
    
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

}

elseif ($option == '2') {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.mailersend.com/v1/email');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"from\": {\n        \"email\": \"noac@lodge104.com\"\n    },\n    \"to\": [\n        {\n            \"email\": \"".$getUnitElections['email']."\"\n        }\n    ],\n    \"variables\": [{\n        \"email\": \"".$getUnitElections['email']."\",\n        \"substitutions\": [\n            {\n                \"var\": \"bsaid\",\n                \"value\": \"".$getUnitElections['bsa_id']."\"\n            },\n            {\n                \"var\": \"lastName\",\n                \"value\": \"".$getUnitElections['lastName']."\"\n            },\n            {\n                \"var\": \"firstName\",\n                \"value\": \"".$getUnitElections['firstName']."\"\n            }\n        ]\n    }],\n    \"template_id\": \"pq3enl6p57g2vwrz\"\n}");
    
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
}
elseif ($option == '3') {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.mailersend.com/v1/email');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"from\": {\n        \"email\": \"noac@lodge104.com\"\n    },\n    \"to\": [\n        {\n            \"email\": \"".$getUnitElections['email']."\"\n        }\n    ],\n    \"variables\": [{\n        \"email\": \"".$getUnitElections['email']."\",\n        \"substitutions\": [\n            {\n                \"var\": \"bsaid\",\n                \"value\": \"".$getUnitElections['bsa_id']."\"\n            },\n            {\n                \"var\": \"lastName\",\n                \"value\": \"".$getUnitElections['lastName']."\"\n            },\n            {\n                \"var\": \"firstName\",\n                \"value\": \"".$getUnitElections['firstName']."\"\n            }\n        ]\n    }],\n    \"template_id\": \"3zxk54vo91gjy6v7\"\n}");
    
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
}
}

header("Location: index.php?status=1");

?>