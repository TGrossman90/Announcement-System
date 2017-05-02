<!-- 
updateUser.php
Created by Tom Grossman on 4/25/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML>  
<html>
	<head>
		<title>UMSL Music: User Control Panel</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	</head>
	<body>  
		<div id="main" class="shadow" style="text-align: center;">
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			
			<?php
			
				//Includes
				include "functions.php";
				include "systemConfiguration.php";
				
				if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['loggedin'] == 1) { 
					$username = processText($_SESSION['username']);
					
					if(!empty($_POST['updateName'])) {
						$name = processText($_POST['updateName']);
						$sql = "UPDATE users SET name='$name' WHERE username='$username'";
						$query = mysqliQuery($sql);
						mysqli_free_result($query);
						
						echo '<p>Your display name was changed successfully!</p>';
					}
					
					if(!empty($_POST['oldPassword'])) {
						if(!empty($_POST['newPassword'])) {
							if(!empty($_POST['newPasswordVerify'])) {
								
								if($_POST['newPassword'] == $_POST['newPasswordVerify']) {
									$password = processText($_POST['newPassword']);
									$oldPassword = processText($_POST['oldPassword']);
									
									$sql = "SELECT password FROM users WHERE username='$username'";
									$query = mysqliQuery($sql);
									if(mysqli_num_rows($query) == 1) {
										$oldPasswordHash = mysqli_fetch_row($query);
										
										if(password_verify($oldPassword, $oldPasswordHash[0])) {
											$newPasswordHash = password_hash($password, PASSWORD_BCRYPT);
											$sql = "UPDATE users SET password='$newPasswordHash' WHERE username='$username'";
											$query = mysqliQuery($sql);
											mysqli_free_result($query);
											
											echo '<p>Your password was changed successfully!</p>';
										} else {
											echo '<p>You\'ve entered your old password incorrectly</p>';
										}
									}
									
									mysqli_free_result($query);
								} else {
										echo '<p>Your passwords do not match!</p>';
								}
							} else {
								echo '<p>You have to re-enter your password!</p>';
							}
						} else {
							echo '<p>You can\'t change your password without entering a new one!</p>';
						}
					}
					
					if((!empty($_POST['newPassword']) || !empty($_POST['newPasswordVerify'])) && empty($_POST['oldPassword'])) {
						echo '<p>You have to enter your old password before you can change it!</p>';
					}
					
					if(!empty($_POST['optout']) && empty($_POST['optin'])) {
						$sql = "UPDATE users SET optstatus='0' WHERE username='$username'";
						$query = mysqliQuery($sql);
						
						$sql = "UPDATE users SET mobile='' WHERE username='$username'";
						$query = mysqliQuery($sql);
						mysqli_free_result($query);
						
						echo '<p>You\'ve successfully opted-out of receiving text alerts!</p>';
					} else if(empty($_POST['optout']) && !empty($_POST['optin'])) {
						$sql = "UPDATE users SET optstatus='1' WHERE username='$username'";
						$query = mysqliQuery($sql);
						mysqli_free_result($query);
						
						echo '<p>You\'ve successfully opted-in to receive text alerts!</p>';
					} else if(!empty($_POST['optout']) && !empty($_POST['optin'])) {
						echo '<p>You can\t opt-in and out at the same time!</p>';
					}
					
					if($_POST['mobile_carrier'] != "none") {
						$sql = "SELECT optstatus FROM users WHERE username='$username'";
						$query = mysqliQuery($sql);
						$optStatus = mysqli_fetch_row($query);
						
						if($optStatus[0] == 1) {
							if(!empty($_POST['mobile_number'])) {
								$number = processText($_POST['mobile_number']);
								$carrier = processText($_POST['mobile_carrier']);
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
								
								$sql = "UPDATE users SET mobile='$mobile' WHERE username='$username'";
								$query = mysqliQuery($sql);
								mysqli_free_result($query);
								
								echo '<p>Your mobile number/carrier were updated!</p>';
								
							} else {
								echo '<p>If you select a new carrier, you must enter a number as well!</p>';
							}
						} else if($optstatus[0] == 0) {
							echo '<p>You are currently opted out of text alerts</p>';
						}
					} else if($_POST['mobile_carrier'] == "none" && !empty($_POST['mobile_number'])) {
						echo '<p>If you enter a new number, you must also select a carrier!</p>';
					}
				}
				
				echo '<a href="index.php" class="buttonForm">Home</a>&nbsp;<a href="userCP.php" class="buttonForm">Go Back</a>';
			?>
		</div>
	</body>
</html>