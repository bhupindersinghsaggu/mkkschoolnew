<?php
include '../config/db.php';

$search = $_GET['term'] ?? '';

$sql = "SELECT teacher_id, teacher_name FROM teachers WHERE teacher_name LIKE ? ORDER BY teacher_name ASC";
$stmt = mysqli_prepare($conn, $sql);
$like = "%$search%";
mysqli_stmt_bind_param($stmt, 's', $like);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        "id" => $row['teacher_id'],
        "text" => $row['teacher_name'],
        "name" => $row['teacher_name']
    ];
}

echo json_encode(["results" => $data]);
?>
