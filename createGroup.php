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
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
		<img src="/img/umslmusic_logo.png" id="logo" />
		
		<?php	
		
			// Includes
			include "functions.php";
			include "dbcontroller.php";
			
			$parentGroup = $_POST['parent'];			
			$groupName = processText($_POST['groupName']);
			$groupName = str_replace(" ", "", $groupName);
			$groupName = strtolower($groupName);
			
			$checkForDupes = mysqli_query($conn, "SELECT groupName FROM groups WHERE groupName='$groupName'") or die(mysqli_error($conn));
			
			if(mysqli_num_rows($checkForDupes) == 0) {
			
				$query = "CREATE TABLE IF NOT EXISTS $groupName (
					`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
					`userName` varchar(32) NOT NULL
					)";
					
				$result = mysqliQuery($query);
				mysqli_free_result($result);
				
				if($parentGroup == ".None") {
					$sql = "INSERT INTO groups (groupName) VALUES ('$groupName')";
					$insert = mysqliQuery($sql);
					mysqli_free_result($insert);
				} else {
					$sql = "INSERT INTO groups (groupName, groupParent) VALUES ('$groupName', '$parentGroup')";
					$insert = mysqliQuery($sql);
					mysqli_free_result($insert);
				}
				
				echo $groupName . " was created successfully!<br />";
			} else {
				echo "There is already a group named " . $groupName ."! <br />";
			}
				
			echo '<br /><center><a href="index.php" class="buttonForm">Home</a>&nbsp;';
			echo '<a href="acpAddGroup.php" class="buttonForm">Add Group</a>&nbsp;';
			echo '<a href="acp.php" class="buttonForm">Admin CP</a></center>';
			
		?>
		
	</body>
</html>