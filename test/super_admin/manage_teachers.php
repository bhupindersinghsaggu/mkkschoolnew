<?php
require_once '../includes/auth_check.php';
if (!isSuperAdmin()) {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<div class="container">
    <h1>Manage Teachers</h1>
    
    <a href="add_teacher.php" class="btn">Add New Teacher</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Subject</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("
                SELECT u.id, u.email, td.full_name, td.subject 
                FROM users u 
                JOIN teacher_details td ON u.id = td.user_id 
                WHERE u.role = 'teacher'
            ");
            
            while ($row = $stmt->fetch()):
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <a href="edit_teacher.php?id=<?php echo $row['id']; ?>" class="btn btn-sm">Edit</a>
                    <a href="delete_teacher.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>