<?php
include './config/db.php'; // update if your DB connection file is named differently

$users = [
    ['MKK003', 'MKK003'],
    ['MKK004', 'MKK004'],
    ['MKK005', 'MKK005'],
    ['MKK006', 'MKK006'],
    ['MKK009', 'MKK009'],
    // Add more here or paste the entire list
];

$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");

foreach ($users as $user) {
    $username = $user[0];
    $plain_password = $user[1];
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
    $role = 'teacher';

    $stmt->bind_param("sss", $username, $hashed_password, $role);
    $stmt->execute();
}

echo "All teacher users have been inserted successfully.";
?>
