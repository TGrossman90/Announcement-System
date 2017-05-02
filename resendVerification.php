<!-- 
resendVerification.php
Created by Tom Grossman on 4/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Resend Verification</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			<?php
				
				// Includes
				include "functions.php";
				include "systemConfiguration.php";
				
				if(!empty($_POST['username'])) {
					$user = processText($_POST['username']);
					
					$time = mt_rand();
					$verificationHash = hash('md5', $user . $time);
					
					$sql = "UPDATE users SET verification='$verificationHash' WHERE username='$user'";
					$query = mysqliQuery($sql);
					mysqli_free_result($query);
					
					// To send HTML mail, the Content-type header must be set
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$from = $mailAdmin;
					$headers .= 'From: '.$from."\r\n".
						'X-Mailer: PHP/' . phpversion();
					
					$url = $webAddress .'/acctVrfy.php?id='.$verificationHash;
					$message = '<html><body>';
					$message .= '<br />Please click the following link to verify your account and complete the registration.<br /><br />';
					$message .= '<a href="'.$url.'"> '.$url.' </a><br />';
					$message .= '<br />Thank you,';
					$message .= '<br />Music Dept Staff';
					$message .= '<br /><br />This email is system generated. Please do not reply -- it will never be seen.';
					$message .= '</body></html>';
					mail($user, "Please Verify Your Account", $message, $headers);
					
					echo '<p>Verification has been resent. Please check your email and follow the instructions.</p>';
					echo '<a href="index.php" class="buttonForm">Go Back</a>';
				} else {
					header("location:index.php");
				}
				
			?>
			
		</div>
	</body>
</html>