<?php ob_start();?>
<?php include '../side-bar.php'; ?>
<?php include '../config/db.php'; ?>
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
<?php ob_start();?>
<?php include '../side-bar.php'; ?>
<?php include '../config/db.php'; ?>

<div class="page-wrapper">
    <div class="content">
        <h4 class="title mb-3">Add Product</h4>
        <div class="row">
            <div class=" col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" enctype="multipart/form-data">
                            <select class="select form-control mt-4 " name="category_id" required>
                                <option value="">Select Category</option>
                                <?php
                                $result = $conn->query("SELECT * FROM categories");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 add-product">
                            <label class="form-label">Product Name<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Price<span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control" name="price">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Description<span class="text-danger ms-1">*</span></label>
                        <textarea class=" form-control" name="description"></textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="file" class="mt-4 " name="image" required>
                    </div>
                    <div class="col-md-12 mt-3 mb-3">
                        <button type="submit" class="btn btn-secondary me-2" name="submit">Add</button>
                        <a href="../categories/add-category.php" class="btn btn-primary  me-2">Back to Category</a>
                    </div>
                    </form>
                </div>

                <?php
                if (isset($_GET['success'])) {
                    echo '<div class="alert alert-success">Product added successfully!</div>';
                }
                

                $categoryAdded = false;
                if (isset($_POST['submit'])) {
                $category_id = $_POST['category_id'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $desc = $_POST['description'];
                $image = $_FILES['image']['name'];
                $target = "../uploads/" . basename($image);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $stmt = $conn->prepare("INSERT INTO products (category_id, name, price, description, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("isdss", $category_id, $name, $price, $desc, $image);
                $stmt->execute();
                $productAdded = true;
                header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                exit;
                }
                }
                ?>
            </div>
            <div class="col-md-4">
                <form method="GET">
                    <div class="form-group d-flex">
                        <input type="text" name="search_category" class="form-control me-2" placeholder="Search by Category..." value="<?php echo isset($_GET['search_category']) ? htmlspecialchars($_GET['search_category']) : ''; ?>">
                        <button type="submit" class="btn btn-secondary me-2">Search</button>
                    </div>
                </form>

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
                    $sql .= " ORDER BY products.id DESC"; // 🔽 Latest first
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                     <td><img src='../uploads/{$row['image']}' width='60'></td>
                     <td>{$row['name']}</td>
                     <td>{$row['price']}</td>
                     <td>{$row['cat_name']}</td>
                     <td>
                     <a href='edit-product.php?id={$row['id']}'>Edit</a> |
                    
                    <a href='?delete={$row['id']}' class='text-danger' onclick=\"return confirm('Are you sure you want to delete this category?')\">Delete</a>
                    </td>

              </tr>";
                    }

                    if (isset($_GET['delete'])) {
                        $id = (int) $_GET['delete'];
                        $conn->query("DELETE FROM products WHERE id=$id");
                        echo "<script>location.href=location.pathname;</script>"; // Refresh to clean URL
                    }

                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->

<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>