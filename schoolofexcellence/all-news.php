<?php include('web/header.php'); ?>
<?php
// Load all data
$data = file_exists('admin/photo-gallery/data.json') ? json_decode(file_get_contents('admin/photo-gallery/data.json'), true) : [];
?>
<?php
$images = file_exists('admin/photo-gallery/data.json') ? json_decode(file_get_contents('admin/photo-gallery/data.json'), true) : [];

?>

<section class="promo-sec" style="background: url('images/promo-bg.jpg')no-repeat center center / cover;">
    <img src="images/promo-left.png" alt="" class="anim-img">
    <img src="images/promo-right.png" alt="" class="anim-img anim-right">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-2 text-white">Photo Gallery</h1>
            </div>
        </div>
    </div>
</section>
<section class="blog-sec bg-shade sec-padding">
    <div class="container">
        <div class="d-md-flex justify-content-between align-items-top mb-5 mb-lg-0">
            <div class="sec-intro">
                <h2 class="sec-title mb-0">Latest <span class="color">Activities</span></h2>
            </div>
        </div>
        <div class="row">
            <?php if (empty($images)): ?>
                <p>No photos found.</p>
            <?php else: ?>
                <?php foreach ($images as $img): ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="event-entry shadow-sm overflow-hidden rounded-4">
                            <div class="event-thumb">
                                <img class="card-img-top" src="admin/photo-gallery/uploads/<?= htmlspecialchars($img['filename']) ?>" alt="Image">
                            </div>
                            <div class="entry-content p-4">
                                <div class="event-meta d-flex justify-content-between mb-2">
                                    <span><i class="feather-icon icon-calendar"></i> <?= htmlspecialchars($img['date']) ?></span>
                                    <!-- <span class="event-location"><i class="feather-icon icon-map-pin"></i>253 Avenue, USA</span> -->
                                </div>
                                <h3 class="display-5">
                                    <a href="<?= htmlspecialchars($img['name']) ?>" target="_blank">
                                        <?= htmlspecialchars($img['title']) ?> </a>
                                </h3>
                                <p class="f-14"><?= htmlspecialchars($img['text']) ?></p>
                                <div class="event-footer d-flex justify-content-start align-items-center">
                                    <a class="btn btn-outline-primary rounded-5" href="<?= htmlspecialchars($img['name']) ?>" target="_blank">
                                        View More <i class="feather-icon icon-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <p><a href="index.php">← Back to Home</a></p>
        </div>
    </div>
</section>
<?php include('web/footer.php'); ?>