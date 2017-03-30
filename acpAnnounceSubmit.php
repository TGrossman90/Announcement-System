<!-- 
acpAnnounceSubmit.php
Created by Tom Grossman on 3/28/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Submit Announcement</title>
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
			
			// Make sure things post properly
			if(!empty($_POST['subject'])) {
				if(!empty($_POST['announcement'])) {
					$subject = processText($_POST['subject']);
					$author = processText($_SESSION['username']);
					$announcement = processText($_POST['announcement']);

					// Get all usernames that are faculty/admin accounts
					// and create announcement entries for them
					$result = mysqli_query($conn, "SELECT username FROM facAdminUsers") or die(mysqli_error($conn));
					while($array = mysqli_fetch_row($result)) {
						$username = $array[0];
						$query = mysqli_query($conn, "INSERT INTO announcements (id, username, priority, subject, author, announcement) VALUES ('NULL', '$username', 'Staff', '$subject', '$author', '$announcement')") or die(mysqli_error($conn));
					}
					
					echo '<center>Announcement sent successfully!</center><br />';
					echo '<br /><center><a href="acpAnnounce.php" class="button">Send Another</a>';
					echo '<br /><center><a href="index.php" class="button">Home</a></center>';
					
				} else {
					echo "There was a problem with posting the announcement";
				}
				
			} else {
				echo "There was a problem with getting the subject";
			}
			
		?>
	</body>
</html>