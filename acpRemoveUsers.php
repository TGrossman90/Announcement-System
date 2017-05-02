<!-- 
acpRemoveUsers.php
Created by Tom Grossman on 4/18/17
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Remove User from Group</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			
			<form method="post" action="removeUserFrom.php" name="announceForm">
				<fieldset>
					
					<?php
					
						//Includes
						include "functions.php";
						include "systemConfiguration.php";
						
						// Check if you're supposed to be here
						if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] >= 50)) {
							echo "You do not have permission to be here!";
							header("location:index.php");
						}

						// Get all users
						$users = getAllUsers();
					?>
					
					<script>
						$( function() {
							var users = <?php echo json_encode($users); ?>;
							$( "#searchUsers" ).autocomplete({
								source: users
							});
						} );
					</script>	
					
					<?php 
						if($_SESSION['permissions'] == 100) {
							mysqli_free_result($users);
					?>
					
					<p>Search for a User</p>
					<div class="ui-widget">
						<input type="text" id="searchUsers" name="user">
					</div>
					<br /><h3>OR</h3>
					
					<?php
						} 

						echo '<div style="display: inline-block; text-align: left">';
						if($_SESSION['permissions'] >= 50) {
							echo '<p>Select a group to view all members</p>';
							
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
						}
					?>
							
					
					<br /> <br />
					<input type="submit" name="submit" value="Submit" class="buttonForm">&nbsp;<a href="acp.php" class="buttonForm">Cancel</a>
				</fieldset>
			</form>
		</div>
	</body>
</html>