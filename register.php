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
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
		<script>
			function checkbox() {
				var checked = document.getElementById("optOut").value;
			}
		</script>
	</head>
	<body>  
		<div id="main" class="shadow">
		<div style="text-align: center;">
		<img src="/img/umslmusic_logo.png" id="logo" />
		<?php
		
			//Includes
			include "functions.php";
			include "dbcontroller.php";
			
			// Set a few vars
			$usernameError = $emailError = $passwordError = $passwordVerifyError = $phoneNumberError = $phoneCarrierError = "";
			$username = $password = "";
			$userFlag = $passwordFlag = "0";
			$optOutMessage = "Are you sure you want to opt out of text alerts? (not recommended unless there are mobile plan restrictions)";

			// Since the register form is on this same page, check to see if a form was submitted
			// or if this is a fresh viewing of the page
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
				// If a registration attempt is currently underway check for matching passwords
				if(!empty($_POST['username']) && !empty($_POST['password'])) {
					if(processText($_POST['password']) != processText($_POST['passwordVerify'])) {
						$passwordError = "Your passwords do not match";
						$passwordVerifyError = "Your passwords do not match";
					
					// If the passwords match, hash the password and check if the username has been registered yet
					} else {
						$username = processText($_POST['username']);
						$username = strtolower($username);
						$password = processText($_POST['password']);
						$carrier = processText($_POST["mobile_carrier"]);
						$number = processText($_POST["mobile_number"]);
						$number = preg_replace("/[^0-9]/", "", $number);
						$hash = password_hash($password, PASSWORD_BCRYPT);
						$optout = $_POST['optout'];
						
						$sql = "SELECT * FROM users WHERE username = '$username'";
						$checkuser = mysqliQuery($sql);
						
						// If the username has been registered...
						if(mysqli_num_rows($checkuser) != 0 ) {
							$usernameError = "That email has already registered";
						
						// If the username has not been registered, make sure that the user has permission to register in the first place
						} else {
							if(!empty($_POST['optout']) && (($_POST['mobile_carrier'] == "none") || empty($_POST['mobile_number']))) {
								if($_POST['mobile_carrier'] == "none") {
									$phoneCarrierError = "You must select a carrier";
								}
								if(empty($_POST['mobile_number'])) {
									$phoneNumberError = "You must enter your number";
								}
							} else {
								// Carriers listed by alphabetical company names from: http://en.wikipedia.org/wiki/List_of_SMS_gateways
								$mobile = '';
								if ($carrier == 'aircel'){
										$mobile = ''.$number.'@aircel.co.in';
								}elseif ($carrier == 'alaskacommunications'){
										$mobile = ''.$number.'@msg.acsalaska.com';
								}elseif ($carrier == 'aliant'){
										$mobile = ''.$number.'@sms.wirefree.informe.ca';
								}elseif ($carrier == 'alltel'){
										$mobile = ''.$number.'@sms.alltelwireless.com';
								}elseif ($carrier == 'ameritech'){
										$mobile = ''.$number.'@paging.acswireless.com';
								}elseif ($carrier == 'andhraairtel'){
										$mobile = '91'.$number.'@airtelap.com';
								}elseif ($carrier == 'aql'){
										$mobile = ''.$number.'@text.aql.com';
								}elseif ($carrier == 'att'){
										$mobile = ''.$number.'@txt.att.net';
								}elseif ($carrier == 'au'){
										$mobile = ''.$number.'@ezweb.ne.jp';
								}elseif ($carrier == 'bellmobility'){
										$mobile = ''.$number.'@txt.bellmobility.ca';
								}elseif ($carrier == 'bellsouth'){
										$mobile = ''.$number.'@bellsouth.cl';
								}elseif ($carrier == 'bluegrass'){
										$mobile = ''.$number.'@sms.bluecell.com';
								}elseif ($carrier == 'bluesky'){
										$mobile = ''.$number.'@psms.bluesky.as';
								}elseif ($carrier == 'myboostmobile'){
										$mobile = ''.$number.'@myboostmobile.com';
								}elseif ($carrier == 'bouyguestelecom'){
										$mobile = ''.$number.'@mms.bouyguestelecom.fr';
								}elseif ($carrier == 'cellcom'){
										$mobile = ''.$number.'@cellcom.quiktxt.com';
								}elseif ($carrier == 'csouth1'){
										$mobile = ''.$number.'@csouth1.com';
								}elseif ($carrier == 'cwemail'){
										$mobile = ''.$number.'@cwemail.com';
								}elseif ($carrier == 'cvalley'){
										$mobile = ''.$number.'@sms.cvalley.net';
								}elseif ($carrier == 'airtelchennai'){
										$mobile = '919840'.$number.'@airtelchennai.com';
								}elseif ($carrier == 'rpgmail'){
										$mobile = '9841'.$number.'@rpgmail.net';
								}elseif ($carrier == '139'){
										$mobile = ''.$number.'@139.com';
								}elseif ($carrier == 'gocbw'){
										$mobile = ''.$number.'@gocbw.com';
								}elseif ($carrier == 'mycingular'){
										$mobile = ''.$number.'@mobile.mycingular.com';
								}elseif ($carrier == 'cingulartext'){
										$mobile = ''.$number.'@cingulartext.com';
								}elseif ($carrier == 'clarotorpedo'){
										$mobile = ''.$number.'@clarotorpedo.com.br';
								}elseif ($carrier == 'ideasclaro'){
										$mobile = ''.$number.'@ideasclaro-ca.com';
								}elseif ($carrier == 'vtexto'){
										$mobile = ''.$number.'@vtexto.com';
								}elseif ($carrier == 'cleartalk'){
										$mobile = ''.$number.'@sms.cleartalk.us';
								}elseif ($carrier == 'comcel'){
										$mobile = ''.$number.'@comcel.com.co';
								}elseif ($carrier == 'mycricket'){
										$mobile = ''.$number.'@sms.mycricket.com';
								}elseif ($carrier == 'cspire1'){
										$mobile = ''.$number.'@cspire1.com';
								}elseif ($carrier == 'hkcsl'){
										$mobile = ''.$number.'@mgw.mmsc1.hkcsl.com';
								}elseif ($carrier == 'ctimovil'){
										$mobile = ''.$number.'@sms.ctimovil.com.ar';
								}elseif ($carrier == 'airtelmail919810'){
										$mobile = '919810'.$number.'@airtelmail.com';
								}elseif ($carrier == 'hutch'){
										$mobile = '9811'.$number.'@delhi.hutch.co.in';
								}elseif ($carrier == 'eplus'){
										$mobile = '0'.$number.'@smsmail.eplus.de';
								}elseif ($carrier == 'edgewireless'){
										$mobile = ''.$number.'@sms.edgewireless.com';
								}elseif ($carrier == 'elementmobile'){
										$mobile = ''.$number.'@SMS.elementmobile.net';
								}elseif ($carrier == 'emtelworld'){
										$mobile = ''.$number.'@emtelworld.net';
								}elseif ($carrier == 'echoemail'){
										$mobile = ''.$number.'@echoemail.net';
								}elseif ($carrier == 'esendex'){
										$mobile = ''.$number.'@esendex.net';
								}elseif ($carrier == 'fido'){
										$mobile = ''.$number.'@fido.ca';
								}elseif ($carrier == 'smssturen'){
										$mobile = ''.$number.'@smssturen.com';
								}elseif ($carrier == 'gci'){
										$mobile = ''.$number.'@mobile.gci.net';
								}elseif ($carrier == 'globalstarusa'){
										$mobile = ''.$number.'@msg.globalstarusa.com';
								}elseif ($carrier == 'globul'){
										$mobile = '35989'.$number.'@sms.globul.bg';
								}elseif ($carrier == 'airtelmail919890'){
										$mobile = '919890'.$number.'@airtelmail.com';
								}elseif ($carrier == 'bplmobile9823'){
										$mobile = '9823'.$number.'@bplmobile.com';
								}elseif ($carrier == 'ideacellular'){
										$mobile = ''.$number.'@ideacellular.net';
								}elseif ($carrier == 'gscsms'){
										$mobile = ''.$number.'@gscsms.com';
								}elseif ($carrier == 'google'){
										// Doesn't work without Google Account authentication or other customizations
										$mobile = '1'.$number.'@txt.voice.google.com';
								}elseif ($carrier == 'airtelg'){
										$mobile = '919898'.$number.'@airtelmail.com';
								}elseif ($carrier == 'celforce'){
										$mobile = '9825'.$number.'@celforce.com';
								}elseif ($carrier == 'airtelh'){
										$mobile = '919896'.$number.'@airtelmail.com';
								}elseif ($carrier == 'escotelmobile9812'){
										$mobile = '9812'.$number.'@escotelmobile.com';
								}elseif ($carrier == 'sprintpcshawaii'){
										$mobile = ''.$number.'@hawaii.sprintpcs.com';
								}elseif ($carrier == 'haysystems'){
										$mobile = ''.$number.'@sms.haysystems.com';
								}elseif ($carrier == 'myhelio'){
										$mobile = ''.$number.'@myhelio.com';
								}elseif ($carrier == 'airtelmail919816'){
										$mobile = '919816'.$number.'@airtelmail.com';
								}elseif ($carrier == 'ice'){
										$mobile = ''.$number.'@ice.cr';
								}elseif ($carrier == 'iwspcs'){
										$mobile = ''.$number.'.iws@iwspcs.net';
								}elseif ($carrier == 'iwirelesshometext'){
										$mobile = ''.$number.'@iwirelesshometext.com';
								}elseif ($carrier == 'kajeet'){
										$mobile = ''.$number.'@mobile.kajeet.net';
								}elseif ($carrier == 'airtelkk'){
										$mobile = '919845'.$number.'@airtelkk.com';
								}elseif ($carrier == 'airtelkerala'){
										$mobile = '919895'.$number.'@airtelkerala.com';
								}elseif ($carrier == 'bplmobile9846'){
										$mobile = '9846'.$number.'@bplmobile.com';
								}elseif ($carrier == 'escotelmobile9847'){
										$mobile = '9847'.$number.'@escotelmobile.com';
								}elseif ($carrier == 'telus'){
										$mobile = ''.$number.'@msg.telus.com';
								}elseif ($carrier == 'longlines'){
										$mobile = ''.$number.'@text.longlines.com';
								}elseif ($carrier == 'loopmobile'){
										$mobile = ''.$number.'@loopmobile.co.in';
								}elseif ($carrier == 'm1'){
										$mobile = ''.$number.'@m1.com.sg';
								}elseif ($carrier == 'airtelmail919893'){
										$mobile = '919893'.$number.'@airtelmail.com';
								}elseif ($carrier == 'airtelmail919890'){
										$mobile = '919890'.$number.'@airtelmail.com';
								}elseif ($carrier == 'ideacellular'){
										$mobile = ''.$number.'@ideacellular.net';
								}elseif ($carrier == 'mediaburst'){
										$mobile = ''.$number.'@sms.mediaburst.co.uk';
								}elseif ($carrier == 'spicenepal'){
										$mobile = '977'.$number.'@sms.spicenepal.com';
								}elseif ($carrier == 'mymeteor'){
										$mobile = ''.$number.'@sms.mymeteor.ie';
								}elseif ($carrier == 'mymetropcs'){
										$mobile = ''.$number.'@mymetropcs.com';
								}elseif ($carrier == 'mtel'){
										$mobile = '35988'.$number.'@sms.mtel.net';
								}elseif ($carrier == 'mobitel'){
										$mobile = ''.$number.'@sms.mobitel.lk';
								}elseif ($carrier == 'movistarargentina'){
										$mobile = ''.$number.'@sms.movistar.net.ar';
								}elseif ($carrier == 'movistarcolumbia'){
										$mobile = ''.$number.'@movistar.com.co';
								}elseif ($carrier == 'movistarspain'){
										$mobile = '0'.$number.'@movistar.net';
								}elseif ($carrier == 'movimensaje'){
										$mobile = ''.$number.'@movimensaje.com.ar';
								}elseif ($carrier == 'mtn'){
										$mobile = ''.$number.'@sms.co.za';
								}elseif ($carrier == 'mtsmobility'){
										$mobile = ''.$number.'@text.mtsmobility.com';
								}elseif ($carrier == 'airtelmail919892'){
										$mobile = '919892'.$number.'@airtelmail.com';
								}elseif ($carrier == 'bplmobile9821'){
										$mobile = '9821'.$number.'@bplmobile.com';
								}elseif ($carrier == 'my-cool-sms'){
										$mobile = ''.$number.'@my-cool-sms.com';
								}elseif ($carrier == 'nextel'){
										$mobile = ''.$number.'@messaging.nextel.com';
								}elseif ($carrier == 'msgnextel'){
										$mobile = ''.$number.'@msgnextel.com.mx';
								}elseif ($carrier == 'nextelargentina'){
										$mobile = 'TwoWay.11'.$number.'@nextel.net.ar';
								}elseif ($carrier == 'docomo'){
										$mobile = ''.$number.'@docomo.ne.jp';
								}elseif ($carrier == 'o2online'){
										$mobile = '0'.$number.'@o2online.de';
								}elseif ($carrier == 'celloneusa'){
										$mobile = ''.$number.'@mobile.celloneusa.com';
								}elseif ($carrier == 'mmail'){
										$mobile = '44'.$number.'@mmail.co.uk';
								}elseif ($carrier == 'ogvodafone'){
										$mobile = ''.$number.'@sms.is';
								}elseif ($carrier == 'orangepl'){
										$mobile = '9digit@orange.pl';
								}elseif ($carrier == 'orangenl'){
										$mobile = '0'.$number.'@sms.orange.nl';
								}elseif ($carrier == 'orange'){
										$mobile = ''.$number.'@orange.net';
								}elseif ($carrier == 'ozekisms'){
										$mobile = ''.$number.'@ozekisms.com';
								}elseif ($carrier == 'vtext'){
										$mobile = ''.$number.'@vtext.com';
								}elseif ($carrier == 'panaceamobile'){
										$mobile = ''.$number.'@api.panaceamobile.com';
								}elseif ($carrier == 'zsend'){
										$mobile = ''.$number.'@zsend.com';
								}elseif ($carrier == 'pocket'){
										$mobile = ''.$number.'@sms.pocket.com';
								}elseif ($carrier == 'bplmobile9843'){
										$mobile = '9843'.$number.'@bplmobile.com';
								}elseif ($carrier == 'mobiletxt'){
										$mobile = ''.$number.'@mobiletxt.ca';
								}elseif ($carrier == 'airtelmail919815'){
										$mobile = '919815'.$number.'@airtelmail.com';
								}elseif ($carrier == 'qwestmp'){
										$mobile = ''.$number.'@qwestmp.com';
								}elseif ($carrier == 'rogers'){
										$mobile = ''.$number.'@pcs.rogers.com';
								}elseif ($carrier == 'routomessaging'){
										$mobile = ''.$number.'@email2sms.routomessaging.com';
								}elseif ($carrier == 'sasktel'){
										$mobile = ''.$number.'@sms.sasktel.com';
								}elseif ($carrier == 'box'){
										$mobile = ''.$number.'@box.is';
								}elseif ($carrier == 'simple'){
										$mobile = ''.$number.'@smtext.com';
								}elseif ($carrier == 'smscentral'){
										$mobile = ''.$number.'@sms.smscentral.com.au';
								}elseif ($carrier == 'starhub'){
										$mobile = ''.$number.'@starhub-enterprisemessaging.com';
								}elseif ($carrier == 'rinasms'){
										$mobile = ''.$number.'@rinasms.com';
								}elseif ($carrier == 'spikkosms'){
										$mobile = ''.$number.'@spikkosms.com';
								}elseif ($carrier == 'sprintpcs'){
										$mobile = ''.$number.'@messaging.sprintpcs.com';
								}elseif ($carrier == 'sprintnextel'){
										$mobile = ''.$number.'@page.nextel.com';
								}elseif ($carrier == 'straighttalk'){
										$mobile = ''.$number.'@vtext.com';
								}elseif ($carrier == 'sunrise'){
										$mobile = ''.$number.'@gsm.sunrise.ch';
								}elseif ($carrier == 'tmomail'){
										$mobile = '1'.$number.'@tmomail.net';
								}elseif ($carrier == 'optusmobile'){
										$mobile = '0'.$number.'@optusmobile.com.au';
								}elseif ($carrier == 'tmobileat'){
										$mobile = '43676'.$number.'@sms.t-mobile.at';
								}elseif ($carrier == 'tmobilehr'){
										$mobile = '385'.$number.'@sms.t-mobile.hr';
								}elseif ($carrier == 'tmobilede'){
										$mobile = ''.$number.'@t-mobile-sms.de';
								}elseif ($carrier == 'gin'){
										$mobile = '31'.$number.'@gin.nl';
								}elseif ($carrier == 'airtelmobile'){
										$mobile = '919894'.$number.'@airtelmobile.com';
								}elseif ($carrier == 'airsms'){
										$mobile = '9842'.$number.'@airsms.com';
								}elseif ($carrier == 'bplmobile919843'){
										$mobile = '919843'.$number.'@bplmobile.com';
								}elseif ($carrier == 'tele2'){
										$mobile = '0'.$number.'@sms.tele2.se';
								}elseif ($carrier == 'etxt'){
										$mobile = ''.$number.'@etxt.co.nz';
								}elseif ($carrier == 'teleflip'){
										$mobile = ''.$number.'@teleflip.com';
								}elseif ($carrier == 'telus'){
										$mobile = ''.$number.'@msg.telus.com';
								}elseif ($carrier == 'esms'){
										$mobile = ''.$number.'@esms.nu';
								}elseif ($carrier == 'tigo'){
										$mobile = ''.$number.'@sms.tigo.com.co';
								}elseif ($carrier == 'timnet'){
										$mobile = '0'.$number.'@timnet.com';
								}elseif ($carrier == 'tracfone'){
										$mobile = ''.$number.'@mmst5.tracfone.com';
								}elseif ($carrier == 'txtlocal'){
										$mobile = ''.$number.'@txtlocal.co.uk';
								}elseif ($carrier == 'utext'){
										$mobile = ''.$number.'@utext.com';
								}elseif ($carrier == 'viawebsms'){
										$mobile = ''.$number.'@viawebsms.com';
								}elseif ($carrier == 'uscc'){
										$mobile = ''.$number.'@email.uscc.net';
								}elseif ($carrier == 'usamobility'){
										$mobile = ''.$number.'@usamobility.net';
								}elseif ($carrier == 'utbox'){
										$mobile = ''.$number.'@sms.utbox.net';
								}elseif ($carrier == 'escotelmobile'){
										$mobile = '9837'.$number.'@escotelmobile.com';
								}elseif ($carrier == 'vtext'){
										$mobile = ''.$number.'@vtext.com';
								}elseif ($carrier == 'viaerosms'){
										$mobile = ''.$number.'@viaerosms.com';
								}elseif ($carrier == 'vivacom'){
										$mobile = '35987'.$number.'@sms.vivacom.bg';
								}elseif ($carrier == 'torpedoemail'){
										$mobile = ''.$number.'@torpedoemail.com.br';
								}elseif ($carrier == 'vmobileca'){
										$mobile = ''.$number.'@vmobile.ca';
								}elseif ($carrier == 'vmobl'){
										$mobile = ''.$number.'@vmobl.com';
								}elseif ($carrier == 'vxtras'){
										$mobile = ''.$number.'@vxtras.com';
								}elseif ($carrier == 'voda'){
										$mobile = ''.$number.'@voda.co.za';
								}elseif ($carrier == 'vodafonede'){
										$mobile = '0'.$number.'@vodafone-sms.de';
								}elseif ($carrier == 'vodafoneit'){
										$mobile = '3**'.$number.'@sms.vodafone.it';
								}elseif ($carrier == 'vodafonejpn'){
										$mobile = ''.$number.'@n.vodafone.ne.jp';
								}elseif ($carrier == 'vodafonejpd'){
										$mobile = ''.$number.'@d.vodafone.ne.jp';
								}elseif ($carrier == 'vodafonejpr'){
										$mobile = ''.$number.'@r.vodafone.ne.jp';
								}elseif ($carrier == 'vodafonejpk'){
										$mobile = ''.$number.'@k.vodafone.ne.jp';
								}elseif ($carrier == 'vodafonejpt'){
										$mobile = ''.$number.'@t.vodafone.ne.jp';
								}elseif ($carrier == 'vodafonejpq'){
										$mobile = ''.$number.'@q.vodafone.ne.jp';
								}elseif ($carrier == 'vodafonejps'){
										$mobile = ''.$number.'@s.vodafone.ne.jp';
								}elseif ($carrier == 'vodafonejph'){
										$mobile = ''.$number.'@h.vodafone.ne.jp';
								}elseif ($carrier == 'vodafonedees'){
										$mobile = '0'.$number.'@vodafone.es';
								}elseif ($carrier == 'mtxt'){
										$mobile = ''.$number.'@mtxt.co.nz';
								}elseif ($carrier == 'pdx'){
										$mobile = ''.$number.'@pdx.ne.jp';
								}elseif ($carrier == 'windmobile'){
										$mobile = ''.$number.'@text.windmobile.ca';
								}elseif ($carrier == 'xit'){
										$mobile = ''.$number.'@sms.xit.net';
								}else{
										// No Carrier Matches!
										$mobile = '';
										// echo 'Failed to find a carrier!';
										// die;
								}
								
								if(empty($_POST['optout'])) {		
									$time = time();
									$verificationHash = hash('md5', $username . $time);
									$optstatus = 0;
									
									$sql = "INSERT INTO users (id, username, password, mobile, optstatus, verification) VALUES ('NULL', '$username', '$hash', '$mobile', '$optstatus', '$verificationHash')";
									$registry = mysqliQuery($sql);
									$sql = "INSERT INTO allusers (id, username) VALUES ('NULL', '$username')";
									$addToAllUsers = mysqliQuery($sql);
									
									// To send HTML mail, the Content-type header must be set
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									$from = 'admin@thedreamteam.me';
									$headers .= 'From: '.$from."\r\n".
										'X-Mailer: PHP/' . phpversion();
									
									$usernameHash = hash('md5', $username);
									$url = 'http://thedreamteam.me/acctVrfy.php?id='.$verificationHash;
									$message = '<html><body>';
									$message .= 'Thank you for taking the time to register with the UMSL Music Department Announcement System!<br />';
									$message .= '<br />Please click the following link to verify your account and complete the registration.<br />';
									$message .= '<a href="'.$url.'"> '.$url.' </a><br />';
									$message .= '<br />Thank you,';
									$message .= '<br />Music Dept Staff';
									$message .= '</body></html>';
									mail($username, "Please Verify Your Account", $message, $headers);
										
									mysqli_free_result($registry);
									mysqli_free_result($addToAllUsers);
									
									header("location: acctVrfy.php");
								} else {
									$time = time();
									$verificationHash = hash('md5', $username . $number . $carrier . $time);
									$optstatus = 1;
									
									$sql = "INSERT INTO users (id, username, password, mobile, optstatus, verification) VALUES ('NULL', '$username', '$hash', '$mobile', '$optstatus', '$verificationHash')";
									$registry = mysqliQuery($sql);
									$sql = "INSERT INTO allusers (id, username) VALUES ('NULL', '$username')";
									$addToAllUsers = mysqliQuery($sql);
									
									$url = 'http://thedreamteam.me/acctVrfy.php?id='.$verificationHash;
									mail($mobile, "Verify Your Account", $url, "From: admin");
										
									mysqli_free_result($registry);
									mysqli_free_result($addToAllUsers);
									
									header("location: acctVrfy.php");
								}
							}
						}
						
						mysqli_free_result($checkuser);
					}
				
				// Display errors next to the incorrectly filled out forms
				} else {
					if (empty($_POST["username"])) {
						$usernameError = "Username is a required field!";
					}
					
					if (empty($_POST["password"])) {
						$usernameError = "Password is a required field!";
					}
					
					if (!empty($_POST["optout"]) && (empty($_POST['mobile_carrier']) || empty($_POST['mobile_number']))) {
						$phoneNumberError = "If you're not opting out of the text alerts, you must enter your phone carrier and number!";
					}
				}
			}
				
			
		?>
		
		<!-- The registration form -->
		
		<p><span class="error">* denotes a required field</span><br />
		<span class="error">** is required if opting in</span></p>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
			<label for="username">Username (USML Email): </label> <input type="text" name="username">
			<span class="error">* <?php echo $usernameError; ?></span>
			<br /><br />
			
			<label for="password">Password: </label> <input type="password" name="password">
			<span class="error">* <?php echo $passwordError; ?></span>
			<br /><br />
			
			<label for="passwordVerify">Re-enter Password: </label> <input type="password" name="passwordVerify">
			<span class="error">* <?php echo $passwordVerifyError; ?></span>
			<br /><br /><br />
			
			<input type="checkbox" name="optout" class="checkStyle" id="optout" onclick="javascript:if (confirm('<?php echo $optOutMessage; ?>'))
				{document.getElementById('optout').checked = false;}else{document.getElementById('optout').checked = true;}; " checked /> Opt In To Text Alerts <br />
			
			<p>Mobile Carrier:
			<select name="mobile_carrier" id="mobile_carrier" onChange="selected()">
					<option value="none"></option>
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
			</select>
			<span class="error">** <?php echo $phoneCarrierError; ?></span></p>
			<p>Mobile Number:
			<input type="text" id="mobile_number" name="mobile_number" maxlength="20" onKeyPress="return numbersonly(event, false)" /> 
			<span class="error">** <?php echo $phoneNumberError; ?></span></p>
			<br />

			<span class="error">WARNING: For the sake of security <u<b>DO NOT</u></b> use the password you use to log into MyGateway, MyView, or any other UM SSO systems.</span>
			<br /><br />
			<input type="submit" name="submit" value="Submit" class="buttonForm">&nbsp;<a href="index.php" class="buttonForm">Cancel</a>
		</form>
		
	</body>
</html>