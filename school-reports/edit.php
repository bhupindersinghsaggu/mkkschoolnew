<?php
// list_users.php - list all users with edit/delete links
require_once 'auth.php';

$auth = new Auth();

// Only admin or higher
if (!$auth->isLoggedIn() || !$auth->hasPermission(ROLE_ADMIN)) {
    header("Location: /login.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$error = '';
$success = '';

// get teacher id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: list_user.php");
    exit;
}

$userId = (int)$_GET['id'];

// Fetch user
try {
    $q = "SELECT * FROM users WHERE id = :id AND role = :role LIMIT 1";
    $s = $conn->prepare($q);
    $s->bindParam(':id', $userId, PDO::PARAM_INT);
    $s->bindValue(':role', ROLE_TEACHER, PDO::PARAM_INT);
    $s->execute();
    $user = $s->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: list.php");
        exit;
    }
} catch (PDOException $e) {
    error_log("Fetch user error: " . $e->getMessage());
    header("Location: list.php");
    exit;
}

// Upload directory
$uploadBase = __DIR__ . '/uploads/teachers';
if (!is_dir($uploadBase)) {
    mkdir($uploadBase, 0755, true);
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    // Collect inputs
    $username = isset($_POST['username']) ? strtoupper(trim($_POST['username'])) : $user['username'];
    $email = trim($_POST['email'] ?? $user['email']);
    $fullname = trim($_POST['fullname'] ?? $user['fullname']);
    $role = ROLE_TEACHER;

    // teacher fields
    $teacher_id = trim($_POST['teacher_id'] ?? ($user['teacher_id'] ?? ''));
    $phone = trim($_POST['phone'] ?? ($user['phone'] ?? ''));
    $subject = trim($_POST['subject'] ?? ($user['subject'] ?? ''));
    $teacher_type = trim($_POST['teacher_type'] ?? ($user['teacher_type'] ?? ''));

    // optional: change password
    $new_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    if ($new_password !== '' && $new_password !== $confirm_password) {
        $error = "New passwords do not match.";
    } elseif ($new_password !== '' && strlen($new_password) < 8) {
        $error = "Password must be at least 8 characters long.";
    }

    // Handle profile picture upload
    $profilePicturePath = $user['profile_picture'] ?? null;
    if (empty($error) && isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['profile_picture'];
        $allowedMime = ['image/jpeg','image/png','image/gif','image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error = "File upload error. Please try again.";
        } elseif ($file['size'] > $maxSize) {
            $error = "Profile picture must be less than 2MB.";
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mime, $allowedMime)) {
                $error = "Invalid profile picture format. Allowed: JPG, PNG, GIF, WEBP.";
            } else {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $safeName = 'teacher_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
                $dest = $uploadBase . '/' . $safeName;

                if (!move_uploaded_file($file['tmp_name'], $dest)) {
                    $error = "Failed to save uploaded profile picture.";
                } else {
                    // remove old pic if exists and safe
                    if (!empty($user['profile_picture'])) {
                        $old = __DIR__ . '/../../' . $user['profile_picture'];
                        if (file_exists($old)) {
                            @unlink($old);
                        }
                    }
                    $profilePicturePath = 'uploads/teachers/' . $safeName;
                }
            }
        }
    }

    // If validation OK, update DB
    if (empty($error)) {
        try {
            // prepare variables for bindParam
            $username_val = $username ?: $user['username'];
            $email_val = $email ?: $user['email'];
            $fullname_val = $fullname ?: $user['fullname'];
            $role_val = (int)$role;
            $teacher_id_val = $teacher_id !== '' ? $teacher_id : ($user['teacher_id'] ?? null);
            $phone_val = $phone !== '' ? $phone : ($user['phone'] ?? null);
            $subject_val = $subject !== '' ? $subject : ($user['subject'] ?? null);
            $teacher_type_val = $teacher_type !== '' ? $teacher_type : ($user['teacher_type'] ?? null);
            $profile_picture_val = $profilePicturePath !== null ? $profilePicturePath : null;

            // start building query
            $updateFields = "username = :username, email = :email, fullname = :fullname, role = :role, teacher_id = :teacher_id, phone = :phone, subject = :subject, teacher_type = :teacher_type, profile_picture = :profile_picture";

            // if password changed, add
            $password_hash_val = null;
            if ($new_password !== '') {
                $password_hash_val = password_hash($new_password, PASSWORD_DEFAULT);
                $updateFields .= ", password = :password";
            }

            $sql = "UPDATE users SET $updateFields WHERE id = :id";
            $stmt = $conn->prepare($sql);

            // bind
            $stmt->bindParam(':username', $username_val, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email_val, PDO::PARAM_STR);
            $stmt->bindParam(':fullname', $fullname_val, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role_val, PDO::PARAM_INT);
            $stmt->bindParam(':teacher_id', $teacher_id_val, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone_val, PDO::PARAM_STR);
            $stmt->bindParam(':subject', $subject_val, PDO::PARAM_STR);
            $stmt->bindParam(':teacher_type', $teacher_type_val, PDO::PARAM_STR);
            $stmt->bindParam(':profile_picture', $profile_picture_val, PDO::PARAM_STR);
            if ($new_password !== '') {
                $stmt->bindParam(':password', $password_hash_val, PDO::PARAM_STR);
            }
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $success = "Teacher updated successfully.";
                $auth->logActivity($_SESSION['user_id'], "Updated teacher ID: $userId");
                // refresh user data
                header("Location: edit.php?id=" . urlencode($userId) . "&updated=1");
                exit;
            } else {
                $error = "Failed to update teacher.";
            }
        } catch (PDOException $e) {
            error_log("Update user error: " . $e->getMessage());
            $error = "Database error while updating teacher.";
        } catch (Exception $e) {
            error_log("Unexpected error: " . $e->getMessage());
            $error = "Unexpected error occurred.";
        }
    }
}

// show updated flag message if redirected
if (isset($_GET['updated']) && $_GET['updated'] == 1) {
    $success = "Teacher updated successfully.";
}

?>
<?php include ('includes/css.php'); ?>
<?php include ('includes/header.php'); ?>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Teacher: <?php echo htmlspecialchars($user['username']); ?></h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="" enctype="multipart/form-data">
                                <!-- Current avatar -->
                                <div class="mb-3">
                                    <label class="form-label">Current Profile Picture</label><br>
                                    <?php if (!empty($user['profile_picture']) && file_exists(__DIR__ . '/../../' . $user['profile_picture'])): ?>
                                        <img src="<?php echo htmlspecialchars('/' . $user['profile_picture']); ?>" alt="avatar" style="width:80px;height:80px;border-radius:50%;">
                                    <?php else: ?>
                                        <img src="/assets/images/default-avatar.png" alt="avatar" style="width:80px;height:80px;border-radius:50%;">
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="profile_picture">Change Profile Picture</label>
                                    <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*">
                                    <small class="form-text">Leave blank to keep existing. Max 2MB.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="username">Admission No. / Username</label>
                                    <input type="text" class="form-control text-uppercase" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="teacher_id">Teacher ID (internal)</label>
                                        <input type="text" class="form-control" name="teacher_id" id="teacher_id" value="<?php echo htmlspecialchars($user['teacher_id'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="phone">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="subject">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject" value="<?php echo htmlspecialchars($user['subject'] ?? ''); ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="teacher_type">Teacher Type</label>
                                    <select name="teacher_type" id="teacher_type" class="form-select">
                                        <option value="">Select Type</option>
                                        <option value="Permanent" <?php echo (isset($user['teacher_type']) && $user['teacher_type'] == 'Pre-Primary') ? 'selected' : ''; ?>>Pre-Primary</option>
                                        <option value="Contract" <?php echo (isset($user['teacher_type']) && $user['teacher_type'] == 'Primary') ? 'selected' : ''; ?>>Primary</option>
                                        <option value="Visiting" <?php echo (isset($user['teacher_type']) && $user['teacher_type'] == 'Middle') ? 'selected' : ''; ?>>Middle</option>
                                        <option value="Visiting" <?php echo (isset($user['teacher_type']) && $user['teacher_type'] == 'Senior') ? 'selected' : ''; ?>>Senior</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="fullname">Full Name</label>
                                    <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>">
                                </div>

                                <hr>
                                <h6>Change Password (optional)</h6>
                                <div class="mb-3">
                                    <label class="form-label" for="password">New Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Leave blank to keep current password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="confirm_password">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" name="update_user" class="btn btn-success">Update Teacher</button>
                                    <a href="list_users.php" class="btn btn-secondary">Back to List</a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php 'includes/footer.php'; ?>
