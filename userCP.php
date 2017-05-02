<!-- 
userCP.php
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
				
				$optOutMessage = "Are you sure you want to opt out of text alerts? (not recommended unless there are mobile plan restrictions)";
				$optInMessage = "By opting in to text alerts, standard text messaging rates apply -- see your carrier plan for details";
				
				if($_SESSION['loggedin'] == 1) {
					echo '<form method="post" action="updateUser.php">';
					
					if($_SESSION['permissions'] >= 50 && $_SESSION['username'] != $globalAdmin) {
						echo '<h4>Update your display name:</h4>';
						echo '<p>(your display name is the name that appears in the author field of announcements)</p>';
						echo '<input type="text" name="updateName" /> <br />';
					}
					
					if($_SESSION['permissions'] >= 10) {
						echo '<h4>Change your password</h4>';
						echo '<p>Enter your current password</p>';
						echo '<input type="password" name="oldPassword" /> <br />';
						echo '<p>Enter your new password</p>';
						echo '<input type="password" name="newPassword" /> <br />';
						echo '<p>Re-enter your new password</p>';
						echo '<input type="password" name="newPasswordVerify" /> <br />';
						
						if($_SESSION['username'] != $globalAdmin) {
							echo '<h4>Change your mobile number/carrier/opt status</h4>';
							?>
							<div style="display: inline-block; text-align: left">
								<input type="checkbox" name="optout" class="checkStyle" id="optout" onclick="javascript:if (confirm('<?php echo $optOutMessage; ?>'))
							{document.getElementById('optout').checked = true;}else{document.getElementById('optout').checked = false;}; " /> Opt-Out of Text Alerts <br />
								<input type="checkbox" name="optin" class="checkStyle" id="optin" onclick="javascript:if (confirm('<?php echo $optInMessage; ?>'))
							{document.getElementById('optin').checked = true;}else{document.getElementById('optin').checked = false;}; " /> Opt-In to Text Alerts <br /> <br />
							</div>
							
							<p>Pick a carrier</p>
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
						
						<?php 
							echo '<p>Mobile Number</p>';
							echo '<input type="text" id="mobile_number" name="mobile_number" maxlength="20" onKeyPress="return numbersonly(event, false)" /> ';
						}
						
						echo '<br /> <br /><input type="submit" name="submit" value="Submit" class="buttonForm">&nbsp;<a href="index.php" class="buttonForm">Cancel</a>';
					}
					
				} else {
					header("location:index.php");
				}
				
			?>
		</div>
	</body>
</html>