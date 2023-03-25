<?php # Script 17.1 - add_cart.php
// This page adds prints to the shopping cart.

session_start();

// Set the page title and include the HTML header:
$page_title = 'Best Deal | Προσθήκη στο καλάθι';

if( !(isset($_SESSION['user_id'])) )
{
	include ('./includes/header.html');
	echo '<p class="error"><br> Δεν έχετε συνδεθεί! <br><br></p>';
	include ('./includes/footer.html');
}
else
{
include ('includes/header.html');

if (isset ($_GET['pid']) && is_numeric($_GET['pid']) ) { // Check for a print ID.

	$pid = (int) $_GET['pid'];

	// Check if the cart already contains one of these prints;
	// If so, increment the quantity:
	if (isset($_SESSION['cart'][$pid]))
	{
	
		$_SESSION['cart'][$pid]['quantity']++; // Add another.

		// Display a message.
		echo "<p class='success'><br>Το προϊόν υπήρχε ήδη στο καλάθι σας και η ποσότητά του είναι πλέον {$_SESSION['cart'][$pid]['quantity']}.<br><br></p>";
		
	}
	else		// New product to the cart.
	{

		// Get the print's price from the database:
		require_once ('mysqli_connect.php');
		$q = "SELECT price FROM products WHERE product_id = $pid";
		$r = mysqli_query ($dbc, $q);
		if (mysqli_num_rows($r) == 1) { // Valid print ID.
		
			// Fetch the information.
			list($price) = mysqli_fetch_array ($r, MYSQLI_NUM);
			
			// Add to the cart:
			$_SESSION['cart'][$pid] = array ('quantity' => 1, 'price' => $price);

			// Display a message:
			echo '<p class="success"><br>Το προϊόν προστέθηκε στο καλάθι σας.<br><br></p>';

		} else { // Not a valid print ID.
			echo '<div align="center">Ζητήσατε κάτι που δεν υπάρχει στο Best Deal. <a href=\"index.php\">Επιστροφή στην αρχική σελίδα</div>';
		}
		
		mysqli_close($dbc);

	} // End of isset($_SESSION['cart'][$pid] conditional.

} else { // No print ID.
	echo '<div align="center">Ζητήσατε κάτι που δεν υπάρχει στο Best Deal. <a href=\"index.php\">Επιστροφή στην αρχική σελίδα</div>';
}

include ('includes/footer.html');
}
?>
