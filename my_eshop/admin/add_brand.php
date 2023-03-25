<!DOCTYPE html">
<html>
<head>
	<title>Προσθήκη κατασκευαστή</title>
	<link rel="stylesheet" href="admin.css">
</head>
<body>
<?php # Script 10.1 - add_brand.php
// This page allows the administrator to add a brand.

require_once ('../mysqli_connect.php');

if (isset($_POST['submitted']))		// Handle the form.
{
	
	// Validate the incoming data...
	$errors = array();

	// Check for a brand name:
	if (!empty($_POST['brand_name']))
	{
		$cn = trim($_POST['brand_name']);
		
	}
	else
	{
		$errors[] = 'Πρέπει να συμπληρώσετε όλα τα πεδία!';
	}
	
	if (empty($errors))		// If everything's OK.
	{
		// Add the brand to the database:
		$q = 'INSERT INTO brands (brand_name) VALUES (?)';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 's', $cn);
		mysqli_stmt_execute($stmt);
		
		// Check the results...
		if (mysqli_stmt_affected_rows($stmt) == 1) {
		
			// Print a message:
			echo '<p>Ο κατασκευαστής προστέθηκε.</p>';
			
			// Clear $_POST:
			$_POST = array();
			
		} else		// Error!
		{
			echo '<p style="font-weight: bold; color: #C00">Η προσθήκη απέτυχε!</p>'; 
		}
		
		mysqli_stmt_close($stmt);
		
	} // End of $errors IF.
	
} // End of the submission IF.

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
<h1>Προσθήκη κατασκευαστή</h1>
<form enctype="multipart/form-data" action="add_brand.php" method="post">

	<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
	
	<fieldset><legend>Συμπληρώστε τη φόρμα προσθήκης κατασκευαστή:</legend>
	
	<table border="0" width="50%" cellspacing="5" cellpadding="15" align="center">
		<tr>
			<td align="left"><b>Όνομα κατασκευαστή:</b></td>
			<td align="left"><input type="text" name="brand_name" size="50" maxlength="60" value="<?php if (isset($_POST['brand_name'])) echo htmlspecialchars($_POST['brand_name']); ?>" /></td>
		</tr>	
	</table>
	
	</fieldset>
	
	<br>
		
	<div align="center"><input type="submit" name="submit" value="Προσθήκη" /></div>
	<input type="hidden" name="submitted" value="TRUE" />

</form>

</body>
</html>
