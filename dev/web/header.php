<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MKK School of Excellence | Admissions Open 2026–27</title>
    <!-- SEO -->
    <meta name="description"
        content="MKK School of Excellence offers quality education, smart classrooms, experienced faculty & holistic development. Admissions Open 2026–27." />
    <meta name="keywords" content="MKK School, School of Excellence, Panipat School, CBSE School, Admissions Open" />
    <link rel="canonical" href="https://mkknew.netlify.app/" />
    <!-- FAVICON -->
    <link rel="icon" href="/assets/images/favicons/favicon.ico" />

    <!-- TAILWIND (PRODUCTION BUILD ONLY) -->
    <link rel="stylesheet" href="/output.css" />

    <!-- SWIPER CSS -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">

    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </noscript>

    <!-- FONT AWESOME (ASYNC) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        /* marquee animation */
        @keyframes marquee-x {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }

            /* move by half because we duplicate content */
        }

        .marquee-mask {
            overflow: hidden;
            position: relative;
        }

        .marquee-track {
            display: flex;
            gap: 1rem;
            /* matches Tailwind gap-4 */
            will-change: transform;
            animation: marquee-x var(--marquee-speed, 136s) linear infinite;
        }

        .marquee-track:hover {
            animation-play-state: paused;
            /* pause on hover */
        }

        /* Accessibility: respect reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .marquee-track {
                animation: none;
            }
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 18s linear infinite;
        }

        /* Hide default Swiper arrow icons */
        .swiper-button-next::after,
        .swiper-button-prev::after {
            display: none;
        }

        /* Custom round gradient arrows */
        .custom-arrow {
            width: 50px;
            height: 50px;
            border-radius: 9999px;
            background: linear-gradient(to right, #ec4899, #ef4444, #ec4899);
            border: 2px solid rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;

            /* Glow effect */
            box-shadow:
                0 0 10px rgba(236, 72, 153, 0.6),
                0 0 20px rgba(239, 68, 68, 0.4);

            transition: all 0.3s ease;
        }

        /* Icon size */
        .custom-arrow i {
            font-size: 18px;
        }

        /* Hover animation */
        .custom-arrow:hover {
            transform: scale(1.15);
            box-shadow:
                0 0 15px rgba(236, 72, 153, 0.9),
                0 0 30px rgba(239, 68, 68, 0.7);
        }

        /* Position adjustment */
        /* .swiper-button-prev {
            left: -12px;
        }

        .swiper-button-next {
            right: -12px;
        } */

        /* 🔥 Hide arrows on mobile */
        @media (max-width: 640px) {

            .swiper-button-next,
            .swiper-button-prev {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-white text-gray-800 overflow-x-hidden">
    <header class="bg-gradient-to-r from-pink-600 via-red-500 to-pink-400 text-white">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap justify-between text-sm">
            <div class="flex gap-4 flex-wrap">
                <span><i class="fa-solid fa-school"></i> School Code: 40047</span>
                <span><i class="fa-solid fa-school"></i> Affiliation No: 530027</span>
                <div class="hidden md:block">
                    <span><i class="fas fa-file-alt"></i> <a href="cbsemandate.php" class="hover:underline">Mandatory
                            Disclosure</a></span>
                    <span><i class="fa-solid fa-envelope"></i> <a href="https://mail.hostinger.com/v2/auth/login"
                            class="hover:underline">Webmail</a> </span>
                </div>
            </div>
            <div class="mt-3 md:block md:mt-0">
                <div class="flex gap-4">
                    <a href="#"><i class="fa-solid fa-arrow-up-right-from-square"></i> Apply For Job</a>
                    <a href="http://www.curtina.in/MKK?url=http://www.curtina.in/_Web/FrmfindTC.aspx"><i
                            class="fa-solid fa-magnifying-glass"></i> Search TC </a>
                </div>
            </div>
        </div>
    </header>
    <nav class="p-3 flex items-center max-w-7xl mx-auto ">
        <a href="#" id="brand" class="flex gap-2 items-center flex-1">
            <img src="./assets/images/logo.png" class="">
        </a>
        <div id="nav-menu" class="hidden lg:flex gap-12">
            <a href="" class="font-semi-bold hover:text-primary">Home</a>
            <a href="" class="font-semi-bold hover:text-primary">About</a>
            <div class="relative group">
                <button class="font-semi-bold hover:text-primary flex items-center gap-1">
                    Academic
                    <i class="fa-solid fa-chevron-down text-sm"></i>
                </button>
                <!-- Submenu -->
                <div class="absolute top-full left-0 mt-3 w-56 bg-white shadow-lg rounded-lg 
              opacity-0 invisible group-hover:opacity-300 group-hover:visible 
              transition-all duration-300 z-50">
                    <a href="#" class="block px-4 py-3 hover:bg-gray-200 rounded-t-lg">Curriculum</a>
                    <a href="#" class="block px-4 py-3 hover:bg-gray-200">Examination</a>
                    <a href="#" class="block px-4 py-3 hover:bg-gray-200">Faculty</a>
                    <a href="#" class="block px-4 py-3 hover:bg-gray-200 rounded-b-lg">Admissions</a>
                </div>
            </div>
            <a href="" class="font-semi-bold hover:text-primary">Facilities</a>
            <a href="" class="font-semi-bold hover:text-primary">Student Corner</a>
        </div>
        <div class="hidden lg:flex flex-1 justify-end">
            <button class="flex gap-2 items-center border border-gray-400 px-6 py-2 rounded-lg hover:border-gray-400">
                <span> ERP login <i class="fa-solid fa-right-to-bracket"></i>
                </span>
            </button>
        </div>
        <button class="p-2 lg:hidden" onclick="handleMenu()">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div id="nav-dialog" class="hidden fixed z-10 md:hidden bg-white inset-0 p-3">
            <div id="nav-bar" class="flex justify-between">
                <a href="#" id="brand" class="flex gap-2 items-center">
                    <img src="./assets/images/logo.png">
                </a>
                <button class="p-2 md:hidden" onclick="handleMenu()">
                    <i class="fa-solid fa-xmark text-gray-300"></i>
                </button>
            </div>
            <div class="mt-6">
                <a href="#" class="font-semi-bold m-3 p-3 hover:bg-gray-300 block rounded-lg">Home</a>
                <a href="#" class="font-semi-bold m-3 p-3 hover:bg-gray-300 block rounded-lg">About</a>
                <div class="m-3">
                    <button onclick="toggleSubmenu()"
                        class="w-full flex justify-between items-center p-3 font-semi-bold hover:bg-gray-300 rounded-lg">
                        Academic
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>

                    <!-- Mobile Submenu -->
                    <div id="mobile-submenu" class="hidden ml-4 mt-2">
                        <a href="#" class="block p-2 hover:bg-gray-200 rounded-lg">Curriculum</a>
                        <a href="#" class="block p-2 hover:bg-gray-200 rounded-lg">Examination</a>
                        <a href="#" class="block p-2 hover:bg-gray-200 rounded-lg">Faculty</a>
                        <a href="#" class="block p-2 hover:bg-gray-200 rounded-lg">Admissions</a>
                    </div>
                </div>

                <a href="#" class="font-semi-bold m-3 p-3 hover:bg-gray-200 block rounded-lg">Facilities</a>
                <a href="#" class="font-semi-bold m-3 p-3 hover:bg-gray-200 block rounded-lg">Student Corner</a>
            </div>
            <div class="h-[1px] bg-gray-100"></div>
            <button class=" mt-6 flex w-full md:flex gap-2 items-center  px-6 py-4 rounded-lg hover:bg-gray-50">
                <a href="#"
                    class="inline-flex items-center gap-2 mt-8 bg-gradient-to-r from-indigo-600 via-blue-500 to-blue-400 hover:bg-pink-700 text-white px-6 py-3 rounded font-medium transition">
                    ERP Login →
                </a>
            </button>
        </div>
    </nav>