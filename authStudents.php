<!-- 
authStudents.php
Created by Tom Grossman on 3/26/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Adding Users</title>
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
			
			// Make sure things posted correctly
			if(!empty($_POST['group'])) {
				if(!empty($_POST['users'])) {
					$group = $_POST['group'];
					$students = array();
					$students = $_POST['users'];	
					
					foreach($students as $user) {
						// Insert email into a database that will allow that user to register an account and into their specified group
						$result = mysqli_query($conn, "INSERT INTO $group (id, username) VALUES ('NULL', '$user')") or die(mysqli_error($conn));
					}
				}
					
				} else {
					header("location:acpAdd.php");
				}

			echo '<br /><center><h3>Finished</h3></center>';
			echo '<center><a href="acp.php" class="button">Go Back</a></center>';
			
		?>
		
	</body>
</html>