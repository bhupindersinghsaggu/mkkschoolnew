<?php
// manage_users.php - User management (for super admins)
require_once 'auth.php';

$auth = new Auth();

// Check if user is logged in and has super admin privileges
if (!$auth->isLoggedIn() || !$auth->hasPermission(ROLE_SUPER_ADMIN)) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();

// Upload directory (ensure writable)
$uploadBase = __DIR__ . '/uploads/teachers';
if (!is_dir($uploadBase)) {
    mkdir($uploadBase, 0755, true);
}

// Initialize variables
$error = '';
$success = '';

// Handle add user (with teacher-specific fields)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    // Basic fields
    $username = isset($_POST['username']) ? strtoupper(trim($_POST['username'])) : '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = isset($_POST['role']) ? (int)$_POST['role'] : 0;
    $email = trim($_POST['email'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');

    // Teacher-specific fields
    $teacher_id = trim($_POST['teacher_id'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $teacher_type = trim($_POST['teacher_type'] ?? '');

    // Basic validation
    if (empty($username) || empty($password) || empty($email) || empty($fullname)) {
        $error = "All required fields (Username, Password, Email, Full Name) are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        try {
            // Check if username already exists
            $query = "SELECT id FROM users WHERE username = :username";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $error = "Username already exists. Please choose a different username.";
            } else {
                // Handle file upload (profile picture) if present
                $profilePicturePath = null;
                if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $file = $_FILES['profile_picture'];
                    // Basic upload validations
                    $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    $maxSize = 2 * 1024 * 1024; // 2 MB

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
                            // safe unique filename
                            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                            $safeName = 'teacher_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
                            $dest = $uploadBase . '/' . $safeName;

                            if (!move_uploaded_file($file['tmp_name'], $dest)) {
                                $error = "Failed to save uploaded profile picture.";
                            } else {
                                // Save relative path to DB (web-accessible)
                                $profilePicturePath = 'uploads/teachers/' . $safeName;
                            }
                        }
                    }
                }

                // If no upload error, insert user
                if (empty($error)) {
                    // Hash password
                    // Hash password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Prepare values to bind (must be actual variables)
                    $created_by_val = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
                    $teacher_id_val = $teacher_id !== '' ? $teacher_id : null;
                    $phone_val = $phone !== '' ? $phone : null;
                    $subject_val = $subject !== '' ? $subject : null;
                    $teacher_type_val = $teacher_type !== '' ? $teacher_type : null;
                    $profile_picture_val = $profilePicturePath !== null ? $profilePicturePath : null;
                    $role_val = (int)$role;

                    // Insert new user (includes teacher-specific columns)
                    $query = "INSERT INTO users 
    (username, password, role, email, fullname, created_by, teacher_id, phone, subject, teacher_type, profile_picture, created_at)
    VALUES 
    (:username, :password, :role, :email, :fullname, :created_by, :teacher_id, :phone, :subject, :teacher_type, :profile_picture, NOW())";

                    $stmt = $conn->prepare($query);

                    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                    $stmt->bindParam(':role', $role_val, PDO::PARAM_INT);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
                    $stmt->bindParam(':created_by', $created_by_val, PDO::PARAM_INT);
                    $stmt->bindParam(':teacher_id', $teacher_id_val, PDO::PARAM_STR);
                    $stmt->bindParam(':phone', $phone_val, PDO::PARAM_STR);
                    $stmt->bindParam(':subject', $subject_val, PDO::PARAM_STR);
                    $stmt->bindParam(':teacher_type', $teacher_type_val, PDO::PARAM_STR);
                    $stmt->bindParam(':profile_picture', $profile_picture_val, PDO::PARAM_STR);


                    if ($stmt->execute()) {
                        $success = "User created successfully!";

                        // Log activity
                        $role_name = $auth->getRoleName($role);
                        $auth->logActivity($_SESSION['user_id'], "Created new $role_name: $username");

                        // Clear form
                        $_POST = array();
                    } else {
                        $error = "Failed to create user. Please try again.";
                    }
                }
            }
        } catch (PDOException $e) {
            error_log("Add user error: " . $e->getMessage());
            $error = "Database error. Please try again.";
        } catch (Exception $e) {
            error_log("Unexpected error: " . $e->getMessage());
            $error = "Unexpected error occurred. Please try again.";
        }
    }
}

// Get all users for listing
try {
    $query = "SELECT u.*, creator.username as created_by_name 
              FROM users u 
              LEFT JOIN users creator ON u.created_by = creator.id 
              ORDER BY u.role, u.username";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Fetch users error: " . $e->getMessage());
    $users = [];
    $error = "Failed to load users.";
}
?>

<?php include 'includes/header.php'; ?>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row vh-100 d-flex justify-content-center">
                <div class="col-12 align-self-center">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                                <?php endif; ?>

                                <?php if (!empty($success)): ?>
                                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                                <?php endif; ?>
                                <div class="card">
                                    <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                        <div class="text-center p-3">
                                            <a href="./dashboard.php" class="logo logo-admin">
                                                <img src="assets/images/logo-sm.png" height="50" alt="logo" class="auth-logo">
                                            </a>
                                            <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Create an account</h4>
                                            <p class="text-muted fw-medium mb-0">Enter Teacher Basic detail to Create your account today.</p>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <!-- note: enctype required for file upload -->
                                        <form class="my-4" method="post" action="" enctype="multipart/form-data">
                                            <!-- Profile Picture -->
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="profile_picture">Profile Picture</label>
                                                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                                                <small class="form-text">Allowed types: JPG, PNG, GIF, WEBP. Max 2MB.</small>
                                            </div>

                                            <!-- Teacher ID / Admission No (converted for teachers) -->
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="username">Admission No. / Teacher ID</label>
                                                <input type="text" class="form-control text-uppercase" id="username" name="username" placeholder="Enter Admission No. or Teacher ID" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                                            </div>

                                            <!-- Teacher-specific visible fields -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="form-label" for="teacher_id">Teacher ID (internal)</label>
                                                        <input type="text" class="form-control" id="teacher_id" name="teacher_id" placeholder="E.g. TCHR-001" value="<?php echo isset($_POST['teacher_id']) ? htmlspecialchars($_POST['teacher_id']) : ''; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="form-label" for="phone">Phone No.</label>
                                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="form-label" for="subject">Subject</label>
                                                <input type="text" class="form-control" id="subject" name="subject" placeholder="E.g. Mathematics" value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="form-label" for="teacher_type">Teacher Type</label>
                                                <select id="teacher_type" class="form-select" name="teacher_type">
                                                    <option value="">Select Type</option>
                                                    <option value="Permanent" <?php echo (isset($_POST['teacher_type']) && $_POST['teacher_type'] == 'Pre-Primary') ? 'selected' : ''; ?>>Pre-Primary</option>
                                                    <option value="Contract" <?php echo (isset($_POST['teacher_type']) && $_POST['teacher_type'] == 'Primary') ? 'selected' : ''; ?>>Primary</option>
                                                    <option value="Visiting" <?php echo (isset($_POST['teacher_type']) && $_POST['teacher_type'] == 'Middle') ? 'selected' : ''; ?>>Middle</option>
                                                    <option value="Visiting" <?php echo (isset($_POST['teacher_type']) && $_POST['teacher_type'] == 'Senior') ? 'selected' : ''; ?>>Senior</option>
                                                </select>
                                            </div>

                                            <!-- Email, Full Name -->
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="form-label" for="fullname">Full Name</label>
                                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter fullname" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">
                                            </div>

                                            <!-- Role -->
                                            <div class="form-group mb-2">
                                                <label for="role" class="form-label">Role:*</label>
                                                <select id="role" class="form-select" name="role" required>
                                                    <option value="">Select Role</option>
                                                    <option value="1" <?php echo (isset($_POST['role']) && $_POST['role'] == 1) ? 'selected' : ''; ?>>Super Admin</option>
                                                    <option value="2" <?php echo (isset($_POST['role']) && $_POST['role'] == 2) ? 'selected' : ''; ?>>Admin</option>
                                                    <option value="3" <?php echo (isset($_POST['role']) && $_POST['role'] == 4) ? 'selected' : ''; ?>>Teacher</option>
                                                </select>
                                            </div>

                                            <!-- Password -->
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="password">Password</label>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="form-label" for="confirm_password">Confirm Password</label>
                                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter Confirm password">
                                            </div>

                                            <div class="form-group mb-0 row">
                                                <div class="col-12">
                                                    <div class="d-flex  gap-2 mt-3">
                                                        <button class="btn btn-primary" name="add_user" type="submit">Create User <i class="fas fa-sign-in-alt ms-1"></i></button>
                                                        <a href="./admin/teachers/list.php" class="btn btn-danger">Back <i class="fas fa-back-alt ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Optional: list existing teachers/users -->
                                <!-- <div class="mt-4">
                                    <h5>Existing Users</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Username</th>
                                                    <th>Fullname</th>
                                                    <th>Role</th>
                                                    <th>Teacher ID</th>
                                                    <th>Phone</th>
                                                    <th>Subject</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($users as $u): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($u['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                                                        <td><?php echo htmlspecialchars($u['fullname']); ?></td>
                                                        <td><?php echo htmlspecialchars($auth->getRoleName((int)$u['role'])); ?></td>
                                                        <td><?php echo htmlspecialchars($u['teacher_id'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($u['phone'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($u['subject'] ?? ''); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>