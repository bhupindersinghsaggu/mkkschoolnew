<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// include '../header.php';
// include '../head-nav.php';
// include '../side-bar.php';

require_once '../config/database.php';
require_once '../config/functions.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Fetch photo path first to delete the file
    $result = mysqli_query($conn, "SELECT photo FROM teachers WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $photoPath = '../uploads/' . $row['photo'];
        if (!empty($row['photo']) && file_exists($photoPath)) {
            unlink($photoPath); // delete the photo file
        }
    }

    // Delete record from DB
    $delete = mysqli_query($conn, "DELETE FROM teachers WHERE id = $id");

    if ($delete) {
        header("Location: list_teacher.php?msg=deleted");
        exit;
    } else {
        echo "Error deleting teacher.";
    }
} else {
    echo "Invalid ID.";
}
?>
