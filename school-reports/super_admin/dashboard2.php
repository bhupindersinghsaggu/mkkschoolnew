<?php
require_once '../includes/auth_check.php';
require_once '../includes/header.php';


?>
<div class="page-wrapper">
    <div class="content">
        <style>
            :root {
                --primary: #3b5998;
                --secondary: #6c757d;
                --success: #28a745;
                --info: #17a2b8;
                --warning: #ffc107;
                --danger: #dc3545;
                --light: #f8f9fa;
                --dark: #343a40;
            }

            body {
                background-color: #f5f7fb;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                color: #333;
            }

            .dashboard-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .dashboard-header {
                background: linear-gradient(135deg, var(--primary), #2d4373);
                color: white;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 25px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .welcome-text {
                font-size: 1.8rem;
                font-weight: 500;
            }

            .card {
                border: none;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                margin-bottom: 20px;
                height: 100%;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                background-color: white;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                font-weight: 600;
                padding: 15px 20px;
                border-radius: 10px 10px 0 0 !important;
            }

            .card-body {
                padding: 20px;
            }

            .stat-card {
                text-align: center;
                padding: 20px;
            }

            .stat-icon {
                font-size: 2.5rem;
                margin-bottom: 15px;
                color: var(--primary);
            }

            .stat-number {
                font-size: 2rem;
                font-weight: 700;
                color: var(--primary);
                margin-bottom: 5px;
            }

            .stat-text {
                color: var(--secondary);
                font-size: 0.9rem;
            }

            .btn-action {
                padding: 10px 20px;
                border-radius: 8px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn-add {
                background-color: var(--success);
                border: none;
            }

            .btn-view {
                background-color: var(--info);
                border: none;
            }

            .btn-add:hover,
            .btn-view:hover {
                opacity: 0.9;
                transform: translateY(-2px);
            }

            .section-title {
                font-size: 1.4rem;
                color: var(--primary);
                margin-bottom: 20px;
                padding-bottom: 10px;
                border-bottom: 2px solid var(--primary);
            }

            .quick-actions {
                margin-top: 30px;
            }

            .recent-activities {
                background-color: white;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .activity-item {
                padding: 10px 0;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }

            .activity-item:last-child {
                border-bottom: none;
            }

            .notification-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background-color: var(--danger);
                color: white;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                font-size: 0.7rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            @media (max-width: 768px) {
                .welcome-text {
                    font-size: 1.5rem;
                }

                .stat-number {
                    font-size: 1.5rem;
                }
            }
        </style>


        <div class="dashboard-container">
            <!-- Header Section -->
            <div class="dashboard-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="welcome-text">Welcome, Admin</h1>
                        <p class="mb-0">Manage teachers and notebook corrections</p>
                    </div>
                    <div class="position-relative">
                        <button class="btn btn-light">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card stat-card">
                        <i class="fas fa-chalkboard-teacher stat-icon"></i>
                        <div class="stat-number">24</div>
                        <div class="stat-text">Total Teachers</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card">
                        <i class="fas fa-book-open stat-icon"></i>
                        <div class="stat-number">156</div>
                        <div class="stat-text">Notebooks Corrected</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card">
                        <i class="fas fa-tasks stat-icon"></i>
                        <div class="stat-number">42</div>
                        <div class="stat-text">Pending Corrections</div>
                    </div>
                </div>
            </div>

            <!-- Teachers Record Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <h3 class="section-title">Teachers Record</h3>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Add Teacher</span>
                            <i class="fas fa-user-plus text-success"></i>
                        </div>
                        <div class="card-body">
                            <p>Add new teachers to the system with their details and subjects.</p>
                            <a href="./add_teacher.php" class="btn btn-add btn-action text-white">
                                <i class="fas fa-plus me-2"></i>Add Teacher
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>View Teachers</span>
                            <i class="fas fa-list text-info"></i>
                        </div>
                        <div class="card-body">
                            <p>View, edit, or manage existing teacher records and information.</p>
                            <a href="./list_teacher.php" class="btn btn-view btn-action text-white">
                                <i class="fas fa-eye me-2"></i>View Teachers
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notebook Correction Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <h3 class="section-title">Notebook Correction</h3>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Add Correction</span>
                            <i class="fas fa-edit text-success"></i>
                        </div>
                        <div class="card-body">
                            <p>Add new notebook correction records and evaluations.</p>
                            <button class="btn btn-add btn-action text-white">
                                <i class="fas fa-plus me-2"></i>Add Correction
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>View Corrections</span>
                            <i class="fas fa-check-circle text-info"></i>
                        </div>
                        <div class="card-body">
                            <p>View, manage, and update existing notebook correction records.</p>
                            <button class="btn btn-view btn-action text-white">
                                <i class="fas fa-eye me-2"></i>View Corrections
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions and Recent Activities -->
            <div class="row mt-5">
                <div class="col-md-8">
                    <div class="recent-activities">
                        <h4 class="mb-4">Recent Activities</h4>

                        <div class="activity-item">
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle p-2 me-3">
                                    <i class="fas fa-user-plus text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">New teacher added</h6>
                                    <small class="text-muted">Dr. Sharma joined the Mathematics department</small>
                                </div>
                                <small class="text-muted ms-auto">2 hours ago</small>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle p-2 me-3">
                                    <i class="fas fa-check-circle text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Notebooks evaluated</h6>
                                    <small class="text-muted">25 Science notebooks from Grade 10</small>
                                </div>
                                <small class="text-muted ms-auto">5 hours ago</small>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded-circle p-2 me-3">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Pending corrections</h6>
                                    <small class="text-muted">15 English notebooks awaiting evaluation</small>
                                </div>
                                <small class="text-muted ms-auto">Yesterday</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="quick-actions">
                        <h4 class="mb-4">Quick Actions</h4>

                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary text-start p-3">
                                <i class="fas fa-key me-2"></i> Change Password
                            </button>

                            <button class="btn btn-outline-info text-start p-3">
                                <i class="fas fa-file-export me-2"></i> Generate Reports
                            </button>

                            <button class="btn btn-outline-success text-start p-3">
                                <i class="fas fa-chart-line me-2"></i> View Analytics
                            </button>

                            <button class="btn btn-outline-secondary text-start p-3">
                                <i class="fas fa-cog me-2"></i> Settings
                            </button>
                        </div>
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





<script>
    // Simple animation for cards when they come into view
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');

        cards.forEach((card, index) => {
            // Add slight delay for staggered animation
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate__animated', 'animate__fadeInUp');
        });
    });
</script>


<?php require_once '../includes/footer.php'; ?>