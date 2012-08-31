<?php
function cleanString($strValue){
	$strDirty = $strValue;
	if(get_magic_quotes_gpc()){
		$strDirty = stripslashes($strDirty);
	}

	$strDirty = mysql_real_escape_string($strDirty);

	return $strDirty;
}
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repassword']) && isset($_POST['email'])){
	$username = cleanString($_POST['username']);
	$password = cleanString($_POST['password']);
	$repassword = cleanString($_POST['repassword']);
	$email = cleanString($_POST['email']);
	$cookie_error = "";

	//check password
	if($password != $repassword)
	{
		$cookie_error .= "Your passwords do not match";
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$cookie_error .= ", Your email is invalid";
	}
	if($cookie_error != ""){
		setcookie("reg-errors", $cookie_error, time()+3600);
		header("Location:register.php");
		return;
	}
	else
	{
		//Open db and update
		$connection = mysql_connect("localhost", "root", "") or die("Could not connect to DB");
		mysql_select_db("portfolio-site");

		//Get next auto incrememnt
		$autoIncResult = mysql_query("SELECT MAX(id) as inc FROM users");
		$autoIncData = mysql_fetch_array($autoIncResult);
		$nextId = $autoIncData['inc'] + 1;
		mysql_free_result($autoIncResult);

		//Build command string
		$strCommand = "INSERT INTO users(id, username, password, email, donation) VALUES (". $nextId .",'".$username."','".$password."','".$email."', 0)";

		//Execute
		if(!mysql_query($strCommand))
		{
			echo $cookie_error;
			echo $strCommand . "<br />";
			die("Error:" . mysql_error());
		}
		mysql_close($connection);

		setcookie("error", "", time()+3600);
		header("Location:securelogin.php");
		return;
	}
}
?>
<html>
<head>
<title>Registration</title>
<link rel="stylesheet" href="css/loginstyle.css" type="text/css" />
</head>
<body>
	<div class="loginHolder">
		<form method="POST" name="register" action="register.php">
			<table>
				<tr>
					<td>
						<label>Username:</label>
					</td>
					<td>
						<input type="text" max="20" name="username" class="textbox" />
					</td>
				</tr>

				<tr>
					<td>
						<label>Password:</label>
					</td>
					<td>
						<input type="password" max="20" name="password" class="textbox" />
					</td>
				</tr>

				<tr>
					<td>
						<label>Re-Enter Password:</label>
					</td>
					<td>
						<input type="password" max="20" name="repassword" class="textbox" />
					</td>
				</tr>

				<tr>
					<td>
						<label>Email:</label>
					</td>
					<td>
						<input type="text" max="40" name="email" class="textbox" />
					</td>
				</tr>

				<tr>
					<td></td>
					<td>
						<input type="submit" name="submit" value="Register" />	
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php if(isset($_COOKIE['reg-errors'])) echo "<span class=\"error\">" . $_COOKIE['reg-errors'] . "</span>"; ?>
					</td>
			</table>
		</form>
	</div>
</body>

</html>