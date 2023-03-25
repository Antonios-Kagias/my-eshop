<?php # Script 11.2 - login_page.php

// This page prints any errors associated with logging in
// and it creates the entire login page, including the form.

// Include the header:
$page_title = 'Best Deal | Σύνδεση';
include ('includes/header.html');

// Print any error messages, if they exist:
if (!empty($errors))
{
	echo "<br>";
	echo "<div class='error'> <br>";
	foreach ($errors as $msg)
	{
		echo "$msg<br>\n";
	}
	echo "<br></div>";
}

// Display the form:
?>
<h1 id="header">Σύνδεση</h1>
<form action="login.php" method="post">
	
	<table border="0" width="60%" cellpadding="2" align="center">
	
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="text" name="email" size="20" maxlength="80" placeholder="Email"><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	<tr align="center">
		<td>
			<div class="col-3">
				<input class="effect-1" type="password" name="password" size="20" maxlength="20" placeholder="Κωδικός"><br>
				<span class="focus-border"></span>
			</div>
		</td>
	</tr>
	
	</table>
	
	<div align="center"><input class="reg_log" type="submit" name="submit" value="Σύνδεση" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
</form>

<?php // Include the footer:
include ('includes/footer.html');
?>
