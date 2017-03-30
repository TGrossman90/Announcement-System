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
		<link rel="stylesheet" href="styles2.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.9"/>
	</head>  
	<body>  
		<div id="main">
		
		<?php
			
			// Includes
			include "functions.php";
			include "dbcontroller.php";
			
			// Check if logged in
			if($_SESSION['loggedin'] == 1) {
				echo '<center><h2>Main Menu</h2></center>';
				
				// Check if faculty/admin account
				if($_SESSION['permissions'] >= 50) {
					echo '<a href="acp.php">Admin Control Panel</a><br />';
				}
				
				// Check for announcements and print the main menu
				$username = processText($_SESSION['username']);
				$result = mysqli_query($conn, "SELECT announcement FROM announcements WHERE username='$username'") or die(mysqli_error($conn));
				
				$count = mysqli_num_rows($result);
				mysqli_free_result($result);
				
				if($count > 0) {
					printf("<br />You have %u announcement(s) to read!<br />", $count);
					echo '<a href="announceInbox.php">Go to Inbox</a> <br /><br />';
				}
				
				if($_SESSION['permissions'] >= 50) {
					echo '<a href="announceCreate.php"> Send an Announcement </a><br />';
				}
				
				echo '<br /><center><a href="logout.php" class="button">Logout</a></center>';		
				
			// If the user is not logged in but filled out and submitted the login form
			} elseif(!empty($_POST['username']) && !empty($_POST['password'])) {
				
				$username = processText($_POST['username']);
				$password = processText($_POST['password']);
				$result = mysqli_query($conn, "SELECT password, userLevel FROM users WHERE username = '$username'") or die(mysqli_error($conn));
				$row = mysqli_fetch_row($result);
				$hash = $row[0];
				$userLevel = $row[1];
				
				// Make sure the user and password match up
				if(mysqli_num_rows($result) == 0 ) {
					echo 'Error: Username/Password not found. <br />Please <a href="index.php">try again</a> or <a href="register.php">register an account</a>.';
				
				// Verify the password is a match and login
				} else {
					if(password_verify($password, $hash)) {
						echo "Successfully logged in";
						
						$_SESSION['loggedin'] = 1;
						$_SESSION['username'] = $username;
						$_SESSION['permissions'] = $userLevel;
						header("location: index.php");
					
					// The password is wrong
					} else {
						echo "Error: Password incorrect. ";	
						echo 'Please <a href="index.php">try again</a>';
					}
				}
				
				mysqli_free_result($result);
				
			// Login form
			} else {
				echo 'Please either login below or <a href="register.php">register an account</a>';
				echo '<form method="post" action="index.php" name="loginform">';
					echo '<fieldset>';
						echo '<label for="username">Username:</label><input type="text" name="username" /><br />';
						echo '<label for="password">Password:</label><input type="password" name="password" /><br />';
						echo '<input type="submit" name="login" value="Login" />';
					echo '</fieldset>';
				echo '</form>';
			}
			
		?>
		
	</body>
</html>