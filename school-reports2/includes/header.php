<?php
// header.php - Common header
if (!isset($auth)) {
    require_once 'auth.php';
    $auth = new Auth();
}

// Get user role
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

?>
<!-- <header class="header">
    <h1>Computer Center Management System</h1>
    <div class="user-menu">
        <div class="user-info">
            <div class="user-avatar">
                <?php echo strtoupper(substr($username, 0, 1)); ?>
            </div>
            <span><?php echo htmlspecialchars($username); ?>
                <?php if ($user_role): ?>
                    <small>(<?php echo $auth->getRoleName($user_role); ?>)</small>
                <?php endif; ?>
            </span>
        </div>
        <a href="logout.php" class="btn btn-sm">Logout</a>
    </div>
</header> -->

<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <title>Bharat Computers & Coaching</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Bharat Computers & Coaching" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/libs/jsvectormap/css/jsvectormap.min.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/data-table.css" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="assets/css/style.css" rel="stylesheet" type="text/css" /> -->
    <!-- jQuery (required for DataTables)
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>

<body>
    <div class="topbar d-print-none">
        <div class="container-xxl">
            <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li>
                        <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                            <i class="iconoir-menu-scale"></i>
                        </button>
                    </li>
                    <li class="mx-3 welcome-text">
                        <h3 class="mb-0 fw-bold text-truncate">Good Morning, <?php echo $auth->getRoleName($user_role); ?>
                        </h3>
                    </li>
                </ul>
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li class="hide-phone app-search">
                        <form role="search" action="#" method="get">
                            <input type="search" name="search" class="form-control top-search mb-0"
                                placeholder="Search here...">
                            <button type="submit"><i class="iconoir-search"></i></button>
                        </form>
                    </li>
                    <!-- <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="assets/images/flags/us_flag.jpg" alt="" class="thumb-sm rounded-circle">
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"><img src="assets/images/flags/us_flag.jpg" alt=""
                                    height="15" class="me-2">English</a>
                            <a class="dropdown-item" href="#"><img src="assets/images/flags/spain_flag.jpg" alt=""
                                    height="15" class="me-2">Spanish</a>
                            <a class="dropdown-item" href="#"><img src="assets/images/flags/germany_flag.jpg" alt=""
                                    height="15" class="me-2">German</a>
                            <a class="dropdown-item" href="#"><img src="assets/images/flags/french_flag.jpg" alt=""
                                    height="15" class="me-2">French</a>
                        </div>
                    </li> -->
                    <li class="topbar-item">
                        <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                            <i class="icofont-moon dark-mode"></i>
                            <i class="icofont-sun light-mode"></i>
                        </a>
                    </li>
                    <!-- <li class="dropdown topbar-item">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="icofont-bell-alt"></i>
                            <span class="alert-badge"></span>
                        </a>
                        <div class="dropdown-menu stop dropdown-menu-end dropdown-lg py-0">

                            <h5 class="dropdown-item-text m-0 py-3 d-flex justify-content-between align-items-center">
                                Notifications <a href="#" class="badge text-body-tertiary badge-pill">
                                    <i class="iconoir-plus-circle fs-4"></i>
                                </a>
                            </h5>
                            <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mx-0 active" data-bs-toggle="tab" href="#All" role="tab"
                                        aria-selected="true">
                                        All <span class="badge bg-primary-subtle text-primary badge-pill ms-1">24</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mx-0" data-bs-toggle="tab" href="#Projects" role="tab"
                                        aria-selected="false" tabindex="-1">
                                        Projects
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mx-0" data-bs-toggle="tab" href="#Teams" role="tab"
                                        aria-selected="false" tabindex="-1">
                                        Team
                                    </a>
                                </li>
                            </ul>
                            <div class="ms-0" style="max-height:230px;" data-simplebar>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="All" role="tabpanel"
                                        aria-labelledby="all-tab" tabindex="0">
                                        <a href="#" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">2 min ago</small>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                                    <i class="iconoir-wolf fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-normal text-dark fs-13">Your order is placed</h6>
                                                    <small class="text-muted mb-0">Dummy text of the printing and
                                                        industry.</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">10 min ago</small>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                                    <i class="iconoir-apple-swift fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-normal text-dark fs-13">Meeting with designers
                                                    </h6>
                                                    <small class="text-muted mb-0">It is a long established fact that a
                                                        reader.</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">40 min ago</small>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                                    <i class="iconoir-birthday-cake fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-normal text-dark fs-13">UX 3 Task complete.</h6>
                                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">1 hr ago</small>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                                    <i class="iconoir-drone fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-normal text-dark fs-13">Your order is placed</h6>
                                                    <small class="text-muted mb-0">It is a long established fact that a
                                                        reader.</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">2 hrs ago</small>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                                    <i class="iconoir-user fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-normal text-dark fs-13">Payment Successfull</h6>
                                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="tab-pane fade" id="Projects" role="tabpanel"
                                        aria-labelledby="projects-tab" tabindex="0">
                                     
                                        <a href="#" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">40 min ago</small>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                                    <i class="iconoir-birthday-cake fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-normal text-dark fs-13">UX 3 Task complete.</h6>
                                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">1 hr ago</small>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                                    <i class="iconoir-drone fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-normal text-dark fs-13">Your order is placed</h6>
                                                    <small class="text-muted mb-0">It is a long established fact that a
                                                        reader.</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">2 hrs ago</small>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                                    <i class="iconoir-user fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-normal text-dark fs-13">Payment Successfull</h6>
                                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="tab-pane fade" id="Teams" role="tabpanel" aria-labelledby="teams-tab"
                                        tabindex="0">
                                        <a href="#" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">1 hr ago</small>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                                    <i class="iconoir-drone fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-normal text-dark fs-13">Your order is placed</h6>
                                                    <small class="text-muted mb-0">It is a long established fact that a
                                                        reader.</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-3">
                                            <small class="float-end text-muted ps-2">2 hrs ago</small>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                                    <i class="iconoir-user fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate">
                                                    <h6 class="my-0 fw-normal text-dark fs-13">Payment Successfull</h6>
                                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <a href="pages-notifications.html" class="dropdown-item text-center text-dark fs-13 py-2">
                                View All <i class="fi-arrow-right"></i>
                            </a>
                        </div>
                    </li> -->

                    <li class="dropdown topbar-item">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="../assets/images/users/avatar-1.jpg" alt="" class="thumb-lg rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0">
                            <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                                <div class="flex-shrink-0">
                                    <img src="../assets/images/users/avatar-1.jpg" alt="" class="thumb-md rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                    <h6 class="my-0 fw-medium text-dark fs-13"><?php echo $auth->getRoleName($user_role); ?></h6>
                                    <!-- <small class="text-muted mb-0">Front End Developer</small> -->
                                </div>
                            </div>
                            <div class="dropdown-divider mt-0"></div>
                            <!-- <small class="text-muted px-2 pb-1 d-block">Account</small>
                            <a class="dropdown-item" href="pages-profile.html"><i
                                    class="las la-user fs-18 me-1 align-text-bottom"></i> Profile</a>
                            <small class="text-muted px-2 py-1 d-block">Settings</small>
                            <a class="dropdown-item" href="pages-profile.html"><i
                                    class="las la-cog fs-18 me-1 align-text-bottom"></i>Account Settings</a>
                            <div class="dropdown-divider mb-0"></div> -->
                            <a class="dropdown-item text-danger" href="logout.php"><i
                                    class="las la-power-off fs-18 me-1 align-text-bottom"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="startbar d-print-none">
        <div class="brand">
            <a href="dashboard.php" class="logo">
                <span>
                    <img src="assets/images/logo-sm.png" alt="logo-small" class="logo-sm">
                </span>
                <span class="">
                    <img src="assets/images/logo-dark.png" alt="logo-large" class="logo-lg logo-light">
                    <img src="assets/images/logo-dark.png" alt="logo-large" class="logo-lg logo-dark">
                </span>
            </a>
        </div>
        <?php include  '../includes/navigation.php'; ?>
    </div>
    <div class="startbar-overlay d-print-none"></div>
    <?php
    // Prepare modal variables (in case you still use $error / $success elsewhere)
    $modal_title = '';
    $modal_body = '';
    $modal_type = ''; // 'error' or 'success'

    if (!empty($error)) {
        // If $error is an array of messages, join them; otherwise treat as string
        if (is_array($error)) {
            $modal_body = '<ul class="mb-0">';
            foreach ($error as $e) {
                $modal_body .= '<li>' . htmlspecialchars($e) . '</li>';
            }
            $modal_body .= '</ul>';
        } else {
            $modal_body = '<p>' . nl2br(htmlspecialchars($error)) . '</p>';
        }
        $modal_title = 'Error';
        $modal_type = 'error';
    } elseif (!empty($success)) {
        $modal_title = 'Success';
        $modal_body = '<p>' . nl2br(htmlspecialchars($success)) . '</p>';
        $modal_type = 'success';
    }
    ?>

    <!-- Message Modal (Bootstrap 5) -->
    <!-- <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
                <div class="modal-header <?php echo ($modal_type === 'error') ? 'bg-danger text-white' : (($modal_type === 'success') ? 'bg-success text-white' : ''); ?>">
                    <h6 class="modal-title m-0" id="messageModalLabel"><?php echo $modal_title ? htmlspecialchars($modal_title) : 'Message'; ?></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="text-center py-3">
                    <h5 class="mb-1"> <?php echo $modal_body; ?></h5>
                </div>
                <div class="modal-footer">
                    <?php if ($modal_type === 'error'): ?>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fix</button>
                    <?php else: ?>
                        <a href="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" class="btn btn-success">OK</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div> -->