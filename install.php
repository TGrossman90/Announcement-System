<!-- 
installSystem.php
Created by Tom Grossman on 4/18/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>SYSTEM INSTALLATION</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			
			<?php 
				// THIS IS THE INSTALLATION FILE. 
				include "installFunctions.php";

				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if(!empty(processText($_POST['installPassword']))) {
						$password = processText($_POST['installPassword']);
						$hash = '$2a$04$1rRPH9fmbhwQwxknEyTze.dz1vUi8QP6Ss0bDkvsX5j2OPLgOVsYq';
						// Default Install Password = password
						
						if(password_verify($password, $hash)) {
							include "systemConfiguration.php";
							
							$conn = mysqli_connect($dbhost, $dbroot, $dbrootpass);
							if(mysqli_connect_errno()) {
								die("Connection Failed: " . mysqli_connect_error());
							}
							
							$sql = "CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET 
								latin1 COLLATE latin1_swedish_ci";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>Database Created...</p>';
							
							usleep(500000);
							
							$sql = "CREATE USER '$dbuser'@'localhost' IDENTIFIED BY '$dbpass'";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							$sql = "GRANT ALL PRIVILEGES ON ".$dbname." . * TO '$dbuser'@'localhost'";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							$sql = "FLUSH PRIVILEGES";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							
							mysqli_close($conn);
							include "dbcontroller.php";
							
							usleep(500000);
							
							$sql = "CREATE TABLE IF NOT EXISTS `groups` (
								`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
								`groupName` varchar(32) NOT NULL,
								`groupParent` varchar(32)
								) ENGINE=InnoDB DEFAULT CHARSET=latin1";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>Groups Table Created...</p>';
							
							usleep(500000);
							
							$sql = "INSERT INTO `groups` (`groupName`) VALUES ('.None')";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>NULL Parent Group Created...</p>';
							
							usleep(500000);
							
							$sql = "CREATE TABLE IF NOT EXISTS `allusers` (
									`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
									`username` varchar(32) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>AllUsers Table Created...</p>';
							
							usleep(500000);
							
							$sql = "CREATE TABLE IF NOT EXISTS `users` (
									`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
									`username` varchar(32) NOT NULL,
									`name` varchar(32) NOT NULL,
									`password` varchar(64) NOT NULL,
									`mobile` varchar(32) NOT NULL,
									`optstatus` tinyint NOT NULL,
									`userLevel` int(11) NOT NULL DEFAULT '10',
									`verification` varchar(63) NOT NULL,
									`passreset` varchar(128)
									) ENGINE=InnoDB DEFAULT CHARSET=latin1";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>Users Table Created...</p>';
							
							usleep(500000);
							
							$sql = "CREATE TABLE IF NOT EXISTS `faculty` (
									`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
									`username` varchar(32) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>Faculty Table Created...</p>';
							
							usleep(500000);
							
							$sql = "CREATE TABLE IF NOT EXISTS `announcements` (
									`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
									`username` varchar(32) NOT NULL,
									`dateSent` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
									`priority` varchar(7) NOT NULL,
									`author` varchar(32) NOT NULL,
									`subject` varchar (32) NOT NULL,
									`announcement` varchar(255) NOT NULL,
									`hashkey` varchar(32) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>Announcement Table Created...</p>';
							
							usleep(500000);
							
							$sql = "CREATE TABLE IF NOT EXISTS `facultyViewPermissions` (
									`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
									`username` varchar(32) NOT NULL,
									`groupName` varchar(32) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>FacultyViewPermissions Table Created...</p>';
							
							usleep(500000);
							
							// Default admin password = password
							$pass = '$2a$04$s56Kk.HNeBW2OA5gGPur1esdjYh/64Nd5ulSZGw6LEFy.G87C10zi';
							$sql = "INSERT INTO `users`(`username`, `name`, `password`, `userLevel`, `optstatus`, `verification`) 
								VALUES ('admin', 'admin', '$pass', '100', '0', 'verified')";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>umslmusicsystem@gmail.com Account Created...</p>';
							
							usleep(500000);
							
							$sql = "INSERT INTO `groups`(`groupName`) 
								VALUES ('allusers')";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>AllUsers Group Inserted...</p>';
							
							usleep(500000);
							
							$sql = "INSERT INTO `groups`(`groupName`) 
								VALUES ('faculty')";
							$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo '<p>Faculty Group Inserted...</p>';
							
							usleep(500000);
							
							echo '<p>Database installed sucessfully!</p>';
							echo '<a href="index.php" class="buttonForm">Main Page</a>';
							
							mysqli_close($conn);
							unlink(__FILE__); 
							unlink("installFunctions.php");
						} else {
							echo '<p>The password you entered is incorrect</p>';
						}
					} else {
						echo '<p>You have to enter the password</p>';
					}
				} else {
					echo '<form method="post" action="'.$_SERVER["PHP_SELF"].'">';
					echo '<p>Please enter the password that was given to you for a clean database install</p>';
					echo '<input type="password" name="installPassword" /> <br />';
					echo '<input type="submit" name="submit" value="Submit" class="buttonForm">';
				}

			?>
		</div>
	</body>
</html>