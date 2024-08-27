<?php
 include('Config.php');
 include('_web/header.php');
 include('_web/navbar.php');
?>
<div class="container"><hr>
   <?php		  
		    $Product_Type='';
            $All='';	
			$BAGS='';
			$BLANKET='';
			$JWELLERY='';
			$CARPET='';		  
		  
		  if(isset($_GET['Product_Type']))
		  $Product_Type= $_GET['Product_Type'];
	      
		  if($Product_Type=='')
		  {
			$All='active';  
		  }	
		 if($Product_Type=='BAGS')
				  {
					$BAGS='active';  
				  }
		 if($Product_Type=='BLANKET')
				  {
					$BLANKET='active';  
				  }
		 if($Product_Type=='JWELLERY')
				  {
					$JWELLERY='active';  
				  }
		 if($Product_Type=='CARPET')
				  {
					$CARPET='active';  
				  }		  
		  ?>
		  <div class="heading heading-center mb-3">
				  <h2 class="title"id="tab">Top Selling Products</h2><hr>
				  <!-- End .title -->
				  <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
					 <li class="nav-item">
						<a class="nav-link <?php echo " ".$All;?>"  href="Product.php?Product_Type=&#tab" role="tab">All</a>
					 </li>
					 <li class="nav-item">
						<a class="nav-link <?php echo " ".$BAGS;?>"  href="Product.php?Product_Type=BAGS&#tab" role="tab">BAGS</a>
					 </li>
					 <li class="nav-item">
						<a class="nav-link <?php echo " ".$BLANKET;?>"  href="Product.php?Product_Type=BLANKET&#tab" role="tab">BLANKET</a>
					 </li>
					 <li class="nav-item">
						<a class="nav-link <?php echo " ".$JWELLERY;?>"  href="Product.php?Product_Type=JWELLERY&#tab" role="tab">JWELLERY</a>
					 </li>
					 <li class="nav-item">
						<a class="nav-link <?php echo " ".$CARPET;?>"  href="Product.php?Product_Type=CARPET&#tab" role="tab">CARPET</a>
					 </li>
				  </ul>
			</div>
    		<div class="row">
			    <?php
				   $show  = "SELECT * FROM tblproducts where  ProductType like '%".$Product_Type."%'";
						$r = $dbh->prepare($show); $r->execute();
						while($res = $r->fetch(PDO::FETCH_ASSOC)):
				?>
				               <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
								  <div class="product product-11 text-center">
									 <figure class="product-media">
										<img src="Upload/tblproducts/TH/<?php echo $res['id'];?>.jpg" alt="Product image" class="product-image">
									 </figure>
									 <!-- End .product-media -->
									 <div class="product-action">
										<a href="#" class="btn-product btn-cart"><span><i class="fa fa-shopping-bag"></i>
										<?php echo $res['Title'];?></span></a>
									 </div>
									 <!-- End .product-action -->
								  </div>
								  <!-- End .product -->
								</div>   			
				<?php  endwhile; ?>				
    		</div>
</div>
<!-- End .container -->
<?php
include('_web/footer.php');
include('_web/scripts.php');
?>
<script src="SupportPlugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script src="SupportPlugins/filterizr/jquery.filterizr.min.js"></script>
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>