<?php # Script 17.14 - order_contents.php
// This page displays a user's order details.

session_start(); // Start the session.

$flag = FALSE;

$page_title = 'Best Deal | Λεπτομέρειες παραγγελίας';
include ('includes/header.html');

require_once ('mysqli_connect.php');
if(isset($_SESSION['user_id']))
	$uid = $_SESSION['user_id'];

if (isset($_GET['oid']) && is_numeric($_GET['oid']) ) { // Make sure there's a oc_id!

	$oid = (int) $_GET['oid'];
	
	// Get the print info:
	

	$q = "	SELECT users.user_id, orders.order_id AS 'Κωδ. Παραγγελίας', users.first_name, users.last_name, products.product_name AS 'Προϊόν', products.price AS 'Τιμή', order_contents.quantity AS 'Ποσότητα', products.product_id, DATE_FORMAT(orders.order_date, '%d-%m-%Y') AS 'Ημ/νία Παραγγελίας'
			FROM users, orders, order_contents, products
			WHERE orders.user_id=users.user_id AND orders.order_id=order_contents.order_id AND orders.order_id=$oid AND order_contents.product_id=products.product_id AND users.user_id=$uid";
	$r = mysqli_query ($dbc, $q);
	
	//Create a header
	echo "<p id='subheader'>Λεπτομέρειες της παραγγελίας σας με κωδικό <b>{$oid}</b><p>";
	
	// Create the table:
	echo '<table class="browse" border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
	<tr style="background-color:#99CCFF">
		<td align="center" width="20%"><b>Προϊόν</b></td>
		<td align="center" width="10%"><b>Τιμή</b></td>
		<td align="center" width="15%"><b>Ποσότητα</b></td>
		<td align="center" width="20%"><b>Ημ/νία Παραγγελίας</b></td>
	</tr>';
	if (mysqli_num_rows($r) > 0)		// Good to go!
	{
		$flag = TRUE;
		
		
		while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC))
		{
			// Fetch the information:
			//$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
		
			// Start the HTML page:
			
			// Display each record:
			echo "\t<tr>
				<td align=\"justify\"><a href=\"view_product.php?pid={$row['product_id']}\">{$row['Προϊόν']}</td>
				<td align=\"center\">{$row['Τιμή']} &euro;</td>
				<td align=\"center\">{$row['Ποσότητα']}</td>
				<td align=\"center\">{$row['Ημ/νία Παραγγελίας']}</td>
			</tr>\n";
		}
		$flag = TRUE;
	
	} // End of the mysqli_num_rows() IF.
	else
	{
		$flag = TRUE;
		echo "Η πληροφορία δεν είναι διαθέσιμη";
	}
	
	echo '</table>';
	mysqli_close($dbc);

}

if (!$flag)
{
	$page_title = 'Σφάλμα';
	include ('includes/header.html');
	echo '<div align="center">Η σελίδα δεν βρέθηκε!</div>';
}

// Complete the page:
include ('includes/footer.html');
?>
