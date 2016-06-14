<?php

session_start();


$randomPassword = $_SESSION['random'];
$myemailaddress = $_GET['emailaddress'];

if(!empty($_POST['submit'])) {
	$myemailaddress = $_POST['myemailaddress'];
	$myfirstname= $_POST['myfirstname'];
	$mylastname= $_POST['mylastname'];
	$myphonenumber = $_POST['myphonenumber'];
	$accesslevel= 10;
	$verification_code = $_POST['myverificationcode'];
	if ($verification_code == '') {
		header("location:send_verification.php?phonenumber=$myphonenumber&myfirstname=$myfirstname");	
	}
	if ($myemailaddress AND $myfirstname!="" AND $mylastname!="" AND $myphonenumber !="" AND $verification_code == $randomPassword) {
		require_once("DB.php");
		$loginconfig = parse_ini_file('../../configs/' . '/master-login.ini',TRUE);
		$dsn= $loginconfig['users']['dsn'];
		$usertable= $loginconfig['users']['table'];
		$connection=DB::connect($dsn);

		if(DB::isError($connection)){
			die($connection->getMessage());
		}
		
		$myfirstname = stripslashes($_POST['myfirstname']);
		$mylastname = stripslashes($_POST['mylastname']);
		$myemailaddress = stripslashes($_POST['myemailaddress']);
		$accesslevel = stripslashes($_POST['accesslevel']);

		$myfirstname = mysql_real_escape_string($_POST['myfirstname']);
		$mylastname = mysql_real_escape_string($_POST['mylastname']);
		$myemailaddress = mysql_real_escape_string($_POST['myemailaddress']);
		$accesslevel = mysql_real_escape_string($_POST['accesslevel']);

		$token = rand(1000, 9000);
		
		// get user.  Will not even have any affect since other
		// groups do not have access to tools which utilize this field.  See master-login.php for more
		if ($_POST['accesslevel']!="10" && $_POST['accesslevel']!="8"){
			$role='user';
		}
		else{
			$role='admin';
		}

		$myemailaddress_array = explode ( "@", $myemailaddress );
		$myusername = $myemailaddress_array[ 0 ];

		$sql="INSERT INTO " . $usertable . " (phone_number,username,firstname, lastname, email,role,accesslevel)
		VALUES ('$myphonenumber', '$myusername','$myfirstname', '$mylastname', '$myemailaddress','admin','10')";
	
		$result=$connection->query($sql);
		
		if(DB::isError($result)){
			die($result->getUserInfo());
		}

		$subject = "Simply Hired Content Tools: Login Credentials.";
		$message = "\n\nA new account has been created.\n\n\nUsername: $myusername \n\nPlease click on the following link to change your password:\n\nhttp://xen-ashwin-1.ksjc.sh.colo/twilio_api_testing/code/accountManagement/passwordreset.php?username=$myusername&token=$token";
		$message = wordwrap($message, 70);
		$headers = "From: admin@twilio_api_testing.com";

		mail($myemailaddress, $subject, $message, $headers);
		$connection->disconnect();
		
		$creationsuccess = true;
	} else {
		echo "<font color='red'>Please make sure your email is work email address. eg. (emailaddress@domain.com). \n <br><br>Make sure you have filled and selected all the fields</font>";
	}
}


?>
<html>
<body>
	<center><h1>Twilio Account Registration</h1></center>
	<?php
	if ($myemailaddress != '') {?>
		<center> Email Address Provided does not have an account, Please Register </center>
	<?php }
	?>
	<div class=\"header_links\">
		<center>Welcome </center>
	</div>
	<br>

	<?php if ($creationsuccess == true) {
	?>
		<br>
		<center>Account credentials have been sent to <?php echo $myfirstname ?>'s email address.</center>
		<br>
		<!--<center><a href="createaccount.php">Click here to create another account</a></center>-->
	<?php } else {
	?>
		<center>
		<form name="submit" method="post" action="createaccount.php">
			<table cellspacing="20">
				<tbody>
					<tr>
						<td colspan="2" align="center"><font color="red">Please fill all the following fields:</font></td>
					</tr>
					<tr>
						<td>First Name</td>
						<td><input name="myfirstname" type="text" size="35" ></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input name="mylastname" type="text" size="35" ></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input name="myemailaddress" type="text" size="35" ></td>
					</tr>
					<tr>
						<td>Phone Number</td>
						<td><input name="myphonenumber" type="text" size="35"></td>
					</tr>
					<?php
						if ($randomPassword != '') {
					?>
					<tr>
						<td> Verification Code </td>
						<td><input name="myverificationcode" type="text" size="35">
					</tr>
					<?php } ?>
					<tr>
						<td colspan="2" align="center">
							<input type="submit" value="Submit" name="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="reset" value="Reset All" name="B5">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		</center>
	<?php }
	?>

	</body>
</html>
