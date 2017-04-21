<!-- 
acpRemove.php
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
		
		<center><h2>Remove Users from Groups</h2>
		<h3>WARNING: This will permanently delete selected accounts!</h3></center>
		<form method="post" action="deauth.php" name="deauthStudents" onsubmit="return confirm('Do you really want to submit the form for the selected users? This action cannot be undone!');">
			<fieldset>
			<select name="usersToRemove[]" size="20" multiple>
			
			<?php
			
				//Get all student usernames
				$users = mysqli_query($conn, "SELECT username FROM users") or die(mysqli_error($conn));
			
				$usersArry = array();
				while($result = mysqli_fetch_row($users)) {
					array_push($usersArry, $result[0]);
				}
				sort($usersArry);
				
				// Create an option with every username 
				foreach($usersArry as $user) {
					echo '<option value="'. $user .'">'. $user .'</option>';
				}
				
			?>
			
			</select> <br /> <br />
				<input type="submit" name="deauthedStudentSubmit" value="Submit" class="buttonForm"  />&nbsp;<a href="acp.php" class="buttonForm">Cancel</a>
			</fieldset>
		</form>
	</body>
</html>
			