<!-- 
removeUsersFrom.php
Created by Tom Grossman on 4/18/17
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Remove User from Group</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			
			<!-- This form is for creating announcements that can be sent to specific user allUsers or 
			all users. -->
			
			<form method="post" action="removeUserFromGroup.php" name="announceForm">
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
						
						if(!empty($_POST['user']) && empty($_POST['group'])) {
							$user = processText($_POST['user']);
							
							$sql = "SELECT username FROM users WHERE username='$user'";
							$result = mysqliQuery($sql);
							
							if(mysqli_num_rows($result) == 0) {
								echo '<p>Could not find that user. Try again!</p>';
								echo '<br /> <br />';
								echo '<a href="acpRemoveUsers.php" class="buttonForm">Go Back</a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
							} else {
								if($user == $globalAdmin) {
									echo '<p>You cannot remove the admin account!</p>';
									echo '<br /> <br />';
									echo '<a href="acpRemoveUsers.php" class="buttonForm">Go Back</a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
								} else {
									echo '<input type="hidden" name="user" value="' . $user . '">';
									
									// Get all groups
									$groups = getAllGroups();
									$grp = array();
									
									foreach($groups as $name) {
										if($name == ".None") {
											continue;
										}
										
										$sql = "SELECT username FROM $name WHERE username='$user'";
										$result = mysqliQuery($sql);
										if(mysqli_num_rows($result) > 0) {
											array_push($grp, $name);
										} 
									}
									
									mysqli_free_result($groups);
									
									if(count($grp) > 0) {	
										echo '<p>Select group(s) to remove ' . $user . ' from:</p>';
										echo '<div style="display: inline-block; text-align: left">';
										foreach($grp as $gp) {
											if($gp == "allusers") {
												continue;
											}
											echo '<input type="checkbox" class="checkStyle" name="groups[]" value="'. $gp .'">' . $gp . '<br />';
										}
										echo '</div>';
										echo '<br /> <br />';
										echo '<input type="submit" name="submit" value="Submit" class="buttonForm">&nbsp;<a href="acpRemoveUsers.php" class="buttonForm">Cancel</a>';
									} else {
										echo '<p>'. $user . ' is not in any groups!</p>';
										echo '<br /> <br />';
										echo '<a href="acpRemoveUsers.php" class="buttonForm">Go Back</a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
									}
								}		
							}	
							mysqli_free_result($result);
							
						} else if(empty($_POST['user']) && !empty($_POST['group'])) {
							$group = processText($_POST['group']);
							echo '<input type="hidden" name="group" value="' . $group . '">';
							
							// Get all users
							$users = getUsersFromGroup($group);
							if(count($users) > 0) {
								
								echo '<p>Select user(s) to remove from ' . $group . '<p>';
								echo '<select name="usersToRemove[]" size="20" multiple>';
								// Create an option with every username 
								foreach($users as $user) {
									echo '<option value="'. $user .'">'. $user .'</option>';
								}
								
								mysqli_free_result($users);
								
								echo '<br /> <br />';
								echo '<input type="submit" name="submit" value="Submit" class="buttonForm">&nbsp;<a href="acp.php" class="buttonForm">Cancel</a>';
							} else {
								echo '<p>'. $group .' does not have any members!</p>';
								echo '<a href="acpRemoveUsers.php" class="buttonForm">Go Back</a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
							}
													
						} else if(empty($_POST['user']) && empty($_POST['group'])) {
							echo '<p>You have to either search for a user or select a group!</p>';
							echo '<br /> <br />';
							echo '<a href="acpRemoveUsers.php" class="buttonForm">Go Back</a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
						} else {
							echo '<p>You can either search for a user or select a group. Not both at the same time!</p>';
							echo '<br /> <br />';
							echo '<a href="acpRemoveUsers.php" class="buttonForm">Go Back</a> &nbsp; <a href="acp.php" class="buttonForm">Admin CP</a>';
						}
					?>
				</fieldset>
			</form>
		</div>
	</body>
</html>