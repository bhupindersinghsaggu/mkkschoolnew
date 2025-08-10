<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';

// Get teacher ID from session or URL
$teacher_id = $_SESSION['user_id']; // Or $_GET['id'] if viewing other profiles

// Fetch teacher details
$teacherQuery = "SELECT * FROM teacher_details WHERE teacher_id = ?";
$stmt = mysqli_prepare($conn, $teacherQuery);
mysqli_stmt_bind_param($stmt, "s", $teacher_id);
mysqli_stmt_execute($stmt);
$teacherResult = mysqli_stmt_get_result($stmt);
$teacher = mysqli_fetch_assoc($teacherResult);

// Fetch notebook reviews for this teacher
$reviewsQuery = "SELECT * FROM records WHERE teacher_id = ? ORDER BY eval_date DESC";
$stmt = mysqli_prepare($conn, $reviewsQuery);
mysqli_stmt_bind_param($stmt, "s", $teacher_id);
mysqli_stmt_execute($stmt);
$reviews = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Profile</title>
    <!-- Include your CSS files here -->
</head>
<body>
    <div class="page-wrapper">
        <div class="content mb-3">
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3>Teacher Profile: <?= htmlspecialchars($teacher['teacher_name']) ?></h3>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <?php if ($teacher['profile_pic']): ?>
                                    <img src="../uploads/profile_pics/<?= htmlspecialchars($teacher['profile_pic']) ?>" 
                                         class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                         style="width: 150px; height: 150px; margin: 0 auto;">
                                        <i class="fas fa-user text-white" style="font-size: 60px;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h4 class="text-center"><?= htmlspecialchars($teacher['teacher_name']) ?></h4>
                            <p class="text-center text-muted"><?= htmlspecialchars($teacher['teacher_id']) ?></p>
                            
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Subject:</strong> <?= htmlspecialchars($teacher['subject']) ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Type:</strong> <?= htmlspecialchars($teacher['teacher_type']) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Notebook Review Documents</h5>
                        </div>
                        <div class="card-body">
                            <?php if (mysqli_num_rows($reviews) > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Evaluator</th>
                                                <th>Overall Rating</th>
                                                <th>Document</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($review = mysqli_fetch_assoc($reviews)): ?>
                                                <tr>
                                                    <td><?= date('d M Y', strtotime($review['eval_date'])) ?></td>
                                                    <td><?= htmlspecialchars($review['evaluator_name']) ?></td>
                                                    <td><?= htmlspecialchars($review['overall_rating']) ?></td>
                                                    <td>
                                                        <?php if (!empty($review['document_path'])): ?>
                                                            <a href="../uploads/notebook_reviews/<?= htmlspecialchars($review['document_path']) ?>" 
                                                               class="btn btn-sm btn-primary" target="_blank">
                                                                <i class="fas fa-download"></i> Download
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">No document</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">No notebook reviews found for this teacher.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>