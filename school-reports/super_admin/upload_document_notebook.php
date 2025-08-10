<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and include dependencies
session_start();
require_once '../config/database.php';
require_once '../includes/auth_check.php';

// Verify authentication and authorization
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

// Only allow authenticated users with appropriate permissions
$allowed_roles = ['admin', 'teacher'];
if (!in_array($_SESSION['role'], $allowed_roles)) {
    header("Location: list_notebook.php?error=unauthorized&msg=Insufficient+privileges");
    exit();
}

// Only process POST requests with file uploads
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['document'])) {
    header("Location: list_notebook.php?error=invalid_request&msg=Invalid+request+method");
    exit();
}

// Validate record_id
$record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
if (!$record_id || $record_id <= 0) {
    header("Location: list_notebook.php?error=invalid_id&msg=Invalid+record+ID");
    exit();
}

// Start transaction for atomic operations
mysqli_begin_transaction($conn);

try {
    // Get record details with ownership check
    $stmt = $conn->prepare("SELECT teacher_id, document FROM records WHERE id = ?");
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Record not found");
    }
    
    $record = $result->fetch_assoc();
    $teacher_id = $record['teacher_id'];
    $old_file = $record['document'] ?? null;

    // Additional ownership check for teachers
    if ($_SESSION['role'] === 'teacher' && $teacher_id != $_SESSION['user_id']) {
        throw new Exception("You can only upload documents for your own records");
    }

    // File upload handling
    $target_dir = realpath(__DIR__ . "/../uploads/teacher_documents/") . DIRECTORY_SEPARATOR;
    
    // Verify and create directory if needed
    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0755, true)) {
            throw new Exception("Failed to create upload directory");
        }
    }

    // File validation
    $file_name = basename($_FILES['document']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];
    
    if (!in_array($file_ext, $allowed_types)) {
        throw new Exception("Only JPG, PNG, and PDF files are allowed");
    }

    // Check file size (max 5MB)
    if ($_FILES['document']['size'] > 5000000) {
        throw new Exception("Maximum file size is 5MB");
    }

    // Verify file content
    $mime_types = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'pdf' => 'application/pdf'
    ];
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $detected_type = finfo_file($finfo, $_FILES['document']['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($detected_type, $mime_types) || !isset($mime_types[$file_ext])) {
        throw new Exception("Invalid file content");
    }

    // Generate secure unique filename
    $new_file_name = "doc_" . $teacher_id . "_" . bin2hex(random_bytes(8)) . "." . $file_ext;
    $target_file = $target_dir . $new_file_name;

    // Move uploaded file with error checking
    if (!move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
        throw new Exception("File upload failed. Error: " . $_FILES['document']['error']);
    }

    // Update database with document path
    $update = $conn->prepare("UPDATE records SET document = ? WHERE id = ?");
    $update->bind_param("si", $new_file_name, $record_id);
    
    if (!$update->execute()) {
        throw new Exception("Database update failed: " . $conn->error);
    }

    // Delete old file if it exists
    if ($old_file && file_exists($target_dir . $old_file)) {
        @unlink($target_dir . $old_file); // Suppress errors if file doesn't exist
    }

    // Commit transaction
    mysqli_commit($conn);
    
    header("Location: list_notebook.php?upload=success");
    exit();
    
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    
    // Clean up if file was uploaded but db update failed
    if (isset($target_file) && file_exists($target_file)) {
        @unlink($target_file);
    }
    
    // Log the error for admin review
    error_log("Document upload failed: " . $e->getMessage());
    
    header("Location: list_notebook.php?upload=error&msg=" . urlencode($e->getMessage()));
    exit();
}