<?php # Script 17.10 - login.php

if (isset($_POST['submitted'])) {

	require_once ('includes/login_functions.php');
	require_once ('mysqli_connect.php');
	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['password']);
	
	if ($check) { // OK!
			
		// Set the session data:.
		session_start();
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['first_name'] = $data['first_name'];
		
		// Redirect:
		$url = absolute_url ('loggedin.php');
		header("Location: $url");
		exit();
			
	} else { // Unsuccessful!
		$errors = $data;
	}
		
	mysqli_close($dbc);

} // End of the main submit conditional.

include ('includes/login_page.php');
?>
