<!-- 
announceInbox.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Inbox</title>
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
			
			// Begin the structure of the inbox
			echo '<h2><center>Inbox</center></h2>';
			echo '
				<table style="margin: 0 auto;">
					<tr>
						<th align="center">Sender</th>
						<th align="center">Subject</th>
						<th align="center">Date/Time</th>
					</tr>';
			
			// Get the relevant info to populate the inbox 
			$username = processText($_SESSION['username']);
			
			$sql = "SELECT author FROM announcements WHERE username='$username'";
			$authorSQL = mysqliQuery($sql);
			
			$sql = "SELECT subject FROM announcements WHERE username='$username'";
			$subjectSQL = mysqliQuery($sql);
			
			$sql = "SELECT dateSent FROM announcements WHERE username='$username'";
			$dateSQL = mysqliQuery($sql);
			
			// Loop through the querys getting all results and creating a table row for each set of associated results
			while(($subject = mysqli_fetch_row($subjectSQL)) && ($author = mysqli_fetch_row($authorSQL)) 
				&& ($date = mysqli_fetch_row($dateSQL))){
					
				$auth = $author[0];
				$sub = $subject[0];
				$d = $date[0];
					
				$sql = "SELECT hashkey FROM announcements WHERE author='$auth' AND subject='$sub' AND dateSent='$d' AND username ='$username'";
				$result = mysqliQuery($sql);
				$hashkey = mysqli_fetch_row($result);
				
				// Shorten the Author name from SSOID@mail.umsl.edu to SSOID
				$theAuthor = explode('@', $auth);
				echo '
						<tr>
							<td align="center" style="border-bottom: 0px;">'.$theAuthor[0].'</td>
							<td align="center" style="border-bottom: 0px;">'.$sub.'</td>
							<td align="center" style="border-bottom: 0px;">'.date('m/j g:iA', strtotime($d)).'</td>
						</tr>

						<tr>
							<td align ="center" style="border-top: 0px;">
							<td align="center" style="border-top: 0px;"><a href="announceRead.php?id='.$hashkey[0].'" class="buttonFormThin">View</a></td>
							<td align ="center" style="border-top: 0px;">
						</tr>';
				mysqli_free_result($result);
			}
			
			mysqli_free_result($authorSQL);
			mysqli_free_result($subjectSQL);
			mysqli_free_result($dateSQL);
			
			echo '
				<tr>
				</tr>
				</table>
				<br /><center><a href="index.php" class="buttonForm">Home</a></center>';
				
		?>
		
	</body>
</html>