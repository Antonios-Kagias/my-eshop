<?php # Script 17.7 - checkout.php
// This page inserts the order information into the table.
// This page would come after the billing process.
// This page assumes that the billing process worked (the money has been taken).

session_start();

// Set the page title and include the HTML header.
$page_title = 'Best Deal | Επιβεβαίωση Παραγγελίας';
include ('includes/header.html');

if(isset($_SESSION['user_id']))
{
	$uid = $_SESSION['user_id'];
}


$total = 0;
foreach ($_SESSION['cart'] as $pid => $item)
{
	$qty = $item['quantity'];
	$price = $item['price'];
	$subtotal = $qty * $price;
	$total += $subtotal;
}

require_once ('mysqli_connect.php'); // Connect to the database.

// Turn autocommit off.
mysqli_autocommit($dbc, FALSE);

// Add the order to the orders table...
$q = "INSERT INTO orders (user_id, total) VALUES ($uid, $total)";
$r = mysqli_query($dbc, $q);
if (mysqli_affected_rows($dbc) == 1) {

	// Need the order ID:
	$oid = mysqli_insert_id($dbc);
	
	// Insert the specific order contents into the database...
	
	// Prepare the query:
	$q = "INSERT INTO order_contents (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
	$stmt = mysqli_prepare($dbc, $q);
	mysqli_stmt_bind_param($stmt, 'iiid', $oid, $pid, $qty, $price);
	
	// Execute each query, count the total affected:
	$affected = 0;
	foreach ($_SESSION['cart'] as $pid => $item) {
		$qty = $item['quantity'];
		$price = $item['price'];
		mysqli_stmt_execute($stmt);
		$affected += mysqli_stmt_affected_rows($stmt);
	}

	// Close this prepared statement:
	mysqli_stmt_close($stmt);

	// Report on the success....
	if ($affected == count($_SESSION['cart'])) { // Whohoo!
	
		// Commit the transaction:
		mysqli_commit($dbc);
		
		// Clear the cart.
		unset($_SESSION['cart']);
		
		// Message to the customer:
		echo '<p>Ευχαριστούμε για την προτίμησή σας. Αν υποθέσουμε ότι έχουμε έστω και ένα προϊόν, η παραγγελία σας θα παραδοθεί σε 1-2 εργάσιμες μέρες! :-)</p>';
		
		// Send emails and do whatever else.
	
	} else { // Rollback and report the problem.
	
		mysqli_rollback($dbc);
		
		echo '<p>Λυπούμαστε, αλλά προέκυψε κάποιο σφάλμα στη διαδικασία παραγγελίας. Μπορείτε να προσπαθήσετε ξανά σε λίγο.</p>';
		// Send the order information to the administrator.
		
	}

} else { // Rollback and report the problem.

	mysqli_rollback($dbc);

	echo '<p>Λυπούμαστε, αλλά προέκυψε κάποιο σφάλμα στη διαδικασία παραγγελίας. Μπορείτε να προσπαθήσετε ξανά σε λίγο.</p>';
	
	// Send the order information to the administrator.
	
}

mysqli_close($dbc);

include ('./includes/footer.html');
?>
