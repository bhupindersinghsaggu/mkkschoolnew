<?php
// $row is already available from export_pdf.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notebook Record - PDF</title>
    <style>
        body {
            font-size: 13px;
            font-family: 'Arial', sans-serif;
        }

        .teacher-photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            padding: 5px;
        }

        .school-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .record-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .report-heading {
            text-align: center;
            background: #000;
            color: #fff;
            padding: 6px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }

        .signature-box {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box div {
            width: 45%;
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 30px;
        }
    </style>
</head>
<body>
    <div class="school-header">
        <img src="../assets/img/printlogo.png" alt="School Logo" width="60">
        <h2>Dr. M.K.K. Arya Model School</h2>
        <p>Model Town, Panipat</p>
    </div>

    <table>
        <tr>
            <td rowspan="4" style="text-align:center; width:130px;">
                <?php
                $photo_path = "../uploads/" . $row['photo'];
                if (!empty($row['photo']) && file_exists($photo_path)) {
                    echo "<img src='$photo_path' class='teacher-photo'>";
                } else {
                    echo "<strong>No Photo</strong>";
                }
                ?>
            </td>
            <th>Session</th>
            <td><?= $row['session'] ?></td>
            <th>Date of Evaluation</th>
            <td><?= $row['eval_date'] ?></td>
        </tr>
        <tr>
            <th>Teacher Name</th>
            <td><?= $row['teacher_name'] ?></td>
            <th>Teacher ID</th>
            <td><?= $row['teacher_id'] ?></td>
        </tr>
        <tr>
            <th>Class</th>
            <td><?= $row['class_section'] ?></td>
            <th>Subject</th>
            <td><?= $row['subject'] ?></td>
        </tr>
        <tr>
            <th>Evaluator</th>
            <td colspan="3"><?= $row['evaluator_name'] ?></td>
        </tr>
    </table>

    <div class="record-card">
        <h5 class="report-heading">Teacher Notebook Review Report</h5>
        <table>
            <tr>
                <th>Number of Notebooks Checked</th>
                <td><?= $row['notebooks_checked'] ?></td>
            </tr>
            <tr>
                <th>Students Reviewed</th>
                <td><?= $row['students_reviewed'] ?></td>
            </tr>
            <tr>
                <th>Regularity in Checking</th>
                <td><?= $row['regularity_checking'] ?></td>
            </tr>
            <tr>
                <th>Accuracy</th>
                <td><?= $row['accuracy'] ?></td>
            </tr>
            <tr>
                <th>Neatness</th>
                <td><?= $row['neatness'] ?></td>
            </tr>
            <tr>
                <th>Follow-up</th>
                <td><?= $row['follow_up'] ?></td>
            </tr>
            <tr>
                <th>Overall Rating</th>
                <td><?= $row['overall_rating'] ?></td>
            </tr>
            <tr>
                <th>Remarks</th>
                <td><?= nl2br(htmlspecialchars($row['remarks'])) ?></td>
            </tr>
        </table>
    </div>

    <div class="signature-box">
        <div>Teacher Signature</div>
        <div>Evaluator Signature</div>
    </div>

    <a href="export_pdf.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">⬇ Export as PDF</a>
</body>
</html>
