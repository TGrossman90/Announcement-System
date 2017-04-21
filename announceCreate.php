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
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
		<img src="/img/umslmusic_logo.png" id="logo" />
		
		<!-- This form is for creating announcements that can be sent to specific user groups or 
		all users. -->
		
		<form method="post" action="announceSubmit.php" name="announceForm">
			<fieldset>
			<div >
				<div style="display: inline-block; text-align: left">
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
						$groups = getAllGroups();
						
						// Create an option with every group name 
						foreach($groups as $name) {
							if($name != ".None") {
								echo '<input type="checkbox" class="checkStyle" name="groups[]" value="'. $name .'">' . $name . '<br />';
							}
						}
						
						mysqli_free_result($groups);
						
					?>
				</div>

				<br /><br />
				<p>Subject:</p> 
				<input type="text" name="subject" maxlength="45" placeholder="Subject line"> <br />
				<p>Announcement:</p>
				<textarea maxlength="20000" placeholder="Type an announcement here!" id="announcement" name="announcement" cols="30" rows="15"></textarea><br />
				Remaining characters: <span id="count"></span><br /><br />
				<input type="submit" name="announceSubmit" value="Submit" class="buttonForm"/>&nbsp;<a href="index.php" class="buttonForm">Cancel</a>
			</fieldset>
		</form>
		
		<!-- Javascript to update on screen the number of characters remaining in the textarea -->
		<script>
			var maxchar = 20000;
			var box = document.getElementById("announcement");
			var counter = document.getElementById("count");
			counter.innerHTML = maxchar;

			box.addEventListener("keydown", count);

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