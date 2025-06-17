<?php
$data = file_exists('data.json') ? json_decode(file_get_contents('data.json'), true) : [];
$createIndex = isset($_GET['create']) ? (int) $_GET['create'] : null;
$createItem = $createIndex !== null ? $data[$createIndex] : null;
?>
<?php include('../web/css.php') ?>
<?php include('../web/header.php') ?>
<div class="row mt-5">
    <div class="col-lg-3">
        <?php include('../web/aside.php') ?>
    </div>
    <div class="col-lg-9 ps-lg-4">
        <section class="dashboard-sec">
            <h4><?= $createItem ? 'Update Video' : 'Upload YouTube Video' ?></h4>
            <form class="video-form" action="upload.php" method="POST">
                <div class="container">
                    <div class="row">
                        
                        <div class="col-lg-6 form-group mt-20">
                            <input type="text" name="title" placeholder="Video Title" required value="<?= $createItem['title'] ?? '' ?>">
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input type="text" name="name" placeholder="Uploaded By" required value="<?= $createItem['name'] ?? '' ?>">
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input type="date" name="date" required value="<?= $createItem['date'] ?? '' ?>">
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <input type="url" name="youtube" placeholder="YouTube Video Link" required value="<?= isset($createItem['youtube_id']) ? 'https://www.youtube.com/watch?v=' . $createItem['youtube_id'] : '' ?>"><br><br>
                        </div>
                        <div class="col-lg-6 form-group mt-20">
                            <button class="btn d-none d-lg-block btn-primary shadow border-0 rounded-2" type="submit"><?= $createItem ? 'Update Video' : 'Add Video' ?></button>
                        </div>
                    </div>
                </div>
            </form>
            <h4>Uploaded Video</h4>
            <table class="table table-responsive-sm ">
                <tr>
                    <th style="width: 60px;">Title</th>
                    <th style="width: 60px;">Thumbnail</th>
                    <th style="width: 60px;">Uploaded By</th>
                    <th style="width: 60px;">Date</th>
                    <!-- <th style="width:60px;">Decription</th> -->
                    <th style="width: 60px;">Delete</th>
                </tr>
                <?php foreach (array_reverse($data) as $i => $item): ?>
                    <tr>
                        <td style="width: 60px;"><?= htmlspecialchars($item['title'] ?? '') ?></td>
                        <td style="width: 60px;"><img class="thumbnail" style="width:100px" src="<?= htmlspecialchars($item['thumbnail'] ?? '') ?>" alt="Thumbnail" onclick="openModal('<?= $item['youtube_id'] ?? '' ?>')"></td>
                        <td style="width: 60px;"><?= htmlspecialchars($item['name']) ?></td>
                        <td style="width: 60px;"><?= htmlspecialchars($item['date']) ?></td>
                        <td>
                            <form action="delete.php" method="post" onsubmit="return confirm('Delete this image?');">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <button type="submit" value="Delete"> <i class="fa-solid fa-trash-can" style="color:brown"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div id="modal" style="display:none; position:fixed; top:10%; left:10%; width:80%; height:80%; background:rgba(0,0,0,0.8);">
                <span onclick="closeModal()" style="position:absolute; top:10px; right:20px; font-size:24px; color:white; cursor:pointer;">×</span>
                <iframe id="modalVideo" src="" style="width:100%; height:100%;" frameborder="0" allowfullscreen></iframe>
            </div>
        </section>
         <div class="">
            <p class="text-mute mb-20 mt-20">© 2025 Design by <a class="text-secondary" href="https://www.theme-village.com/">Bhupinder Singh</a>. All Rights Reserved.</p>
        </div>
    </div>
</div>
<script>
    function openModal(videoId) {
        document.getElementById('modal').style.display = 'block';
        document.getElementById('modalVideo').src = 'https://www.youtube.com/embed/' + videoId;
    }

    function closeModal() {
        document.getElementById('modal').style.display = 'none';
        document.getElementById('modalVideo').src = '';
    }
</script>