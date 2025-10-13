<?php
// navigation.php - Navigation based on user role (no BASE_URL, hardcoded project folder)
$current_page = basename($_SERVER['PHP_SELF']);
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>

<div class="startbar-menu">
    <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
        <div class="d-flex align-items-start flex-column w-100">
            <ul class="navbar-nav mb-auto w-100">
                <li class="menu-label pt-0 mt-0">
                    <span>Main Menu</span>
                </li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>"
                       href="<?php echo ($user_role == ROLE_TEACHER) ? 'dashboard.php' : 'dashboard.php'; ?>">
                        <i class="iconoir-compact-disc menu-icon"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Manage Users (Super Admin) -->
                <?php if ($user_role == ROLE_SUPER_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#usersMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="usersMenu">
                            <i class="iconoir-user menu-icon"></i>
                            <span>Manage Users</span>
                        </a>
                        <div class="collapse" id="usersMenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'manage_users.php') ? 'active' : ''; ?>"
                                       href="manage_users.php">Add Users</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'list_users.php') ? 'active' : ''; ?>"
                                       href="list_users.php">List Users</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Manage Teachers (Super Admin) -->
                <?php if ($user_role == ROLE_SUPER_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#teachersMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="teachersMenu">
                            <i class="iconoir-user menu-icon"></i>
                            <span>Teacher's Notebook</span>
                        </a>
                        <div class="collapse" id="teachersMenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'add_notebook.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/admin/teachers/add_notebook.php">Add Notebook Report</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'edit_notebook.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/admin/teachers/edit_notebook.php">Edit Notebook Report</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'list_notebook.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/admin/teachers/list_notebook.php">List Notebook Report</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Fee Management (Super Admin) -->
                <?php if ($user_role == ROLE_SUPER_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#feeMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="feeMenu">
                            <i class="iconoir-user menu-icon"></i>
                            <span>Teacher Class Show </span>
                        </a>
                        <div class="collapse" id="feeMenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'add_class_show.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/admin/teachers/add_class_show.php">Add Class Show</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'list_class_show.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/admin/teachers/list_class_show.php">View Class Show</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Course Management (Super Admin) -->
                <!-- <?php if ($user_role == ROLE_SUPER_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#courseMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="courseMenu">
                            <i class="iconoir-user menu-icon"></i>
                            <span>Course Management</span>
                        </a>
                        <div class="collapse" id="courseMenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'courses.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/courses.php">Add Course</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'courses_report.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/courses_report.php">Course Wise Report</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?> -->

                <!-- Job Work (Super Admin) -->
                <!-- <?php if ($user_role == ROLE_SUPER_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#jobMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="jobMenu">
                            <i class="iconoir-user menu-icon"></i>
                            <span>Job Work Management</span>
                        </a>
                        <div class="collapse" id="jobMenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'add_job.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/add_job.php">Add Job</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'manage_jobs.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/manage_jobs.php">Manage Jobs</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?> -->

                <!-- Expenses (Super Admin) -->
                <!-- <?php if ($user_role == ROLE_SUPER_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#expenseMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="expenseMenu">
                            <i class="iconoir-user menu-icon"></i>
                            <span>Expense Management</span>
                        </a>
                        <div class="collapse" id="expenseMenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'add_expense.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/add_expense.php">Add Expense</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'manage_expenses.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/manage_expenses.php">Manage Expenses</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($current_page == 'expenses_report.php') ? 'active' : ''; ?>"
                                       href="/mkkschool-new/expenses_report.php">Expense Reports</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?> -->

                <!-- Teacher Menu -->
                <!-- <?php if ($user_role == ROLE_TEACHER): ?>
                    <li class="nav-item">
                        <a href="/mkkschool-new/teacher/my_courses.php" class="nav-link <?php echo ($current_page == 'my_courses.php') ? 'active' : ''; ?>">
                            <i class="iconoir-folder menu-icon"></i>
                            <span>My Courses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/mkkschool-new/teacher/my_docs.php" class="nav-link <?php echo ($current_page == 'my_docs.php') ? 'active' : ''; ?>">
                            <i class="iconoir-folder menu-icon"></i>
                            <span>My Docs</span>
                        </a>
                    </li>
                <?php endif; ?> -->
            </ul>
        </div>
    </div>
</div>
