<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection BEFORE any database operations
require_once '../config/database.php';
require_once '../includes/auth_check.php';

// Get teacher details using MySQLi
$user_id = $_SESSION['user_id'];
$query = "SELECT td.*, u.username, u.email 
          FROM teacher_details td
          JOIN users u ON td.user_id = u.id
          WHERE td.user_id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $teacher = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    if (!$teacher) {
        die("<div class='alert alert-danger'>Teacher profile not found. Please contact administration.</div>");
    }
} else {
    die("<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>");
}

// Now include header after all PHP processing is done
require_once '../teacher/header.php';
require_once '../teacher/side-bar.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Card -->
            <div class="card">
                <div class="card-body text-center">
                    <?php if (!empty($teacher['profile_pic'])): ?>
                        <img src="../uploads/profile_pics/<?php echo htmlspecialchars($teacher['profile_pic']); ?>" 
                             class="img-fluid rounded-circle mb-3" 
                             style="width: 200px; height: 200px; object-fit: cover;"
                             alt="Profile Picture">
                    <?php else: ?>
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" 
                             style="width: 200px; height: 200px; margin: 0 auto;">
                            <i class="fas fa-user fa-5x text-secondary"></i>
                        </div>
                    <?php endif; ?>
                    
                    <h4><?php echo htmlspecialchars($teacher['teacher_name'] ?? 'Teacher Name'); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($teacher['teacher_type'] ?? 'Teacher Type'); ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Teacher Details -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Teacher Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Teacher ID:</strong> <?php echo htmlspecialchars($teacher['teacher_id'] ?? 'N/A'); ?></p>
                            <p><strong>Subject:</strong> <?php echo htmlspecialchars($teacher['subject'] ?? 'Not specified'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($teacher['email'] ?? 'N/A'); ?></p>
                            <p><strong>Username:</strong> <?php echo htmlspecialchars($teacher['username'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    
                    <!-- Additional fields can be added here -->
                    <?php if (!empty($teacher['phone'])): ?>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($teacher['phone']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($teacher['address'])): ?>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($teacher['address']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>