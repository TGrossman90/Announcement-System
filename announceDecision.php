<!-- 
announceDecision.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
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
			
			// Get variables from the submitted form
			$decision = processText($_GET['decision']);
			$id = processText($_GET['id']);
			$username = processText($_SESSION['username']);
			
			// Retrieve ID associated with the username
			$result = mysqli_query($conn, "SELECT username FROM announcements WHERE id='$id'") or die(mysqli_error($conn));
			$idd = mysqli_fetch_row($result);
			mysqli_free_result($result);
			
			// Make sure that the username logged in and the username attached to the announcement are the same
			if($_SESSION['username'] != $idd[0]) {
				echo 'Error: You do not have permission to be here!';
				header("location:announceInbox.php");
				
			} else {

				// If the user wants to delete the announcement, run a query on the database to do so.
				// If they want to save it, do nothing
				if($decision == 'delete') {
					$result = mysqli_query($conn, "DELETE FROM announcements WHERE id='$id' AND username='$username'") or die(mysqli_error($conn));
					mysqli_free_result($result);
					//sleep(2);
					header("location:announceInbox.php");
				} 
				
				if($decision == "save") {
					//sleep(2);
					header("location:announceInbox.php");
				}
			}
			
		?>
		
	</body>
</html>