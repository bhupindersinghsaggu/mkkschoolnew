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

// Teacher photo
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
    <title>Class Show Report - <?= htmlspecialchars($row['teacher_name']) ?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 14px;
            background: #fff;
        }

        .school-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .school-header img {
            width: 70px;
            margin-bottom: 10px;
        }

        .school-header h2 {
            margin: 0;
            font-weight: 600;
        }

        .school-header p {
            margin: 0;
            font-size: 14px;
        }

        .report-title {
            text-align: center;
            background: #343a40;
            color: #fff;
            padding: 5px;
            margin: 5px 0;
            border-radius: 5px;
            font-size: 18px;
            letter-spacing: 1px;
        }

        .teacher-photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 2px solid #ccc;
            border-radius: 6px;
            padding: 5px;
        }

        .section-title {
            background: #f8f9fa;
            font-weight: 600;
            padding: 6px 10px;
            margin-top: 20px;
            border-left: 4px solid #007bff;
            font-size: 15px;
        }

        .signature-box .col-md-6 {
            padding-top: 40px;
            border-top: 1px solid #333;
            text-align: center;
            margin-top: 50px;
            font-weight: 500;
        }

        table {
            width: 100%;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            @page {
                margin: 15mm;
            }

            body {
                font-size: 12px;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">

        <!-- Top buttons (hidden on print) -->
        <div class="no-print text-end my-3">
            <button class="btn btn-primary btn-sm" onclick="window.print()">🖨 Print</button>
            <a href="./list_class_show.php" class="btn btn-secondary btn-sm">← Back</a>
        </div>

        <!-- Header -->
        <div class="school-header">
            <div class="d-flex justify-content-center align-items-center gap-2">
                <div>
                    <img src="../assets/img/printlogo.png" alt="School Logo">
                </div>
                <div>
                    <h2>Dr. M.K.K. Arya Model School</h2>
                    <p>Model Town, Panipat</p>
                    <div class="report-title">Class Show Evaluation Report</div>
                </div>
            </div>
        </div>
        <!-- Report Title -->
        <!-- Basic Information -->
        <div class="section-title">Basic Information</div>
        <table class="table table-bordered table-sm">
            <tr>
                <td rowspan="4" style="text-align:center; vertical-align:middle; width:150px;">
                    <img src="<?= $teacher_photo ?>" class="teacher-photo" alt="Teacher Photo">
                </td>
                <th>Teacher Name</th>
                <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                <th>Teacher ID</th>
                <td><?= htmlspecialchars($row['teacher_id']) ?></td>
            </tr>
            <tr>
                <th>Session</th>
                <td><?= htmlspecialchars($row['session']) ?></td>
                <th>Date</th>
                <td><?= date('d M Y', strtotime($row['eval_date'])) ?></td>
            </tr>
            <tr>
                <th>Class/Section</th>
                <td><?= htmlspecialchars($row['class_section']) ?></td>
                <th>Topic</th>
                <td><?= htmlspecialchars($row['topic']) ?></td>
            </tr>
            <tr>
                <th>Judges</th>
                <td colspan="3"><?= htmlspecialchars($row['evaluator_name']) ?></td>
            </tr>
        </table>

        <!-- Scores & Evaluation -->
        <div class="section-title">Scores & Evaluation</div>
        <table class="table table-bordered table-sm">
            <tr>
                <th>Prayer</th>
                <td><?= $row['prayer'] ?></td>
            </tr>
            <tr>
                <th>News</th>
                <td><?= $row['news'] ?></td>
            </tr>
            <tr>
                <th>Participation</th>
                <td><?= $row['participation'] ?></td>
            </tr>
            <tr>
                <th>Speeches</th>
                <td><?= $row['speeches'] ?></td>
            </tr>
            <tr>
                <th>Poem Recitation</th>
                <td><?= $row['poem_recitation'] ?></td>
            </tr>
            <tr>
                <th>Dance</th>
                <td><?= $row['dance'] ?></td>
            </tr>
            <tr>
                <th>Song</th>
                <td><?= $row['song'] ?></td>
            </tr>
            <tr>
                <th>Stage Management</th>
                <td><?= $row['stage_management'] ?></td>
            </tr>
            <tr>
                <th>Innovation</th>
                <td><?= $row['innovation'] ?></td>
            </tr>
            <tr>
                <th>Skit</th>
                <td><?= $row['skit'] ?></td>
            </tr>
            <tr>
                <th>PPT</th>
                <td><?= $row['ppt'] ?></td>
            </tr>
            <tr>
                <th>Anchoring</th>
                <td><?= $row['anchoring'] ?></td>
            </tr>
        </table>
        <!-- Skills Assessment -->
        <div class="">
            <div>
                <div class="section-title">Skills Assessment (Students)</div>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Speaking Skills</th>
                        <td><?= $row['speaking_skills'] ?></td>
                    </tr>
                    <tr>
                        <th>Dancing Skills</th>
                        <td><?= $row['dancing_skills'] ?></td>
                    </tr>
                    <tr>
                        <th>Singing Skills</th>
                        <td><?= $row['singing_skills'] ?></td>
                    </tr>
                    <tr>
                        <th>Dramatic Skills</th>
                        <td><?= $row['dramatic_skills'] ?></td>
                    </tr>
                </table>
            </div>
            <!-- Marks -->
            <div>
                <div class="section-title">Final Marks</div>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Marks by Judge 1</th>
                        <td><?= $row['marks_judge1'] ?></td>
                    </tr>
                    <tr>
                        <th>Marks by Judge 2</th>
                        <td><?= $row['marks_judge2'] ?></td>
                    </tr>
                    <tr class="table-success">
                        <th>Average Marks</th>
                        <td><strong><?= number_format($average_marks, 2) ?> / 40</strong></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Comments -->
        <div class="section-title">Comments & Suggestions</div>
        <table class="table table-bordered table-sm">
            <tr>
                <td><strong> Judge 1 </strong> <br><?= nl2br(htmlspecialchars($row['comments1'])) ?></td>
            </tr>
            <tr>
                <td><strong>Judge 2 </strong><br><?= nl2br(htmlspecialchars($row['comments2'])) ?></td>
            </tr>
        </table>
        <div class="d-flex justify-content-start gap-3">
            <div>Record Created</div>
            <div><?= date('d M Y h:i A', strtotime($row['created_at'])) ?></div>
            <!-- Signature -->
        </div>
        <div class="row signature-box d-flex justify-content-between">
            <div class="col-md-6">Teacher Signature</div>
            <div class="col-md-6">Evaluator Signature</div>
        </div>
</body>

</html>