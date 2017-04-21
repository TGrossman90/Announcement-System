<!-- 
announceDecision.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
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
			
			// Get variables from the submitted form
			$decision = processText($_GET['decision']);
			$id = processText($_GET['id']);
			$username = processText($_SESSION['username']);
			
			// Retrieve ID associated with the username
			$sql = "SELECT username FROM announcements WHERE hashkey='$id'";
			$result = mysqliQuery($sql);
			
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
					$sql = "DELETE FROM announcements WHERE hashkey='$id' AND username='$username'";
					$result = mysqliQuery($sql);
					
					mysqli_free_result($result);
					header("location:announceInbox.php");
				} 
				
				if($decision == "save") {
					mysqli_free_result($result);
					header("location:announceInbox.php");
				}
			}
			
			mysqli_free_result($result);
			
		?>
		
	</body>
</html>