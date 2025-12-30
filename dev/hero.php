<section id="hero" class="bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-400 px-6  md:px-6 py-12">
    <div id="hero-container" class="max-w-7xl mx-auto ">
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Left Section -->
            <div class="flex-1">
                <div id="version-text"
                    class="flex items-center my-6 gap-2 border border-yellow-300 bg-yellow-50 rounded-lg px-3 py-1 w-fit shadow-lg hover:translate-y-1 transition group">
                    <div class="w-2 h-2 bg-yellow-400 rounded-full border border-yellow-600"></div>
                    <p class="text-yellow-600">
                        Smart Classrooms <span class="text-yellow-800">| Safe Campus</span>
                        <i
                            class="fa-solid fa-arrow-right text-yellow-600 group-hover:translate-x-1 transition duration-300"></i>
                    </p>
                </div>
                <h1 class="text-4xl font-semibold mt-4 sm:text-6xl text-white lg:leading-18">
                    Shaping Young Minds for a <span class="text-yellow-300">Brighter Tomorrow</span>
                </h1>
                <p class="text-xl text-gray-100 mt-4 leading-relaxed sm:text-xl sm:mt-8">
                    At MKK, we nurture curiosity, creativity, and confidence through quality
                    education, experienced faculty, and a safe learning environment. Give your child the foundation
                    they deserve.
                </p>
                <div id="botton-container" class="mt-12 flex flex-col sm:flex-row gap-4  ">
                    <button
                        class="px-8 py-3 font-semibold text-xl  hover:translate-y-1 transition group  bg-yellow-50  border border-emerald-400 rounded-lg shadow-sm hover:bg-opacity-90">
                        Admission Open <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <button
                        class="px-8 py-3 font-semibold text-xl rounded-lg text-white  border border-white shadow-sm hover:bg-opacity-90">
                        Call Now <i class="fa-solid fa-phone"></i>
                    </button>
                </div>
            </div>
            <!-- Right Section -->
            <style>
                @keyframes spinSlow {
                    from {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(360deg);
                    }
                }

                .spin-slow {
                    animation: spinSlow 16s linear infinite;
                }
            </style>
            <div class="flex-1 hidden lg:flex justify-center items-center relative">
                <!-- Dotted Circle -->
                <div
                    class="absolute w-[500px] h-[500px] rounded-full border-4 border-dashed border-white/80 spin-slow z-40">
                </div>
                <!-- Image -->
                <img src="./assets/images/hero.webp"alt="Students at MKK School" class="relative z-10 object-cover rounded-full shadow-lg">
            </div>
        </div>
    </div>
</section>