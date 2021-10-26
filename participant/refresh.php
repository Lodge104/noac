<?php
include '../unitelections-info.php';

session_start();
if (!isset($_SESSION['count'])) {
  $_SESSION['count'] = 0;
} else {
  $_SESSION['count']++;
}

if (isset($_GET['bsaID'])) {
    $bsaID = $_POST['bsaID'] = $_GET['bsaID'];

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

header("Location: index.php?bsaID=" . $bsaID);
}