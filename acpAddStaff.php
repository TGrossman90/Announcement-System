<!-- 
acpAddStaff.php
Created by Tom Grossman on 4/20/2017
Copyright © 2017 Tom Grossman. All Rights Reserved
-->

<!DOCTYPE HTML> 
<html>  
	<head>  
		<title>UMSL Music: Add Staff Accounts</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	</head>  
	<body>  
		<div id="main" style="text-align: center;" class="shadow">	
			<img src="/img/umslmusic_logo.png" id="logo" /> <br />
			
			<?php	
			
				// Includes
				include "functions.php";
				include "systemConfiguration.php";
				
				// Check if you're supposed to be here
				if((! $_SESSION['loggedin'] == 1) && (! $_SESSION['permissions'] == 100)) {
					echo "You do not have permission to be here!";
					header("location:index.php");
				}
				
			?>
					
			<form method="post" action="authStaff.php">
				<fieldset>
					<center><h2>Add Staff Accounts</h2></center>
					<p>Search for username:</p>
					
						<?php
							// Get all users
							$users = getAllUsers();
						?>

					<script>
						$( function() {
							var users = <?php echo json_encode($users); ?>;
							$( "#searchUsers" ).autocomplete({
								source: users
							});
						} );
					</script>
					
					<div class="ui-widget">
						<input type="text" id="searchUsers" name="user">
					</div> <br />
					
					<p>Is this a faculty or administrator account?</p>
					<div style="display: inline-block; text-align: left">
					<input type="radio" name="level" class="radioStyle" value="faculty" /> Faculty <br />
					<input type="radio" name="level" class="radioStyle" value="admin" /> Administrator <br />
					<br />
					</div>
					<h3>If this is a faculty account, please select groups that this faculty member will be allowed to manage. If you select a parent group, it will also allow the user to manage all subgroups! (skip for administrators)</h3>
					
					<div style="display: inline-block; text-align: left">
					
						<?php
							
							mysqli_free_result($users);
							// Get all groups
							$groups = getAllGroups();
							
							// Create an option with every group
							foreach($groups as $name) {
								
								if($name == ".None" || $name == "allusers" || $name == "faculty"){
									continue;
								}
								
								echo '<input type="checkbox" name="groups[]" class="checkStyle" value="'. $name .'">'. $name;
								echo '<br />';
							}
							
							mysqli_free_result($groups);
							
						?>
						
					</div>
					
					<br /> <br />
					<input type="submit" name="submit" value="Submit" class="buttonForm">&nbsp;<a href="acp.php" class="buttonForm">Cancel</a>
				</fieldset>
			</form>
		</div>
	</body>
</html>
			