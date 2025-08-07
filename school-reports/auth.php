<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

?>