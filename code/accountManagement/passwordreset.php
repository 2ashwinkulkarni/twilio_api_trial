<?php
session_start();

if(!empty($_POST['submit'])) {
	require_once('DB.php');
	$simplyconfig = parse_ini_file('../../configs/' . $_SERVER['SH_ENV'] . '/master-login.ini',TRUE);

	//$dsn = $simplyconfig['purge']['dsn'];
	$dsn = $simplyconfig['users']['dsn'];
	$usertable = $simplyconfig['users']['table'];
	// Connect to server

	$connection=DB::connect($dsn);
	if(DB::isError($connection)) {
		  die($connection->getMessage());
	}

	// Data sent form
	$username=$_POST['username'];
	
	// Check for value before running md5 function since it will give output for empty value.
	// $token variable is later used to determine what info to show if unsuccessful
	$token=$_POST['token'];
	if (!empty($token)) {
		$token=md5($token);
	}
	
	$currentpassword=$_POST['currentpassword'];
	if (!empty($currentpassword)) {
		$currentpassword=md5($currentpassword);
	}
	
	$newpassword=$_POST['newpassword'];
	
	if ($newpassword == '') {
		echo "Please enter a valid password";
	} else {
		$newpassword = md5($newpassword);

		// To protect MySQL injection (more detail about MySQL injection)
		$username = stripslashes($username);
		$newpassword = stripslashes($newpassword);
		$username = mysql_real_escape_string($username);
		$newpassword = mysql_real_escape_string($newpassword);

		$sql="SELECT * FROM " . $usertable . " WHERE username='$username'";

		$result=$connection->query($sql);

		if(DB::isError($result)) {
				die($result->getUserInfo());
		}

		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);

		// Check if current password or new password token match, change the password
		if($row['password'] == $currentpassword || $row['newpwtoken'] == $token) {
		  $updatePasswordQuery = "UPDATE " . $usertable . " SET password = '$newpassword' where username = '$username'";
		  $result=$connection->query($updatePasswordQuery);

		  if(DB::isError($result)) {
			die($result->getUserInfo());
		  }

		  header("location:confirmpassword.php"); 
		} else {  //Failed to change password.  Different info shown depending on if using token or not.
		  if(!empty($username)) {
			if (!empty($token)) {
				$tokenfailed = true;
			} else {
				echo "Wrong Username or Password";
				$pwchangefailed = true;
			}
		  }
		}
	}
	$connection->disconnect();
}
?>

<?php
	if ($tokenfailed) {
?>
	<html>
	  <head>
		<title>Twilio Account Management</title>
		<link type="text/css" rel="Stylesheet" media="all" href="styles.css">
	  </head>

	  <body>
		<div id="message" align="center" style="margin-top:50px">
			Oops!  Something went wrong when trying to change the password.
			<br>
			Please ensure you are using the correct link
			<br>
			or
			<br>
			<a href="accountinfo.php">Click here to obtain a new password reset link</a>
		</div>
	  </body>
	</html>
<?php
	} else {
?>
	<html>
	  <head>
		<title>Twilio Account Management</title>
		<link type="text/css" rel="Stylesheet" media="all" href="styles.css">
	  <script type='text/javascript'>
		function validatePasswords() {
			var newpassword = document.getElementById('newpassword').value;
			var confirmpassword = document.getElementById('confirmpassword').value;
			if (newpassword == '' || confirmpassword == '') {
				alert("Please enter a valid password");
			} else {
				if (newpassword == confirmpassword) {
					document.changepassword.submit();
				}
				else {
					document.getElementById('newpassword').focus();
					alert("New Passwords do not match");
				}
			}
		}
	  </script>

	  </head>
	  
	<body>


	<br/><br/>


	<div class="my_login_container">
	<form name="changepassword" method="POST" action="passwordreset.php">

	<table border="0" cellspacing="5" cellpadding="2">
	  <tr>
		<td><b><div class="login">Twilio Account Management</div></b></td>
	  </tr>
	  <tr>
		<td colspan=2><div class="login">Reset Password</div></td>
		<!--<td colspan=2><img src="shlogo1.png"></td>-->
	  </tr>
	</table>
	<table border="0" cellspacing="5" cellpadding="2">
	  <tr>
	  </tr>
	  <tr>
		<td>Username: </td>
	  </tr>
	  <?php
		if (!empty($_GET['username']) && !empty($_GET['token'])) {
			$myusername = $_GET['username'];
			$mytoken = $_GET['token'];
			echo '<tr>
					<td><input name="username" type="text" id="username" size="35" readonly="readonly" value="' . $myusername . '"><input type="hidden" name="token" value="' . $mytoken . '"></td>
				  </tr>';
		} else {
			echo '<td><input name="username" type="text" id="username" size="35" ></td>
				  <tr>
					<td>Current Password: <br> <input name="currentpassword" type="password" id="currentpassword" size="35" ></td>
				  </tr>';
		}
	  ?>   
	  <tr>
		<td>New Password: <br> <input name="newpassword" type="password" id="newpassword" size="35" ></td>
	  </tr>
	  <tr>
		<td>Confirm New Password: <br> <input name="confirmpassword" type="password" id="confirmpassword" size="35" ></td>
	  </tr>
	  <tr><td></td></tr>
	  <tr>
		<td><input type="submit" name="submit" value="Reset Password" onclick="validatePasswords(); return false;"></td>
	  </tr>
	  <?php
		if ($pwchangefailed) {
			echo '<tr></tr><tr><td><em>Use the following link if you forgot your current password:<br><a href="accountinfo.php">Account Management</a></em></td></tr>';
		}
	  ?>
	</table>

	</form>
	</div>

	</body>
	</html>
<?php
	}
?>
