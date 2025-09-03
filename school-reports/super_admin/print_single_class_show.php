<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

// Get record ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$id) {
    die("Invalid Record ID");
}

// Fetch record with teacher photo
$query = "SELECT cs.*, td.profile_pic AS teacher_photo
          FROM class_show cs
          LEFT JOIN teacher_details td ON cs.teacher_id = td.teacher_id
          WHERE cs.id = $id LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Record not found");
}

// Photo
$teacher_photo = !empty($row['teacher_photo']) && file_exists('../uploads/profile_pics/' . $row['teacher_photo'])
    ? '../uploads/profile_pics/' . $row['teacher_photo']
    : '../assets/img/default-teacher.png';

// Average marks
$marks1 = (float) $row['marks_judge1'];
$marks2 = (float) $row['marks_judge2'];
$average_marks = ($marks1 + $marks2) / 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print View - Class Show Record</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .school-header { text-align: center; margin-bottom: 30px; }
        .school-header img { width: 60px; margin-bottom: 10px; }
        .record-card { border: 1px solid #ccc; padding: 20px; margin-bottom: 30px; border-radius: 5px; }
        .report-heading { text-align: center; background: #000; color: #fff; padding: 6px; border-radius: 5px; margin-bottom: 20px; }
        .teacher-photo { width: 120px; height: 120px; object-fit: cover; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; padding: 5px; }
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12px; }
            @page { margin: 15mm; }
        }
    </style>
</head>
<body onload="window.print()">
<div class="container">
    <div class="no-print text-end my-3">
        <button class="btn btn-primary btn-sm" onclick="window.print()">🖨 Print</button>
        <a href="./list_class_show.php" class="btn btn-secondary btn-sm">← Back</a>
    </div>

    <div class="school-header">
        <img src="../assets/img/printlogo.png" alt="School Logo">
        <h2>Dr. M.K.K. Arya Model School</h2>
        <p>Model Town, Panipat</p>
    </div>

    <table class="table table-bordered">
        <tbody>
        <tr>
            <td rowspan="5" style="text-align:center; vertical-align:middle; width:130px;">
                <img src="<?= $teacher_photo ?>" class="teacher-photo" alt="Teacher Photo">
            </td>
            <th>Session</th>
            <td><?= htmlspecialchars($row['session']) ?></td>
            <th>Date of Class Show</th>
            <td><?= date('d M Y', strtotime($row['eval_date'])) ?></td>
        </tr>
        <tr>
            <th>Teacher Name</th>
            <td><?= htmlspecialchars($row['teacher_name']) ?></td>
            <th>Teacher ID</th>
            <td><?= htmlspecialchars($row['teacher_id']) ?></td>
        </tr>
        <tr>
            <th>Class/Section</th>
            <td><?= htmlspecialchars($row['class_section']) ?></td>
            <th>Topic</th>
            <td><?= htmlspecialchars($row['topic']) ?></td>
        </tr>
        <tr>
            <th>Evaluator</th>
            <td colspan="3"><?= htmlspecialchars($row['evaluator_name']) ?></td>
        </tr>
        </tbody>
    </table>

    <div class="record-card">
        <h5 class="report-heading">Class Show Skills Assessment</h5>
        <table class="table table-bordered">
            <tr><th>Speaking Skills</th><td><?= $row['speaking_skills'] ?></td></tr>
            <tr><th>Dancing Skills</th><td><?= $row['dancing_skills'] ?></td></tr>
            <tr><th>Singing Skills</th><td><?= $row['singing_skills'] ?></td></tr>
            <tr><th>Dramatic Skills</th><td><?= $row['dramatic_skills'] ?></td></tr>
        </table>
    </div>

    <div class="record-card">
        <h5 class="report-heading">Scores & Evaluation</h5>
        <table class="table table-bordered">
            <tr><th>Prayer</th><td><?= $row['prayer'] ?></td></tr>
            <tr><th>News</th><td><?= $row['news'] ?></td></tr>
            <tr><th>Participation</th><td><?= $row['participation'] ?></td></tr>
            <tr><th>Speeches</th><td><?= $row['speeches'] ?></td></tr>
            <tr><th>Poem Recitation</th><td><?= $row['poem_recitation'] ?></td></tr>
            <tr><th>Dance</th><td><?= $row['dance'] ?></td></tr>
            <tr><th>Song</th><td><?= $row['song'] ?></td></tr>
            <tr><th>Stage Management</th><td><?= $row['stage_management'] ?></td></tr>
            <tr><th>Innovation</th><td><?= $row['innovation'] ?></td></tr>
            <tr><th>Skit</th><td><?= $row['skit'] ?></td></tr>
            <tr><th>PowerPoint Presentation</th><td><?= $row['ppt'] ?></td></tr>
            <tr><th>Anchoring</th><td><?= $row['anchoring'] ?></td></tr>
            <tr><th>Judge 1 Marks</th><td><?= $row['marks_judge1'] ?></td></tr>
            <tr><th>Judge 2 Marks</th><td><?= $row['marks_judge2'] ?></td></tr>
            <tr><th>Average Marks</th><td><?= number_format($average_marks, 2) ?> / 40</td></tr>
        </table>
    </div>

    <div class="record-card">
        <h5 class="report-heading">Comments</h5>
        <p><strong>Comment 1:</strong> <?= nl2br(htmlspecialchars($row['comments1'])) ?></p>
        <p><strong>Comment 2:</strong> <?= nl2br(htmlspecialchars($row['comments2'])) ?></p>
        <p><strong>Record Created:</strong> <?= date('d M Y h:i A', strtotime($row['created_at'])) ?></p>
    </div>
</div>
</body>
</html>
