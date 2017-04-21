<!-- 
acpAdd.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Add Authed Users</title>
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
			if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] >= 50)) {
				echo "You do not have permission to be here!";
				header("location:index.php");
			}
			
		?>
		
		<form method="post" action="authUsers.php">
			<fieldset>
				<center><h2>Add Users to Groups</h2></center>
				<p><center>Which group would you like to add student(s) to?</center></p>
				<div style="display: inline-block; text-align: left">
					<?php
					
						// Get all groups
						$groups = getAllChildrenGroups();
						$sessionUser = $_SESSION['username'];

						// Create an option with every group
						foreach($groups as $name) {
							$sql = "SELECT username FROM facultyViewPermissions WHERE username='$sessionUser' AND groupName='$name'";
							$result = mysqliQuery($sql);
							
							if($_SESSION['permissions'] != 100 && (mysqli_num_rows($result) == 0)) {
								continue;
							}
							
							if($name == ".None" || $name == "allusers"){
								continue;
							}
							
							echo '<input type="radio" name="group" class="radioStyle" value="'. $name .'">'. $name;
							echo '<br />';
						}
						
						mysqli_free_result($groups);
					?>
				<br />
				</div>
				<p>Select users to add to the group</p>
				<select name="users[]" size="20" multiple>
					<?php
						// Get all users
						$users = getAllUsers();
						
						// Create an option with every username 
						foreach($users as $user) {
							echo '<option value="'. $user .'">'. $user .'</option>';
						}
						
						mysqli_free_result($users);
					?> 
				</select> <br /><br />
				<input type="submit" name="submit" value="Submit" class="buttonForm">&nbsp;<a href="acp.php" class="buttonForm">Cancel</a>
			</fieldset>
		</form>
	</body>
</html>
			