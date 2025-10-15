<?php
// list_users.php - list all users with edit/delete links
require_once '../auth.php';

$auth = new Auth();

// Only super admin can access
if (!$auth->isLoggedIn() || !$auth->hasPermission(ROLE_SUPER_ADMIN)) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$error = '';
$success = '';

// Handle delete action (soft delete or permanent - here we'll do permanent delete)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];

    try {
        // get profile picture path to unlink if exists
        $q = "SELECT profile_picture FROM users WHERE id = :id LIMIT 1";
        $s = $conn->prepare($q);
        $s->bindParam(':id', $deleteId, PDO::PARAM_INT);
        $s->execute();
        $row = $s->fetch(PDO::FETCH_ASSOC);

        // Delete DB row
        $del = "DELETE FROM users WHERE id = :id";
        $ds = $conn->prepare($del);
        $ds->bindParam(':id', $deleteId, PDO::PARAM_INT);
        if ($ds->execute()) {
            // remove picture file if exists and inside uploads
            if (!empty($row['profile_picture'])) {
                $filePath = __DIR__ . '/' . $row['profile_picture'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
            $success = "User deleted successfully.";
            $auth->logActivity($_SESSION['user_id'], "Deleted user ID: $deleteId");
        } else {
            $error = "Failed to delete user.";
        }
    } catch (PDOException $e) {
        error_log("Delete user error: " . $e->getMessage());
        $error = "Database error while deleting user.";
    }
}

// Fetch users
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
<?php include '../includes/header.php'; ?>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row">
                <div class="col-12">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Users</h5>
                            <a href="manage_users.php" class="btn btn-primary btn-sm">Add New User</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Avatar</th>
                                            <th>Username</th>
                                            <th>Fullname</th>
                                            <th>Role</th>
                                            <th>Teacher ID</th>
                                            <th>Phone</th>
                                            <th>Subject</th>
                                            <th>Created By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $u): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($u['id']); ?></td>
                                                <td>
                                                    <?php if (!empty($u['profile_picture']) && file_exists(__DIR__ . '/' . $u['profile_picture'])): ?>
                                                        <img src="<?php echo htmlspecialchars($u['profile_picture']); ?>" alt="avatar" style="width:40px;height:40px;border-radius:50%;">
                                                    <?php else: ?>
                                                        <img src="assets/images/default-avatar.png" alt="avatar" style="width:40px;height:40px;border-radius:50%;">
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($u['username']); ?></td>
                                                <td><?php echo htmlspecialchars($u['fullname']); ?></td>
                                                <td><?php echo htmlspecialchars($auth->getRoleName((int)$u['role'])); ?></td>
                                                <td><?php echo htmlspecialchars($u['teacher_id'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($u['phone'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($u['subject'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($u['created_by_name'] ?? ''); ?></td>
                                                <td>
                                                    <a href="edit.php?id=<?php echo urlencode($u['id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                                                    <a href="list_users.php?delete=<?php echo urlencode($u['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user? This action cannot be undone.')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($users)): ?>
                                            <tr><td colspan="10">No users found.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
