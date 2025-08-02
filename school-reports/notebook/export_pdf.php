<?php
require_once '../vendor/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include '../config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$id) {
    die("Invalid Record ID");
}

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

ob_start();
include 'pdf_template.php'; // separate HTML template file
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Notebook_Record_{$row['teacher_name']}.pdf", ["Attachment" => false]);
exit;
