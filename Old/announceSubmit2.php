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
		<link rel="stylesheet" href="styles2.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.9"/>
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
							while($array = mysqli_fetch_row($result)) {
								$username = $array[0];
								$query = mysqli_query($conn, "INSERT INTO announcements (id, username, priority, subject, author, announcement) VALUES ('NULL', '$username', '$priority', '$subject', '$author', '$announcement')") or die(mysqli_error($conn));
								
								$getNum = mysqli_query($conn, "SELECT mobile FROM users WHERE username='$username'") or die(mysqli_error($conn));
								$num = mysqli_fetch_row($getNum);
								$mobile = $num[0];
								
								$message = '';
								if($priority == "Urgent") {
									$message = " URGENT announcement from " . $author . " with the subject of: " . $subject;
								} else {
									$message = " You have a new announcement from " . $author . " with the subject of: " . $subject;
								}
									
								mail($mobile, "", $message, "From: admin\r\n");
								
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
	
	