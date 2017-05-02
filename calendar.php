<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Calendar</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
		<style>
			div#list {
				border: 1px solid #ff9900;
				padding: 1% 2% 0% 2%;
				margin: 2% 1% 0% 2%;
				box-shadow: 1px 1px 2px 2px #111111;
				border-radius: 1%;
				background-color: #640000;
				color: #ff9900;
			}

			div#event {
				border: 1px solid #ff9900;
				padding: 1% 2% 0% 2%;
				margin: 2% 1% 0% 2%;
				box-shadow: 1px 1px 2px 2px #111111;
				border-radius: 1%;
				background-color: #990000;
				color: white;
			}
			hr{
				height: 3px;
				border: 0;
			}
		</style>
	</head>
	<body>
		<div id="main" style="text-align:center;" class="shadow">
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			<?php
				include "systemConfiguration.php";
				
				//if($_SESSION['loggedin'] == 1) {
				
					ini_set('display_errors', 'On');
					error_reporting(E_ALL | E_STRICT);
					require_once '/var/www/html/google-api-php-client-2.1.3/vendor/autoload.php';
					putenv(''); // Google service_account key
					define('SCOPES', implode(' ', array(Google_Service_Calendar::CALENDAR_READONLY)));
					$client = new Google_Client();
					$client->useApplicationDefaultCredentials();
					$client->setScopes(SCOPES);
					$service = new Google_Service_Calendar($client);
					$calendarId = 'umslmusic@gmail.com';
					$optParams = array(
						'alwaysIncludeEmail'=> FALSE,
						'orderBy' => 'startTime',
						'singleEvents' => TRUE,
						'showDeleted'=>FALSE,
						'showHiddenInvitations'=>FALSE,
						'timeMin' => date('c'),
					);
					// php documentation 
					// https://developers.google.com/resources/api-libraries/documentation/calendar/v3/php/latest/class-Google_Service_Calendar.html
					// Google_Service_Calendar => Google_Service_Calendar_Events_Resource => Google_Service_Calendar_Events => Class Google_Service_Calendar_Event
					$results = $service->events->listEvents($calendarId, $optParams);
					if (count($results->getItems()) == 0) {
						printf("No Events Found ;_; try <a href=\"https://calendar.google.com/calendar/embed?src=umslmusic@gmail.com&ctz=America/Chicago\">this Google Calendar</a>, emailing music@umsl.edu , or calling 314-516-5980 for event information.<br />");
					} else {
						$day=0;
						echo("<a href=\"https://calendar.google.com/calendar/embed?src=umslmusic@gmail.com&ctz=America/Chicago\">Google Calendar source</a><br />");
						echo("For questions regarding the calendar, please email music@umsl.edu or call 314-516-5980.<br />");
						echo '<a href="index.php" class="buttonFormThin">Go Back</a>';
						foreach ($results->getItems() as $event) {
							$sum = $event->getSummary();
							$desc= $event->getDescription();
							$loc = $event->getLocation();
							if (!empty($loc)){
								$map = "https://www.google.com/maps/search/";
								$map.=preg_replace("/\s/", "+", $loc);
							}
							preg_match("/..:../", $event->getStart()->dateTime, $srt);
							preg_match("/..:../", $event->getEnd()->dateTime, $end);
							if (!empty($event->getStart()->dateTime)){
								preg_match("/^.{10}/",$event->getStart()->dateTime,$date);
								$date = preg_split("/-/", $date[0]);
								$time = mktime(0,0,0,$date[1],$date[2],$date[0]);
								if ($time > $day){
									if ($day != 0){
										echo ("<hr></div>\n");
									}
									$startDateStr=strftime("%A %B %d, %Y",$time);
									$day = $time;
									echo ("<div id=\"list\">\n");
								} else {
									$startDateStr="";
								}
							}
							if (!empty($event->getEnd()->date)){
								$date = preg_split("/-/", $event->getStart()->date);
								$time = mktime(0,0,0,$date[1],$date[2],$date[0]);
								$startDateStr=strftime("%A %B %d, %Y",$time);
								$date=preg_split("/-/", $event->getEnd()->date);
								$time = mktime(0,0,0,$date[1],$date[2],$date[0]);
								$endDateStr=strftime("%A %B %d, %Y",$time);
								echo ("<hr></div>\n");
							} else {
								$endDateStr="";
							}
							//=====================================================
							if (!empty($endDateStr)){
								echo ("<div id=\"list\">\n");
								echo "<b><hr>$startDateStr - $endDateStr</b>\n<hr>\n";
								echo ("<div id=\"event\">\n");
							} else {
								echo "<b>$startDateStr</b>\n<hr>\n";
								echo ("<div id=\"event\">\n");
							}
							echo ("$sum<br />\n");
							echo "<hr>\n";
							if (!empty($srt)){
								echo "$srt[0]";
								if(!empty($end)){
									echo " - $end[0] <br />\n";
									echo "<hr>\n";
								} else {
									echo "<br />\n";
									echo "<hr>\n";
								}
							} else if (!empty($end)){
								echo "Ends at $end[0]<br />\n";
								echo "<hr>\n";
							}
							if (!empty($loc)){
								echo ("$loc <br /><a href=\"$map\" class=\"buttonFormMini\">View Map</a><br />\n");
							}
							if (!empty($desc)){
								echo "<hr>\n";
								echo ("$desc<br />\n");
							}
							if (!empty($endDateStr)){
								echo("</div>\n");
								echo ("<hr></div>\n");
							} else {
								echo ("<hr></div>\n");
							}
						}
						
					}
					echo '<a href="index.php" class="buttonForm">Go Back</a>';
			//	} else {
			//		header("location: index.php");
			//	}
			?>
		</div>
	</body>
</html>
