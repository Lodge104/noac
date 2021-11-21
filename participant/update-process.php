<?php
include '../unitelections-info.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['bsaID'])) { $bsaID = $_POST['bsaID']; } else { die("No BSAID id."); }
if (isset($_POST['rank'])) {  $rank = $_POST['rank']; } else { $rank = ""; }
if (isset($_POST['ecfn'])) {  $ecfn = $_POST['ecfn']; } else { $ecfn = ""; }
if (isset($_POST['ecln'])) {  $ecln = $_POST['ecln']; } else { $ecln = ""; }
if (isset($_POST['ecrelationship'])) {  $ecrelationship = $_POST['ecrelationship']; } else { $ecrelationship = ""; }
if (isset($_POST['ecemail'])) {  $ecemail = $_POST['ecemail']; } else { $ecemail = ""; }
if (isset($_POST['ecphone'])) {  $ecphone = $_POST['ecphone']; } else { $ecphone = ""; }


$updateElection = $conn->prepare("UPDATE participants SET bsa_rank=?,ec_fn=?,ec_ln=?,ec_relationship=?,ec_email=?,ec_phone=? WHERE bsa_id = ?");
$updateElection->bind_param("sssssss", $$rank, $ecfn, $ecln, $ecrelationship, $ecemail, $ecphone, $bsaID);
$updateElection->execute();
$updateElection->close();


header("Location: check.php?bsaID=" . $bsaID);

?>
