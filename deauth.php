<!-- 
deauth.php
Created by Tom Grossman on 3/27/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Deauthorize Student Accounts</title>
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
			
			// Make sure you are supposed to be here
			if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] == 100)) {
				echo "You do not have permission to be here!";
				header("location:index.php");
			} 
			
			// Get all groups
			$result = mysqli_query($conn, "SELECT groupName FROM groups") or die(mysqli_error($conn));
			$groups = array();
			while($group = mysqli_fetch_row($result)) {
				array_push($groups, $group[0]);
			}
			
			// For every user that is to be removed check for that user in every group.
			// If found, remove that user from the group. 
			foreach($_POST['usersToRemove'] as $user) {
				foreach($groups as $grp) {
					if($grp == ".None") {
						continue;
					}
					
					$result2 = mysqli_query($conn, "SELECT id FROM $grp WHERE userName='$user'") or die(mysqli_error($conn));
					if(mysqli_num_rows($result2) > 0) {
						$iden = mysqli_fetch_row($result2);
						$id = $iden[0];
						$delete = mysqli_query($conn, "DELETE FROM $grp WHERE id='$id'") or die(mysqli_error($conn));
						echo "Removed $user from $grp <br />";
					}
				}
					
				$result = mysqli_query($conn, "DELETE FROM users WHERE username='$user'") or die(mysqli_error($conn));
				echo "Deleted account with username: $user";
			}
			
			
			echo '<br /><center><a href="index.php" class="button">Home</a>&nbsp;';
			echo '<a href="acp.php" class="button">Admin CP</a>';
			
		?>
		
	</body>
</html>