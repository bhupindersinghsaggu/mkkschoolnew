<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';

// Only allow authenticated users with appropriate permissions
// if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'teacher') {
//     header("Location: list_notebook.php?upload=error&msg=Unauthorized");
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    // Validate record_id
    $record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
    if (!$record_id || $record_id <= 0) {
        header("Location: list_notebook.php?upload=error&msg=Invalid record ID");
        exit();
    }

    // Start transaction for atomic operations
    mysqli_begin_transaction($conn);

    try {
        // Get teacher_id from the record
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

        // File upload handling
        $target_dir = __DIR__ . "/../uploads/teacher_documents/";
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
            throw new Exception("Invalid file type. Only JPG, PNG, and PDF files are allowed");
        }

        // Check file size (max 5MB)
        if ($_FILES['document']['size'] > 5000000) {
            throw new Exception("File too large. Maximum size is 5MB");
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
        
        if (!in_array($detected_type, $mime_types)) {
            throw new Exception("Invalid file content");
        }

        // Generate unique filename
        $new_file_name = "teacher_" . $teacher_id . "_" . uniqid() . "." . $file_ext;
        $target_file = $target_dir . $new_file_name;

        // Move uploaded file
        if (!move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
            throw new Exception("File upload failed");
        }

        // Update database with document path
        $update = $conn->prepare("UPDATE records SET document = ? WHERE id = ?");
        $update->bind_param("si", $new_file_name, $record_id);
        
        if (!$update->execute()) {
            throw new Exception("Database update failed");
        }

        // Delete old file if it exists
        if ($old_file && file_exists($target_dir . $old_file)) {
            unlink($target_dir . $old_file);
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
            unlink($target_file);
        }
        
        header("Location: list_notebook.php?upload=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: list_notebook.php?upload=error&msg=Invalid request");
    exit();
}