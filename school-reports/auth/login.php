<?php
session_start();

require_once '../config/database.php';
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M.K.K. School - Login</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/apple-touch-icon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="../assets/plugins/tabler-icons/tabler-icons.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
        }
        
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transform-style: preserve-3d;
            transition: all 0.5s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }
        
        .card-header {
            background: var(--primary-color);
            color: white;
            text-align: center;
            padding: 25px;
            position: relative;
            overflow: hidden;
        }
        
        .card-header h3 {
            font-weight: 700;
            position: relative;
            z-index: 2;
        }
        
        .school-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 15px;
            filter: drop-shadow(0 2px 5px rgba(0,0,0,0.2));
            animation: pulse 2s infinite alternate;
        }
        
        @keyframes pulse {
            from { transform: scale(1); }
            to { transform: scale(1.05); }
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-login {
            background: var(--primary-color);
            border: none;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            border-radius: 8px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .btn-login:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
        }
        
        .input-group-text {
            background: transparent;
            border-right: none;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card {
                border-radius: 10px;
            }
            
            .card-header {
                padding: 20px 15px;
            }
            
            .school-logo {
                width: 60px;
                height: 60px;
            }
            
            .form-control {
                padding: 10px 12px;
            }
        }
        
        /* Error message styling */
        .alert-danger {
            animation: shake 0.5s;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
    </style>
</head>

<body>
    <div class="login-container animate__animated animate__fadeIn">
        <div class="login-card card animate__animated animate__zoomIn">
            <div class="card-header">
                <img src="../assets/img/logo-small.png" alt="M.K.K. School Logo" class="school-logo animate__animated animate__bounceIn">
                <h3 class="animate__animated animate__fadeInDown">M.K.K. School</h3>
            </div>
            <div class="card-body p-4">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger animate__animated animate__shakeX"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-4 animate__animated animate__fadeInLeft">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
                        </div>
                    </div>
                    
                    <div class="mb-4 animate__animated animate__fadeInRight">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                            <span class="input-group-text toggle-password" style="cursor: pointer;">
                                <i class="ti ti-eye-off"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4 animate__animated animate__fadeInUp">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <a href="forgot-password.html" class="text-decoration-none">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-login text-white animate__animated animate__fadeInUp animate__delay-1s">
                        <i class="ti ti-login me-2"></i> Sign In
                    </button>
                </form>
            </div>
            <div class="card-footer text-center py-3 animate__animated animate__fadeInUp animate__delay-1s">
                <p class="mb-0 small">Copyright © MKK School. Developed By Bhupinder Singh (IT Department)</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(function(icon) {
            icon.addEventListener('click', function() {
                const passwordInput = this.parentElement.querySelector('input');
                const iconElement = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    iconElement.classList.remove('ti-eye-off');
                    iconElement.classList.add('ti-eye');
                } else {
                    passwordInput.type = 'password';
                    iconElement.classList.remove('ti-eye');
                    iconElement.classList.add('ti-eye-off');
                }
            });
        });
        
        // Add animation on focus
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.classList.add('animate__pulse');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.parentElement.classList.remove('animate__pulse');
            });
        });
        
        // Form submission animation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const loginBtn = this.querySelector('button[type="submit"]');
            loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Signing in...';
            loginBtn.disabled = true;
        });
    </script>
</body>
</html>