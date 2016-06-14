<?php
session_start();

if(!empty($_POST['submit'])) {
	$emailaddress = $_POST['myemailaddress'];
	$phonenumber = $_POST['myphonenumber'];

	if ($emailaddress != '' &&  $phonenumber != '') {
		require_once('DB.php');
		$simplyconfig = parse_ini_file('../../configs/' . '/master-login.ini',TRUE);

		//$dsn = $simplyconfig['purge']['dsn'];
		$dsn = $simplyconfig['users']['dsn'];
		$usertable = $simplyconfig['users']['table'];
		// Connect to server

		$connection=DB::connect($dsn);
		if(DB::isError($connection)) {
			  die($connection->getMessage());
		}

		$sql="SELECT * FROM " . $usertable . " WHERE email = '$emailaddress' and phone_number='$phonenumber'";

		$result=$connection->query($sql);

		if(DB::isError($result)) {
				die($result->getUserInfo());
		}
		
		$randomToken = rand(1000, 9000);

		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$username = $row['username'];
		if($username) {
		  $query = "UPDATE $usertable SET newpwtoken = '". md5($randomToken) . "' where email = '$emailaddress'";
		  $credentials = $connection->query($query);
		  if(DB::isError($credentials)) {
				die($result->getUserInfo());
		  }

		  $webMessage = "<p>The account already exists and A link to change the account's password has been sent to the email address associated with the account. <br><a href='../index.php'>Please click here to go back to the Content Tools page.</a></p>";
          $_SESSION["accesslevel"] = $row['accesslevel'];
          $_SESSION["accesslevel"] = $row['accesslevel'];
		  $subject = "Twilio Testing : Forgotten Password.";
		  $message = "Twilio Testing .\nA Link to reset the password been requested for this account.\n\nUsername: $username \n\n* Please note this message does NOT mean your password has been changed.\n\n* Your current password is still valid, but you may use the following link to reset it:\n\nhttps://xen-ashwin-1.ksjc.sh.colo/twilio_api_testing/code/accountManagement/passwordreset.php?username=$username&token=$randomToken";
		  $message = wordwrap($message, 70);
		  $headers = "From: admin@twilio_api_testing.com";

		  mail($emailaddress, $subject, $message, $headers);
		} else {
		//$webMessage = "Account does not seem to exist for the information provided, An account can be created provided we perform a 2-Factor authentication by sending a Verification Code to your Provided Phone number - $phonenumber<br> <a href='../accountManagement/createaccount.php'>Click Here</a> to create account";
		//$emailaddress = $_POST['myemailaddress'];
		header("location:createaccount.php?emailaddress=$emailaddress");


		}
		
		$connection->disconnect();
	} else {
		$webMessage = "<b>Invalid email given.</b><br><br><a href='accountinfo.php'>Back to form.</a>";
	}
	
}

?>

<html>
  <head>
    <title>TWilio Account Management</title>
    <link type="text/css" rel="Stylesheet" media="all" href="styles.css">
  </head>

<body>
<div id="message" align="center" style="margin-top:50px"><?php echo $webMessage  ?></div>
</body>
</html>

