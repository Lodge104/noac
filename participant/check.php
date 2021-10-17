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
    header("Location: index.php?bsaID" . $bsaID);
    } else {
        header("Location: application.php?bsaID" . $bsaID);
    }} else{
        header("Location: index.php?status=3");
    }
?>