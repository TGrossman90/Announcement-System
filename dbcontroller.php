<!-- 
dbcontroller.php
Created by Tom Grossman on 3/24/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<?php
	
	session_start();
	
	$dbhost = "localhost";
	$dbuser = "umslmusic";
	$dbpass = "cs4500groupproject";
	$db = "umsl_musicdept";
	
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
	if(mysqli_connect_errno()) {
		die("Connection Failed: " . mysqli_connect_error());
	}
	
?>