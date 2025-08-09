<?php
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

// Get teacher details
$stmt = $pdo->prepare("SELECT td.* FROM teacher_details td WHERE td.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$teacher = $stmt->fetch();
?>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($teacher['full_name']); ?></h1>
    <div class="teacher-info">
        <p><strong>Subject:</strong> <?php echo htmlspecialchars($teacher['subject']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($teacher['phone']); ?></p>
    </div>
    <!-- Add teacher-specific content here -->
</div>

<?php require_once '../includes/footer.php'; ?>