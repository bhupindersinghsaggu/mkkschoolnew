<?php
include '../header.php';
include '../head-nav.php';
include '../side-bar.php';
include '../config/db.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Notebook Review Records</h2>
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link rel="apple-touch-icon" href="../assets/img/apple-touch-icon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../assets/plugins/tabler-icons/tabler-icons.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/plugins/%40simonwep/pickr/themes/nano.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Session</th>
                <th>Date</th>
                <th>Teacher</th>
                <th>ID</th>
                <th>Subject</th>
                <th>Class</th>
                <th>Books Checked</th>
                <th>Rating</th>
                <th>Actions</th>
                <th>Upload</th>
                <th>View Document</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT e.*, t.name AS teacher_name, t.photo AS teacher_photo FROM evaluations e
                    JOIN teachers t ON e.teacher_id = t.teacher_id
                    ORDER BY e.id DESC";
            $result = mysqli_query($conn, $sql);
            $count = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td>
                        <?php
                        $photo_path = "../uploads/" . $row['teacher_photo'];
                        if (!empty($row['teacher_photo']) && file_exists($photo_path)) {
                            echo '<img src="' . $photo_path . '" alt="Photo" width="60">';
                        } else {
                            echo 'No photo';
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($row['session']) ?></td>
                    <td><?= htmlspecialchars($row['eval_date']) ?></td>
                    <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                    <td><?= htmlspecialchars($row['teacher_id']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= htmlspecialchars($row['class']) ?></td>
                    <td><?= htmlspecialchars($row['books_checked']) ?></td>
                    <td><?= htmlspecialchars($row['rating']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this record?')">Delete</a>
                    </td>
                    <td>
                        <form action="upload_document.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="evaluation_id" value="<?= $row['id'] ?>">
                            <input type="file" name="document" class="form-control mb-2" required>
                            <button type="submit" class="btn btn-sm btn-success">Upload</button>
                        </form>
                    </td>
                    <td>
                        <?php if (!empty($row['document']) && file_exists('../documents/' . $row['document'])): ?>
                            <a href="../documents/<?= $row['document'] ?>" target="_blank" class="btn btn-sm btn-info">View</a>
                            <a href="../documents/<?= $row['document'] ?>" download class="btn btn-sm btn-secondary">Download</a>
                        <?php else: ?>
                            <span class="text-muted">No document</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- ✅ Bootstrap Alert Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="alertModalLabel">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="alertModalBody">
                <!-- Message will go here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Bootstrap JS + Modal trigger -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const uploadStatus = urlParams.get('upload');
        const message = urlParams.get('msg');

        if (uploadStatus) {
            let alertText = '';
            if (uploadStatus === 'success') {
                alertText = '✅ Document uploaded successfully!';
            } else if (uploadStatus === 'error') {
                alertText = '❌ ' + (message || 'Document upload failed.');
            }

            document.getElementById('alertModalBody').innerText = alertText;
            var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
            alertModal.show();
        }
    });
</script>

<?php include '../footer.php'; ?>