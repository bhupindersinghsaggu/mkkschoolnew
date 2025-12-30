<section id="footer" class=" px-4 py-8 md:px-12  lg:py-16 bg-black">
    <div class="grid grid-cols-1  gap-8 lg:grid-cols-4 md:grid-cols-2 py-4 max-w-7xl mx-auto">
        <div id="logo-section">
            <h3 class="text-3xl  text-yellow-400 mb-4">Happy Birthday</h3>
            <iframe
                src="https://curtina.in/_EazySchool/Formsweb/StudBday_STM.aspx?AppId=MKK&cdn=http://curtina.in/MKK"
                style="height:370px; width:100% ;border:none; margin-left: -30px;"></iframe>
        </div>
        <div id="Quick-Links" class="">
            <div class="">
                <h3 class="text-3xl  text-yellow-400 mb-4">Quick Links</h3>
                <ul class="text-white leading-10">
                    <li>
                        <a href="https://www.curtina.in/_Web/FrmfindTC.aspx">
                            <i class="fa-regular fa-paper-plane text-gray-500 pr-2"></i> SLC Download
                        </a>
                    </li>
                    <li>
                        <a href="download_app.php">
                            <i class="fa-regular fa-paper-plane text-gray-500 pr-2"></i> Download APP
                        </a>
                    </li>
                    <li>
                        <a href="https://curtina.in/_mobile/login.aspx?AppId=MKK">
                            <i class="fa-regular fa-paper-plane text-gray-500 pr-2"></i> ERP Login
                        </a>
                    </li>
                    <li>
                        <a href="booklist.php">
                            <i class="fa-regular fa-paper-plane text-gray-500 pr-2"></i> Book List
                        </a>
                    </li>
                    <li>
                        <a href="/assets/images/fee-structure/fee-structure-2024-25.pdf">
                            <i class="fa-regular fa-paper-plane text-gray-500 pr-2"></i> Fee Structure
                        </a>
                    </li>
                    <li>
                        <a href="applyonline.php">
                            <i class="fa-regular fa-paper-plane text-gray-500 pr-2"></i> Admission Online
                        </a>
                    </li>
                    <li>
                        <a href="privacy_policy.php">
                            <i class="fa-regular fa-paper-plane text-gray-500 pr-2"></i> Privacy Policy
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="Locate-us" class="">
            <div class="">
                <h3 class="text-3xl  text-yellow-400 mb-4">Address</h3>
                <ul class="text-white leading-10">
                    <li>
                        <a href="#">
                            <i class="fa-regular fa-paper-plane text-gray-500 pr-2"></i>Ram Lal Chowk, Model Town,
                            Panipat (Haryana) - 132103.

                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa-regular fa-paper-plane text-gray-500 pr-2"></i> 0180-4013047, 4004556
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa-regular fa-paper-plane text-gray-500 pr-2"></i>info@mkkschool.com
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="google-map" class="">
            <div class="">
                <h3 class="text-3xl  text-yellow-400 mb-4">Locate us</h3>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3380.1589881999466!2d76.56482841554113!3d32.09198848118435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3904b14b77f63b8f%3A0xf7f80654e688c8d5!2sCrescent%20public%20school!5e0!3m2!1sen!2sin!4v1610038540720!5m2!1sen!2sin"
                    width="250" height="200" frameborder="0" style="border:0;" allowfullscreen=""
                    aria-hidden="false" tabindex="0"></iframe>"
            </div>
        </div>
    </div>
</section>
<!-- Copyright section-->
<section id="copy-right" class="max-w-7xl mx-auto flex items-center px-2 py-2">
    <div>
        <p class="px-3 py-3">Copyright Dr. M.K.K. Arya Model School Site created by IT Department</p>
    </div>
</section>
<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Swiper(".achievementsSwiper", {
            loop: true,
            spaceBetween: 20,

            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },

            pagination: {
                el: ".achievementsSwiper .swiper-pagination",
                clickable: true,
            },

            navigation: {
                nextEl: ".achievementsSwiper .swiper-button-next",
                prevEl: ".achievementsSwiper .swiper-button-prev",
            },

            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                640: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                },
            },
        });
    });
</script>

<script src="./scripts.js" defer></script>
<script>
    document.getElementById('whatsappForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Replace with your WhatsApp number
        const phoneNumber = "919034252500";
        const name = document.getElementById("name").value;
        const phone = document.getElementById("phone").value;
        const message = document.getElementById("message").value;
        const classes = document.getElementById("classes").value;
        const source = document.getElementById("source").value;
        const text = `Hello, my name is: ${name}
          Phone: ${phone}
		  Inquiry About: ${classes} 
		  Message: ${message} 
		  Source of Information: ${source}`;
        const url = `https://wa.me/${phoneNumber}?text=${text}`;
        window.open(url, 'index.php');
    });
</script>
</body>
</html>