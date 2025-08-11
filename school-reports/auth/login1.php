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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M.K.K. School - Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 0 20px;
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

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to bottom right,
                    rgba(255, 255, 255, 0.3),
                    rgba(255, 255, 255, 0));
            transform: rotate(30deg);
            z-index: 1;
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% {
                transform: rotate(30deg) translate(-30%, -30%);
            }

            100% {
                transform: rotate(30deg) translate(30%, 30%);
            }
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

        .form-floating>label {
            padding: 0.5rem 0.75rem;
        }

        .floating-input {
            border-left: none;
        }

        .school-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 15px;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.2));
            animation: pulse 2s infinite alternate;
        }

        @keyframes pulse {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.05);
            }
        }

        .floating-label-group {
            position: relative;
            margin-bottom: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-container {
                margin: 0 15px;
            }

            .card-header {
                padding: 20px;
            }

            .school-logo {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container animate__animated animate__fadeIn">
        <div class="login-card card animate__animated animate__zoomIn">
            <div class="card-header">
                <img src="your-school-logo.png" alt="M.K.K. School Logo" class="school-logo animate__animated animate__bounceIn">
                <h3 class="animate__animated animate__fadeInDown">M.K.K. School</h3>
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="card-body p-4">
               <form method="POST">
                    <div class="floating-label-group mb-4 animate__animated animate__fadeInLeft">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <div class="form-floating">
                                <input type="text" class="form-control floating-input" id="username" placeholder="Username" required>
                                <label for="username">Username</label>
                            </div>
                        </div>
                    </div>

                    <div class="floating-label-group mb-4 animate__animated animate__fadeInRight">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <div class="form-floating">
                                <input type="password" class="form-control floating-input" id="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-4 animate__animated animate__fadeInUp">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <a href="#forgot-password" class="text-decoration-none">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-login text-white animate__animated animate__fadeInUp animate__delay-1s">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </button>
                </form>
            </div>
            <div class="card-footer text-center py-3 animate__animated animate__fadeInUp animate__delay-1s">
                <p class="mb-0">Don't have an account? <a href="#register" class="text-decoration-none">Contact Admin</a></p>
            </div>
        </div>
    </div>
    <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
        <p>Copyright © MKK School. Developed By Bhupinder Singh (IT Department)</p>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
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
            e.preventDefault();
            const loginBtn = document.querySelector('.btn-login');
            loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Logging in...';
            loginBtn.disabled = true;

            // Simulate login process
            setTimeout(() => {
                loginBtn.innerHTML = '<i class="fas fa-check me-2"></i> Login Successful';
                loginBtn.classList.remove('btn-primary');
                loginBtn.classList.add('btn-success');
                // Redirect after success
                setTimeout(() => {
                    window.location.href = "dashboard.php";
                }, 1000);
            }, 2000);
        });
    </script>
</body>

</html>