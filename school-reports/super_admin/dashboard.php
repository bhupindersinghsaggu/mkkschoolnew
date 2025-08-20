<?php
require_once '../includes/auth_check.php';
require_once '../includes/header.php';


?>
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
            <div class="mb-3">
                <h1 class="mb-1">Welcome, Admin</h1>
            </div>
            <!-- <div class="input-icon-start position-relative mb-3">
                <span class="input-icon-addon fs-16 text-gray-9">
                    <i class="ti ti-calendar"></i>
                </span>
                <input type="text" class="form-control date-range bookingrange" placeholder="Search Product">
            </div> -->
        </div>
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-primary sale-widget flex-fill">
                    <div class="card-body d-flex align-items-center">
                        <span class="sale-icon bg-white text-primary">
                            <i class="ti ti-file-text fs-24"></i>
                        </span>
                        <div class="ms-2">
                            <h3 class="text-white mb-1">Teachers Record</h3>
                            <div class="d-inline-flex align-items-center flex-wrap gap-2">
                                <!-- <h4 class="text-white"><?php echo $totalCategories; ?></h4> -->
                            </div>
                        </div>
                    </div>
                    <div class="page-btn d-padding">
                        <a href="./add_teacher.php" class="btn btn-dark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-1">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>Add </a>
                          <a href="./list_teacher.php" class="btn btn-dark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-1">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>View </a>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-secondary sale-widget flex-fill">
                    <div class="card-body d-flex align-items-center">
                        <span class="sale-icon bg-white text-secondary">
                            <i class="ti ti-repeat fs-24"></i>
                        </span>
                        <div class="ms-2">
                            <h3 class="text-white mb-1">Notebook Correction</h3>
                            <div class="d-inline-flex align-items-center flex-wrap gap-2">
                                <!-- <h4 class="text-white"><?php echo $totalProducts; ?></h4> -->
                                <!-- <span class="badge badge-soft-danger"><i
										class="ti ti-arrow-down me-1"></i>-22%</span> -->
                            </div>
                        </div>
                    </div>
                    <div class="page-btn d-padding">
                        <a href="./add_notebook.php" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-purchase"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-1">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>Add </a>
                        <a href="./list_notebook.php" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-purchase"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-1">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>View </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="copyright-footer d-flex align-items-center justify-content-between border-top bg-white gap-3 flex-wrap">
        <p class="fs-13 text-gray-9 mb-0">2025 &copy; Design Pocket. All Right Reserved</p>
        <p>Designed & Developed By <a href="javascript:void(0);" class="link-primary">M.K.K. (IT Department)</a></p>
    </div>
</div>



<?php require_once '../includes/footer.php'; ?>