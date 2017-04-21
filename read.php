<!-- 
read.php
Created by Tom Grossman on 4/18/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Read Announcement</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
		<style>
		th {
			width: 320px
		}
		</style>
	</head>  
	<body>  
		<div id="main" class="shadow">
		<div style="text-align: center;">
			<img src="/img/umslmusic_logo.png" id="logo" style="text-align: center;" />
		</div>
		
		<?php 
		
		if(!empty($_GET['id'])) {
			// Includes
			include "functions.php";
			include "dbcontroller.php";
			
			// Gets the announcement ID passed by URL
			$id = processText($_GET['id']);

			$sql = "SELECT author, subject, dateSent, announcement FROM announcements WHERE hashkey='$id'";
			$getannounce = mysqliQuery($sql);
			$announcement = mysqli_fetch_row($getannounce);
			mysqli_free_result($getannounce);
			
			// Shorten author name and generate the announcement in a table to make it look presentable
			$author = explode('@', $announcement[0]);
			echo '<h2><center>Inbox</center></h2>';
			echo '
				<table style="width:100%; margin: 0 auto;">
					<tr>
						<th>Sender: '. $author[0] ."<br />".'Subject: ' . $announcement[1] . '<br />' . 'Date: '.date('m/j g:iA', strtotime($announcement[2])).'<br /><br /></th>
					</tr>
					<tr>
						<td>' . $announcement[3] . '</td>
					</tr>
				</table>
				<br />';
				
		} else {
			header("location:index.php");
		}
	
		?>
		
	</body>
</html>