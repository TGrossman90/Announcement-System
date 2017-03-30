<!-- 
acpAdd.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Add Authed Users</title>
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
			
			// Check if you're supposed to be here
			if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] == 100)) {
				echo "You do not have permission to be here!";
				header("location:index.php");
			}
			
		?>
		
		<!-- This is the form for authorizing emails to register 
		accounts on the site. There are two different forms -- one for 
		adding student accounts and placing them in their correct groups,
		and one for adding staff accounts with different permissions. -->
		
		<form method="post" action="authStudents.php" name="authUsers">
			<fieldset>
				<center><h2>Authorize Student Users Form</h2></center>
				<p>Which group would you like to add student(s) too?</p>
				<input type="radio" name="group" value="windsPercussionGroup"> Winds/Percussion <br />
				<input type="radio" name="group" value="stringGroup"> Strings <br />
				<input type="radio" name="group" value="vocalGroup"> Vocal <br />
				<input type="radio" name="group" value="musicEdGroup"> Music Ed <br />
				<p>Please enter student(s) UMSL E-Mail addresses. NOTE: Seperate all emails by commas</p>
				<textarea placeholder="sso1@mail.umsl.edu, sso2@mail.umsl.edu, sso3@mail.umsl.edu, sso4@mail.umsl.edu, sso5@mail.umsl.edu" id="students" name="students" cols="25" rows="5"></textarea><br />
				<input type="submit" name="authedStudentSubmit" value="Submit" />&nbsp;<a href="acp.php" class="button">Cancel</a>
			</fieldset>
		</form>
		
		<form method="post" action="authFacAdmin.php" name="authFacAdmin">
			<fieldset>
				<center><h2>Authorize Faculty/Administrator Users Form</h2></center>
				<p>Which permission group would you like to add user(s) to?</p>
				<input type="radio" name="group" value="admin"> Administrator <br />
				<input type="radio" name="group" value="faculty"> Faculty <br />
				<p>Please enter only UMSL E-Mail addresses. NOTE: Seperate all emails by commas</p>
				<textarea placeholder="user1@umsl.edu, user2@umsl.edu, user3@umsl.edu, user4@umsl.edu, user5@umsl.edu" id="facultyAdmin" name="facultyAdmin" cols="25" rows="5"></textarea><br />
				<input type="submit" name="authedFacAdminSubmit" value="Submit" />&nbsp;<a href="acp.php" class="button">Cancel</a>
			</fieldset>
		</form>
	</body>
</html>
			