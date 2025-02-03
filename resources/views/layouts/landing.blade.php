<!DOCTYPE html>
<html lang="vi" class="overflow-x-hidden">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Nhúng các thư viện và tài nguyên -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/solid.min.css">
    <script src="{{ asset('js/tiny.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="{{ asset('js/tailwind.js') }}"></script>
    <!-- Bắt đầu - Thư viện hỗ trợ giao diện đẹp mắt cho selection -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <!-- Kết thúc - Thư viện hỗ trợ giao diện đẹp mắt cho selection -->
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Js cho tailwind-->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!--HTMX -->
    <script src="https://unpkg.com/htmx.org"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</head>

<body class="bg-gray-100 overflow-x-hidden">
    <header id='home' class="body-font" style="background-color: #D35400;"> <!-- Màu cam đất sang trọng -->
        <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
            <a class="flex title-font font-medium items-center text-white mb-4 md:mb-0">
                {{-- <span class="ml-3 text-2xl font-serif">
                    Là Cafe
                </span>  --}}
                <img src="{{ asset('asset/local/logo_la.svg') }}" alt="" class="ml-3 text-2xl font-serif w-12">
            </a>
            <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center md:flex">
                <a href="#story" class="mr-5 text-white hover:underline">Câu chuyện</a>
                <a href="#picture" class="mr-5 text-white hover:underline">Hình ảnh</a>
                {{-- <a href="#reviews" class="mr-5 text-white hover:underline">Đánh giá</a>
                <a href="#news" class="mr-5 text-white hover:underline">Tin tức</a> --}}
                <a href="#contact" class="mr-5 text-white hover:underline">Liên hệ</a>
            </nav>
        </div>
    </header>


    <!-- Main Content -->
    <main class="container mx-auto mt-0">
        @if (session('status'))
            <div x-data="{ open: true }" x-init="setTimeout(() => open = false, 1000)" x-show="open" @click.away="open = false"
                class="fixed inset-0 flex items-center justify-center z-50 p-4 sm:p-8 bg-black bg-opacity-50">
                <div
                    class="bg-white dark:bg-gray-900 transform transition-transform ease-in-out duration-500 w-full sm:max-w-2xl rounded-lg shadow-2xl overflow-hidden">
                    <div class="relative group flex items-center justify-start p-6 space-x-4">
                        <!-- Animated bell icon -->
                        <div class="flex-none w-16 h-16 bg-indigo-500 rounded-full group-hover:animate-bounce">
                            <svg class="w-10 h-10 text-white mx-auto mt-3" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 003 14h14a1 1 0 00.707-1.707L17 11.586V8a6 6 0 00-6-6zm0 18a3 3 0 003-3H7a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300">{{ session('status') }}
                            </h3>
                        </div>
                        <button @click="open = false"
                            class="absolute top-4 right-4 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <svg class="w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>


    <!-- footer -->
    <div class="container mx-auto p-6 mb-8" id="contact">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0">
                <h2 class="text-2xl font-bold text-gray-800">Liên hệ với Là Cafe</h2>
                <p class="text-gray-600 mt-2">
                    <strong>Địa chỉ:</strong>
                    122/6 Mạc Thiên Tích, Phường Xuân Khánh, Quận Ninh Kiều, TP Cần Thơ</p>
                <p class="text-gray-600">
                    <strong>SDT:</strong>  097 766 66 47
                    <strong>Facebook:</strong> <a href="https://www.facebook.com/LaCafe.2020" target="_blank" class="text-gray-600 hover:text-blue-800">
                        <i class="fab fa-facebook-square fa-2x"></i>
                    </a>
                </p>
                
            </div>
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="nav-toggle" class="md:hidden fixed z-50  text-red-500 max-w-lg rounded-full -bottom-4 -right-6">
            <i class="fa-solid fa-eye h-20 w-20"></i>
    </button>
    
    <!-- bottom nav -->
    <div id="bottom-nav"
        class="md:hidden fixed z-50 w-full h-16 max-w-lg -translate-x-1/2 bg-white border border-gray-200 rounded-full bottom-4 left-1/2 dark:bg-gray-700 dark:border-gray-600">
        <div class="grid h-full max-w-lg grid-cols-5 mx-auto">
            <button data-tooltip-target="tooltip-home" type="button"
                class="inline-flex flex-col items-center justify-center px-5 rounded-s-full hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <a class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" href='#home'>
                    <i class="fa-solid fa-house"></i>
                </a>
                <span class="sr-only">Home</span>
            </button>
            <div id="tooltip-home" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Home
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button data-tooltip-target="tooltip-wallet" type="button"
                class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <a class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" href='#story'>
                    <i class="fa-solid fa-book-open-reader"></i>
                </a>
                <span class="sr-only">Câu chuyện</span>
            </button>
            <div id="tooltip-wallet" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Câu chuyện
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div class="flex items-center justify-center">
                <button data-tooltip-target="tooltip-new" type="button"
                    class="inline-flex items-center justify-center w-10 h-10 font-medium bg-blue-600 rounded-full hover:bg-blue-700 group focus:ring-4 focus:ring-blue-300 focus:outline-none dark:focus:ring-blue-800">
                    <a class="w-5 h-5 mb-1 text-white group-hover:text-gray-500" id='open-menu-link'>
                        <i class="fa-solid fa-eye-slash"></i>
                    </a>
                    <span class="sr-only">Menu</span>
                </button>
            </div>
            <div id="tooltip-new" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Menu
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button data-tooltip-target="tooltip-settings" type="button"
                class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <a class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" href='#accordion-open'>
                    <i class="fa-solid fa-question"></i>
                </a>
                <span class="sr-only">Câu hỏi</span>
            </button>
            <div id="tooltip-settings" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Câu hỏi
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button data-tooltip-target="tooltip-profile" type="button"
                class="inline-flex flex-col items-center justify-center px-5 rounded-e-full hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <a class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" href='#picture'>
                    <i class="fa-solid fa-image"></i>
                </a>
                <span class="sr-only">Profile</span>
            </button>
            <div id="tooltip-profile" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Profile
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('nav-toggle').addEventListener('click', function() {
            document.getElementById('bottom-nav').classList.toggle('hidden');
        });
        
        document.getElementById('open-menu-link').addEventListener('click', function() {
            document.getElementById('bottom-nav').classList.toggle('hidden');
        });
    </script>
</body>

</html>
