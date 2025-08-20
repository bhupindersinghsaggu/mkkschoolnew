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
    $teacher_name = $_POST['teacher_name'];
    $teacher_id = $_POST['teacher_id'];
    $evaluator_name = $_POST['evaluator_name'];
    $class_section = $_POST['class_section'];
    
    // Convert to integers
    $prayer = (int)$_POST['prayer'];
    $news = (int)$_POST['news'];
    $participation = (int)$_POST['participation'];
    $speeches = (int)$_POST['speeches'];
    $poem_recitation = (int)$_POST['poem_recitation'];
    $dance = (int)$_POST['dance'];
    $song = (int)$_POST['song'];
    $stage_management = (int)$_POST['stage_management'];
    $innovation = (int)$_POST['innovation'];
    $skit = (int)$_POST['skit'];
    $ppt = (int)$_POST['ppt'];
    $anchoring = (int)$_POST['anchoring'];
    
    // Calculate total sum
    $total = $prayer + $news + $participation + $speeches + $poem_recitation + 
             $dance + $song + $stage_management + $innovation + 
             $skit + $ppt + $anchoring;
    
    $speaking_skills = (int)$_POST['speaking_skills'];
    $dancing_skills = (int)$_POST['dancing_skills'];
    $singing_skills = (int)$_POST['singing_skills'];
    $dramatic_skills = (int)$_POST['dramatic_skills'];
    $comments = $_POST['comments'];

    // Update query
    $sql = "UPDATE class_show SET 
        session = ?, eval_date = ?, topic = ?, teacher_name = ?, teacher_id = ?, 
        evaluator_name = ?, class_section = ?, prayer = ?, news = ?, participation = ?, 
        speeches = ?, poem_recitation = ?, dance = ?, song = ?, stage_management = ?, 
        innovation = ?, skit = ?, ppt = ?, anchoring = ?, total = ?, 
        speaking_skills = ?, dancing_skills = ?, singing_skills = ?, dramatic_skills = ?, 
        comments = ? 
        WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssssssssssssssssi",
            $session, $eval_date, $topic, $teacher_name, $teacher_id, 
            $evaluator_name, $class_section, $prayer, $news, $participation,
            $speeches, $poem_recitation, $dance, $song, $stage_management,
            $innovation, $skit, $ppt, $anchoring, $total,
            $speaking_skills, $dancing_skills, $singing_skills, $dramatic_skills, 
            $comments, $id
        );

        if (mysqli_stmt_execute($stmt)) {
            $submitted = true;
            $message = "✅ Record updated successfully. Total: " . $total;
            // Refresh the record data
            $record = array_merge($record, [
                'session' => $session, 'eval_date' => $eval_date, 'topic' => $topic,
                'teacher_name' => $teacher_name, 'teacher_id' => $teacher_id,
                'evaluator_name' => $evaluator_name, 'class_section' => $class_section,
                'prayer' => $prayer, 'news' => $news, 'participation' => $participation,
                'speeches' => $speeches, 'poem_recitation' => $poem_recitation,
                'dance' => $dance, 'song' => $song, 'stage_management' => $stage_management,
                'innovation' => $innovation, 'skit' => $skit, 'ppt' => $ppt,
                'anchoring' => $anchoring, 'total' => $total,
                'speaking_skills' => $speaking_skills, 'dancing_skills' => $dancing_skills,
                'singing_skills' => $singing_skills, 'dramatic_skills' => $dramatic_skills,
                'comments' => $comments
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

        function calculateTotal() {
            const fields = [
                'prayer', 'news', 'participation', 'speeches', 'poem_recitation',
                'dance', 'song', 'stage_management', 'innovation',
                'skit', 'ppt', 'anchoring'
            ];
            
            let total = 0;
            
            fields.forEach(field => {
                const value = parseInt(document.querySelector(`[name="${field}"]`).value) || 0;
                total += value;
            });
            
            document.getElementById('totalField').value = total;
        }

        // Add event listeners when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const numericFields = [
                'prayer', 'news', 'participation', 'speeches', 'poem_recitation',
                'dance', 'song', 'stage_management', 'innovation',
                'skit', 'ppt', 'anchoring'
            ];
            
            numericFields.forEach(field => {
                const input = document.querySelector(`[name="${field}"]`);
                if (input) {
                    input.addEventListener('input', calculateTotal);
                }
            });
            
            // Calculate initial total
            calculateTotal();
        });
    </script>
</head>
<body>
    <div class="page-wrapper">
        <div class="content mb-3">
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3>Edit Class Show Record</h3>
                <div>
                    <a href="list_class_show.php" class="btn btn-secondary">Back to List</a>
                    <a href="view_class_show.php?id=<?= $id ?>" class="btn btn-info">View</a>
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
                                    <label>Evaluator's Name & Designation</label>
                                    <select name="evaluator_name" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="Meera Marwaha" <?= $record['evaluator_name'] == 'Meera Marwaha' ? 'selected' : '' ?>>Meera Marwaha</option>
                                        <option value="Manju Setia" <?= $record['evaluator_name'] == 'Manju Setia' ? 'selected' : '' ?>>Manju Setia</option>
                                        <option value="Madhup Prashar" <?= $record['evaluator_name'] == 'Madhup Prashar' ? 'selected' : '' ?>>Madhup Prashar</option>
                                        <option value="Other" <?= $record['evaluator_name'] == 'Other' ? 'selected' : '' ?>>Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Topic</label>
                                    <input type="text" name="topic" class="form-control" value="<?= htmlspecialchars($record['topic']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Prayer</label>
                                    <input type="number" name="prayer" class="form-control" value="<?= $record['prayer'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>News</label>
                                    <input type="number" name="news" class="form-control" value="<?= $record['news'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Participation</label>
                                    <input type="number" name="participation" class="form-control" value="<?= $record['participation'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Speeches</label>
                                    <input type="number" name="speeches" class="form-control" value="<?= $record['speeches'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Poem recitation</label>
                                    <input type="number" name="poem_recitation" class="form-control" value="<?= $record['poem_recitation'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Dance</label>
                                    <input type="number" name="dance" class="form-control" value="<?= $record['dance'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Song</label>
                                    <input type="number" name="song" class="form-control" value="<?= $record['song'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Stage Management</label>
                                    <input type="number" name="stage_management" class="form-control" value="<?= $record['stage_management'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Innovation</label>
                                    <input type="number" name="innovation" class="form-control" value="<?= $record['innovation'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Skit</label>
                                    <input type="number" name="skit" class="form-control" value="<?= $record['skit'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>PPT</label>
                                    <input type="number" name="ppt" class="form-control" value="<?= $record['ppt'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Anchoring</label>
                                    <input type="number" name="anchoring" class="form-control" value="<?= $record['anchoring'] ?>" min="0" max="10" required>
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
                                    <input type="number" name="speaking_skills" class="form-control" value="<?= $record['speaking_skills'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Dancing Skills</label>
                                    <input type="number" name="dancing_skills" class="form-control" value="<?= $record['dancing_skills'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Singing Skills</label>
                                    <input type="number" name="singing_skills" class="form-control" value="<?= $record['singing_skills'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Dramatic Skills</label>
                                    <input type="number" name="dramatic_skills" class="form-control" value="<?= $record['dramatic_skills'] ?>" min="0" max="10" required>
                                </div>
                                <div class="mb-3">
                                    <label>Comments</label>
                                    <textarea name="comments" class="form-control" rows="4" required><?= htmlspecialchars($record['comments']) ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Update Record</button>
                                <a href="./dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
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