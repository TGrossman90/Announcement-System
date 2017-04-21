<!-- 
announceSubmit.php
Created by Tom Grossman on 3/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL MUSIC: Submit Announcement</title>
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
			
			// Make sure things POST correctly
			if(!empty($_POST['groups'])) {
				if(!empty($_POST['subject'])) {
					if(!empty($_POST['announcement'])) {
						$groups = $_POST['groups'];
						$subject = processText($_POST['subject']);
						$subject = str_replace("'", "''", $subject);
						$author = processText($_SESSION['username']);
						$announcement = processText($_POST['announcement']);
						$announcement = str_replace("'", "''", $announcement);

						// For every group the announcement is sent to
						// retrieve all usernames and create announcements for them
						foreach($groups as $group) {	
							$sql = "SELECT groupParent FROM groups WHERE groupName='$group'";
							$result = mysqliQuery($sql);
							
							$isParent = mysqli_fetch_row($result);
							if(is_null($isParent[0]) && $group != "allusers") {
								$sql = "SELECT groupName FROM groups WHERE groupParent='$group'";
								$getChildren = mysqliQuery($sql);
					
								$grps = array();
								while($grp = mysqli_fetch_row($getChildren)) {
									array_push($grps, $grp[0]);
								}
								
								mysqli_free_result($getChildren);
								
								foreach($grps as $grp) {
									$sql = "SELECT username FROM $grp";
									$result = mysqliQuery($sql);
									
									while($array = mysqli_fetch_row($result)) {
										$username = $array[0];
										
										$sql = "SELECT optstatus FROM users WHERE username='$username'";
										$resultStatus = mysqliQuery($sql);
										$status = mysqli_fetch_row($resultStatus);
										$optstatus = $status[0];
										
										if($optstatus == 1) {
											$time = time();
											$hashkey = hash('md5', $subject . $username . $time);
											$url = "http://thedreamteam.me/read.php?id=" . $hashkey;
											$sql = "INSERT INTO announcements (id, username, subject, author, announcement, hashkey) VALUES ('NULL', '$username', '$subject', '$author', '$announcement', '$hashkey')";
											$query = mysqliQuery($sql);
											
											$sql = "SELECT mobile FROM users WHERE username='$username'";
											$getNum = mysqliQuery($sql);
											$num = mysqli_fetch_row($getNum);
											$mobile = $num[0];
											
											mail($mobile, $subject, $url, "From: admin");
											echo 'Sent announcement to: ' . $grp . '<br />';
											mysqli_free_result($getNum);
										} else {
											$time = time();
											$hashkey = hash('md5', $subject . $username . $time);
											$url = "http://thedreamteam.me/read.php?id=" . $hashkey;
											$sql = "INSERT INTO announcements (id, username, subject, author, announcement, hashkey) VALUES ('NULL', '$username', '$subject', '$author', '$announcement', '$hashkey')";
											$query = mysqliQuery($sql);

											$headers  = 'MIME-Version: 1.0' . "\r\n";
											$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
											$from = 'admin@thedreamteam.me';
											$headers .= 'From: '.$from."\r\n".
												'X-Mailer: PHP/' . phpversion();
												
											$message = '<html><body>';
											$message .= 'Hello,<br />';
											$message .= '<br />This message is to inform you that you have a new announcement waiting to be viewed.<br />';
											$message .= '<br />You can view the announcement by clicking the following link:<br />';
											$message .= '<a href="'.$url.'"> '.$url.' </a><br />';
											$message .= '<br />Thank you,';
											$message .= '<br />Music Dept Staff';
											$message .= '</body></html>';
											mail($username, "You Have a New Announcement!", $message, $headers);
											echo 'Sent announcement to: ' . $grp . '<br />';
											
											mysqli_free_result($query);
										}
										
										mysqli_free_result($resultStatus);
									}
									
									mysqli_free_result($result);
								}
							} else {
								$sql = "SELECT username FROM $group";
								$result = mysqliQuery($sql);
								
								while($array = mysqli_fetch_row($result)) {
									$username = $array[0];
									
									$sql = "SELECT optstatus FROM users WHERE username='$username'";
									$resultStatus = mysqliQuery($sql);
									$status = mysqli_fetch_row($resultStatus);
									$optstatus = $status[0];
									
									if($optstatus == 1) {
										$time = time();
										$hashkey = hash('md5', $subject . $username . $time);
										$url = "http://thedreamteam.me/read.php?id=" . $hashkey;
										$sql = "INSERT INTO announcements (id, username, subject, author, announcement, hashkey) VALUES ('NULL', '$username', '$subject', '$author', '$announcement', '$hashkey')";
										$query = mysqliQuery($sql);
										
										$sql = "SELECT mobile FROM users WHERE username='$username'";
										$getNum = mysqliQuery($sql);
										$num = mysqli_fetch_row($getNum);
										$mobile = $num[0];
										
										mail($mobile, $subject, $url, "From: admin");
										mysqli_free_result($query);
									} else {
										$time = time();
										$hashkey = hash('md5', $subject . $username . $time);
										$url = "http://thedreamteam.me/read.php?id=" . $hashkey;
										$sql = "INSERT INTO announcements (id, username, subject, author, announcement, hashkey) VALUES ('NULL', '$username', '$subject', '$author', '$announcement', '$hashkey')";
										$query = mysqliQuery($sql);
										
										$headers  = 'MIME-Version: 1.0' . "\r\n";
										$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
										$from = 'admin@thedreamteam.me';
										$headers .= 'From: '.$from."\r\n".
											'X-Mailer: PHP/' . phpversion();
											
										$message = '<html><body>';
										$message .= 'Hello,<br />';
										$message .= '<br />This message is to inform you that you have a new announcement waiting to be viewed.<br />';
										$message .= '<br />You can view the announcement by clicking the following link:<br />';
										$message .= '<a href="'.$url.'"> '.$url.' </a><br />';
										$message .= '<br />Thank you,';
										$message .= '<br />Music Dept Staff';
										$message .= '</body></html>';
										mail($username, "You Have a New Announcement!", $message, $headers);
										
										mysqli_free_result($query);
									}
									
									echo 'Sent announcement to: ' . $group . '<br />';
									mysqli_free_result($resultStatus);
								}
								
								mysqli_free_result($result);
							}
							
							mysqli_free_result($result);
						}
						
						echo '<center>Announcement sent successfully!</center><br />';
						echo '<br /><center><a href="announceCreate.php" class="buttonForm">Send Another</a>';
						echo '<br /><center><a href="index.php" class="buttonForm">Home</a></center>';
						
					} else {
						echo "ERROR: You have to enter an announcement";
						echo '<br /><center><a href="announceCreate.php" class="buttonForm">Go back</a></center>';
					}
					
				} else {
					echo "ERROR: You have to enter a subject";
					echo '<br /><center><a href="announceCreate.php" class="buttonForm">Go back</a></center>';
				}
				
			} else {
				echo "ERROR: You have to select a group";
				echo '<br /><center><a href="announceCreate.php" class="buttonForm">Go back</a></center>';
			}
			
		?>
		
	</body>
</html>
	
	