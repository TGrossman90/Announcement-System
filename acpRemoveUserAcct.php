<!-- 
acpRemoveUserAcct.php
Created by Tom Grossman on 3/27/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Remove Authed Users</title>
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
		
		<!-- This form is for deauthorizing student accounts. It will populate a drop-down list 
		that allows multiple selections with all of the student accounts in the database.
		The other form does the exact same thing except for faculty/admin accounts. -->
		
		<center><h2>Delete Users</h2>
		<h3>WARNING: This will permanently delete selected accounts!</h3></center>
		<form method="post" action="deauthUsers.php" name="deauthStudents" onsubmit="return confirm('Do you really want to delete the selected users? This action cannot be undone!');">
			<fieldset>
			<select name="usersToRemove[]" size="20" multiple>
			
			<?php
			
				//Get all student usernames
				$users = getAllUsers();
				
				// Create an option with every username 
				foreach($users as $user) {
					if($user == "admin") {
						continue;
					}
					echo '<option value="'. $user .'">'. $user .'</option>';
				}
				
				mysqli_free_result($users);
				
			?>
			
			</select> <br /> <br />
				<input type="submit" name="deauthedStudentSubmit" value="Submit" class="buttonForm"  />&nbsp;<a href="acp.php" class="buttonForm">Cancel</a>
			</fieldset>
		</form>
	</body>
</html>
			