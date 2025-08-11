<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../teacher/header.php';
require_once '../teacher/side-bar.php';

// Check if teacher is logged in
if ($_SESSION['role'] !== 'teacher') {
    header("Location: ../login.php");
    exit();
}

$teacher_id = $_SESSION['user_id'];

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    $date = $_POST['date'];
    $session = $_POST['session'];
    $doc_name = $_POST['doc_name'];
    
    // File upload handling
    $upload_dir = '../uploads/teacher_documents/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $file_name = uniqid() . '_' . basename($_FILES['document']['name']);
    $target_path = $upload_dir . $file_name;
    
    if (move_uploaded_file($_FILES['document']['tmp_name'], $target_path)) {
        // Save to database
        $stmt = $conn->prepare("INSERT INTO teacher_documents 
                              (teacher_id, date, session, doc_name, file_path) 
                              VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $teacher_id, $date, $session, $doc_name, $file_name);
        $stmt->execute();
        
        $_SESSION['message'] = "Document uploaded successfully!";
    } else {
        $_SESSION['error'] = "Error uploading document.";
    }
}

// Handle file deletion
if (isset($_GET['delete'])) {
    $doc_id = $_GET['delete'];
    
    // Get file path first
    $stmt = $conn->prepare("SELECT file_path FROM teacher_documents WHERE id = ? AND teacher_id = ?");
    $stmt->bind_param("ii", $doc_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $document = $result->fetch_assoc();
    
    if ($document) {
        $file_path = '../uploads/teacher_documents/' . $document['file_path'];
        
        // Delete from filesystem
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        // Delete from database
        $stmt = $conn->prepare("DELETE FROM teacher_documents WHERE id = ? AND teacher_id = ?");
        $stmt->bind_param("ii", $doc_id, $teacher_id);
        $stmt->execute();
        
        $_SESSION['message'] = "Document deleted successfully!";
    }
    
    header("Location: documents.php");
    exit();
}

// Fetch teacher's documents
$documents = [];
$stmt = $conn->prepare("SELECT * FROM teacher_documents WHERE teacher_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$documents = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management - Teacher Panel</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link rel="apple-touch-icon" href="../assets/img/apple-touch-icon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../assets/plugins/tabler-icons/tabler-icons.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/plugins/%40simonwep/pickr/themes/nano.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .document-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .document-card:hover {
            transform: translateY(-5px);
        }
        .file-icon {
            font-size: 2.5rem;
        }
        .pdf-icon { color: #e74c3c; }
        .doc-icon { color: #3498db; }
        .img-icon { color: #2ecc71; }
        .other-icon { color: #9b59b6; }
    </style>
</head>
<body>
    <?php include('teacher_header.php'); ?>
    
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Messages -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= $_SESSION['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= $_SESSION['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                
                <!-- Upload Form -->
                <div class="card mb-4 document-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Upload New Document</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Session</label>
                                <select name="session" class="form-select" required>
                                    <option value="">Select Session</option>
                                    <option value="2023-24">2023-24</option>
                                    <option value="2024-25">2024-25</option>
                                    <option value="2025-26">2025-26</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Document Name</label>
                                <input type="text" name="doc_name" class="form-control" placeholder="E.g. Lesson Plan, Worksheet" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Document File</label>
                                <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                <small class="text-muted">Allowed formats: PDF, DOC, DOCX, JPG, PNG</small>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-upload me-2"></i> Upload Document
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Documents List -->
                <h4 class="mb-3">Your Uploaded Documents</h4>
                
                <?php if (empty($documents)): ?>
                    <div class="alert alert-info">
                        No documents uploaded yet.
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($documents as $doc): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card document-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <?php
                                            $ext = pathinfo($doc['file_path'], PATHINFO_EXTENSION);
                                            $icon_class = "other-icon";
                                            $icon = "fa-file";
                                            
                                            if (in_array($ext, ['pdf'])) {
                                                $icon_class = "pdf-icon";
                                                $icon = "fa-file-pdf";
                                            } elseif (in_array($ext, ['doc', 'docx'])) {
                                                $icon_class = "doc-icon";
                                                $icon = "fa-file-word";
                                            } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                                                $icon_class = "img-icon";
                                                $icon = "fa-file-image";
                                            }
                                            ?>
                                            <div class="me-3">
                                                <i class="fas <?= $icon ?> file-icon <?= $icon_class ?>"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5><?= htmlspecialchars($doc['doc_name']) ?></h5>
                                                <p class="mb-1 text-muted">
                                                    <small>
                                                        <i class="far fa-calendar me-1"></i>
                                                        <?= date('d M Y', strtotime($doc['date'])) ?>
                                                    </small>
                                                </p>
                                                <p class="mb-1 text-muted">
                                                    <small>
                                                        <i class="fas fa-graduation-cap me-1"></i>
                                                        <?= htmlspecialchars($doc['session']) ?>
                                                    </small>
                                                </p>
                                                <div class="mt-2">
                                                    <a href="../uploads/teacher_documents/<?= htmlspecialchars($doc['file_path']) ?>" 
                                                       class="btn btn-sm btn-success me-2" download>
                                                        <i class="fas fa-download me-1"></i> Download
                                                    </a>
                                                    <a href="documents.php?delete=<?= $doc['id'] ?>" 
                                                       class="btn btn-sm btn-danger" 
                                                       onclick="return confirm('Are you sure you want to delete this document?')">
                                                        <i class="fas fa-trash me-1"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include('teacher_footer.php'); ?>
    
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // Confirm before delete
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this document?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>