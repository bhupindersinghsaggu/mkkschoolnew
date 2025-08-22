<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

$message = '';
$record_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch existing record data
$record = null;
if ($record_id > 0) {
    $query = "SELECT * FROM records WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $record_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $record = mysqli_fetch_assoc($result);
}

if (!$record) {
    header("Location: list_notebook.php");
    exit();
}

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

    $sql = "UPDATE records SET 
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

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
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
            $record_id
        );
        if (mysqli_stmt_execute($stmt)) {
            $message = "✅ Record successfully updated.";
            // Refresh the record data
            $query = "SELECT * FROM records WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $record_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $record = mysqli_fetch_assoc($result);
        } else {
            $message = "❌ Update error: " . mysqli_stmt_error($stmt);
        }
    } else {
        $message = "❌ Prepare failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Notebook Review</title>
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
    <script>
    function filterTeachers() {
        const input = document.getElementById('teacherSearch');
        const filter = input.value.toUpperCase();
        const select = document.getElementById('teacherSelect');
        const options = select.getElementsByTagName('option');
        
        for (let i = 0; i < options.length; i++) {
            const text = options[i].textContent || options[i].innerText;
            if (text.toUpperCase().indexOf(filter) > -1) {
                options[i].style.display = "";
            } else {
                options[i].style.display = "none";
            }
        }
    }

    function fillTeacherDetails() {
        const select = document.getElementById('teacherSelect');
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption.value !== "") {
            document.getElementById('teacherName').value = selectedOption.getAttribute('data-name');
            document.getElementById('teacherId').value = selectedOption.value;
            document.getElementById('subject').value = selectedOption.getAttribute('data-subject');
            document.getElementById('teacherType').value = selectedOption.getAttribute('data-type');
        } else {
            document.getElementById('teacherName').value = "";
            document.getElementById('teacherId').value = "";
            document.getElementById('subject').value = "";
            document.getElementById('teacherType').value = "";
        }
    }

    // Function to select the current teacher in the dropdown
    window.onload = function() {
        const teacherId = "<?php echo htmlspecialchars($record['teacher_id']); ?>";
        if (teacherId) {
            const select = document.getElementById('teacherSelect');
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].value === teacherId) {
                    select.selectedIndex = i;
                    // Trigger the change event to fill other fields
                    const event = new Event('change');
                    select.dispatchEvent(event);
                    break;
                }
            }
        }
    };
    </script>
</head>
<body>
    <div class="page-wrapper">
        <div class="content mb-3">
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3 class="">Edit Notebook Corrections</h3>
                <a href="list_notebook.php" class="btn btn-success">View All</a></h3>
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
                                        <option value="2025-26" <?= $record['session'] === '2025-26' ? 'selected' : '' ?>>2025-26</option>
                                        <option value="2026-27" <?= $record['session'] === '2026-27' ? 'selected' : '' ?>>2026-27</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Date of Evaluation</label>
                                    <input type="date" name="eval_date" class="form-control" value="<?= htmlspecialchars($record['eval_date']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Search Teacher</label>
                                    <input type="text" id="teacherSearch" class="form-control mb-2" placeholder="Type to filter..." onkeyup="filterTeachers()">

                                    <label>Select Teacher</label>
                                    <select name="teacher_id" id="teacherSelect" class="form-control" onchange="fillTeacherDetails()" required>
                                        <option value="">-- Select Teacher --</option>
                                        <?php
                                        $query = "SELECT td.teacher_id, td.teacher_name, td.subject, td.teacher_type 
                                                  FROM teacher_details td
                                                  JOIN users u ON td.user_id = u.id
                                                  ORDER BY td.teacher_name ASC";
                                        $result = mysqli_query($conn, $query);
                                        
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($teacher = mysqli_fetch_assoc($result)) {
                                                echo "<option value='".htmlspecialchars($teacher['teacher_id'])."' 
                                                      data-name='".htmlspecialchars($teacher['teacher_name'])."' 
                                                      data-subject='".htmlspecialchars($teacher['subject'])."'
                                                      data-type='".htmlspecialchars($teacher['teacher_type'])."'
                                                      ".($teacher['teacher_id'] === $record['teacher_id'] ? 'selected' : '').">
                                                      ".htmlspecialchars($teacher['teacher_name'])." (".htmlspecialchars($teacher['teacher_id']).")
                                                      </option>";
                                            }
                                        } else {
                                            echo "<option value=''>No teachers found</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Name of the Teacher</label>
                                    <input type="text" name="teacher_name" id="teacherName" class="form-control" value="<?= htmlspecialchars($record['teacher_name']) ?>" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Teacher ID</label>
                                    <input type="text" name="teacher_id" id="teacherId" class="form-control" value="<?= htmlspecialchars($record['teacher_id']) ?>" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control" value="<?= htmlspecialchars($record['subject']) ?>" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Teacher Type</label>
                                    <input type="text" name="teacher_type" id="teacherType" class="form-control" value="<?= htmlspecialchars($record['teacher_type'] ?? '') ?>" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Class/Section</label>
                                    <input type="text" name="class_section" class="form-control" value="<?= htmlspecialchars($record['class_section']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Number of Notebooks Checked</label>
                                    <input type="number" name="notebooks_checked" class="form-control" value="<?= htmlspecialchars($record['notebooks_checked']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Names of Students Reviewed</label>
                                    <textarea name="students_reviewed" class="form-control" required><?= htmlspecialchars($record['students_reviewed']) ?></textarea>
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
                                        <option <?= $record['regularity_checking'] === 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                        <option <?= $record['regularity_checking'] === 'Good' ? 'selected' : '' ?>>Good</option>
                                        <option <?= $record['regularity_checking'] === 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                        <option <?= $record['regularity_checking'] === 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Accuracy</label>
                                    <select name="accuracy" class="form-control" required>
                                        <option <?= $record['accuracy'] === 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                        <option <?= $record['accuracy'] === 'Good' ? 'selected' : '' ?>>Good</option>
                                        <option <?= $record['accuracy'] === 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                        <option <?= $record['accuracy'] === 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Neatness</label>
                                    <select name="neatness" class="form-control" required>
                                        <option <?= $record['neatness'] === 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                        <option <?= $record['neatness'] === 'Good' ? 'selected' : '' ?>>Good</option>
                                        <option <?= $record['neatness'] === 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                        <option <?= $record['neatness'] === 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Follow-up of Corrections</label>
                                    <select name="follow_up" class="form-control" required>
                                        <option <?= $record['follow_up'] === 'Done' ? 'selected' : '' ?>>Done</option>
                                        <option <?= $record['follow_up'] === 'Not Done' ? 'selected' : '' ?>>Not Done</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Overall Rating</label>
                                    <select name="overall_rating" class="form-control" required>
                                        <option <?= $record['overall_rating'] === 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                        <option <?= $record['overall_rating'] === 'Good' ? 'selected' : '' ?>>Good</option>
                                        <option <?= $record['overall_rating'] === 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                        <option <?= $record['overall_rating'] === 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Evaluator's Name & Designation</label>
                                    <select name="evaluator_name" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="Meera Marwaha" <?= $record['evaluator_name'] === 'Meera Marwaha' ? 'selected' : '' ?>>Meera Marwaha</option>
                                        <option value="Manju Setia" <?= $record['evaluator_name'] === 'Manju Setia' ? 'selected' : '' ?>>Manju Setia</option>
                                        <option value="Madhup Prashar" <?= $record['evaluator_name'] === 'Madhup Prashar' ? 'selected' : '' ?>>Madhup Prashar</option>
                                        <option value="Other" <?= $record['evaluator_name'] === 'Other' ? 'selected' : '' ?>>Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Remarks</label>
                                    <textarea name="remarks" class="form-control"><?= htmlspecialchars($record['remarks']) ?></textarea>
                                </div>
                                <!-- <div class="mb-3 form-check">
                                    <input type="checkbox" name="undertaking" class="form-check-input" id="undertaking" <?= $record['undertaking'] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="undertaking">Undertaking</label>
                                </div> -->
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="./list_notebook.php" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>