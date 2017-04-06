<!-- 
announceCreate.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Create Announcement</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="styles2.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.9"/>
	</head>  
	<body>  
		<div id="main">
		
		<!-- This form is for creating announcements that can be sent to specific user groups or 
		all users. -->
		
		<form method="post" action="announceSubmit.php" name="announceForm">
			<fieldset>
				<p>Send to Group(s):</p>
				<?php
				
					//Includes
					include "functions.php";
					include "dbcontroller.php";
					
					// Check if you're supposed to be here
					if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] >= 50)) {
						echo "You do not have permission to be here!";
						header("location:index.php");
					}
					
						// Get all groups
						$result = mysqli_query($conn, "SELECT groupName FROM groups") or die(mysqli_error($conn));
					
						$groups = array();
						while($group = mysqli_fetch_row($result)) {
							array_push($groups, $group[0]);
						}
						sort($groups);
						
						// Create an option with every group name 
						foreach($groups as $name) {
							if($name != ".None") {
								echo '<input type="checkbox" name="groups[]" value="'. $name .'">'. $name . '<br />';
							}
						}
						
					?>
				<br />
				<label for="subject">Priority: </label>
				<select name="priority" id="priority">
					<option value="Normal">Normal</option>
					<option value="Urgent">Urgent</option>
				</select> <br /><br />

				<label for="subject">Subject: </label> <input type="text" name="subject" maxlength="31"> <br />
				<p>Announcement (Max: 254 characters):</p>
				<textarea maxlength="254" placeholder="...announcement text goes here..." id="announcement" name="announcement" cols="30" rows="5"></textarea><br />
				Remaining characters: <span id="count"></span><br /><br />
				<input type="submit" name="announceSubmit" value="Submit" />&nbsp;<a href="index.php" class="button">Cancel</a>
			</fieldset>
		</form>
		
		<!-- Javascript to update on screen the number of characters remaining in the textarea -->
		<script>
			var maxchar = 254;
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