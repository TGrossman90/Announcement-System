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
	</head>  
	<body>  
		<div id="main">
		
		<?php 
		
			// Includes
			include "functions.php";
			include "dbcontroller.php";
			
			// Begin the structure of the inbox
			echo '<h2><center>Inbox</center></h2>';
			echo '
				<table>
					<tr>
						<th>Priority</th>
						<th>Sender</th>
						<th>Subject</th>
						<th>Date/Time</th>
						<th>&nbsp;</th>
					</tr>';
			
			// Get the relevant info to populate the inbox 
			$username = processText($_SESSION['username']);
			$authorSQL = mysqli_query($conn, "SELECT author FROM announcements WHERE username='$username'") or die(mysqli_error($conn));
			$subjectSQL = mysqli_query($conn, "SELECT subject FROM announcements WHERE username='$username'") or die(mysqli_error($conn));
			$dateSQL = mysqli_query($conn, "SELECT dateSent FROM announcements WHERE username='$username'") or die(mysqli_error($conn));
			$prioritySQL = mysqli_query($conn, "SELECT priority FROM announcements WHERE username='$username'") or die(mysqli_error($conn));
			
			// Loop through the querys getting all results and creating a table row for each set of associated results
			while(($subject = mysqli_fetch_row($subjectSQL)) && ($author = mysqli_fetch_row($authorSQL)) 
				&& ($date = mysqli_fetch_row($dateSQL)) && ($priority = mysqli_fetch_row($prioritySQL))){
					
					$auth = $author[0];
					$sub = $subject[0];
					$d = $date[0];
					$status = $priority[0];
					
				$result = mysqli_query($conn, "SELECT id FROM announcements WHERE author='$auth' AND subject='$sub' AND dateSent='$d' AND username ='$username' AND priority='$status'") or die(mysqli_error($conn));
				$id = mysqli_fetch_row($result);
				
				// Shorten the Author name from SSOID@mail.umsl.edu to SSOID
				$theAuthor = explode('@', $auth);
				echo '
						<tr>
							<td align="center">'.$status.'</td>
							<td align="center">'.$theAuthor[0].'</td>
							<td align="center">'.$sub.'</td>
							<td align="center">'.date('m/j g:iA', strtotime($d)).'</td>
							<td align="center"><a href="announceRead.php?id='.$id[0].'" class="button">View</a></td>
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
				<br /><center><a href="index.php" class="button">Home</a></center>';
				
		?>
		
	</body>
</html>