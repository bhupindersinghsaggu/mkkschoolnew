<?php
// logout.php - Logout script
require_once 'auth.php';

$auth = new Auth();
$auth->logout();

header("Location: login.php");
exit;
?>