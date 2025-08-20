<?php require_once '../includes/auth_check.php';
require_once  '../config/database.php';
require_once  '../config/functions.php';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$where = "";
if ($start_date && $end_date) {
    $where = "WHERE eval_date BETWEEN '$start_date' AND '$end_date'";
}

$query = "SELECT * FROM records $where ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print View - Notebook Records</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        @media print {

            /****** Utils ******/
            @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lexend:wght@100..900&display=swap');

            body {
                font-size: 9px;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                font-family: 'Lexend', sans-serif;
                color: #646B72;
                line-height: 1.5;
                background-color: #F7F7F7;
                overflow-y: auto;
                overflow-x: hidden;
            }

            .no-print {
                display: none;
            }

            @page {
                size: portrait;
                margin: 20mm;
            }

            .record-card {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }

        .report-heading {
            text-align: center;
            background: black;
            padding-top: 5px;
            padding-bottom: 5px;
            color: #fff;
            font-weight: 400;
            border-radius: 8px;
            text-align: center;
        }

        .th {
            font-weight: 400 !important;
        }

        .record-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 5px;
        }

        .record-card h5 {
            margin-bottom: 15px;
            /* font-weight: bold; */
        }

        .record-field {
            margin-bottom: 5px;
        }

        .label {
            font-weight: bold;
        }

        .signature-box {
            margin-top: 10px;
        }

        .signature-box .col-md-6 {
            padding-top: 30px;
            border-top: 1px solid #333;
            text-align: center;
        }

        .header-logo {
            width: 50px;
            height: auto;
            margin-right: 20px;
        }

        .school-header {
            text-align: center;
            margin-bottom: 30px;
            font-family: 'Lexend', sans-serif;
        }

        .school-header h2 {
            font-weight: 500;
            margin-top: 10px;
        }

        .school-header p {
            margin: 0;
            font-size: 14px;
        }

        .print-box {
            border-bottom: 1px solid lightgray;
            padding: 10px;
            margin-left: 10px;
        }

       

        table {
            font-size: 10px;
            /* Adjust size as needed */
        }

        table th,
        table td {
            padding: 6px 10px;
            /* Optional: reduce padding too */
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="no-print mb-3 text-end">
            <button class="btn btn-primary btn-sm" onclick="window.print()">🖨 Print</button>
            <a href="list.php" class="btn btn-secondary btn-sm">← Back</a>
        </div>

        <!-- School Header with Logo -->
        <div class="school-header mt-4">
            <div class="d-flex justify-content-center align-items-center "><img src="../assets/img/printlogo.png" alt="School Logo" class="header-logo">
                <h2>Dr. M.K.K. Arya Model School</h2>
            </div>

            <p>Model Town, Panipat</p>
            <?php if ($start_date && $end_date): ?>
            <?php endif; ?>
        </div>
        <?php
        $count = 1;
        while ($row = mysqli_fetch_assoc($result)):
        ?>
            <div class="container mb-3">
                <div class="row">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Session</th>
                                <td><?= $row['session'] ?></td>

                                <th>Date of Evaluation</th>
                                <td><?= $row['eval_date'] ?></td>
                            </tr>
                            <tr>
                                <th>Teacher Name</th>
                                <td><?= $row['teacher_name'] ?></td>

                                <th>Class</th>
                                <td><?= $row['class_section'] ?></td>
                            </tr>
                            <tr>
                                <th>Subject</th>
                                <td><?= $row['subject'] ?></td>

                                <th>Evaluator Name</th>
                                <td><?= $row['evaluator_name'] ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="row">
                <div class="record-card">
                    <h5 class="report-heading"">Teacher Notebook Review Report</h5>
                    <div class=" container">
                        <div class="row">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Number of Notebooks Checked</th>
                                        <td><?= $row['notebooks_checked'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Notebooks Reviewed</th>
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
                                        <td><?= $row['remarks'] ?></td>
                                    </tr>
                                    <!-- <tr>
                                        <th>Undertaking By</th>
                                        <td>Mr/Ms: <?= $row['evaluator_name'] ?></td>
                                    </tr> -->
                                </tbody>
                            </table>

                        </div>
                </div>
            </div>
            <div class="row signature-box">
                <div class="col-md-6">Teacher Signature</div>
                <div class="col-md-6">Evaluator Signature</div>
            </div>
    </div>
<?php
            $count++;
        endwhile;
?>
</div>
</body>

</html>