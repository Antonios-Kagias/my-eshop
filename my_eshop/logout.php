<?php # Script 17.11 - logout.php #2
// This page lets the user logout.

session_start(); // Access the existing session.

// If no session variable exists, redirect the user:
if (!isset($_SESSION['user_id']))
{

	require_once ('includes/login_functions.inc.php');
	$url = absolute_url();
	header("Location: $url");
	exit();

} else	// Cancel the session.
{

	$_SESSION = array(); // Clear the variables.
	session_destroy(); // Destroy the session itself.
}

// Set the page title and include the HTML header:
$page_title = 'Best Deal | Αποσύνδεση';
include ('includes/header.html');

// Print a customized message:
echo "<div class='success'><br>Έχετε αποσυνδεθεί επιτυχώς! <br><br></div>";

include ('includes/footer.html');
?>
