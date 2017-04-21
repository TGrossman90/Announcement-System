<!-- 
acctVrfy.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Read Announcement</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
		<style>
		th {
			width: 320px
		}
		</style>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
		<img src="/img/umslmusic_logo.png" id="logo" />
		
		<?php 
		
			// Includes
			include "functions.php";
			include "dbcontroller.php";
			
			if(!empty($_GET['id'])) {
			
				// Gets the announcement ID passed by URL
				$verificationLink = processText($_GET['id']);

				$sql = "SELECT id FROM users WHERE verification='$verificationLink'";
				$result = "";
				
				if($result = mysqliQuery($sql)) {
					$idd = mysqli_fetch_row($result);
					$id = $idd[0];
					
					$sql = "UPDATE users SET verification='verified' WHERE id='$id'";
					if(!$result = mysqliQuery($sql)) {
						echo 'Error: Could not update user. Please try again <br />';
						echo '<a href="index.php" class="buttonForm">Go Back</a>';
					}
				} else {
					echo 'Error: Could not find a user with this verification link. <br />';
					echo '<a href="index.php" class="buttonForm">Go Back</a>';
				}
				
				mysqli_free_result($result);
				
				echo 'Thank you for verifying your account. Please go back and login. <br />';
				echo '<a href="index.php" class="buttonForm">Login</a>';
				
			} else {
				// If registration is complete and awaiting verification
				echo '<p>Your registration is almost complete.</p>';
				echo '<p>Please follow the instructions sent to your phone (or email if you opted out).</p>';
				echo '<a href="index.php" class="buttonForm">Back</a>';
			}
		?>
		
	</body>
</html>