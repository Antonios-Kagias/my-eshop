<!DOCTYPE html">
<html>
<head>
	<title>Προβολή παραγγελιών</title>
	<link rel="stylesheet" href="admin.css">
</head>
<body>
<?php # Script 17.5 - view_orders.php
// This page allows the administrator to view all orders.

require_once ('../mysqli_connect.php');
	
	// Validate the incoming data...
	$errors = array();
	
	if (empty($errors))		// If everything's OK.
	{
		// Add the brand to the database:
		$q = "	SELECT orders.order_id AS 'Κωδ. Παραγγελίας', users.user_id AS 'Κωδ. Χρήστη', CONCAT(users.first_name, ' ', users.last_name) AS 'Ονοματεπώνυμο',
					order_contents.quantity AS 'Ποσότητα', products.price AS 'Τιμή', orders.total AS 'Σύνολο', products.product_name AS 'Προϊόν',
					orders.order_date AS 'Ημ/νία Παραγγελίας'
				FROM users, orders, order_contents, products
				WHERE users.user_id=orders.user_id AND orders.order_id=order_contents.order_id AND order_contents.product_id=products.product_id
				ORDER BY orders.order_id ASC";
		
		//Create header
		echo "<h1 align='center'>Παραγγελίες καταστήματος</h1>";
	
		// Create the table head:
		echo '<table class="browse" border="0" width="100%" align="center">
			<tr style="background-color:#99CCFF">
				<td align="center" width="9%"><b>Κωδ. Παραγγελίας</b></td>
				<td align="center" width="9%"><b>Κωδ. Χρήστη</b></td>
				<td align="center" width="12.5%"><b>Ονοματεπώνυμο</b></td>
				<td align="center" width="9%"><b>Ποσότητα</b></td>
				<td align="center" width="9%"><b>Τιμή</b></td>
				<td align="center" width="9%"><b>Σύνολο</b></td>
				<td align="center" width="30%"><b>Προϊόν</b></td>
				<td align="center" width="12.5%"><b>Ημ/νία Παραγγελίας</b></td>
			</tr>';

		// Display all TVs, linked to URLs:
		$r = mysqli_query ($dbc, $q);
		while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC))
		{

			// Display each record:
			echo "\t<tr>
				<td align=\"center\">{$row['Κωδ. Παραγγελίας']}</td>
				<td align=\"center\">{$row['Κωδ. Χρήστη']}</td>
				<td align=\"justify\">{$row['Ονοματεπώνυμο']}</td>
				<td align=\"center\">{$row['Ποσότητα']}</td>
				<td align=\"center\">{$row['Τιμή']} &euro;</td>
				<td align=\"center\">{$row['Σύνολο']} &euro;</td>
				<td align=\"justify\">{$row['Προϊόν']}</td>
				<td align=\"center\">{$row['Ημ/νία Παραγγελίας']}</td>
			</tr>\n";
		}
		
	} // End of $errors IF.
	

// Check for any errors and print them:
if ( !empty($errors) && is_array($errors) )
{
	echo '<p style="font-weight: bold; color: #C00">';
	foreach ($errors as $msg)
	{
		echo "$msg<br />\n";
	}
	echo 'Παρακαλώ προσπαθήστε ξανά.</p>';
}

// Display the form...
?>

</body>
</html>
