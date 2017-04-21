<!-- 
deauthUsers.php
Created by Tom Grossman on 3/27/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Deauthorize Student Accounts</title>
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
			
			// Make sure you are supposed to be here
			if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] == 100)) {
				echo "You do not have permission to be here!";
				header("location:index.php");
			} 
			
			// Get all groups
			
			$groups = getAllGroups();
			
			// For every user that is to be removed check for that user in every group.
			// If found, remove that user from the group. 
			foreach($_POST['usersToRemove'] as $user) {
				if($user == "admin") {
					echo '<p>You cannot delete the admin account! Skipping...</p>';
					continue;
				}
				
				foreach($groups as $grp) {
					if($grp == ".None") {
						continue;
					}
					
					$sql = "SELECT id FROM $grp WHERE userName='$user'";
					$result = mysqliQuery($sql);
					if(mysqli_num_rows($result) > 0) {
						$iden = mysqli_fetch_row($result);
						$id = $iden[0];
						
						$sql = "DELETE FROM $grp WHERE id='$id'";
						$delete = mysqliQuery($sql);
						mysqli_free_result($sql);
						echo "Removed $user from $grp <br />";
					}
				}
				
				mysqli_free_result($groups);
				
				$sql = "DELETE FROM announcements WHERE username='$user'";
				$result = mysqliQuery($sql);
				$sql = "DELETE FROM users WHERE username='$user'";
				$result = mysqliQuery($sql);
				echo "Deleted account with username: $user";
				
				mysqli_free_result($result);
			}
			
			
			echo '<br /><center><a href="index.php" class="buttonForm">Home</a>&nbsp;';
			echo '<a href="acp.php" class="buttonForm">Admin CP</a>';
			
		?>
		
	</body>
</html>