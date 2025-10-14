<?php
// navigation.php - Navigation based on user role
$current_page = basename($_SERVER['PHP_SELF']);

// Get the user's role from session
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>

<div class="startbar-menu">
    <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
        <div class="d-flex align-items-start flex-column w-100">
            <ul class="navbar-nav mb-auto w-100">
                <li class="menu-label pt-0 mt-0">
                    <span>Main Menu</span>
                </li>

                <li class="nav-item">
                    <a href="<?php echo ($user_role == ROLE_TEACHER) ? 'student_dashboard.php' : 'dashboard.php'; ?>"
                        class="nav-link <?php echo ($current_page == 'dashboard.php' || $current_page == 'student_dashboard.php') ? 'active' : ''; ?>">
                        Dashboard
                    </a>
                </li>

                <?php if ($user_role == ROLE_SUPER_ADMIN): ?>
                    <li class="nav-item">
                        <a href="manage_users.php" class="nav-link <?php echo ($current_page == 'manage_users.php') ? 'active' : ''; ?>">
                            Manage Users
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($user_role == ROLE_ADMIN || $user_role == ROLE_SUPER_ADMIN): ?>
                    <li class="nav-item">
                        <a href="manage_students.php" class="nav-link <?php echo ($current_page == 'manage_students.php') ? 'active' : ''; ?>">
                            Manage Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link <?php echo ($current_page == 'reports.php') ? 'active' : ''; ?>">
                            Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="administration.php" class="nav-link <?php echo ($current_page == 'administration.php') ? 'active' : ''; ?>">
                            Administration
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($user_role == ROLE_TEACHER): ?>
                    <li class="nav-item">
                        <a href="my_courses.php" class="nav-link <?php echo ($current_page == 'my_courses.php') ? 'active' : ''; ?>">
                            My Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="my_profile.php" class="nav-link <?php echo ($current_page == 'my_profile.php') ? 'active' : ''; ?>">
                            My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="schedule.php" class="nav-link <?php echo ($current_page == 'schedule.php') ? 'active' : ''; ?>">
                            Schedule
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="resources.php" class="nav-link <?php echo ($current_page == 'resources.php') ? 'active' : ''; ?>">
                            Resources
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($user_role == ROLE_SUPER_ADMIN): ?>
                    <li class="nav-item">
                        <a href="system_logs.php" class="nav-link <?php echo ($current_page == 'system_logs.php') ? 'active' : ''; ?>">
                            System Logs
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <!-- <div class="update-msg text-center">
                <div
                    class="d-flex justify-content-center align-items-center thumb-lg update-icon-box  rounded-circle mx-auto">
                    <i class="iconoir-peace-hand h3 align-self-center mb-0 text-primary"></i>
                </div>
                <h5 class="mt-3">Mannat Themes</h5>
                <p class="mb-3 text-muted">Rizz is a high quality web applications.</p>
                <a href="javascript: void(0);" class="btn text-primary shadow-sm rounded-pill">Upgrade your
                    plan</a>
            </div> -->
        </div>
    </div>
</div>