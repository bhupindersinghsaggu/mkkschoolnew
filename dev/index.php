<?php include('./web/header.php') ?>
<!-- Hero section -->
<?php include('./hero.php')?>

<div class="overflow-hidden bg-sky-50 py-6">
    <div class="flex w-max animate-marquee gap-16">
        <span class="flex items-center gap-4 text-2xl md:text-5xl font-semibold">
            <i class="fa-solid fa-graduation-cap text-red-600"></i> Admission Open: 2026-27
            <i class="fa-solid fa-graduation-cap text-red-600"></i> Admission Open: 2026-27
            <i class="fa-solid fa-graduation-cap text-red-600"></i> Admission Open: 2026-27
            <i class="fa-solid fa-graduation-cap text-red-600"></i> Admission Open: 2026-27
            <i class="fa-solid fa-graduation-cap text-red-600"></i> Admission Open: 2026-27
            <i class="fa-solid fa-graduation-cap text-red-600"></i> Admission Open: 2026-27
            <i class="fa-solid fa-graduation-cap text-red-600"></i> Admission Open: 2026-27
        </span>
    </div>
</div>
<!-- about-school -->
<section id="about-school" class="flex flex-col gap-6 max-w-7xl mx-auto px-4 py-8 md:px-12  lg:py-16 ">
    <div class="max-w-7xl mx-auto ">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl lg:text-4xl font-semibold leading-tight">
                    Dr. M.K.K. Arya Model School
                </h2>
                <!-- <p class="mt-6 text-xl font-medium">
                        Learn. Explore. Achieve.
                    </p> -->
                <p class="mt-6 text-gray-600 leading-relaxed max-w-xl">
                    Dr. M.K.K. Arya Model School has emerged as one of the premier Educational Institutions in
                    Panipat. The school is a Mascot for developing and inculcating the minds of the young students
                    towards their future careers and with a positive outlook. Our motto “One Team One Goal” has
                    renowned the institution as a guiding force in every student's life. Every year the school is
                    delivering outstanding results with a professional growth for every student by virtue of giving
                    a broader platform with an exposure to explore their forte.our mission is always to provide a
                    value based education with professional training to our students through immaculately designed
                    curriculum.
                </p>
                <a href="#"
                    class="inline-flex items-center gap-2 mt-8 bg-gradient-to-r from-indigo-600 via-blue-500 to-blue-400 hover:bg-pink-700 text-white px-6 py-3 rounded font-medium transition">
                    More About Us →
                </a>
            </div>
            <div>
                <div class="">
                    <img src="./assets/images/about-us.webp" loading="lazy" decoding="async" width="600"
                        height="400" alt="About School">

                </div>
            </div>
        </div>
    </div>
</section>
<!--  Facilities -->
<?php include('./facilities.php')?>
<!--  admission-open -->
<section id="admission-open"
    class="bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-400 px-4 py-8 md:px-12  lg:py-16">
    <div class="max-w-7xl mx-auto ">
        <h2 class="text-2xl  py-4 md:py-8 mb-4  md:text-5xl font-semibold leading-tight text-center">
            <span class="text-gray-800 mb-3 mt-3 text-3xl lg:text-5xl"> Admission Open For<span
                    class="text-gray-800"> 2026-27</span>
        </h2>
        <div class="grid grid-cols-1 gap-3 lg:grid-cols-2   overflow-hidden">
            <!-- Left Image -->
            <div class="hidden lg:block border-r-accent">
                <img src="./assets/images/admission.webp" alt="Counsellor"
                    class="max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl xl:max-w-3xl rounded-lg">
            </div>
            <!-- Right Form -->
            <div class="text-white">
                <h3 class="text-white mb-6  text-2xl font-semibold  lg:text-4xl"> Talk To Our <span
                        class="text-white"> Counsellor </span></h3>
                <form class="grid grid-cols-1 gap-6" id="whatsappForm">
                    <input type="text" placeholder="Name" id="name"
                        class="bg-transparent border border-white/100 px-4 py-3 rounded focus:outline-none focus:border-white" />
                    <input type="tel" placeholder="Phone*" id="phone"
                        class="bg-transparent border border-white/100 px-4 py-3 rounded focus:outline-none focus:border-white" />
                    <select id="classes"
                        class="bg-transparent border border-white/100 px-4 py-3 rounded focus:outline-none focus:border-white text-white">
                        <option class="text-black">Select Class</option>
                        <option class="text-black">Pre-Nur</option>
                        <option class="text-black">Nursery</option>
                        <option class="text-black">LKG</option>
                        <option class="text-black">UKG</option>
                        <option class="text-black">Class I</option>
                        <option class="text-black">Class II</option>
                        <option class="text-black">Class III</option>
                        <option class="text-black">Class IV</option>
                        <option class="text-black">Class V</option>
                        <option class="text-black">Class VI</option>
                        <option class="text-black">Class VII</option>
                        <option class="text-black">Class VIII</option>
                        <option class="text-black">Class IX</option>
                        <option class="text-black">Class XI</option>
                    </select>
                    <select id="source"
                        class="bg-transparent border border-white/100 px-4 py-3 rounded focus:outline-none focus:border-white text-white">
                        <option class="text-black">Select Source of Information</option>
                        <option class="text-black">Google</option>
                        <option class="text-black">Social Media</option>
                        <option class="text-black">Website</option>
                        <option class="text-black">Hoarding</option>
                        <option class="text-black">Word of Mouth</option>
                    </select>
                    <textarea rows="5" placeholder="Write your message*" id="message"
                        class="bg-transparent border border-white/100 px-4 py-3 rounded focus:outline-none focus:border-gray-300"></textarea>
                    <button type="submit"
                        class="border border-white transition px-8 py-3 rounded font-semibold w-fit">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
<!--  School Achievements -->
<section class="max-w-7xl mx-auto px-4 py-8 md:px-12  lg:py-16">
    <h2 class="text-center mb-10">
        <span class="px-4 py-2 inline-block text-3xl lg:text-5xl font-semibold">
            School Achievements
        </span>
    </h2>
    <!-- Swiper -->
    <div class="swiper achievementsSwiper">
        <div class="swiper-wrapper">
            <!-- Slide -->
            <div class="swiper-slide p-4">
                <div class="bg-white shadow rounded overflow-hidden">
                    <img src="/assets/images/news/1.webp" class="swiper-lazy w-full" width="400" height="300"
                        alt="dr.m.k.k school" />

                    <div class="p-4 mt-3">
                        Silver Medal at Haryana Open Kids Athletics Championship
                    </div>

                    <div class="flex justify-between items-center p-4 text-sm">
                        <span>
                            <i class="fas fa-calendar-alt text-red-500"></i> 15, Dec
                        </span>
                        <a href="https://www.facebook.com/share/p/1FozefPs9w/" target="_blank"
                            class="border border-blue-400 px-6 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition">
                            View More
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide -->
            <div class="swiper-slide p-4">
                <div class="bg-white shadow rounded overflow-hidden">
                    <img src="/assets/images/news/2.webp" class="swiper-lazy w-full" width="400" height="300"
                        alt="dr.m.k.k school" />

                    <div class="p-4 mt-3">
                        Achievement at Divisional Level Dance Competition!
                    </div>

                    <div class="flex justify-between items-center p-4 text-sm">
                        <span>
                            <i class="fas fa-calendar-alt text-red-500"></i> 4, Dec
                        </span>
                        <a href="https://www.facebook.com/share/p/1DCzvD1wKg/" target="_blank"
                            class="border border-blue-400 px-6 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition">
                            View More
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide -->
            <div class="swiper-slide p-4">
                <div class="bg-white shadow rounded overflow-hidden">
                    <img src="/assets/images/news/3.webp" class="swiper-lazy w-full" width="400" height="300"
                        alt="dr.m.k.k school" />

                    <div class="p-4 mt-3">
                        Students once again made us proud at PIET Quest 2025
                    </div>

                    <div class="flex justify-between items-center p-4 text-sm">
                        <span>
                            <i class="fas fa-calendar-alt text-red-500"></i> 12, Nov
                        </span>
                        <a href="https://www.facebook.com/story.php?story_fbid=1316459530493521&id=100063884590594&rdid=HKIk0O7UpbtdGGwt#"
                            class="border border-blue-400 px-6 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition">
                            View More
                        </a>
                    </div>
                </div>
            </div>
            <!-- Slide -->
            <div class="swiper-slide p-4">
                <div class="bg-white shadow rounded overflow-hidden">
                    <img src="/assets/images/news/7.webp" class="swiper-lazy w-full" width="400" height="300"
                        alt="dr.m.k.k school" />

                    <div class="p-4 mt-3">
                        Twelve talented girls from Dr. M.K.K. Arya Model School, Panipat won the Third Position in
                        Group 3 at the District Level Group Singing Competition held at Bal Bhawan, Panipat
                    </div>

                    <div class="flex justify-between items-center p-4 text-sm">
                        <span>
                            <i class="fas fa-calendar-alt text-red-500"></i> 16, Oct
                        </span>
                        <a href="https://www.facebook.com/story.php?story_fbid=1291842539621887&id=100063884590594&rdid=I5Z0HVVutdFCFYXz#"
                            class="border border-blue-400 px-6 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition">
                            View More
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination Dots -->
        <!-- <div class="swiper-pagination"></div> -->
        <!-- Arrows -->
        <div class="swiper-button-prev custom-arrow">
            <i class="fa-solid fa-chevron-left"></i>
        </div>
        <div class="swiper-button-next custom-arrow">
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </div>
</section>
<!--  Student-Corner -->
<div id="student-corner" class="flex flex-col gap-6  max-w-7xl mx-auto px-4 py-8 md:px-12  lg:py-16">
    <div class="">
        <h2 class="text-center font-semibold leading-tight py-8">
            <span class="inline-block  text-3xl md:text-5xl relative ">Student Corner
        </h2>
        <div class="grid grid-cols-1  gap-8 lg:grid-cols-4 md:grid-cols-2 py-4" id="product-card">
            <div id="product"
                class="rounded-lg border border-gray-200 bg-gradient-to-bl from-purple-700 via-indigo-600 to-blue-500 ">
                <div class="flex flex-col items-center py-8 px-8 lg:flex-col">
                    <div class="">
                        <div
                            class="text-center w-[108px] h-[108px] rounded-full bg-[#F3F6FF] mx-auto flex items-center justify-center">
                            <i class="fab fa-android icon-home text-5xl text-blue-600"></i>
                        </div>
                    </div>
                    <div>
                        <div class="py-4 px-4 text-center">
                            <h3 class="text-xl font text-white ">
                                School APP
                            </h3>
                        </div>
                        <div class="px-4 py-4 text-center">
                            <a href="#"
                                class="inline-flex items-center gap-2  border border-blue-400 text-white hover:bg-blue-500 hover:text-white transition  px-6 py-3 rounded font-medium ">
                                Click Here
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="product"
                class="rounded-lg border border-gray-200 bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-400">
                <div class="flex flex-col items-center py-8 px-8 lg:flex-col">
                    <div class="">
                        <div
                            class="text-center w-[108px] h-[108px] rounded-full bg-[#F3F6FF] mx-auto flex items-center justify-center">
                            <i class="fas fa-file-alt icon-home text-5xl text-blue-600"></i>
                        </div>
                    </div>
                    <div>
                        <div class="py-4 px-2 text-center">
                            <h3 class="text-xl font text-white ">
                                E-News Letter
                            </h3>
                        </div>
                        <div class="px-4 py-4 text-center">
                            <a href="e-news-letter.php"
                                class="inline-flex items-center gap-2 bg:white border border-white text-white hover:bg-emerald-400 hover:text-white transition  px-6 py-3 rounded font-medium ">
                                Click Here
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="product"
                class="rounded-lg border border-gray-200 bg-gradient-to-bl from-purple-700 via-indigo-600 to-blue-500 ">
                <div class="flex flex-col items-center py-8 px-8 lg:flex-col">
                    <div class="">
                        <div
                            class="text-center w-[108px] h-[108px] rounded-full bg-[#F3F6FF] mx-auto flex items-center justify-center">
                            <i class="fas fa-book icon-home text-5xl text-blue-600"></i>
                        </div>
                    </div>
                    <div>
                        <div class="py-4 px-4 text-center">
                            <h3 class="text-xl font text-white ">
                                Book List
                            </h3>
                        </div>
                        <div class="px-4 py-4 text-center">
                            <a href="#"
                                class="inline-flex items-center gap-2  border border-white text-white hover:bg-blue-500 hover:text-white transition  px-6 py-3 rounded font-medium ">
                                Click Here
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="product"
                class="rounded-lg border border-gray-200 bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-400">
                <div class="flex flex-col items-center py-8 px-8 lg:flex-col">
                    <div class="">
                        <div
                            class="text-center w-[108px] h-[108px] rounded-full bg-[#F3F6FF] mx-auto flex items-center justify-center">
                            <i class="fas fa-stream icon-home text-5xl text-blue-600"></i>
                        </div>
                    </div>
                    <div>
                        <div class="py-4 px-4 text-center">
                            <h3 class="text-xl font text-white ">
                                List of Holidays
                            </h3>
                        </div>
                        <div class="px-4 py-4 text-center">
                            <a href="list-of-holidays.php"
                                class="inline-flex items-center gap-2 bg:white border border-white text-white hover:bg-emerald-400 hover:text-white transition  px-6 py-3 rounded font-medium ">
                                Click Here
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div id="Video-Gallery"
        class="flex flex-col gap-6   px-6 py-12 mx-auto bg-gradient-to-r from-blue-900 via-blue-700 to-blue-800 ">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-center font-semibold leading-tight py-8">
                <span class="inline-block text-white text-3xl md:text-5xl relative ">
                    Video Gallery
                </span>
            </h2>
            <div class="grid grid-cols-1  gap-4 lg:grid-cols-3 md:grid-cols-2 py-4" id="product-card">
                <div id="product" class="rounded-lg border border-gray-200">
                    <div class="">
                        <iframe width="400" height="315" class="px-4 py-4 "
                            src="https://www.youtube.com/embed/epdBMnc1sqw?si=6eRGrykwsnFwFrkQ"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
                <div id="product" class="rounded-lg border border-gray-200">
                    <div class="">
                        <iframe width="400" height="315" class="px-4 py-4 "
                            src="https://www.youtube.com/embed/00e8uRTVi5s?si=VvCtfi8bbRxGK45c"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
                <div id="product" class="rounded-lg border border-gray-200">
                    <div class="">
                        <iframe width="400" height="315" class="px-4 py-4 "
                            src="https://www.youtube.com/embed/EOUY0ePUwD4?si=qqTLWVqB7ntTaENt"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="px-4 py-4 text-center">
                    <a href="list-of-holidays.php"
                        class="inline-flex items-center gap-2  border border-blue-400 text-white hover:bg-blue-500 hover:text-white transition  px-6 py-3 rounded font-medium ">
                        Click Here
                    </a>
                </div>
            </div>
        </div>
    </div> -->
<?php include('./web/footer.php') ?>