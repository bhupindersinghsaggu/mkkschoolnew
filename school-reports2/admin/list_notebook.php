<?php
// admin/teachers/list_notebook.php
require_once '../config.php';
require_once '../auth.php';
require_once '../database.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header('Location: /mkkschool-new/login.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$error = '';
$success = '';

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    try {
        $del = $conn->prepare("DELETE FROM records WHERE id = :id LIMIT 1");
        $del->bindParam(':id', $deleteId, PDO::PARAM_INT);
        if ($del->execute()) {
            $success = "Record deleted successfully.";
        } else {
            $error = "Failed to delete record.";
        }
    } catch (PDOException $e) {
        error_log("Delete record error: " . $e->getMessage());
        $error = "Database error while deleting record.";
    }
}

// Fetch all records
$rows = [];
try {
    $stmt = $conn->query("SELECT * FROM records ORDER BY eval_date DESC, id DESC");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Fetch records error: " . $e->getMessage());
    $error = "Failed to load records.";
}
?>
<?php include '../includes/css.php'; ?>
<?php include '../includes/header.php'; ?>

<style>
    table.dataTable {
        width: 100%;
        margin: 0 auto;
        clear: both;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 12px;
    }
</style>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row">
                <div class="col-12">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Notebook Corrections</h3>
                        <a href="add_notebook.php" class="btn btn-primary">Add</a>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">

                            <!-- Filter controls -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Filter by Session</label>
                                    <select id="filterSession" class="form-control">
                                        <option value="">All</option>
                                        <?php
                                        $sessions = array_unique(array_column($rows, 'session'));
                                        foreach ($sessions as $s) {
                                            echo "<option value='" . htmlspecialchars($s) . "'>" . htmlspecialchars($s) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Filter by Teacher</label>
                                    <input type="text" id="filterTeacher" class="form-control" placeholder="Type teacher name">
                                </div>
                                <div class="col-md-3">
                                    <label>Filter by Class/Section</label>
                                    <input type="text" id="filterClass" class="form-control" placeholder="Type class/section">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="recordsTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Session</th>
                                            <th>Date</th>
                                            <th>Teacher</th>
                                            <th>Teacher ID</th>
                                            <th>Subject</th>
                                            <th>Class/Section</th>
                                            <th>Notebooks Checked</th>
                                            <th>Evaluator</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($rows) > 0): ?>
                                            <?php foreach ($rows as $r): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($r['id']) ?></td>
                                                    <td><?= htmlspecialchars($r['session']) ?></td>
                                                    <td><?= htmlspecialchars($r['eval_date']) ?></td>
                                                    <td><?= htmlspecialchars($r['teacher_name']) ?></td>
                                                    <td><?= htmlspecialchars($r['teacher_id']) ?></td>
                                                    <td><?= htmlspecialchars($r['subject']) ?></td>
                                                    <td><?= htmlspecialchars($r['class_section']) ?></td>
                                                    <td><?= htmlspecialchars($r['notebooks_checked']) ?></td>
                                                    <td><?= htmlspecialchars($r['evaluator_name']) ?></td>
                                                    <td class="d-flex justify-content-center gap 1">
                                                        <a href="edit_notebook.php?id=<?= urlencode($r['id']) ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                                        <a href="list_notebook.php?delete=<?= urlencode($r['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record? This cannot be undone.');"><i class="fa-solid fa-trash-can"></i></a>
                                                        <a href="print_notebook.php?id=<?= urlencode($r['id']) ?>" target="_blank" class="btn btn-sm btn-info"><i class="fa-solid fa-print"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="17">No records found.</td>
                                            </tr>
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

<?php include '../includes/footer.php'; ?>

<!-- Load DataTables Buttons assets (CDNs). If your header already loads some of these, duplication is harmless. -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- DataTables with custom filters + Buttons -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
            var table = jQuery('#recordsTable').DataTable({
                pageLength: 25,
                order: [
                    [2, 'desc']
                ],
                dom: 'Bfrtip', // show buttons + filter + table
                buttons: [{
                        extend: 'copy',
                        title: 'Notebook_Corrections'
                    },
                    {
                        extend: 'csv',
                        title: 'Notebook_Corrections'
                    },
                    {
                        extend: 'excel',
                        title: 'Notebook_Corrections'
                    },
                    {
                        extend: 'pdf',
                        title: 'Notebook_Corrections',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        title: 'Notebook Corrections'
                    }
                ],
                columnDefs: [{
                        orderable: false,
                        targets: -1
                    } // actions column not orderable
                ]
            });

            // Session filter
            jQuery('#filterSession').on('change', function() {
                table.column(1).search(this.value).draw();
            });

            // Teacher filter (text input)
            jQuery('#filterTeacher').on('keyup change', function() {
                table.column(3).search(this.value).draw();
            });

            // Class/Section filter
            jQuery('#filterClass').on('keyup change', function() {
                table.column(6).search(this.value).draw();
            });
        } else {
            console.warn('DataTables not found. Buttons and filters require DataTables JS/CSS.');
        }
    });
</script>