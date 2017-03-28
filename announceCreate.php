<!-- 
announceCreate.php
Created by Tom Grossman on 3/25/2017
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
		
		<!-- This form is for creating announcements that can be sent to specific user groups or 
		all users. -->
		
		<form method="post" action="announceSubmit.php" name="announceForm">
			<fieldset>
				<p>Send to Group(s):</p>
				<input type="checkbox" name="groups[]" value="windsPercussionGroup"> Winds/Percussion <br />
				<input type="checkbox" name="groups[]" value="vocalGroup"> Vocal <br />
				<input type="checkbox" name="groups[]" value="stringGroup"> Strings <br />
				<input type="checkbox" name="groups[]" value="musicEdGroup"> Music Ed <br />
				<input type="checkbox" name="groups[]" value="departmentWideGroup"> All <br /> <br />
				<label for="subject">Priority: </label>
				<select name="priority" id="priority">
					<option value="Normal">Normal</option>
					<option value="Urgent">Urgent</option>
				</select> <br /><br />
				<label for="subject">Subject: </label> <input type="text" name="subject" maxlength="31"> <br />
				<p>Announcement (Max: 254 characters):</p>
				<textarea maxlength="254" placeholder="...announcement text goes here..." id="announcement" name="announcement" cols="40" rows="5"></textarea><br />
				Remaining characters: <span id="count"></span><br /><br />
				<input type="submit" name="announceSubmit" value="Submit" />&nbsp;<a href="index.php" class="button">Cancel</a>
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