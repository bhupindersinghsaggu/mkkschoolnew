<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

// Fetch all records from class_show table
$query = "SELECT * FROM class_show ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Class Show Records</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .action-buttons {
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="content">
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3>Class Show</h3>
                <div class="d-flex gap-2">
                    <a href="add_class_show.php" class="btn btn-success">Add </a>
                    <a href="./dashboard.php" class="btn btn-secondary">Dashboard</a>
                </div>
            </div>

            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-info"><?= htmlspecialchars($_GET['message']) ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Session</th>
                                        <th>Date</th>
                                        <th>Teacher</th>
                                        <th>Class</th>
                                        <th>Topic</th>
                                        <th>Video Link</th>
                                        <th>Judge</th>
                                        <th>Total Score (Out of 40)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): 
                                        // Calculate average marks for each row
                                        $marks1 = (int)$row['marks_judge1'];
                                        $marks2 = (int)$row['marks_judge2'];
                                        $average_marks = ($marks1 + $marks2) / 2;
                                        
                                        // Debug: Check what values you're getting
                                        error_log("Judge 1 marks: " . $row['marks_judge1']);
                                        error_log("Judge 2 marks: " . $row['marks_judge2']);
                                        error_log("Calculated average: " . $average_marks);
                                    ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= htmlspecialchars($row['session']) ?></td>
                                            <td><?= date('d M Y', strtotime($row['eval_date'])) ?></td>
                                            <td><?= htmlspecialchars($row['teacher_name']) ?><br>
                                                <small class="text-muted">ID: <?= htmlspecialchars($row['teacher_id']) ?></small>
                                            </td>
                                            <td><?= htmlspecialchars($row['class_section']) ?></td>
                                            <td> <a href="view_class_show.php?id=<?= $row['id'] ?>">  <?= htmlspecialchars($row['topic']) ?>- View Report</a></td>
                                            <td>
                                                <a href="<?= htmlspecialchars($row['video_link']) ?>" target="_blank" title="Watch Video">
                                                    <i class="fas fa-external-link-alt"></i> View <!-- External link icon -->
                                                </a>
                                            </td>
                                            <td><?= htmlspecialchars($row['evaluator_name']) ?></td>
                                            <td><strong> <input type="number" class="form-control fw-bold text-success"
                                                        value="<?= number_format($average_marks, 2) ?>"
                                                        readonly> </td>
                                            <td class="action-buttons">
                                                <a href="view_class_show.php?id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="edit_class_show.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="delete_class_show.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this record?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i> No class show records found.
                            <a href="add_class_show.php" class="alert-link">Add your first record</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>

<?php
// Free result set
mysqli_free_result($result);
?>