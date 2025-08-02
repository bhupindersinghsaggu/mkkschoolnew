<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../header.php';
include '../head-nav.php';
include '../side-bar.php';
include '../config/db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_name = mysqli_real_escape_string($conn, $_POST['teacher_name']);
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $department = mysqli_real_escape_string($conn, $_POST['subject']);
    $teacher_type = mysqli_real_escape_string($conn, $_POST['teacher_type']);

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = '../uploads/';  // ✅ Fix: relative to current script
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $filename = basename($_FILES['photo']['name']);
        $photo_name = time() . "_" . $filename;
        $target_file = $upload_dir . $photo_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ['jpg', 'jpeg', 'png'];
        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                $query = "INSERT INTO teachers (teacher_name, teacher_id, subject, teacher_type, photo)
                      VALUES ('$teacher_name', '$teacher_id', '$subject', '$teacher_type', '$photo_name')";
                if (mysqli_query($conn, $query)) {
                    $message = "Teacher added successfully!";
                } else {
                    $message = "Database error: " . mysqli_error($conn);
                }
            } else {
                $message = "Failed to upload photo.";
            }
        } else {
            $message = "Only JPG, JPEG, PNG files allowed.";
        }
    }
} else {
    // $message = "Photo is required.";
}

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
</head>

<body>
    <div class="page-wrapper">
        <div class="content ">
            <div class="header-button d-flex justify-content-center">
                <h3 class="mb-3">Add Teacher</h3>
                <a href="list.php" class="btn btn-secondary me-2">View Teacher</a></h3>
            </div>
            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xl-6 col-sm-6 col-12">
                    <div class="card dash-widget w-100">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label>Teacher Name</label>
                                    <input type="text" name="teacher_name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Teacher ID</label>
                                    <input type="text" name="teacher_id" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Subject</label>
                                    <input type="text" name="subject" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Teacher Type</label>
                                    <select name="teacher_type" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="PPRT">PPRT</option>
                                        <option value="PRT">PRT</option>
                                        <option value="PGT">PGT</option>
                                        <option value="PGT">TGT</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Photo (JPG/PNG)</label>
                                    <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="form-control" required>
                                </div>

                                <div class="d-flex justify-content-start ">
                                    <button type="submit" class="btn btn-primary me-2">Save Teacher</button>
                                    <a href="list.php" class="btn btn-secondary me-2" name="submit">View Teacher</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../footer.php'; ?>
</body>

</html>