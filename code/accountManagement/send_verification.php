<?php
session_start();

$myphonenumber = $_GET['phonenumber'];
$firstname = $_GET['myfirstname'];
echo $myphonenumber;
echo $firstname;

?>
<html>
<head>
</head>

<body>
<p>Send Verification Code</p>
<?php

$randomPassword = rand(1000, 90000);
echo $randomPassword;
$_SESSION['random'] = $randomPassword;

/* Send an SMS using Twilio. You can run this file 3 different ways:
     *
     * - Save it as sendnotifications.php and at the command line, run 
     *        php sendnotifications.php
     *
     * - Upload it to a web host and load mywebhost.com/sendnotifications.php 
     *   in a web browser.
     * - Download a local server like WAMP, MAMP or XAMPP. Point the web root 
     *   directory to the folder containing this file, and load 
     *   localhost:8888/sendnotifications.php in a web browser.
     */

    // Step 1: Download the Twilio-PHP library from twilio.com/docs/libraries, 
    // and move it into the folder containing this file.
    require "/usr/local/sh-platform/web-framework-docroot/twilio_api_testing/code/twilio-php-master/Services/Twilio.php";

    // Step 2: set our AccountSid and AuthToken from www.twilio.com/user/account
    $AccountSid = "AC651584ed25ddcb8f2a6b686b27e2cba3";
    $AuthToken = "8a1498fad6ad9300b30d94672e25364d";

    // Step 3: instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);

    // Step 4: make an array of people we know, to send them a message. 
    // Feel free to change/add your own phone number and name here.
    $people = array(
        $myphonenumber => "New User",
    );

    // Step 5: Loop over all our friends. $number is a phone number above, and 
    // $name is the name next to it
    foreach ($people as $number => $name) {

        $sms = $client->account->messages->sendMessage(

        // Step 6: Change the 'From' number below to be a valid Twilio number 
        // that you've purchased, or the (deprecated) Sandbox number
            "650-900-2030", 

            // the number we are sending to - Any phone number
            $number,

            // the sms body
            "Hello $firstname, Verification Code is $randomPassword"
        );

        // Display a confirmation message on the screen
        //echo "Sent message to $name";
    }

//$url = 'http://xen-ashwin-1.ksjc.sh.colo/twilio_api_testing/code/accountManagement/createaccount.php';
//$http = new HttpRequest($url, HttpRequest::METH_POST);
//$http->setOptions(array(
//    'timeout' => 10,
//    'redirect' => 4
//));

//$http->addPostFields(array(
//    'randomPassword' => $randomPassword,
//));

//$response = $http->send();
//echo "This is the repsonse: ".$response->getBody();
header("location:createaccount.php");
?>

</html>
