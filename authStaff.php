<!-- 
authStaff.php
Created by Tom Grossman on 4/20/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>ACP: Adding Staff</title>
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
				
			if($_SESSION['permissions'] == 100) {
				// Make sure things posted correctly
				if(!empty($_POST['user'])) {
					$user = processText($_POST['user']);
					
					if(!empty($_POST['level'])) {
						$level = processText($_POST['level']);
						
						if($level == "faculty") {
							if(!empty($_POST['groups'])) {
								
								foreach($_POST['groups'] as $group) {
									$sql = "SELECT groupParent FROM groups WHERE groupName='$group'";
									$result = mysqliQuery($sql);
							
									$isParent = mysqli_fetch_row($result);
									if(is_null($isParent[0])) {
										$sql = "SELECT groupName FROM groups WHERE groupParent='$group'";
										$getChildren = mysqliQuery($sql);
							
										$grps = array();
										while($grp = mysqli_fetch_row($getChildren)) {
											array_push($grps, $grp[0]);
										}
										
										foreach($grps as $grp) {
											$sql = "SELECT username FROM facultyViewPermissions WHERE username='$user' AND groupName='$grp'";
											$result = mysqliQuery($sql);
											if(mysqli_num_rows($result) == 0) {
												$sql = "INSERT INTO facultyViewPermissions (username, groupName) VALUES ('$user', '$grp')";
												$result = mysqliQuery($sql);
												echo $user . ' now manages ' . $grp . '<br />';
											} else {
												echo $user . ' already manages ' . $grp . '! <br />';
											}
										}
										
										$sql = "SELECT username FROM facultyViewPermissions WHERE username='$user' AND groupName='$group'";
										$result = mysqliQuery($sql);
										if(mysqli_num_rows($result) == 0) {
											$sql = "INSERT INTO facultyViewPermissions (username, groupName) VALUES ('$user', '$group')";
											$result = mysqliQuery($sql);
											echo $user . ' now manages ' . $group . '<br />';
										} else {
											echo $user . ' already manages ' . $group . '! <br />';
										}
										
									} else {
										$sql = "SELECT username FROM facultyViewPermissions WHERE username='$user' AND groupName='$group'";
										$result = mysqliQuery($sql);
										if(mysqli_num_rows($result) == 0) {
											$sql = "INSERT INTO facultyViewPermissions (username, groupName) VALUES ('$user', '$group')";
											$result = mysqliQuery($sql);
											echo $user . ' now manages ' . $group . '<br />';
										} else {
											echo $user . ' already manages ' . $group . '! <br />';
										}
									}
									
									mysqli_free_result($result);
								}
								
								$sql = "SELECT username FROM faculty WHERE username='$user'";
								$result = mysqliQuery($sql);
								if(mysqli_num_rows($result) == 0) {
									$sql = "INSERT INTO faculty (username) VALUES ('$user')";
									$result = mysqliQuery($sql);
								} else { 
									echo $user . ' is already a faculty account! <br />';
								}
								
								$sql = "UPDATE users SET userLevel='50' WHERE username='$user'";
								$result = mysqliQuery($sql);
								mysqli_free_result($result);
								
								echo '<p>Finished making ' . $user . ' a faculty account!</p>';
								echo '<center><a href="acpAddStaff.php" class="buttonForm">Go Back</a> &nbsp;';
								echo '<a href="acp.php" class="buttonForm">Admin CP</a></center>';
								
							} else {
								echo '<p>You have to select at least one group for a faculty account to manage, otherwise it cannot send any announcements!</p>';
								echo '<center><a href="acpAddStaff.php" class="buttonForm">Go Back</a> &nbsp;';
								echo '<a href="acp.php" class="buttonForm">Admin CP</a></center>';
							}
							
						} else if($level == "admin") {
							$sql = "UPDATE users SET userLevel='100' WHERE username='$user'";
							$result = mysqliQuery($sql);
							
							$sql = "SELECT username FROM faculty WHERE username='$user'";
							$result = mysqliQuery($sql);		
							if(mysqli_num_rows($result) == 0) {
								$sql = "INSERT INTO faculty (username) VALUES ('$user')";
								$result = mysqliQuery($sql);
							}
							
							mysqli_free_result($result);	
							
							echo '<p>Finished making ' . $user . ' an administrator account!</p>';
							echo '<center><a href="acpAddStaff.php" class="buttonForm">Go Back</a> &nbsp;';
							echo '<a href="acp.php" class="buttonForm">Admin CP</a></center>';
						}
						
					} else {
						echo '<p>You have to pick either the faculty or administrator option!</p>';
						echo '<center><a href="acpAddStaff.php" class="buttonForm">Go Back</a> &nbsp;';
						echo '<a href="acp.php" class="buttonForm">Admin CP</a></center>';
					}
					
				} else {
					echo '<p>You have to select a user!</p>';
					echo '<center><a href="acpAddStaff.php" class="buttonForm">Go Back</a> &nbsp;';
					echo '<a href="acp.php" class="buttonForm">Admin CP</a></center>';
				}
			} else {
				header("location:index.php");
			}
			
		?>
		
	</body>
</html>