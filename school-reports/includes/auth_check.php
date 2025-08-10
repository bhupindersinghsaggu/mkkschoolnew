
<?php
session_start();

function is_authenticated() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

function require_auth() {
    if (!is_authenticated()) {
        header('Location: login.php');
        exit();
    }
}

function require_admin() {
    require_auth();
    if ($_SESSION['role'] !== 'admin') {
        header('Location: ../index.php');
        exit();
    }
}
?>