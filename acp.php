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
		<link rel="stylesheet" href="styles2.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.9"/>
	</head>  
	<body>  
		<div id="main">
		
		<?php	
		
			// Includes
			include "functions.php";
			include "dbcontroller.php";
			
			// Check if you're allowed to be here
			if(($_SESSION['permissions'] >= 50) && ($_SESSION['loggedin'] == "1")) {
				echo '<center><h2>Admin Control Panel</h2></center>';
				
				// Show links for admins only
				if($_SESSION['permissions'] == 100) {
					echo '<a href="acpAdd.php">Add Authorized Accounts</a><br />';
					echo '<a href="acpRemove.php">Remove Authorized Accounts</a><br />';
				}
				
				// Show links for faculty
				echo '<a href="acpAnnounce.php">Send Message To Faculty/Administrators</a><br /><br />';
				echo '<center><a href="index.php" class="button">Home</a></center>';
			} else {
				
				// Kicked out
				echo 'You do not have permission to be here!';
				header("location:index.php");
			}
			
		?>
		
	</body>
</html>