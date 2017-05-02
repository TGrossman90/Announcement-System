<!-- 
deauthStaff.php
Created by Tom Grossman on 4/20/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Remove Staff Accounts</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">	
			<img src="/img/umslmusic_logo.png" id="logo" />	<br />
			
			<?php	

				// Includes
				include "functions.php";
				include "systemConfiguration.php";
				
				// Check if you're supposed to be here
				if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] == 100)) {
					echo "You do not have permission to be here!";
					header("location:index.php");
				}
				
				if(!empty($_POST['action'])) {
					$action = processText($_POST['action']);
					
					if(!empty($_POST['user']) && ($_POST['user'] != "NULL")) {
						$user = processText($_POST['user']);
						
						if($action == "remove") {
							$sql = "DELETE FROM faculty WHERE username='$user'";
							$result = mysqliQuery($sql);
							$sql = "DELETE FROM facultyViewPermissions WHERE username='$user'";
							$result = mysqliQuery($sql);
							$sql = "UPDATE users SET userLevel='10' WHERE username='$user'";
							$result = mysqliQuery($sql);
							
							mysqli_free_result($result);
							
							echo '<p>Finished removing ' . $user .'\'s permissions</p>';
							echo '<a href="acpDeauthStaff.php" class="buttonForm"> Go Back </a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
						} else if($action == "delete") {
							
							$sql = "DELETE FROM facultyViewPermissions WHERE username='$user'";
							$result = mysqliQuery($sql);
							$sql = "DELETE FROM users WHERE username='$user'";
							$result = mysqliQuery($sql);
							$sql = "DELETE FROM announcements WHERE username='$user'";
							$result = mysqliQuery($sql);
							
							mysqli_free_result($result);
							
							// Get all groups
							$groups = getAllGroups();
							
							foreach($groups as $name) {
								if($name == ".None") {
									continue;
								}
								$sql = "DELETE FROM $name WHERE username='$user'";
								$result = mysqliQuery($sql);
								mysqli_free_result($result);
							}
							
							mysqli_free_result($groups);
							echo '<p>Finished deleting ' . $user .'\'s account</p>';
							echo '<a href="acpDeauthStaff.php" class="buttonForm"> Go Back </a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
						}
							
					} else {
						echo '<p>You have to select a user!</p>';
						echo '<a href="acpDeauthStaff.php" class="buttonForm"> Go Back </a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
					}
					
				} else {
					echo '<p>You have to select an action to take!</p>';
					echo '<a href="acpDeauthStaff.php" class="buttonForm"> Go Back </a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
				}	

			?>	

		</div>
	</body>
</html>