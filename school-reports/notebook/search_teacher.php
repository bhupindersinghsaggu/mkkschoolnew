<?php
include '../auth.php';
include '../config/db.php';

header('Content-Type: application/json');

$term = isset($_GET['term']) ? $_GET['term'] : '';

$data = [];

if ($term !== '') {
    $stmt = $conn->prepare("SELECT teacher_id, teacher_name FROM teachers WHERE teacher_name LIKE ? ORDER BY teacher_name ASC");
    $searchTerm = "%{$term}%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id" => $row['teacher_id'],
            "text" => $row['teacher_name'],
            "name" => $row['teacher_name']
        ];
    }
}

echo json_encode(['results' => $data]);
