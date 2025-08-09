<?php
require_once '../includes/auth_check.php';
require_once  '../config/database.php';
require_once  '../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $record_id = $_POST['record_id'];

    if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];
        $upload_dir = '../uploads/';
        $file_name = basename($_FILES['document']['name']);
        $file_tmp = $_FILES['document']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_ext)) {
            die('Invalid file type.');
        }

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $new_name = 'doc_' . $record_id . '_' . time() . '.' . $file_ext;
        $destination = $upload_dir . $new_name;

        if (move_uploaded_file($file_tmp, $destination)) {
            // Optional: store file path in DB
            $file_path = mysqli_real_escape_string($conn, $new_name);
            $update = mysqli_query($conn, "UPDATE records SET document = '$file_path' WHERE id = $record_id");

            if ($update) {
                header("Location: list_notebook.php?upload=success");
                exit;
            } else {
                die('Failed to update record with file path.');
            }
        } else {
            die('Failed to upload file.');
        }
    } else {
        die('No file uploaded or upload error.');
    }
} else {
    die('Invalid request method.');
}
