<?php
include '../config/db.php';
include '../header.php';
include '../head-nav.php';
include '../side-bar.php';

$id = $_GET['id'] ?? 0;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_name = mysqli_real_escape_string($conn, $_POST['teacher_name']);
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $department = mysqli_real_escape_string($conn, $_POST['subject']);
    $teacher_type = mysqli_real_escape_string($conn, $_POST['teacher_type']);
    $photo_path = $_POST['existing_photo'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $upload_dir = 'uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $filename = basename($_FILES['photo']['name']);
        $photo_path = $upload_dir . time() . "_" . $filename;
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    }

    $query = "UPDATE teachers SET 
        teacher_name = '$teacher_name',
        teacher_id = '$teacher_id',
        subject = '$subject',
        teacher_type = '$teacher_type',
        photo = '$photo_path'
        WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $message = "Teacher updated successfully.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM teachers WHERE id = $id");
$row = mysqli_fetch_assoc($result);
?>
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
<div class="page-wrapper">
    <div class="content">
       <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3 class="">Edit Teacher</h3>
                <a href="list.php" class="btn btn-secondary">View Teacher</a></h3>
            </div>
        <?php if ($message): ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-4">
                <label>Teacher Name</label>
                <input type="text" name="teacher_name" class="form-control" value="<?= $row['teacher_name'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Teacher ID</label>
                <input type="text" name="teacher_id" class="form-control" value="<?= $row['teacher_id'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" value="<?= $row['subject'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Teacher Type</label>
                <select name="teacher_type" class="form-control" required>
                    <option value="">--Select--</option>
                    <option value="PPRT" <?= $row['teacher_type'] == 'PPRT' ? 'selected' : '' ?>>PPRT</option>
                    <option value="PRT" <?= $row['teacher_type'] == 'PRT' ? 'selected' : '' ?>>PRT</option>
                    <option value="PGT" <?= $row['teacher_type'] == 'PGT' ? 'selected' : '' ?>>PGT</option>
                    <option value="TGT" <?= $row['teacher_type'] == 'TGT' ? 'selected' : '' ?>>TGT</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Current Photo:</label><br>
                 <img src="<?= $row['photo'] ?>" width="80" alt="Photo">
                <label>Change Photo (optional):</label>
                <input type="file" name="photo" class="form-control">
                <input type="hidden" name="existing_photo" value="<?= $row['photo'] ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Teacher</button>
        </form>
    </div>
</div>
<?php include '../footer.php'; ?>
