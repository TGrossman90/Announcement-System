<!-- 
acpAnnounce.php
Created by Tom Grossman on 3/28/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Create Announcement</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>  
	<body>  
		<div id="main">
		
		<?php
		
			// Includes
			include "functions.php";
			include "dbcontroller.php";
			
			// Check if you're supposed to be here
			if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] >= 50)) {
				echo "You do not have permission to be here!";
				sleep(1);
				header("location:index.php");
			}
			
		?>
		
		<!-- This form is for sending announcements to only faculty/administration accounts -->
		
		<form method="post" action="acpAnnounceSubmit.php" name="acpAnnounceForm">
			<fieldset>
				<p>Send to Faculty and Administrators:</p>
				<label for="subject">Subject: </label> <input type="text" name="subject" maxlength="31"> <br />
				<p>Announcement (Max: 254 characters):</p>
				<textarea maxlength="254" placeholder="...announcement text goes here..." id="announcement" name="announcement" cols="40" rows="5"></textarea><br />
				Remaining characters: <span id="count"></span><br /><br />
				<input type="submit" name="acpAnnounceSubmit" value="Submit" />&nbsp;<a href="acp.php" class="button">Cancel</a>
			</fieldset>
		</form>
		
		<!-- Javascript to update on screen the number of characters remaining in the textarea -->
		
		<script>
			var maxchar = 255;
			var box = document.getElementById("announcement");
			var counter = document.getElementById("count");
			counter.innerHTML = maxchar;

			box.addEventListener("keydown",count);

			function count(e){
				var len =  box.value.length;
				if (len >= maxchar){
				   e.preventDefault();
				} else{
				   counter.innerHTML = maxchar - len-1;   
				}
			}
		</script>
		
		</body>
	</head>
</html>