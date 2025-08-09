<?php
require_once '../config/database.php';

$new_password = 'new_secure_password';
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password = ? WHERE username = 'admin'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hashed_password);
$stmt->execute();

echo "Password reset to: $new_password";

?>