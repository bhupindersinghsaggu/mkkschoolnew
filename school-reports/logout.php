<?php
session_start();
session_unset();
session_destroy();

// Prevent back button from accessing cached pages
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies

// Redirect to login
header("Location: ../login.php");
exit;
?>
