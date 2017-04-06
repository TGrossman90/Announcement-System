<!-- 
removeGroup.php
Created by Tom Grossman on 4/05/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Delete Group</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="styles2.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.9"/>
	</head>  
	<body>  
		<div id="main">
		<center><h2>Group Control Panel</h2></center>
		<center><h3>WARNING: If you delete a parent group, all children groups will also be deleted!</h3></center>
		<form method="post" action="deleteGroup.php" name="announceForm" onsubmit="return confirm('Do you really want to delete the selected Group(s)? This action cannot be undone!');">
			<fieldset>
				<p>Group to Delete: <select name="group" size="1" style="width:50%">
					<?php
		
					//Includes
					include "functions.php";
					include "dbcontroller.php";
					
						// Get all groups
						$result = mysqli_query($conn, "SELECT groupName FROM groups") or die(mysqli_error($conn));
					
						$groups = array();
						while($group = mysqli_fetch_row($result)) {
							array_push($groups, $group[0]);
						}
						sort($groups);
						
						// Create an option with every group name 
						foreach($groups as $name) {
							echo '<option value="'. $name .'">'. $name .'</option>';
						}
						
					?>
				</select> </p>
				<input type="submit" name="createGroup" value="Submit" />&nbsp;<a href="acp.php" class="button">Cancel</a>
				
			</fieldset>
		</form>
	</body>
</html>