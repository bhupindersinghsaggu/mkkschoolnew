<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../header.php';
include '../head-nav.php';
include '../side-bar.php';
include '../config/db.php';

$submitted = false;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session = $_POST['session'];
    $eval_date = $_POST['eval_date'];
    $teacher_name = $_POST['teacher_name'];
    $teacher_id = $_POST['teacher_id'];
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

    $sql = "INSERT INTO records (session, eval_date, teacher_name, teacher_id, subject, class_section,
    notebooks_checked, students_reviewed, regularity_checking, accuracy, neatness,
    follow_up, overall_rating, evaluator_name, remarks, undertaking)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssissssssssi",
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
            $undertaking
        );
        if (mysqli_stmt_execute($stmt)) {
            $submitted = true;
            $message = "✅ Record successfully submitted.";
        } else {
            $message = "❌ Execution error: " . mysqli_stmt_error($stmt);
        }
    } else {
        $message = "❌ Prepare failed: " . mysqli_error($conn);
    }
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
        <div class="content mb-3">
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3 class="">Notebook Corrections</h3>
                <a href="list.php" class="btn btn-secondary">View Record</a></h3>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Session</label>
                                    <select name="session" class="form-control" required>
                                        <option value="2025-26">2025-26</option>
                                        <option value="2026-27">2026-27</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Date of Evaluation</label>
                                    <input type="date" name="eval_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Search Teacher</label>
                                    <input type="text" id="teacherSearch" class="form-control mb-2" placeholder="Type to filter..." onkeyup="filterTeachers()">

                                    <label>Select Teacher</label>
                                    <select name="teacher_id" id="teacherSelect" class="form-control" onchange="fillTeacherName()" required>
                                        <option value="">-- Select Teacher --</option>
                                        <?php
                                        $teacher_result = mysqli_query($conn, "SELECT teacher_id, teacher_name FROM teachers ORDER BY teacher_name ASC");
                                        while ($teacher = mysqli_fetch_assoc($teacher_result)) {
                                            echo "<option value='{$teacher['teacher_id']}' data-name='{$teacher['teacher_name']}'>{$teacher['teacher_name']} ({$teacher['teacher_id']})</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Name of the Teacher</label>
                                    <input type="text" name="teacher_name" id="teacherName" class="form-control" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Subject</label>
                                    <input type="text" name="subject" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Class/Section</label>
                                    <input type="text" name="class_section" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Number of Notebooks Checked</label>
                                    <input type="number" name="notebooks_checked" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Names of Students Reviewed</label>
                                    <textarea name="students_reviewed" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Regularity in Checking</label>
                                    <select name="regularity_checking" class="form-control" required>
                                        <option>Excellent</option>
                                        <option>Good</option>
                                        <option>Satisfactory</option>
                                        <option>Needs Improvement</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Accuracy</label>
                                    <select name="accuracy" class="form-control" required>
                                        <option>Excellent</option>
                                        <option>Good</option>
                                        <option>Satisfactory</option>
                                        <option>Needs Improvement</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Neatness</label>
                                    <select name="neatness" class="form-control" required>
                                        <option>Excellent</option>
                                        <option>Good</option>
                                        <option>Satisfactory</option>
                                        <option>Needs Improvement</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Follow-up of Corrections</label>
                                    <select name="follow_up" class="form-control" required>
                                        <option>Done</option>
                                        <option>Not Done</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Overall Rating</label>
                                    <select name="overall_rating" class="form-control" required>
                                        <option>Excellent</option>
                                        <option>Good</option>
                                        <option>Satisfactory</option>
                                        <option>Needs Improvement</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Evaluator’s Name & Designation</label>
                                    <select name="evaluator_name" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="Meera Marwaha">Meera Marwaha</option>
                                        <option value="Manju Setia">Manju Setia</option>
                                        <option value="Madhup Prashar">Madhup Prashar</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Remarks</label>
                                    <textarea name="remarks" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="add.php" class="btn btn-secondary">Add</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include '../footer.php'; ?>
</body>

</html>