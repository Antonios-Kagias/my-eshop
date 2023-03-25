<?php # Script 17.20 - view_product.php
// This page displays the details for a particular product.

session_start(); // Start the session.

$row = FALSE; // Assume nothing!

if (isset($_GET['pid']) && is_numeric($_GET['pid']) ) { // Make sure there's a product ID!

	$pid = (int) $_GET['pid'];
	
	// Get the product info:
	require_once ('mysqli_connect.php'); 
	$q = "	SELECT brands.brand_name AS Κατασκευαστής, products.product_name AS Μοντέλο, products.description AS Περιγραφή, products.price AS Τιμή,
				products.image_name
			FROM products, categories, brands
			WHERE products.category_id=categories.category_id AND products.brand_id=brands.brand_id AND products.product_id=$pid";
	$r = mysqli_query ($dbc, $q);
	if (mysqli_num_rows($r) == 1)		// Good to go!
	{
	
		// Fetch the information:
		$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
		
		// Start the HTML page:
		$page_title = 'Best Deal | '.$row['Μοντέλο'];
		include ('includes/header.html');
	
		// Display a header:
		echo "<div style='color:#000099; font-weight:bold;' id='header' align=\"center\">
	{$row['Μοντέλο']}<br><br></div>";

		echo "<div style='color:red; font-weight:bold;' id='subheader' align='center'> {$row['Τιμή']} &euro;  
	<a class='add_cart' href=\"add_cart.php?pid=$pid\">Προσθήκη στο καλάθι</a>
	</div><br />";
	
	// Get the image information and display the image:
	if ($image = @getimagesize ("images/$pid"))
	{
		echo "	<div class='image' align=\"center\">
				<img src=\"show_image.php?image=$pid&name=" . urlencode($row['image_name']) . "\" $image[3] alt=\"{$row['Μοντέλο']}\" />
				</div>\n";	
	}
	else
	{
		echo "<div align=\"center\">No image available.</div>\n"; 
	}
	
		// Add the description or a default message:
		echo '<p align="justify">' . ((is_null($row['Περιγραφή'])) ? '(Μη διαθέσιμη περιγραφή)' : $row['Περιγραφή']) . '</p>';
		
	
	} // End of the mysqli_num_rows() IF.
	
	mysqli_close($dbc);

}

if (!$row) { // Show an error message.
	$page_title = 'Best Deal | Σφάλμα';
	include ('includes/header.html');
	echo '<div align="center">Δεν υπάρχουν διαθέσιμες πληροφορίες</div>';
}

// Complete the page:
include ('includes/footer.html');
?>
