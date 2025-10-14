<?php
// admin/class_show/list_class_show.php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../auth.php';
require_once __DIR__ . '/../../database.php';

$auth = new Auth();
if (!$auth->isLoggedIn() || !$auth->hasPermission(ROLE_ADMIN)) {
    header('Location: /mkkschool-new/login.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection(); // PDO

// Messages
$error = '';
$success = '';

// Handle delete action (via GET ?delete=ID)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delId = (int)$_GET['delete'];

    try {
        // Optional: fetch record to check existence
        $check = $conn->prepare("SELECT id FROM class_show WHERE id = :id LIMIT 1");
        $check->bindParam(':id', $delId, PDO::PARAM_INT);
        $check->execute();
        if ($check->rowCount() === 0) {
            $error = "Record not found or already deleted.";
        } else {
            $del = $conn->prepare("DELETE FROM class_show WHERE id = :id");
            $del->bindParam(':id', $delId, PDO::PARAM_INT);
            if ($del->execute()) {
                $success = "Record deleted successfully.";
                $auth->logActivity($_SESSION['user_id'], "Deleted class_show ID: $delId");
            } else {
                $error = "Failed to delete record.";
            }
        }
    } catch (PDOException $e) {
        error_log("Delete class_show error: " . $e->getMessage());
        $error = "Database error while deleting record.";
    }
}

// Pagination / list fetching
$page = isset($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$perPage = 15;
$offset = ($page - 1) * $perPage;

// Optional filter/search (not required but added for convenience)
$search = trim($_GET['q'] ?? '');
$whereSql = "1=1";
$params = [];

if ($search !== '') {
    // search by topic, teacher_name, teacher_id, class_section, evaluator_name
    $whereSql = "(topic LIKE :s OR teacher_name LIKE :s OR teacher_id LIKE :s OR class_section LIKE :s OR evaluator_name LIKE :s)";
    $params[':s'] = '%' . $search . '%';
}

// Get total count
try {
    $countSql = "SELECT COUNT(*) FROM class_show WHERE $whereSql";
    $countStmt = $conn->prepare($countSql);
    foreach ($params as $k => $v) $countStmt->bindValue($k, $v);
    $countStmt->execute();
    $totalRows = (int)$countStmt->fetchColumn();
} catch (PDOException $e) {
    error_log("Count class_show error: " . $e->getMessage());
    $totalRows = 0;
}

// Fetch page rows
try {
    $listSql = "SELECT * FROM class_show WHERE $whereSql ORDER BY eval_date DESC, id DESC LIMIT :limit OFFSET :offset";
    $listStmt = $conn->prepare($listSql);
    foreach ($params as $k => $v) $listStmt->bindValue($k, $v);
    $listStmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
    $listStmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $listStmt->execute();
    $rows = $listStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Fetch class_show error: " . $e->getMessage());
    $rows = [];
    $error = $error ?: "Failed to load records.";
}

// build base url for pagination while preserving search query
$queryParams = $_GET;
unset($queryParams['page']);
$baseUrl = basename($_SERVER['PHP_SELF']) . (count($queryParams) ? ('?' . http_build_query($queryParams) . '&') : '?');

// total pages
$totalPages = $perPage > 0 ? (int)ceil($totalRows / $perPage) : 1;

?>
<?php include __DIR__ . '/../../includes/css.php'; ?>
<?php include __DIR__ . '/../../includes/header.php'; ?>
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
                        <h4 class="mb-0">Class Shows</h4>
                        <div>
                            <a href="add_class_show.php" class="btn btn-primary btn-sm">Add New</a>
                            <a href="/mkkschool-new/dashboard.php" class="btn btn-secondary btn-sm">Back</a>
                        </div>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <!-- Optional search -->
                    <!-- <form method="GET" class="mb-3 d-flex gap-2" style="max-width:600px;">
                        <input type="text" name="q" class="form-control" placeholder="Search topic / teacher / class / evaluator" value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                        <a class="btn btn-outline-secondary" href="<?= basename($_SERVER['PHP_SELF']) ?>">Reset</a>
                    </form> -->

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
                                 <!-- <div class="col-md-3">
                                    <label>Filter by Total</label>
                                    <input type="text" id="filterTotal" class="form-control" placeholder="Type Marks">
                                </div> -->
                            </div>
                            <div class="table-responsive">
                                <table id="classhowTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Session</th>
                                            <th>Topic</th>
                                            <th>Teacher</th>
                                            <th>Class/Section</th>
                                            <th>Total</th>
                                            <th>Evaluator</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($rows)): ?>
                                            <tr>
                                                <td colspan="9" class="text-center">No records found.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($rows as $r): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($r['id']) ?></td>
                                                    <td><?= htmlspecialchars(date('d M Y', strtotime($r['eval_date']))) ?></td>
                                                    <td><?= htmlspecialchars($r['session']) ?></td>
                                                    <td style="max-width:260px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?= htmlspecialchars($r['topic']) ?>"><?= htmlspecialchars($r['topic']) ?></td>
                                                    <td>
                                                        <?= htmlspecialchars($r['teacher_name']) ?>
                                                        <?php if (!empty($r['teacher_id'])): ?>
                                                            <div class="text-muted small"><?= htmlspecialchars($r['teacher_id']) ?></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($r['class_section']) ?></td>
                                                    <td><?= htmlspecialchars($r['total']) ?></td>
                                                    <td><?= htmlspecialchars($r['evaluator_name']) ?></td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="edit_class_show.php?id=<?= urlencode($r['id']) ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                        <a class="btn btn-sm btn-secondary" href="view_class_show.php?id=<?= urlencode($r['id']) ?>" target="_blank"><i class="fa-solid fa-print"></i></a>
                                                        <a class="btn btn-sm btn-danger" href="<?= htmlspecialchars($baseUrl . 'delete=' . urlencode($r['id'])) ?>" onclick="return confirm('Delete this record? This cannot be undone.')"><i class="fa-solid fa-trash-can"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <?php if ($totalPages > 1): ?>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php
                                        $start = max(1, $page - 3);
                                        $end = min($totalPages, $page + 3);
                                        if ($page > 1):
                                        ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?= htmlspecialchars($baseUrl . 'page=1') ?>">« First</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="<?= htmlspecialchars($baseUrl . 'page=' . ($page - 1)) ?>">‹ Prev</a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($p = $start; $p <= $end; $p++): ?>
                                            <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                                                <a class="page-link" href="<?= htmlspecialchars($baseUrl . 'page=' . $p) ?>"><?= $p ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $totalPages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?= htmlspecialchars($baseUrl . 'page=' . ($page + 1)) ?>">Next ›</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="<?= htmlspecialchars($baseUrl . 'page=' . $totalPages) ?>">Last »</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            <?php endif; ?>

                            <div class="text-muted small mt-2">Showing <?= count($rows) ?> of <?= $totalRows ?> records.</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
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
            var table = jQuery('#classhowTable').DataTable({
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
                table.column(5).search(this.value).draw();
            });

            // Class/Section filter
            jQuery('#filterClass').on('keyup change', function() {
                table.column(6).search(this.value).draw();
            });

            // Class/Section filter
            // jQuery('#filterTotal').on('keyup change', function() {
            //     table.column(7).search(this.value).draw();
            // });
        } else {
            console.warn('DataTables not found. Buttons and filters require DataTables JS/CSS.');
        }
    });
</script>