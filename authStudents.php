<!-- 
authStudents.php
Created by Tom Grossman on 3/26/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Adding Users</title>
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
			
			// Make sure things posted correctly
			if(!empty($_POST['group'])) {
				if(!empty($_POST['students'])) {
					$group = $_POST['group'];
					$students = $_POST['students'];	
					
					// Break the usernames up into an array of strings with no special characters
					$std = explode(',', $students);
					
					// For every email address
					foreach($std as $user) {	
						$allowed = array('mail.umsl.edu', 'umsl.edu');
						$user = processText($user);
						
						// Check to make sure that the email hasn't already been used
						$checkuser = mysqli_query($conn, "SELECT * FROM studentUsers WHERE username = '$user'") or die(mysqli_error($conn));
						if(mysqli_num_rows($checkuser) != 0 ) {
							echo $user . " is already registered. Skipping...<br />";
							mysqli_free_result($checkuser);
							continue;
							
						// Check to make sure the email address is actually real
						} else if(filter_var($user, FILTER_VALIDATE_EMAIL)) {
							$email = explode('@', $user);
							$domain = array_pop($email);
							$domain = processText($domain);
							
							// If it is real, make sure it is of the UMSL domain
							if(! in_array($domain, $allowed)) {
								echo $domain ." is not an allowed domain (mail.umsl.edu or umsl.edu). Skipping...<br />";
								continue;
							}
							
						// If it's not a real email
						} else if(! filter_var($user, FILTER_VALIDATE_EMAIL)) {
								echo $user ." isn't even an email. Skipping...<br />";
								continue;
						}
						
						// Insert email into a database that will allow that user to register an account and into their specified group
						$result = mysqli_query($conn, "INSERT INTO $group (id, username) VALUES ('NULL', '$user')") or die(mysqli_error($conn));
						$result2 = mysqli_query($conn, "INSERT INTO studentUsers (id, username) VALUES ('NULL', '$user')") or die(mysqli_error($conn));
					
					}
					
				} else {
					header("location:acpAdd.php");
				}
				
			} else {
				header("location:acpAdd.php");
			}

			echo '<br /><center><h3>Finished</h3></center>';
			echo '<center><a href="acp.php" class="button">Go Back</a></center>';
			
		?>
		
	</body>
</html>