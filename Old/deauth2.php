<!-- 
deauth.php
Created by Tom Grossman on 3/27/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Deauthorize Student Accounts</title>
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
			
			// Make sure you are supposed to be here
			if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] == 100)) {
				echo "You do not have permission to be here!";
				header("location:index.php");
			} 

			// For every user that is to be removed check for that user in every group.
			// If found, remove that user from the group. 
			foreach($_POST['usersToRemove'] as $user) {
				
				$result = mysqli_query($conn, "SELECT id FROM windsPercussionGroup WHERE username='$user'") or die(mysqli_error($conn));
				if(mysqli_num_rows($result) != 0) {
					$num = mysqli_fetch_row($result);
					$id = $num[0];
					//echo "windsPercussionGroup = " . $id . "<br />";
					$delete = mysqli_query($conn, "DELETE FROM windsPercussionGroup WHERE id='$id'");
				}
				
				$result = mysqli_query($conn, "SELECT id FROM vocalGroup WHERE username='$user'") or die(mysqli_error($conn));
				if(mysqli_num_rows($result) != 0) {
					$num = mysqli_fetch_row($result);
					$id = $num[0];
					//echo "vocalGroup = " . $id . "<br />";
					$delete = mysqli_query($conn, "DELETE FROM vocalGroup WHERE id='$id'");
				}
				
				$result = mysqli_query($conn, "SELECT id FROM users WHERE username='$user'") or die(mysqli_error($conn));
				if(mysqli_num_rows($result) != 0) {
					$num = mysqli_fetch_row($result);
					$id = $num[0];
					//echo "users = " . $id . "<br />";
					$delete = mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
				}			
				
				$result = mysqli_query($conn, "SELECT id FROM studentUsers WHERE username='$user'") or die(mysqli_error($conn));
				if(mysqli_num_rows($result) != 0) {
					$num = mysqli_fetch_row($result);
					$id = $num[0];
					//echo "studentUsers = " . $id . "<br />";
					$delete = mysqli_query($conn, "DELETE FROM studentUsers WHERE id='$id'");
				}
				
				$result = mysqli_query($conn, "SELECT id FROM stringGroup WHERE username='$user'") or die(mysqli_error($conn));
				if(mysqli_num_rows($result) != 0) {
					$num = mysqli_fetch_row($result);
					$id = $num[0];
					//echo "stringGroup = " . $id . "<br />";
					$delete = mysqli_query($conn, "DELETE FROM stringGroup WHERE id='$id'");
				}
				
				$result = mysqli_query($conn, "SELECT id FROM musicEdGroup WHERE username='$user'") or die(mysqli_error($conn));
				if(mysqli_num_rows($result) != 0) {
					$num = mysqli_fetch_row($result);
					$id = $num[0];
					//echo "musicEdGroup = " . $id . "<br />";
					$delete = mysqli_query($conn, "DELETE FROM musicEdGroup WHERE id='$id'");
				}
				
				$result = mysqli_query($conn, "SELECT id FROM facAdminUsers WHERE username='$user'") or die(mysqli_error($conn));
				if(mysqli_num_rows($result) != 0) {
					$num = mysqli_fetch_row($result);
					$id = $num[0];
					//echo "facAdminUsers = " . $id . "<br />";
					$delete = mysqli_query($conn, "DELETE FROM facAdminUsers WHERE id='$id'");
				}
				
				$result = mysqli_query($conn, "SELECT id FROM departmentWideGroup WHERE username='$user'") or die(mysqli_error($conn));
				if(mysqli_num_rows($result) != 0) {
					$num = mysqli_fetch_row($result);
					$id = $num[0];
					//echo " departmentWideGroup = " . $id . "<br />";
					$delete = mysqli_query($conn, "DELETE FROM departmentWideGroup WHERE id='$id'");
				}
				
				// Lastly, delete any announcements associated with the deleted user
				$result = mysqli_query($conn, "SELECT id FROM announcements WHERE username='$user'") or die(mysqli_error($conn));
				if(mysqli_num_rows($result) != 0) {
					$num = mysqli_fetch_row($result);
					$id = $num[0];
					//echo " announcements = " . $id . "<br />";
					$delete = mysqli_query($conn, "DELETE FROM announcements WHERE id='$id'");
				}
				
				mysqli_free_result($result);
				
				echo '<center>'. $user . ' was removed successfully. <br /></center>';
			}
			
			echo '<br /><center><a href="index.php" class="button">Home</a>&nbsp;';
			echo '<a href="acp.php" class="button">Admin CP</a>';
			
		?>
		
	</body>
</html>