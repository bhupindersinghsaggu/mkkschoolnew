<?php
require '../config/db.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=notebook_records.xls");

echo "Session\tDate\tTeacher\tSubject\tClass\tChecked\tReviewed\tRegularity\tAccuracy\tNeatness\tFollow-Up\tRating\tEvaluator\tRemarks\tUndertaking\n";

$result = mysqli_query($conn, "SELECT * FROM records");
while ($row = mysqli_fetch_assoc($result)) {
    echo "{$row['session']}\t{$row['eval_date']}\t{$row['teacher_name']}\t{$row['subject']}\t{$row['class_section']}\t{$row['notebooks_checked']}\t{$row['students_reviewed']}\t{$row['regularity_checking']}\t{$row['accuracy']}\t{$row['neatness']}\t{$row['follow_up']}\t{$row['overall_rating']}\t{$row['evaluator_name']}\t{$row['remarks']}\t" . ($row['undertaking'] ? 'Yes' : 'No') . "\n";
}
