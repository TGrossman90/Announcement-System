<!-- 
resetSystem.php
Created by Tom Grossman on 4/20/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Reset System</title>
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
				if(!empty($_POST['resetOption'])) {
					$resetOption = processText($_POST['resetOption']);
					$result = "";
					
					if($resetOption == "resetSemester") {
						$sql = "DELETE FROM announcements";
						$result = mysqliQuery($sql);
						
						echo '<p>Successfully deleted all announcements from the system!</p>';
						echo '<a href="index.php" class="buttonForm">Home</a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
					} else if($resetOption == "resetYear") {
						
						$sql = "DELETE FROM announcements";
						$result = mysqliQuery($sql);
						$sql = "SELECT username FROM users WHERE userLevel='10'";
						$result = mysqliQuery($sql);
						
						while($username = mysqli_fetch_row($result)) {
							$user = $username[0];
							$groups = getAllGroups();
							
							foreach($groups as $group) {
								if($group == ".None") {
									continue;
								}
								$delete = mysqli_query($conn, "DELETE FROM $group WHERE username='$user'") or die(mysqli_error($conn));
							}
							
							mysqli_free_result($groups);
							
							$sql = "DELETE FROM users WHERE username='$user'";
							$deleteUser = mysqliQuery($sql);
							mysqli_free_result($deleteUser);
						}
						
						echo '<p>Successfully reset the system for the new year!</p>';
						echo '<a href="index.php" class="buttonForm">Home</a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
					} else {
						header("location:index.php");
					}
					
					mysqli_free_result($result);
				}
			}
		?>
		
	</body>
</html>