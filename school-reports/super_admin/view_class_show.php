<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

// Get record ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: list_class_show.php?message=Invalid record ID");
    exit();
}

// Fetch specific record with teacher photo
$query = "SELECT cs.*, td.profile_pic as teacher_photo 
          FROM class_show cs 
          LEFT JOIN teacher_details td ON cs.teacher_id = td.teacher_id 
          WHERE cs.id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: list_class_show.php?message=Record not found");
    exit();
}

// Get teacher photo path or use default
$teacher_photo = !empty($row['teacher_photo']) ? '../uploads/profile_pics/' . $row['teacher_photo'] : '../assets/img/default-teacher.png';
// Make sure the path is correct - adjust if your photos are in a different directory

// Calculate average marks
$marks1 = (float)$row['marks_judge1'];
$marks2 = (float)$row['marks_judge2'];
$average_marks = ($marks1 + $marks2) / 2;

// Debug: Check what values you're getting
error_log("Judge 1 marks: " . $row['marks_judge1']);
error_log("Judge 2 marks: " . $row['marks_judge2']);
error_log("Calculated average: " . $average_marks);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Class Show Record</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .page-wrapper {
                padding: 0;
                margin: 0;
            }

            .card {
                border: 1px solid #000;
                margin-bottom: 15px;
                break-inside: avoid;
            }

            .card-header {
                background-color: #f8f9fa !important;
                border-bottom: 2px solid #000;
            }

            .table th {
                background-color: #f8f9fa !important;
            }

            body {
                font-size: 12px;
                padding: 20px;
            }

            h3,
            h5 {
                color: #000 !important;
            }

            .btn {
                display: none;
            }

            .header-button {
                margin-bottom: 20px;
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
            }

            .teacher-photo {
                max-width: 120px;
                height: auto;
                border: 2px solid #000;
                margin: 10px 0;
            }

            /* Ensure images print correctly */
            img {
                max-width: 100% !important;
                height: auto !important;
            }
        }

        .print-header {
            display: none;
        }

        @media print {
            .print-header {
                display: block;
                text-align: center;
                margin-bottom: 20px;
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
            }

            .print-header h2 {
                margin: 0;
                font-size: 18px;
            }

            .print-header p {
                margin: 5px 0;
                font-size: 12px;
            }
        }

        .teacher-photo-container {
            text-align: center;
            margin: 15px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .teacher-photo {
            max-width: 70px;
            height: auto;
            border-radius: 5px;
            border: 3px solid #dee2e6;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        @media print {
            .teacher-photo-container {
                background-color: transparent !important;
                border: 1px solid #000;
            }

            .teacher-photo {
                max-width: 100px;
                border: 2px solid #000;
                box-shadow: none;
            }
        }

        .photo-label {
            font-weight: bold;
            margin-top: 8px;
            color: #495057;
        }

        @media print {
            .photo-label {
                color: #000 !important;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="content">
            <div class="header-button d-flex justify-content-between align-items-center mb-3 no-print">
                <h3>Class Show Record Details</h3>
                <div>
                    <a href="print_single_class_show.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print
                    </a>
                    <a href="list_class_show.php" class="btn btn-secondary">Back</a>
                    <a href="edit_class_show.php?id=<?= $row['id'] ?>" class="btn btn-success">Edit</a>
                </div>
            </div>

            <!-- Print Header (only shows when printing) -->
            <div class="print-header">
                <h2>Class Show Evaluation Report</h2>
                <!-- <p>Generated on: <?= date('d M Y h:i A') ?></p>
                <p>Report ID: CS<?= str_pad($row['id'], 4, '0', STR_PAD_LEFT) ?></p> -->
            </div>

            <div class="row">
                <h2 style="text-align: center; margin-bottom:10px">Class Show Report</h2>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%"><img src="<?= $teacher_photo ?>"
                                            alt="<?= htmlspecialchars($row['teacher_name']) ?>"
                                            class="teacher-photo"
                                            onerror="this.onerror=null; this.src='../assets/img/default-teacher.png'">
                                    </th>
                                    <td>
                                        <div class="photo-label">
                                            <?= htmlspecialchars($row['teacher_name']) ?>
                                        </div>
                                        <div class="text-muted small">
                                            ID: <?= htmlspecialchars($row['teacher_id']) ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="40%">Session</th>
                                    <td><?= htmlspecialchars($row['session']) ?></td>
                                </tr>
                                <tr>
                                    <th>Class Show Date</th>
                                    <td><?= date('d M Y', strtotime($row['eval_date'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Class/Section</th>
                                    <td><?= htmlspecialchars($row['class_section']) ?></td>
                                </tr>
                                <tr>
                                    <th>Topic</th>
                                    <td><?= htmlspecialchars($row['topic']) ?></td>
                                </tr>
                                <tr>
                                    <th>Video Link</th>
                                    <td><a href="<?= htmlspecialchars($row['video_link']) ?>" target="_blank" title="Watch Video">
                                            <i class="fas fa-external-link-alt"></i> View Video <!-- External link icon -->
                                        </a></td>
                                </tr>
                                <tr>
                                    <th>Judge</th>
                                    <td><?= htmlspecialchars($row['evaluator_name']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Skills Assessment (Students)</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="60%">Speaking Skills (Students):</th>
                                    <td><?= $row['speaking_skills'] ?></td>
                                </tr>
                                <tr>
                                    <th>Dancing Skills (Students)</th>
                                    <td><?= $row['dancing_skills'] ?></td>
                                </tr>
                                <tr>
                                    <th>Singing Skills (Students)</th>
                                    <td><?= $row['singing_skills'] ?></td>
                                </tr>
                                <tr>
                                    <th>Dramatic Skills (Students)</th>
                                    <td><?= $row['dramatic_skills'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Scores & Evaluation</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="60%">Prayer (03)</th>
                                    <td><?= $row['prayer'] ?></td>
                                </tr>
                                <tr>
                                    <th>News [English Only] (02)</th>
                                    <td><?= $row['news'] ?></td>
                                </tr>
                                <tr>
                                    <th>Participation (03)</th>
                                    <td><?= $row['participation'] ?></td>
                                </tr>
                                <tr>
                                    <th>Speeches [English (50), Hindi (01)]</th>
                                    <td><?= $row['speeches'] ?></td>
                                </tr>
                                <tr>
                                    <th>Poem Recitation [English (02), Hindi (01)]</th>
                                    <td><?= $row['poem_recitation'] ?></td>
                                </tr>
                                <tr>
                                    <th>Group Dance (04)</th>
                                    <td><?= $row['dance'] ?></td>
                                </tr>
                                <tr>
                                    <th>Group Song (04)</th>
                                    <td><?= $row['song'] ?></td>
                                </tr>
                                <tr>
                                    <th>Stage Management (03)</th>
                                    <td><?= $row['stage_management'] ?></td>
                                </tr>
                                <tr>
                                    <th>Innovation (02)</th>
                                    <td><?= $row['innovation'] ?></td>
                                </tr>
                                <tr>
                                    <th>Theme Based Skit Presentation (04)</th>
                                    <td><?= $row['skit'] ?></td>
                                </tr>
                                <tr>
                                    <th>Theme Based Power Point Presentation (04)</th>
                                    <td><?= $row['ppt'] ?></td>
                                </tr>
                                <tr>
                                    <th>Anchoring (03)</th>
                                    <td><?= $row['anchoring'] ?></td>
                                </tr>
                                <!-- <tr class="table-success">
                                    <th><strong>Total Score (Out of 40):</strong></th>
                                    <td><strong><?= $row['total'] ?></strong></td>
                                </tr> -->

                            </table>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Final Marks</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Marks By Judge 1</th>
                                        <td><?= $row['marks_judge1'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Marks By Judge 2</th>
                                        <td><?= $row['marks_judge2'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Comments & Suggestions </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label"><strong>Judge 1 </strong></label>
                                <p class="form-control-plaintext"><?= nl2br(htmlspecialchars($row['comments1'])) ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Judge 2</strong></label>
                                <p class="form-control-plaintext"><?= nl2br(htmlspecialchars($row['comments2'])) ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Record Created:</strong></label>
                                <p class="form-control-plaintext"><?= date('d M Y h:i A', strtotime($row['created_at'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <div class="card-header">
                            <h5 class="card-title">Average Marks</h5>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <div class="input-group">
                                    <input type="number" class="form-control fw-bold text-success"
                                        value="<?= number_format($average_marks, 2) ?>"
                                        readonly>
                                    <span class="input-group-text">/ 40</span>
                                </div>
                                <small class="text-muted">
                                    Calculated from: (Judge 1: <?= $row['marks_judge1'] ?> + Judge 2: <?= $row['marks_judge2'] ?>) ÷ 2
                                </small>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Print Footer -->
        <div class="no-print mt-4 mb-3">
            <div class="text-center">
                <button onclick="printReport()" class="btn btn-primary btn-lg">
                    <i class="fas fa-print"></i> Print This Report
                </button>
            </div>
        </div>
    </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script>
        function printReport() {
            // Store original title
            const originalTitle = document.title;

            // Set print-specific title
            document.title = "Class Show Evaluation - <?= $row['teacher_name'] ?> - <?= date('d M Y', strtotime($row['eval_date'])) ?>";

            // Ensure images are loaded before printing
            const images = document.querySelectorAll('img');
            let imagesLoaded = 0;

            if (images.length === 0) {
                window.print();
            } else {
                images.forEach(img => {
                    if (img.complete) {
                        imagesLoaded++;
                    } else {
                        img.onload = function() {
                            imagesLoaded++;
                            if (imagesLoaded === images.length) {
                                window.print();
                            }
                        };
                        img.onerror = function() {
                            imagesLoaded++;
                            if (imagesLoaded === images.length) {
                                window.print();
                            }
                        };
                    }
                });

                // If all images are already loaded
                if (imagesLoaded === images.length) {
                    window.print();
                }
            }

            // Restore original title after a delay
            setTimeout(() => {
                document.title = originalTitle;
            }, 1000);
        }

        // Preload default teacher image for fallback
        document.addEventListener('DOMContentLoaded', function() {
            const defaultImg = new Image();
            defaultImg.src = '../assets/img/default-teacher.png';
        });
    </script>
</body>

</html>

<?php
// Close statement
mysqli_stmt_close($stmt);
?>