<?php

ob_start(); // Start output buffering
require_once '../config/database.php';
require_once '../includes/header.php';



// Handle teacher deletion
if (isset($_GET['delete'])) {
    $teacher_id = intval($_GET['delete']);

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // First get the user_id and profile_pic
        $query = "SELECT user_id, profile_pic FROM teacher_details WHERE id = $teacher_id";
        $result = mysqli_query($conn, $query);
        $teacher = mysqli_fetch_assoc($result);

        if ($teacher) {
            // Delete from teacher_details
            mysqli_query($conn, "DELETE FROM teacher_details WHERE id = $teacher_id");

            // Delete from users
            mysqli_query($conn, "DELETE FROM users WHERE id = {$teacher['user_id']}");

            // Delete profile picture if exists
            if ($teacher['profile_pic'] && file_exists("../uploads/profile_pics/{$teacher['profile_pic']}")) {
                unlink("../uploads/profile_pics/{$teacher['profile_pic']}");
            }

            mysqli_commit($conn);
            $_SESSION['success'] = "Teacher deleted successfully";
        } else {
            $_SESSION['error'] = "Teacher not found";
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['error'] = "Error deleting teacher: " . $e->getMessage();
    }

    header('Location: list_teacher.php');
    exit();
}

// Fetch all teachers with their details
$query = "SELECT td.id, td.teacher_name, td.teacher_id, td.subject, td.teacher_type, 
                 td.profile_pic, u.email, u.username, u.created_at
          FROM teacher_details td
          JOIN users u ON td.user_id = u.id
          ORDER BY td.teacher_name ASC";
$result = mysqli_query($conn, $query);
$teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher List</title>
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
        .profile-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #dee2e6;
        }

        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="content mb-3">
            <div class="container py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0 mt-4">Teacher Management</h2>
                    <a href="register_teacher.php" class="btn btn-success mt-4">
                        <i class="bi bi-plus-lg"></i> Add
                    </a>
                </div>

                <!-- Display success/error messages -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Registered Teachers</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Photo</th>
                                        <th>Teacher Name</th>
                                        <th>Teacher ID</th>
                                        <th>Subject</th>
                                        <th>Type</th>
                                        <!-- <th>Email</th> -->
                                        <!-- <th>Username</th>
                                        <th>Registered</th> -->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($teachers) > 0): ?>
                                        <?php foreach ($teachers as $teacher): ?>
                                            <tr>
                                                <td>
                                                    <?php if ($teacher['profile_pic']): ?>
                                                        <img src="../uploads/profile_pics/<?= htmlspecialchars($teacher['profile_pic']) ?>"
                                                            alt="<?= htmlspecialchars($teacher['teacher_name']) ?>" class="profile-img">
                                                    <?php else: ?>
                                                        <div class="profile-img bg-secondary text-white d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-person-fill"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($teacher['teacher_name']) ?></td>
                                                <td><?= htmlspecialchars($teacher['teacher_id']) ?></td>
                                                <td><?= htmlspecialchars($teacher['subject']) ?></td>
                                                <td><?= htmlspecialchars($teacher['teacher_type']) ?></td>
                                                <!-- <td><?= htmlspecialchars($teacher['email']) ?></td> -->
                                                <!-- <td><?= htmlspecialchars($teacher['username']) ?></td>
                                                <td><?= date('M j, Y', strtotime($teacher['created_at'])) ?></td> -->
                                                <td class="action-btns">
                                                    <a href="edit_teacher.php?id=<?= $teacher['id'] ?>"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm"
                                                        data-id="<?= $teacher['id'] ?>"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center py-4">No teachers found. Add your first teacher.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this teacher? This action cannot be undone.</p>
                            <p class="fw-bold">All associated data will be permanently removed.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="#" id="confirmDelete" class="btn btn-danger">Delete Teacher</a>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                // Delete confirmation
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const teacherId = this.getAttribute('data-id');
                        const deleteLink = document.getElementById('confirmDelete');
                        deleteLink.href = `list_teacher.php?delete=${teacherId}`;

                        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                        modal.show();
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>
<?php
ob_end_flush(); // Send the output
?>