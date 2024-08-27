<?php

$page_title = $_GET["title"];

if ($page_title == "") {
  $page_title = 'Mail sent';
}





include('_web/header.php');
 include('_web/navbar.php');

?>
<section class="inner-banner">
            <div class="container">
                <ul class="list-unstyled thm-breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active"><a href="#">E-mail Sent</a></li>
                </ul><!-- /.list-unstyled -->
                <h2 class="inner-banner__title"></h2><!-- /.inner-banner__title -->
            </div><!-- /.container -->
        </section>
<div class="container my-4">

  <div class="row">
    <h3 class="page-title" style="text-align:center;>
      <h3>Mail Sent</h3>
  </div>


  <div class="row">
    <div class="col col-md-12 course-one__title" style="text-align:center;">


      <?php
      ini_set('display_errors', 1);
      error_reporting(E_ALL);
      $from = "inquiry@mkkschool.com";
      $to = $_POST["email"];
      $subject = $_POST["subject"];
      $message = "Dear " . $_POST["your-name"] . "\n";
      $message = $message . "Thanks for connecting with us.\n";
      $message = $message . "We will shortly get back to you\n\n";
      $message = $message . "Dr. M.K.K. Arya Model School\n";
      $message = $message . "inquiry@mkkschool.com\n";
      $message =$message  . "Ram Lal Chowk, Model Town, Panipat (Haryana) - 132103.\n";
      $message =$message  . "Contact No.0180-4013047,4004556\n";
      
      
      
      $headers = "From:" . $from;
      
      if (mail($to, $subject, $message, $headers)) {

        echo "Thanks for connecting with us, We will shortly get back to you.\n";
        echo "You may contact is on following numbers 0180-4013047, 4004556.";
        
      } else {
        echo "The email message was not sent.";
      }



      $from = "inquiry@mkkschool.com";
      $to = "inquiry@mkkschool.com";
      $subject = "New Enquiry : " . $_POST["message"];
      $message = "Name :  " . $_POST["your-name"] . "\n";
      $message = $message . "Email :  " . $_POST["email"] . "\n";
      $message = $message . "Phone :  " . $_POST["your-phone"] . "\n";
      $message = $message . "Subject :  " . $_POST["subject"] . "\n";
      $message = $message . "Message :  " . $_POST["message"] . "\n";
  
      $headers = "From:" . $from;
      mail($to, $subject, $message, $headers)

      ?>


    </div>
  </div>
</div>


<?php
include('_web/footer.php');
include('_web/scripts.php');


?>
</body>



</html>