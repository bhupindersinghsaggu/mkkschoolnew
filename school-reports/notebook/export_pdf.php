<?php
require_once '../vendor/autoload.php';
include '../config/db.php';

$mpdf = new \Mpdf\Mpdf();
$html = '<h2>Notebook Review Records</h2><table border="1"><thead><tr>
<th>Session</th><th>Date</th><th>Teacher</th><th>Subject</th><th>Class</th><th>Checked</th><th>Students</th><th>Regularity</th><th>Accuracy</th><th>Neatness</th><th>Follow-up</th><th>Rating</th><th>Evaluator</th><th>Remarks</th><th>Undertaking</th></tr></thead><tbody>';

$result = mysqli_query($conn, "SELECT * FROM records");
while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr><td>{$row['session']}</td><td>{$row['eval_date']}</td><td>{$row['teacher_name']}</td><td>{$row['subject']}</td><td>{$row['class_section']}</td><td>{$row['notebooks_checked']}</td><td>{$row['students_reviewed']}</td><td>{$row['regularity_checking']}</td><td>{$row['accuracy']}</td><td>{$row['neatness']}</td><td>{$row['follow_up']}</td><td>{$row['overall_rating']}</td><td>{$row['evaluator_name']}</td><td>{$row['remarks']}</td><td>" . ($row['undertaking'] ? 'Yes' : 'No') . "</td></tr>";
}
$html .= '</tbody></table>';

$mpdf->WriteHTML($html);
$mpdf->Output('notebook_records.pdf', 'D');
