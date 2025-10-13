<?php
// admin/teachers/print_notebook.php
// Fancy printable notebook-correction report (A4-fit)

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../auth.php';
require_once __DIR__ . '/../../database.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header('Location: /mkkschool-new/login.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$PROJECT_FOLDER = '/mkkschool-new'; // adjust if your project folder differs

// Get ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid record ID.");
}

// Fetch record
try {
    $stmt = $conn->prepare("SELECT * FROM records WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$record) {
        die("Record not found.");
    }
} catch (PDOException $e) {
    error_log("Fetch print record error: " . $e->getMessage());
    die("Database error.");
}

// Try to locate teacher photo from users table using teacher_id
$profile_picture = '';
if (!empty($record['teacher_id'])) {
    try {
        $u = $conn->prepare("SELECT profile_picture FROM users WHERE teacher_id = :tid LIMIT 1");
        $u->bindParam(':tid', $record['teacher_id'], PDO::PARAM_STR);
        $u->execute();
        $userRow = $u->fetch(PDO::FETCH_ASSOC);
        if ($userRow && !empty($userRow['profile_picture'])) {
            $profile_picture = $userRow['profile_picture'];
        }
    } catch (PDOException $e) {
        error_log("Lookup teacher photo error: " . $e->getMessage());
    }
}

// Build web URL for profile picture (fall back to default avatar)
$defaultAvatarWeb = $PROJECT_FOLDER . '/assets/images/default-avatar.png';
$logoWeb = $PROJECT_FOLDER . '/assets/images/logo-light.png'; // school logo (adjust if different)
$teacherPhotoWeb = $defaultAvatarWeb;

if (!empty($profile_picture)) {
    // profile_picture stored as relative path like 'uploads/teachers/xxxxx.jpg'
    $candidateRel = ltrim($profile_picture, '/');
    $candidateServer = $_SERVER['DOCUMENT_ROOT'] . $PROJECT_FOLDER . '/' . $candidateRel;
    $candidateWeb = $PROJECT_FOLDER . '/' . $candidateRel;

    if (file_exists($candidateServer)) {
        $teacherPhotoWeb = $candidateWeb;
    } else {
        // maybe it is already a web path starting with slash
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profile_picture)) {
            $teacherPhotoWeb = $profile_picture;
        } else {
            $teacherPhotoWeb = $defaultAvatarWeb;
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Notebook Report #<?= htmlspecialchars($record['id']) ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- keep your project CSS (optional) -->
    <?php /* If includes/css.php outputs <link> tags, keep it. If it injects bulky layout CSS that interferes with print you may remove it. */ ?>
    <?php include __DIR__ . '/../../includes/css.php'; ?>

    <style>
        /* A4 print settings */
        @page {
            size: A4 portrait;
            margin: 10mm;
            /* change if you want larger margins */
        }

        /* Basic reset for print */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: #fff;
            color: #222;
            /* font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", Arial, sans-serif; */
            -webkit-print-color-adjust: exact;
        }

        /* Container sized to A4 width minus margins (210mm - 2*10mm = 190mm) */
        .report {
            width: 190mm;
            margin: 0 auto;
            padding: 8mm 10mm;
            /* internal spacing (keeps content away from edges) */
            background: #fff;
            box-sizing: border-box;
        }

        /* Header */
        .header {
            /* background-color: #2c3e50; */
            color: white;
            padding: 1rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            gap: 12px;
        }

        .logo {
            width: 68px;
            height: 68px;
            /* flex: 0 0 68px; */
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .school-info h1 {
            margin: 0;
            font-size: 18px;
            line-height: 1.05;
        }

        .school-info .sub {
            color: #6c757d;
            font-size: 11px;
            margin-top: 3px;
        }

        /* Meta area */
        .meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }

        .teacher-card {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .teacher-photo {
            width: 88px;
            height: 88px;
            border-radius: 6px;
            overflow: hidden;
            flex: 0 0 88px;
            border: 1px solid #e9ecef;
            background: #fff;
        }

        .teacher-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Info table and small tables */
        table.info-table,
        table.assess-table,
        table.small-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table.info-table td,
        table.info-table th,
        table.assess-table td,
        table.assess-table th,
        table.small-table td,
        table.small-table th {
            padding: 6px 8px;
            vertical-align: top;
            border: 1px solid #e9ecef;
        }

        table.info-table th {
            /* width: 36%; */
            background: #f8f9fa;
            font-weight: 600;
            font-size: 12px;
        }

        .section-title {
            font-weight: 600;
            color: #0d6efd;
            margin-top: 10px;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .remarks {
            border: 1px dashed #e9ecef;
            padding: 8px;
            min-height: 72px;
            white-space: pre-wrap;
            background: #fbfbfb;
            font-size: 12px;
        }

        .two-column {
            display: flex;
            gap: 8px;
        }

        .col-left {
            flex: 0 0 58%;
        }

        .col-right {
            flex: 0 0 42%;
        }

        .sign {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
            align-items: center;
        }

        .sign .by {
            color: #6c757d;
            font-size: 12px;
        }

        .print-footer {
            text-align: right;
            color: #6c757d;
            font-size: 11px;
            margin-top: 8px;
        }

        /* Hide elements you don't want on print */
        .no-print {
            display: inline-block;
            margin-top: 8px;
        }

        /* Print-specific tweaks */
        @media print {

            /* Remove shadows and borders that waste ink */
            .report {
                box-shadow: none;
                border: none;
                background: #fff;
                padding: 0;
            }

            .header {
                border-bottom: none;
                margin-bottom: 6px;
                padding-bottom: 0;
            }

            .no-print {
                display: none !important;
            }

            /* Prevent page breaks inside critical blocks */
            .teacher-card,
            .remarks,
            .two-column {
                page-break-inside: avoid;
            }
        }

        /* Small screens fallback (if viewing in browser) */
        @media screen and (max-width: 900px) {
            .report {
                width: auto;
                padding: 12px;
            }

            .two-column {
                flex-direction: column;
            }

            .col-right,
            .col-left {
                flex: 1 1 auto;
            }
        }
    </style>
</head>

<body onload="setTimeout(()=>window.print(),250)">
    <div class="report" role="main" aria-label="Notebook correction report">

        <div class="header mb-2 d-flex align-items-center">
            <div class="logo mb-2"><img src="<?= htmlspecialchars($logoWeb) ?>" alt="School Logo"></div>
            <div class="school-info">
                <h1 style="color:#000;">Dr. M.K.K. Arya Model School</h1>
                <div class="sub">Notebook Correction Report</div>
                <div class="sub" style="margin-top:6px;">Model Town, Panipat · Phone: 0180-4004556</div>
            </div>

            <div style="margin-left:auto;text-align:right;">
                <div style="font-weight:600; font-size:13px;">Report #: <?= htmlspecialchars($record['id']) ?></div>
                <div style="color:#6c757d; font-size:12px; margin-top:6px;">Date: <?= htmlspecialchars(date('d M Y', strtotime($record['eval_date']))) ?></div>
            </div>
        </div>

        <div class="meta">
            <div class="teacher-card" style="align-items:flex-start;">
                <div class="teacher-photo">
                    <img src="<?= htmlspecialchars($teacherPhotoWeb) ?>" alt="Teacher Photo">
                </div>
                <div>
                    <div style="font-weight:700; font-size:15px;"><?= htmlspecialchars($record['teacher_name']) ?></div>
                    <div style="color:#6c757d; margin-top:6px; font-size:12px;">Teacher ID: <strong><?= htmlspecialchars($record['teacher_id']) ?></strong></div>
                    <div style="color:#6c757d; margin-top:6px; font-size:12px;">Subject: <strong><?= htmlspecialchars($record['subject']) ?></strong></div>
                </div>
            </div>

            <div style="width: 88mm;">
                <table class="small-table">
                    <tr>
                        <th style="background:#f8f9fa; width:50%;">Session</th>
                        <td><?= htmlspecialchars($record['session']) ?></td>
                    </tr>
                    <tr>
                        <th style="background:#f8f9fa;">Class / Section</th>
                        <td><?= htmlspecialchars($record['class_section']) ?></td>
                    </tr>
                    <tr>
                        <th style="background:#f8f9fa;">Notebooks Checked</th>
                        <td><?= htmlspecialchars($record['notebooks_checked']) ?></td>
                    </tr>
                    <tr>
                        <th style="background:#f8f9fa;">Evaluator</th>
                        <td><?= htmlspecialchars($record['evaluator_name']) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="two-column">
            <div class="col-left">
                <div class="section-title">Assessment Summary</div>
                <table class="info-table">
                    <tr>
                        <th>Regularity in Checking</th>
                        <td><?= htmlspecialchars($record['regularity_checking']) ?></td>
                    </tr>
                    <tr>
                        <th>Accuracy</th>
                        <td><?= htmlspecialchars($record['accuracy']) ?></td>
                    </tr>
                    <tr>
                        <th>Neatness</th>
                        <td><?= htmlspecialchars($record['neatness']) ?></td>
                    </tr>
                    <tr>
                        <th>Follow-up of Corrections</th>
                        <td><?= htmlspecialchars($record['follow_up']) ?></td>
                    </tr>
                    <tr>
                        <th>Overall Rating</th>
                        <td><?= htmlspecialchars($record['overall_rating']) ?></td>
                    </tr>
                </table>
            </div>

            <div class="col-right">
                <div class="section-title">Students Reviewed</div>
                <div class="remarks"><?= nl2br(htmlspecialchars($record['students_reviewed'])) ?></div>
            </div>
        </div>

        <div style="margin-top:8px;">
            <div class="section-title">Remarks</div>
            <div class="remarks"><?= nl2br(htmlspecialchars($record['remarks'])) ?></div>
        </div>

        <div class="sign">
            <div class="by">Prepared by: <?= htmlspecialchars($record['evaluator_name']) ?></div>
            <div style="text-align:center;">
                <div style="height:36px;"></div>
                <div style="border-top:1px solid #ddd; padding-top:4px; font-size:12px; color:#6c757d;">Signature</div>
            </div>
        </div>

        <!-- <div class="print-footer">
            Printed on <?= date('d M Y, H:i') ?> · Record ID: <?= htmlspecialchars($record['id']) ?>
        </div> -->

        <div class="no-print" style="margin-top:8px;">
            <a href="list_notebook.php" class="btn btn-secondary btn-sm">Back to list</a>
            <button onclick="window.print()" class="btn btn-primary btn-sm">Print</button>
        </div>

    </div>
</body>

</html>