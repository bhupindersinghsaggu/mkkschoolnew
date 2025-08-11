<div class="header">
    <div class="main-header">
        <!-- Logo -->
        <div class="header-left active">
            <a href="../index.php" class="logo logo-normal">
                <h3>M.K.K. School</h3>
                <!-- <img src="../assets/img/logo.svg" alt="Img"> -->
            </a>
            <a href="../index.php" class="logo logo-white">
                <h3>M.K.K. School</h3>
                <!-- <img src="../assets/img/logo-white.svg" alt="Img"> -->
            </a>
            <a href="../index.php" class="logo-small">
                <h3>M.K.K. School</h3>
                <!-- <img src="../assets/img/logo-small.png" alt="Img"> -->
            </a>
        </div>
        <!-- /Logo -->
        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>
        <!-- Header Menu -->
        <div class="logout d-flex ">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="../auth/logout.php" class="btn btn-secondary me-2 logout-link">
                    <i class="fas fa-sign-out-alt"></i> Logout 
                    <!-- (<?php echo htmlspecialchars($username); ?>) -->
                </a>
            <?php endif; ?>
        </div>
       
    </div>
</div>