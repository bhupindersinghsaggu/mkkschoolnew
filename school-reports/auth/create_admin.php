<?php
// TEMPORARY ADMIN CREATION SCRIPT
// RUN ONCE THEN DELETE IMMEDIATELY
error_reporting(E_ALL);
ini_set('display_errors', 1);
// 1. Include your database connection
require_once('../config/database.php');

// 2. SET YOUR CUSTOM CREDENTIALS HERE
$username = "admin";          // Change if needed
$password = "Mkk@2019"; // CHANGE THIS TO YOUR STRONG PASSWORD

// 3. Hash the password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 4. Insert into database
$stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    // 5. DISPLAY CREDENTIALS ONCE (then never store them)
    echo "<h1>Admin User Created</h1>";
    echo "<p>Username: <strong>$username</strong></p>";
    echo "<p>Password: <strong>$password</strong></p>"; 
    echo "<p style='color:red'>DELETE THIS FILE IMMEDIATELY AFTER USE!</p>";
} else {
    echo "Error: " . $db->error;
}

$stmt->close();
?>