<?php
// login.php - Login page
require_once 'auth.php';

$auth = new Auth();
$error = '';

// Redirect if already logged in
if ($auth->isLoggedIn()) {
    // Redirect based on user role
    $role = $_SESSION['role'];
    if ($role == ROLE_TEACHER) {
        header("Location: admin/teachers/dashboard.php");
    } elseif ($role == ROLE_ADMIN) {
        header("Location: dashboard.php");
    } elseif ($role == ROLE_SUPER_ADMIN) {
        header("Location: dashboard.php");
    }
    exit;
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if ($auth->login($username, $password)) {
        // Redirect based on user role
        $role = $_SESSION['role'];
        if ($role == ROLE_TEACHER) {
            header("Location: admin/teachers/dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MKK- Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-header">
            <img src="assets/logo.png" style="max-width: 100px;">
            <h2> Dr. M.K.K. Arya Model School</h2>
            <p>Please sign in to access your account</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="post" action="" class="login-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>
        
        <div class="login-footer">
            <p>&copy; <?php echo date('Y'); ?> Computer Center. All rights reserved.</p>
        </div>
    </div>
</body>
</html>