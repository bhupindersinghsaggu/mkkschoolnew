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


<body>
    <div class="login-container">
        <div class="main-wrapper">
            <div class="account-content">
                <div class="login-wrapper bg-img">
                    <div class="login-content authent-content">
                        <div class="login-userset">
                            <div class="login-logo logo-normal">
                                <img src="../assets/img/logo-small.png" alt="img">
                            </div>
                            <!-- <h3>Dr. M.K.K. Arya Model School</h3> -->
                            <a href="login.php" class="login-logo logo-white">
                                <img src="../assets/img/logo-white.svg" alt="Img">
                            </a>
                            <?php if (isset($error)): ?>
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
                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-mail"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password <span class="text-danger"> *</span></label>
                                    <div class="pass-group">
                                        <input type="password" name="password" class="pass-input form-control">
                                        <span class="ti toggle-password ti-eye-off text-gray-9"></span>
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
                                            <div class="text-end">
                                                <a class="text-orange fs-16 fw-medium" href="forgot-password.html">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-login">
                                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                </div>
                            </form>
                            <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                                <p>Copyright © MKK School. Developed By Bhupinder Singh (IT Department)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>