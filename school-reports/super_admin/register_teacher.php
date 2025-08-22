<?php
ob_start(); // Start output buffering
require_once '../config/database.php';
require_once '../includes/header.php';
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $teacher_name = mysqli_real_escape_string($conn, $_POST['teacher_name']);
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $teacher_type = mysqli_real_escape_string($conn, $_POST['teacher_type']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Validate inputs
    if (empty($teacher_name)) $errors['teacher_name'] = 'Teacher name is required';
    if (empty($teacher_id)) $errors['teacher_id'] = 'Teacher ID is required';
    if (empty($subject)) $errors['subject'] = 'Subject is required';
    if (empty($teacher_type)) $errors['teacher_type'] = 'Teacher type is required';
    if (empty($username)) $errors['username'] = 'Username is required';
    if (empty($password)) $errors['password'] = 'Password is required';
    if ($password !== $confirm_password) $errors['confirm_password'] = 'Passwords do not match';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Valid email is required';

    // Handle file upload
    $profile_pic = null;
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $upload_dir = '../uploads/profile_pics/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $profile_pic = 'teacher_' . time() . '.' . $ext;
            $destination = $upload_dir . $profile_pic;

            if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $destination)) {
                $errors['profile_pic'] = 'Failed to upload profile picture';
            }
        } else {
            $errors['profile_pic'] = 'Only JPG, JPEG, PNG files allowed';
        }
    } else {
        $errors['profile_pic'] = 'Profile picture is required';
    }

    // Check if username/email exists
    if (empty($errors)) {
        $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $errors['general'] = 'Username or email already exists';
        }
    }

    // Register teacher
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_begin_transaction($conn);

        try {
            // Insert user
            $user_sql = "INSERT INTO users (username, password, email, role) 
                         VALUES ('$username', '$hashed_password', '$email', 'teacher')";
            mysqli_query($conn, $user_sql);
            $user_id = mysqli_insert_id($conn);

            // Insert teacher details
            $teacher_sql = "INSERT INTO teacher_details (user_id, teacher_name, teacher_id, subject, teacher_type, profile_pic)
                           VALUES ($user_id, '$teacher_name', '$teacher_id', '$subject', '$teacher_type', '$profile_pic')";
            mysqli_query($conn, $teacher_sql);

            mysqli_commit($conn);
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'teacher';
            header("Location: register_success.php");
            exit();
        } catch (Exception $e) {
            mysqli_rollback($conn);
            if ($profile_pic && file_exists($destination)) {
                unlink($destination);
            }
            $errors['general'] = 'Registration failed: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link rel="apple-touch-icon" href="../assets/img/apple-touch-icon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../assets/plugins/tabler-icons/tabler-icons.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/plugins/%40simonwep/pickr/themes/nano.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <style>
        .profile-pic-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-pic-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ddd;
            display: none;
        }

        .upload-btn {
            cursor: pointer;
            display: inline-block;
            padding: 8px 15px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="content mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3>Teacher Registration</h3>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($errors['general'])): ?>
                                    <div class="alert alert-danger"><?= $errors['general'] ?></div>
                                <?php endif; ?>

                                <form method="POST" enctype="multipart/form-data">
                                    <!-- Profile Picture -->
                                    <div class="profile-pic-container">
                                        <img id="profilePreview" class="profile-pic-preview" src="#" alt="Profile Preview">
                                        <input type="file" id="profile_pic" name="profile_pic" accept="image/*" class="d-none" required>
                                        <label for="profile_pic" class="upload-btn">
                                            <i class="bi bi-camera"></i> Upload Profile Picture
                                        </label>
                                        <?php if (!empty($errors['profile_pic'])): ?>
                                            <div class="text-danger"><?= $errors['profile_pic'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Teacher Information -->
                                    <div class="mb-3">
                                        <label class="form-label">Teacher Name</label>
                                        <input type="text" name="teacher_name" class="form-control <?= !empty($errors['teacher_name']) ? 'is-invalid' : '' ?>"
                                            value="<?= htmlspecialchars($_POST['teacher_name'] ?? '') ?>" required>
                                        <?php if (!empty($errors['teacher_name'])): ?>
                                            <div class="invalid-feedback"><?= $errors['teacher_name'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Teacher ID</label>
                                        <input type="text" name="teacher_id" class="form-control <?= !empty($errors['teacher_id']) ? 'is-invalid' : '' ?>"
                                            value="<?= htmlspecialchars($_POST['teacher_id'] ?? '') ?>" required>
                                        <?php if (!empty($errors['teacher_id'])): ?>
                                            <div class="invalid-feedback"><?= $errors['teacher_id'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Subject</label>
                                        <input type="text" name="subject" class="form-control <?= !empty($errors['subject']) ? 'is-invalid' : '' ?>"
                                            value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>" required>
                                        <?php if (!empty($errors['subject'])): ?>
                                            <div class="invalid-feedback"><?= $errors['subject'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Teacher Type</label>
                                        <select name="teacher_type" class="form-select <?= !empty($errors['teacher_type']) ? 'is-invalid' : '' ?>" required>
                                            <option value="">Select Type</option>
                                            <option value="PPRT" <?= ($_POST['teacher_type'] ?? '') === 'PPRT' ? 'selected' : '' ?>>PPRT</option>
                                            <option value="PRT" <?= ($_POST['teacher_type'] ?? '') === 'PRT' ? 'selected' : '' ?>>PRT</option>
                                            <option value="PGT" <?= ($_POST['teacher_type'] ?? '') === 'PGT' ? 'selected' : '' ?>>PGT</option>
                                            <option value="TGT" <?= ($_POST['teacher_type'] ?? '') === 'TGT' ? 'selected' : '' ?>>TGT</option>
                                        </select>
                                        <?php if (!empty($errors['teacher_type'])): ?>
                                            <div class="invalid-feedback"><?= $errors['teacher_type'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Account Information -->
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control <?= !empty($errors['username']) ? 'is-invalid' : '' ?>"
                                            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                                        <?php if (!empty($errors['username'])): ?>
                                            <div class="invalid-feedback"><?= $errors['username'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>"
                                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                                        <?php if (!empty($errors['email'])): ?>
                                            <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>" required>
                                        <?php if (!empty($errors['password'])): ?>
                                            <div class="invalid-feedback"><?= $errors['password'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control <?= !empty($errors['confirm_password']) ? 'is-invalid' : '' ?>" required>
                                        <?php if (!empty($errors['confirm_password'])): ?>
                                            <div class="invalid-feedback"><?= $errors['confirm_password'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Profile picture preview
                document.getElementById('profile_pic').addEventListener('change', function(e) {
                    const preview = document.getElementById('profilePreview');
                    const file = e.target.files[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            </script>
        </div>
    </div>
</body>

</html>
<?php
ob_end_flush(); // Send the output
?>