<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';

// Ensure only teachers can access this page
if ($_SESSION['role'] !== 'teacher') {
    header('Location: ../dashboard.php');
    exit();
}

// Get teacher ID from session
$teacher_id = $_SESSION['user_id'];

// Fetch teacher's documents
$query = $conn->prepare("
    SELECT r.id, r.teacher_name, r.subject, r.class_section, r.eval_date, r.document 
    FROM records r
    WHERE r.teacher_id = ?
    ORDER BY r.eval_date DESC
");
$query->bind_param("i", $teacher_id);
$query->execute();
$result = $query->get_result();
$documents = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Documents</title>
    <!-- Include your CSS files here -->
</head>
<body>
    <div class="page-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="page-header">
                    <h3 class="page-title">My Documents</h3>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Subject</th>
                                                <th>Class</th>
                                                <th>Document</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($documents) > 0): ?>
                                                <?php foreach ($documents as $doc): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($doc['eval_date']) ?></td>
                                                        <td><?= htmlspecialchars($doc['subject']) ?></td>
                                                        <td><?= htmlspecialchars($doc['class_section']) ?></td>
                                                        <td>
                                                            <?php if (!empty($doc['document'])): ?>
                                                                <?php
                                                                $docPath = '../uploads/teacher_documents/' . htmlspecialchars($doc['document']);
                                                                if (file_exists($docPath)): ?>
                                                                    <a href="<?= $docPath ?>" target="_blank" class="btn btn-sm btn-info">
                                                                        <i class="fa fa-eye"></i> View
                                                                    </a>
                                                                    <a href="<?= $docPath ?>" download class="btn btn-sm btn-secondary">
                                                                        <i class="fa fa-download"></i> Download
                                                                    </a>
                                                                <?php else: ?>
                                                                    <span class="text-danger">File missing</span>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <span class="text-muted">No document available</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">No documents found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>