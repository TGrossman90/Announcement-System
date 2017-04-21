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

function mysqliQuery($sqlQuery) {
	include "dbcontroller.php";
	
	$result = mysqli_query($conn, $sqlQuery) or die(mysqli_error($conn));
	
	if($result) {
		return $result;
	} else {
		echo '<p>There was a problem! :(</p>';
	}
}

function getAllUsers() {
	// Get all users
	$sql = "SELECT username FROM users WHERE userLevel='10'";
	$result = mysqliQuery($sql);
					
	$users = array();
	while($user = mysqli_fetch_row($result)) {
		array_push($users, $user[0]);
	}
	sort($users);
	
	return $users;
}

function getUsersFromGroup($group) {
	// Get all users
	$sql = "SELECT userName FROM $group";
	$result = mysqliQuery($sql);
					
	$users = array();
	while($user = mysqli_fetch_row($result)) {
		array_push($users, $user[0]);
	}
	sort($users);
	
	return $users;
}

function getAllStaffUsers() {
	$sql = "SELECT username FROM faculty";
	$result = mysqliQuery($sql);
	
	$users = array();
	while($user = mysqli_fetch_row($result)) {
		array_push($users, $user[0]);
	}
	sort($users);
	
	return $users;
}

function getAllGroups() {
	// Get all groups
	$sql = "SELECT groupName FROM groups";
	$result = mysqliQuery($sql);
	
	$groups = array();
	while($group = mysqli_fetch_row($result)) {						
		array_push($groups, $group[0]);
	}
	sort($groups);
	
	return $groups;
}

function getAllChildrenGroups() {
	// Get all groups
	$sql = "SELECT groupName FROM groups WHERE groupParent IS NOT NULL";
	$result = mysqliQuery($sql);

	$groups = array();
	while($group = mysqli_fetch_row($result)) {
		array_push($groups, $group[0]);
	}
	sort($groups);
	
	return $groups;
}
?>
