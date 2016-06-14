<html>
  <head>
    <title>Twilio Account Management</title>
    <link type="text/css" rel="Stylesheet" media="all" href="styles.css">
  </head>
<body>


<br/><br/>


<div class="my_login_container">
<form name="login" method="POST" action="passwordsend.php">

<table border="0" cellspacing="5" cellpadding="2">
  <tr>
	<td><b><div class="login">TWilio API Testing Account Management</div></b></td>
  </tr>
  <tr>
    <td colspan=2><div class="login">Forgot Password/Request Account Creation</div></td>
    <!--<td colspan=2><img src="shlogo1.png"></td>-->
  </tr>
</table>
<table border="0" cellspacing="5" cellpadding="2">
  <tr></tr>
  <tr>
    <td>Email Address</td>
  </tr>
  <tr>
    <td><input name="myemailaddress" type="text" id="myemailaddress" size="35" ></td>
  </tr>
  <tr>
  <td>Phone Number</td>
  </tr>
  <tr>
  <td><input name="myphonenumber" type="text" id="myphonenumber" size="35" ></td>
  </tr>
  <tr>
  <td></td>
  </tr>
  <tr>
    <td><input type="submit" name="submit" value="Send Request"></td>
  </tr>
  <tr>
	<td>This form will generate an email with a link for changing the password for an existing account.</td>
  </tr>
  <tr>
	<td>If the account does not exist, You will be redirected to Registration Page.</td>
  </tr>
</table>

</form>
</div>

</body>
</html>

