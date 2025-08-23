<?php
include('web/header.php');
include('web/functions.php');
?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">


        <h5>British Council Projects</h5>
        <div class="row g-6">
            <div class="col-md-12">
                <div class="accordion mt-4" id="accordionExample">
                    <div class="accordion-item ">
                        <h2 class="accordion-header" id="headingOne">
                            <button type="button" class="accordion-button btn-info" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">Project One</button>
                        </h2>
                        <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mb-12 g-6">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- <h5 class="card-title">green thumb farming </h5> -->
                                                <img src="../reports/assets/img/green.jpg" width="300px">
                                                <div class="demo-inline-spacing mt-4">
                                                    <div class="list-group">
                                                        <a href="https://www.canva.com/design/DAGwuaESUoc/7HjpROPAsJ_-rieNOWt9nQ/edit?utm_content=DAGwuaESUoc&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton" class="btn btn-dark">Video Link</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- / Content -->
    <?php
    include('web/footer.php')
    ?>