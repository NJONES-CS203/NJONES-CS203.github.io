<?php
// Start 
session_start();

// Stop
session_destroy();

// Go back
header("Location: index.php");
exit;
?>
