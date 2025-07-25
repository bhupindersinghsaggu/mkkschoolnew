<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../header.php';
include '../head-nav.php';
include '../side-bar.php';
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Fetch photo path first to delete the file
    $result = mysqli_query($conn, "SELECT photo FROM teachers WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    if ($row && file_exists($row['photo'])) {
        unlink($row['photo']);
    }

    // Delete record from DB
    $delete = mysqli_query($conn, "DELETE FROM teachers WHERE id = $id");

    if ($delete) {
        header("Location: list_teachers.php?msg=deleted");
    } else {
        echo "Error deleting teacher.";
    }
} else {
    echo "Invalid ID.";
}
