<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../header.php';
include '../head-nav.php';
include '../side-bar.php';
include '../config/db.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Filter by date
$where = "";
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

if ($start_date && $end_date) {
    $where = "WHERE r.eval_date BETWEEN '$start_date' AND '$end_date'";
}

// Count total records (with filter)
$count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM records r $where");
$total = mysqli_fetch_assoc($count_query)['total'];
$total_pages = ceil($total / $limit);

// Fetch records with teacher photos using JOIN
$query = "
    SELECT r.*, t.photo 
    FROM records r
    LEFT JOIN teachers t ON r.teacher_id = t.teacher_id
    $where
    ORDER BY r.id DESC 
    LIMIT $start, $limit
";
$result = mysqli_query($conn, $query);
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
                <a href="add.php" class="btn btn-success">Back</a></h3>
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
           
            <?php if (isset($_GET['upload']) && $_GET['upload'] === 'success'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Document uploaded successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (isset($_GET['upload']) && $_GET['upload'] === 'error'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_GET['msg'] ?? 'Document upload failed.') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
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
                            <th>Upload Report</th>
                            <th>View Report</th>
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
                                    <?php if (!empty($row['photo']) && file_exists('../uploads/' . $row['photo'])): ?>
                                        <img src="../uploads/<?= $row['photo'] ?>" alt="Photo" class="teacher-thumb">
                                    <?php else: ?>
                                        <span>No Photo</span>
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
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="action-buttons" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this record?')" class="action-buttons" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                    <a href="print_single.php?id=<?= $row['id'] ?>" target="_blank" class="action-buttons" title="Print">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="action-buttons" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this record?')" class="action-buttons" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                    <a href="print_single.php?id=<?= $row['id'] ?>" target="_blank" class="action-buttons" title="Print">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                </td>
                                <td>
                                    <form action="upload_document.php" method="POST" enctype="multipart/form-data" style="display:flex; gap:5px;">
                                        <input type="hidden" name="record_id" value="<?= $row['id'] ?>">
                                        <input type="file" name="document" accept=".jpg,.jpeg,.png,.pdf" required style="width: 150px;">
                                        <button type="submit" class="btn btn-sm btn-primary" title="Upload">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <?php if (!empty($row['document']) && file_exists('../uploads/' . $row['document'])): ?>
                                        <a href="../uploads/<?= $row['document'] ?>" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <a href="../uploads/<?= $row['document'] ?>" download class="btn btn-sm btn-secondary">
                                            <i class="fa fa-download"></i> Download
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
            <div class="header-button mt-4">
                <a href="add.php" class="btn btn-success">Back</a></h3>
            </div>
            <!-- Pagination -->
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

    <?php include '../footer.php'; ?>
</body>

</html>