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

<div class="page-wrapper">
    <div class="content">
        <h4 class="title mb-3">Edit Category</h4>
        <div class="row">
            <div class="col-md-4">
                <?php
                $id = $_GET['id'];
                $result = $conn->query("SELECT * FROM categories WHERE id=$id");
                $row = $result->fetch_assoc();
                ?>
                <form method="POST">
                    <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required>
                    <button type="submit" name="update" class="btn btn-primary  me-2 mb-3 mt-3">Update Category</button>
                    <a href="../categories/add-category.php"  class="btn btn-dark  me-2">Back to Category</a>
                </form>
                <?php
                if (isset($_POST['update'])) {
                    $name = $_POST['name'];
                    $conn->query("UPDATE categories SET name='$name' WHERE id=$id");
                    echo "Category updated!";
                }
                ?>
            </div>
        </div>
    </div>
    <?php include '../footer.php'; ?>