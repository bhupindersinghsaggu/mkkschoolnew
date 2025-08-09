<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once  '../includes/header.php';
require_once  '../config/database.php';
require_once  '../config/functions.php';

$message = '';

$result = mysqli_query($conn, "SELECT * FROM teachers ORDER BY id DESC");
?>


<!DOCTYPE html>
<html>

<head>
    <title>Teachers</title>
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
            max-width: 80px;
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
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3 class="">Add Teacher</h3>
                <a href="add.php" class="btn btn-secondary">Add Teacher</a></h3>
            </div>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr class="odd">
                        <th>Photo</th>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="odd">
                            <td>
                                <?php
                                $photo_path = '../uploads/' . $row['photo'];
                                if (!empty($row['photo']) && file_exists($photo_path)): ?>
                                    <img src="<?= $photo_path ?>" class="teacher-thumb" alt="Photo"
                                        <?php else: ?>
                                        <span>No photo</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $row['teacher_name'] ?></td>
                            <td><?= $row['teacher_id'] ?></td>
                            <td><?= $row['subject'] ?></td>
                            <td><?= $row['teacher_type'] ?></td>
                            <td class="d-flex gap-2">
                                <a href="edit_teacher.php?id=<?= $row['id'] ?>" class="action-buttons" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="delete_teacher.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this record?')" class="action-buttons" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class=" d-flex justify-content-start mt-4">
                <a href="add_teacher.php" class="btn btn-success me-2" name="submit">Back</a>
            </div>

        </div>
    </div>

 <?php include '../includes/footer.php'; ?>
</body>

</html>