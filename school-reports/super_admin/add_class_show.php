<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

$submitted = false;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Convert string inputs to integers for numeric fields
    $session = $_POST['session'];
    $eval_date = $_POST['eval_date'];
    $topic = $_POST['topic'];
    $teacher_name = $_POST['teacher_name'];
    $teacher_id = $_POST['teacher_id'];
    $evaluator_name = $_POST['evaluator_name'];
    $class_section = $_POST['class_section'];

    // Convert to integers
    $prayer = (int)$_POST['prayer']; // This is included in bind variables
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

    // Calculate total sum (including prayer if needed)
    $total = $prayer + $news + $participation + $speeches + $poem_recitation +
        $dance + $song + $stage_management + $innovation +
        $skit + $ppt + $anchoring;

    $speaking_skills = (int)$_POST['speaking_skills'];
    $dancing_skills = (int)$_POST['dancing_skills'];
    $singing_skills = (int)$_POST['singing_skills'];
    $dramatic_skills = (int)$_POST['dramatic_skills'];
    $comments = $_POST['comments'];

    $sql = "INSERT INTO class_show (
        session, eval_date, topic, teacher_name, teacher_id, evaluator_name, class_section,
        prayer, news, participation, speeches, poem_recitation,
        dance, song, stage_management, innovation, skit, ppt, anchoring, total,
        speaking_skills, dancing_skills, singing_skills, dramatic_skills, comments
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Count your bind variables: 25 total
        // 7 strings (session to class_section) + 18 integers + 1 string (comments)
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssiiiiiiiiiiiiiiiiis", // 25 characters: 8s + 18i
            $session,           // s (1)
            $eval_date,         // s (2)
            $topic,             // s (3)
            $teacher_name,      // s (4)
            $teacher_id,        // s (5)
            $evaluator_name,    // s (6)
            $class_section,     // s (7)
            $prayer,            // i (8) - This was missing from your count!
            $news,              // i (9)
            $participation,     // i (10)
            $speeches,          // i (11)
            $poem_recitation,   // i (12)
            $dance,             // i (13)
            $song,              // i (14)
            $stage_management,  // i (15)
            $innovation,        // i (16)
            $skit,              // i (17)
            $ppt,               // i (18)
            $anchoring,         // i (19)
            $total,             // i (20)
            $speaking_skills,   // i (21)
            $dancing_skills,    // i (22)
            $singing_skills,    // i (23)
            $dramatic_skills,   // i (24)
            $comments           // s (25)
        );

        if (mysqli_stmt_execute($stmt)) {
            $submitted = true;
            $message = "✅ Record successfully submitted. Total: " . $total;
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
    <title>Add Class Show</title>
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
    </script>
</head>

<body>
    <div class="page-wrapper">
        <div class="content mb-3">
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3 class="">Add Class Show</h3>
                <a href="list_class_show.php" class="btn btn-success">View</a></h3>
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
                                    <label>Date of class show</label>
                                    <input type="date" name="eval_date" class="form-control" required>
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
                                                echo "<option value='" . htmlspecialchars($teacher['teacher_id']) . "' 
                                                      data-name='" . htmlspecialchars($teacher['teacher_name']) . "' 
                                                      data-subject='" . htmlspecialchars($teacher['subject']) . "'
                                                      data-type='" . htmlspecialchars($teacher['teacher_type']) . "'>
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
                                    <input type="text" name="teacher_name" id="teacherName" class="form-control" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Teacher ID</label>
                                    <input type="text" name="teacher_id" id="teacherId" class="form-control" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Teacher Type</label>
                                    <input type="text" name="teacher_type" id="teacherType" class="form-control" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label>Class/Section</label>
                                    <input type="text" name="class_section" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Evaluator's Name & Designation</label>
                                    <select name="evaluator_name" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="Meera Marwaha">Meera Marwaha</option>
                                        <option value="Manju Setia">Manju Setia</option>
                                        <option value="Madhup Prashar">Madhup Prashar</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Topic</label>
                                    <input type="text" name="topic" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Prayer</label>
                                    <input type="number" name="prayer" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>News</label>
                                    <input type="number" name="news" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Participation</label>
                                    <input type="number" name="participation" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Speeches</label>
                                    <input type="number" name="speeches" class="form-control" required>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Poem recitation</label>
                                    <input type="number" name="poem_recitation" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Dance</label>
                                    <input type="number" name="dance" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Song</label>
                                    <input type="number" name="song" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Stage Management</label>
                                    <input type="number" name="stage_management" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Innovation</label>
                                    <input type="number" name="innovation" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Skit</label>
                                    <input type="number" name="skit" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>PPT</label>
                                    <input type="number" name="ppt" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Anchoring</label>
                                    <input type="number" name="anchoring" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Total (Auto-calculated)</label>
                                    <input type="number" name="total" id="totalField" class="form-control" readonly required>
                                    <small class="text-muted">This field is automatically calculated</small>
                                </div>
                                <div class="mb-3">
                                    <label>Speaking Skills</label>
                                    <input type="text" name="speaking_skills" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Dancing Skills</label>
                                    <input type="text" name="dancing_skills" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Singing Skills</label>
                                    <input type="text" name="singing_skills" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Dramatic Skills</label>
                                    <input type="text" name="dramatic_skills" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Comments</label>
                                    <input type="text" name="comments" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="./dashboard.php" class="btn btn-secondary">Back</a>
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