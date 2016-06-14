<?php
	require_once("DB.php");
	$loginconfig = parse_ini_file(dirname(__FILE__) . '/../configs/' . '/master-login.ini', TRUE);
	$tool_access_array = array(
							"twilio_api_tool"              => array(10, 8, 5),
							"DedupeRulesUI"                 => array(10)
						);

	function user_login($username, $password, $toolname) {
		global $loginconfig;
		$dsn = $loginconfig['users']['dsn'];
		$usertable = $loginconfig['users']['table'];
		// Connect to server

		$connection=DB::connect($dsn);
		if(DB::isError($connection)) {
			  die($connection->getMessage());
		}

		$myusername=$username;
		$mypassword=md5($password);
		$mytoolname = $toolname;
		
		// To protect MySQL injection (more detail about MySQL injection)
		$myusername = stripslashes($myusername);
		$mypassword = stripslashes($mypassword);
		$myusername = mysql_real_escape_string($myusername);
		$mypassword = mysql_real_escape_string($mypassword);

		$sql="SELECT role, accesslevel, email FROM " . $usertable . " WHERE username='$myusername' and password='$mypassword'";

		$result=$connection->query($sql);

		if(DB::isError($result)) {
			die($result->getUserInfo());
		}

		$connection->disconnect();

		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$myrole = $row['role'];
		echo $myrole;
		$myaccesslevel = $row['accesslevel'];
		echo $myaccesslevel;
		$email = $row['email'];
		echo $email;

		global $tool_access_array;

		foreach ($tool_access_array as $toolname=>$accesslevel) {
			if ($toolname == $mytoolname) {
				// Get array of allowable integer values for the given tool name
				foreach ($accesslevel as $value) {
					// Test the user's access level if exists in the tool's array of values
					if ($value == $myaccesslevel) {
						// has the access level assigned to "access", else return 1.
						if ($toolname == "JobExclusionsUI" || $toolname == "KeywordFiltersUI") {
							$row = array("access" => $myrole);
							return $row;
						} else if ($toolname == 'twilio_api_tool') {
							$row = array("email" => $email, "accesslevel" => $myaccesslevel);
							return $row;
                                                } else if ($toolname == 'CrawlTracker') {
                                                        $row = array("email" => $email,"accesslevel" => $myaccesslevel, "role" => $myrole);
                                                        return $row;
						} else {
							return 1;
						}
					}
				}
			}
		}
		
		return 0;
	}
?>
