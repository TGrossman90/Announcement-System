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
		<link rel="stylesheet" href="styles2.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.9"/>
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
		
		<!-- This is the form for authorizing emails to register 
		accounts on the site. There are two different forms -- one for 
		adding student accounts and placing them in their correct groups,
		and one for adding staff accounts with different permissions. -->
		
		
		<form method="post" action="authStudents.php">
			<fieldset>
				<center><h2>Authorize Student Users Form</h2></center>
				<p>Which group would you like to add student(s) too?</p>
					<?php
					
						// Get all groups
						$result = mysqli_query($conn, "SELECT groupName FROM groups") or die(mysqli_error($conn));
					
						$groups = array();
						while($group = mysqli_fetch_row($result)) {
							array_push($groups, $group[0]);
						}
						sort($groups);
						
						// Create an option with every username 
						foreach($groups as $name) {
							if($name == ".None"){
								continue;
							}
							
							echo '<input type="radio" name="group" value="'. $name .'">'. $name;
							echo '<br />';
						}
						
					?>
				<br />
				<p>Select users to add to the group</p>
				<select name="users[]" size="10" style="width:75%" multiple>
					<?php
						// Get all groups
						$result = mysqli_query($conn, "SELECT username FROM users") or die(mysqli_error($conn));
					
						$groups = array();
						while($group = mysqli_fetch_row($result)) {
							array_push($groups, $group[0]);
						}
						sort($groups);
						
						// Create an option with every username 
						foreach($groups as $name) {
							echo '<option value="'. $name .'">'. $name .'</option>';
						}
					?> 
				</select> <br />
				<input type="submit" name="submit" value="Submit">&nbsp;<a href="acp.php" class="button">Cancel</a>
			</fieldset>
		</form>
	</body>
</html>
			