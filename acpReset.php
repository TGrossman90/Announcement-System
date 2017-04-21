<!-- 
acpReset.php
Created by Tom Grossman on 4/20/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Reset Options</title>
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
			
			// Check if you're allowed to be here
			if(($_SESSION['permissions'] == 100) && ($_SESSION['loggedin'] == "1")) {
				
		?>
				<h2>Reset Options</h2>
				<form method="post" action="resetSystem.php" onsubmit="return confirm('Do you really want to continue? This action cannot be undone!')">
					<fieldset>
						<button name="resetOption" type="submit" class="button" value="resetSemester" onclick="return confirm('This will delete any announcements that are currently in the system (clutter removal). Are you sure you want to continue?')">Reset For Semester (Fall to Spring)</button> <br />
						<button name="resetOption" type="submit" class="button" value="resetYear" onclick="return confirm('This will delete all users (except staff) and all announcements in the system. Are you sure you want to continue?')">Reset For Year (Spring to Fall)</button> <br />
					</fieldset>
				</form>
				
				<br /><br /><center><a href="acp.php" class="buttonForm">Go Back</a></center><br />
		<?php		
			} else {
				// Kicked out
				echo 'You do not have permission to be here!';
				header("location:index.php");
			}
			
		?>
		
	</body>
</html>