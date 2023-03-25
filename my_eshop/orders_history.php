<?php # Script 17.15 - orders_history.php
// This page displays user's order history.

session_start(); // Start the session.

// Set the page title and include the HTML header:
$page_title = 'Best Deal | Ιστορικό παραγγελιών';
include ('includes/header.html');

require_once ('mysqli_connect.php');

if(isset($_SESSION['user_id']))
{
	$uid = $_SESSION['user_id'];
}

//Create header
echo "<h2 id='header'>Οι παραγγελίες σας</h2>";

 
// Default query for this page:
$q = "	SELECT users.user_id, orders.order_id AS 'Κωδ. Παραγγελίας', users.first_name, users.last_name, orders.total AS 'Σύνολο', DATE_FORMAT(orders.order_date, '%d-%m-%Y') AS 'Ημ/νία Παραγγελίας' FROM users, orders
		WHERE orders.user_id=users.user_id AND users.user_id=$uid
		ORDER BY orders.order_date DESC";
		

$r = mysqli_query ($dbc, $q);
echo '<table class="browse" border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
	<tr style="background-color:#99CCFF">
		<td align="center" width="20%"><b>Κωδ. Παραγγελίας</b></td>
		<td align="center" width="15%"><b>Σύνολο</b></td>
		<td align="center" width="20%"><b>Ημ/νία Παραγγελίας</b></td>
	</tr>';
while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC))
{

	// Display each record:
	echo "\t<tr>
		<td align=\"center\"><a href=\"order_contents.php?oid={$row['Κωδ. Παραγγελίας']}\">{$row['Κωδ. Παραγγελίας']}</a></td>
		<td align=\"center\">{$row['Σύνολο']} &euro;</td>
		<td align=\"center\">{$row['Ημ/νία Παραγγελίας']}</td>
	</tr>\n";
}
echo '</table>';

mysqli_close($dbc);
include ('includes/footer.html');
?>
