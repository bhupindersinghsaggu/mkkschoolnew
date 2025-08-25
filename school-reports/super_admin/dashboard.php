<?php
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/database.php';
require_once '../includes/function.php';

?>

<?php
$query = "SELECT * FROM class_show ORDER BY created_at DESC LIMIT 2";
$result = mysqli_query($conn, $query);
// Check if query was successful and has data
 if ($result && mysqli_num_rows($result) > 0):
$latest_class = mysqli_fetch_assoc($result);
                                            
// Calculate average marks
$marks1 = (int)$latest_class['marks_judge1'];
$marks2 = (int)$latest_class['marks_judge2'];
$average_marks = ($marks1 + $marks2) / 2;
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
                            <a href="./add_teacher.php" class="btn btn-success btn-sm">Add New</a>
                            <a href="./list_teacher.php" class="text-decoration-underline fs-13 fw-medium">View All</a>
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
                            <a href="./list_notebook.php" class="text-decoration-underline fs-13 fw-medium">View All</a>
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
                            <a href="./list_class_show.php" class="text-decoration-underline fs-13 fw-medium">View
                                All</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Expenses -->

            <!-- Returns -->
            <!-- <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card revenue-widget flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div>
                                <h4 class="mb-2">$78,458,798</h4>
                                <p>Total Payment Returns</p>
                            </div>
                            <span class="revenue-icon bg-indigo-transparent text-indigo">
                                <i class="ti ti-hash fs-16"></i>
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0"><span class="fs-13 fw-bold text-danger">-20%</span> vs Last Month</p>
                            <a href="sales-report.html" class="text-decoration-underline fs-13 fw-medium">View All</a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="row">
            <div class="col-xxl-4 col-md-6 d-flex">
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
            </div>

            <!-- /Low Stock Products -->

            <!-- Recent Sales -->
              <div class="col-xxl-4 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-inline-flex align-items-center">
                            <span class="title-icon bg-soft-pink fs-16 me-2"><i class="ti ti-box"></i></span>
                            <h5 class="card-title mb-0">Recent Class Show</h5>
                        </div>
                        <a href="./list_class_show.php" class="fs-13 fw-medium text-decoration-underline">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="fw-bold mb-2">
                                        <?php echo htmlspecialchars($latest_class['teacher_name']); ?>
                                    </h6>
                                    <div class="fs-13 mb-2">Class/Section:
                                        <?php echo htmlspecialchars($latest_class['class_section']); ?>
                                    </div>
                                    <div class="fs-13 mb-2">Average No:
                                        <span
                                            class="revenue-icon bg-cyan-transparent text-cyan value"><?php echo number_format($average_marks, 2); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <p class="fs-13 mb-2">
                                <i class="ti ti-calendar"></i>($latest_class['eval_date']); ?>
                                </p>
                                <span class="badge bg-purple badge-xs d-inline-flex align-items-center mb-2">
                                    <h6 class="text-white fw-medium">
                                        <?php echo htmlspecialchars($latest_class['topic']); ?>
                                    </h6>
                                </span>
                                <br>
                                <span class="info-value mb-2">
                                    <a href="<?php echo htmlspecialchars($latest_class['video_link']); ?>"
                                        target="_blank" class="class-link">
                                        <i class="fas fa-external-link-alt"></i> Watch Show
                                    </a>
                                </span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="copyright-footer d-flex align-items-center justify-content-between border-top bg-white gap-3 flex-wrap">
            <p class="fs-13 text-gray-9 mb-0">Designed & Developed By  <span class="theme-color">Bhupinder Singh (IT
                    Department)</p>
        </div>
    </div>
</div>



<!-- /Main Wrapper -->

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