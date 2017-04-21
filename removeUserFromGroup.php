<!-- 
removeUserFromGroup.php
Created by Tom Grossman on 4/18/2017
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
			if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] >= 50)) {
				echo "You do not have permission to be here!";
				header("location:index.php");
			} 
			
			if(!empty($_POST['user']) && empty($_POST['usersToRemove'])) {
				$user = processText($_POST['user']);
				
				if(!empty($_POST['groups'])) {
					foreach($_POST['groups'] as $group) {
						if($group == ".None" || $group == "allusers") {
							continue;
						}
						
						$sql = "SELECT id FROM $group WHERE userName='$user'";
						$result = mysqliQuery($sql);
						
						if(mysqli_num_rows($result) > 0) {
							$iden = mysqli_fetch_row($result);
							$id = $iden[0];
							$sql = "DELETE FROM $group WHERE id='$id'";
							$result = mysqliQuery($sql);
							
							echo "Removed $user from $group <br />";
						}
						
						mysqli_free_result($result);
					}
					
					echo '<br /><a href="index.php" class="buttonForm">Home</a>&nbsp;<a href="acp.php" class="buttonForm">Admin CP</a>';
				} else {
					echo 'You have to select at least one group to remove a user from!';
					echo '<br /> <br />';
					echo '<a href="acpRemoveUsers.php" class="buttonForm">Go Back</a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
				}
				
			} else if(empty($_POST['user']) && !empty($_POST['usersToRemove'])) {
				if(!empty($_POST['group'])) {
		
					$group = $_POST['group'];
					foreach($_POST['usersToRemove'] as $user) {
						$sql = "SELECT id FROM $group WHERE userName='$user'";
						$result = mysqliQuery($sql);
						
						if(mysqli_num_rows($result) > 0) {
							$iden = mysqli_fetch_row($result);
							$id = $iden[0];
							$sql = "DELETE FROM $group WHERE id='$id'";
							$result = mysqliQuery($sql);
							
							echo "Removed $user from $group <br />";
						}
					}
					
					echo '<br /><a href="index.php" class="buttonForm">Home</a>&nbsp;<a href="acp.php" class="buttonForm">Admin CP</a>';
				}					
			} else {
				echo 'There was an error. Please try again!';
				echo '<br /> <br />';
				echo '<a href="acpRemoveUsers.php" class="buttonForm">Go Back</a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a> &nbsp; <a href="acpRemoveUsers.php" class="buttonForm">Remove Another</a>';
			}
			
		?>
		
	</body>
</html>