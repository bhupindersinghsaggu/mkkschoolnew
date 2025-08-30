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
    <!-- Load Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Load Font Awesome for icons -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                font-size: 13px;
            }

            .no-print {
                display: none !important;
            }

            @page {
                margin: 15mm;
            }

            .record-card {
                page-break-inside: avoid;
            }

            .table {
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
                border-collapse: collapse;
            }

            .table-bordered {
                border: 1px solid #dee2e6;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid #dee2e6;
                padding: 0.75rem;
                vertical-align: top;
            }

            .table-bordered thead th,
            .table-bordered thead td {
                border-bottom-width: 2px;
            }
        }

        .teacher-photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            padding: 5px;
        }

        .school-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .school-header h2 {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .school-header p {
            margin-bottom: 0;
        }

        .record-card {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }

        .report-heading {
            text-align: center;
            background: #000;
            color: #fff;
            padding: 6px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .signature-box .col-md-6 {
            padding-top: 30px;
            border-top: 1px solid #333;
            text-align: center;
            margin-top: 40px;
        }

        .container {
            max-width: 100%;
            padding: 15px;
        }

        .table {
            margin-bottom: 20px;
        }

        .table th {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="no-print mt-4 mb-3 text-end">
            <button class="btn btn-primary btn-sm" onclick="window.print()">🖨 Print</button>
            <a href="./list_notebook.php" class="btn btn-secondary btn-sm">← Back</a>
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
                        $photo_path = '../uploads/profile_pics/' . ($row['profile_pic'] ?? '');
                        if (!empty($row['profile_pic']) && file_exists($photo_path)) {
                            echo "<img src='$photo_path' class='teacher-photo' alt='Teacher Photo'>";
                        } else {
                            echo "<div class='teacher-photo d-flex align-items-center justify-content-center bg-light'>
                                    <i class='fas fa-user fa-3x text-muted'></i>
                                  </div>";
                        }
                        ?>
                    </td>
                    <th>Session</th>
                    <td><?= htmlspecialchars($row['session']) ?></td>
                    <th>Date of Evaluation</th>
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
                        <th>Number of Notebooks Checked</th>
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

        <div class="row signature-box">
            <div class="col-md-6">Teacher Signature</div>
            <div class="col-md-6">Evaluator Signature</div>
        </div>
    </div>

    <!-- Load Bootstrap JS (optional, only needed if using interactive elements) -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>