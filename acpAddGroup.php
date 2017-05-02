<!-- 
acpAddGroup.php
Created by Tom Grossman on 4/05/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Add Group</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			<h2>Group Control Panel</h2>
			<form method="post" action="createGroup.php" name="announceForm">
				<fieldset>
					<p>Parent Group:</p>
					<select name="parent" size="1" class="select">
						<?php
			
						//Includes
						include "functions.php";
						include "systemConfiguration.php";
						
							$groups = getAllGroups();
							
							// Create an option with every username 
							foreach($groups as $name) {
								if($name == ".None") {
									echo '<option value="'. $name .'"></option>';
								} else if($name == "allusers" || $name == "faculty") {
									continue;
								} else {
									echo '<option value="'. $name .'">'. $name .'</option>';
								}
							}
							
							mysqli_free_result($groups);
							
						?>
					</select>

					<p>GroupName:</p> <input type="text" name="groupName"> <br /> <br />
					<input type="submit" name="createGroup" value="Submit" class="buttonForm" />&nbsp;<a href="acp.php" class="buttonForm">Cancel</a>
					
				</fieldset>
			</form>
		</div>
	</body>
</html>