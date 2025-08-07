<?php
include '../../auth.php';
include '../../header.php';
include '../../head-nav.php';
include '../../side-bar.php';
include '../../config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid Record ID</div>";
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM records WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$record = mysqli_fetch_assoc($result);

if (!$record) {
    echo "<div class='alert alert-warning'>Record not found.</div>";
    exit;
}

// Fetch teacher list for dropdown
$teachers_result = mysqli_query($conn, "SELECT teacher_id, teacher_name FROM teachers ORDER BY teacher_name ASC");

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session = $_POST['session'];
    $eval_date = $_POST['eval_date'];
    $teacher_id = $_POST['teacher_id'];
    $teacher_name = ''; // Will be fetched below
    $subject = $_POST['subject'];
    $class_section = $_POST['class_section'];
    $notebooks_checked = $_POST['notebooks_checked'];
    $students_reviewed = $_POST['students_reviewed'];
    $regularity_checking = $_POST['regularity_checking'];
    $accuracy = $_POST['accuracy'];
    $neatness = $_POST['neatness'];
    $follow_up = $_POST['follow_up'];
    $overall_rating = $_POST['overall_rating'];
    $evaluator_name = $_POST['evaluator_name'];
    $remarks = $_POST['remarks'];
    $undertaking = isset($_POST['undertaking']) ? 1 : 0;

    // Fetch teacher_name from teachers table
    $tq = mysqli_query($conn, "SELECT teacher_name FROM teachers WHERE teacher_id = '$teacher_id' LIMIT 1");
    if ($tq && mysqli_num_rows($tq) > 0) {
        $tdata = mysqli_fetch_assoc($tq);
        $teacher_name = $tdata['teacher_name'];
    }

    $updateSql = "UPDATE records SET session=?, eval_date=?, teacher_name=?, teacher_id=?, subject=?, class_section=?,
        notebooks_checked=?, students_reviewed=?, regularity_checking=?, accuracy=?, neatness=?,
        follow_up=?, overall_rating=?, evaluator_name=?, remarks=?, undertaking=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssissssssssii",
        $session,
        $eval_date,
        $teacher_name,
        $teacher_id,
        $subject,
        $class_section,
        $notebooks_checked,
        $students_reviewed,
        $regularity_checking,
        $accuracy,
        $neatness,
        $follow_up,
        $overall_rating,
        $evaluator_name,
        $remarks,
        $undertaking,
        $id
    );
    mysqli_stmt_execute($stmt);

    echo "<script>alert('Record updated successfully'); window.location='list.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Record</title>
    <title>Notebook Records</title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png">
    <link rel="apple-touch-icon" href="../../assets/img/apple-touch-icon.png">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../../assets/css/animate.css">
    <link rel="stylesheet" href="../../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../assets/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../../assets/plugins/tabler-icons/tabler-icons.min.css">
    <link rel="stylesheet" href="../../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../assets/plugins/%40simonwep/pickr/themes/nano.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body>
    <div class="page-wrapper mb-3">
        <div class="content">
            <div class="header-button d-flex justify-content-end align-items-center mb-3">
                <a href="list.php" class="btn btn-success">Back</a></h3>
            </div>
            <div class="mb-3">
                <h3 class="">Edit Record</h3>
            </div>
            <form method="POST">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="mb-3"><label>Session</label>
                            <input type="text" name="session" value="<?= htmlspecialchars($record['session']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3"><label>Evaluation Date</label>
                            <input type="date" name="eval_date" value="<?= htmlspecialchars($record['eval_date']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3"><label>Teacher ID</label>
                            <select name="teacher_id" class="form-control" required>
                                <option value="">-- Select Teacher ID --</option>
                                <?php while ($t = mysqli_fetch_assoc($teachers_result)) : ?>
                                    <option value="<?= $t['teacher_id'] ?>" <?= $t['teacher_id'] == $record['teacher_id'] ? 'selected' : '' ?>>
                                        <?= $t['teacher_id'] ?> - <?= $t['teacher_name'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3"><label>Subject</label>
                            <input type="text" name="subject" value="<?= htmlspecialchars($record['subject']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3"><label>Class/Section</label>
                            <input type="text" name="class_section" value="<?= htmlspecialchars($record['class_section']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3"><label>No. of Notebooks Checked</label>
                            <input type="number" name="notebooks_checked" value="<?= htmlspecialchars($record['notebooks_checked']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3"><label>Students Reviewed</label>
                            <textarea name="students_reviewed" class="form-control" required><?= htmlspecialchars($record['students_reviewed']) ?></textarea>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3"><label>Regularity in Checking</label>
                            <select name="regularity_checking" class="form-control">
                                <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                    <option <?= $record['regularity_checking'] == $option ? 'selected' : '' ?>><?= $option ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3"><label>Accuracy</label>
                            <select name="accuracy" class="form-control">
                                <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                    <option <?= $record['accuracy'] == $option ? 'selected' : '' ?>><?= $option ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3"><label>Neatness</label>
                            <select name="neatness" class="form-control">
                                <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                    <option <?= $record['neatness'] == $option ? 'selected' : '' ?>><?= $option ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3"><label>Follow Up</label>
                            <select name="follow_up" class="form-control">
                                <option <?= $record['follow_up'] == 'Done' ? 'selected' : '' ?>>Done</option>
                                <option <?= $record['follow_up'] == 'Not Done' ? 'selected' : '' ?>>Not Done</option>
                            </select>
                        </div>
                        <div class="mb-3"><label>Overall Rating</label>
                            <select name="overall_rating" class="form-control">
                                <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                    <option <?= $record['overall_rating'] == $option ? 'selected' : '' ?>><?= $option ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3"><label>Evaluator Name</label>
                            <input type="text" name="evaluator_name" value="<?= htmlspecialchars($record['evaluator_name']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3"><label>Remarks</label>
                            <textarea name="remarks" class="form-control"><?= htmlspecialchars($record['remarks']) ?></textarea>
                        </div>
                        <!-- <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="undertaking" id="undertaking" <?= $record['undertaking'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="undertaking">I confirm this information is correct.</label>
                </div> -->
                    </div>
                    <button type="submit" class="btn btn-secondary">Update Record</button>
                    <a href="list.php" class="btn btn-success">Back</a>
            </form>
        </div>
    </div>

    <?php include '../../footer.php'; ?>
</body>

</html>