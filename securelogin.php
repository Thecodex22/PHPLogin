<html>
<head><title>Secure Login</title>
	<link rel="stylesheet" href="css/loginstyle.css" type="text/css" />
</head>
<body>

	<div class="loginHolder">
		<form method="POST" name="login" action="homepage.php">
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
					<td></td>
					<td>
						<input type="submit" name="submit" value="Login" />	
					</td>
				</tr>
				<tr><td></td><td><a href="register.php">Register?</a></td></tr>
				<tr>
					<td colspan="2">
					<?php 
					if(isset($_COOKIE['error'])){
						if($_COOKIE['error'] == ""){
							session_destroy();
							echo "Session destroyed";
						}else{
							echo "<span class=\"error\">" . $_COOKIE['error'] . "</span>";
						}
					}
					?>
					</td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>