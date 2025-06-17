<?php
$images = file_exists('admin/photo-gallery/data.json') ? json_decode(file_get_contents('admin/photo-gallery/data.json'), true) : [];
$latestPosts = array_slice(array_reverse($images), 0, 4);
?>
<?php
$data = file_exists('admin/photo-gallery/data.json') ? json_decode(file_get_contents('admin/photo-gallery/data.json'), true) : [];
?>


<section class="blog-sec bg-shade sec-padding">
    <div class="container">
        <div class="d-md-flex justify-content-between align-items-top mb-5 mb-lg-0">
            <div class="sec-intro">
                <span class="badge-lg bg-primary rounded-5">Blog &amp; News</span>
                <h2 class="sec-title mb-0">Latest <span class="color">Activities</span></h2>
            </div>
            <a href="all-news.php" class="btn btn-primary align-self-start shadow rounded-5">View All</a>
        </div>
        <div class="row">
            <?php if (empty($images)): ?>
                <p>No photos found.</p>
            <?php else: ?>
                <?php foreach ($latestPosts as $img): ?>
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
        </div>
    </div>
</section>