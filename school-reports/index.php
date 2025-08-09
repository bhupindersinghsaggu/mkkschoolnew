<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['role'] === 'super_admin') {
        header("Location: dashboard/super_admin.php");
    } else {
        header("Location: dashboard/teacher.php");
    }
    exit;
} else {
    header("Location: auth/login.php");
}
?>
