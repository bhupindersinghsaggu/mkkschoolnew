<?php
 $frmTitle="Dashboard";
 include('Config.php');
 require_once '_Eazyschool/Function/MyFunction.php';
 include('_Eazyschool/header.php');
 include('_Eazyschool/navbar.php'); 
?>    
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<div class="content-wrapper">
<?php HeaderTitle($frmTitle);?>
<!-- Main content -->
    <section class="content">
       <div class="table-responsive-lg">
            
		</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->  
<?php
include('_Eazyschool/footer.php');
include('_Eazyschool/scripts.php');
?>
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

