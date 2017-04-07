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
		<link rel="stylesheet" href="styles2.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height,initial-scale=0.9"/>
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
			
			<p>Mobile Carrier:
			<select name="mobile_carrier" id="mobile_carrier" onChange="selected()">
					<option value='none'></option>
					<optgroup label="North America">
							<option value="alaskacommunications">Alaska Communications</option>
							<option value="aliant">Aliant</option>
							<option value="alltel">Alltel</option>
							<option value="ameritech">Ameritech</option>
							<option value="att">AT&amp;T</option>
							<option value="bellmobility">Bell Mobility &amp; Solo Mobile</option>
							<option value="bellsouth">BellSouth</option>
							<option value="bluegrass">Bluegrass Cellular</option>
							<option value="bluesky">Bluesky Communications</option>
							<option value="myboostmobile">Boost Mobile</option>
							<option value="cellcom">Cellcom</option>
							<option value="celloneusa">Cellular One</option>
							<option value="csouth1">Cellular South</option>
							<option value="cwemail">Centennial Wireless</option>
							<option value="cvalley">Chariton Valley Wireless</option>
							<option value="gocbw">Cincinnati Bell</option>
							<option value="cingular">Cingular</option>
							<option value="cingulartext">Cingular (GoPhone)</option>
							<option value="cleartalk">Cleartalk Wireless</option>
							<option value="mycricket">Cricket</option>
							<option value="cspire1">C Spire Wireless</option>
							<option value="edgewireless">Edge Wireless</option>
							<option value="elementmobile">Element Mobile</option>
							<option value="echoemail">Esendex</option>
							<option value="fido">Fido</option>
							<option value="gci">General Communications</option>
							<option value="gscsms">Golden State Cellular</option>
							<!-- <option value="google">Google</option> -->
							<option value="myhelio">Helio</option>
							<option value="iwirelesshometext">i-wireless (Sprint PCS)</option>
							<option value="kajeet">Kajeet</option>
							<option value="telus">Koodo Mobile</option>
							<option value="longlines">LongLines</option>
							<option value="mymetropcs">MetroPCS</option>
							<option value="mtsmobility">MTS Mobility</option>
							<option value="nextel">Nextel (Sprint)</option>
							<option value="celloneusa">O2</option>
							<option value="celloneusa">Orange</option>
							<option value="mobiletxt">PC Telecom</option>
							<option value="zsend">Pioneer Cellular</option>
							<option value="pocket">Pocket Wireless</option>
							<option value="qwestmp">Qwest Wireless</option>
							<option value="att">Red Pocket Mobile (AT&T MVNO)</option>
							<option value="rogers">Rogers Wireless</option>
							<option value="sasktel">SaskTel</option>
							<option value="smtext">Simple Mobile</option>
							<option value="rinasms">South Central Communications</option>
							<option value="sprintpcs">Sprint (PCS)</option>
							<option value="vtext">Straight Talk</option>
							<option value="rinasms">Syringa Wireless</option>
							<option value="tmomail">T-Mobile</option>
							<option value="teleflip">Teleflip</option>
							<option value="telus">Telus Mobility</option>
							<option value="tracfone">TracFone (prepaid)</option>
							<option value="utext">Unicel</option>
							<option value="uscc">US Cellular</option>
							<option value="usamobility">USA Mobility</option>
							<option value="vtext">Verizon Wireless</option>
							<option value="viaerosms">Viaero</option>
							<option value="vmobl">Virgin Mobile</option>
							<option value="vmobileca">Virgin Mobile (Canada)</option>
							<option value="">Wind Mobile</option>
							<option value="xit">XIT Communications</option>
					</optgroup>
					<optgroup label="Africa">
							<option value="emtelworld">Emtel</option>
							<option value="mtn">MTN</option>
							<option value="voda">Vodacom</option>
					</optgroup>
					<optgroup label="Asia">
							<option value="aircel">Aircel</option>
							<option value="airtela">Airtel (Andhra Pradesh, India)</option>
							<option value="airtelg">Airtel (Gujarat, India)</option>
							<option value="airtelh">Airtel (Haryana, India)</option>
							<option value="airtelk">Airtel (Karnataka, India)</option>
							<option value="andhraairtel">Andhra Pradesh AirTel</option>
							<option value="au">AU by KDDI</option>
							<option value="airtelchennai">Chennai Skycell / Airtel</option>
							<option value="rpgmail">Chennai RPG Cellular</option>
							<option value="139">China Mobile</option>
							<option value="hkcsl">CSL</option>
							<option value="airtelmail">Delhi Airtel</option>
							<option value="hutch">Delhi Hutch</option>
							<option value="airtelmail">Goa Airtel</option>
							<option value="bplmobile">Goa BPL Mobile</option>
							<option value="celforce">Gujarat Celforce / Fascel</option>
							<option value="escotelmobile">Haryana Escotel</option>
							<option value="ideacellular">Idea Cellular</option>
							<!--
							<option value=""></option>
							-->
					</optgroup>
					<!--
					<optgroup label="Australia &amp; Oceana">
							<option value=""></option>
					</optgroup>
					-->
					<optgroup label="Europe">
							<option value="aql">aql</option>
							<option value="bouyguestelecom">Bouygues Telecom</option>
							<option value="eplus">E-Plus</option>
							<option value="echoemail">Esendex (UK)</option>
							<option value="esendex">Esendex (Spain)</option>
							<option value="globul">Globul</option>
							<!--
							<option value=""></option>
							-->
					</optgroup>
					<optgroup label="South America">
							<option value="clarotorpedo">Claro (Brasil)</option>
							<option value="ideasclaro">Claro (Nicaragua)</option>
							<option value="vtexto">Claro (Puerto Rico)</option>
							<option value="comcel">Comcel</option>
							<option value="ctimovil">Claro (Argentina)</option>
							<option value="digitextdm">Digicel (Dominica)</option>
							<!--
							<option value=""></option>
					</optgroup>
					<!--
					<optgroup label="International">
							<option value="globalstarusa">Globalstar</option>
							<option value=""></option>
					</optgroup>
					-->
			</select> </p>
		   
			<p>Mobile Number:
			<input type="text" id="mobile_number" name="mobile_number" maxlength="20" onKeyPress="return numbersonly(event, false)" /> </p>
			<br />

			<span class="error">WARNING: For the sake of security <u<b>DO NOT</u></b> use the password you use to log into MyGateway, MyView, or any other UM SSO systems.</span>
			<br /><br />
			<input type="submit" name="submit" value="Submit">&nbsp;<a href="index.php" class="button">Cancel</a>
		</form>
		
	</body>
</html>