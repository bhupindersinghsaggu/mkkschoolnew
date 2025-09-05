<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

$message = '';
$submitted = false;

// Get record ID from URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: list_class_show.php?message=Invalid record ID");
    exit();
}

/* --------------------
   FETCH EXISTING RECORD
   -------------------- */
$select_sql = "SELECT * FROM class_show WHERE id = ?";
$select_stmt = mysqli_prepare($conn, $select_sql);
if (!$select_stmt) {
    die("Prepare failed (select): " . mysqli_error($conn));
}
mysqli_stmt_bind_param($select_stmt, "i", $id);
mysqli_stmt_execute($select_stmt);
$select_result = mysqli_stmt_get_result($select_stmt);
$record = mysqli_fetch_assoc($select_result);
mysqli_stmt_close($select_stmt); // close SELECT stmt

if (!$record) {
    header("Location: list_class_show.php?message=Record not found");
    exit();
}

/* --------------------
   PROCESS FORM SUBMISSION
   -------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize / fetch form data
    $session = trim($_POST['session']);
    $eval_date = trim($_POST['eval_date']);
    $topic = trim($_POST['topic']);
    $video_link = trim($_POST['video_link']);
    $teacher_name = trim($_POST['teacher_name']);
    $teacher_id = trim($_POST['teacher_id']);
    $evaluator_name = trim($_POST['evaluator_name']);
    $class_section = trim($_POST['class_section']);

    // numeric fields (forced to float)
    $prayer = isset($_POST['prayer']) ? (float)$_POST['prayer'] : 0;
    $news = isset($_POST['news']) ? (float)$_POST['news'] : 0;
    $participation = isset($_POST['participation']) ? (float)$_POST['participation'] : 0;
    $speeches = isset($_POST['speeches']) ? (float)$_POST['speeches'] : 0;
    $poem_recitation = isset($_POST['poem_recitation']) ? (float)$_POST['poem_recitation'] : 0;
    $dance = isset($_POST['dance']) ? (float)$_POST['dance'] : 0;
    $song = isset($_POST['song']) ? (float)$_POST['song'] : 0;
    $stage_management = isset($_POST['stage_management']) ? (float)$_POST['stage_management'] : 0;
    $innovation = isset($_POST['innovation']) ? (float)$_POST['innovation'] : 0;
    $skit = isset($_POST['skit']) ? (float)$_POST['skit'] : 0;
    $ppt = isset($_POST['ppt']) ? (float)$_POST['ppt'] : 0;
    $anchoring = isset($_POST['anchoring']) ? (float)$_POST['anchoring'] : 0;

    // Calculate total sum
    $total = $prayer + $news + $participation + $speeches + $poem_recitation +
        $dance + $song + $stage_management + $innovation +
        $skit + $ppt + $anchoring;

    // other string fields
    $speaking_skills = trim($_POST['speaking_skills'] ?? '');
    $dancing_skills = trim($_POST['dancing_skills'] ?? '');
    $singing_skills = trim($_POST['singing_skills'] ?? '');
    $dramatic_skills = trim($_POST['dramatic_skills'] ?? '');
    $comments1 = trim($_POST['comments1'] ?? '');
    $comments2 = trim($_POST['comments2'] ?? '');

    // marks (floats)
    $marks_judge1 = isset($_POST['marks_judge1']) ? (float)$_POST['marks_judge1'] : 0;
    $marks_judge2 = isset($_POST['marks_judge2']) ? (float)$_POST['marks_judge2'] : 0;

    // UPDATE query
    $update_sql = "UPDATE class_show SET 
        session = ?, eval_date = ?, topic = ?, video_link = ?, teacher_name = ?, teacher_id = ?, 
        evaluator_name = ?, class_section = ?, prayer = ?, news = ?, participation = ?, 
        speeches = ?, poem_recitation = ?, dance = ?, song = ?, stage_management = ?, 
        innovation = ?, skit = ?, ppt = ?, anchoring = ?, total = ?, 
        speaking_skills = ?, dancing_skills = ?, singing_skills = ?, dramatic_skills = ?, 
        comments1 = ?, comments2 = ?, marks_judge1 = ?, marks_judge2 = ?
        WHERE id = ?";

    $update_stmt = mysqli_prepare($conn, $update_sql);
    if (!$update_stmt) {
        $message = "❌ Prepare failed (update): " . mysqli_error($conn);
    } else {
        // Bind parameters
        $types = "ssssssss" // 8 strings: session, eval_date, topic, video_link, teacher_name, teacher_id, evaluator_name, class_section
               . "ddddddddddddd" // 13 doubles: prayer..anchoring (12) + total (1) => total 13 d
               . "ssssss" // 6 strings: speaking_skills, dancing_skills, singing_skills, dramatic_skills, comments1, comments2
               . "ddi";   // 2 doubles: marks_judge1, marks_judge2 + 1 integer id

        // Prepare the param list in the same order as SQL
        $bind = mysqli_stmt_bind_param(
            $update_stmt,
            $types,
            $session,
            $eval_date,
            $topic,
            $video_link,
            $teacher_name,
            $teacher_id,
            $evaluator_name,
            $class_section,
            $prayer,
            $news,
            $participation,
            $speeches,
            $poem_recitation,
            $dance,
            $song,
            $stage_management,
            $innovation,
            $skit,
            $ppt,
            $anchoring,
            $total,
            $speaking_skills,
            $dancing_skills,
            $singing_skills,
            $dramatic_skills,
            $comments1,
            $comments2,
            $marks_judge1,
            $marks_judge2,
            $id
        );

        if ($bind === false) {
            $message = "❌ Bind failed: " . mysqli_stmt_error($update_stmt);
        } else {
            if (mysqli_stmt_execute($update_stmt)) {
                $submitted = true;
                $message = "✅ Record updated successfully. Total: " . $total;

                // Refresh $record variable to reflect updated values
                $record = array_merge($record, [
                    'session' => $session,
                    'eval_date' => $eval_date,
                    'topic' => $topic,
                    'video_link' => $video_link,
                    'teacher_name' => $teacher_name,
                    'teacher_id' => $teacher_id,
                    'evaluator_name' => $evaluator_name,
                    'class_section' => $class_section,
                    'prayer' => $prayer,
                    'news' => $news,
                    'participation' => $participation,
                    'speeches' => $speeches,
                    'poem_recitation' => $poem_recitation,
                    'dance' => $dance,
                    'song' => $song,
                    'stage_management' => $stage_management,
                    'innovation' => $innovation,
                    'skit' => $skit,
                    'ppt' => $ppt,
                    'anchoring' => $anchoring,
                    'total' => $total,
                    'speaking_skills' => $speaking_skills,
                    'dancing_skills' => $dancing_skills,
                    'singing_skills' => $singing_skills,
                    'dramatic_skills' => $dramatic_skills,
                    'comments1' => $comments1,
                    'comments2' => $comments2,
                    'marks_judge1' => $marks_judge1,
                    'marks_judge2' => $marks_judge2
                ]);
            } else {
                $message = "❌ Execution error: " . mysqli_stmt_error($update_stmt);
            }
        }

        // Close the update statement
        if (isset($update_stmt) && $update_stmt instanceof mysqli_stmt) {
            mysqli_stmt_close($update_stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Class Show Record</title>
    <!-- your CSS and JS links (kept as in original) -->
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- (other CSS omitted here for brevity) -->
    <script>
        /* Keep your JS exactly as before — unchanged */
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

            if (selectedOption && selectedOption.value !== "") {
                document.getElementById('teacherName').value = selectedOption.getAttribute('data-name') || '';
                document.getElementById('teacherId').value = selectedOption.value || '';
                document.getElementById('subject').value = selectedOption.getAttribute('data-subject') || '';
                document.getElementById('teacherType').value = selectedOption.getAttribute('data-type') || '';
            } else {
                document.getElementById('teacherName').value = "";
                document.getElementById('teacherId').value = "";
                document.getElementById('subject').value = "";
                document.getElementById('teacherType').value = "";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editClassShowForm');
            // selector adjusted to match your form structure
            const scoreInputs = document.querySelectorAll('input[type="number"][name]:not([name="total"]):not([name="marks_judge1"]):not([name="marks_judge2"])');
            const totalField = document.getElementById('totalField');

            function calculateTotal() {
                let total = 0;
                scoreInputs.forEach(input => {
                    if (input.value && !isNaN(parseFloat(input.value))) {
                        total += parseFloat(input.value);
                    }
                });
                totalField.value = total.toFixed(2);
            }

            scoreInputs.forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

            // Initial calculation and teacher details
            calculateTotal();
            fillTeacherDetails();
        });
    </script>
</head>

<body>
    <div class="page-wrapper">
        <div class="content mb-3">
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3>Edit Class Show Record</h3>
                <div class="d-flex gap-2">
                    <a href="list_class_show.php" class="btn btn-secondary">Back</a>
                    <a href="view_class_show.php?id=<?= $id ?>" class="btn btn-success">View</a>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>

            <!-- Note: Add id="editClassShowForm" to match JS selectors -->
            <form method="POST" id="editClassShowForm">
                <input type="hidden" name="id" value="<?= $id ?>">

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <!-- same form fields as in your original file, using $record values -->
                                <!-- Session -->
                                <div class="mb-3">
                                    <label>Session</label>
                                    <select name="session" class="form-control" required>
                                        <option value="2025-26" <?= $record['session'] == '2025-26' ? 'selected' : '' ?>>2025-26</option>
                                        <option value="2026-27" <?= $record['session'] == '2026-27' ? 'selected' : '' ?>>2026-27</option>
                                    </select>
                                </div>

                                <!-- Date -->
                                <div class="mb-3">
                                    <label>Date of class show</label>
                                    <input type="date" name="eval_date" class="form-control" value="<?= htmlspecialchars($record['eval_date']) ?>" required>
                                </div>

                                <!-- Search / select teacher -->
                                <div class="mb-3">
                                    <label>Search Teacher</label>
                                    <input type="text" id="teacherSearch" class="form-control mb-2" placeholder="Type to filter..." onkeyup="filterTeachers()">

                                    <label>Select Teacher</label>
                                    <select name="teacher_id" id="teacherSelect" class="form-control" onchange="fillTeacherDetails()" required>
                                        <option value="">-- Select Teacher --</option>
                                        <?php
                                        $teacher_query = "SELECT td.teacher_id, td.teacher_name, td.subject, td.teacher_type 
                                                          FROM teacher_details td
                                                          JOIN users u ON td.user_id = u.id
                                                          ORDER BY td.teacher_name ASC";
                                        $teacher_result = mysqli_query($conn, $teacher_query);

                                        if ($teacher_result && mysqli_num_rows($teacher_result) > 0) {
                                            while ($teacher = mysqli_fetch_assoc($teacher_result)) {
                                                $selected = $teacher['teacher_id'] == $record['teacher_id'] ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($teacher['teacher_id']) . "' 
                                                      data-name='" . htmlspecialchars($teacher['teacher_name']) . "' 
                                                      data-subject='" . htmlspecialchars($teacher['subject']) . "'
                                                      data-type='" . htmlspecialchars($teacher['teacher_type']) . "'
                                                      $selected>
                                                      " . htmlspecialchars($teacher['teacher_name']) . " (" . htmlspecialchars($teacher['teacher_id']) . ")
                                                      </option>";
                                            }
                                        } else {
                                            echo "<option value=''>No teachers found</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Teacher name / id etc -->
                                <div class="mb-3">
                                    <label>Name of the Teacher</label>
                                    <input type="text" name="teacher_name" id="teacherName" class="form-control" value="<?= htmlspecialchars($record['teacher_name']) ?>" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Teacher ID</label>
                                    <input type="text" name="teacher_id_display" id="teacherId" class="form-control" value="<?= htmlspecialchars($record['teacher_id']) ?>" readonly required>
                                    <!-- ensure the actual teacher_id is in the select name="teacher_id" -->
                                </div>

                                <div class="mb-3">
                                    <label>Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control" value="<?= htmlspecialchars($record['subject'] ?? '') ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label>Teacher Type</label>
                                    <input type="text" name="teacher_type" id="teacherType" class="form-control" value="<?= htmlspecialchars($record['teacher_type'] ?? '') ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label>Class/Section</label>
                                    <input type="text" name="class_section" class="form-control" value="<?= htmlspecialchars($record['class_section']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label>Name of the Judge</label>
                                    <input type="text" name="evaluator_name" class="form-control" value="<?= htmlspecialchars($record['evaluator_name']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label>Topic</label>
                                    <input type="text" name="topic" class="form-control" value="<?= htmlspecialchars($record['topic']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label>Video Link</label>
                                    <input type="text" name="video_link" class="form-control" value="<?= htmlspecialchars($record['video_link']) ?>">
                                </div>

                                <!-- Score inputs (kept as before) -->
                                <div class="mb-3"><label>Prayer</label><input type="number" name="prayer" class="form-control" step="0.01" value="<?= $record['prayer'] ?>" min="0" max="10" required></div>
                                <div class="mb-3"><label>News</label><input type="number" name="news" class="form-control" step="0.01" value="<?= $record['news'] ?>" min="0" max="10" required></div>
                                <div class="mb-3"><label>Participation</label><input type="number" name="participation" class="form-control" step="0.01" value="<?= $record['participation'] ?>" min="0" max="10" required></div>
                                <div class="mb-3"><label>Speeches</label><input type="number" name="speeches" class="form-control" step="0.01" value="<?= $record['speeches'] ?>" min="0" max="15" required></div>
                                <div class="mb-3"><label>Poem recitation</label><input type="number" name="poem_recitation" class="form-control" step="0.01" value="<?= $record['poem_recitation'] ?>" min="0" max="10" required></div>
                                <div class="mb-3"><label>Dance</label><input type="number" name="dance" class="form-control" step="0.01" value="<?= $record['dance'] ?>" min="0" max="10" required></div>
                                <div class="mb-3"><label>Song</label><input type="number" name="song" class="form-control" step="0.01" value="<?= $record['song'] ?>" min="0" max="10" required></div>
                                <div class="mb-3"><label>Stage Management</label><input type="number" name="stage_management" class="form-control" step="0.01" value="<?= $record['stage_management'] ?>" min="0" max="10" required></div>
                                <div class="mb-3"><label>Innovation</label><input type="number" name="innovation" class="form-control" step="0.01" value="<?= $record['innovation'] ?>" min="0" max="10" required></div>
                                <div class="mb-3"><label>Skit</label><input type="number" name="skit" class="form-control" step="0.01" value="<?= $record['skit'] ?>" min="0" max="10" required></div>
                                <div class="mb-3"><label>PPT</label><input type="number" name="ppt" class="form-control" step="0.01" value="<?= $record['ppt'] ?>" min="0" max="10" required></div>
                                <div class="mb-3"><label>Anchoring</label><input type="number" name="anchoring" class="form-control" step="0.01" value="<?= $record['anchoring'] ?>" min="0" max="10" required></div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Total (Auto-calculated)</label>
                                    <input type="number" name="total" id="totalField" class="form-control" value="<?= $record['total'] ?>" readonly required>
                                    <small class="text-muted">This field is automatically calculated</small>
                                </div>

                                <div class="mb-3"><label>Speaking Skills</label><input type="text" name="speaking_skills" class="form-control" value="<?= $record['speaking_skills'] ?>"></div>
                                <div class="mb-3"><label>Dancing Skills</label><input type="text" name="dancing_skills" class="form-control" value="<?= $record['dancing_skills'] ?>"></div>
                                <div class="mb-3"><label>Singing Skills</label><input type="text" name="singing_skills" class="form-control" value="<?= $record['singing_skills'] ?>"></div>
                                <div class="mb-3"><label>Dramatic Skills</label><input type="text" name="dramatic_skills" class="form-control" value="<?= $record['dramatic_skills'] ?>"></div>

                                <div class="mb-3"><label>Comments/Remarks By Judge1</label><textarea name="comments1" class="form-control" rows="4"><?= htmlspecialchars($record['comments1']) ?></textarea></div>
                                <div class="mb-3"><label>Comments/Remarks By Judge2</label><textarea name="comments2" class="form-control" rows="4"><?= htmlspecialchars($record['comments2']) ?></textarea></div>

                                <div class="mb-3"><label>Marks By Judge1</label><input type="number" name="marks_judge1" class="form-control" step="0.01" value="<?= $record['marks_judge1'] ?>" min="0" max="50"></div>
                                <div class="mb-3"><label>Marks By Judge2</label><input type="number" name="marks_judge2" class="form-control" step="0.01" value="<?= $record['marks_judge2'] ?>" min="0" max="50"></div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">Update </button>
                                    <a href="./dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                                </div>
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
