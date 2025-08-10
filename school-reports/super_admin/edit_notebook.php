<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

// Validate ID parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid Record ID";
    header('Location: notebook_list.php');
    exit;
}

$id = (int)$_GET['id'];

// Fetch record data
$query = $conn->prepare("
    SELECT r.*, td.profile_pic 
    FROM records r
    LEFT JOIN teacher_details td ON r.teacher_id = td.teacher_id
    WHERE r.id = ?
");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$record = $result->fetch_assoc();

if (!$record) {
    $_SESSION['error'] = "Record not found";
    header('Location: notebook_list.php');
    exit;
}

// Fetch teachers for dropdown
$teachers_query = $conn->query("SELECT teacher_id, teacher_name FROM teacher_details ORDER BY teacher_name ASC");
$teachers = $teachers_query->fetch_all(MYSQLI_ASSOC);

// Fetch evaluators (assuming they are also from teacher_details or a separate table)
$evaluators_query = $conn->query("SELECT DISTINCT evaluator_name FROM records WHERE evaluator_name IS NOT NULL ORDER BY evaluator_name ASC");
$evaluators = $evaluators_query->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // [Previous sanitization code remains the same...]
    
    // Update record
    $update_query = $conn->prepare("
        UPDATE records SET 
            session = ?,
            eval_date = ?,
            teacher_id = ?,
            teacher_name = ?,
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
            remarks = ?
        WHERE id = ?
    ");
    
    $update_query->bind_param(
        "ssssssisssssssi",
        $session,
        $eval_date,
        $teacher_id,
        $teacher_name,
        $subject,
        $class_section,
        $notebooks_checked,
        $students_reviewed,
        $regularity_checking,
        $accuracy,
        $neatness,
        $follow_up,
        $overall_rating,
        $_POST['evaluator_name'], // Changed to use select value
        $remarks,
        $id
    );

    if ($update_query->execute()) {
        $_SESSION['success'] = "Record updated successfully";
        header('Location: notebook_list.php');
        exit;
    } else {
        $_SESSION['error'] = "Error updating record: " . $conn->error;
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
    <style>
        .teacher-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
        
        .form-section {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <div class="content">
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Edit Notebook Record</h3>
                <a href="notebook_list.php" class="btn btn-secondary">Back to List</a>
            </div>

            <!-- Display success/error messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-section">
                            <h5 class="mb-4">Basic Information</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Session</label>
                                <input type="text" name="session" class="form-control" 
                                    value="<?= htmlspecialchars($record['session']) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Evaluation Date</label>
                                <input type="date" name="eval_date" class="form-control" 
                                    value="<?= htmlspecialchars($record['eval_date']) ?>" required>
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
                                <input type="text" name="subject" class="form-control" 
                                    value="<?= htmlspecialchars($record['subject']) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Class/Section</label>
                                <input type="text" name="class_section" class="form-control" 
                                    value="<?= htmlspecialchars($record['class_section']) ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-section">
                            <h5 class="mb-4">Evaluation Details</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Number of Notebooks Checked</label>
                                <input type="number" name="notebooks_checked" class="form-control" 
                                    value="<?= htmlspecialchars($record['notebooks_checked']) ?>" min="1" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Students Reviewed</label>
                                <textarea name="students_reviewed" class="form-control" 
                                    required><?= htmlspecialchars($record['students_reviewed']) ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Evaluator Name</label>
                                <input type="text" name="evaluator_name" class="form-control" 
                                    value="<?= htmlspecialchars($record['evaluator_name']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h5 class="mb-4">Evaluation Ratings</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Regularity in Checking</label>
                                <select name="regularity_checking" class="form-control">
                                    <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                        <option value="<?= htmlspecialchars($option) ?>"
                                            <?= $option == $record['regularity_checking'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($option) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Accuracy</label>
                                <select name="accuracy" class="form-control">
                                    <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                        <option value="<?= htmlspecialchars($option) ?>"
                                            <?= $option == $record['accuracy'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($option) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Neatness</label>
                                <select name="neatness" class="form-control">
                                    <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                        <option value="<?= htmlspecialchars($option) ?>"
                                            <?= $option == $record['neatness'] ? 'selected' : '' ?>>
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
                            
                            <div class="mb-3">
                                <label class="form-label">Overall Rating</label>
                                <select name="overall_rating" class="form-control">
                                    <?php foreach (['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'] as $option): ?>
                                        <option value="<?= htmlspecialchars($option) ?>"
                                            <?= $option == $record['overall_rating'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($option) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h5 class="mb-4">Additional Information</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="3"><?= htmlspecialchars($record['remarks']) ?></textarea>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary px-4">Update Record</button>
                    <a href="notebook_list.php" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>