<!-- 
deleteGroup.php
Created by Tom Grossman on 4/05/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Deleting Group(s)...</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			
			<?php	
			
				// Includes
				include "functions.php";
				include "systemConfiguration.php";
				
				$groupName = processText($_POST['group']);
				
				if($groupName != "NULL" || $groupName == "allusers") {
					removeGroup($groupName);
				} else {
					echo '<p>You must select a table to delete!</p>';
				}

				echo '<br /><a href="index.php" class="buttonForm">Home</a>&nbsp;';
				echo '<a href="acpRemoveGroup.php" class="buttonForm">Delete Group</a>&nbsp;';
				echo '<a href="acp.php" class="buttonForm">Admin CP</a>';
				
			?>
		
		</div>
	</body>
</html>