<!-- 
logout.php
Created by Tom Grossman on 3/24/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<?php

	include "systemConfiguration.php";
	
	$_SESSION = array(); 
	session_destroy(); 
	mysqli_close();
	
?>

<meta http-equiv="refresh" content="0;index.php">