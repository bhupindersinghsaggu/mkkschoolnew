<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

// Filter by date (using prepared statements)
$where = "";
$params = [];
$types = "";
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

if ($start_date && $end_date) {
    $where = "WHERE r.eval_date BETWEEN ? AND ?";
    $params = [$start_date, $end_date];
    $types = "ss";
}

// Fetch records (no LIMIT; DataTables will handle paging client-side)
$sql = "
    SELECT r.*, td.profile_pic, r.document 
    FROM records r
    LEFT JOIN teacher_details td ON r.teacher_id = td.teacher_id
    $where
    ORDER BY r.id DESC
";
$query = $conn->prepare($sql);
if ($where) {
    $query->bind_param($types, ...$params);
}
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Notebook Records</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png">

    <!-- Basic styles -->
    <!-- <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css"> -->

    <!-- Simple DataTables CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> -->

    <style>
        .teacher-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        /* .action-buttons {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            background-color: #ffffff;
            border: 1px solid #E6EAED;
            border-radius: 4px;
            text-decoration: none;
        }
        .action-buttons + .action-buttons { margin-left: 6px; } */
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="content">
            <div class="header-button d-flex justify-content-end align-items-center mb-3">
                <a href="add_notebook.php" class="btn btn-success">Add New</a>
            </div>

            <h3 class="mb-3">Notebook Review Records</h3>

            <!-- Date Filter -->
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($start_date) ?>">
                </div>
                <div class="col-md-4">
                    <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($end_date) ?>">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </form>

            <!-- Optional custom search (you can use DataTables' built-in search instead) -->
            <input class="form-control mb-3" id="searchInput" type="text" placeholder="Search table...">

            <!-- Alert Modal -->
            <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="alertModalLabel">Notification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="alertModalBody">
                            <?php if (isset($_GET['upload']) && $_GET['upload'] === 'success'): ?>
                                <div class="alert alert-success">Document uploaded successfully!</div>
                            <?php elseif (isset($_GET['upload']) && $_GET['upload'] === 'error'): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($_GET['msg'] ?? 'Document upload failed.') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Simple table for DataTables -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="recordsTable" style="width:100%;">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Session</th>
                            <th>Date</th>
                            <th>Teacher</th>
                            <th>ID</th>
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Books Checked</th>
                            <th>Rating</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td>
                                    <?php
                                    $photoPath = '../uploads/profile_pics/' . ($row['profile_pic'] ?? '');
                                    if (!empty($row['profile_pic']) && file_exists($photoPath)): ?>
                                        <img src="<?= htmlspecialchars($photoPath) ?>"
                                             alt="<?= htmlspecialchars($row['teacher_name']) ?>"
                                             class="teacher-thumb"
                                             onerror="this.onerror=null;this.src='../assets/img/default-profile.jpg'">
                                    <?php else: ?>
                                        <div class="teacher-thumb bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['session']) ?></td>
                                <td><?= htmlspecialchars($row['eval_date']) ?></td>
                                <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                                <td><?= htmlspecialchars($row['teacher_id']) ?></td>
                                <td><?= htmlspecialchars($row['subject']) ?></td>
                                <td><?= htmlspecialchars($row['class_section']) ?></td>
                                <td><?= htmlspecialchars($row['notebooks_checked']) ?></td>
                                <td><?= htmlspecialchars($row['overall_rating']) ?></td>
                                <td>
                                    <a href="edit_notebook.php?id=<?= urlencode($row['id']) ?>" class="action-buttons" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="delete_notebook.php?id=<?= urlencode($row['id']) ?>" onclick="return confirm('Delete this record?')" class="action-buttons" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                    <a href="print_single_notebook.php?id=<?= urlencode($row['id']) ?>" target="_blank" class="action-buttons" title="View Report">
                                        <small>View</small>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <a href="add_notebook.php" class="btn btn-success">Back</a>
            </div>
        </div>
    </div>

    <!-- Minimal scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- Simple DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with defaults (search, sort, paging)
            var table = $('#recordsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                ordering: true,
                // If you don't want the built-in search input, set searching: false
                // searching: true
            });

            // Wire optional custom search input to DataTables
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Show alert modal if URL contains upload param
            const urlParams = new URLSearchParams(window.location.search);
            const uploadStatus = urlParams.get('upload');
            if (uploadStatus) {
                var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                alertModal.show();
            }
        });
    </script>

    <?php include '../includes/footer.php'; ?>
</body>

</html>
