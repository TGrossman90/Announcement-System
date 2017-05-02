<!-- 
dbcontroller.php
Created by Tom Grossman on 3/24/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<?php
	
	include "systemConfiguration.php";
	
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if(mysqli_connect_errno()) {
		die("Connection Failed: " . mysqli_connect_error());
	}
	
?>