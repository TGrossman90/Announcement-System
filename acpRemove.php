<!-- 
acpRemove.php
Created by Tom Grossman on 3/27/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Add Authed Users</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>  
	<body>  
		<div id="main">
		
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
		
		<center><h2>Deauthorize Student Users Form</h2>
		<h3>WARNING: This will permanently delete selected accounts!</h3></center>
		<form method="post" action="deauth.php" name="deauthStudents" onsubmit="return confirm('Do you really want to submit the form for the selected users? This action cannot be undone!');">
			<fieldset>
			<select name="usersToRemove[]" size="20" style="width:95%" multiple>
			
			<?php
			
				//Get all student usernames
				$students = mysqli_query($conn, "SELECT username FROM studentUsers") or die(mysqli_error($conn));
			
				$studentUsers = array();
				while($result = mysqli_fetch_row($students)) {
					array_push($studentUsers, $result[0]);
				}
				sort($studentUsers);
				
				// Create an option with every username 
				foreach($studentUsers as $user) {
					echo '<option value="'. $user .'">'. $user .'</option>';
				}
				
			?>
			
			</select> <br />
				<input type="submit" name="deauthedStudentSubmit" value="Submit"  />&nbsp;<a href="acp.php" class="button">Cancel</a>
			</fieldset>
		</form>
		
		<br /><br />
		
		<center><h2>Deauthorize Faculty/Admin Users Form</h2>
		<h3>WARNING: This will permanently delete selected accounts!</h3></center>
		<form method="post" action="deauth.php" name="deauthFacAdmin" onsubmit="return confirm('Do you really want to submit the form for the selected users? This action cannot be undone!');">
			<fieldset>
			<select name="usersToRemove[]" size="20" style="width:95%" multiple>
			
			<?php
			
				// Get all the faculty/admin usernames
				$facAdmin = mysqli_query($conn, "SELECT username FROM facAdminUsers") or die(mysqli_error($conn));
				
				$facAdminUsers = array();
				while($result = mysqli_fetch_row($facAdmin)) {
					array_push($facAdminUsers, $result[0]);
				}
				sort($facAdminUsers);
				
				// Create an option with every username
				foreach($facAdminUsers as $user) {
					echo '<option value="'.$user.'">'.$user.'</option>';
				}
				
			?>
			
			</select><br />
				<input type="submit" name="authedFacAdminSubmit" value="Submit"  />&nbsp;<a href="acp.php" class="button">Cancel</a>
			</fieldset>
		</form>
	</body>
</html>
			