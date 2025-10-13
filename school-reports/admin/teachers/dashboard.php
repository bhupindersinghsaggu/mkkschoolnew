<?php
// admin/teachers/list.php - list teachers with edit/delete links
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../auth.php';

$auth = new Auth();

// Check if user is logged in
if (!$auth->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

// Get user role for displaying appropriate dashboard
$role = $_SESSION['role'];
$username = $_SESSION['username'];
$role_name = $auth->getRoleName($role);
$db = new Database();
$conn = $db->getConnection();

// ✅ Fetch logged-in user details
$stmt = $conn->prepare("SELECT fullname, photo FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If no photo uploaded, fallback image
$photoPath = !empty($user['photo']) ? 'uploads/' . $user['photo'] : 'assets/default.png';

//fecth totol no of student
// $stmt = $conn->query("SELECT COUNT(*) AS total_students FROM students");
// $totalStudents = $stmt->fetch(PDO::FETCH_ASSOC)['total_students'];

// counts only students not marked deleted
$stmt = $conn->query("SELECT COUNT(*) AS total_students FROM students WHERE is_deleted = 0");
$totalStudents = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total_students'];

// counts students by Courses

$studentsPerCourse = [];
try {
    // Count distinct active students per course
    $sql = "
        SELECT c.id AS course_id, c.name AS course_name,
               COUNT(DISTINCT s.id) AS student_count
        FROM courses c
        LEFT JOIN student_courses sc ON sc.course_id = c.id
        LEFT JOIN students s ON s.id = sc.student_id AND COALESCE(s.is_deleted, 0) = 0
        GROUP BY c.id, c.name
        ORDER BY student_count DESC, c.name ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $studentsPerCourse = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Dashboard: students per course error: " . $e->getMessage());
    $studentsPerCourse = [];
}


// Fetch total fee collection
$stmt = $conn->query("SELECT SUM(amount) AS total_collection FROM fee_payments");
$totalCollection = $stmt->fetch(PDO::FETCH_ASSOC)['total_collection'];
$totalCollection = $totalCollection ?? 0; // in case null

// Fetch today fee collection
$stmt = $conn->prepare("SELECT SUM(amount) AS today_collection FROM fee_payments WHERE DATE(paid_on) = CURDATE()");
$stmt->execute();
$todayCollection = $stmt->fetch(PDO::FETCH_ASSOC)['today_collection'] ?? 0;


// Fetch total jobwork collection
$stmt = $conn->query("SELECT SUM(fee) AS total_jobcollection FROM job_work");
$totaljobcollection = $stmt->fetch(PDO::FETCH_ASSOC)['total_jobcollection'];
$totaljobcollection = $totaljobcollection ?? 0; // in case null

// Fetch today jobwork collection
$stmt = $conn->prepare("SELECT SUM(fee) AS today_jobcollection FROM job_work WHERE DATE(work_date) = CURDATE()");
$stmt->execute();
$todayjobCollection = $stmt->fetch(PDO::FETCH_ASSOC)['today_jobcollection'] ?? 0;


// Fetch total expence
$stmt = $conn->query("SELECT SUM(amount) AS total_expenses FROM expenses");
$totalexpenses = $stmt->fetch(PDO::FETCH_ASSOC)['total_expenses'];
$totalexpenses = $totalexpenses ?? 0; // in case null

// Fetch today expence collection
$stmt = $conn->prepare("SELECT SUM(amount) AS today_expenses FROM expenses WHERE DATE(expense_date) = CURDATE()");
$stmt->execute();
$todayexpenses = $stmt->fetch(PDO::FETCH_ASSOC)['today_expenses'] ?? 0;




// Log page access
$auth->logActivity($_SESSION['user_id'], "Accessed dashboard");
?>

<?php include __DIR__ . '/../../includes/css.php'; ?>
<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold fs-14 theme-color">Total Teachers</p>
                                    <h3 class="mt-2 mb-0 fw-bold"><?php echo $totalStudents; ?></h3>
                                </div>
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                        <i
                                            class="icofont-ui-user-group h1 align-self-center mb-0 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="fee d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-truncate text-muted mt-3"><a href="courses_report.php" class="btn rounded-pill btn-success">View Report</a></p>
                                <p class="mb-0 text-truncate text-muted mt-3"><a href="add_student.php" class="btn rounded-pill btn-warning">Add New</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-start border-dashed-bottom pb-3">
                                <div class="col-12">
                                    <div class="fee d-flex justify-content-between align-items-center">
                                        <p class="text-dark mb-0 fw-semibold fs-14 theme-color">Total Fee ₹</p>
                                        <h3 class="mt-2 mb-2 fw-bold"><?php echo $totalCollection; ?></h3>
                                    </div>
                                    <div class="fee d-flex justify-content-between align-items-center">
                                        <p class="text-dark mb-0 fw-semibold fs-14 theme-color">Today Fee ₹</p>
                                        <h3 class="mt-2 mb-2 fw-bold"><?php echo $todayCollection; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-0 text-truncate text-muted mt-3"><a href="fee_collection_report.php" class="btn rounded-pill btn-success">View Report</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-start border-dashed-bottom pb-3">
                                <div class="col-12">
                                    <div class="fee d-flex justify-content-between align-items-center">
                                        <p class="text-dark mb-0 fw-semibold fs-14 theme-color">Total Job Work ₹</p>
                                        <h3 class="mt-2 mb-2 fw-bold"><?php echo $totaljobcollection; ?></h3>
                                    </div>
                                    <div class="fee d-flex justify-content-between align-items-center">
                                        <p class="text-dark mb-0 fw-semibold fs-14 theme-color">Today Job Work ₹</p>
                                        <h3 class="mt-2 mb-2 fw-bold"><?php echo $todayjobCollection; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-0 text-truncate text-muted mt-3"><a href="manage_jobs.php" class="btn rounded-pill btn-danger">View Report</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-start border-dashed-bottom pb-3">
                                <div class="col-12">
                                    <div class="fee d-flex justify-content-between align-items-center">
                                        <p class="text-dark mb-0 fw-semibold fs-14 theme-color">Total Expenses ₹</p>
                                        <h3 class="mt-2 mb-2 fw-bold"><?php echo $totalexpenses; ?></h3>
                                    </div>
                                    <div class="fee d-flex justify-content-between align-items-center">
                                        <p class="text-dark mb-0 fw-semibold fs-14 theme-color">Today Expenses ₹</p>
                                        <h3 class="mt-2 mb-2 fw-bold"><?php echo $todayexpenses; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-0 text-truncate text-muted mt-3"><a href="fee_collection_report.php" class="btn rounded-pill btn-secondary">View Report</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="Appearance" aria-labelledby="AppearanceLabel">
            <div class="offcanvas-header border-bottom justify-content-between">
                <h5 class="m-0 font-14" id="AppearanceLabel">Appearance</h5>
                <button type="button" class="btn-close text-reset p-0 m-0 align-self-center"
                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <h6>Account Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch1">
                        <label class="form-check-label" for="settings-switch1">Auto updates</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch2" checked>
                        <label class="form-check-label" for="settings-switch2">Location Permission</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch3">
                        <label class="form-check-label" for="settings-switch3">Show offline Contacts</label>
                    </div>
                </div>
                <h6>General Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch4">
                        <label class="form-check-label" for="settings-switch4">Show me Online</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch5" checked>
                        <label class="form-check-label" for="settings-switch5">Status visible to all</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch6">
                        <label class="form-check-label" for="settings-switch6">Notifications Popup</label>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer text-center text-sm-start d-print-none">
            <div class="container-xxl">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0 rounded-bottom-0">
                            <div class="card-body">
                                <p class="text-muted mb-0">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script>
                                    Bharat Computer & Coaching
                                    <span class="text-muted d-none d-sm-inline-block float-end">
                                        Crafted with
                                        <i class="iconoir-heart text-danger"></i>
                                        by Bhupinder Singh</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
</body>

</html>