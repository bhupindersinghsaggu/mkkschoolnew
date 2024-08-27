<?php

include('_web/header.php');
include('_web/navbar.php');
?>

<!--====== SLIDER PART START ======-->
<style>
    button.close {

        background-color: transparent;
        border: 0;
        -webkit-appearance: none;
        padding-right: 10px;
        padding-top: 10px;
    }

    .admission-banner a {
        padding: 4px;
        font-size: 19px;
        background: #07294d;
        color: #ffc600;
    }


    .admission-banner {
        padding: 4px;
        font-size: 19px;
        background: #07294d;
        color: #ffc600;
        margin-top: 20px;
    }

    .modal-title {
        text-align: center;
        padding-top: 20px;
        color: #ffffff;
        font-size: 31px;
    }

    .online {
        font-size: 23px;
        color: #0c365e;
        text-align: center;
        text-align: center;
    }

    .enquiry {
        position: fixed;
        background: #f16101;
        padding: 5px;
        margin-left: -39px;
        top: 409px;
        z-index: 9999999999;
        transform: rotate(270deg);
        -webkit-transform: rotate(270deg);
        -moz-transform: rotate(270deg);
    }

    .icon-bar-left {
        position: fixed;
        top: 50%;
        z-index: 99 !important;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .icon-bar-left a {
        display: block;
        text-align: center;
        padding: 11px;
        transition: all 0.3s ease;
        color: white;
        font-size: 20px;
    }

    .facebook {
        background: #3B5998;
        color: white;
    }

    .youtube {
        background: #bb0000;
        color: white;
    }
	.instagram{
		background: #C150C8;
		color; white;
	}
</style>
<script src="js/vendor/modernizr-3.5.0.min.js"></script>
<!-- mycode -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $("#myModal").modal('show');
    });
</script>
<!--Modal pop start-->
<div id="myModal" class="modal fade show" aria-modal="true" style="padding-right: 17px; display: block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="button__close">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            </div>
            <h4 class="modal-title">Crescent Public School
            </h4>
           <p style="text-align: center;
    font-size: 19px;
    font-weight: 700;
    color: #f0bd05;
    background-color: #07294d;
   ">"Next Generation School" </p>
            <div class="online" style="padding-top:10px;"><b></b><i></i><em style="
    font-size:  19px;
	color:  white;
">"Hostel Facility Only For Girls"<br>
            (6th Class Onwards)<br></em>
            <a href="https://curtina.in/_EazySchool/FormsWeb/frmHostel.aspx?AppId=crescent"><b><u>Apply
                                    for Girls Hostel</u></a></b>
                <div class="admission-banner"> <a href="https://curtina.in/CRESCENT/forms/frmApplication3_AE_JQ.aspx">Click
                        here
                        for Online Admission/Registration </a></div>
            </div>
            <div class="online"><b><br>
                    <!--	<div class="whatappdesktop"><a href="https://wa.me/918295600108?text=I%20want%20to%20know%20more%20about%20admission">  <i class="fab fa-whatsapp" aria-hidden="true" style="color: #f16101; font-size:25px;"></i></a></div>-->
                    <a href="https://play.google.com/store/apps/details?id=com.jet66.erp2"><u>Download School App</u></a> | <a href="https://www.curtinatech.in/CRESCENT/forms/frmstdpayonline.aspx"><u>Pay Online</u></a>
                    <div class="pros"><a href="pro-21-22.pdf"><marquee direction="left" height="30" width="350"><u>Download Prospects 2022-23</u></marquee></a></div>
          <p style="
    padding: 10px;
    font-weight: 800; 
	font-size:14px;
	background-color:#07294d;
	color:#fff;
"> Hostel Charges 144000 (25% concession for next two year) + School Fee</p> </div>
            <div>
                <p style="margin-left: 50px;"></p>
            </div>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">

        </div>
    </div>
</div>
<!--Modal pop end-->
<!--admission open button
-->

<!--====== admission open icon ======-->
<style>
    .icon-bar-right {
        position: fixed;
        top: 50%;
        z-index: 99 !important;
        right: 0px;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        margin-right: 7px;
    }

    /* Style the icon bar links */
    .icon-bar-right a {
        display: block;
        text-align: center;
        padding: 0px;
        transition: all 0.3s ease;
        color: white;
        font-size: 20px;
    }

    /* Style the social media icons with color, if you want */
    .icon-bar-right a:hover {
        background-color: #000;
    }

    /* The side navigation menu */
    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 9999 !important;
        top: 0;
        right: 0;
        background-color: #fafafa;
        overflow-x: hidden;
        padding-top: 60px;
        transition: 0.5s;
    }

    /* The navigation menu links */
    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
        border-left: solid 2px #fcff23;
    }

    /* When you mouse over the navigation links, change their color */
    .sidenav a:hover {
        color: #ced3f3;
    }

    /* Position and style the close button (top right corner) */
    .sidenav .closebtn1 {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
        }

        .sidenav a {
            font-size: 18px;
        }
    }

    iframe {
        border: solid 1px #eee;
        border-radius: 8px;
    }
</style>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "350px";
        document.getElementById("main").style.marginLeft = "370px";
    }

    /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
    }
</script>
<div class="icon-bar-right" onclick="openNav()">
    <a href="#"><img src="images/bgEnquiry.png" /></a>
</div>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn1" onclick="closeNav()">&times;</a>
    <div class="row">
        <div class="col-md-12" style="padding:0px 40px">
            <h4>Online Enquiry</h4>
            <iframe style="height:460px;" width="100%" src="https://curtina.in/_EazySchool/FormsWeb/frmEnquiry.aspx?AppId=crescent">

            </iframe>
        </div>
    </div>
</div>
<!--
    admission open button close
-->
<!--icon bar left start-->
<div class="icon-bar-left">
    <a href="https://www.facebook.com/Crescent-School-Banuri-Palampur-CBSE-Board-317253068398836" class="facebook" target="_blank"><i class="fa fa-facebook"></i></a>
    <a href="https://www.youtube.com/channel/UCsWfbcRc22RMD6esXmKRC0w" class="youtube" target="_blank"><i class="fa fa-youtube"></i></a>
    <a href="https://www.instagram.com/crescentpublicschoolbanuri/" class="instagram" target="_blank"><i class="fa fa-instagram"></i></a>
</div>
<!--icon bar left end-->
<!--====== HEADER PART START ======-->

<a href="https://www.curtinatech.in/CRESCENT/forms/frmstdpayonline.aspx" target="_blank"><img onclick="topFunction()" id="btnGoToTop" src="/images/ss.png" alt=""></a>
 <section id="slider-part" class="slider-active ">

        <div class="single-slider bg_cover pt-150" style=" width: 1349px;
        position: relative;
        left: 0px;
        top: 0px;
        z-index: 998;
        opacity: 0;
        transition: opacity 500ms ease 0s;
        height:550px; background-image: url(images/slider/s-1.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9">
                        <!--  <div class="slider-cont">
                               <h1 data-animation="fadeInLeft" data-delay="1s">Crescent Public School
                            </h1>
                             
                            <ul>
                                <li><a data-animation="fadeInUp" data-delay="1.6s" class="main-btn" href="#">Read More</a></li>
                                <li><a data-animation="fadeInUp" data-delay="1.9s" class="main-btn" href="#">Get Started</a></li>
                            </ul>
                        </div>row -->
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- single slider -->
         <div class="single-slider bg_cover pt-150" style=" width: 1349px;
        position: relative;
        left: 0px;
        top: 0px;
        z-index: 998;
        opacity: 0;
        transition: opacity 500ms ease 0s;
        height:550px; background-image: url(images/slider/tali.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9">
                        <div class="slider-cont">
                            <!--  <h1 data-animation="fadeInLeft" data-delay="1s">Choose the right theme for education</h1>
                             <p data-animation="fadeInUp" data-delay="1.3s">Donec vitae sapien ut libearo venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt  Sed fringilla mauri amet nibh.</p>
                            <ul>
                                <li><a data-animation="fadeInUp" data-delay="1.6s" class="main-btn" href="#">Read More</a></li>
                                <li><a data-animation="fadeInUp" data-delay="1.9s" class="main-btn" href="#">Get Started</a></li>
                            </ul>-->
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- single slider -->

        <div class="single-slider bg_cover pt-150" style=" width: 1349px;
        position: relative;
        left: 0px;
        top: 0px;
        z-index: 998;
        opacity: 0;
        transition: opacity 500ms ease 0s;
        height:550px; background-image: url(images/slider/s-3.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9">
                        <div class="slider-cont">
                            <!--  <h1 data-animation="fadeInLeft" data-delay="1s">Choose the right theme for education</h1>
                             <p data-animation="fadeInUp" data-delay="1.3s">Donec vitae sapien ut libearo venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt  Sed fringilla mauri amet nibh.</p>
                            <ul>
                                <li><a data-animation="fadeInUp" data-delay="1.6s" class="main-btn" href="#">Read More</a></li>
                                <li><a data-animation="fadeInUp" data-delay="1.9s" class="main-btn" href="#">Get Started</a></li>
                            </ul>-->
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- single slider -->
        <div class="single-slider bg_cover pt-150" style=" width: 1349px;
        position: relative;
        left: 0px;
        top: 0px;
        z-index: 998;
        opacity: 0;
        transition: opacity 500ms ease 0s;
        height:550px; background-image: url(images/slider/s-4.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9">
                        <div class="slider-cont">
                            <!--   <h1 data-animation="fadeInLeft" data-delay="1s">Choose the right theme for education</h1>
                            <p data-animation="fadeInUp" data-delay="1.3s">Donec vitae sapien ut libearo venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt  Sed fringilla mauri amet nibh.</p>
                            <ul>
                                <li><a data-animation="fadeInUp" data-delay="1.6s" class="main-btn" href="#">Read More</a></li>
                                <li><a data-animation="fadeInUp" data-delay="1.9s" class="main-btn" href="#">Get Started</a></li>
                            </ul>-->
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- single slider -->
        <div class="single-slider bg_cover pt-150" style=" width: 1349px;
        position: relative;
        left: 0px;
        top: 0px;
        z-index: 998;
        opacity: 0;
        transition: opacity 500ms ease 0s;
        height:550px; background-image: url(images/slider/s-5.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9">
                        <div class="slider-cont">
                            <!--   <h1 data-animation="fadeInLeft" data-delay="1s">Choose the right theme for education</h1>
                            <p data-animation="fadeInUp" data-delay="1.3s">Donec vitae sapien ut libearo venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt  Sed fringilla mauri amet nibh.</p>
                            <ul>
                                <li><a data-animation="fadeInUp" data-delay="1.6s" class="main-btn" href="#">Read More</a></li>
                                <li><a data-animation="fadeInUp" data-delay="1.9s" class="main-btn" href="#">Get Started</a></li>
                            </ul>-->
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- single slider -->
        <div class="single-slider bg_cover pt-150" style=" width: 1349px;
        position: relative;
        left: 0px;
        top: 0px;
        z-index: 998;
        opacity: 0;
        transition: opacity 500ms ease 0s;
        height:550px; background-image: url(images/slider/s-6.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9">
                        <div class="slider-cont">
                            <!--   <h1 data-animation="fadeInLeft" data-delay="1s">Choose the right theme for education</h1>
                            <p data-animation="fadeInUp" data-delay="1.3s">Donec vitae sapien ut libearo venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt  Sed fringilla mauri amet nibh.</p>
                            <ul>
                                <li><a data-animation="fadeInUp" data-delay="1.6s" class="main-btn" href="#">Read More</a></li>
                                <li><a data-animation="fadeInUp" data-delay="1.9s" class="main-btn" href="#">Get Started</a></li>
                            </ul>-->
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- single slider -->
        <div class="single-slider bg_cover pt-150" style=" width: 1349px;
        position: relative;
        left: 0px;
        top: 0px;
        z-index: 998;
        opacity: 0;
        transition: opacity 500ms ease 0s;
        height:550px; background-image: url(images/slider/s-2.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9">
                        <div class="slider-cont">
                            <!--   <h1 data-animation="fadeInLeft" data-delay="1s">Choose the right theme for education</h1>
                            <p data-animation="fadeInUp" data-delay="1.3s">Donec vitae sapien ut libearo venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt  Sed fringilla mauri amet nibh.</p>
                            <ul>
                                <li><a data-animation="fadeInUp" data-delay="1.6s" class="main-btn" href="#">Read More</a></li>
                                <li><a data-animation="fadeInUp" data-delay="1.9s" class="main-btn" href="#">Get Started</a></li>
                            </ul>-->
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- single slider -->
    </section>
</iframe>

<!--====== SLIDER PART ENDS ======-->

<!--====== CATEGORY PART START ======-->


<div class="purchase desktop-view">
    <div class="container" style="padding: 7px 0px 6px;">
        <div class="row">
            <div class="thought">
                <div class="span2">

                </div>
                <div class="span10">
                    <marquee scrollamount="5" scrolldelay="40" onmouseover="this.stop();" onmouseout="this.start();" style="color:#07294d;">
                        <ul>
                            <li>Welcome to Crescent public school Admission Open For Session 2022-23 || Welcome to Crescent public school Admission Open For Session 2022-23 || Welcome to Crescent public school Admission Open For Session 2022-23 || </li>
                        </ul>
                    </marquee>
                </div>
            </div>
        </div>
    </div>
</div>
<!--====== CATEGORY PART ENDS ======-->

<!--====== ABOUT PART START ======-->

<section id="about-part" class="about-tow pt-65">
    <div class="about-shape">
        <img src="images/about/shape.png" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="section-title mt-50">
                    <h5>About us</h5>
                    <h2>
					<u>Welcome to Crescent Public School</u>
                    </h2>
                   <h5 style="font-size: 25px;padding-top: 13px;color:#ba0000;">"Next Generation School"</h5>
                </div> <!-- section title -->
                <div class="about-cont">
                    <p style="text-align: justify;">Crescent Public School has emerged as one of the premier Educational Institutions in Palampur (H.P.). The school is a Mascot for developing and inculcating the minds of the young students towards their future careers and with a positive outlook.  Our motto “One Team One Goal” has renowned the institution as a guiding force in every student's life. Every year the school is delivering outstanding results with a professional growth for every student by virtue of giving a broader platform with an exposure to explore their forte.our mission is always to provide a value based education with professional training to our students through immaculately designed curriculum.

                    </p>
                <style>
    .bs-example{
    	margin: 20px;
    }
    .modal-dialog iframe{
        margin: 0 auto;
        display: block;
    }
</style>

</head>
<body>
<div class="bs-example">
    <!-- Button HTML (to Trigger Modal) -->
        <a href="http://crescenteducation.in/about-us.php" class="main-btn mt-55" style="margin-right: 20px;">More About us</a>
    <a href="#myModal1" class="main-btn mt-55" data-toggle="modal" style="margin-left: -20px;"> Take a Tour</a>

    
    <!-- Modal HTML -->
    <div id="myModal1" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe id="cartoonVideo" class="embed-responsive-item" width="560" height="315" src="//www.youtube.com/embed/A4-mQcWDBd4" allowfullscreen></iframe>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div> 
                </div> <!-- about cont -->
            </div>
            <div class="col-lg-5">
                 <div class="about-image-tow mt-55" style="padding-bottom:20px;">
                    <img src="images/about/about-3.jpg" alt="about">

                </div> <!-- about image tow -->
                <div class="news" style="background: #e9d4d8;
                    border-radius: 40px;
                    padding: 40px 30px 41px;">

                    <h3 style="color: #cc0606;">News &amp; Updates</h3>

                    <ul class="news-list">
                        <marquee scrollamount="3" height="300px" loop="" direction="up" crollamount="5" scrolldelay="40" onmouseover="this.stop();" onmouseout="this.start();">
                            <li>
                                <article class="entry">
                                    <div class="entry-body">
                                        <h5 class="entry-title"><a href="#"></a></h5>
                                        <div class="contact-info-menu">
                                            <div class="contact-info-item">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                <span style="color: #106EEB;">In appreciation of the excellent academic
                                                    results in the Board Examinations 2020, the CBSE Regional Office,
                                                    Dehradun,
                                                    has categorized our school as A+, which is among the best of the
                                                    best.

                                                    <p></p></span>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                            </li>
                            <li>
                                <article class="entry">
                                    <div class="entry-body">
                                        <h5 class="entry-title"><a href="#"></a></h5>
                                        <div class="contact-info-menu">
                                            <div class="contact-info-item">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                <span style="color: #106EEB;">This categorization has been done on the
                                                    basis
                                                    of overall academic performance of the school.</span>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                            </li>
                            <li>
                                <article class="entry">
                                    <div class="entry-body">
                                        <h5 class="entry-title"><a href="#"></a></h5>
                                        <div class="contact-info-menu">
                                            <div class="contact-info-item">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                <span style="color: #106EEB;">On being accredited with the A+ category
                                                    by
                                                    the CBSE, Dehradun, the School Management congratulates everyone
                                                    associated
                                                    with the school, for this great achievement.
                                                </span>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </li>
                            <li>

                            </li>
                    
                    </marquee>
                    <a href="#" class="info-btn"></a>
                </ul></div>
               
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== ABOUT PART ENDS ======-->

<!--====== ADMISSION PART START ======-->

<section class="admission-row pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-8">
                <div class="admission-card mt-30">
                    <div class="card-image">
                        <a href="#"><img src="images/admission/admission-1.jpg" alt="Admission"></a>
                    </div>
                    <div class="card-content">
                        <h4 class="card-titles">Our Motto</h4>
                        <p>We are an extremely close knit family with all the members working
                            towards the goal of development and character building of our students.</p>
                    </div>
                </div> <!-- admission card -->
            </div>

            <div class="col-lg-4 col-md-8">

                <div class="admission-info mt-30">
                    <div class="svg1">
                      
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="100 " height="100" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path xmlns="http://www.w3.org/2000/svg" d="M256,248a48,48,0,1,0-48-48A48.055,48.055,0,0,0,256,248Zm0-80a32,32,0,1,1-32,32A32.036,32.036,0,0,1,256,168Z" fill="#ffc600" data-original="#000000" style="" class="" />
                                <path xmlns="http://www.w3.org/2000/svg" d="M256,208h8a8,8,0,0,0,0-16v-8a8,8,0,0,0-16,0v16A8,8,0,0,0,256,208Z" fill="#ffc600" data-original="#000000" style="" class="" />
                                <path xmlns="http://www.w3.org/2000/svg" d="M320,304V272a8,8,0,0,0-8-8H200a8,8,0,0,0-8,8v32a8,8,0,0,0,8,8H312A8,8,0,0,0,320,304Zm-16-8H208V280h96Z" fill="#ffc600" data-original="#000000" style="" class="" />
                                <path xmlns="http://www.w3.org/2000/svg" d="M72,264h64a8,8,0,0,0,0-16V192a8,8,0,0,0-8-8H80a8,8,0,0,0-8,8v56a8,8,0,0,0,0,16Zm16-64h32v48H88Z" fill="#ffc600" data-original="#000000" style="" class="" />
                                <path xmlns="http://www.w3.org/2000/svg" d="M136,344V288a8,8,0,0,0-8-8H80a8,8,0,0,0-8,8v56a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16ZM88,296h32v48H88Z" fill="#ffc600" data-original="#000000" style="" class="" />
                                <path xmlns="http://www.w3.org/2000/svg" d="M136,440V384a8,8,0,0,0-8-8H80a8,8,0,0,0-8,8v56a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16ZM88,392h32v48H88Z" fill="#ffc600" data-original="#000000" style="" class="" />
                                <path xmlns="http://www.w3.org/2000/svg" d="M376,264h64a8,8,0,0,0,0-16V192a8,8,0,0,0-8-8H384a8,8,0,0,0-8,8v56a8,8,0,0,0,0,16Zm16-64h32v48H392Z" fill="#ffc600" data-original="#000000" style="" class="" />
                                <path xmlns="http://www.w3.org/2000/svg" d="M376,360h64a8,8,0,0,0,0-16V288a8,8,0,0,0-8-8H384a8,8,0,0,0-8,8v56a8,8,0,0,0,0,16Zm16-64h32v48H392Z" fill="#ffc600" data-original="#000000" style="" class="" />
                                <path xmlns="http://www.w3.org/2000/svg" d="M376,456h64a8,8,0,0,0,0-16V384a8,8,0,0,0-8-8H384a8,8,0,0,0-8,8v56a8,8,0,0,0,0,16Zm16-64h32v48H392Z" fill="#ffc600" data-original="#000000" style="" class="" />
                                <path xmlns="http://www.w3.org/2000/svg" d="M488,160a8,8,0,0,0,0-16H346.6L264,83.926V65.444l38.685,6.447A8,8,0,0,0,312,64V32a8,8,0,0,0-6.685-7.891l-48-8v.008A7.954,7.954,0,0,0,248,24V83.926L165.4,144H24a8,8,0,0,0,0,16h8V480H24a8,8,0,0,0,0,16H488a8,8,0,0,0,0-16h-8V160ZM248,480H216V392a40.067,40.067,0,0,1,32-39.195Zm16-127.195A40.067,40.067,0,0,1,296,392v88H264ZM256,336a56.064,56.064,0,0,0-56,56v88H176V156.074l80-58.182,80,58.182V480H312V392A56.064,56.064,0,0,0,256,336ZM296,54.556l-32-5.333V33.444l32,5.333ZM48,160H160V480H48ZM464,480H352V160H464Z" fill="#ffc600" data-original="#000000" style="" class="" />
                            </g>
                        </svg>
                    </div>
                    <h3 class="admission-title" style="
                        text-align: center;
                    ">Join The Best School in City </h3>
                    <p>Online Admission Open for 2022-23</p>
                    <div class="my-button"><a href="onlineadmission.php" class="main-btn"> Click Here</a></div>



                </div> <!-- admission info -->
            </div>

            <div class="col-lg-4 col-md-8">
                <div class="admission-card mt-30">
                    <div class="card-image">
                        <a href="#"><img src="images/admission/admission-2.jpg" alt="Admission"></a>
                    </div>
                    <div class="card-content">
                        <h4 class="card-titles">Our Objectives</h4>
                        <p>Change the age-old system of spoon feeding and make the child self reliant to manage the
                            challenges he/she faces and emerge successfully</p>
                    </div>
                </div> <!-- admission card -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== ADMISSION PART ENDS ======-->

<!--====== COURSE PART START ======-->

<section id="course-part" class="pt-115 pb-120 gray-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title pb-45">
                    <h5>Our Facilities</h5>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="courses-grid" role="tabpanel" aria-labelledby="courses-grid-tab">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-course mt-30">
                                        <div class="thum">
                                            <div class="image">
                                                <img src="images/course/cu-1.jpg" alt="Course">
                                            </div>
                                            <div class="price">
                                                <span>
                                                  
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="30" height="30" x="0" y="0" viewBox="0 0 480.00958 480" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                        <g>
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m128 104.003906v-32c0-4.417968-3.582031-8-8-8h-112c-4.417969 0-8 3.582032-8 8v32zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m0 120.003906v264h128v-264zm96 104h-64c-4.417969 0-8-3.582031-8-8v-64c0-4.417968 3.582031-8 8-8h64c4.417969 0 8 3.582032 8 8v64c0 4.417969-3.582031 8-8 8zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m0 432.003906v40c0 4.417969 3.582031 8 8 8h112c4.417969 0 8-3.582031 8-8v-40zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m0 400.003906h128v16h-128zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m144 400.003906h104v16h-104zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m248 32.003906v-24c0-4.417968-3.582031-7.99999975-8-7.99999975h-88c-4.417969 0-8 3.58203175-8 7.99999975v24zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m144 88.003906h104v296h-104zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m144 432.003906v40c0 4.417969 3.582031 8 8 8h88c4.417969 0 8-3.582031 8-8v-40zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m144 48.003906h104v24h-104zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m263.808594 165.667969 4.28125 16.433593 135.484375-36.128906-4.285157-16.433594zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m330.664062 421.949219 135.480469-36.128907-8.578125-32.886718-135.488281 36.128906zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m453.527344 337.453125-45.910156-176-135.488282 36.128906 45.910156 176zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m259.769531 150.1875 135.476563-36.125-11.484375-44.058594c-1.183594-4.265625-5.542969-6.816406-9.839844-5.757812l-120 32c-4.238281 1.160156-6.765625 5.5-5.683594 9.757812zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m470.183594 401.300781-135.488282 36.128907 9.542969 36.574218c.554688 2.0625 1.90625 3.820313 3.761719 4.882813 1.207031.730469 2.589844 1.117187 4 1.117187.699219 0 1.398438-.082031 2.078125-.238281l120-32c4.238281-1.160156 6.765625-5.503906 5.683594-9.761719zm0 0" fill="#07294d" data-original="#000000" style="" class="" />
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="cont">
                                            <a href="courses-single.html">
                                                <h4>Library</h4>
                                            </a>
                                        </div>
                                    </div> <!-- single course -->
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-course mt-30">
                                        <div class="thum">
                                            <div class="image">
                                                <img src="images/course/cu-4.jpg" alt="Course">
                                            </div>
                                            <div class="price">
                                                <span>
                                                  
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="30" height="30" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                        <g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                                <g>
                                                                    <g>
                                                                        <path d="M330.667,122.667c23.467,0,42.667-19.2,42.667-42.667s-19.2-42.667-42.667-42.667S288,56.533,288,80     S307.2,122.667,330.667,122.667z" fill="#07294d" data-original="#000000" style="" />
                                                                        <path d="M106.667,261.333C48,261.333,0,309.333,0,368s48,106.667,106.667,106.667c58.667,0,106.667-48,106.667-106.667     S165.333,261.333,106.667,261.333z M106.667,442.667C65.067,442.667,32,409.6,32,368s33.067-74.667,74.667-74.667     c41.6,0,74.667,33.067,74.667,74.667S148.267,442.667,106.667,442.667z" fill="#07294d" data-original="#000000" style="" />
                                                                        <path d="M404.267,238.933v-42.667c-32,0-58.667-11.733-77.867-30.933L284.8,124.8c-6.4-7.467-17.067-12.8-28.8-12.8     s-22.4,4.267-29.867,12.8l-58.667,58.667c-7.467,7.467-12.8,18.133-12.8,29.867s5.333,22.4,12.8,30.933l67.2,59.733v106.667     h42.667V277.333L230.4,230.4l50.133-51.2l16,16C323.2,222.933,360.533,238.933,404.267,238.933z" fill="#07294d" data-original="#000000" style="" />
                                                                        <path d="M405.333,261.333c-58.667,0-106.667,48-106.667,106.667s48,106.667,106.667,106.667C464,474.667,512,426.667,512,368     S464,261.333,405.333,261.333z M405.333,442.667c-41.6,0-74.667-33.067-74.667-74.667s33.067-74.667,74.667-74.667     C446.933,293.333,480,326.4,480,368S446.933,442.667,405.333,442.667z" fill="#07294d" data-original="#000000" style="" />
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="cont">
                                            <a href="sports_games.php">
                                                <h4>Games & Sports</h4>
                                            </a>
                                        </div>
                                    </div> <!-- single course -->
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-course mt-30">
                                        <div class="thum">
                                            <div class="image">
                                                <img src="images/course/cu-7.jpg" alt="Course">
                                            </div>
                                            <div class="price">
                                                <span>
                                                  
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="30" height="30" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                        <g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                                <path d="m327.282 426.077c-14.511 0-26.315 11.808-26.315 26.322s11.805 26.322 26.315 26.322 26.316-11.808 26.316-26.322c.001-14.514-11.805-26.322-26.316-26.322zm0 37.644c-6.239 0-11.315-5.079-11.315-11.322s5.076-11.322 11.315-11.322c6.24 0 11.316 5.079 11.316 11.322.001 6.243-5.076 11.322-11.316 11.322z" fill="#212529" data-original="#000000" style="" class="" />
                                                                <path d="m447.318 0h-240.072c-9.214 0-16.71 7.484-16.71 16.684v169.456c0 34.157 25.876 62.372 59.055 66.111v20.204c0 13.623 11.068 24.707 24.673 24.707h8.179l-14.374 154.891c-1.33 14.465 3.615 28.655 13.924 39.956 11.421 12.517 28.351 19.991 45.289 19.991 16.947 0 33.88-7.479 45.296-20.005 10.3-11.301 15.231-25.489 13.888-39.948l-14.346-154.885h8.152c13.62 0 24.701-11.083 24.701-24.707v-20.204c33.164-3.741 59.027-31.955 59.027-66.111v-169.456c0-9.2-7.483-16.684-16.682-16.684zm-85.827 481.892c-8.622 9.46-21.41 15.108-34.209 15.108-12.793 0-25.581-5.646-34.207-15.101-7.432-8.147-11.008-18.259-10.069-28.467l14.501-156.271h59.549l14.475 156.272c.948 10.208-2.617 20.314-10.04 28.459zm28.483-209.437c0 5.352-4.352 9.707-9.701 9.707h-106.009c-5.334 0-9.673-4.354-9.673-9.707v-19.77h125.383zm59.026-93.815h-103.157c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5h102.606c-3.642 24.88-25.109 44.045-50.975 44.045h-140.383c-25.88 0-47.359-19.166-51.003-44.045h105.666c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-106.218v-161.956c0-.913.783-1.684 1.71-1.684h26.362v95.908c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-95.908h28.102v51.149c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-51.149h28.072v95.908c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-95.908h28.072v51.149c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-51.149h28.073v95.908c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-95.908h26.391c.896 0 1.682.787 1.682 1.684z" fill="#212529" data-original="#000000" style="" class="" />
                                                                <path d="m147.28 195.076c1.858-2.472 3.3-5.335 4.278-8.56 5.939-19.584-6.091-48.575-20.648-68.62-8.636-11.888-7.607-24.833-6.928-33.4.502-6.312 1.02-12.838-4.72-15.985-5.929-3.251-12.244.907-19.89 6.683-16.845 12.758-27.925 25.732-37.05 43.389-11.929 23.138-16.886 54.263-3.421 74.733-6.571 4.443-10.901 11.97-10.901 20.49 0 11.708 8.196 21.531 19.149 24.047l-5.45 131.558c-.027.257-.041.518-.041.782 0 .032.004.062.005.094l-1.289 31.12c-.006.122-.018.241-.018.364 0 .012.002.024.002.036l-2.716 65.558c-.472 11.35 3.728 22.249 11.824 30.689 8.501 8.863 20.339 13.946 32.478 13.946 12.154 0 23.977-5.052 32.434-13.859 8.117-8.453 12.333-19.379 11.87-30.774l-5.81-139.692c-.171-4.139-3.645-7.352-7.805-7.182-4.139.172-7.354 3.667-7.182 7.805l1.43 34.396h-49.891l5.145-124.209h39.621l2.28 54.946c.167 4.033 3.489 7.189 7.487 7.189.105 0 .211-.002.316-.006 4.139-.172 7.354-3.666 7.183-7.805l-2.28-54.956c10.952-2.517 19.148-12.339 19.148-24.047 0-7.483-3.345-14.195-8.61-18.73zm-71.629-69.613c8.135-15.741 17.632-26.841 32.771-38.307.115-.087.229-.173.343-.258-.631 9.909-.507 25.336 10.008 39.812 14.176 19.518 22.099 43.357 18.431 55.452-1.014 3.345-2.838 5.576-5.694 6.937h-.292-56.555c-13.684-14.005-10.093-42.142.988-63.636zm55.61 342.519c.295 7.269-2.44 14.29-7.702 19.77-5.644 5.877-13.521 9.249-21.614 9.249-8.074 0-15.967-3.4-21.654-9.329-5.241-5.463-7.962-12.454-7.662-19.683l2.432-58.716h53.759zm-3.755-90.288.689 16.578h-52.513l.687-16.578zm3.711-154.21h-58.545c-5.333 0-9.672-4.342-9.672-9.678 0-5.352 4.339-9.707 9.672-9.707h58.545c5.334 0 9.673 4.354 9.673 9.707 0 5.337-4.339 9.678-9.673 9.678z" fill="#212529" data-original="#000000" style="" class="" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="cont">
                                            <a href="hostel_facilities.php">
                                                <h4>Hostel</h4>
                                            </a>
                                        </div>
                                    </div> <!-- single course -->
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-course mt-30">
                                        <div class="thum">
                                            <div class="image">
                                                <img src="images/course/cu-6.jpg" alt="Course">
                                            </div>
                                            <div class="price">
                                                <span>
                                                  
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="30" height="30" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                        <g>
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m21.5 14c-.276 0-.5-.224-.5-.5v-10c0-.827-.673-1.5-1.5-1.5h-15c-.827 0-1.5.673-1.5 1.5v10c0 .276-.224.5-.5.5s-.5-.224-.5-.5v-10c0-1.379 1.122-2.5 2.5-2.5h15c1.378 0 2.5 1.121 2.5 2.5v10c0 .276-.224.5-.5.5z" fill="#212529" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m6.5 23c-.066 0-.133-.013-.197-.04-.254-.109-.372-.403-.263-.657l3-7c.109-.254.403-.37.656-.263.254.109.372.403.263.657l-3 7c-.081.19-.265.303-.459.303z" fill="#212529" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m17.5 23c-.194 0-.378-.113-.459-.303l-3-7c-.109-.254.009-.548.263-.657.25-.108.547.009.656.263l3 7c.109.254-.009.548-.263.657-.064.027-.131.04-.197.04z" fill="#212529" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m12 21c-.276 0-.5-.224-.5-.5v-5c0-.276.224-.5.5-.5s.5.224.5.5v5c0 .276-.224.5-.5.5z" fill="#212529" data-original="#000000" style="" class="" />
                                                            <path xmlns="http://www.w3.org/2000/svg" d="m23.5 16h-23c-.276 0-.5-.224-.5-.5v-2c0-.276.224-.5.5-.5h23c.276 0 .5.224.5.5v2c0 .276-.224.5-.5.5zm-22.5-1h22v-1h-22z" fill="#212529" data-original="#000000" style="" class="" />
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="cont">
                                            <a href="atal.php">
                                                <h4>Atal Tinkering Lab</h4>
                                            </a>
                                        </div>
                                    </div> <!-- single course -->
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-course mt-30">
                                        <div class="thum">
                                            <div class="image">
                                                <img src="images/course/cu-3.jpg" alt="Course">
                                            </div>
                                            <div class="price">
                                                <span>
                                                  
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="30" height="30" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                        <g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M30.624,37.833a1.751,1.751,0,0,0,1.75-1.75V29.5a1.75,1.75,0,0,0-3.5,0v6.583A1.75,1.75,0,0,0,30.624,37.833Z" fill="#212529" data-original="#000000" style="" class="" />
                                                                <path d="M60.365,80.737a1.749,1.749,0,0,0-1.7-1.317H14.57a1.748,1.748,0,0,0-1.7,1.317,24.274,24.274,0,0,0-.755,6.013,24.5,24.5,0,1,0,48.245-6.013ZM36.62,107.75a21.024,21.024,0,0,1-21-21,20.8,20.8,0,0,1,.355-3.83H57.266A20.991,20.991,0,0,1,36.62,107.75Z" fill="#212529" data-original="#000000" style="" class="" />
                                                                <path d="M121.5,113.75h-6.562V109.5a1.75,1.75,0,0,0-1.75-1.75H111.94V31.942h7.186a1.75,1.75,0,0,0,1.75-1.75v-6a1.751,1.751,0,0,0-1.75-1.75H111.94V15.19a1.751,1.751,0,0,0-1.75-1.75h-6a1.751,1.751,0,0,0-1.75,1.75v7.252H94.88V14.224a4.74,4.74,0,0,0-.254-9.474h-21a4.74,4.74,0,0,0-.246,9.475v8.217H70.626a1.751,1.751,0,0,0-1.75,1.75v6a1.75,1.75,0,0,0,1.75,1.75H73.38V77.12a10.744,10.744,0,0,0,18.344,7.6,10.641,10.641,0,0,0,3.156-7.6V31.942h7.56V107.75h-1.252a1.751,1.751,0,0,0-1.75,1.75v4.25H50.783a30.485,30.485,0,0,0-.413-54.219V53.783c0-.012,0-.022,0-.034s0-.022,0-.034V47.033c0-.012,0-.022,0-.034s0-.022,0-.034V40.283c0-.012,0-.022,0-.034s0-.022,0-.034V33.533c0-.012,0-.022,0-.034s0-.022,0-.034V26.783c0-.012,0-.022,0-.034s0-.022,0-.034V21a4.74,4.74,0,0,0-.246-9.475h-27A4.741,4.741,0,0,0,22.87,21V59.531a30.485,30.485,0,0,0-.412,54.219H6.5a1.751,1.751,0,0,0-1.75,1.75v6a1.751,1.751,0,0,0,1.75,1.75h115a1.751,1.751,0,0,0,1.75-1.75v-6A1.751,1.751,0,0,0,121.5,113.75ZM105.94,16.94h2.5v5.5h-2.5ZM72.376,9.5a1.252,1.252,0,0,1,1.25-1.25h21a1.25,1.25,0,0,1,0,2.5h-21A1.252,1.252,0,0,1,72.376,9.5Zm4.5,4.75h14.5v8.192H76.88Zm-4.5,11.692h45v2.5h-45Zm19,9.25H87.126a1.75,1.75,0,0,0,0,3.5H91.38v3.25H87.126a1.75,1.75,0,0,0,0,3.5H91.38v3.25H87.126a1.75,1.75,0,0,0,0,3.5H91.38v3.25H87.126a1.75,1.75,0,0,0,0,3.5H91.38v3.25H87.126a1.75,1.75,0,0,0,0,3.5H91.38V77.12a7.264,7.264,0,0,1-7.25,7.25,7.258,7.258,0,0,1-7.25-7.25V31.942h14.5Zm14.56-3.25h2.5V107.75h-2.5Zm-3,79.308h8.5v2.5h-8.5ZM21.874,16.275a1.251,1.251,0,0,1,1.25-1.25h27a1.25,1.25,0,1,1,0,2.5h-27A1.25,1.25,0,0,1,21.874,16.275ZM9.62,86.75A27.073,27.073,0,0,1,25.351,62.22a1.75,1.75,0,0,0,1.019-1.59V21.025h20.5V25H42.624a1.75,1.75,0,0,0,0,3.5H46.87v3.25H42.624a1.75,1.75,0,1,0,0,3.5H46.87V38.5H42.624a1.75,1.75,0,0,0,0,3.5H46.87v3.25H42.624a1.75,1.75,0,0,0,0,3.5H46.87V52H42.624a1.75,1.75,0,0,0,0,3.5H46.87V60.63a1.75,1.75,0,0,0,1.02,1.59A27,27,0,1,1,9.62,86.75Zm110.13,33H8.25v-2.5h111.5Z" fill="#212529" data-original="#000000" style="" class="" />
                                                                <path d="M32.137,89.792a4.75,4.75,0,1,0,4.75,4.75A4.755,4.755,0,0,0,32.137,89.792Zm0,6a1.25,1.25,0,1,1,1.25-1.25A1.251,1.251,0,0,1,32.137,95.792Z" fill="#212529" data-original="#000000" style="" class="" />
                                                                <path d="M48.624,83.917a4.75,4.75,0,1,0,4.75,4.75A4.754,4.754,0,0,0,48.624,83.917Zm0,6a1.25,1.25,0,1,1,1.25-1.25A1.251,1.251,0,0,1,48.624,89.917Z" fill="#212529" data-original="#000000" style="" class="" />
                                                                <path d="M30.387,67.388a4.75,4.75,0,1,0,4.75-4.75A4.756,4.756,0,0,0,30.387,67.388Zm4.75-1.25a1.25,1.25,0,1,1-1.25,1.25A1.251,1.251,0,0,1,35.137,66.138Z" fill="#212529" data-original="#000000" style="" class="" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="cont">
                                            <a href="sciencelabs.php">
                                                <h4>Science Labs</h4>
                                            </a>
                                        </div>
                                    </div> <!-- single course -->
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-course mt-30">
                                        <div class="thum">
                                            <div class="image">
                                                <img src="images/course/cu-2.jpg" alt="Course">
                                            </div>
                                            <div class="price">
                                                <span>
                                                  
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="30" height="30" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                        <g>
                                                            <g xmlns="http://www.w3.org/2000/svg">
                                                                <path d="m512 145v-34c0-16.262-14.196-30-31-30h-114c-16.542 0-30 13.458-30 30v34z" fill="#212529" data-original="#000000" style="" class="" />
                                                                <path d="m337 175v226c0 16.542 13.458 30 30 30h114c16.804 0 31-13.738 31-30v-226zm91.36 191.35c-7.436 2.216-15.909-1.397-18.71-9.99-2.249-7.541 1.534-16.011 10-18.71 8.201-2.494 17.18 2.403 19.06 11.42 1.357 7.25-2.368 14.679-10.35 17.28zm0-64c-7.43 2.214-15.909-1.396-18.71-9.99-2.249-7.541 1.534-16.011 10-18.71 8.201-2.494 17.18 2.403 19.06 11.42 1.357 7.25-2.368 14.679-10.35 17.28z" fill="#212529" data-original="#000000" style="" class="" />
                                                                <path d="m273 81h-243c-16.54 0-30 13.46-30 30v203c0 16.54 13.46 30 30 30h243c16.54 0 30-13.46 30-30v-203c0-16.54-13.46-30-30-30z" fill="#212529" data-original="#000000" style="" class="" />
                                                                <path d="m232 401h-33v-27h-94v27h-33c-8.28 0-15 6.72-15 15s6.72 15 15 15h160c8.28 0 15-6.72 15-15s-6.72-15-15-15z" fill="#212529" data-original="#000000" style="" class="" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="cont">
                                            <a href="computerlab.php">
                                                <h4>Computer Labs</h4>
                                            </a>
                                        </div>
                                    </div> <!-- single course -->
                                </div>
                            </div> <!-- row -->
                        </div>

                    </div>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
    </div> <!-- course slide -->
    </div> <!-- container -->
</section>

<!--====== COURSE PART ENDS 
    <section id="about-part" class="pt-65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="section-title mt-50">
                        <h5>Philosophy of G.G.S Public School</h5>
                   
                    </div> 
                    <div class="about-cont">
                        <p>"Watch your musings; they get to be activities<br>
                            Watch your activities; they get to be propensities<br>
                            Watch your propensities; they turn into you're character<br>
                            Watch your Character for it turns into your Destiny".</p>
                        <a href="#" class="main-btn mt-55">Learn More</a>
                    </div>
                </div> 
                <div class="col-lg-6 offset-lg-1">
                    <div class="about-event mt-50">
                        <div class="event-title">
                            <h3>Upcoming events</h3>
                        </div>
                       <marquee direction = "up"> <ul>
                            <li>
                                <div class="single-event">
                                    <span><i class="fa fa-calendar"></i> 2 December 2018</span>
                                    <a href="events-single.html"><h4>Campus clean workshop</h4></a>
                                    <span><i class="fa fa-clock-o"></i> 10:00 Am - 3:00 Pm</span>
                                    <span><i class="fa fa-map-marker"></i> Rc Auditorim</span>
                                </div>
                            </li>
                            <li>
                                <div class="single-event">
                                    <span><i class="fa fa-calendar"></i> 2 December 2018</span>
                                    <a href="events-single.html"><h4>Tech Summit</h4></a>
                                    <span><i class="fa fa-clock-o"></i> 10:00 Am - 3:00 Pm</span>
                                    <span><i class="fa fa-map-marker"></i> Rc Auditorim</span>
                                </div>
                            </li>
                            <li>
                                <div class="single-event">
                                    <span><i class="fa fa-calendar"></i> 2 December 2018</span>
                                    <a href="events-single.html"><h4>Environment conference</h4></a>
                                    <span><i class="fa fa-clock-o"></i> 10:00 Am - 3:00 Pm</span>
                                    <span><i class="fa fa-map-marker"></i> Rc Auditorim</span>
                                </div>
                            </li>
                        </ul> </marquee>
                    </div> 
                </div>
            </div> 
        </div> 
        <div class="about-bg">
            <img src="images/about/bg-1.png" alt="About">
        </div>
    </section>======-->
<!--====== VIDEO FEATURE PART START ======-->

<section id="video-feature" class="bg_cover pt-60 pb-110" style="background-image: url(images/bg-1.jpg)">
    <div class="container">
        <div class="row align-items-center">
            <div class="order-last col-lg-6 order-lg-first">
                <div class="text-center video text-lg-left pt-50">
                    
                </div> <!-- row -->
            </div>
            <div class="order-first col-lg-5 offset-lg-1 order-lg-last">
                <div class="feature pt-50">
                    <div class="feature-title">
                        <h3>Why Choose us?</h3>
                    </div>
                    <ul>
                        <li>
                            <div class="single-feature">
                                <div class="icon">

                                  
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="71" height="60" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;background-color: #ff00008c;" xml:space="preserve" class="">                                        <g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path d="M504.984,407.552c-4.486-4.37-10.547-6.739-16.809-6.578c-33.187,0.855-64.219-6.478-92.22-26.71    c-25.3-18.279-45.075-44.849-61.547-71.479c-9.209-14.888-17.894-33.443-42.745-52.21c-30.764-23.236-71.898-33.537-109.531-33.63    v-50.912l55.611,41.751c25.235,6.452,49.633,17.687,70.077,34.915c18.506,15.595,27.542,30.093,35.339,43.223l10.051-4.423    l5.98,29.697c12.223,17.828,24.964,32.867,39.287,44.615c1.685-3.255,2.321-7.08,1.541-10.952l-18.14-90.084    c-0.993-4.926-4.152-9.143-8.601-11.481c-4.449-2.336-9.714-2.544-14.333-0.566l-23.457,10.049    c-6.28-25.238-8.436-33.902-14.58-58.596l56.505-77.152c4.538-6.196,3.194-14.9-3.003-19.439    c-6.197-4.539-14.898-3.194-19.44,3.003l-57.133,78.01l-38.956,10.266l-76.747-57.619v-9.2c0-5.202-2.352-10.126-6.399-13.395    l-75.536-61.009c-5.327-4.302-12.935-4.302-18.263,0L6.399,108.655C2.353,111.925,0,116.848,0,122.05v337.033    c0,4.693,3.805,8.497,8.497,8.497h20.366c4.693,0,8.498-3.805,8.498-8.497v-90.074h107.411v90.074    c0,4.693,3.805,8.497,8.497,8.497h4.179c0.21,0,0.275,0,0.266,0h15.921c4.693,0,8.498-3.805,8.498-8.497V284.537    c18.986,2.052,43.324,7.407,65.79,20.479c18.565,10.803,33.309,25.424,43.879,43.523c23.311,39.917,44.09,65.968,67.373,84.471    c38.645,30.711,83.079,38.657,132.495,32.511c0.009-0.001,0.019-0.002,0.029-0.003C503.326,464.062,512,454.201,512,442.482v-18.3    C512,417.919,509.469,411.922,504.984,407.552z M144.772,339.822L144.772,339.822H37.361v-40.863h107.411V339.822z     M144.772,269.771L144.772,269.771H37.361v-42.007h107.411V269.771z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                </g>
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path d="M448.619,294.203c-58.083-46.371-53.978-43.173-55.356-44.016c0.486,1.719-0.339-2.18,10.325,50.777l24.206,19.325    c7.204,5.752,17.706,4.571,23.456-2.631C457.001,310.456,455.823,299.954,448.619,294.203z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                </g>
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <circle cx="271.262" cy="146.57" r="32.45" fill="#ffc600" data-original="#000000" style="" class="" />
                                                </g>
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                        </g>
                                    </svg>

                                </div>
                                <div class="cont">
                                    <h4>Excellent Infrastructure</h4>
                                    <p>The ultramodern facilities available in the school including Computer – aided
                                        – learning (Smart Class Rooms).</p>
                                </div>
                            </div> <!-- single feature -->
                        </li>
                        <li>
                            <div class="single-feature">
                                <div class="icon">

                                  
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="70" height="61" x="0" y="0" viewBox="0 0 512.037 512.037" style="enable-background:new 0 0 512 512;background-color: #596fdac9;" xml:space="preserve" class="">
                                        <g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path d="m75.633 301.76c-20.377 8.44-30.088 31.886-21.648 52.263 6.375 15.388 21.303 24.693 37.008 24.693 5.091 0 10.267-.979 15.255-3.045 20.377-8.44 30.088-31.885 21.648-52.262-8.441-20.378-31.884-30.09-52.263-21.649zm22.961 55.433c-10.188 4.219-21.911-.635-26.132-10.824-4.22-10.189.636-21.912 10.824-26.132 2.495-1.033 5.081-1.522 7.627-1.522 7.852 0 15.317 4.653 18.504 12.347 4.221 10.188-.634 21.911-10.823 26.131z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                    <path d="m54.002 237.522c4.089 9.872 11.777 17.56 21.648 21.648 4.99 2.067 10.163 3.045 15.255 3.045 15.704 0 30.634-9.306 37.007-24.693 8.44-20.377-1.271-43.822-21.647-52.262-9.872-4.089-20.744-4.089-30.615 0s-17.559 11.777-21.647 21.648c-4.09 9.871-4.09 20.743-.001 30.614zm18.478-22.96c2.044-4.936 5.888-8.78 10.824-10.824 2.468-1.022 5.061-1.533 7.653-1.533s5.187.511 7.654 1.533c10.188 4.22 15.044 15.942 10.824 26.131-4.221 10.188-15.944 15.045-26.131 10.824-4.936-2.044-8.78-5.888-10.824-10.824-2.045-4.935-2.045-10.371 0-15.307z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                    <path d="m158.04 176.805c4.936 2.044 10.121 3.066 15.308 3.066 5.185 0 10.372-1.022 15.307-3.066 9.871-4.089 17.559-11.777 21.648-21.648 4.088-9.871 4.088-20.744 0-30.615s-11.776-17.559-21.647-21.648-20.744-4.089-30.615 0c-9.872 4.088-17.56 11.776-21.648 21.648-4.088 9.871-4.088 20.744 0 30.614 4.087 9.871 11.775 17.56 21.647 21.649zm-3.171-44.61c2.044-4.936 5.888-8.779 10.824-10.824 2.468-1.022 5.06-1.533 7.653-1.533s5.186.511 7.654 1.533c4.936 2.044 8.779 5.888 10.824 10.824 2.044 4.936 2.044 10.372 0 15.307-2.044 4.936-5.888 8.78-10.824 10.824-4.936 2.044-10.372 2.044-15.308 0s-8.779-5.889-10.824-10.825c-2.043-4.934-2.043-10.37.001-15.306z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                    <path d="m157.999 458.06c4.99 2.067 10.163 3.045 15.255 3.045 15.704 0 30.634-9.306 37.007-24.693 4.089-9.871 4.089-20.744 0-30.615s-11.777-17.56-21.648-21.648c-9.872-4.089-20.744-4.089-30.615 0s-17.559 11.777-21.648 21.648c-8.439 20.378 1.272 43.823 21.649 52.263zm-3.17-44.608c2.044-4.936 5.889-8.78 10.824-10.824 2.468-1.022 5.061-1.533 7.653-1.533s5.186.511 7.654 1.533c4.935 2.044 8.779 5.888 10.823 10.824s2.044 10.372 0 15.308c-4.22 10.188-15.941 15.043-26.131 10.824-10.188-4.222-15.043-15.944-10.823-26.132z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                    <path d="m274.499 458.077c4.936 2.044 10.121 3.066 15.307 3.066s10.372-1.022 15.307-3.067c9.872-4.088 17.56-11.776 21.648-21.648 4.088-9.871 4.088-20.744 0-30.614-4.088-9.871-11.776-17.56-21.648-21.648-9.871-4.089-20.743-4.089-30.614 0-20.377 8.44-30.088 31.885-21.648 52.263 4.089 9.871 11.777 17.559 21.648 21.648zm7.654-55.433c2.468-1.022 5.061-1.533 7.654-1.533s5.186.511 7.654 1.533c4.936 2.044 8.779 5.888 10.824 10.824 2.044 4.936 2.044 10.372 0 15.307-2.044 4.936-5.888 8.779-10.824 10.824s-10.372 2.044-15.307 0c-4.936-2.044-8.78-5.888-10.824-10.824-4.221-10.189.634-21.911 10.823-26.131z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                    <path d="m372.144 378.756c15.704 0 30.633-9.305 37.007-24.693 4.089-9.871 4.089-20.744 0-30.615-4.089-9.872-11.777-17.56-21.648-21.648-20.377-8.441-43.821 1.271-52.262 21.647-8.44 20.377 1.271 43.822 21.647 52.262 4.99 2.068 10.164 3.047 15.256 3.047zm-18.426-47.654c4.22-10.188 15.943-15.043 26.131-10.824 10.188 4.22 15.044 15.943 10.824 26.131s-15.94 15.044-26.132 10.824c-10.187-4.22-15.042-15.942-10.823-26.131z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                    <path d="m503.612 8.418c-11.14-11.14-29.056-11.235-40.788-.218l-153.092 143.787c-2.685-8.018-4.114-16.474-4.171-24.97-.032-4.704 1.005-9.935 2.103-15.473 2.426-12.244 5.176-26.121-3.679-38.173-7.985-10.868-23.594-17.216-49.122-19.979-53.057-5.746-106.697 7.146-151.041 36.294-4.615 3.034-5.897 9.234-2.864 13.849s9.235 5.897 13.849 2.864c40.475-26.605 89.448-38.369 137.903-33.124 23.692 2.565 32.195 7.907 35.156 11.938 3.398 4.625 2.334 11.564.178 22.443-1.243 6.273-2.529 12.76-2.484 19.494.091 13.626 3.004 27.178 8.454 39.597l-62.038 58.267c-45.251 13.055-46.243 39.977-47.04 61.685-.537 14.623-1 27.252-12.254 38.506-2.198 2.199-3.249 5.294-2.843 8.376.406 3.083 2.222 5.801 4.915 7.355 7.952 4.591 18.161 6.829 29.188 6.829 15.456 0 32.515-4.398 47.203-12.878 22.479-12.979 35.411-32.679 36.773-55.795l57.365-61.078c12.421 5.451 25.968 8.364 39.597 8.455 6.758.047 13.221-1.241 19.494-2.483 10.881-2.155 17.82-3.219 22.444.178 4.03 2.961 9.373 11.464 11.938 35.156 6.886 63.618-15.082 126.021-60.27 171.208-81.879 81.879-215.105 81.879-296.984 0-70.092-70.09-81.507-180.985-27.142-263.682 3.034-4.615 1.752-10.815-2.863-13.849-4.615-3.035-10.816-1.753-13.849 2.863-28.631 43.552-41.621 96.267-36.578 148.438 5.112 52.886 28.654 102.738 66.29 140.374 43.441 43.441 101.2 67.365 162.635 67.365s119.193-23.924 162.634-67.365c49.492-49.491 73.552-117.833 66.011-187.503-2.763-25.528-9.112-41.136-19.979-49.121-12.052-8.855-25.93-6.105-38.174-3.679-5.538 1.097-10.771 2.144-15.473 2.102-8.498-.057-16.952-1.486-24.97-4.171l143.786-153.094c11.018-11.731 10.923-29.647-.218-40.788zm-262.467 309.149c-15.374 8.876-32.501 11.493-44.984 9.672 7.8-13.57 8.323-27.813 8.763-39.806.725-19.763 1.231-33.205 29.232-42.183l33.719 33.72c-1.761 21.055-17.265 33.132-26.73 38.597zm248.107-282.054-211.432 225.118-26.42-26.42 225.117-211.432c3.809-3.577 9.499-3.673 12.953-.218 3.455 3.455 3.359 9.144-.218 12.952z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                    <path d="m74.438 136.473c5.523 0 10-4.477 10-10s-4.477-10-10-10h-.007c-5.523 0-9.996 4.477-9.996 10s4.48 10 10.003 10z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                </g>
                                            </g>
                                        </g>
                                    </svg>

                                </div>
                                <div class="cont">
                                    <h4>Co-Curricular Activities</h4>
                                    <p>Co-Curricular Activities have been an inseparable part of curriculum of the
                                        school</p>
                                </div>
                            </div> <!-- single feature -->
                        </li>
                        <li>
                            <div class="single-feature">
                                <div class="icon">

                                  
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="70" height="70" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;background-color: #f08cd1a6;" xml:space="preserve" class="">
                                        <g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                                <path d="m512 0h-414.5v45h15v67.629c-16.273 1.509-31.904 7.884-44.663 18.342l9.509 11.602c12.036-9.866 27.184-15.299 42.654-15.299 37.219 0 67.499 30.28 67.499 67.499v67.501h-34.393l19.394-19.394v-38.512l-51.283-17.095h-53.717v55.606l23.318 23.318-38.318 11.496v-82.921c0-15.471 5.433-30.618 15.298-42.652l-11.6-9.51c-12.058 14.709-18.698 33.234-18.698 52.162v87.421l-15 4.5v82.808h-22.5v45h15v97.499h209.999v-97.499h15v-45h-37.5v-17.005h219.502v-15h-215.716l88.717-78.902 1.193-50.199 13.343-19.799-12.439-8.383-13.941 20.687-75.813 61.374h-4.845v-67.501c0-42.961-33.012-78.339-74.999-82.143v-67.63h354.499v292.496h-45v15h60v-307.496h15zm-377.001 277.272h18.401l-34.021 31.591-35.073-25.052 21.794-6.539zm-52.499-75h36.283l38.717 12.905v21.488l-25.607 25.606h-23.786l-25.607-25.605zm-45 95.582 28.633-8.59 46.366 33.119v47.119h-37.499v-37.5h-15v37.5h-22.5zm172.499 199.146h-179.999v-82.499h179.999zm14.999-97.499h-209.998v-15h209.998zm-12.344-122.228 68.212-55.219-.705 29.665-92.662 82.41v35.372h-60v-47.708l47.945-44.52zm284.346-247.273h-384.5v-15h384.5z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                <path d="m340.573 91.267-19.393-19.394h-58.713l-19.394 19.394v115.605h15v-52.5h67.5v52.5h15zm-15 48.105h-67.5v-41.893l10.606-10.606h46.287l10.606 10.606v41.893z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                <path d="m355.573 139.372v67.5h75v-97.499h-75v15h60v14.999zm60 52.5h-45v-37.5h45z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                <path d="m355.573 251.872h75v15h-75z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                <path d="m355.573 221.872h75v15h-75z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                <path d="m325.573 221.872h15v15h-15z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                <path d="m325.573 251.872h15v15h-15z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                <path d="m452 60h15v15h-15z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                <path d="m179.999 429.501h15v15h-15z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                <path d="m422 60h15v15.001h-15z" fill="#ffc600" data-original="#000000" style="" class="" />
                                            </g>
                                        </g>
                                    </svg>

                                </div>
                                <div class="cont">
                                    <h4>Dedicated Staff</h4>
                                    <p>They dedicate their time, their expertise and their hearts to the educational betterment.</p>
                                </div>
                            </div> <!-- single feature -->
                        </li>
                    </ul>
                </div> <!-- feature -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
    <div class="feature-bg"></div> <!-- feature bg -->
</section>

<!--====== VIDEO FEATURE PART ENDS ======-->
<section id="news-part" class="pt-115 pb-110">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title pb-50">
                    <h5>Our Pre School</h5>

                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row">
            <div class="col-lg-6">
                <div class="single-news mt-30">
                    <div class="news-thum pb-25">
                        <img src="images/news/n-1.jpg" alt="News">
                    </div>
                    <div class="news-cont">

                        <a href="blog-single.html">
                            <h4 style="
    font-size: 16px;
    line-height: 27px;
    text-align: justify;
">In an environment of immense positivity we nurture our little learner to learn &amp; grow, learning in encouraged
                                through play and creative thinking. Our Little Ones Bloom in an atmosphere of care
                                and happiness.</h4>
                        </a>
                        <p></p>
                    </div>
                </div> <!-- single news -->
            </div>
            <div class="col-lg-6">
                <div class="single-news news-list">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="news-thum mt-30">
                                <div class="svg">
                                  
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="100" height="100" x="0" y="0" viewBox="0 0 31.695 31.695" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                        <g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <polygon points="13.236,14.937 13.551,21.738 17.734,21.738 18.053,14.937 20.48,14.937 21.148,11.556 18.232,11.556     18.193,10.132 17.788,10.132 17.264,10.132 16.475,10.132 15.688,11.075 14.877,10.132 14.045,10.132 13.452,10.132     12.995,10.132 12.995,11.556 10.27,11.556 10.937,14.937   " fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="15.651" cy="7.68" r="2.132" fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="23.535" cy="24.066" r="1.004" fill="#ffc600" data-original="#000000" style="" />
                                                    <path d="M28.145,25.07c0.556,0,1.004-0.449,1.004-1.004c0-0.559-0.448-1.006-1.004-1.006c-0.558,0-1.004,0.447-1.004,1.006    C27.141,24.621,27.587,25.07,28.145,25.07z" fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="18.432" cy="24.066" r="1.004" fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="12.986" cy="24.066" r="1.004" fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="7.731" cy="23.971" r="1.003" fill="#ffc600" data-original="#000000" style="" />
                                                    <path d="M2.5,24.975c0.557,0,1.006-0.449,1.006-1.004S3.057,22.968,2.5,22.968c-0.553,0-1.001,0.448-1.001,1.003    S1.947,24.975,2.5,24.975z" fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="23.534" cy="27.207" r="1.446" fill="#ffc600" data-original="#000000" style="" />
                                                    <polygon points="24.092,28.869 23.561,29.509 23.008,28.869 21.732,29.111 21.732,31.652 25.337,31.652 25.279,29.131   " fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="18.295" cy="27.206" r="1.445" fill="#ffc600" data-original="#000000" style="" />
                                                    <polygon points="18.854,28.869 18.32,29.509 17.77,28.869 16.494,29.131 16.494,31.652 20.1,31.652 20.025,29.131   " fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="20.843" cy="25.189" r="1.058" fill="#ffc600" data-original="#000000" style="" />
                                                    <path d="M22.159,28.379c-0.188-0.354-0.318-0.74-0.318-1.173c0-0.283,0.074-0.546,0.162-0.8h-0.104h-0.258h-0.392l-0.39,0.468    l-0.402-0.468h-0.413h-0.231c0.106,0.246,0.168,0.515,0.168,0.8c0,0.466-0.164,0.892-0.432,1.237h2.61V28.379z" fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="12.986" cy="27.207" r="1.446" fill="#ffc600" data-original="#000000" style="" />
                                                    <polygon points="13.543,28.869 13.012,29.509 12.46,28.869 11.184,29.131 11.184,31.652 14.789,31.652 14.716,29.131   " fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="15.531" cy="25.189" r="1.058" fill="#ffc600" data-original="#000000" style="" />
                                                    <path d="M16.85,28.379c-0.188-0.354-0.32-0.74-0.32-1.173c0-0.283,0.077-0.546,0.164-0.8h-0.104H16.33h-0.392l-0.39,0.468    l-0.402-0.468h-0.414h-0.23c0.106,0.246,0.168,0.515,0.168,0.8c0,0.466-0.162,0.892-0.432,1.237h2.612V28.379L16.85,28.379z" fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="28.835" cy="27.14" r="1.446" fill="#ffc600" data-original="#000000" style="" />
                                                    <polygon points="29.393,28.805 28.859,29.441 28.309,28.805 27.033,29.092 27.033,31.589 30.639,31.589 30.564,29.072   " fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="26.068" cy="25.124" r="1.058" fill="#ffc600" data-original="#000000" style="" />
                                                    <path d="M27.389,28.312c-0.188-0.354-0.32-0.74-0.32-1.172c0-0.283,0.076-0.547,0.162-0.803h-0.103h-0.26h-0.392l-0.389,0.469    l-0.404-0.469H25.27H25.04c0.106,0.248,0.168,0.52,0.168,0.803c0,0.463-0.162,0.891-0.431,1.237h2.611V28.312z" fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="7.814" cy="27.248" r="1.446" fill="#ffc600" data-original="#000000" style="" />
                                                    <polygon points="8.373,28.909 7.838,29.548 7.287,28.909 6.012,29.131 6.012,31.695 9.616,31.695 9.542,29.131   " fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="10.358" cy="25.23" r="1.057" fill="#ffc600" data-original="#000000" style="" />
                                                    <path d="M11.677,28.484l-0.001-0.063c-0.188-0.356-0.318-0.743-0.318-1.172c0-0.285,0.076-0.549,0.162-0.804h-0.104h-0.258h-0.391    l-0.391,0.47l-0.402-0.47H9.561H9.329c0.105,0.248,0.167,0.519,0.167,0.803c0,0.464-0.162,0.888-0.432,1.236H11.677z" fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="2.502" cy="27.248" r="1.446" fill="#ffc600" data-original="#000000" style="" />
                                                    <polygon points="3.062,28.909 2.528,29.548 1.977,28.909 0.666,29.131 0.7,31.695 4.307,31.695 4.231,29.131   " fill="#ffc600" data-original="#000000" style="" />
                                                    <circle cx="5.049" cy="25.23" r="1.057" fill="#ffc600" data-original="#000000" style="" />
                                                    <path d="M6.105,26.445H5.847H5.456l-0.39,0.47l-0.402-0.47H4.25H4.02c0.106,0.248,0.168,0.519,0.168,0.803    c0,0.464-0.164,0.888-0.432,1.236h2.611l-0.002-0.063c-0.188-0.356-0.318-0.743-0.318-1.172c0-0.285,0.076-0.549,0.164-0.804    H6.105z" fill="#ffc600" data-original="#000000" style="" />
                                                    <path d="M20.98,7.716l-1.199,2.096L20.3,9.734c0.033-0.008,3.479-0.541,5.849-1.243c3.103-0.92,4.881-2.446,4.881-4.189    C31.027,1.93,28.225,0,24.777,0c-3.446,0-6.252,1.93-6.252,4.301C18.525,5.644,19.438,6.905,20.98,7.716z M24.777,0.505    c3.168,0,5.746,1.701,5.746,3.796c0,2.135-3.162,3.302-4.521,3.706c-1.788,0.528-4.211,0.965-5.261,1.142L21.688,7.5l-0.248-0.117    c-1.508-0.717-2.41-1.868-2.41-3.081C19.029,2.206,21.607,0.505,24.777,0.505z" fill="#ffc600" data-original="#000000" style="" />
                                                </g>
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="news-cont mt-30">

                                <a href="blog-single.html">
                                    <h3>Safety First</h3>
                                </a>
                                <p>We offer first-class protection and security for your children.</p>
                            </div>
                        </div>
                    </div> <!-- row -->
                </div> <!-- single news -->
                <div class="single-news news-list">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="news-thum mt-30">
                                <div class="svg">
                                  
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="80" height="80" x="0" y="0" viewBox="0 0 512 512.00142" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                        <g>
                                            <g xmlns="http://www.w3.org/2000/svg" id="surface1">
                                                <path d="M 217.996094 158.457031 C 164.203125 158.457031 120.441406 202.21875 120.441406 256.007812 C 120.441406 309.800781 164.203125 353.5625 217.996094 353.5625 C 271.785156 353.5625 315.546875 309.800781 315.546875 256.007812 C 315.546875 202.21875 271.785156 158.457031 217.996094 158.457031 Z M 275.914062 237.636719 L 206.027344 307.523438 C 203.09375 310.457031 199.246094 311.925781 195.402344 311.925781 C 191.558594 311.925781 187.714844 310.460938 184.78125 307.523438 L 158.074219 280.816406 C 152.207031 274.953125 152.207031 265.441406 158.074219 259.574219 C 163.9375 253.707031 173.449219 253.707031 179.316406 259.574219 L 195.402344 275.660156 L 254.671875 216.394531 C 260.535156 210.527344 270.046875 210.527344 275.914062 216.394531 C 281.78125 222.257812 281.78125 231.769531 275.914062 237.636719 Z M 275.914062 237.636719 " style="" fill="#ffc600" data-original="#000000" class="" />
                                                <path d="M 435.488281 138.917969 L 435.472656 138.519531 C 435.25 133.601562 435.101562 128.398438 435.011719 122.609375 C 434.59375 94.378906 412.152344 71.027344 383.917969 69.449219 C 325.050781 66.164062 279.511719 46.96875 240.601562 9.042969 L 240.269531 8.726562 C 227.578125 -2.910156 208.433594 -2.910156 195.738281 8.726562 L 195.40625 9.042969 C 156.496094 46.96875 110.957031 66.164062 52.089844 69.453125 C 23.859375 71.027344 1.414062 94.378906 0.996094 122.613281 C 0.910156 128.363281 0.757812 133.566406 0.535156 138.519531 L 0.511719 139.445312 C -0.632812 199.472656 -2.054688 274.179688 22.9375 341.988281 C 36.679688 379.277344 57.492188 411.691406 84.792969 438.335938 C 115.886719 468.679688 156.613281 492.769531 205.839844 509.933594 C 207.441406 510.492188 209.105469 510.945312 210.800781 511.285156 C 213.191406 511.761719 215.597656 512 218.003906 512 C 220.410156 512 222.820312 511.761719 225.207031 511.285156 C 226.902344 510.945312 228.578125 510.488281 230.1875 509.925781 C 279.355469 492.730469 320.039062 468.628906 351.105469 438.289062 C 378.394531 411.636719 399.207031 379.214844 412.960938 341.917969 C 438.046875 273.90625 436.628906 199.058594 435.488281 138.917969 Z M 217.996094 383.605469 C 147.636719 383.605469 90.398438 326.367188 90.398438 256.007812 C 90.398438 185.648438 147.636719 128.410156 217.996094 128.410156 C 288.351562 128.410156 345.59375 185.648438 345.59375 256.007812 C 345.59375 326.367188 288.351562 383.605469 217.996094 383.605469 Z M 217.996094 383.605469 " style="" fill="#ffc600" data-original="#000000" class="" />
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="news-cont mt-30">

                                <a href="blog-single.html">
                                    <h3>Small Class Size</h3>
                                </a>
                                <p style="text-align: justify;">All classes in our school have strength of maximum 30 students so that the proper focus of the teacher is upon the
                                    students and involve them in the lectures.</p>
                            </div>
                        </div>
                    </div> <!-- row -->
                </div> <!-- single news -->
                <div class="single-news news-list">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="news-thum mt-30">
                                <div class="svg">
                                    <a href="#">
                                      
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="80" height="80" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                            <g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                    <path d="m90.937 195.098c0-9.524 3.884-18.198 10.177-24.463 6.265-6.293 14.939-10.176 24.463-10.176 9.553 0 18.198 3.883 24.492 10.176 6.265 6.265 10.176 14.938 10.176 24.463 0 9.241.482 17.887 1.304 26.079h17.688c5.386 0 10.261-2.183 13.805-5.726 3.543-3.543 5.754-8.447 5.754-13.805v-28.176c0-4.139 3.345-7.512 7.512-7.512h28.177c5.357 0 10.261-2.183 13.805-5.754 3.543-3.543 5.754-8.419 5.754-13.776 0-5.386-2.211-10.261-5.754-13.805s-8.447-5.754-13.805-5.754h-28.177c-4.167 0-7.512-3.345-7.512-7.483v-28.206c0-5.358-2.211-10.233-5.754-13.777-3.544-3.543-8.419-5.754-13.805-5.754h-28.176c-4.139 0-7.484-3.373-7.484-7.512v-28.177c0-5.386-2.211-10.261-5.754-13.805-3.544-3.543-8.447-5.754-13.805-5.754s-10.233 2.211-13.805 5.754c-3.544 3.543-5.727 8.419-5.727 13.805v28.177c0 4.139-3.373 7.512-7.512 7.512h-28.176c-5.358 0-10.262 2.211-13.805 5.754-3.543 3.544-5.754 8.419-5.754 13.777v110.466c0 5.358 2.211 10.262 5.754 13.805s8.447 5.726 13.805 5.726h22.139zm330.127 81.524c0 4.139-3.345 7.483-7.483 7.483s-7.512-3.345-7.512-7.483v-47.934-33.59c0-5.386-2.211-10.318-5.783-13.861-3.543-3.572-8.476-5.783-13.861-5.783-5.387 0-10.319 2.211-13.862 5.783-3.571 3.544-5.782 8.476-5.782 13.861 0 23.556-3.175 44.192-7.257 67.266-2.948 16.725-5.698 32.4-5.698 48.869 0 20.325 5.727 57.203 24.945 70.129 2.098 1.389 3.316 3.713 3.316 6.207l.028 19.843h76.196c4.139-16.271 9.949-29.48 15.875-42.973 11.197-25.455 22.819-51.902 22.819-102.416 0-29.338-4.054-56.636-11.056-79.625-4.365-14.372-9.864-27.014-16.185-37.361v56.608c0 9.496-3.885 18.142-10.149 24.407-6.265 6.264-14.882 10.148-24.406 10.148h-14.145zm0-81.524v26.079h14.145c5.386 0 10.262-2.183 13.805-5.726 3.544-3.543 5.755-8.447 5.755-13.805v-110.466c0-5.358-2.211-10.233-5.755-13.777-3.543-3.543-8.419-5.754-13.805-5.754h-28.176c-4.139 0-7.513-3.373-7.513-7.512v-28.177c0-5.386-2.182-10.261-5.726-13.805-3.543-3.543-8.448-5.754-13.806-5.754-5.357 0-10.261 2.211-13.805 5.754-3.543 3.543-5.754 8.419-5.754 13.805v28.177c0 4.139-3.345 7.512-7.483 7.512h-28.176c-5.387 0-10.262 2.211-13.805 5.754-3.544 3.544-5.755 8.419-5.755 13.777v20.693h20.693c9.524 0 18.142 3.883 24.406 10.148 6.265 6.265 10.148 14.882 10.148 24.406 0 9.496-3.884 18.142-10.148 24.406-6.265 6.236-14.882 10.12-24.406 10.12h-20.693v20.693c0 5.358 2.211 10.262 5.755 13.805 3.543 3.543 8.418 5.726 13.805 5.726h25.71c.794-8.192 1.305-16.838 1.305-26.079 0-9.524 3.883-18.198 10.176-24.463 6.265-6.293 14.938-10.176 24.464-10.176 9.553 0 18.198 3.883 24.491 10.176 6.264 6.264 10.148 14.938 10.148 24.463zm-330.127 41.102h-22.139c-9.525 0-18.142-3.884-24.407-10.148-6.265-6.265-10.148-14.911-10.148-24.407v-42.151c-4.082 8.872-7.625 18.878-10.517 29.792-5.613 21.288-8.731 46.006-8.731 72.737 0 50.514 11.623 76.961 22.819 102.416 5.924 13.493 11.735 26.702 15.874 42.973h76.196v-19.842c0-2.409 1.19-4.762 3.345-6.207 19.247-12.926 24.974-49.805 24.974-70.129 0-16.469-2.778-32.145-5.726-48.869-4.054-23.074-7.229-43.71-7.229-67.266 0-5.386-2.211-10.318-5.783-13.861-3.572-3.572-8.476-5.783-13.89-5.783-5.386 0-10.29 2.211-13.861 5.783-3.572 3.544-5.784 8.476-5.784 13.861v33.59 47.934c0 4.139-3.345 7.483-7.483 7.483-4.167 0-7.512-3.345-7.512-7.483v-40.423zm311.503 259.37c4.139 0 7.512 3.374 7.512 7.512s-3.373 7.512-7.512 7.512h-54.058c-4.139 0-7.512-3.374-7.512-7.512v-61.937c0-9.27 3.799-17.717 9.922-23.839 4.422-4.422 10.034-7.625 16.327-9.043v-16.979c-21.345-17.66-28.29-54.369-28.29-80.051 0-17.716 2.863-34.044 5.925-51.42 1.36-7.597 2.721-15.42 3.911-23.612h-23.895c-9.525 0-18.142-3.884-24.406-10.148-6.266-6.265-10.148-14.911-10.148-24.407v-28.176c0-4.139 3.345-7.512 7.512-7.512h28.177c5.357 0 10.262-2.183 13.805-5.754 3.543-3.543 5.754-8.419 5.754-13.776 0-5.386-2.211-10.261-5.754-13.805s-8.447-5.754-13.805-5.754h-28.177c-4.167 0-7.512-3.345-7.512-7.483v-28.206c0-9.496 3.883-18.142 10.148-24.378 6.264-6.264 14.881-10.148 24.406-10.148h20.665v-20.694c0-9.524 3.883-18.142 10.147-24.406 6.265-6.265 14.91-10.148 24.406-10.148 9.497 0 18.143 3.883 24.407 10.148 6.265 6.265 10.148 14.882 10.148 24.406v20.693h20.664c9.524 0 18.142 3.883 24.406 10.148 6.265 6.236 10.149 14.882 10.149 24.378v29.027c12.558 13.521 23.103 33.59 30.501 57.855 7.428 24.463 11.737 53.263 11.737 83.962 0 53.604-12.274 81.553-24.095 108.454-5.357 12.189-10.63 24.123-14.429 38.211 5.585 1.616 10.602 4.621 14.599 8.618 6.123 6.122 9.922 14.57 9.922 23.839v61.937c0 4.138-3.374 7.512-7.512 7.512h-54.059c-4.138 0-7.512-3.374-7.512-7.512 0-4.139 3.374-7.512 7.512-7.512h46.574v-54.425c0-5.131-2.126-9.836-5.527-13.238-3.401-3.374-8.079-5.5-13.21-5.5h-89.633c-5.159 0-9.836 2.098-13.237 5.5-3.402 3.401-5.5 8.107-5.5 13.238v54.425zm-292.879 15.024c-4.139 0-7.484-3.374-7.484-7.512 0-4.139 3.345-7.512 7.484-7.512h46.574v-54.425c0-5.131-2.126-9.836-5.528-13.238s-8.079-5.5-13.21-5.5h-89.632c-4.989 0-9.723 1.984-13.238 5.5-3.402 3.401-5.5 8.107-5.5 13.238v54.425h46.574c4.139 0 7.484 3.374 7.484 7.512s-3.345 7.512-7.484 7.512h-54.085c-4.139 0-7.484-3.374-7.484-7.512v-61.937c0-9.27 3.798-17.717 9.894-23.839 4.025-3.997 9.014-7.001 14.598-8.618-3.798-14.088-9.042-26.022-14.4-38.211-11.85-26.9-24.124-54.85-24.124-108.454 0-27.978 3.289-53.971 9.269-76.563 5.868-22.224 14.4-41.216 24.974-55.502v-38.778c0-9.496 3.883-18.142 10.148-24.378 6.265-6.264 14.882-10.148 24.407-10.148h20.693v-20.694c0-9.524 3.883-18.142 10.12-24.406 6.264-6.265 14.911-10.148 24.407-10.148 9.524 0 18.142 3.883 24.406 10.148 6.265 6.265 10.148 14.882 10.148 24.406v20.693h20.665c9.524 0 18.171 3.883 24.407 10.148 6.265 6.236 10.148 14.882 10.148 24.378v20.693h20.694c9.496 0 18.142 3.883 24.406 10.148 6.265 6.265 10.147 14.882 10.147 24.406 0 9.496-3.883 18.142-10.147 24.406-6.265 6.236-14.911 10.12-24.406 10.12h-20.694v20.693c0 9.496-3.883 18.142-10.148 24.407-6.236 6.264-14.882 10.148-24.407 10.148h-15.874c1.162 8.192 2.551 16.016 3.883 23.612 3.062 17.376 5.953 33.704 5.953 51.42 0 25.682-6.974 62.391-28.319 80.051v16.979c6.293 1.417 11.934 4.62 16.356 9.043 6.094 6.122 9.893 14.57 9.893 23.839v61.937c0 4.138-3.345 7.512-7.483 7.512h-54.085z" fill="#ffc600" data-original="#000000" style="" class="" />
                                                </g>
                                            </g>
                                        </svg>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="news-cont mt-30">

                                <a href="blog-single.html">
                                    <h3>Creative Lessons</h3>
                                </a>
                                <p style="text-align: justify;">Curriculum is designed to nurture creativity and innovation for all students of the School. The latest methods and
                                    techniques are adopted to prepare the curriculum as per the global standards required for the modern system of
                                    education.</p>
                            </div>
                        </div>
                    </div> <!-- row -->
                </div> <!-- single news -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>
<!--====== TEACHERS PART START ======-->

                        <h5 style="color: #07294d;
                        position: relative;
                        padding-bottom: 12px;
                        font-size: 40px; text-align: center;">Photo Gallery</h5>
<iframe src="https://curtina.in/_EazySchool/Crescent/PhotoGallery.aspx?AppId=crescent&cdn=http://curtina.in/crescent" style="height:300px; width:100%"></iframe><?php
            include('_web/footer.php');
            include('_web/scripts.php');
            ?>