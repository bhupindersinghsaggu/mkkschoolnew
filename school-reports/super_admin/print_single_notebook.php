<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';
require_once '../config/functions.php';

// Get the ID from the URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$id) {
    die("Invalid Record ID");
}

// Fetch record from records + photo from teachers table
$query = "SELECT r.*, td.profile_pic 
          FROM records r 
          LEFT JOIN teacher_details td ON r.teacher_id = td.teacher_id 
          WHERE r.id = ? 
          LIMIT 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    die("Record not found");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print View - Notebook Record</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">

    <style>
        /* A4 page settings */
        @page {
            size: A4 portrait;
            margin: 15mm 12mm;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: "Arial", sans-serif;
            font-size: 13px;
            color: #222;
            background: #fff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            margin: 0;
        }

        /* Container sized to A4 printable width (210mm minus horizontal margins) */
        .print-container {
            width: calc(210mm - 24mm); /* 210 - (left+right margins) */
            max-width: 100%;
            margin: 12mm auto;
            padding: 10px 12px;
            box-sizing: border-box;
            color: #111;
        }

        .no-print {
            display: block;
        }

        .school-header {
            text-align: center;
            margin-bottom: 12px;
        }

        .school-header img {
            width: 60px;
            height: auto;
            display: inline-block;
        }

        .school-header h2 {
            margin: 6px 0 2px;
            font-size: 18px;
            font-weight: 600;
        }

        .school-header p {
            margin: 0;
            font-size: 12px;
            color: #555;
        }

        .teacher-photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: block;
            margin: 0 auto;
            padding: 4px;
            background: #fff;
        }

        .record-card {
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 12px;
            background: #fff;
        }

        .report-heading {
            text-align: center;
            background: #000;
            color: #fff;
            padding: 6px 8px;
            border-radius: 4px;
            margin: 8px 0 14px;
            font-size: 14px;
        }

        .table th,
        .table td {
            padding: 8px 10px;
            vertical-align: top;
            border: 1px solid #e6e6e6;
            font-size: 13px;
        }

        .table thead th {
            background-color: #f4f4f4;
            font-weight: 600;
        }

        .signature-box .col-6 {
            padding-top: 28px;
            border-top: 1px solid #333;
            text-align: center;
        }

        /* Print-specific rules */
        @media print {
            .no-print { display: none !important; }
            .print-container { margin: 0; padding: 0; box-shadow: none; }
            body { background: white; }
            a[href]:after { content: ""; } /* remove url after links */
        }

        /* Make things a bit tighter on small screens when previewing */
        @media (max-width: 900px) {
            .print-container {
                width: auto;
                margin: 10px;
            }
            .teacher-photo { width: 100px; height: 100px; }
            .school-header h2 { font-size: 16px; }
        }

    </style>
</head>

<body>
    <div class="print-container">
        <div class="no-print mb-3 d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-primary btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print (A4)
                </button>
                <a href="./list_notebook.php" class="btn btn-secondary btn-sm">← Back</a>
            </div>
            <div class="text-muted small">
                Generated: <?= date('d M Y, h:i A') ?>
            </div>
        </div>

        <div class="school-header">
            <img src="../assets/img/printlogo.png" alt="School Logo">
            <h2>Dr. M.K.K. Arya Model School</h2>
            <p>Model Town, Panipat</p>
        </div>

        <table class="table table-bordered mb-3">
            <tbody>
                <tr>
                    <td rowspan="5" style="width: 132px; text-align:center; vertical-align:middle;">
                        <?php
                        $photo_path = '../uploads/profile_pics/' . ($row['profile_pic'] ?? '');
                        if (!empty($row['profile_pic']) && file_exists($photo_path)) {
                            echo "<img src='$photo_path' class='teacher-photo' alt='Teacher Photo'>";
                        } else {
                            echo "<div style='width:120px;height:120px;border:1px solid #eee;border-radius:4px;display:flex;align-items:center;justify-content:center;background:#f8f8f8;'>
                                    <i class='fas fa-user fa-2x text-muted'></i>
                                  </div>";
                        }
                        ?>
                    </td>
                    <th style="width:120px">Session</th>
                    <td><?= htmlspecialchars($row['session']) ?></td>
                    <th style="width:150px">Date of Evaluation</th>
                    <td><?= htmlspecialchars($row['eval_date']) ?></td>
                </tr>
                <tr>
                    <th>Teacher Name</th>
                    <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                    <th>Teacher ID</th>
                    <td><?= htmlspecialchars($row['teacher_id']) ?></td>
                </tr>
                <tr>
                    <th>Class</th>
                    <td><?= htmlspecialchars($row['class_section']) ?></td>
                    <th>Subject</th>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                </tr>
                <tr>
                    <th>Evaluator</th>
                    <td colspan="3"><?= htmlspecialchars($row['evaluator_name']) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="record-card">
            <h5 class="report-heading">Teacher Notebook Review Report</h5>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width:40%;">Number of Notebooks Checked</th>
                        <td><?= htmlspecialchars($row['notebooks_checked']) ?></td>
                    </tr>
                    <tr>
                        <th>Students Reviewed</th>
                        <td><?= htmlspecialchars($row['students_reviewed']) ?></td>
                    </tr>
                    <tr>
                        <th>Regularity in Checking</th>
                        <td><?= htmlspecialchars($row['regularity_checking']) ?></td>
                    </tr>
                    <tr>
                        <th>Accuracy</th>
                        <td><?= htmlspecialchars($row['accuracy']) ?></td>
                    </tr>
                    <tr>
                        <th>Neatness</th>
                        <td><?= htmlspecialchars($row['neatness']) ?></td>
                    </tr>
                    <tr>
                        <th>Follow-up</th>
                        <td><?= htmlspecialchars($row['follow_up']) ?></td>
                    </tr>
                    <tr>
                        <th>Overall Rating</th>
                        <td><?= htmlspecialchars($row['overall_rating']) ?></td>
                    </tr>
                    <tr>
                        <th>Remarks</th>
                        <td><?= nl2br(htmlspecialchars($row['remarks'])) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row signature-box" style="margin-top:18px;">
            <div class="col-6">Teacher Signature</div>
            <div class="col-6 text-end">Evaluator Signature</div>
        </div>

        <div class="no-print" style="height: 20px;"></div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
