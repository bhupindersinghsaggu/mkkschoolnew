<?php
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/database.php';
require_once '../includes/function.php';

?>


<div class="page-wrapper">
    <div class="content">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
            <div class="card  ">
                <div class="card-header d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="d-inline-flex align-items-center">
                            <span class="title-icon bg-soft-info fs-16 me-2"><i class="ti ti-info-circle"></i></span>
                            <h4 class="card-title mb-0">Welcome </h4>
                        </div>
                        <h4 class="card-title px-2 theme-color"><?php echo getGreetingWithEmoji(); ?></h3>
                            <!-- <p class="fw-medium">You have <span class="text-primary fw-bold">200+</span> Orders, Today</p> -->
                    </div>
                </div>
            </div>
            <!-- <div class="input-icon-start position-relative mb-3">
                <span class="input-icon-addon fs-16 text-gray-9">
                    <i class="ti ti-calendar"></i>
                </span>
                <input type="text" class="form-control date-range bookingrange" placeholder="Search Product">
            </div> -->
        </div>
        <!-- <div class="alert bg-orange-transparent alert-dismissible fade show mb-4">
            <div>
                <span><i class="ti ti-info-circle fs-14 text-orange me-2"></i>Your Product </span> <span class="text-orange fw-semibold"> Apple Iphone 15 is running Low, </span> already below 5 Pcs., <a href="javascript:void(0);" class="link-orange text-decoration-underline fw-semibold" data-bs-toggle="modal" data-bs-target="#add-stock">Add Stock</a>
            </div>
            <button type="button" class="btn-close text-gray-9 fs-14" data-bs-dismiss="alert" aria-label="Close"><i class="ti ti-x"></i></button>
        </div> -->
        <div class="row">
            <!-- Profit -->
            <div class="col-xl-4 col-sm-6 col-12 d-flex">
                <div class="card revenue-widget flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <h5 class="card-title mb-0">Total Teacher</h5>
                            <span class="revenue-icon bg-cyan-transparent text-cyan">
                                <?php echo $total_teachers; ?>
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="./register_teacher.php" class="btn btn-success btn-sm">Add New</a>
                            <!-- <a href="./list_teacher.php" class="text-decoration-underline fs-13 fw-medium">View All</a> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Profit -->

            <!-- Invoice -->
            <div class="col-xl-4 col-sm-6 col-12 d-flex">
                <div class="card revenue-widget flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <h5 class="card-title mb-0">Total Notebook Check </h5>
                            <span class="revenue-icon bg-teal-transparent text-teal">
                                <?php echo $notebook_count; ?>
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="./add_notebook.php" class="btn btn-primary btn-sm">Add New</a>
                            <!-- <a href="./list_notebook.php" class="text-decoration-underline fs-13 fw-medium">View All</a> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Expenses -->
            <div class="col-xl-4 col-sm-6 col-12 d-flex">
                <div class="card revenue-widget flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <h5 class="card-title mb-0">Total Class Show </h5>
                            <span class="revenue-icon bg-orange-transparent text-orange">
                                <?php echo $class_show_count; ?>
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="./add_class_show.php" class="btn btn-primary btn-sm">Add New</a>
                            <!-- <a href="./list_class_show.php" class="text-decoration-underline fs-13 fw-medium">View
                                All</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-4 col-md-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-inline-flex align-items-center">
                            <span class="title-icon bg-soft-pink fs-16 me-2"><i class="ti ti-box"></i></span>
                            <h5 class="card-title mb-0">Recent Notebook Check</h5>
                        </div>
                        <a href="./list_notebook.php" class="fs-13 fw-medium text-decoration-underline">View All</a>
                    </div>
                    <div class="card-body">
                        <?php
                        $notebook_query = "SELECT * FROM records ORDER BY created_at DESC LIMIT 3";
                        $notebook_result = mysqli_query($conn, $notebook_query);
                        $recent_notebooks = [];
                        if ($notebook_result && mysqli_num_rows($notebook_result) > 0) {
                            while ($row = mysqli_fetch_assoc($notebook_result)) {
                                $recent_notebooks[] = $row;
                            }
                        }
                        ?>
                        <?php if (!empty($recent_notebooks)):
                            foreach ($recent_notebooks as $latest_notebook):
                                // Get the document path
                                $docPath = '';
                                $hasDocument = false;

                                if (!empty($latest_notebook['document'])) {
                                    $docPath = '../uploads/teacher_documents/' . htmlspecialchars(basename($latest_notebook['document']));
                                    $allowedPath = realpath('../uploads/teacher_documents/');
                                    $currentPath = realpath($docPath);

                                    if ($currentPath && strpos($currentPath, $allowedPath) === 0 && file_exists($currentPath)) {
                                        $hasDocument = true;
                                    }
                                }
                        ?>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="fw-bold mb-2">
                                                <?php echo htmlspecialchars($latest_notebook['teacher_name']); ?>
                                            </h6>
                                            <div class="fs-13 mb-2">Class/Section:
                                                <strong><?php echo htmlspecialchars($latest_notebook['class_section']); ?></strong>
                                            </div>
                                            <div class="fs-13 mb-2">Notebook Checked
                                                <span class="revenue-icon bg-cyan-transparent text-cyan value">
                                                    <?php echo htmlspecialchars($latest_notebook['notebooks_checked']); ?>
                                                </span>
                                            </div>





                                            <td>
                                                <?php
                                                if (!empty($row['document'])):
                                                    // Build safe path
                                                    $docName = basename($row['document']);
                                                    $docPath = realpath(__DIR__ . '/../uploads/teacher_documents/' . $docName);
                                                    $allowedDir = realpath(__DIR__ . '/../uploads/teacher_documents/');
                                                    $fileExists = ($docPath && $allowedDir && strpos($docPath, $allowedDir) === 0 && file_exists($docPath));
                                                    $webPath = $fileExists ? '../uploads/teacher_documents/' . $docName : '';

                                                    if ($fileExists): ?>
                                                        <a href="<?= htmlspecialchars($webPath) ?>"
                                                            class="btn btn-sm btn-success"
                                                            download>
                                                            <i class="fa fa-download"></i> Download
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">File not found</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">No document</span>
                                                <?php endif; ?>
                                            </td>

                                        </div>
                                    </div>

                                </div>

                            <?php endforeach;
                        else: ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-md-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-inline-flex align-items-center">
                            <span class="title-icon bg-soft-pink fs-16 me-2"><i class="ti ti-box"></i></span>
                            <h5 class="card-title mb-0">Recent Class Show</h5>
                        </div>
                        <a href="./list_class_show.php" class="fs-13 fw-medium text-decoration-underline">View All</a>
                    </div>
                    <div class="card-body">
                        <?php
                        // Fetch the 2 latest class_show records
                        $latest_sql = "SELECT cs.*, td.profile_pic AS teacher_photo
                           FROM class_show cs
                           LEFT JOIN teacher_details td ON cs.teacher_id = td.teacher_id
                           ORDER BY cs.created_at DESC
                           LIMIT 3";
                        $latest_res = mysqli_query($conn, $latest_sql);

                        if ($latest_res && mysqli_num_rows($latest_res) > 0):
                            while ($latest = mysqli_fetch_assoc($latest_res)):

                                // Safe values
                                $id = (int)$latest['id'];
                                $teacher_name = htmlspecialchars($latest['teacher_name'] ?? 'Unknown');
                                $class_section = htmlspecialchars($latest['class_section'] ?? '');
                                $topic = htmlspecialchars($latest['topic'] ?? '');
                                $eval_date = !empty($latest['eval_date']) ? htmlspecialchars($latest['eval_date']) : '';
                                // $comments_preview = htmlspecialchars($latest['comments1'] ?? $latest['comments2'] ?? '');
                                // trim to 120 chars
                                // if (strlen($comments_preview) > 120) {
                                //     $comments_preview = substr($comments_preview, 0, 120) . '...';
                                // }
                                // Average marks (safe numeric)
                                $marks1 = is_numeric($latest['marks_judge1']) ? (float)$latest['marks_judge1'] : 0;
                                $marks2 = is_numeric($latest['marks_judge2']) ? (float)$latest['marks_judge2'] : 0;
                                $average_marks = ($marks1 + $marks2) / 2;

                                // Teacher photo handling (prevent path traversal)
                                $photoPath = '../assets/img/default-teacher.png';
                                if (!empty($latest['teacher_photo'])) {
                                    $candidate = '../uploads/profile_pics/' . basename($latest['teacher_photo']);
                                    $allowed = realpath('../uploads/profile_pics/');
                                    $real = realpath($candidate);
                                    if ($real && $allowed && strpos($real, $allowed) === 0 && file_exists($real)) {
                                        // use a relative web path for image src
                                        $photoPath = $candidate;
                                    }
                                }

                                $viewUrl = './view_class_show.php?id=' . urlencode($id);
                                $printUrl = './print_single_class_show.php?id=' . urlencode($id); ?>
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <div style="width:64px; height:64px; flex:0 0 64px;">
                                        <img src="<?= $photoPath ?>" alt="<?= $teacher_name ?>"
                                            style="width:64px;height:64px;object-fit:cover;border-radius:6px;border:1px solid #eee;">
                                    </div>

                                    <div class="flex-fill">
                                        <h6 class="fw-bold mb-1"><?= $teacher_name ?></h6>

                                        <div class="fs-13 mb-1">
                                            <strong>Class:</strong> <?= $class_section ?>
                                            &nbsp;·&nbsp;
                                            <strong>Date:</strong> <?= $eval_date ?>
                                        </div>

                                        <div class="fs-13 mb-1">
                                            <strong>Topic:</strong> <?= $topic ?>
                                        </div>
                                        <!-- 
                                        <div class="fs-13 mb-2 text-muted">
                                            <?= $comments_preview ?: '<em>No comments</em>' ?>
                                        </div> -->

                                        <div class="d-flex gap-2">
                                            <a href="<?= $viewUrl ?>" class="btn btn-outline- btn-sm bg-purple" style="">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="<?= $printUrl ?>" target="_blank" class="btn btn-success btn-sm">
                                                <i class="fas fa-print"></i> Print
                                            </a>

                                            <div class="ms-auto text-end">
                                                <small class="text-muted">Avg: <strong><?= number_format($average_marks, 2) ?></strong></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($latest_res) && mysqli_num_rows($latest_res) > 0) : ?>
                                    <hr style="margin: 8px 0;">
                                <?php endif; ?>

                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-muted">No class show records found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- <div class="col-xxl-4 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-inline-flex align-items-center">
                            <span class="title-icon bg-soft-danger fs-16 me-2"><i
                                    class="fa-solid fa-circle-user"></i></span>
                            <h5 class="card-title mb-0">Latest Teacher Added</h5>
                        </div>
                        <a href="./list_teacher.php" class="fs-13 fw-medium text-decoration-underline">View All</a>
                    </div>
                    <div class="card-body">
                        <?php if ($latest_teacher): ?>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center">
                                    <?php if ($latest_teacher['profile_pic']): ?>
                                        <img src="../uploads/profile_pics/<?php echo htmlspecialchars($latest_teacher['profile_pic']); ?>"
                                            class="rounded-circle mb-2" style="width: 60px; height: 60px; object-fit: cover;"
                                            alt="<?php echo htmlspecialchars($latest_teacher['teacher_name']); ?>">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3"
                                            style="width: 60px; height: 60px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="ms-2">
                                        <h6 class="fw-bold mb-2">
                                            <?php echo htmlspecialchars($latest_teacher['teacher_name']); ?>
                                        </h6>
                                        <p class="fs-13">ID: <?php echo htmlspecialchars($latest_teacher['teacher_id']); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <p class="fs-13 mb-1"><?php echo htmlspecialchars($latest_teacher['teacher_type']); ?>
                                    </p>
                                    <span class="badge bg-purple badge-xs d-inline-flex align-items-center">
                                        <h6 class="text-white fw-medium">
                                            <?php echo htmlspecialchars($latest_teacher['subject']); ?>
                                            </h6v>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <div class="copyright-footer d-flex align-items-center justify-content-between border-top bg-white gap-3 flex-wrap">
        <p class="fs-13 text-gray-9 mb-0">Designed & Developed By <span class="theme-color">Bhupinder Singh (IT
                Department)</p>
    </div>
</div>
<script>
    // Simple animation on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const animatedElements = document.querySelectorAll('.animate-fadeIn');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.visibility = 'visible';
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        animatedElements.forEach(el => {
            el.style.visibility = 'hidden';
            observer.observe(el);
        });
    });

    // date on dashboard
    // Add this script to display the current date
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
    });
</script>

<script>
    // You can add any dynamic functionality here if needed
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Class dashboard component loaded');

        // Add click event to all class links to track engagement
        const classLinks = document.querySelectorAll('.class-link');
        classLinks.forEach(link => {
            link.addEventListener('click', function() {
                console.log('Class video link clicked: ' + this.href);
            });
        });
    });
</script>

<?php require_once '../includes/footer.php'; ?>