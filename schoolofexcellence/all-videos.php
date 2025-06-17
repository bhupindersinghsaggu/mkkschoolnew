<?php
$dataFile = 'admin/video-gallery/data.json';
$data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
?>
<?php include('web/header.php'); ?>

<section class="promo-sec" style="background: url('images/promo-bg.jpg')no-repeat center center / cover;">
    <img src="images/promo-left.png" alt="" class="anim-img">
    <img src="images/promo-right.png" alt="" class="anim-img anim-right">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-2 text-white">Video Gallery</h1>
            </div>
        </div>
    </div>
</section>
<section class="blog-sec bg-shade sec-padding">
    <div class="container">
        <div class="row">
            <?php if (empty($data)): ?>
                <p>No photos found.</p>
            <?php else: ?>
                <?php foreach (array_reverse($data) as $item): ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="event-entry shadow-sm overflow-hidden rounded-4">
                            <div class="event-thumb">
                                <img class="card-img-top" src="<?= htmlspecialchars($item['thumbnail']) ?>" alt="Thumbnail" onclick="openModal('<?= $item['youtube_id'] ?>')">
                            </div>
                            <div class="entry-content p-4">
                                <div class="event-meta d-flex justify-content-between mb-2">
                                    <span><i class="feather-icon icon-calendar"></i> <?= htmlspecialchars($item['date']) ?> – <?= htmlspecialchars($item['name']) ?></span>
                                </div>
                                <h3 class="display-5">
                                    <?= htmlspecialchars($item['title']) ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<div id="modal" class="modal" onclick="closeModal()">
    <span class="close">&times;</span>
    <iframe id="modalVideo" src="" frameborder="0" allowfullscreen></iframe>
</div>

<script>
    function openModal(videoId) {
        document.getElementById('modal').style.display = 'flex';
        document.getElementById('modalVideo').src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
    }

    function closeModal() {
        document.getElementById('modal').style.display = 'none';
        document.getElementById('modalVideo').src = '';
    }
</script>