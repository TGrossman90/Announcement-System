<!-- 
announceSubmit.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Submit Announcement</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>  
	<body>  
		<div id="main">
		
		<?php
		
			// Includes
			include "functions.php";
			include "dbcontroller.php";
			
			// Make sure things POST correctly
			if(!empty($_POST['groups'])) {
				if(!empty($_POST['subject'])) {
					if(!empty($_POST['announcement'])) {
						$groups = $_POST['groups'];
						$subject = processText($_POST['subject']);
						$author = processText($_SESSION['username']);
						$announcement = processText($_POST['announcement']);
						$priority = processText($_POST['priority']);

						// For every group the announcement is sent to
						// retrieve all usernames and create announcements for them
						foreach($groups as $group) {	
						
							$result = mysqli_query($conn, "SELECT username FROM $group") or die(mysqli_error($conn));
							while(($array = mysqli_fetch_array($result, MYSQLI_NUM))) {
								$username = $array[0];
								$query = mysqli_query($conn, "INSERT INTO announcements (id, username, priority, subject, author, announcement) VALUES ('NULL', '$username', '$priority', '$subject', '$author', '$announcement')") or die(mysqli_error($conn));
							}
						}
						
						echo '<center>Announcement sent successfully!</center><br />';
						echo '<br /><center><a href="announceCreate.php" class="button">Send Another</a>';
						echo '<br /><center><a href="index.php" class="button">Home</a></center>';
						
					} else {
						echo "There was a problem with posting the announcement";
					}
					
				} else {
					echo "There was a problem with getting the subject";
				}
				
			} else {
				echo "There was a problem with retrieving the groups";
			}
			
		?>
		
	</body>
</html>
	
	