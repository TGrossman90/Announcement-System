<!-- 
authUsers.php
Created by Tom Grossman on 3/26/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Adding Users</title>
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
				
				// Make sure things posted correctly
				if(!empty($_POST['group'])) {
					if(!empty($_POST['users'])) {
						$group = $_POST['group'];
						$students = array();
						$students = $_POST['users'];	
						
						foreach($students as $user) {
							$sql = "SELECT username FROM $group WHERE username='$user'";
							$result = mysqliQuery($sql);
							
							if(mysqli_num_rows($result) == 0) {
								$sql = "INSERT INTO $group (id, username) VALUES ('NULL', '$user')";
								$result = mysqliQuery($sql);
								echo '<center><p>Added ' . $user . ' into ' . $group . ' </p></center>';
								
							} else {
								echo '<p>'. $user .' is already a member of ' . $group .'</p>';
							}
							
							mysqli_free_result($result);
						}
					}
						
					} else {
						header("location:acpAdd.php");
					}

				echo '<br /><h3>Finished</h3>';
				echo '<a href="acp.php" class="buttonForm">Go Back</a> &nbsp; <a href="acpAdd.php" class="buttonForm">Add Another</a>';
				
			?>
			
		</div>	
	</body>
</html>