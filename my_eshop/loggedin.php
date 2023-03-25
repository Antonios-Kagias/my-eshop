<?php # Script 17.9 - loggedin.php #2

// The user is redirected here from login.php.

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {
	require_once ('includes/login_functions.php');
	$url = absolute_url();
	header("Location: $url");
	exit();	
}

$page_title = 'Best Deal | Σύνδεση';
include ('includes/header.html');

// Print a customized message:
echo "<div class='success'>Επιτυχής σύνδεση
<p>Γεια σας, {$_SESSION['first_name']}!</p></div>";

include ('includes/footer.html');
?>
