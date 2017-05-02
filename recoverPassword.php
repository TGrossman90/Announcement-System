<!-- 
recoverPassword.php
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
			
			<form method="post" action="resetPassword.php" name="announceForm">
				<fieldset>
					<input type="hidden" name="hidden" value="username">
					<p>Username:</p>
					<input type="text" name="username"> <br /> 
					<p>Clicking submit will send an email to your account that will contain a link to reset your password</p>
					<input type="submit" name="resetPassword" value="Submit" class="buttonForm"/>&nbsp;<a href="index.php" class="buttonForm">Cancel</a>
				</fieldset>
			</form>
			
		</div>
	</body>
</html>