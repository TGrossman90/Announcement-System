<!-- 
resetPassword.php
Created by Tom Grossman on 4/24/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Recover Lost Password</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			<?php
		
				//Includes
				include "functions.php";
				include "systemConfiguration.php";
				
				$passwordError = $passwordVerifyError = "";

				// Since the register form is on this same page, check to see if a form was submitted
				// or if this is a fresh viewing of the page
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if(!empty($_POST['hidden'])) {
						if($_POST['hidden'] == "username") {
							if(!empty($_POST['username'])) {
								$user = processText($_POST['username']);
								$userHash = hash('sha512', $user);
								
								$now = mt_rand();
								$hashID = hash('sha512', $user . $now);
								
								$url = $webAddress . "/resetPassword.php?id=" . $hashID ."&req=" . $userHash;
								
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								$from = $mailAdmin;
								$headers .= 'From: '.$from."\r\n".
									'X-Mailer: PHP/' . phpversion();
									
								$sql = "UPDATE users SET passreset='$hashID' WHERE username='$user'";
								$query = mysqliQuery($sql);
								mysqli_free_result($query);
									
								$message = '<html><body>';
								$message .= 'Hello,<br />';
								$message .= '<br />This message has been generated because a request to reset your password was submitted.<br />';
								$message .= '<br />To reset your password, click the link below:<br />';
								$message .= '<a href="'.$url.'"> '.$url.' </a><br />';
								$message .= '<br />If you have received this email in error, you can just disregard it. <br />';
								$message .= '<br />Thank you,';
								$message .= '<br />Music Dept Staff';
								$message .= '</body></html>';
								mail($user, "Password Reset Request!", $message, $headers);
								
								echo '<p>An email has been sent with instructions to reset your password</p>';
								echo '<a href="index.php" class="buttonForm">Go Back</a>';
							} else {
								echo '<p>You have to enter a username in order to reset the password!</p>';
								echo '<a href="index.php" class="buttonForm">Go Back</a>';
							}
							
						} else {
							if(!empty($_POST['password']) && !empty($_POST['passwordVerify'])) {
								if(processText($_POST['password']) != processText($_POST['passwordVerify'])) {
									$passwordError = "**Your passwords do not match";
									$passwordVerifyError = "**Your passwords do not match";
								} else if(!empty($_POST['hidden'])) {
									
									$password = processText($_POST['password']);
									$usr = processText($_POST['hidden']);
									
									$passHash = password_hash($password, PASSWORD_BCRYPT);
									$sql = "UPDATE users SET password='$passHash' WHERE username='$usr'";
									$query = mysqliQuery($sql);
									$sql = "UPDATE users SET passreset=' ' WHERE username='$usr'";
									$query = mysqliQuery($sql);
									mysqli_free_result($query);
									
									echo '<p>Your password has been changed!</p>';
									echo '<a href="index.php" class="buttonForm">Go Back and Login</a>';
								}
							}
						}
					}
					
				} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
					if(!empty($_GET['id'])) {
						$id = processText($_GET['id']);

						if(!empty($_GET['req'])) {
							$req = processText($_GET['req']); 
							
							$sql = "SELECT username FROM users WHERE passreset='$id'";
							$query = mysqliQuery($sql);
							
							if(mysqli_num_rows($query) == 1) {
								$username = mysqli_fetch_row($query);
								$user = $username[0];
								$userHash = hash('sha512', $user);
								
								if($userHash == $req) {
									echo '<form method="post" action="' . $_SERVER["PHP_SELF"] . '" name="announceForm">';
									echo '<fieldset>';
									echo '<input type="hidden" name="hidden" value="' . $user .'">';
									echo '<p>Enter a new password</p>';
									echo '<input type="password" name="password"> <br />';
									echo '<span class="error">' . $passwordError . ' </span>';
									echo '<p>Re-enter your password</p>';
									echo '<input type="password" name="passwordVerify"> <br />';
									echo '<span class="error">' . $passwordVerifyError . ' </span>';
									echo '<br /><input type="submit" name="resetPassword" value="Submit" class="buttonForm"/>&nbsp;<a href="index.php" class="buttonForm">Cancel</a>';
								} else {
									echo 'There was an error<br />';
									echo '<a href="index.php" class="buttonForm">Cancel</a>';
								}
							}
						}
					}
				} else {
					header("location:index.php");
				}
			?>
			
		</div>
	</body>
</html>