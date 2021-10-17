<?php
include '../unitelections-info.php';
require '../vendor/autoload.php';


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['bsaID'])) {
    $bsaID = $_POST['bsaID'] = $_GET['bsaID'];

    $getbsaIDQuery = $conn->prepare("SELECT * from applications where bsa_id = ?");
    $getbsaIDQuery->bind_param("s", $bsaID);
    $getbsaIDQuery->execute();
    $getbsaIDQ = $getbsaIDQuery->get_result();
    if ($getbsaIDQ->num_rows > 0) {
    header("Location: index.php?bsaID=" . $bsaID);
    } else {
        $url = ("https://registration-test.lodge104.net/api/members/" . $bsaID);

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json",
   ("Authorization: Bearer ". $bearer),
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
        echo 'Unexpected HTTP code: ', $http_code, "\n";
    }
  }
curl_close($curl);
var_dump($resp);




        //header("Location: application.php?bsaID=" . $bsaID);
    }}
?>