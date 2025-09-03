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
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: list_class_show.php?message=Invalid record ID");
    exit();
}

// Fetch existing record data
$query = "SELECT * FROM class_show WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$record = mysqli_fetch_assoc($result);

if (!$record) {
    header("Location: list_class_show.php?message=Record not found");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $session = $_POST['session'];
    $eval_date = $_POST['eval_date'];
    $topic = $_POST['topic'];
    $video_link = $_POST['video_link'];
    $teacher_name = $_POST['teacher_name'];
    $teacher_id = $_POST['teacher_id'];
    $evaluator_name = $_POST['evaluator_name'];
    $class_section = $_POST['class_section'];

    // Convert to floats for decimal values
    $prayer = (float)$_POST['prayer'];
    $news = (float)$_POST['news'];
    $participation = (float)$_POST['participation'];
    $speeches = (float)$_POST['speeches'];
    $poem_recitation = (float)$_POST['poem_recitation'];
    $dance = (float)$_POST['dance'];
    $song = (float)$_POST['song'];
    $stage_management = (float)$_POST['stage_management'];
    $innovation = (float)$_POST['innovation'];
    $skit = (float)$_POST['skit'];
    $ppt = (float)$_POST['ppt'];
    $anchoring = (float)$_POST['anchoring'];

    // Calculate total sum
    $total = $prayer + $news + $participation + $speeches + $poem_recitation +
        $dance + $song + $stage_management + $innovation +
        $skit + $ppt + $anchoring;

    $speaking_skills = $_POST['speaking_skills'];
    $dancing_skills = $_POST['dancing_skills'];
    $singing_skills = $_POST['singing_skills'];
    $dramatic_skills = $_POST['dramatic_skills'];
    $comments1 = $_POST['comments1'];
    $comments2 = $_POST['comments2'];
    $marks_judge1 = (float)$_POST['marks_judge1'];
    $marks_judge2 = (float)$_POST['marks_judge2'];

    // Update query
    $sql = "UPDATE class_show SET 
        session = ?, eval_date = ?, topic = ?, video_link = ?,  teacher_name = ?, teacher_id = ?, 
        evaluator_name = ?, class_section = ?, prayer = ?, news = ?, participation = ?, 
        speeches = ?, poem_recitation = ?, dance = ?, song = ?, stage_management = ?, 
        innovation = ?, skit = ?, ppt = ?, anchoring = ?, total = ?, 
        speaking_skills = ?, dancing_skills = ?, singing_skills = ?, dramatic_skills = ?, 
        comments1 = ?, comments2 = ?, marks_judge1 =?, marks_judge2 = ?
        WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    
if ($stmt) {
    // Correct format string: 8 strings + 13 decimals + 6 strings + 2 decimals + 1 integer = 30 characters
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssdddddddddddddssssssddi", // 30 characters: 8s + 13d + 6s + 2d + 1i
        $session,           // s (1)
        $eval_date,         // s (2)
        $topic,             // s (3)
        $video_link,        // s (4)
        $teacher_name,      // s (5)
        $teacher_id,        // s (6)
        $evaluator_name,    // s (7)
        $class_section,     // s (8)
        $prayer,            // d (9)
        $news,              // d (10)
        $participation,     // d (11)
        $speeches,          // d (12)
        $poem_recitation,   // d (13)
        $dance,             // d (14)
        $song,              // d (15)
        $stage_management,  // d (16)
        $innovation,        // d (17)
        $skit,              // d (18)
        $ppt,               // d (19)
        $anchoring,         // d (20)
        $total,             // d (21) - 13th decimal
        $speaking_skills,   // s (22)
        $dancing_skills,    // s (23)
        $singing_skills,    // s (24)
        $dramatic_skills,   // s (25)
        $comments1,         // s (26)
        $comments2,         // s (27) - 6th string
        $marks_judge1,      // d (28)
        $marks_judge2,      // d (29) - 15th decimal
        $id                 // i (30)
    );
        if (mysqli_stmt_execute($stmt)) {
            $submitted = true;
            $message = "✅ Record updated successfully. Total: " . $total;
            // Refresh the record data with correct array keys
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
                'marks_judge1' => $marks_judge1, // Fixed array key
                'marks_judge2' => $marks_judge2  // Fixed array key
            ]);
        } else {
            $message = "❌ Execution error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "❌ Prepare failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Class Show Record</title>
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

        // Auto-calculate total when any score field changes
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editClassShowForm');
            const scoreInputs = form.querySelectorAll('input[type="number"][name]:not([name="total"]):not([name="marks_judge1"]):not([name="marks_judge2"])');
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
            
            // Initial calculation
            calculateTotal();
            
            // Initialize teacher details on page load
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

            <form method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Session</label>
                                    <select name="session" class="form-control" required>
                                        <option value="2025-26" <?= $record['session'] == '2025-26' ? 'selected' : '' ?>>2025-26</option>
                                        <option value="2026-27" <?= $record['session'] == '2026-27' ? 'selected' : '' ?>>2026-27</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Date of class show</label>
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
                                    <input type="text" name="subject" id="subject" class="form-control" readonly>
                                </div>

                                <div class="mb-3">
                                    <label>Teacher Type</label>
                                    <input type="text" name="teacher_type" id="teacherType" class="form-control" readonly>
                                </div>

                                <div class="mb-3">
                                    <label>Class/Section</label>
                                    <input type="text" name="class_section" class="form-control" value="<?= htmlspecialchars($record['class_section']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Name of the Judge</label>
                                    <input type="text" name="evaluator_name" class="form-control" value="<?= htmlspecialchars($record['evaluator_name']) ?>" required>
                                </div>
                                <!-- <div class="mb-3">
                                    <label>Evaluator's Name & Designation</label>
                                    <select name="evaluator_name" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="Meera Marwaha" <?= $record['evaluator_name'] == 'Meera Marwaha' ? 'selected' : '' ?>>Meera Marwaha</option>
                                        <option value="Manju Setia" <?= $record['evaluator_name'] == 'Manju Setia' ? 'selected' : '' ?>>Manju Setia</option>
                                        <option value="Madhup Prashar" <?= $record['evaluator_name'] == 'Madhup Prashar' ? 'selected' : '' ?>>Madhup Prashar</option>
                                        <option value="Other" <?= $record['evaluator_name'] == 'Other' ? 'selected' : '' ?>>Other</option>
                                    </select>
                                </div> -->
                                <div class="mb-3">
                                    <label>Topic</label>
                                    <input type="text" name="topic" class="form-control" value="<?= htmlspecialchars($record['topic']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Video Link</label>
                                    <input type="text" name="video_link" class="form-control" value="<?= htmlspecialchars($record['video_link']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Prayer</label>
                                    <input type="number" name="prayer" class="form-control" step="0.01" value="<?= $record['prayer'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>News</label>
                                    <input type="number" name="news" class="form-control" step="0.01" value="<?= $record['news'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Participation</label>
                                    <input type="number" name="participation" class="form-control" step="0.01" value="<?= $record['participation'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Speeches</label>
                                    <input type="number" name="speeches" class="form-control" step="0.01" value="<?= $record['speeches'] ?>" min="0" max="15" required>
                                </div>
                                <div class="mb-3">
                                    <label>Poem recitation</label>
                                    <input type="number" name="poem_recitation" class="form-control" step="0.01" value="<?= $record['poem_recitation'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Dance</label>
                                    <input type="number" name="dance" class="form-control" step="0.01" value="<?= $record['dance'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Song</label>
                                    <input type="number" name="song" class="form-control" step="0.01" value="<?= $record['song'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Stage Management</label>
                                    <input type="number" name="stage_management" class="form-control" step="0.01" value="<?= $record['stage_management'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Innovation</label>
                                    <input type="number" name="innovation" class="form-control" step="0.01" value="<?= $record['innovation'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Skit</label>
                                    <input type="number" name="skit" class="form-control" step="0.01" value="<?= $record['skit'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>PPT</label>
                                    <input type="number" name="ppt" class="form-control" step="0.01" value="<?= $record['ppt'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Anchoring</label>
                                    <input type="number" name="anchoring" class="form-control" step="0.01" value="<?= $record['anchoring'] ?>" min="0" max="10" required>
                                </div>
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
                                <div class="mb-3">
                                    <label>Speaking Skills</label>
                                    <input type="text" name="speaking_skills" class="form-control" value="<?= $record['speaking_skills'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Dancing Skills</label>
                                    <input type="text" name="dancing_skills" class="form-control" value="<?= $record['dancing_skills'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Singing Skills</label>
                                    <input type="text" name="singing_skills" class="form-control" value="<?= $record['singing_skills'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Dramatic Skills</label>
                                    <input type="text" name="dramatic_skills" class="form-control" value="<?= $record['dramatic_skills'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Comments/Remarks By Judge1</label>
                                    <textarea name="comments1" class="form-control" rows="4" required><?= htmlspecialchars($record['comments1']) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Comments/Remarks By Judge2</label>
                                    <textarea name="comments2" class="form-control" rows="4" required><?= htmlspecialchars($record['comments2']) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Marks By Judge1</label>
                                    <input type="number" name="marks_judge1" class="form-control" step="0.01" value="<?= $record['marks_judge1'] ?>" min="0" max="40">
                                </div>
                                <div class="mb-3">
                                    <label>Marks By Judge2</label>
                                    <input type="number" name="marks_judge2" class="form-control" step="0.01" value="<?= $record['marks_judge2'] ?>" min="0" max="40">
                                </div>
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

    <script>
        // Initialize teacher details on page load
        document.addEventListener('DOMContentLoaded', function() {
            fillTeacherDetails();
        });
    </script>
</body>

</html>

<?php
// Close statement if it exists
if (isset($stmt)) {
    mysqli_stmt_close($stmt);
}
?>