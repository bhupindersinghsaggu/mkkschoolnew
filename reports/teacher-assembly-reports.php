<?php
include('web/header.php');
include('web/functions.php');
?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-6 col-md-4 order-1">
                <div class="card-body">
                    <div class="button-group">
                        <h5 class="card-title m-0 me-2 mb-6 ">Teacher Observation Report</h5>
                        <a href="<?php echo "$class_assembly_form ?>"
                            class="btn btn-sm btn-primary mb-1 mb-6">Download</a>
                    </div>
                    <div class="iframe mb-6">
                        <iframe src="<?php echo "$class_assembly_form_view" ?>" width="1400"
                            height="300"></iframe>
                    </div>
                </div>
                <a href="index.php" class="btn btn-danger btn-buy-now">Back</a>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <?php
    include('web/footer.php')
    ?>