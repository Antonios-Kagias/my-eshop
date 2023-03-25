<?php # Script 17.8 - index.php
// This is the main page for the site.

session_start(); // Start the session.

// Set the page title and include the HTML header:
$page_title = 'Best Deal | Αρχική';
include ('includes/header.html');
?>
	<h1 style="font-size: 50px; text-align: center;">Best Deal</h1>
	
	<p>Ψάχνεις καινούργια τηλεόραση; Μήπως να αναβαθμίσεις το smartphone σου;</p>
	<p>Ό,τι τεχνολογικό κι αν θέλεις, το Best Deal είναι ο προορισμός σου!</p>
	
	<p>Με πάνω από 30 [ :-) ] προϊόντα, εδώ θα βρεις από low-budget tablets για απλή οικιακή χρήση μέχρι και 55" τηλεοράσεις για να δώσεις στις βραδιές Champions League την αίσθηση που τους αξίζει!</p>
	
	<p>Πλήρωσε με τον τρόπο της αρεσκείας σου και δες την παραγγελία στην πόρτα σου σε λίγες μέρες.</p>
	
</div>

<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
