<?php # Script 17.2 - browse_headphones.php
// This page displays the available headphones.

session_start(); // Start the session.

// Set the page title and include the HTML header:
$page_title = 'Best Deal | Ακουστικά';
include ('includes/header.html');

require_once ('mysqli_connect.php');
 
// Default query for this page:
$q = "	SELECT brands.brand_id, products.product_id, brands.brand_name AS Κατασκευαστής, products.product_name AS Μοντέλο, products.description AS Περιγραφή, products.price AS Τιμή FROM products, categories, brands
		WHERE products.category_id=categories.category_id AND products.brand_id=brands.brand_id AND categories.category_name='Ακουστικά'
		ORDER BY products.price ASC";


// Looking at a particular brand
if (isset($_GET['bid']) && is_numeric($_GET['bid']) ) {
	$bid = (int) $_GET['bid'];
	if ($bid > 0) { // Overwrite the query:
		$q = "	SELECT brands.brand_id, products.product_id, brands.brand_name AS Κατασκευαστής, products.product_name AS Μοντέλο, products.description AS Περιγραφή, products.price AS Τιμή FROM products, categories, brands
				WHERE products.category_id=categories.category_id AND products.brand_id=brands.brand_id AND categories.category_name='Ακουστικά' AND brands.brand_id = $bid
				ORDER BY products.price ASC";
	}
}


//Create header
echo "<h2 id='header'>Ακουστικά</h2>";

// Create the table head:
echo '<table class="browse" border="0" width="90%" align="center">
	<tr style="background-color:#99CCFF">
		<td align="center" width="20%"><b>Κατασκευαστής</b></td>
		<td align="center" width="20%"><b>Μοντέλο</b></td>
		<td align="center" width="40%"><b>Περιγραφή</b></td>
		<td align="center" width="20%"><b>Τιμή</b></td>
	</tr>';

// Display all TVs, linked to URLs:
$r = mysqli_query ($dbc, $q);
while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

	// Display each record:
	echo "\t<tr>
		<td align=\"center\"><a href=\"browse_headphones.php?bid={$row['brand_id']}\">{$row['Κατασκευαστής']}</a></td>
		<td align=\"justify\"><a href=\"view_product.php?pid={$row['product_id']}\"><b>{$row['Μοντέλο']}</b></td>
		<td align=\"justify\">{$row['Περιγραφή']}</td>
		<td style='color: red;	font-weight: bold;' align=\"center\">{$row['Τιμή']} &euro;</td>
	</tr>\n";

} // End of while loop.

echo '</table>';
mysqli_close($dbc);
include ('includes/footer.html');
?>
