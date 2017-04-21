<!-- 
index.php
Created by Tom Grossman on 3/24/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
		<img src="/img/umslmusic_logo.png" id="logo" />
		
		<?php
			
			// Includes
			include "functions.php";
			include "dbcontroller.php";
			
			// Check if logged in
			if($_SESSION['loggedin'] == 1) {
				echo '<center><h2>Main Menu</h2></center>';
				
				// Check for announcements and print the main menu
				$username = processText($_SESSION['username']);
				$sql = "SELECT announcement FROM announcements WHERE username='$username'";
				$result = mysqliQuery($sql);
				
				$count = mysqli_num_rows($result);
				mysqli_free_result($result);
				
				if($count > 0) {
					printf("<br />You have %u announcement(s) to read!<br />", $count);
					echo '<a href="announceInbox.php" class="button">Go to Inbox</a> <br /><br />';
				}
				
				if($_SESSION['permissions'] >= 50) {
					echo '<a href="announceCreate.php" class="button"> Send an Announcement </a><br />';
				}
				
				// Check if faculty/admin account
				if($_SESSION['permissions'] >= 50) {
					echo '<a href="acp.php" class="button">Admin Control Panel</a><br />';
				}
				
				echo '<br /><center><a href="logout.php" class="buttonForm">Logout</a></center>';		
				
			// If the user is not logged in but filled out and submitted the login form
			} elseif(!empty($_POST['username']) && !empty($_POST['password'])) {
				
				$username = processText($_POST['username']);
				$password = processText($_POST['password']);
				$sql = "SELECT password, userLevel FROM users WHERE username = '$username'";
				$result = mysqliQuery($sql);
				$row = mysqli_fetch_row($result);
				$hash = $row[0];
				$userLevel = $row[1];
				
				// Make sure the user and password match up
				if(mysqli_num_rows($result) == 0 ) {
					echo '<br /><br />Error: Username/Password not found. <br /><a href="index.php" class="buttonForm">try again</a> &nbsp; <a href="register.php" class="buttonForm">register an account</a>';
				
				// Verify the password is a match and login
				} else {
					$sql = "SELECT verification FROM users WHERE username='$username'";
					$result = mysqliQuery($sql);
					$verified = mysqli_fetch_row($result);
					if($verified[0] == "verified") {
						if(password_verify($password, $hash)) {
							echo "Successfully logged in";
							
							$_SESSION['loggedin'] = 1;
							$_SESSION['username'] = $username;
							$_SESSION['permissions'] = $userLevel;
							header("location: index.php");
						
						// The password is wrong
						} else {
							echo '<p>The entered password does not match the password for that user. Please try again.<p>';	
							echo '<a href="index.php" class="buttonForm">Go Back</a>';
						}
					
					} else {
						echo '<p>You need to verify your account before you can login.</p>';
						echo '<a href="index.php" class="buttonForm">Go Back</a>';
					}
				}
				
				mysqli_free_result($result);
				
			// Login form
			} else {
				echo '<h4>Please login or register an account</h4>';
				echo '<form method="post" action="index.php" name="loginform">';
					echo '<fieldset>';
						echo '<p>Username:</p><input type="text" name="username" /><br />';
						echo '<p>Password:</p><input type="password" name="password" /><br />';
						echo '<br /><input type="submit" name="login" value="Login" class="buttonForm" />';
						echo '<a href="register.php" class="buttonForm">Register</a>';
					echo '</fieldset>';
				echo '</form>';
			}
		?>
		
	</body>
</html>