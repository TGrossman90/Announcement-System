<!-- 
acp.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Admin Control Panel</title>
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
			if(($_SESSION['permissions'] >= 50) && ($_SESSION['loggedin'] == "1")) {
				echo '<h2>Admin Control Panel</h2>';
				
				// Show links for admins only
				if($_SESSION['permissions'] == 100) {
					echo '<a href="acpAdd.php" class="button">Add User to Group</a><br />';
					echo '<a href="acpRemoveUsers.php" class="button">Remove User from Group</a><br />';
					echo '<a href="acpRemoveUserAcct.php" class="button">Delete User</a><br />';
					echo '<a href="acpAddStaff.php" class="button">Add Staff Account</a><br />';
					echo '<a href="acpDeauthStaff.php" class="button">Remove Staff Account</a><br />';
					echo '<a href="acpAddGroup.php" class="button">Create a Group</a><br />';
					echo '<a href="acpRemoveGroup.php" class="button">Delete a Group</a><br />';
					echo '<a href="acpReset.php" class="button">Reset Options</a><br />';
				}
				
				// Show links for faculty
				if($_SESSION['permissions'] == 50) {
					echo '<a href="acpAdd.php" class="button">Add Users to Group</a><br />';
					echo '<a href="acpRemoveUser.php" class="button">Remove Users from Group</a><br />';
				}
				
				echo '<br /><br /><center><a href="index.php" class="buttonForm">Home</a></center><br />';
			} else {
				
				// Kicked out
				echo 'You do not have permission to be here!';
				header("location:index.php");
			}
			
		?>
		
	</body>
</html>