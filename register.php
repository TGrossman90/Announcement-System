<!-- 
register.php
Created by Tom Grossman on 3/24/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML>  
<html>
	<head>
		<title>UMSL MUSIC: Registration</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>  
		<div id="main">
		
		<?php
		
			//Includes
			include "functions.php";
			include "dbcontroller.php";
			
			// Set a few vars
			$usernameError = $emailError = $passwordError = $passwordVerifyError = "";
			$username = $password = "";
			$userFlag = $passwordFlag = "0";

			// Since the register form is on this same page, check to see if a form was submitted
			// or if this is a fresh viewing of the page
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
				// If a registration attempt is currently underway check for matching passwords
				if(!empty($_POST['username']) && !empty($_POST['password'])) {
					if(processText($_POST['password']) != processText($_POST['passwordVerify'])) {
						$passwordError = "Your passwords do not match";
					
					// If the passwords match, hash the password and check if the username has been registered yet
					} else {
						$username = processText($_POST['username']);
						$password = processText($_POST['password']);
						$hash = password_hash($password, PASSWORD_BCRYPT);
						
						$checkuser = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
						
						// If the username has been registered...
						if(mysqli_num_rows($checkuser) != 0 ) {
							$usernameError = "That email has already registered";
							mysqli_free_result($checkuser);
						
						// If the username has not been registered, make sure that the user has permission to register in the first place
						} else {
							$checkAuthorizedStudent = mysqli_query($conn, "SELECT * FROM studentUsers WHERE username='$username'") or die(mysqli_error($conn));
							$checkAuthorizedFacultyAdmin = mysqli_query($conn, "SELECT * FROM facAdminUsers WHERE username='$username'") or die(mysqli_error($conn));

							// If the user is a student and has been authorized, create the account
							if(mysqli_num_rows($checkAuthorizedStudent) != 0) {
								$registry = mysqli_query($conn, "INSERT INTO users (id, username, password) VALUES ('NULL', '$username', '$hash')") or die(mysqli_error($conn));
								$addToDepartmentGroup = mysqli_query($conn, "INSERT INTO departmentWideGroup (id, username) VALUES ('NULL', '$username')") or die(mysqli_error($conn));
								
								mysqli_free_result($registry);
								mysqli_free_result($addToDepartmentGroup);
								
								header("location:index.php");
								
							// If the user is a faculty/admin account and has been authorized, create the account
							} if(mysqli_num_rows($checkAuthorizedFacultyAdmin) != 0) {
								$permissions = mysqli_query($conn, "SELECT permissions FROM facAdminUsers WHERE username='$username'") or die(mysqli_error($conn));
								$level = mysqli_fetch_row($permissions);
								$userLevel = $level[0];
								$registry = mysqli_query($conn, "INSERT INTO users (id, username, password, userLevel) VALUES ('NULL', '$username', '$hash', '$userLevel')") or die(mysqli_error($conn));
								$addToDepartmentGroup = mysqli_query($conn, "INSERT INTO departmentWideGroup (id, username) VALUES ('NULL', '$username')") or die(mysqli_error($conn));
							
								mysqli_free_result($registry);
								mysqli_free_result($addToDepartmentGroup);
								
								header("location:index.php");
							
							// Otherwise, do not create the account
							} else {
								echo '<h2>Error: You have not been added as an authorized user for registration!</h2>';
								echo 'If you feel you have recieved this message in error, please contact the UMSL Music Department Administration<br /><br />';
								echo '<a href="index.php" class="button">Home</a>';
							}
						}
					}
				
				// Display errors next to the incorrectly filled out forms
				} else {
					if (empty($_POST["username"])) {
						$usernameError = "Username is a required field!";
					}
					
					if (empty($_POST["password"])) {
						$usernameError = "Password is a required field!";
					}
				}
			}	
			
		?>
		
		<!-- The registration form -->
		
		<p><span class="error">* denotes a required field</span></p>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
			<label for="username">Username (USML Email): </label> <input type="text" name="username">
			<span class="error">* <?php echo $usernameError; ?></span>
			<br /><br />
			
			<label for="password">Password: </label> <input type="password" name="password">
			<span class="error">* <?php echo $passwordError; ?></span>
			<br /><br />
			
			<label for="passwordVerify">Re-enter Password: </label> <input type="password" name="passwordVerify">
			<span class="error">* <?php echo $passwordVerifyError; ?></span>
			<br /><br />

			<span class="error">WARNING: For the sake of security <u<b>DO NOT</u></b> use the password you use to log into MyGateway, MyView, or any other UM SSO systems.</span>
			<br /><br />
			<input type="submit" name="submit" value="Submit">&nbsp;<a href="index.php" class="button">Cancel</a>
		</form>
		
	</body>
</html>