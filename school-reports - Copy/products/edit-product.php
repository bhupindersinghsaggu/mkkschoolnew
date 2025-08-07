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
<?php include '../header.php'; ?>
<?php include '../head-nav.php'; ?>

<?php
ob_start(); // Start output buffering
include '../side-bar.php'; // or wherever your include is
?>
<?php include '../config/db.php'; ?>


<?php

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();
?>
<div class="page-wrapper">
    <div class="content">
        <h4 class="title mb-3">Edit Product</h4>
        <div class="row">
            <div class="col-md-6 lg-6">
                <form method="POST" enctype="multipart/form-data">
                    <label class="form-label">Product Category<span class="text-danger ms-1">*</span></label>
                    <select name="category_id" class="form-control mb-3" required>
                        <?php
                        $cats = $conn->query("SELECT * FROM categories");
                        while ($cat = $cats->fetch_assoc()) {
                            $selected = ($cat['id'] == $product['category_id']) ? 'selected' : '';
                            echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                        }
                        ?>
                    </select>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Product Name<span class="text-danger ms-1">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Product Price<span class="text-danger ms-1">*</span></label>
                        <input type="text" name="price" class="form-control" value="<?= $product['price'] ?>" required>
                    </div>
                    <label class="form-label">Description<span class="text-danger ms-1">*</span></label>
                    <div class="col-md-12 mb-3">
                        <textarea name="description" class="form-control"><?= $product['description'] ?></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <input type="file" name="image">
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" name="update" class="btn btn-primary me-2">Update Product</button>
                        <a href="./add-product.php" class="btn btn-secondary  me-2">Back to Products</a>
                    </div>
                </form>

                <?php
                if (isset($_POST['update'])) {
                    $cat_id = $_POST['category_id'];
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $desc = $_POST['description'];
                    $image = $_FILES['image']['name'];

                    if ($image != "") {
                        $target = "../uploads/" . basename($image);
                        move_uploaded_file($_FILES['image']['tmp_name'], $target);
                        $conn->query("UPDATE products SET category_id=$cat_id, name='$name', price=$price, description='$desc', image='$image' WHERE id=$id");
                    } else {
                        $conn->query("UPDATE products SET category_id=$cat_id, name='$name', price=$price, description='$desc' WHERE id=$id");
                    }

                    // ✅ Redirect to avoid duplicate on refresh
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                    echo "Product updated!";
                }
                ?>
            </div>
        </div>
    </div>

    <?php include '../footer.php'; ?>