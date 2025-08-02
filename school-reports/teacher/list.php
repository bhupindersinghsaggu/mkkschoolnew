<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../header.php';
include '../head-nav.php';
include '../side-bar.php';
include '../config/db.php';

$message = '';

$result = mysqli_query($conn, "SELECT * FROM teachers ORDER BY id DESC");
?>


<!DOCTYPE html>
<html>

<head>
    <title>Add Notebook Review</title>
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
            border: 1px solid #E6EAED;
            background-color: #ffffff;
            border-radius: 5px;
            display: -ms-flexbox;
            -ms-flex-align: center;
            justify-content: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            padding: 8px;
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
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>" <i class="fa-solid fa-pen-to-square action-buttons"></i></a>
                                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this record?')"><i class="fa-solid fa-trash-can action-buttons"></i></a>
                                <a href="print_single.php?id=34" target="_blank"><i class="fa-solid fa-print action-buttons"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class=" d-flex justify-content-start mt-4">
                <a href="add.php" class="btn btn-secondary me-2" name="submit">Add Teacher</a>
            </div>

        </div>
    </div>

    <?php include '../footer.php'; ?>
</body>

</html>