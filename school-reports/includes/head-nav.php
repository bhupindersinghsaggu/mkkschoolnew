<div class="header">
    <div class="main-header">
        <div class="header-left active">
            <!-- <a href="../index.php" class="logo logo-normal"> -->
                <h3>M.K.K. School</h3>
            <!-- </a> -->
            <!-- <a href="../index.php" class="logo logo-white"> -->
                <h3>M.K.K. School</h3>
            <!-- </a> -->
            <!-- <a href="../index.php" class="logo-small"> -->
                <h3>M.K.K. School</h3>
            <!-- </a> -->
        </div>
        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>
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