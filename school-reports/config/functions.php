<?php
require_once 'database.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isSuperAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'super_admin';
}

function isTeacher() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'teacher';
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: ../auth/login.php");
        exit();
    }
}

function redirectBasedOnRole() {
    if (isLoggedIn()) {
        if (isSuperAdmin()) {
            header("Location: ../super_admin/dashboard.php");
        } elseif (isTeacher()) {
            header("Location: ../teacher/dashboard.php");
        }
        exit();
    }
}
?>