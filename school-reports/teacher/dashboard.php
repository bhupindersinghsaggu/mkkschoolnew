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
                <div class="col-md-3">
                    <!-- Profile Card -->
                    <div class="card">
                        <div class="card-body text-center">
                            <?php if (!empty($teacher['profile_pic'])): ?>
                            <img src="../uploads/profile_pics/<?php echo htmlspecialchars($teacher['profile_pic']); ?>"
                                class="img-fluid  mb-3" style="width: 100% ;height: 200px; object-fit: cover;"
                                alt="Profile Picture">
                            <?php else: ?>
                            <div class="bg-light  d-flex align-items-center justify-content-center mb-3"
                                style="width: 100%; height: 200px; margin: 0 auto;">
                                <i class="fas fa-user fa-5x text-secondary"></i>
                            </div>
                            <?php endif; ?>

                            <h4><?php echo htmlspecialchars($teacher['teacher_name'] ?? 'Teacher Name'); ?></h4>
                            <p class="text-muted">
                                <?php echo htmlspecialchars($teacher['teacher_type'] ?? 'Teacher Type'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <!-- Teacher Details -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Basic Information</h5>
                        </div>
                        <table class="table ">
                            <tbody>
                                <tr>
                                    <th width="30%">Teacher ID</th>
                                    <td><?= htmlspecialchars($teacher['teacher_id'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Subject</th>
                                    <td><?= htmlspecialchars($teacher['subject'] ?? 'Not specified') ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= htmlspecialchars($teacher['email'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?= htmlspecialchars($teacher['username'] ?? 'N/A') ?></td>
                                </tr>
                            </tbody>
                        </table>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info ">
                        <h5 class="text-white">My Notebook Review </h5>
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
                                            <a href="<?= $docPath ?>" target="_blank" class="btn btn-sm btn-info"
                                                title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= $docPath ?>" download class="btn btn-sm btn-secondary"
                                                title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button onclick="printDocument('<?= $docPath ?>')"
                                                class="btn btn-sm btn-primary" title="Print">
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
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 text-white">My Class Shows</h5>
                    </div>
                    <div class="card-body">
                        <?php
                                // Get class shows for this teacher
                                $teacher_id = $teacher['teacher_id'];
                                $class_show_query = "SELECT * FROM class_show WHERE teacher_id = ? ORDER BY created_at DESC";
                                $stmt = mysqli_prepare($conn, $class_show_query);
                                
                                if ($stmt) {
                                    mysqli_stmt_bind_param($stmt, "s", $teacher_id);
                                    mysqli_stmt_execute($stmt);
                                    $class_show_result = mysqli_stmt_get_result($stmt);
                                    
                                    if (mysqli_num_rows($class_show_result) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Session</th>
                                        <th>Class/Section</th>
                                        <th>Topic</th>
                                        <th>Judge 1</th>
                                        <th>Judge 2</th>
                                        <th>Score</th>
                                        <th>Comments</th>
                                        <th>Video</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($class = mysqli_fetch_assoc($class_show_result)): 
                                                        // Calculate average marks
                                                        $marks1 = (int)$class['marks_judge1'];
                                                        $marks2 = (int)$class['marks_judge2'];
                                                        $average_marks = ($marks1 + $marks2) / 2;
                                                    ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($class['eval_date'])) ?></td>
                                        <td><?= htmlspecialchars($class['session']) ?></td>
                                        <td><?= htmlspecialchars($class['class_section']) ?></td>
                                        <td><?= htmlspecialchars($class['topic']) ?></td>
                                        <td><?= htmlspecialchars($class['evaluator_name']) ?></td>
                                        <td>
                                            <?php 
                                                            // Assuming you have a second judge field
                                                            $judges = explode(',', $class['evaluator_name']);
                                                            echo isset($judges[1]) ? trim($judges[1]) : 'N/A'; 
                                                            ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-success badge-score">
                                                <?= number_format($average_marks, 1) ?>%
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($class['comments1']) || !empty($class['comments2'])): ?>
                                            <button type="button" class="btn btn-sm btn-info comments-popover"
                                                data-bs-toggle="popover" title="Judge Comments"
                                                data-bs-content="<strong>Judge 1:</strong> <?= htmlspecialchars($class['comments1'] ?? 'No comment') ?><br><strong>Judge 2:</strong> <?= htmlspecialchars($class['comments2'] ?? 'No comment') ?>">
                                                <i class="fas fa-comments"></i> View
                                            </button>
                                            <?php else: ?>
                                            <span class="text-muted">No comments</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($class['video_link'])): ?>
                                            <a href="<?= htmlspecialchars($class['video_link']) ?>" target="_blank"
                                                class="video-link">
                                                <i class="fas fa-external-link-alt"></i> Watch
                                            </a>
                                            <?php else: ?>
                                            <span class="text-muted">No video</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No class show records found.
                        </div>
                        <?php endif;
                                    
                                    mysqli_stmt_close($stmt);
                                } else {
                                    echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
                                }
                                ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Initialize popovers for comments
document.addEventListener('DOMContentLoaded', function() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            html: true,
            trigger: 'focus'
        });
    });
});
</script>
<?php require_once './teacher-footer-icon.php'; ?>
<?php require_once './footer.php'; ?>