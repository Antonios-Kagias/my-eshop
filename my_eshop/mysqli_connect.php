<?php # Script 17.13 - mysqli_connect.php

// This file contains the database access information. 
// This file also establishes a connection to MySQL 
// and selects the database.

// Set the database access information as constants:

// Make the connection:
$dbc = @mysqli_connect ('localhost', 'root', '', 'my_eshop') OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

?>
