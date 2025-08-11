<!-- Mobile Footer Navigation - Only shows on small screens -->

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<style>
    /* Mobile footer styling */
    @media (min-width: 992px) {
        .fixed-bottom {
            display: none !important;
        }
    }

    /* Active state for icons */
    .mobile-nav a.active {
        color: #0d6efd !important;
    }
</style>
<div class="d-block d-lg-none fixed-bottom bg-white shadow-lg py-2">
    <div class="container">
        <div class="row text-center">
            <!-- Home Icon -->
            <div class="col-3">
                <a href="../teacher/dashboard.php" class="text-dark text-decoration-none">
                    <i class="bi bi-house-door fs-4"></i>
                    <div class="small">Home</div>
                </a>
            </div>
            <!-- Dashboard Icon -->
            <div class="col-3">
                <a href="../teacher/teacher_docs.php" class="text-dark text-decoration-none">
                    <i class="bi bi-speedometer2 fs-4"></i>
                    <div class="small">My Docs</div>
                </a>
            </div>
            <!-- Dashboard Icon -->
            <div class="col-3">
                <a href="../teacher/dashboard.php" class="text-dark text-decoration-none">
                    <i class="bi bi-speedometer2 fs-4"></i>
                    <div class="small">My Reports</div>
                </a>
            </div>

            <!-- Logout Icon -->
            <div class="col-3">'
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="../auth/logout.php" class="text-dark text-decoration-none">
                        <i class="bi bi-box-arrow-right fs-4"></i>
                        <div class="small">Logout</div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop();
        const mobileLinks = document.querySelectorAll('.fixed-bottom a');

        mobileLinks.forEach(link => {
            const linkPage = link.getAttribute('href');
            if (currentPage === linkPage) {
                link.classList.add('active');
            }
        });
    });
</script>