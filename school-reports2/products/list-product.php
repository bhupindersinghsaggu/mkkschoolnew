<!-- <link href="../css/bootstrap.min.css" rel="stylesheet"> -->
<script src="../assets/js/theme-script.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>

<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
<!-- Apple Touch Icon -->
<link rel="apple-touch-icon" sizes="180x180" href="../assets/img/apple-touch-icon.png">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">
<!-- animation CSS -->
<link rel="stylesheet" href="../assets/css/animate.css">
<!-- Select2 CSS -->
<link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
<!-- Daterangepikcer CSS -->
<link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
<!-- Tabler Icon CSS -->
<link rel="stylesheet" href="../assets/plugins/tabler-icons/tabler-icons.min.css">
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
<!-- Color Picker Css -->
<link rel="stylesheet" href="../assets/plugins/%40simonwep/pickr/themes/nano.min.css">
<!-- Main CSS -->
<link rel="stylesheet" href="../assets/css/style.css">
<?php include '../header.php' ?>;
<?php include '../head-nav.php' ?>;
<?php
// Enable all error reporting
error_reporting(E_ALL);

// Display errors on the screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<?php include '../side-bar.php'; ?>
<?php include '../config/db.php'; ?>
<?php
ob_start(); // Start output buffering
?>


<div class="page-wrapper">
    <div class="content">
        <h4 class="title mb-3">List Product</h4>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $search = isset($_GET['search_category']) ? $conn->real_escape_string($_GET['search_category']) : '';
                    $sql = "SELECT products.*, categories.name as cat_name FROM products JOIN categories ON products.category_id = categories.id";

                    if (!empty($search)) {
                        $sql .= " WHERE categories.name LIKE '%$search%'";
                    }

                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                    <td><img src='../uploads/{$row['image']}' width='60'></td>
                    <td>{$row['name']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['cat_name']}</td>
                    <td>
                    <a href='edit-product.php?id={$row['id']}'>Edit</a> |
                    <a href='?delete={$row['id']}'>Delete</a>
                    </td>
                    </tr>";
                    }

                    if (isset($_GET['delete'])) {
                        $id = $_GET['delete'];
                        $conn->query("DELETE FROM products WHERE id=$id");
                        echo "Deleted!";
                    }
                    // ✅ Redirect to avoid duplicate on refresh
                    ?>
                </table>
            </div>
            <div class="col-md-12 mt-3 mb-3">
                <a href="../products/add-product.php" class="btn btn-primary  me-2">Back to Products</a>
            </div>
        </div>
    </div>
    <?php include '../footer.php'; ?>