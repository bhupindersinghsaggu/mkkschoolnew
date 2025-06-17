<?php
$dataFile = 'admin/video-gallery/data.json'; // correct path
$data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
?>


<title>Video Gallery</title>
<style>
    .gallery-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .video-card {
        width: 320px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        text-align: center;
        padding: 10px;
    }

    .video-card img {
        width: 100%;
        cursor: pointer;
        border-bottom: 1px solid #ddd;
    }

    .video-card h4 {
        margin: 10px 0 5px;
    }

    .video-card p {
        margin: 0;
        font-size: 0.9em;
        color: #666;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    }

    .modal iframe {
        width: 80%;
        height: 80%;
        max-width: 800px;
    }

    .close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: #fff;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
    }
</style>

<section class="blog-sec bg-shade">
    <div class="container">
        <div class="d-md-flex justify-content-between align-items-top mb-5 mb-lg-0">
            <div class="sec-intro">
                <h2 class="sec-title mb-0">Latest <span class="color">Videos</span></h2>
            </div>
            <a href="all-videos.php" class="btn btn-primary align-self-start shadow rounded-5">View All</a>
        </div>
        <div class="row">
            <?php if (empty($data)): ?>
                <p>No videos found.</p>
            <?php else: ?>
                <?php foreach (array_slice(array_reverse($data), 0, 4) as $item): ?>
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