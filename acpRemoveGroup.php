<!-- 
acpRemoveGroup.php
Created by Tom Grossman on 4/05/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Delete Group</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			<h2>Group Control Panel</h2>
			<h3>WARNING: If you delete a parent group, all sub-groups will also be deleted!</h3>
			
			<form method="post" action="deleteGroup.php" name="announceForm" onsubmit="return confirm('Do you really want to delete the selected Group(s)? This action cannot be undone!');">
				<fieldset>
					<p>Group to Delete:</p>
					<select name="group" class="select" size="1">
					
						<?php
			
						//Includes
						include "functions.php";
						include "systemConfiguration.php";
						
							// Get all groups
							$groups = getAllGroups();
							
							// Create an option with every group name 
							foreach($groups as $name) {
								if($name == ".None") {
									echo '<option value="NULL"></option>';
								} else if($name == "allusers" || $name == "faculty") {
									continue;
								} else {
									echo '<option value="'. $name .'">'. $name .'</option>';
								}
							}
							
							mysqli_free_result($groups);
							
						?>
						
					</select>
					
					<br /> <br />
					<input type="submit" name="createGroup" value="Submit" class="buttonForm" />&nbsp;<a href="acp.php" class="buttonForm">Cancel</a>
				</fieldset>
			</form>
		</div>
	</body>
</html>