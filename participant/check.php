<?php
include '../unitelections-info.php';
require '../vendor/autoload.php';

session_start();
if (!isset($_SESSION['count'])) {
  $_SESSION['count'] = 0;
} else {
  $_SESSION['count']++;
}


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['bsaID'])) {
  $bsaID = $_POST['bsaID'] = $_GET['bsaID'];
  if (isset($_GET['status'])) {
    $status = $_POST['status'] = $_GET['status'];
  } else {
    $status = "1";
  }

  $getbsaIDQuery = $conn->prepare("SELECT * from participants where bsa_id = ?");
  $getbsaIDQuery->bind_param("s", $bsaID);
  $getbsaIDQuery->execute();
  $getbsaIDQ = $getbsaIDQuery->get_result();
  $getApplicant = $getbsaIDQ->fetch_assoc();
  if ($getbsaIDQ->num_rows > 0) {

    $url = ($transactionURL . $bsaID);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
      "Accept: application/json",
      ("Authorization: Bearer " . $bearer),
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    if (!curl_errno($curl)) {
      switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
        case 200:  # OK
          break;
        default:
      }
    }
    curl_close($curl);

    $json = json_decode($resp, true);
    $_SESSION['transactions'] = $json;
    if ($getApplicant['ec_fn'] == null || $getApplicant['bsa_rank'] == null) {
      header("Location: update.php?bsaID=" . $bsaID);
    } else {
      header("Location: index.php?bsaID=" . $bsaID . "&status=" . $status);
    }
  } else {
    $url = ($membersURL . $bsaID);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
      "Accept: application/json",
      ("Authorization: Bearer " . $bearer),
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    if (!curl_errno($curl)) {
      switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
        case 200:  # OK
          header("Location: application.php?bsaID=" . $bsaID);
          break;
        default:
          header("Location: index.php?status=4");
      }
    }
    curl_close($curl);
    $json = json_decode($resp, true);

    $_SESSION['jsonData'] = $json;
  }
}
