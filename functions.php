<!-- 
functions.php
Created by Tom Grossman on 3/24/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<?php


function processText($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function removeGroup($group) {
	include "dbcontroller.php";
	$groupChildren = mysqli_query($conn, "SELECT groupName FROM groups WHERE groupParent='$group'") or die(mysqli_error($conn));
	
	if(mysqli_num_rows($groupChildren) > 0) {
		while($nextGroup = mysqli_fetch_row($groupChildren)) {
			$next = $nextGroup[0];
			removeGroup($next);
		}
	}
		
	$deleteChildren = mysqli_query($conn, "DELETE FROM groups WHERE groupParent ='$group'") or die(mysqli_error($conn));
	$deleteGroup = mysqli_query($conn, "DELETE FROM groups WHERE groupName='$group'") or die(mysqli_error($conn));
	$deleteTable = mysqli_query($conn, "DROP TABLE $group") or die(mysqli_error($conn));
	
	echo "Deleted " . $group . " successfully <br />";
}

?>
