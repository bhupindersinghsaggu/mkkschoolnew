<?php
session_start();
require_once '../config/functions.php';

redirectIfNotLoggedIn();

// Check if user has permission to access this page
$allowed_roles = ['super_admin', 'teacher']; // Adjust as needed
if (!in_array($_SESSION['role'], $allowed_roles)) {
    header("Location: ../auth/login.php");
    exit();
}
?>