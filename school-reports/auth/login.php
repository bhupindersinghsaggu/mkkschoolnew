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
    <style>
        /* Custom enhanced styles */
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
        }

        .container {
            max-width: 800px;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .copyright-container {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            color: #495057;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
            position: relative;
            overflow: hidden;
        }

        .copyright-container:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shine 6s infinite linear;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        .copyright-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .copyright-text {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }

        .copyright-text span {
            margin: 0 5px;
        }

        .school-name {
            color: #4361ee;
            font-weight: 700;
        }

        .developed-by {
            font-style: italic;
            color: #6c757d;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }

        .copyright-icon {
            margin-right: 10px;
            color: #4361ee;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .it-icon {
            color: #4361ee;
            margin: 0 8px;
            animation: rotate 8s infinite linear;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .divider {
            width: 80%;
            height: 1px;
            background: linear-gradient(to right, transparent, #dee2e6, transparent);
            margin: 15px 0;
        }

        .copyright-notice {
            font-size: 12px;
            color: #6c757d;
            margin-top: 10px;
        }

        .school-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {

            .copyright-text,
            .developed-by {
                flex-direction: column;
            }

            .copyright-text span,
            .developed-by span {
                margin: 3px 0;
            }
        }

        /* body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        } */

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* .login-container {
            width: 100%;
            max-width: 430px;
            margin: 0 auto;
            animation: fadeIn 0.8s ease-in-out;
        } */

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 
        .login-wrapper {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            position: relative;
        }

        .login-wrapper:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shine 6s infinite linear;
        } */

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        .login-content {
            padding: 30px;
            position: relative;
            z-index: 1;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .login-userheading {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-userheading h3 {
            color: var(--primary-color);
            font-weight: 700;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        .login-userheading h3:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 3px;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .input-group-text {
            background: transparent;
            border: 2px solid #e9ecef;
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .input-group .form-control:not(:last-child) {
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .pass-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: var(--primary-color);
        }

        .alert-danger {
            background: rgba(247, 37, 133, 0.15);
            color: var(--danger-color);
            border: none;
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            animation: shake 0.5s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .authentication-check {
            margin: 20px 0;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .copyright-text {
            margin-top: 25px;
            color: #6c757d;
            font-size: 14px;
            text-align: center;
        }

        /* Floating animation for form elements */
        .form-group {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 575px) {
            .login-container {
                padding: 0 15px;
            }

            .login-content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="main-wrapper">
            <div class="account-content">
                <div class="login-wrapper bg-img">
                    <div class="login-content authent-content">
                        <div class="login-userset">
                            <!-- <div class="login-logo logo-normal">
                                <img src="../assets/img/logo-small.png" alt="img" style="max-width: 100px;">
                            </div> -->
                            <!-- <h3>Dr. M.K.K. Arya Model School</h3> -->
                            <a href="login.php" class="login-logo logo-white">
                                <img src="../assets/img/logo-white.svg" alt="Img">
                            </a> <?php if (isset($error)): ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>
                            <form method="POST">
                                <div class="login-userheading">
                                    <h3>Sign In</h3>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Username <span class="text-danger"> *</span></label>
                                    <div class="input-group">
                                        <input type="text" name="username" value="" class="form-control border-end-0">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password <span class="text-danger"> *</span></label>
                                    <div class="pass-group">
                                        <input type="password" name="password" class="pass-input form-control">
                                    </div>
                                </div>
                                <div class="form-login authentication-check">
                                    <div class="row">
                                        <div class="col-12 d-flex align-items-center justify-content-between">
                                            <div class="custom-control custom-checkbox">
                                                <label class="checkboxs ps-4 mb-0 pb-0 line-height-1 fs-16 text-gray-6">
                                                    <input type="checkbox" class="form-control">
                                                    <span class="checkmarks"></span>Remember me
                                                </label>
                                            </div>
                                            <!-- <div class="text-end">
                                                <a class="text-orange fs-16 fw-medium" href="forgot-password.html">Forgot Password?</a>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-login">
                                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                </div>
                            </form>
                            <div class="container">
                                <div class="copyright-container">
                                    <div class="copyright-content">
                                        <div class="school-logo">
                                            <i class="fas fa-school"></i>
                                        </div>

                                        <div class="copyright-text">
                                            <i class="far fa-copyright copyright-icon"></i>
                                            <span>All Rights Reserved Copyright By</span>
                                            <span class="school-name">Dr. M.K.K. Arya Model School</span>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="developed-by">
                                            <span>Developed By</span>
                                            <i class="fas fa-laptop-code it-icon"></i>
                                            <span>Bhupinder Singh (IT Department)</span>
                                        </div>

                                        <div class="copyright-notice">
                                            <p>© 2023 Dr. M.K.K. Arya Model School. All rights reserved.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                // Simple animation control
                                document.addEventListener('DOMContentLoaded', function() {
                                    const copyrightElements = document.querySelectorAll('.copyright-text, .developed-by');

                                    copyrightElements.forEach((element, index) => {
                                        setTimeout(() => {
                                            element.style.opacity = '1';
                                            element.style.transform = 'translateY(0)';
                                        }, index * 300);
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>