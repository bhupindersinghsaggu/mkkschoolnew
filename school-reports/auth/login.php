<?php
session_start();

require_once '../config/database.php'; // Add this line first
require_once '../config/functions.php';

// Redirect if already logged in
redirectBasedOnRole();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password";
    } else {
        // Check credentials using mysqli
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'super_admin') {
                header("Location: ../super_admin/dashboard.php");
            } else {
                header("Location: ../teacher/dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    
<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- For IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/theme-script.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/apple-touch-icon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">
    <!-- animation CSS -->
    <link rel="stylesheet" href="../assets/css/animate.css">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="../assets/plugins/tabler-icons/tabler-icons.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="../assets/plugins/%40simonwep/pickr/themes/nano.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="login-container">
        <div class="main-wrapper">
            <div class="account-content">
                <div class="login-wrapper bg-img">
                    <div class="login-content authent-content">
                        dfgfdg
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>