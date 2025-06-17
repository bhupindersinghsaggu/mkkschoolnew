<?php
$images = file_exists('data.json') ? json_decode(file_get_contents('data.json'), true) : [];
?>

<style>
    img {
        width: 50px;
    }
</style>

<?php include('../web/css.php') ?>
<?php include('../web/header.php') ?>
<div class="row mt-5">
    <div class="col-lg-3">
        <?php include('../web/aside.php') ?>
    </div>
    <div class="col-lg-9 ps-lg-4">
        <section class="dashboard-sec">
            <h4>Create Photo Gallery</h4>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 form-group mt-20">
                            <input class="form-control" name="title" type="text" placeholder="Title" required="">
                            <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input class="form-control" name="name" type="text" placeholder="Facebook-Link" required="">
                            <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input class="form-control" name="date" type="date" placeholder="Date" required="">
                            <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input class="form-control" name="text" type="text" placeholder="Decription" required="">
                            <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input class="form-control" type="file" name="image" accept="image/*" required="">
                            <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input type="submit" value="Upload" class="btn d-none d-lg-block btn-primary shadow border-0 rounded-2">
                            <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-responsive-sm ">
                            <tr>
                                <th style="width: 60px;">Date</th>
                                <th style="width: 60px;">Photo</th>
                                <th style="width: 60px;">Title</th>
                                <th style="width: 60px;">URL</th>
                                <th style="width:60px;">Decription</th>
                                <th style="width: 60px;">Delete</th>
                                <th style="width: 60px;">Edit</th>
                            </tr>
                            <?php foreach ($images as $index => $img): ?>
                                <tr>
                                    <td style="width: 60px;"><?= htmlspecialchars($img['date']) ?></td>
                                    <td style="width: 60px;"><img src="uploads/<?= htmlspecialchars($img['filename']) ?>"></td>
                                    <td style="width: 60px;"><?= htmlspecialchars($img['title']) ?></td>
                                    <td style="width: 60px;"><?= htmlspecialchars($img['name']) ?></td>
                                    <td style="width: 60px;"><?= htmlspecialchars($img['text']) ?></td>
                                    <td>
                                        <form action="delete.php" method="post" onsubmit="return confirm('Delete this image?');">
                                            <input type="hidden" name="index" value="<?= $index ?>">
                                            <button type="submit" value="Delete"> <i class="fa-solid fa-trash-can" style="color:brown"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="edit.php" method="get">
                                            <input type="hidden" name="index" value="<?= $index ?>">
                                            <button type="submit" value="Edit"> <i class="fa-solid fa-pen-to-square"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>

            </div>
        </section>
        <div class="">
            <p class="text-mute mb-20 mt-20">© 2025 Design by <a class="text-secondary" href="https://www.theme-village.com/">Bhupinder Singh</a>. All Rights Reserved.</p>
        </div>

    </div>

</div>