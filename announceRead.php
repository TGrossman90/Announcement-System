<!-- 
announceRead.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Read Announcement</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="styles2.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.9"/>
		<style>
		th {
			width: 320px
		}
		</style>
	</head>  
	<body>  
		<div id="main">
		
		<?php 
		
			// Includes
			include "functions.php";
			include "dbcontroller.php";
			
			// Gets the announcement ID passed by URL
			$id = processText($_GET['id']);
			$result = mysqli_query($conn, "SELECT username FROM announcements WHERE id='$id'") or die(mysqli_error($conn));
			$idd = mysqli_fetch_row($result);
			
			// Verify user is allowed to read the announcement
			if($idd[0] == $_SESSION['username']) {
				$getannounce = mysqli_query($conn, "SELECT author, subject, dateSent, announcement FROM announcements WHERE id='$id'") or die(mysqli_error($conn));
				$announcement = mysqli_fetch_row($getannounce);
				mysqli_free_result($getannounce);
				
				// Shorten author name and generate the announcement in a table to make it look presentable
				$author = explode('@', $announcement[0]);
				echo '<h2><center>Inbox</center></h2>';
				echo '
					<table>
						<tr>
							<th width="400px">Sender: '.$author[0]."<br />".'Subject: '.$announcement[1]."<br />".'Date: '.date('m/j g:iA', strtotime($announcement[2]))."<br />".'</th>
						</tr>
						<tr>
							<td>'.$announcement[3].'</td>
						</tr>
						<tr>
							<td align="center"><a href="announceDecision.php?decision=save&id='.$id.'" class="button">Save</a> <a href="announceDecision.php?decision=delete&id='.$id.'" class="button">Delete</a></td>
						</tr>
					</table>';
			} else {
				echo 'There are no messages here. <br />';
				echo '<a href="announceInbox.php class="button"">Return to Inbox</a>';
			}
			
		?>
		
	</body>
</html>