<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

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

// Count total records
$count_query = $conn->prepare("SELECT COUNT(*) AS total FROM records r $where");
if ($where) {
    $count_query->bind_param($types, ...$params);
}
$count_query->execute();
$total = $count_query->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

// Fetch records with teacher photos and documents
// Change your query to:
$query = $conn->prepare("
    SELECT r.*, td.profile_pic, r.document 
    FROM records r
    LEFT JOIN teacher_details td ON r.teacher_id = td.teacher_id
    $where
    ORDER BY r.id DESC 
    LIMIT ?, ?
");

if ($where) {
    $params[] = $start;
    $params[] = $limit;
    $types .= "ii";
    $query->bind_param($types, ...$params);
} else {
    $query->bind_param("ii", $start, $limit);
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
                    <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>">
                </div>
                <div class="col-md-4">
                    <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>">
                </div>
                <div class="col-md-4 justify-content-between align-items-center">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </form>
            <input class="form-control mb-3" id="searchInput" type="text" placeholder="Search by Name, Class, Subject">
            <!-- File upload Alert Message start -->

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

            <!-- File upload Alert Message start -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="recordsTable">
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
                            <!-- <th>Reviewed</th> -->
                            <th>Rating</th>
                            <th>Actions</th>
                            <!-- <th>Upload Report</th>
                            <th>View Report</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = $start + 1;
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
                                <td><?= $row['session'] ?></td>
                                <td><?= $row['eval_date'] ?></td>
                                <td><?= $row['teacher_name'] ?></td>
                                <td><?= $row['teacher_id'] ?></td>
                                <td><?= $row['subject'] ?></td>
                                <td><?= $row['class_section'] ?></td>
                                <td><?= $row['notebooks_checked'] ?></td>
                                <!-- <td><?= $row['students_reviewed'] ?></td> -->
                                <td><?= $row['overall_rating'] ?></td>
                                <td class="d-flex gap-2">
                                    <a href="edit_notebook.php?id=<?= $row['id'] ?>" class="action-buttons" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="delete_notebook.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this record?')" class="action-buttons" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                    <a href="print_single_notebook.php?id=<?= $row['id'] ?>" target="_blank" class="action-buttons" title="Print">
                                        <span class="badge bg-secondary">View Report</span>
                                    </a>
                                </td>
                                <!-- <td>
                                    <form action="upload_document_notebook.php" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                                        <input type="hidden" name="record_id" value="<?= htmlspecialchars($row['id']) ?>">
                                        <input type="hidden" name="teacher_id" value="<?= htmlspecialchars($row['teacher_id']) ?>">
                                        <div class="position-relative" style="width: 150px;">
                                            <input type="file" name="document" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                                class="form-control form-control-sm" required>
                                            <div class="invalid-feedback">Please select a valid file</div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary" title="Upload">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                    </form>
                                </td> -->
                                <!-- <td>
                                    <?php
                                    if (!empty($row['document'])):
                                        // Sanitize and secure the document path
                                        $docPath = '../uploads/teacher_documents/' . htmlspecialchars(basename($row['document']));

                                        // Check if file exists and is within the allowed directory
                                        $allowedPath = realpath('../uploads/teacher_documents/');
                                        $currentPath = realpath($docPath);

                                        if ($currentPath && strpos($currentPath, $allowedPath) === 0 && file_exists($currentPath)):
                                            $fileExt = strtolower(pathinfo($currentPath, PATHINFO_EXTENSION));
                                            $iconClass = [
                                                'pdf' => 'fa-file-pdf',
                                                'jpg' => 'fa-file-image',
                                                'jpeg' => 'fa-file-image',
                                                'png' => 'fa-file-image',
                                                'doc' => 'fa-file-word',
                                                'docx' => 'fa-file-word',
                                            ][$fileExt] ?? 'fa-file';
                                    ?>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?= htmlspecialchars($docPath) ?>" target="_blank" class="btn btn-info"
                                                    title="View <?= htmlspecialchars($row['document']) ?>">
                                                    <i class="fa <?= $iconClass ?>"></i> View
                                                </a>
                                                <a href="<?= htmlspecialchars($docPath) ?>" download
                                                    class="btn btn-secondary" title="Download">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-danger">File not found</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No document</span>
                                    <?php endif; ?>
                                </td> -->
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="header-button mt-4 d-flex justify-content-between">
                <a href="add_notebook.php" class="btn btn-success">Back</a></h3>
                <div>
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Pagination -->

        </div>
    </div>

    <script>
        // Live search filter
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#recordsTable tbody tr");

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>
    <script>
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