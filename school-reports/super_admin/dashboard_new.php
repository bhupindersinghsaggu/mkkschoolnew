<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M.K.K. School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">

</head>

<body>
    <!-- Header -->
    <header class="dashboard-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex align-items-center">
                    <button class="hamburger-menu" id="hamburgerMenu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="h3 mb-0">School Management Dashboard</h1>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <div class="me-4 d-none d-md-block">
                        <span class="badge bg-light text-dark"><i class="fas fa-calendar-alt me-2"></i><span id="currentDate"></span></span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> Admin User
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Sidebar -->
    <div class="mobile-sidebar" id="mobileSidebar">
        <button class="close-sidebar" id="closeSidebar">
            <i class="fas fa-times"></i>
        </button>
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-book"></i> Notebook Corrections
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-chalkboard-teacher"></i> Add Teacher
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-list"></i> List Teachers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-theater-masks"></i> Add Class Show
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (Desktop) -->
            <div class="col-md-3 col-lg-2 sidebar d-none d-md-block">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-book"></i> Notebook Corrections
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chalkboard-teacher"></i> Add Teacher
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-list"></i> List Teachers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-theater-masks"></i> Add Class Show
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-bar"></i> Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 main-content">
                <div class="container-fluid">
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card card-1 animate-fadeIn">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="number">42</div>
                                            <div class="label">Total Teachers</div>
                                        </div>
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <div class="mt-3">
                                        <small><i class="fas fa-arrow-up me-1"></i> 5% increase this month</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card card-2 animate-fadeIn delay-1">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="number">18</div>
                                            <div class="label">Class Shows</div>
                                        </div>
                                        <i class="fas fa-theater-masks"></i>
                                    </div>
                                    <div class="mt-3">
                                        <small><i class="fas fa-arrow-up me-1"></i> 2 new this week</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card card-3 animate-fadeIn delay-2">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="number">127</div>
                                            <div class="label">Notebooks Checked</div>
                                        </div>
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="mt-3">
                                        <small><i class="fas fa-arrow-up me-1"></i> 12% increase</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card card-4 animate-fadeIn delay-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="number">92%</div>
                                            <div class="label">Average Score</div>
                                        </div>
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div class="mt-3">
                                        <small><i class="fas fa-arrow-up me-1"></i> 3% improvement</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Recent Notebook Corrections -->
                        <div class="col-lg-6 mb-4">
                            <div class="card animate-fadeIn">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Recent Notebook Corrections</h5>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                                </div>
                                <div class="card-body">
                                    <ul class="recent-activity">
                                        <li>
                                            <div class="activity-icon bg-primary text-white">
                                                <i class="fas fa-book"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-title">Mathematics Notebook Evaluation</div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="activity-time">Mrs. Sharma - Class 9A</span>
                                                    <span class="badge badge-success">Score: 85%</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="activity-icon bg-success text-white">
                                                <i class="fas fa-pen-fancy"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-title">English Literature Notebooks</div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="activity-time">Mr. Johnson - Class 10B</span>
                                                    <span class="badge badge-success">Score: 92%</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="activity-icon bg-warning text-white">
                                                <i class="fas fa-science"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-title">Science Practical Copies</div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="activity-time">Dr. Patel - Class 11C</span>
                                                    <span class="badge badge-warning">Score: 78%</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="activity-icon bg-info text-white">
                                                <i class="fas fa-history"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-title">History Project Submissions</div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="activity-time">Ms. Gupta - Class 8B</span>
                                                    <span class="badge badge-success">Score: 88%</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Class Shows -->
                        <div class="col-lg-6 mb-4">
                            <div class="card animate-fadeIn delay-1">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Recent Class Shows</h5>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                                </div>
                                <div class="card-body">
                                    <ul class="recent-activity">
                                        <li>
                                            <div class="activity-icon bg-danger text-white">
                                                <i class="fas fa-theater-masks"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-title">Science Exhibition</div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="activity-time">Mrs. Kumar - 22 Jun 2023</span>
                                                    <span class="badge badge-success">Score: 90%</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="activity-icon bg-purple text-white">
                                                <i class="fas fa-music"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-title">Annual Day Performance</div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="activity-time">Mr. Singh - 18 Jun 2023</span>
                                                    <span class="badge badge-success">Score: 95%</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="activity-icon bg-info text-white">
                                                <i class="fas fa-microphone"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-title">Debate Competition</div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="activity-time">Ms. Reddy - 15 Jun 2023</span>
                                                    <span class="badge badge-warning">Score: 82%</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="activity-icon bg-success text-white">
                                                <i class="fas fa-paint-brush"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-title">Art & Craft Exhibition</div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="activity-time">Mr. Ahmed - 12 Jun 2023</span>
                                                    <span class="badge badge-success">Score: 89%</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Teacher Performance -->
                        <div class="col-lg-12 mb-4">
                            <div class="card animate-fadeIn delay-2">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">Teacher Performance Overview</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Teacher</th>
                                                    <th>Subject</th>
                                                    <th>Notebook Score</th>
                                                    <th>Class Show Score</th>
                                                    <th>Overall</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Mrs. Sharma</td>
                                                    <td>Mathematics</td>
                                                    <td>85%</td>
                                                    <td>90%</td>
                                                    <td>87.5%</td>
                                                    <td><span class="badge bg-success">Excellent</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mr. Johnson</td>
                                                    <td>English</td>
                                                    <td>92%</td>
                                                    <td>95%</td>
                                                    <td>93.5%</td>
                                                    <td><span class="badge bg-success">Excellent</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Dr. Patel</td>
                                                    <td>Science</td>
                                                    <td>78%</td>
                                                    <td>82%</td>
                                                    <td>80%</td>
                                                    <td><span class="badge bg-warning">Good</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Ms. Gupta</td>
                                                    <td>History</td>
                                                    <td>88%</td>
                                                    <td>89%</td>
                                                    <td>88.5%</td>
                                                    <td><span class="badge bg-success">Excellent</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mr. Singh</td>
                                                    <td>Music</td>
                                                    <td>92%</td>
                                                    <td>95%</td>
                                                    <td>93.5%</td>
                                                    <td><span class="badge bg-success">Excellent</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/custom.js"></script>
</body>

</html>