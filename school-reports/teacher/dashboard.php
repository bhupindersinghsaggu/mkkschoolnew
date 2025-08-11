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

<div class="page-wrapper">
    <div class="content mb-3">
        <div class="container py-4">
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
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5>My Notebook Review Documents</h5>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Get documents for this teacher
                                    $teacher_id = $teacher['teacher_id'];
                                    $documents_query = "SELECT r.id, r.eval_date, r.document, r.class_section, r.subject 
                              FROM records r
                              WHERE r.teacher_id = ? AND r.document IS NOT NULL
                              ORDER BY r.eval_date DESC";
                                    $stmt = mysqli_prepare($conn, $documents_query);
                                    mysqli_stmt_bind_param($stmt, "s", $teacher_id);
                                    mysqli_stmt_execute($stmt);
                                    $documents = mysqli_stmt_get_result($stmt);

                                    if (mysqli_num_rows($documents) > 0): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Class</th>
                                                        <th>Subject</th>
                                                        <th>Document</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($doc = mysqli_fetch_assoc($documents)):
                                                        $docPath = '../uploads/teacher_documents/' . htmlspecialchars(basename($doc['document']));
                                                        $fileExists = file_exists($docPath) && is_file($docPath);
                                                    ?>
                                                        <tr>
                                                            <td><?= date('d M Y', strtotime($doc['eval_date'])) ?></td>
                                                            <td><?= htmlspecialchars($doc['class_section']) ?></td>
                                                            <td><?= htmlspecialchars($doc['subject']) ?></td>
                                                            <td>
                                                                <?php if ($fileExists):
                                                                    $fileExt = strtolower(pathinfo($docPath, PATHINFO_EXTENSION));
                                                                    $iconClass = [
                                                                        'pdf' => 'fa-file-pdf text-danger',
                                                                        'jpg' => 'fa-file-image text-primary',
                                                                        'jpeg' => 'fa-file-image text-primary',
                                                                        'png' => 'fa-file-image text-primary',
                                                                        'doc' => 'fa-file-word text-primary',
                                                                        'docx' => 'fa-file-word text-primary',
                                                                    ][$fileExt] ?? 'fa-file text-secondary';
                                                                ?>
                                                                    <i class="fas <?= $iconClass ?> me-2"></i>
                                                                    <?= htmlspecialchars(basename($doc['document'])) ?>
                                                                <?php else: ?>
                                                                    <span class="text-danger">File missing</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($fileExists): ?>
                                                                    <a href="<?= $docPath ?>" target="_blank" class="btn btn-sm btn-info" title="View">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="<?= $docPath ?>" download class="btn btn-sm btn-secondary" title="Download">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                    <button onclick="printDocument('<?= $docPath ?>')" class="btn btn-sm btn-primary" title="Print">
                                                                        <i class="fas fa-print"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">No notebook review documents found.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <script>
                            function printDocument(filePath) {
                                // Open the document in a new window and print
                                let printWindow = window.open(filePath, '_blank');
                                printWindow.onload = function() {
                                    printWindow.print();
                                };
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<?php require_once '../includes/footer.php'; ?>