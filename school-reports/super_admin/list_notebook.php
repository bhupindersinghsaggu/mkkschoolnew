<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

// NOTE: We fetch all matching records so DataTables can paginate / search client-side.
// If your dataset is very large, consider using server-side processing instead.

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

// Fetch records with teacher photos and documents (no LIMIT for client-side DataTables)
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
    <link rel="stylesheet" href="../assets/css/custom.css">

    <!-- DataTables CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>
        .teacher-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .action-buttons {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            background-color: #ffffff;
            border: 1px solid #E6EAED;
            border-radius: 5px;
            color: #333;
            transition: 0.2s;
            text-decoration: none;
        }

        .action-buttons:hover {
            background-color: #f5f5f5;
            color: #000;
        }

        td .action-buttons+.action-buttons {
            margin-left: 8px;
        }

        /* keep DataTables buttons visually consistent with your layout */
        .dt-buttons .btn {
            margin-right: 6px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="content">
            <div class="header-button d-flex justify-content-end align-items-center mb-3">
                <a href="add_notebook.php" class="btn btn-success">Add New</a>
            </div>
            <div class="mb-3">
                <h3 class="">Notebook Review Records</h3>
            </div>

            <!-- Date Filter -->
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($start_date) ?>">
                </div>
                <div class="col-md-4">
                    <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($end_date) ?>">
                </div>
                <div class="col-md-4 justify-content-between align-items-center">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </form>

            <input class="form-control mb-3" id="searchInput" type="text" placeholder="Search by Name, Class, Subject">

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
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <div class="d-inline-flex align-items-center">
                                        <span class="title-icon bg-soft-info fs-16 me-2"><i class="ti ti-info-circle"></i></span>
                                        <h5 class="card-title mb-0"> Document uploaded successfully!</h5>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php elseif (isset($_GET['upload']) && $_GET['upload'] === 'error'): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= htmlspecialchars($_GET['msg'] ?? 'Document upload failed.') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
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
                        <?php
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($result)):
                        ?>
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
                                <td class="d-flex gap-2">
                                    <a href="edit_notebook.php?id=<?= urlencode($row['id']) ?>" class="action-buttons" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="delete_notebook.php?id=<?= urlencode($row['id']) ?>" onclick="return confirm('Delete this record?')" class="action-buttons" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                    <a href="print_single_notebook.php?id=<?= urlencode($row['id']) ?>" target="_blank" class="action-buttons" title="Print">
                                         <span class="badge bg-secondary">View Report</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="header-button mt-4">
                <a href="add_notebook.php" class="btn btn-success">Back</a>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <!-- jQuery (required by DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap bundle -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables & Extensions -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Buttons extension + dependencies -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script>
        

        // Modal alert handling (keeps your previous behavior)
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const uploadStatus = urlParams.get('upload');
            const message = urlParams.get('msg');

            if (uploadStatus) {
                let alertText = '';
                if (uploadStatus === 'success') {
                    alertText = '✅ Document uploaded successfully!';
                } else if (uploadStatus === 'error') {
                    alertText = '❌ ' + (message || 'Document upload failed.');
                }

                // Set modal message
                document.getElementById('alertModalBody').innerText = alertText;

                // Show modal
                var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                alertModal.show();
            }
        });
    </script>

    <?php include '../includes/footer.php'; ?>
</body>

</html>
