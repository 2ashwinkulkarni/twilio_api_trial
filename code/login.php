<?php
session_start();
#require_once('../master-login.php');
if (count($_POST) > 0) {
	// username and password sent from form
	$myusername=$_POST['myusername'];
	$mypassword=$_POST['mypassword'];
	$count = user_login($myusername, $mypassword, "PurgeTool");
	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count==1)
	{
	  $_SESSION["myusername"] = $myusername;
	  
	  header("location:index.php");
	}
	else
	{
	  echo "Wrong Username or Password";
	}
}
?>

<html>
  <head>
    <title>Purge Tool</title>
    <link type="text/css" rel="Stylesheet" media="all" href="styles.css">
  </head>
<body onload="document.login.myusername.focus()">


<br/><br/>


<div class="my_login_container">
<form name="login" method="POST" action="login.php">

<table border="0" cellspacing="5" cellpadding="2">
  <tr>
    <td colspan=2><b><div class="login">Login to Twilio API Web-App</div></b></td>
    <!--<td colspan=2><img src="shlogo1.png"></td>-->
  </tr>
</table>
<table border="0" cellspacing="5" cellpadding="2">
  <tr></tr>
  <tr>
    <td>Username:</td>
  </tr>
  <tr>
    <td><input name="myusername" type="text" id="myusername" size="35" ></td>
  </tr>
  <tr>
    <td>Password:</td>
  </tr>
  <tr>
    <td><input name="mypassword" type="password" id="mypassword" size="35" ></td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td><input type="submit" name="Submit" value="Login"></td>
  </tr>
 <tr><td></td></tr>
  <tr>
    <td><a href="../accountManagement/accountinfo.php">Forgot Password / Create Account</a></td>
  </tr>
 <tr>
    <td><a href="../accountManagement/passwordreset.php">Reset Password</a></td>
  </tr>
</table>

</form>
</div>

</body>
</html>
