<?php
require_once '../includes/auth_check.php';
require_once  '../config/database.php';
require_once  '../config/functions.php';

// Get the ID from the URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$id) {
    die("Invalid Record ID");
}

// Fetch record from records + photo from teachers table
$query = "SELECT r.*, t.photo 
          FROM records r 
          LEFT JOIN teachers t ON r.teacher_id = t.teacher_id 
          WHERE r.id = $id 
          LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Record not found");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print View - Notebook Record</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        @media print {
            body {
                font-size: 13px;
                font-family: 'Arial', sans-serif;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none;
            }

            @page {
                margin: 20mm;
            }

            .record-card {
                page-break-inside: avoid;
            }
        }

        .teacher-photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            /* border-radius: 100%; */
            padding: 5px;
        }

        .school-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .school-header h2 {
            font-weight: 500;
        }

        .record-card {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }

        .report-heading {
            text-align: center;
            background: black;
            color: white;
            padding: 6px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .signature-box .col-md-6 {
            padding-top: 30px;
            border-top: 1px solid #333;
            text-align: center;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="no-print mt-4 mb-3 text-end">
            <button class="btn btn-primary btn-sm" onclick="window.print()">🖨 Print</button>
            <a href="list.php" class="btn btn-secondary btn-sm">← Back</a>
        </div>

        <div class="school-header">
            <img src="../assets/img/printlogo.png" alt="School Logo" width="60">
            <h2>Dr. M.K.K. Arya Model School</h2>
            <p>Model Town, Panipat</p>
        </div>


        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td rowspan="5" style="text-align: center; vertical-align: middle; width: 130px;">
                        <?php
                        $photo_path = "../uploads/" . $row['photo'];
                        if (!empty($row['photo']) && file_exists($photo_path)) {
                            echo "<img src='$photo_path' class='teacher-photo' alt='Teacher Photo'>";
                        } else {
                            echo "<p><strong>No Photo</strong></p>";
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
            </tbody>
        </table>


        <div class="record-card">
            <h5 class="report-heading">Teacher Notebook Review Report</h5>
            <table class="table table-bordered">
                <tbody>
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

                    <!-- <tr>
                        <th>Undertaking</th>
                        <td><?= $row['undertaking'] ? '✔ Yes' : '✖ No' ?></td>
                    </tr> -->
                </tbody>
            </table>
        </div>

        <div class="row signature-box">
            <div class="col-md-6">Teacher Signature</div>
            <div class="col-md-6">Evaluator Signature</div>
        </div>
    </div>
</body>

</html>