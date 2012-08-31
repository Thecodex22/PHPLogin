<?php
function cleanString($strValue){
	$strDirty = $strValue;
	if(get_magic_quotes_gpc()){
		$strDirty = stripslashes($strDirty);
	}

	$strDirty = mysql_real_escape_string($strDirty);

	return $strDirty;
}

//Check if information on screen is valid
if(isset($_POST['username']) && isset($_POST['password']))
{
	//Begin connecting to the server
	$connection = mysql_connect("localhost", "root", "") or die("Could not connect to Database");
	mysql_select_db("portfolio-site", $connection);

	//Clean up data to be sent to server
	$username = cleanString($_POST['username']);
	$password = cleanString($_POST['password']);

	//Prepare statement then execute
	$strCommand = "SELECT * FROM users WHERE username='$username' AND password='$password'";
	$result = mysql_query($strCommand);

	//returning 1 row will prove the user exists and is valid
	if(mysql_num_rows($result) == 1){
		session_start();
		$_SESSION['username'] = $username;
	}else{
		setcookie("error", "Invalid username or password", time()+3600);
		header("Location:securelogin.php");
		return;
	}
}

if(isset($_SESSION['username'])){
?>
<html>
<head>
<title>Account Home</title>
<link rel="stylesheet" type="text/css" href="css/loginstyle.css" />
</head>
<body>
<div class="loginHolder">
	<table>
		<tr>
			<td class="welcome">Welcome, <?php echo $_SESSION['username']; ?></td>
		</tr>
		<tr>
			<td class="welcome"><a href="logout.php">Logout</a></td>
		</tr>
	</table>
</div>

<div class="sitecenter">
	<h2>Donations Amount </h2>
	<span class="currency"><?php $info = mysql_fetch_array($result); echo $info['donation']; ?></span>
</div>
</body>
</html>
<?php }else{
	setcookie("error", "You need to be logged in to do that.", time()+2000);
	header("Location:securelogin.php");
} ?>