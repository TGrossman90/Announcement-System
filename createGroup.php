<!-- 
createGroup.php
Created by Tom Grossman on 4/05/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Creating Group...</title>
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
			
			$parentGroup = $_POST['parent'];			
			$groupName = processText($_POST['groupName']);
			
			$checkForDupes = mysqli_query($conn, "SELECT groupName FROM groups WHERE groupName='$groupName'") or die(mysqli_error($conn));
			
			if(mysqli_num_rows($checkForDupes) == 0) {
			
				$query = "CREATE TABLE IF NOT EXISTS $groupName (
					`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					`userName` varchar(32) NOT NULL
					)";
					
				$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
				
				if($parentGroup == ".None") {
					$insert = mysqli_query($conn, "INSERT INTO groups (groupName) VALUES ('$groupName')") or die(mysqli_error($conn));
				} else {
					$insert = mysqli_query($conn, "INSERT INTO groups (groupName, groupParent) VALUES ('$groupName', '$parentGroup')") or die(mysqli_error($conn));
				}
				
				echo $groupName . " was created successfully!<br />";
			} else {
				echo "There is already a group named " . $groupName ."! <br />";
			}
				
			echo '<br /><center><a href="index.php" class="button">Home</a>&nbsp;';
			echo '<a href="addGroup.php" class="button">Add Group</a>&nbsp;';
			echo '<a href="acp.php" class="button">Admin CP</a></center>';
			
		?>
		
	</body>
</html>