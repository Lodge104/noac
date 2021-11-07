<?php

require 'vendor/autoload.php';

use Auth0\SDK\Auth0;
use Twilio\Rest\Client;
use MailerSend\MailerSend;

$servername = getenv('SERVERNAME');
$username = getenv('DBUSERNAME');
$password = getenv('DBPASSWORD');
$dbname = getenv('DBNAME');
$bearer = getenv('BEARER');
$host = getenv('SMTPHOST');
$port = getenv('SMTPPORT');
$musername = getenv('SMTPUSERNAME');
$mpassword = getenv('SMTPPASSWORD');
$mfrom = getenv('SMTPFROM');
$mfromname = getenv('SMTPFROMNAME');
$notify = getenv('NOTIFY');
$sidp = getenv('TWILIOID');
$tokenp = getenv('TWILIOTOKEN');
$transactionURL = getenv('TRANSACTIONURL');
$membersURL = getenv('MEMBERSURL');
$mailersend = new MailerSend(['api_key' => getenv('MAILERSEND')]);
$auth0 = new Auth0([
    'domain' => getenv('AUTH0DOMAIN'),
    'client_id' => getenv('AUTH0CLIENTID'),
    'client_secret' => getenv('AUTH0CLIENTSECRET'),
    'redirect_uri' => "https://" . $_SERVER['HTTP_HOST'],
    'scope' => 'openid profile email',
  ]);

?>