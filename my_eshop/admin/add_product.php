<!DOCTYPE html">
<html>
<head>
	<title>Προσθήκη προϊόντος</title>
	<link rel="stylesheet" href="admin.css">
</head>
<body>
<?php # Script 10.3 - add_product.php
// This page allows the administrator to add a product.

require_once ('../mysqli_connect.php');

if (isset($_POST['submitted']))		// Handle the form.
{
	
	// Validate the incoming data...
	$errors = array();

	// Check for a product name:
	if (!empty($_POST['product_name']) && is_uploaded_file ($_FILES['image']['tmp_name']) && (isset($_POST['category']) && ($_POST['category'] > 0)) && (isset($_POST['brand']) && ($_POST['brand'] > 0)) && is_numeric($_POST['price']) && !empty($_POST['description']))
	{
		$pn = trim($_POST['product_name']);
		$c = (int) $_POST['category'];
		$b = (int) $_POST['brand'];
		$p = (float) $_POST['price'];
		$d = trim($_POST['description']);
		
		// Create a temporary file name:
		$temp = '../images/' . md5($_FILES['image']['name']);
	
		
		// Move the file over:
		if (move_uploaded_file($_FILES['image']['tmp_name'], $temp))
		{			
			// Set the $i variable to the image's name:
			$i = $_FILES['image']['name'];
	
		}
		else	// Couldn't move the file over.
		{
			$errors[] = 'The file could not be moved.';
			$temp = $_FILES['image']['tmp_name'];
		}
		
	}
	else
	{
		$errors[] = 'Πρέπει να συμπληρώσετε όλα τα πεδία!';
	}
	
	if (empty($errors))		// If everything's OK.
	{
		// Add the product to the database:
		$q = 'INSERT INTO products (brand_id, product_name, category_id, price, description, image_name) VALUES (?, ?, ?, ?, ?, ?)';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'isdsss', $b, $pn, $c, $p, $d, $i);
		mysqli_stmt_execute($stmt);
		
		// Check the results...
		if (mysqli_stmt_affected_rows($stmt) == 1) {
		
			// Print a message:
			echo '<p>Το προϊόν προστέθηκε.</p>';
			
			// Rename the image:
			$id = mysqli_stmt_insert_id($stmt); // Get the print ID.
			rename ($temp, "../images/$id");
			
			// Clear $_POST:
			$_POST = array();
			
		} else		// Error!
		{
			echo '<p style="font-weight: bold; color: #C00">Η προσθήκη απέτυχε!</p>'; 
		}
		
		mysqli_stmt_close($stmt);
		
	} // End of $errors IF.
	
	// Delete the uploaded file if it still exists:
	if ( isset($temp) && file_exists ($temp) && is_file($temp) ) {
		unlink ($temp);
	}
	
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
<h1>Προσθήκη προϊόντος</h1>
<form enctype="multipart/form-data" action="add_product.php" method="post">

	<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
	
	<fieldset><legend>Συμπληρώστε τη φόρμα προσθήκης προϊόντος:</legend>
	
	<table border="0" width="50%" cellspacing="5" cellpadding="15" align="center">
		<tr>
			<td align="left"><b>Όνομα προϊόντος:</b></td>
			<td align="left"><input type="text" name="product_name" size="50" maxlength="60" value="<?php if (isset($_POST['product_name'])) echo htmlspecialchars($_POST['product_name']); ?>" /></td>
		</tr>
		<tr>
			<td align="left"><b>Εικόνα:</b></td>
			<td align="left"><input type="file" name="image" /></td>
		</tr>
		<tr>
			<td align="left"><b>Κατηγορία:</b></td>
			<td align="left"><select name="category"><option disabled selected>Επιλέξτε</option>
						<?php // Retrieve all the categories and add to the pull-down menu.
						$q = "SELECT category_id, category_name FROM categories ORDER BY category_name ASC";		
						$r = mysqli_query ($dbc, $q);
						if (mysqli_num_rows($r) > 0)
						{
							while ($row = mysqli_fetch_array ($r, MYSQLI_NUM))
							{
								echo "<option value=\"$row[0]\"";
								/*
								// Check for stickyness:
								if (isset($_POST['existing']) && ($_POST['existing'] == $row[0]) ) echo ' selected="selected"';*/
									echo ">$row[1]</option>\n";
							}
						}
						else
						{
							echo '<option>Please add a new category.</option>';
						}
						//mysqli_close($dbc); // Close the database connection.
						?>
						</select>
			</td>
		</tr>
		<tr>
			<td align="left"><b>Κατασκευαστής:</b></td>
			<td align="left"><select name="brand"><option disabled selected>Επιλέξτε</option>
						<?php // Retrieve all the brands and add to the pull-down menu.
						$q = "SELECT brand_id, brand_name FROM brands ORDER BY brand_name ASC";		
						$r = mysqli_query ($dbc, $q);
						if (mysqli_num_rows($r) > 0)
						{
							while ($row = mysqli_fetch_array ($r, MYSQLI_NUM))
							{
								echo "<option value=\"$row[0]\"";
								echo ">$row[1]</option>\n";
							}
						}
						else
						{
							echo '<option>Please add a new brand.</option>';
						}
						mysqli_close($dbc); // Close the database connection.
						?>
						</select>
			</td>
		</tr>
		<tr>
			<td align="left"><b>Τιμή:</b></td>
			<td align="left"><input type="text" name="price" size="20" maxlength="10" value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>" /> <small>στη μορφή 140.99</small></td>
		</tr>
		<tr>
			<td align="left"><b>Περιγραφή:</b></td>
			<td align="left"><textarea name="description" cols="40" rows="5"><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea> <small>Σύντομη, μέχρι 255 χαρακτήρες.</small></td>
		</tr>
	
	</table>
	
	</fieldset>
	
	<br>
		
	<div align="center"><input type="submit" name="submit" value="Προσθήκη" /></div>
	<input type="hidden" name="submitted" value="TRUE" />

</form>

</body>
</html>
