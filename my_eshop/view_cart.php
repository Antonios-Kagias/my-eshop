<?php # Script 17.19 - view_cart.php
// This page displays the contents of the shopping cart.
// This page also lets the user update the contents of the cart.

session_start(); // Start the session.
$page_title = 'BestDeal | Το Καλάθι Μου';

if( !(isset($_SESSION['user_id'])) )
{
	include ('./includes/header.html');
	echo '<p class="error"><br> Δεν έχετε συνδεθεί! <br><br></p>';
	include ('./includes/footer.html');
}
else
{

// Set the page title and include the HTML header:

include ('./includes/header.html');

echo "<h2 id='header'>Το Καλάθι Μου</h2>";

// Check if the form has been submitted (to update the cart):
if (isset($_POST['submitted']))
{

	// Change any quantities:
	foreach ($_POST['qty'] as $k => $v)
	{

		// Must be integers!
		$pid = (int) $k;
		$qty = (int) $v;
		
		if ( $qty == 0 )		// Delete.
		{
			unset ($_SESSION['cart'][$pid]);
		}
		elseif ( $qty > 0 )		// Change quantity.
		{
			$_SESSION['cart'][$pid]['quantity'] = $qty;
		}
		
	} // End of FOREACH.
} // End of SUBMITTED IF.

// Display the cart if it's not empty...
if (!empty($_SESSION['cart']))
{
	
	// Retrieve all of the information for the prints in the cart:
	require_once ('mysqli_connect.php');
	$q = "	SELECT brands.brand_name AS 'Κατασκευαστής', products.product_id, products.product_name AS 'Προϊόν' FROM products, brands
			WHERE products.brand_id=brands.brand_id AND products.product_id IN (";
	foreach ($_SESSION['cart'] as $pid => $value) {
		$q .= $pid . ',';
	}
	$q = substr($q, 0, -1) . ') ORDER BY products.product_name ASC';
	$r = mysqli_query ($dbc, $q);
	
	// Create a form and a table:
	echo '<form action="view_cart.php" method="post">
<table class="browse" border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
	<tr style="background-color:#99CCFF">
		<td align="center" width="15%"><b>Κατασκευαστής</b></td>
		<td align="center" width="25%"><b>Προϊόν</b></td>
		<td align="center" width="10%"><b>Τιμή</b></td>
		<td align="center" width="10%"><b>Ποσότητα</b></td>
		<td align="center" width="10%"><b>Σύνολο</b></td>
	</tr>
';

	// Print each item...
	$total = 0; // Total cost of the order.
	while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC))
	{
		//Retrieve the quantity of each product to determine the selected value in HTML <select>
		$quantity = (int) $_SESSION['cart'][$row['product_id']]['quantity'];
		
		// Calculate the total and sub-totals.
		$subtotal = $_SESSION['cart'][$row['product_id']]['quantity'] * $_SESSION['cart'][$row['product_id']]['price'];
		$total += $subtotal;
				
		// Print the row.
		echo "\t<tr>
		<td align=\"center\">{$row['Κατασκευαστής']}</td>
		<td align=\"center\"><a href=\"view_product.php?pid={$row['product_id']}\">{$row['Προϊόν']}</td>
		<td align=\"center\"> {$_SESSION['cart'][$row['product_id']]['price']} &euro;</td>";
		if ($quantity == 1)
		{
			echo "<td align=\"center\">	<select class=\"quantity\" id=\"quantity\" name=\"qty[{$row['product_id']}]\">
									<option value=\"0\">0</option>
									<option selected value=\"1\">1</option>
									<option value=\"2\">2</option>
									<option value=\"3\">3</option>
									<option value=\"4\">4</option>
									<option value=\"5\">5</option>
								</select>
		</td>";
		}
		if ($quantity == 2)
		{
			echo "<td align=\"center\">	<select class=\"quantity\" id=\"quantity\" name=\"qty[{$row['product_id']}]\">
									<option value=\"0\">0</option>
									<option value=\"1\">1</option>
									<option selected value=\"2\">2</option>
									<option value=\"3\">3</option>
									<option value=\"4\">4</option>
									<option value=\"5\">5</option>
								</select>
		</td>";
		}
		if ($quantity == 3)
		{
			echo "<td align=\"center\">	<select class=\"quantity\" id=\"quantity\" name=\"qty[{$row['product_id']}]\">
									<option value=\"0\">0</option>
									<option value=\"1\">1</option>
									<option value=\"2\">2</option>
									<option selected value=\"3\">3</option>
									<option value=\"4\">4</option>
									<option value=\"5\">5</option>
								</select>
		</td>";
		}
		if ($quantity == 4)
		{
			echo "<td align=\"center\">	<select class=\"quantity\" id=\"quantity\" name=\"qty[{$row['product_id']}]\">
									<option value=\"0\">0</option>
									<option value=\"1\">1</option>
									<option value=\"2\">2</option>
									<option value=\"3\">3</option>
									<option selected value=\"4\">4</option>
									<option value=\"5\">5</option>
								</select>
		</td>";
		}
		if ($quantity == 5)
		{
			echo "<td align=\"center\">	<select class=\"quantity\" id=\"quantity\" name=\"qty[{$row['product_id']}]\">
									<option value=\"0\">0</option>
									<option value=\"1\">1</option>
									<option value=\"2\">2</option>
									<option value=\"3\">3</option>
									<option value=\"4\">4</option>
									<option selected value=\"5\">5</option>
								</select>
		</td>";
		}
		
		echo "<td style='color: red;	font-weight: bold;' align=\"center\">" . number_format ($subtotal, 2) . " &euro;</td>
			</tr>\n";
	
	
	} // End of the WHILE loop.
	
	mysqli_close($dbc); // Close the database connection.

	// Print the footer, close the table, and the form.
	echo '	<tr>
				<td colspan="4" align="right"><b>Τελικό Σύνολο:</b></td>
				<td style="color: red;	font-weight: bold;" align="center">' . number_format ($total, 2) . ' &euro;</td>
			</tr>
		</table>
	<br>
	
	<div align="center">Θα πληρώσω με: <select class="pay">
							<option>Αντικαταβολή</option>
							<option>Πιστωτική/Χρεωστική κάρτα</option>
							<option>Κατάθεση σε τραπεζικό λογαριασμό</option>
						</select>
	</div>
	<br>
	<div align="center"><input class="update_cart" type="submit" name="submit" value="Ενημέρωση καλαθιού" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
	</form>
	<p style="font-size: 13px" align="center">Επιλέξτε 0 για να αφαιρέσετε ένα προϊόν από το καλάθι σας.</p>
	<br /><p align="center"><a href="checkout.php">CHECKOUT</a></p>';

}
else
{
	echo '<p>Το καλάθι σας είναι άδειο.</p>';
}

include ('./includes/footer.html');
}
?>
