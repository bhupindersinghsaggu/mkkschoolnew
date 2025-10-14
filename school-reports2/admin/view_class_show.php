<?php
// admin/class_show/print_single_class_show.php
// A4-friendly, fancy class-show report with logo & teacher photo
require_once '../config.php';
require_once '../auth.php';
require_once '../database.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header('Location: /mkkschool-new/login.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection();

// Adjust if your project is in a subfolder
$PROJECT_FOLDER = '/mkkschool-new';

// get id
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid record ID.");
}

// fetch record
try {
    $stmt = $conn->prepare("SELECT * FROM class_show WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$record) die("Record not found.");
} catch (PDOException $e) {
    error_log("Fetch class_show print error: " . $e->getMessage());
    die("Database error.");
}

// get teacher photo if possible
$teacher_photo_rel = '';
if (!empty($record['teacher_id'])) {
    try {
        $u = $conn->prepare("SELECT profile_picture, subject, fullname FROM users WHERE teacher_id = :tid LIMIT 1");
        $u->execute([':tid' => $record['teacher_id']]);
        $urow = $u->fetch(PDO::FETCH_ASSOC);
        if ($urow) {
            if (!empty($urow['profile_picture'])) $teacher_photo_rel = $urow['profile_picture'];
            // if subject or fullname stored in users prefer them
            if (empty($record['subject']) && !empty($urow['subject'])) $record['subject'] = $urow['subject'];
            if (empty($record['teacher_name']) && !empty($urow['fullname'])) $record['teacher_name'] = $urow['fullname'];
        }
    } catch (PDOException $e) {
        error_log("Lookup teacher photo error: " . $e->getMessage());
    }
}

$defaultAvatarWeb = $PROJECT_FOLDER . '/assets/images/default-avatar.png';
$logoWeb = $PROJECT_FOLDER . '/assets/images/logo-light.png'; // adjust to your logo

// resolve teacher photo to web path
$teacherPhotoWeb = $defaultAvatarWeb;
if (!empty($teacher_photo_rel)) {
    $candidateRel = ltrim($teacher_photo_rel, '/');
    $candidateServer = $_SERVER['DOCUMENT_ROOT'] . $PROJECT_FOLDER . '/' . $candidateRel;
    $candidateWeb = $PROJECT_FOLDER . '/' . $candidateRel;
    if (file_exists($candidateServer)) {
        $teacherPhotoWeb = $candidateWeb;
    } else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $teacher_photo_rel)) {
            $teacherPhotoWeb = $teacher_photo_rel;
        }
    }
}

function e($v)
{
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

// compute judges average if present
$marks1 = is_numeric($record['marks_judge1']) ? (float)$record['marks_judge1'] : null;
$marks2 = is_numeric($record['marks_judge2']) ? (float)$record['marks_judge2'] : null;
$avgMarks = null;
if ($marks1 !== null && $marks2 !== null) {
    $avgMarks = round(($marks1 + $marks2) / 2, 2);
}

// compute total if not present (server authoritative)
$total = $record['total'];
if ($total === null || $total === '') {
    $fields = ['prayer', 'news', 'participation', 'speeches', 'poem_recitation', 'dance', 'song', 'stage_management', 'innovation', 'skit', 'ppt', 'anchoring'];
    $sum = 0;
    foreach ($fields as $f) {
        $sum += (is_numeric($record[$f]) ? (float)$record[$f] : 0);
    }
    $total = round($sum, 2);
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Class Show Report #<?= e($record['id']) ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php include '../includes/css.php'; ?>
    <style>
        /* A4 Page sizing for print */
        @page {
            size: A4;
            margin: 18mm;
        }

        body {
            background: #f6f7fb;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            color: #222;
        }

        .paper {
            width: 210mm;
            max-width: 900px;
            margin: 18px auto;
            background: #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 18px;
            border-radius: 6px;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 18px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 12px;
        }

        .logo {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .school-info h1 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 0.6px;
        }

        .school-info p {
            margin: 2px 0;
            color: #6c757d;
            font-size: 13px;
        }

        .meta {
            margin-top: 12px;
            display: flex;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
        }

        .teacher {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .teacher-photo {
            width: 120px;
            height: 120px;
            border-radius: 6px;
            overflow: hidden;
            border: 2px solid #f1f3f5;
            background: #fff;
        }

        .teacher-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .info {
            flex: 1;
        }

        .info .big {
            font-weight: 700;
            font-size: 18px;
        }

        .info .sub {
            color: #6c757d;
            margin-top: 6px;
        }

        .right-box {
            width: 300px;
        }

        .score-table,
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .score-table th,
        .score-table td {
            padding: 8px 10px;
            border: 1px solid #eee;
            text-align: left;
        }

        .score-table th {
            background: #f8f9fa;
            width: 55%;
        }

        .summary {
            display: flex;
            gap: 12px;
            margin-top: 12px;
        }

        .card {
            flex: 1;
            border: 1px solid #f1f3f5;

            border-radius: 6px;
            background: #fbfbfb;
        }

        .section-title {
            color: #0d6efd;
            font-weight: 700;
            margin-top: 6px;
            margin-bottom: 6px;
        }

        .remarks {
            border: 1px dashed #e9ecef;
            padding: 10px;
            min-height: 90px;
            background: #fff;
            white-space: pre-wrap;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
            gap: 12px;
        }

        .sig {
            text-align: center;
            width: 45%;
        }

        .sig .line {
            border-top: 1px solid #999;
            margin-top: 36px;
            padding-top: 6px;
            color: #333;
        }

        .actions {
            margin-top: 12px;
            text-align: right;
        }

        .no-print {
            display: block;
        }

        @media print {
            body {
                background: #fff;
            }

            .paper {
                box-shadow: none;
                margin: 0;
                border-radius: 0;
                width: 100%;
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print actions">
        <a href="edit_class_show.php?id=<?= urlencode($record['id']) ?>" class="btn btn-warning">Edit</a>
        <a href="list_class_show.php" class="btn btn-secondary">Back to list</a>
        <button onclick="window.print()" class="btn btn-primary">Print / Save PDF</button>
    </div>
    <div class="paper" role="main">
        <div class="header">
            <div class="logo"><img src="<?= e($teacherPhotoWeb) ?>" alt="School logo"></div>
            <div class="school-info">
                <h1><?= e($record['teacher_name']) ?></h1>
                <p><?= e($record['teacher_id']) ?></p>
                <div class="section-title ">Class Show Report</div>
            </div>
            <div style="margin-left:auto; text-align:right;">
                <h1>Dr. M.K.K. Arya Model School</h1>
                <div style="color:#6c757d; margin-top:6px;">Model Town, Panipat</div>
            </div>
        </div>
        <div class="row">
            <div class="card-header d-flex justify-content-center mt-2 mb-2">
                <h3 class="card-title">Basic Information</h3>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="table-responsive ">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th width="40%">Session</th>
                                    <td><?= e($record['session']) ?></td>
                                </tr>
                                <tr>
                                    <th>Class Show Date</th>
                                    <td><?= e($record['eval_date']) ?></td>
                                </tr>
                                <tr>
                                    <th>Class/Section</th>
                                    <td><?= e($record['class_section']) ?></td>
                                </tr>
                                <tr>
                                    <th>Topic</th>
                                    <td><?= e($record['topic']) ?></td>
                                </tr>
                                <tr>
                                    <th>Video Link</th>
                                    <td><a href="<?= e($record['video_link']) ?>" target="_blank" title="Watch Video">
                                            View Video <i class="fas fa-external-link-alt"></i>
                                        </a></td>
                                </tr>
                                <tr>
                                    <th>Judges</th>
                                    <td>Meera Marwaha, Anjali Dewan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th>Marks By Judge 1</th>
                                    <td><?= $marks1 !== null ? e($marks1) : '-' ?></td>
                                </tr>
                                <tr>
                                    <th>Marks By Judge 2</th>
                                    <td><?= $marks2 !== null ? e($marks2) : '-' ?></td>
                                </tr>
                                <tr>
                                    <th>Average Marks</th>
                                    <td><?= $avgMarks !== null ? e($avgMarks) : '-' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <h3 class="card-title text-center">Score & Assessment </h3>
                <div class="col-md-12">
                    <div class="section-title">Detailed Activity Scores</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th>Activity</th>
                                        <th>Score</th>
                                    </tr>
                                    <tr>
                                        <td>Prayer (03)</td>
                                        <td><?= e($record['prayer']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>News (2)</td>
                                        <td><?= e($record['news']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Participation (3)</td>
                                        <td><?= e($record['participation']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Speeches</td>
                                        <td><?= e($record['speeches']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Poem Recitation</td>
                                        <td><?= e($record['poem_recitation']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Group Dance</td>
                                        <td><?= e($record['dance']) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <td>Group Song</td>
                                        <td><?= e($record['song']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Stage Management</td>
                                        <td><?= e($record['stage_management']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Innovation</td>
                                        <td><?= e($record['innovation']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Skit</td>
                                        <td><?= e($record['skit']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>PPT</td>
                                        <td><?= e($record['ppt']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Anchoring</td>
                                        <td><?= e($record['anchoring']) ?></td>
                                    </tr>
                                    <tr style="background:#f8f9fa; font-weight:700;">
                                        <td>Total</td>
                                        <td><?= e($total) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="section-title">Skills Assessment (Students)</div>
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <td>Speaking Skills (Students):</td>
                                    <td><?= e($record['speaking_skills']) ?></td>
                                </tr>
                                <tr>
                                    <td>Dancing Skills (Students) </td>
                                    <td><?= e($record['dancing_skills']) ?></td>
                                </tr>
                                <tr>
                                    <td>Singing Skills (Students) </td>
                                    <td><?= e($record['singing_skills']) ?></td>
                                </tr>
                                <tr>
                                    <td>Dramatic Skills (Students) </td>
                                    <td><?= e($record['dramatic_skills']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <h3 class="card-title text-center">Comments & Suggestions </h3>
                        <div class="col-md-12">
                            <div class="section-title mb-2">Judge 1</div>
                            <div class="remarks"><?= nl2br(e($record['comments1'])) ?></div>
                        </div>
                        <div class="col-md-12">
                            <div class="section-title mb-2">Judge 2</div>
                            <div class="remarks"><?= nl2br(e($record['comments2'])) ?></div>
                        </div>
                    </div>
                    <!-- <div class="signatures">
            <div class="sig">
                <div class="line">Checked by</div>
            </div>
            <div class="sig">
                <div class="line">Principal / Head</div>
            </div>
        </div> -->
                </div>
</body>

</html>

<!-- <th width="40%"><img src="<?= e($teacherPhotoWeb) ?>" alt="AARTI KAPOOR" class="teacher-photo" onerror="this.onerror=null; this.src='../assets/img/default-teacher.png'"> -->