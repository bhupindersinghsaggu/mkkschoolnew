<?php
ob_start(); // Start output buffering
require_once '../config/database.php';
require_once '../includes/header.php';
session_start();



// Get teacher ID from URL
$teacher_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch teacher data
$teacher = [];
if ($teacher_id > 0) {
    $query = "SELECT td.*, u.username, u.email 
              FROM teacher_details td
              JOIN users u ON td.user_id = u.id
              WHERE td.id = $teacher_id";
    $result = mysqli_query($conn, $query);
    $teacher = mysqli_fetch_assoc($result);

    if (!$teacher) {
        $_SESSION['error'] = "Teacher not found";
        header('Location: list_teacher.php');
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid teacher ID";
    header('Location: list_teacher.php');
    exit();
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $teacher_name = mysqli_real_escape_string($conn, $_POST['teacher_name']);
    $teacher_id_num = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $teacher_type = mysqli_real_escape_string($conn, $_POST['teacher_type']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($teacher_name)) $errors['teacher_name'] = 'Teacher name is required';
    if (empty($teacher_id_num)) $errors['teacher_id'] = 'Teacher ID is required';
    if (empty($subject)) $errors['subject'] = 'Subject is required';
    if (empty($teacher_type)) $errors['teacher_type'] = 'Teacher type is required';
    if (empty($username)) $errors['username'] = 'Username is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Valid email is required';

    // Only validate passwords if they're provided
    if (!empty($password)) {
        if ($password !== $confirm_password) $errors['confirm_password'] = 'Passwords do not match';
    }

    // Handle file upload
    $profile_pic = $teacher['profile_pic'];
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $upload_dir = '../uploads/profile_pics/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Delete old profile picture if exists
            if ($profile_pic && file_exists($upload_dir . $profile_pic)) {
                unlink($upload_dir . $profile_pic);
            }

            $profile_pic = 'teacher_' . time() . '.' . $ext;
            $destination = $upload_dir . $profile_pic;

            if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $destination)) {
                $errors['profile_pic'] = 'Failed to upload profile picture';
            }
        } else {
            $errors['profile_pic'] = 'Only JPG, JPEG, PNG files allowed';
        }
    }

    // Check if username/email exists (excluding current teacher)
    if (empty($errors)) {
        $check = mysqli_query($conn, "SELECT id FROM users 
                                     WHERE (username='$username' OR email='$email') 
                                     AND id != {$teacher['user_id']}");
        if (mysqli_num_rows($check) > 0) {
            $errors['general'] = 'Username or email already exists';
        }
    }

    // Update teacher
    if (empty($errors)) {
        mysqli_begin_transaction($conn);

        try {
            // Update user
            $user_sql = "UPDATE users SET 
                        username = '$username', 
                        email = '$email'";

            // Only update password if provided
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $user_sql .= ", password = '$hashed_password'";
            }

            $user_sql .= " WHERE id = {$teacher['user_id']}";
            mysqli_query($conn, $user_sql);

            // Update teacher details
            $teacher_sql = "UPDATE teacher_details SET
                           teacher_name = '$teacher_name',
                           teacher_id = '$teacher_id_num',
                           subject = '$subject',
                           teacher_type = '$teacher_type',
                           profile_pic = '$profile_pic'
                           WHERE id = $teacher_id";
            mysqli_query($conn, $teacher_sql);

            mysqli_commit($conn);
            $_SESSION['success'] = "Teacher updated successfully";
            header("Location: list_teacher.php");
            exit();
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $errors['general'] = 'Update failed: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
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
            display: flex;
            flex-direction: column;
            justify-items: center;
            align-items: center;
        }

        .profile-pic-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ddd;
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
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h3>Edit Teacher</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($errors['general'])): ?>
                                <div class="alert alert-danger"><?= $errors['general'] ?></div>
                            <?php endif; ?>

                            <form method="POST" enctype="multipart/form-data">
                                <!-- Profile Picture -->
                                <div class="profile-pic-container">
                                    <?php if ($teacher['profile_pic']): ?>
                                        <img id="profilePreview" class="profile-pic-preview"
                                            src="../uploads/profile_pics/<?= htmlspecialchars($teacher['profile_pic']) ?>"
                                            alt="Profile Preview">
                                    <?php else: ?>
                                        <img id="profilePreview" class="profile-pic-preview"
                                            src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='150' viewBox='0 0 150 150'%3E%3Crect width='150' height='150' fill='%23dee2e6'/%3E%3Ctext x='50%' y='50%' fill='%236c757d' font-family='sans-serif' font-size='16' text-anchor='middle' dominant-baseline='middle'%3ENo Image%3C/text%3E%3C/svg%3E"
                                            alt="Profile Preview">
                                    <?php endif; ?>
                                    <input type="file" id="profile_pic" name="profile_pic" accept="image/*" class="d-none">
                                    <label for="profile_pic" class="upload-btn mt-2">
                                        <i class="bi bi-camera"></i> Change Photo
                                    </label>
                                    <?php if (!empty($errors['profile_pic'])): ?>
                                        <div class="text-danger"><?= $errors['profile_pic'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Teacher Information -->
                                <div class="mb-3">
                                    <label class="form-label">Teacher Name</label>
                                    <input type="text" name="teacher_name" class="form-control <?= !empty($errors['teacher_name']) ? 'is-invalid' : '' ?>"
                                        value="<?= htmlspecialchars($teacher['teacher_name'] ?? ($_POST['teacher_name'] ?? '')) ?>" required>
                                    <?php if (!empty($errors['teacher_name'])): ?>
                                        <div class="invalid-feedback"><?= $errors['teacher_name'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Teacher ID</label>
                                    <input type="text" name="teacher_id" class="form-control <?= !empty($errors['teacher_id']) ? 'is-invalid' : '' ?>"
                                        value="<?= htmlspecialchars($teacher['teacher_id'] ?? ($_POST['teacher_id'] ?? '')) ?>" required>
                                    <?php if (!empty($errors['teacher_id'])): ?>
                                        <div class="invalid-feedback"><?= $errors['teacher_id'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Subject</label>
                                    <input type="text" name="subject" class="form-control <?= !empty($errors['subject']) ? 'is-invalid' : '' ?>"
                                        value="<?= htmlspecialchars($teacher['subject'] ?? ($_POST['subject'] ?? '')) ?>" required>
                                    <?php if (!empty($errors['subject'])): ?>
                                        <div class="invalid-feedback"><?= $errors['subject'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Teacher Type</label>
                                    <select name="teacher_type" class="form-select <?= !empty($errors['teacher_type']) ? 'is-invalid' : '' ?>" required>
                                        <option value="">Select Type</option>
                                        <option value="PPRT" <?= ($teacher['teacher_type'] ?? ($_POST['teacher_type'] ?? '')) === 'PPRT' ? 'selected' : '' ?>>PPRT</option>
                                        <option value="PRT" <?= ($teacher['teacher_type'] ?? ($_POST['teacher_type'] ?? '')) === 'PRT' ? 'selected' : '' ?>>PRT</option>
                                        <option value="PGT" <?= ($teacher['teacher_type'] ?? ($_POST['teacher_type'] ?? '')) === 'PGT' ? 'selected' : '' ?>>PGT</option>
                                        <option value="TGT" <?= ($teacher['teacher_type'] ?? ($_POST['teacher_type'] ?? '')) === 'TGT' ? 'selected' : '' ?>>TGT</option>
                                    </select>
                                    <?php if (!empty($errors['teacher_type'])): ?>
                                        <div class="invalid-feedback"><?= $errors['teacher_type'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Account Information -->
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control <?= !empty($errors['username']) ? 'is-invalid' : '' ?>"
                                        value="<?= htmlspecialchars($teacher['username'] ?? ($_POST['username'] ?? '')) ?>" required>
                                    <?php if (!empty($errors['username'])): ?>
                                        <div class="invalid-feedback"><?= $errors['username'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>"
                                        value="<?= htmlspecialchars($teacher['email'] ?? ($_POST['email'] ?? '')) ?>" required>
                                    <?php if (!empty($errors['email'])): ?>
                                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password (leave blank to keep current)</label>
                                    <input type="password" name="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>">
                                    <?php if (!empty($errors['password'])): ?>
                                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control <?= !empty($errors['confirm_password']) ? 'is-invalid' : '' ?>">
                                    <?php if (!empty($errors['confirm_password'])): ?>
                                        <div class="invalid-feedback"><?= $errors['confirm_password'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success">Update Teacher</button>
                                    <a href="list_teacher.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Profile picture preview
            document.getElementById('profile_pic').addEventListener('change', function(e) {
                const preview = document.getElementById('profilePreview');
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </div>
</body>

</html>
<?php
ob_end_flush(); // Send the output
?>