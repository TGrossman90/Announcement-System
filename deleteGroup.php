<!-- 
deleteGroup.php
Created by Tom Grossman on 4/05/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Deleting Group(s)...</title>
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
			
			$groupName = processText($_POST['group']);
			
			if($groupName != ".None") {
				removeGroup($groupName);
			} else {
				echo "You cannot delete this table! <br />";
			}

			echo '<br /><br /><center><a href="index.php" class="button">Home</a>&nbsp;';
			echo '<a href="removeGroup.php" class="button">Delete Group</a>&nbsp;';
			echo '<a href="acp.php" class="button">Admin CP</a></center>';
			
		?>
		
	</body>
</html>