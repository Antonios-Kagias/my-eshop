<?php # Script 17.17 - register.php #2

$page_title = 'Best Deal | Εγγραφή';
include ('includes/header.html');

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

	require_once ('mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for inserted data:
	if (empty($_POST['first_name']) || empty($_POST['first_name']) || empty($_POST['first_name']) || empty($_POST['pass1']))
	{
		$errors[] = 'Πρέπει να συμπληρώσετε όλα τα στοιχεία που ζητούνται!';
	} else
	{
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
		$pn = mysqli_real_escape_string($dbc, trim($_POST['phone_number']));
		$c = mysqli_real_escape_string($dbc, trim($_POST['city']));
		$a = mysqli_real_escape_string($dbc, trim($_POST['address']));
		$pc = mysqli_real_escape_string($dbc, trim($_POST['postal_code']));
	}
	
		
	// Check for a matched password:
	if ($_POST['pass1'] != $_POST['pass2'])
	{
		$errors[] = 'Δεν συμπληρώσατε σωστά τον κωδικό σας και τις 2 φορές!';
	}
	else
	{
		$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
	}
	
	if (empty($errors))		 // If everything's OK.
	{
		// Register the user in the database...
		
		// Make the query:
		$q = "	INSERT INTO users (first_name, last_name, email, phone_number, city, address, postal_code, password, registration_date) VALUES
				('$fn', '$ln', '$e', '$pn', '$c', '$a', '$pc', SHA1('$p'), NOW() )";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r)		 // If it ran OK.
		{
			// Print a message:
			echo '<h1>Ευχαριστούμε!</h1>
			<p>Η εγγραφή σας έγινε με επιτυχία! Μπορείτε πλέον να συνδεθείτε!</p><p><br /></p>';	
		
		}
		else		// If it did not run OK.
		{
			// Public message:
			echo '<h1>Σφάλμα συστήματος!</h1>
			<p class="error">Η εγγραφή σας δεν πραγματοποιήθηκε λόγω σφάλματος στο σύστημα. Μπορείτε να προσπαθήσετε πάλι σε λίγο.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('includes/footer.html'); 
		exit();
		
	}
	else		// Report the errors.
	{
		echo "<br>";
		echo "<div class='error'>";
		foreach ($errors as $msg) { // Print each error.
		echo "$msg<br />\n";
	}
	echo '<p>Προσπαθήστε ξανά.</p></div>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<h1 id="header">Εγγραφή</h1>
<form action="register.php" method="post">
	
	<table border="0" width="60%" cellpadding="2" align="center">
	
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="text" name="first_name" size="20" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" placeholder="Όνομα"><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="text" name="last_name" size="20" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" placeholder="Επώνυμο"><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="text" name="email" size="20" maxlength="80" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Email"><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="text" name="phone_number" size="20" maxlength="20" value="<?php if (isset($_POST['phone_number'])) echo $_POST['phone_number']; ?>" placeholder="Τηλέφωνο"><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="text" name="city" size="20" maxlength="30" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>" placeholder="Πόλη"><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="text" name="address" size="20" maxlength="40" value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>" placeholder="Διεύθυνση"><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="text" name="postal_code" size="20" maxlength="10" value="<?php if (isset($_POST['postal_code'])) echo $_POST['postal_code']; ?>" placeholder="Τ.Κ."><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="password" name="pass1" size="20" maxlength="20" placeholder="Κωδικός πρόσβασης"><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="password" name="pass2" size="20" maxlength="20" placeholder="Επιβεβαίωση κωδικού"><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	
	</table>
	
	<div align="center"><input class="reg_log" type="submit" name="submit" value="Εγγραφή" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
	
</form>
<?php
include ('includes/footer.html');
?>
