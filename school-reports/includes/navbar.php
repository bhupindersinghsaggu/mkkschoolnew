<?php
// navbar.php
require_once '../config/functions.php';
?>

<!-- <nav class="navbar">
    <div class="container">
        <a href="#" class="logo">School Admin</a>
        <ul class="nav-links">
            <?php if (isLoggedIn()): ?>
                <?php if (isSuperAdmin()): ?>
                    <li><a href="../super_admin/dashboard.php">Dashboard</a></li>
                    <li><a href="../super_admin/manage_teachers.php">Manage Teachers</a></li>
                <?php elseif (isTeacher()): ?>
                    <li><a href="../teacher/dashboard.php">Dashboard</a></li>
                    <li><a href="../teacher/profile.php">Profile</a></li>
                <?php endif; ?>
                <li>
                    <form action="../auth/logout.php" method="post" class="logout-form">
                        <button type="submit" class="logout-btn">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</button>
                    </form>
                </li>
            <?php else: ?>
                <li><a href="../auth/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav> -->
<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Logout</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="../auth/logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Logout Link -->
<li>
    <a href="#" class="logout-link" data-toggle="modal" data-target="#logoutModal">
        Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)
    </a>
</li>