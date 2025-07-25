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

<a href="add-category.php">Add New Category</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM categories");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>
                    <a href='edit-category.php?id={$row['id']}'>Edit</a> |
                    <a href='?delete={$row['id']}'>Delete</a>
                </td>
              </tr>";
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $conn->query("DELETE FROM categories WHERE id=$id");
        echo "Deleted!";
    }
    ?>
</table>
<script src="../js/jquery.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/slick.min.js"></script>
<script src="../js/slick-animation.min.js"></script>
<script src="../js/jquery.fancybox.js"></script>
<script src="../js/wow.js"></script>
<script src="../js/appear.js"></script>
<script src="../js/mixitup.js"></script>
<script src="../js/flatpickr.js"></script>
<script src="../js/swiper.min.js"></script>
<script src="../js/gsap.min.js"></script>
<script src="../js/ScrollTrigger.min.js"></script>
<script src="../js/SplitText.min.js"></script>
<script src="../js/nice-select.min.js"></script>
<script src="../js/knob.js"></script>
<script src="../js/parallax.js"></script>
<script src="../js/vanilla-tilt.js"></script>
<script src="../js/splitting.js"></script>
<script src="../js/splitType.js"></script>
<script src="../js/script-gsap.js"></script>
<script src="../js/script.js"></script>