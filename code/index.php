<?php
session_start();

//$myusername=$_SESSION['trackingusername'];
$myusername = $_GET["uname"];
?>
<html>
<head>

</head>
<body>
<?php
    if($myusername != '') {    
    	print "<div class=\"header_links\" style=\"margin-right:10px\">\n".
          "Welcome, ".ucfirst($myusername)."<a href=\"index.php\"><b> <br>| Home </b></a>"." | "."<a href=\"logout.php\">Logout</a><br/>\n".
          "</div>\n".
	  "<div><img src='http://lolsnaps.com/upload_pic/catatonia.gif'></img></div>";
	  
	      require "/usr/local/sh-platform/web-framework-docroot/twilio_api_testing/code/twilio-php-master/Services/Twilio.php";
	    function send_link() {
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

    }
}
    else {
	  print "<div class=\"header_links\" style=\"margin-right:10px\" >\n".
          "Welcome, "."Guest ".
          "</div>\n".
	  "<p> This is the Twilio API Testing Interface - You are not Logged in, Please Login or Register to see the Magic</p>\n".
	  "<p>Link to the Login Page <a href='http://xen-ashwin-1.ksjc.sh.colo/twilio_api_testing/code/login.php'>Login Page </a>\n".
	  "<p>Link to the Login Page <a href='http://xen-ashwin-1.ksjc.sh.colo/twilio_api_testing/code/accountManagement/createaccount.php'>Registration Page </a>\n";
    }
?>

</body>
</html>
