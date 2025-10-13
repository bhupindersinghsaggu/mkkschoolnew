<?php
// admin/teachers/print_notebook_pdf.php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../auth.php';
require_once __DIR__ . '/../../database.php';

// Require autoloader from Composer (dompdf)
require_once __DIR__ . '/../../vendor/autoload.php'; // composer path

use Dompdf\Dompdf;
use Dompdf\Options;

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header('Location: /mkkschool-new/login.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$PROJECT_FOLDER = '/mkkschool-new';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) die("Invalid ID.");

// Fetch record
try {
    $stmt = $conn->prepare("SELECT * FROM records WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$record) die("Record not found.");
} catch (PDOException $e) {
    error_log($e->getMessage());
    die("DB error.");
}

// Fetch teacher photo path same as preview
$profile_picture = '';
if (!empty($record['teacher_id'])) {
    try {
        $u = $conn->prepare("SELECT profile_picture FROM users WHERE teacher_id = :tid LIMIT 1");
        $u->bindParam(':tid', $record['teacher_id'], PDO::PARAM_STR);
        $u->execute();
        $userRow = $u->fetch(PDO::FETCH_ASSOC);
        if ($userRow && !empty($userRow['profile_picture'])) $profile_picture = $userRow['profile_picture'];
    } catch (PDOException $e) {
        error_log($e->getMessage());
    }
}

$defaultAvatarWeb = $PROJECT_FOLDER . '/assets/images/default-avatar.png';
$logoWeb = $PROJECT_FOLDER . '/assets/images/logo-light.png';
$teacherPhotoWeb = $defaultAvatarWeb;

if (!empty($profile_picture)) {
    $candidateRel = ltrim($profile_picture, '/');
    // Dompdf prefers absolute URLs for images; build absolute URL
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $maybeUrl = $scheme . '://' . $host . $PROJECT_FOLDER . '/' . $candidateRel;
    $maybeServer = $_SERVER['DOCUMENT_ROOT'] . $PROJECT_FOLDER . '/' . $candidateRel;
    if (file_exists($maybeServer)) $teacherPhotoWeb = $maybeUrl;
    else {
        // fallback to default absolute logo
        $teacherPhotoWeb = $scheme . '://' . $host . $defaultAvatarWeb;
    }
} else {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $teacherPhotoWeb = $scheme . '://' . $host . $defaultAvatarWeb;
}

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$logoWebAbs = $scheme . '://' . $host . $logoWeb;

// Build HTML for PDF (keep inline styles for Dompdf)
$html = '<!doctype html><html><head><meta charset="utf-8"><title>Notebook #' . htmlspecialchars($record['id']) . '</title>';
$html .= '<style>
    @page { size: A4 portrait; margin:10mm; }
    body{ font-family: DejaVu Sans, Arial, sans-serif; font-size:12px; color:#222; }
    .header{ display:flex; align-items:center; gap:12px; border-bottom:1px solid #eee; padding-bottom:8px; margin-bottom:8px; }
    .logo img{ width:64px; height:auto; }
    .teacher-photo img{ width:88px; height:88px; object-fit:cover; border:1px solid #eee; }
    table { width:100%; border-collapse:collapse; }
    td, th { padding:6px; border:1px solid #eee; vertical-align:top; }
    .remarks { border:1px dashed #eee; padding:8px; background:#fafafa; white-space:pre-wrap; }
    .section-title{ color:#0d6efd; font-weight:700; margin-top:8px; margin-bottom:6px; }
    </style></head><body>';

$html .= '<div class="header"><div class="logo"><img src="' . htmlspecialchars($logoWebAbs) . '"></div>';
$html .= '<div><div style="font-weight:700;font-size:16px;">Dr. M.K.K. Arya Model School</div><div style="color:#666;font-size:12px;">Notebook Correction Report</div></div>';
$html .= '<div style="margin-left:auto;text-align:right;"><div style="font-weight:600">Report #: ' . htmlspecialchars($record['id']) . '</div><div style="color:#666;font-size:12px;">Date: ' . htmlspecialchars(date('d M Y', strtotime($record['eval_date']))) . '</div></div></div>';

$html .= '<div style="display:flex; gap:12px;"><div style="flex:0 0 100px;"><img src="' . htmlspecialchars($teacherPhotoWeb) . '" style="width:88px;height:88px;object-fit:cover;border:1px solid #eee;"></div>';
$html .= '<div style="flex:1;"><div style="font-weight:700;font-size:14px;">' . htmlspecialchars($record['teacher_name']) . '</div>';
$html .= '<div style="color:#666;">Teacher ID: ' . htmlspecialchars($record['teacher_id']) . ' | Subject: ' . htmlspecialchars($record['subject']) . '</div>';
$html .= '<table style="margin-top:8px;"><tr><th>Session</th><td>' . htmlspecialchars($record['session']) . '</td></tr>';
$html .= '<tr><th>Class/Section</th><td>' . htmlspecialchars($record['class_section']) . '</td></tr>';
$html .= '<tr><th>Notebooks Checked</th><td>' . htmlspecialchars($record['notebooks_checked']) . '</td></tr></table></div></div>';

$html .= '<div class="section-title">Assessment Summary</div><table><tr><th>Regularity</th><td>' . htmlspecialchars($record['regularity_checking']) . '</td></tr>';
$html .= '<tr><th>Accuracy</th><td>' . htmlspecialchars($record['accuracy']) . '</td></tr>';
$html .= '<tr><th>Neatness</th><td>' . htmlspecialchars($record['neatness']) . '</td></tr>';
$html .= '<tr><th>Follow-up</th><td>' . htmlspecialchars($record['follow_up']) . '</td></tr>';
$html .= '<tr><th>Overall</th><td>' . htmlspecialchars($record['overall_rating']) . '</td></tr></table>';

$html .= '<div class="section-title">Students Reviewed</div><div class="remarks">' . nl2br(htmlspecialchars($record['students_reviewed'])) . '</div>';
$html .= '<div class="section-title">Remarks</div><div class="remarks">' . nl2br(htmlspecialchars($record['remarks'])) . '</div>';

$html .= '<div style="margin-top:10px;color:#666;font-size:11px;">Prepared by: ' . htmlspecialchars($record['evaluator_name']) . '</div>';
$html .= '</body></html>';

// Configure Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true); // allow remote images (absolute URLs)
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Send PDF to browser (download)
$filename = 'Notebook_Report_' . $record['id'] . '.pdf';
$dompdf->stream($filename, ['Attachment' => 1]);
exit;
