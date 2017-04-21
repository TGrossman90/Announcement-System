<!-- 
acpDeauthStaff.php
Created by Tom Grossman on 4/20/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Remove Staff Accounts</title>
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
			
			// Check if you're supposed to be here
			if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] == 100)) {
				echo "You do not have permission to be here!";
				header("location:index.php");
			}
			
		?>
		
		<form method="post" action="deauthStaff.php">
			<fieldset>
				<h2>Remove Staff Accounts</h2>
				<p>What would you like to do?</p>
				<div style="display: inline-block; text-align: left">
					<input type="radio" name="action" class="radioStyle" value="delete" /> Delete Staff Account <br />
					<input type="radio" name="action" class="radioStyle" value="remove" /> Remove Staff Permissions <br />
				</div>
				
				<br /> <br />
				<p>Select a User:</p>
				<select name="user" size="1">
					<option value="NULL"></option>
					<?php
						// Get all users
						$staffUsers = getAllStaffUsers();
						
						// Create an option with every username 
						foreach($staffUsers as $user) {
							if($user == "admin") {
								continue;
							}
							echo '<option value="'. $user .'">'. $user .'</option>';
						}
						
						mysqli_free_result($staffUsers);
					?> 
				</select> <br /><br />
				<input type="submit" name="submit" value="Submit" class="buttonForm">&nbsp;<a href="acp.php" class="buttonForm">Cancel</a>
			</fieldset>
		</form>
	</body>
</html>