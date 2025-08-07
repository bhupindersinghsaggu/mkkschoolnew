<?php
ob_start(); // ✅ Must be first line to prevent header issues
include '../config/db.php';
include '../header.php';
include '../head-nav.php';
include '../side-bar.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// 🔁 Slug generator
function generateSlug($string)
{
    $slug = strtolower($string);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    return trim($slug, '-');
}

// ✅ Handle category add BEFORE HTML
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $slug = generateSlug($name);

    $stmt = $conn->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $slug);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
    exit;
}

// ✅ Handle delete BEFORE HTML
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM categories WHERE id=$id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!-- HTML starts AFTER all logic -->
    <title>Add Category</title>
    <!-- CSS Links -->
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

<div class="page-wrapper">
    <div class="content">
        <h4 class="title mb-3">Add Category</h4>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Category added successfully!</div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-6">
                <form method="POST">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Category Name" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn btn-primary me-2">Add Category</button>
                        <a href="../products/add-product.php" class="btn btn-secondary me-2">Back to Products</a>
                    </div>
                </form>
            </div>

            <div class="col-sm-6">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['slug']}</td>
                            <td>
                                <a href='edit-category.php?id={$row['id']}'>Edit</a> |
                                <a href='?delete={$row['id']}' class='text-danger' onclick=\"return confirm('Are you sure you want to delete this category?')\">Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>

