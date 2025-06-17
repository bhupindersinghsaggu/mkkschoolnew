<?php
$index = $_GET['index'];
$data = file_exists('data.json') ? json_decode(file_get_contents('data.json'), true) : [];

if (!isset($data[$index])) {
    die("Invalid photo index.");
}

$item = $data[$index];
?>
<?php include('../web/css.php') ?>
<?php include('../web/header.php') ?>
<div class="row mt-5">
    <div class="col-lg-3">
        <?php include('../web/aside.php') ?>
    </div>
    <div class="col-lg-9 ps-lg-4">
        <section class="dashboard-sec">
            <h4>Edit Photo Gallery</h4>
            <form action="update.php" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 form-group mt-20">
                            <input class="form-control" type="hidden" name="index" placeholder="Title" value="<?= $index ?>">
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input class="form-control" type="text" name="title" placeholder="Title" value="<?= htmlspecialchars($item['title']) ?>" required>
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input class="form-control" type="text" name="name" placeholder="URL" value="<?= htmlspecialchars($item['name']) ?>" required>
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input class="form-control" type="date" name="date" placeholder="Date" value="<?= htmlspecialchars($item['date']) ?>" required>
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input class="form-control" type="text" name="text" placeholder="Description" value="<?= htmlspecialchars($item['text']) ?>" required>
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input type="submit" value="Update" class="btn d-none d-lg-block btn-primary shadow border-0 rounded-2">
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<?php include('../web/footer.php') ?>
</body>

</html>