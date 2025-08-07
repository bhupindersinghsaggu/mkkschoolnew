<?php
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<div class="container">
    <h1>Super Admin Dashboard</h1>
    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Teachers</h3>
            <p>
                <?php 
                $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'teacher'");
                echo $stmt->fetchColumn();
                ?>
            </p>
        </div>
        <!-- Add more cards as needed -->
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>