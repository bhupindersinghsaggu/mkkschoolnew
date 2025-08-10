<?php
// test/auth/register_success.php
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
?>

<div class="container mt-5">
    <div class="alert alert-success text-center">
        <h4>Registration Successful!</h4>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <a href="../super_admin/dashboard.php" class="btn btn-primary">Go to Dashboard</a>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>