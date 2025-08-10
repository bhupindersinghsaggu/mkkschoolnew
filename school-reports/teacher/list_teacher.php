
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and check authentication
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login.php');
    exit();
}

require_once '../config/database.php';
require_once '../config/functions.php';

// Safely get teacher_id with null coalescing operator
$teacher_id = $_SESSION['teacher_id'] ?? null;

if (!$teacher_id) {
    die("<div class='alert alert-danger'>Teacher profile not configured. Please contact administration.</div>");
}

// Rest of your pagination and query code...
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Count records for THIS teacher only
$count_query = $conn->prepare("SELECT COUNT(*) AS total FROM records WHERE teacher_id = ?");
$count_query->bind_param("s", $teacher_id);
$count_query->execute();
$total = $count_query->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

// Fetch records for this teacher only
$query = $conn->prepare("
    SELECT u.id, u.role, td.teacher_id 
          FROM users u
          JOIN teacher_details td ON u.id = td.user_id
          WHERE u.username = ? AND u.password = ?");

$query->bind_param("sii", $teacher_id, $start, $limit);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Notebook Reports</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <style>
        .teacher-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .btn-action {
            padding: 5px 10px;
            margin: 2px;
        }
        .document-status {
            padding: 5px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">My Notebook Evaluation Reports</h3>
            </div>
            
            <div class="card-body">
                <!-- Records Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Session</th>
                                <th>Date</th>
                                <th>Subject</th>
                                <th>Class</th>
                                <th>Books Checked</th>
                                <th>Rating</th>
                                <th>Document</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php $count = $start + 1; while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= htmlspecialchars($row['session']) ?></td>
                                        <td><?= htmlspecialchars($row['eval_date']) ?></td>
                                        <td><?= htmlspecialchars($row['subject']) ?></td>
                                        <td><?= htmlspecialchars($row['class_section']) ?></td>
                                        <td><?= htmlspecialchars($row['notebooks_checked']) ?></td>
                                        <td><?= htmlspecialchars($row['overall_rating']) ?></td>
                                        <td>
                                            <?php 
                                            $docPath = !empty($row['document']) ? '../uploads/' . htmlspecialchars($row['document']) : '';
                                            if ($docPath && file_exists($docPath)): ?>
                                                <a href="<?= $docPath ?>" target="_blank" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="<?= $docPath ?>" download class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            <?php elseif (!empty($row['document'])): ?>
                                                <span class="text-danger document-status">File missing</span>
                                            <?php else: ?>
                                                <span class="text-muted document-status">No document</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="print_single_notebook.php?id=<?= $row['id'] ?>" 
                                               target="_blank" 
                                               class="btn btn-sm btn-primary btn-action"
                                               title="Print Report">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4">No evaluation records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-4">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>">
                                   <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>