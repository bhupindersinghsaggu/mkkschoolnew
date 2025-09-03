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
        /* Print Styles */
        @media print {
            /* Hide non-essential elements */
            .no-print {
                display: none !important;
            }
            
            .page-wrapper {
                padding: 0;
                margin: 0;
                width: 100%;
            }
            
            body {
                font-size: 12pt;
                line-height: 1.4;
                color: #000;
                background: white !important;
                padding: 15px;
            }
            
            /* Card styling */
            .card {
                border: 2px solid #000 !important;
                margin-bottom: 15px;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            
            .card-header {
                background-color: #f0f0f0 !important;
                border-bottom: 2px solid #000 !important;
                padding: 10px;
            }
            
            .card-title {
                color: #000 !important;
                font-weight: bold;
                margin: 0;
            }
            
            /* Table styling */
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            
            .table th,
            .table td {
                border: 1px solid #000 !important;
                padding: 6px;
                vertical-align: top;
            }
            
            .table th {
                background-color: #f8f9fa !important;
                font-weight: bold;
            }
            
            /* Header styling */
            .print-header {
                text-align: center;
                margin-bottom: 20px;
                border-bottom: 3px double #000;
                padding-bottom: 15px;
            }
            
            .print-header h2 {
                margin: 0 0 5px 0;
                font-size: 20pt;
                color: #000;
            }
            
            .print-header p {
                margin: 3px 0;
                font-size: 11pt;
            }
            
            /* Teacher photo */
            .teacher-photo-container {
                text-align: center;
                margin: 10px 0;
                padding: 8px;
                border: 1px solid #000;
            }
            
            .teacher-photo {
                max-width: 80px;
                height: auto;
                border: 2px solid #000;
            }
            
            .photo-label {
                font-weight: bold;
                margin-top: 5px;
                font-size: 11pt;
            }
            
            /* Total score highlighting */
            .total-score {
                background-color: #e9ecef !important;
                font-weight: bold;
                font-size: 13pt;
            }
            
            /* Comments section */
            .comments-box {
                border: 1px solid #000;
                padding: 10px;
                margin: 10px 0;
                background-color: #f9f9f9;
            }
            
            /* Remove all shadows and colors */
            * {
                box-shadow: none !important;
                text-shadow: none !important;
            }
            
            /* Ensure proper page breaks */
            .page-break {
                page-break-before: always;
            }
            
            /* Footer for each page */
            @page {
                margin: 1cm;
                @bottom-right {
                    content: "Page " counter(page) " of " counter(pages);
                    font-size: 10pt;
                }
            }
            
            /* School header */
            .school-header {
                text-align: center;
                margin-bottom: 15px;
            }
            
            .school-header h1 {
                font-size: 18pt;
                margin: 0;
                color: #000;
            }
            
            .school-header p {
                font-size: 11pt;
                margin: 3px 0;
            }
        }

        /* Screen styles */
        @media screen {
            .print-header {
                display: none;
            }
            
            .school-header {
                display: none;
            }
        }

        /* Additional print enhancements */
        @media print {
            a[href]:after {
                content: "" !important;
            }
            
            .btn {
                display: none !important;
            }
            
            /* Improve text contrast */
            .text-muted {
                color: #666 !important;
            }
            
            /* Force black and white */
            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: black !important;
                background: white !important;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="content">
            <!-- Screen header -->
            <div class="header-button d-flex justify-content-between align-items-center mb-3 no-print">
                <h3>Class Show Record Details</h3>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <a href="list_class_show.php" class="btn btn-secondary">Back</a>
                    <a href="edit_class_show.php?id=<?= $row['id'] ?>" class="btn btn-success">Edit</a>
                </div>
            </div>

            <!-- Print Header -->
            <div class="print-header">
                <div class="school-header">
                    <h1>MKK SCHOOL</h1>
                    <p>Class Show Evaluation Report</p>
                </div>
                <h2>CLASS SHOW EVALUATION REPORT</h2>
                <p>Generated on: <?= date('d F Y h:i A') ?></p>
                <p>Report ID: CS<?= str_pad($row['id'], 4, '0', STR_PAD_LEFT) ?></p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Basic Information Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <img src="<?= $teacher_photo ?>" 
                                             alt="<?= htmlspecialchars($row['teacher_name']) ?>"
                                             class="teacher-photo"
                                             onerror="this.onerror=null; this.src='../assets/img/default-teacher.png'">
                                        <div class="photo-label">
                                            <?= htmlspecialchars($row['teacher_name']) ?>
                                        </div>
                                        <div style="font-size: 11pt;">
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
                                    <td><?= htmlspecialchars($row['video_link']) ?></td>
                                </tr>
                                <tr>
                                    <th>Judge</th>
                                    <td><?= htmlspecialchars($row['evaluator_name']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Skills Assessment Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Skills Assessment (Students)</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="60%">Speaking Skills:</th>
                                    <td><?= htmlspecialchars($row['speaking_skills']) ?></td>
                                </tr>
                                <tr>
                                    <th>Dancing Skills</th>
                                    <td><?= htmlspecialchars($row['dancing_skills']) ?></td>
                                </tr>
                                <tr>
                                    <th>Singing Skills</th>
                                    <td><?= htmlspecialchars($row['singing_skills']) ?></td>
                                </tr>
                                <tr>
                                    <th>Dramatic Skills</th>
                                    <td><?= htmlspecialchars($row['dramatic_skills']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Scores Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Scores & Evaluation</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr><th>Category</th><th>Score</th><th>Max</th></tr>
                                <tr><td>Prayer</td><td><?= $row['prayer'] ?></td><td>3</td></tr>
                                <tr><td>News [English Only]</td><td><?= $row['news'] ?></td><td>2</td></tr>
                                <tr><td>Participation</td><td><?= $row['participation'] ?></td><td>3</td></tr>
                                <tr><td>Speeches</td><td><?= $row['speeches'] ?></td><td>5</td></tr>
                                <tr><td>Poem Recitation</td><td><?= $row['poem_recitation'] ?></td><td>2</td></tr>
                                <tr><td>Group Dance</td><td><?= $row['dance'] ?></td><td>4</td></tr>
                                <tr><td>Group Song</td><td><?= $row['song'] ?></td><td>4</td></tr>
                                <tr><td>Stage Management</td><td><?= $row['stage_management'] ?></td><td>3</td></tr>
                                <tr><td>Innovation</td><td><?= $row['innovation'] ?></td><td>2</td></tr>
                                <tr><td>Theme Based Skit</td><td><?= $row['skit'] ?></td><td>4</td></tr>
                                <tr><td>Power Point Presentation</td><td><?= $row['ppt'] ?></td><td>4</td></tr>
                                <tr><td>Anchoring</td><td><?= $row['anchoring'] ?></td><td>3</td></tr>
                                <tr class="total-score">
                                    <td><strong>TOTAL SCORE</strong></td>
                                    <td colspan="2"><strong><?= $row['total'] ?> / 40</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Final Marks Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Final Marks</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="70%">Marks By Judge 1</th>
                                    <td><?= $row['marks_judge1'] ?></td>
                                </tr>
                                <tr>
                                    <th>Marks By Judge 2</th>
                                    <td><?= $row['marks_judge2'] ?></td>
                                </tr>
                                <tr class="total-score">
                                    <th>AVERAGE MARKS</th>
                                    <td><strong><?= number_format($average_marks, 2) ?></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Comments & Remarks</h5>
                        </div>
                        <div class="card-body">
                            <div class="comments-box">
                                <strong>Judge 1 Comments:</strong><br>
                                <?= nl2br(htmlspecialchars($row['comments1'])) ?>
                            </div>
                            <div class="comments-box">
                                <strong>Judge 2 Comments:</strong><br>
                                <?= nl2br(htmlspecialchars($row['comments2'])) ?>
                            </div>
                            <div style="margin-top: 15px; font-style: italic;">
                                <strong>Record Created:</strong> 
                                <?= date('d M Y h:i A', strtotime($row['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Signature Area for Print -->
            <div class="row no-print" style="margin-top: 30px;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Approval</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Evaluator's Signature: _________________________</p>
                                    <p>Name: <?= htmlspecialchars($row['evaluator_name']) ?></p>
                                    <p>Date: _________________________</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Principal's Signature: _________________________</p>
                                    <p>Date: _________________________</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <div class="no-print mt-4 mb-3">
            <div class="text-center">
                <button onclick="window.print()" class="btn btn-primary btn-lg">
                    <i class="fas fa-print"></i> Print This Report
                </button>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script>
        // Preload images for better printing
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                const newImg = new Image();
                newImg.src = img.src;
            });
        });

        // Print optimization
        function beforePrint() {
            document.title = "Class Show Evaluation - <?= $row['teacher_name'] ?> - <?= date('d M Y', strtotime($row['eval_date'])) ?>";
        }

        function afterPrint() {
            document.title = "View Class Show Record";
        }

        // Add event listeners for print
        if (window.matchMedia) {
            const mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(mql => {
                if (mql.matches) {
                    beforePrint();
                } else {
                    afterPrint();
                }
            });
        }

        window.onbeforeprint = beforePrint;
        window.onafterprint = afterPrint;
    </script>
</body>

</html>

<?php
// Close statement
mysqli_stmt_close($stmt);
?>