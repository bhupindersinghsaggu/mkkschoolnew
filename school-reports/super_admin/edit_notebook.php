<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

// Validate ID parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid Record ID";
    header('Location: list.php');
    exit;
}

$id = (int)$_GET['id'];

// Fetch record using prepared statement
$sql = "SELECT * FROM records WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$record = mysqli_fetch_assoc($result);

if (!$record) {
    $_SESSION['error'] = "Record not found";
    header('Location: list.php');
    exit;
}

// Fetch teachers for dropdown
$teachers_stmt = mysqli_prepare($conn, "SELECT teacher_id, teacher_name FROM teachers ORDER BY teacher_name ASC");
mysqli_stmt_execute($teachers_stmt);
$teachers_result = mysqli_stmt_get_result($teachers_stmt);
$teachers = mysqli_fetch_all($teachers_result, MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $session = htmlspecialchars(trim($_POST['session']));
    $eval_date = $_POST['eval_date'];
    $teacher_id = $_POST['teacher_id'];
    $subject = htmlspecialchars(trim($_POST['subject']));
    $class_section = htmlspecialchars(trim($_POST['class_section']));
    $notebooks_checked = (int)$_POST['notebooks_checked'];
    $students_reviewed = htmlspecialchars(trim($_POST['students_reviewed']));
    $regularity_checking = htmlspecialchars(trim($_POST['regularity_checking']));
    $accuracy = htmlspecialchars(trim($_POST['accuracy']));
    $neatness = htmlspecialchars(trim($_POST['neatness']));
    $follow_up = htmlspecialchars(trim($_POST['follow_up']));
    $overall_rating = htmlspecialchars(trim($_POST['overall_rating']));
    $evaluator_name = htmlspecialchars(trim($_POST['evaluator_name']));
    $remarks = htmlspecialchars(trim($_POST['remarks']));
    $undertaking = isset($_POST['undertaking']) ? 1 : 0;

    // Fetch teacher name safely
    $tq = mysqli_prepare($conn, "SELECT teacher_name FROM teachers WHERE teacher_id = ? LIMIT 1");
    mysqli_stmt_bind_param($tq, "s", $teacher_id);
    mysqli_stmt_execute($tq);
    $tdata = mysqli_stmt_get_result($tq)->fetch_assoc();
    $teacher_name = $tdata['teacher_name'] ?? '';

    // Update record
    $updateSql = "UPDATE records SET 
        session = ?, 
        eval_date = ?, 
        teacher_name = ?, 
        teacher_id = ?, 
        subject = ?, 
        class_section = ?,
        notebooks_checked = ?, 
        students_reviewed = ?, 
        regularity_checking = ?, 
        accuracy = ?, 
        neatness = ?,
        follow_up = ?, 
        overall_rating = ?, 
        evaluator_name = ?, 
        remarks = ?, 
        undertaking = ? 
        WHERE id = ?";
    
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

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = 'Record updated successfully';
        header('Location: list.php');
        exit;
    } else {
        $_SESSION['error'] = 'Error updating record: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Notebook Record</title>
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
        <div class="content">
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Edit Notebook Record</h3>
                <a href="list.php" class="btn btn-secondary">Back to List</a>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label class="form-label">Session</label>
                            <input type="text" name="session" value="<?= htmlspecialchars($record['session']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Evaluation Date</label>
                            <input type="date" name="eval_date" value="<?= htmlspecialchars($record['eval_date']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teacher</label>
                            <select name="teacher_id" class="form-control" required>
                                <option value="">-- Select Teacher --</option>
                                <?php foreach ($teachers as $teacher): ?>
                                    <option value="<?= htmlspecialchars($teacher['teacher_id']) ?>" 
                                        <?= $teacher['teacher_id'] == $record['teacher_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($teacher['teacher_name']) ?> (<?= htmlspecialchars($teacher['teacher_id']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" value="<?= htmlspecialchars($record['subject']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Class/Section</label>
                            <input type="text" name="class_section" value="<?= htmlspecialchars($record['class_section']) ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label class="form-label">Notebooks Checked</label>
                            <input type="number" name="notebooks_checked" value="<?= htmlspecialchars($record['notebooks_checked']) ?>" class="form-control" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Students Reviewed</label>
                            <textarea name="students_reviewed" class="form-control" required><?= htmlspecialchars($record['students_reviewed']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Evaluator Name</label>
                            <input type="text" name="evaluator_name" value="<?= htmlspecialchars($record['evaluator_name']) ?>" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label class="form-label">Regularity in Checking</label>
                            <select name="regularity_checking" class="form-control">
                                <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                    <option value="<?= htmlspecialchars($option) ?>" <?= $option == $record['regularity_checking'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($option) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Accuracy</label>
                            <select name="accuracy" class="form-control">
                                <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                    <option value="<?= htmlspecialchars($option) ?>" <?= $option == $record['accuracy'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($option) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label class="form-label">Neatness</label>
                            <select name="neatness" class="form-control">
                                <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                    <option value="<?= htmlspecialchars($option) ?>" <?= $option == $record['neatness'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($option) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Follow Up</label>
                            <select name="follow_up" class="form-control">
                                <option value="Done" <?= $record['follow_up'] == 'Done' ? 'selected' : '' ?>>Done</option>
                                <option value="Not Done" <?= $record['follow_up'] == 'Not Done' ? 'selected' : '' ?>>Not Done</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Overall Rating</label>
                            <select name="overall_rating" class="form-control">
                                <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                    <option value="<?= htmlspecialchars($option) ?>" <?= $option == $record['overall_rating'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($option) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="3"><?= htmlspecialchars($record['remarks']) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">Update Record</button>
                    <a href="list.php" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>