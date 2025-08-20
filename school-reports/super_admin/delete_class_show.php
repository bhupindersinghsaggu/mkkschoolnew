<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../config/functions.php';

// Get record ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: list_class_show.php?message=Invalid record ID");
    exit();
}

// Delete record
$query = "DELETE FROM class_show WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: list_class_show.php?message=Record deleted successfully");
} else {
    header("Location: list_class_show.php?message=Error deleting record: " . mysqli_error($conn));
}

mysqli_stmt_close($stmt);
?>