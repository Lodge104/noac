<?php
include '../unitelections-info.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['bsa_id'])) {  $bsa_id = $_POST['bsa_id']; } else { die("No BSA id."); }
if (isset($_POST['oalm_id'])) { $oalmID = $_POST['oalm_id']; } else { die("No OALM id."); }
if (isset($_POST['firstName'])) {  $firstName = $_POST['firstName']; } else { die("No FN"); }
if (isset($_POST['lastName'])) {  $lastName = $_POST['lastName']; } else { die("No LN"); }
if (isset($_POST['address_line1'])) {  $address_line1 = $_POST['address_line1']; } else { die("No A1"); }
if (isset($_POST['address_line2'])) {  $address_line2 = $_POST['address_line2']; } else { die("No A2"); }
if (isset($_POST['city'])) {  $city = $_POST['city']; } else { die("No City"); }
if (isset($_POST['state'])) {  $state = $_POST['state']; } else { die("No State"); }
if (isset($_POST['zip'])) {  $zip = $_POST['zip']; } else { die("No Zip"); }
if (isset($_POST['email'])) {  $email = $_POST['email']; } else { die("No Email"); }
if (isset($_POST['hphone'])) {  $hphone = $_POST['hphone']; } else { die("No hp"); }
if (isset($_POST['cphone'])) {  $cphone = $_POST['cphone']; } else { die("No cp"); }
if (isset($_POST['tshirt'])) {  $tshirt = $_POST['tshirt']; } else { die("No ts"); }
//if (isset($_POST['text_agreement'])) {  $text = "1"; } else { $text = "0"; }
if (isset($_POST['gender'])) {  $gender = $_POST['gender']; } else { die("No Gender"); }
if (isset($_POST['chapter'])) {  $chapter = $_POST['chapter']; } else { die("No Chapter"); }
if (isset($_POST['dob'])) {  $dob = $_POST['dob']; } else { die("No dob"); }
if (isset($_POST['level'])) {  $level = $_POST['level']; } else { die("No level"); }
//if (isset($_POST['aia_check'])) {  $aiacheck = "1"; } else { $aiacheck = "0"; }
if (isset($_POST['aia'])) {  $aia = $_POST['aia']; } else { die("No aia"); }
if (isset($_POST['signature'])) {  $signature = $_POST['signature']; } else { die("No sig"); }
if (isset($_POST['parent'])) {  $parent = $_POST['parent']; } else { die("No parent"); }


$createAdult = $conn->prepare("INSERT INTO participants(bsa_id, oalm_id firstName, lastName, address_line1, address_line2, city, st, zip, email, hphone, cphone, tshirt, gender, chapter, dob, aia, sr, parent) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$createAdult->bind_param("ssssssssssssssssssss", $bsa_id, $oalmID, $firstName, $lastName, $address_line1, $address_line2, $city, $state, $zip, $email, $hphone, $cphone, $tshirt, $gender, $chapter, $dob, $level, $aia, $signature, $parent);
$createAdult->execute();
$createAdult->close();


/*
$parent = "";

include '../unitelections-info.php';
$mail = new PHPMailer(true);
  $mail->IsSMTP();        //Sets Mailer to send message using SMTP
  $mail->Host = $host;  //Sets the SMTP hosts
  $mail->Port = $port;        //Sets the default SMTP server port
  $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
  $mail->Username = $musername;     //Sets SMTP username
  $mail->Password = $mpassword;     //Sets SMTP password
  $mail->SMTPSecure = 'tls';       //Sets connection prefix. Options are "", "ssl" or "tls"
  $mail->From = $mfrom;     //Sets the From email address for the message
  $mail->FromName = $mfromname;    //Sets the From name of the message
  $mail->AddAddress($uc_email);//Adds a "To" address
  $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
  $mail->IsHTML(true);       //Sets message type to HTML    
  $mail->Subject = 'Please review OA Adult Nomination for ' . $firstName . ' ' . $lastName;    //Sets the Subject of the message
  $mail->Body = '<table cellspacing="0" cellpadding="0" border="0" width="600px" style="margin:auto">
  <tbody>
    <tr>
      <td style="text-align:center;padding:10px 0 20px 0"><a href="%%7Brecipient.ticket_link%7D" target="_blank"> <img src="https://lodge104.net/wp-content/uploads/2018/09/Horizontal-Brand-Color.png" alt="Occonechee Lodge Support" width="419" height="69" data-image="xoo68adcoon5"></a></td>
    </tr>
    <tr>
      <td><table cellspacing="0" cellpadding="0" border="0" width="100%">
          <tbody>
            <tr>
              <td style="text-align:center;color:#ffffff;background-color:#2d3e4f;padding:8px 0;font-size:13px"> Occoneechee Lodge Unit Elections </td>
            </tr>
            <tr>
              <td style="text-align:left;border:1px solid #2d3e4f;padding:10px 30px;background-color:#fefefe;line-height:18px;color:#2d3e4f;font-size:13px"> 
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tbody>
                    <tr>
                      <td style="padding:15px 0; width:100%"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed">
                          <tbody>
                            <tr>
                              <td style="width:100%" valign="top">
                                <br>
                                Dear '.$uc_name.',<br>
                                <br>
                                The unit leader, from '.$unitCommunity.' '.$unitNumber.' has submitted an Adult Nomination for consideration of candidacy in the Order of the Arrow. This nomination is for '.$firstName.' '.$lastName.'. Before the nomination can be reviewed by the Lodge Selection Committee it must be independently reviewed and approved by the Unit Chair. Please click the link below to access the Unit Chair dashboard for your unit and review the nomination.<br>
                                <br>
								Additional nominations may be submitted and will be viewable on the same link.
								</td>
                            </tr>
                          </tbody>
                          <tbody>
                            <tr>
                              <td style="width:100%;text-align:center">
							  <a href="https://nominate.lodge104.net/unitchair/?accessKey=' . $accessKey . '" target="_blank">
							  <p>https://nominate.lodge104.net/unitchair/?accessKey=' . $accessKey . '</p>
							  </a>
							  </td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>';   //An HTML or plain text message body
  if($mail->Send())        //Send an Email. Return true on success or false on error

*/
header("Location: index.php?accessKey=" . $accessKey . "&status=2");

?>