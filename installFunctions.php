<?php  

	$dbroot = ""; // Change this to be the root database user
	$dbrootpass = ""; // Change this to be the root database user password
	
	function processText($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	function mysqliQuery($sqlQuery) {
		$result = mysqli_query($conn, $sqlQuery) or die(mysqli_error($conn));
		
		if($result) {
			return $result;
		} else {
			echo '<p>There was a problem! :(</p>';
		}
	}
	
?>