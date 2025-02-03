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
    <link rel="icon" href="https://pokestore.info.vn/asset/local/dark_logo.svg" type="image/svg+xml">
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

</head>

<body class="bg-gray-100 overflow-x-hidden">
    <!-- Header -->
    <header class=" w-full z-50 bg-gray-100 p-4 shadow-md ">
        <div class="container mx-auto flex justify-between items-center">

            <!-- Logo -->
            <a href="{{ route('store_front') }}" class="text-2xl font-bold text-gray-700 w-28">
                {{-- Vision.vn --}}
                <img src="{{ asset('asset/local/dark_logo.svg') }}" alt="">
            </a>

            <!-- Hamburger Button (only shown on small screens) -->
            <button id="hamburger-btn"
                class="md:hidden flex items-center px-3 py-2 border rounded text-gray-700 border-gray-400 hover:text-gray-800 hover:border-gray-700">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Middle Links -->
            <div class="hidden md:flex space-x-4 relative">
                {{-- <button class="text-gray-700 hover:underline"
                    onmouseover="showMenu(document.getElementById('menu_danhmuc'))"
                    onmouseleave="hideMenu(document.getElementById('menu_danhmuc'))"
                    >
                    Danh mục
                    @php
                        $categories = App\Models\Category::where('status', 'show')->get();
                    @endphp
                    <div id="menu_danhmuc"
                        class="hidden absolute mt-8 w-56 right-0 top-0 z-10 bg-white border border-gray-300 rounded shadow-lg py-2">
                        @foreach ($categories as $item)
                            <a href="{{ route('product_filter', ['category' => $item->id]) }}"
                                class="block px-4 py-2 hover:bg-gray-100">{{ $item->name }}</a>
                        @endforeach
                    </div>
                </button> --}}
                <button class="text-gray-700 hover:underline relative"
                    onmouseover="showMenu(document.getElementById('menu_danhmuc'))"
                    onmouseleave="hideMenu(document.getElementById('menu_danhmuc'))">
                    Danh mục
                    @php
                        $categories = App\Models\Category::where('status', 'show')->get();
                    @endphp
                    <div id="menu_danhmuc"
                        class="hidden absolute mt-0 w-56 left-1/2 transform -translate-x-1/2 top-full z-20 bg-white border border-gray-300 rounded shadow-lg py-2">
                        @foreach ($categories as $item)
                            <a href="{{ route('product_filter', ['category' => $item->id]) }}"
                                class="block px-4 py-2 hover:bg-gray-100">{{ $item->name }}</a>
                        @endforeach
                    </div>
                </button>

                <button class="text-gray-700 hover:underline relative"
                    onmouseover="showMenu(document.getElementById('menu_gioitinh'))"
                    onmouseleave="hideMenu(document.getElementById('menu_gioitinh'))">
                    Giới tính
                    <div id="menu_gioitinh"
                        class="hidden absolute mt-0 w-56 left-1/2 transform -translate-x-1/2 top-full z-10 bg-white border border-gray-300 rounded shadow-lg py-2">
                        <a href="{{ route('product_filter', ['sex' => 'male']) }}"
                            class="block px-4 py-2 hover:bg-gray-100">Nam</a>
                        <a href="{{ route('product_filter', ['sex' => 'female']) }}"
                            class="block px-4 py-2 hover:bg-gray-100">Nữ</a>
                        <a href="{{ route('product_filter', ['sex' => 'unisex']) }}"
                            class="block px-4 py-2 hover:bg-gray-100">Unisex</a>
                    </div>
                </button>

                <a href="{{ route('product_filter') }}" class="text-gray-700 hover:underline">Lọc sản phẩm</a>
                <a href="{{ route('page_user', 5) }}" class="text-gray-700 hover:underline">Chính sách</a>
            </div>

            <!-- Right Links & Actions -->
            <div class="flex items-center space-x-4 relative">
                @guest('customer')
                    <a href="{{ route('customer_login') }}" class="text-gray-600 hover:underline">Đăng nhập</a>
                    <a href="{{ route('customer_register') }}" class="text-gray-600 hover:underline">Đăng ký</a>
                @endguest

                @auth('customer')
                    <!-- Dropdown Trigger -->
                    <div class="flex items-center cursor-pointer hover:underline"
                        onclick="toggleMenu(document.getElementById('menu'), this)">
                        <span>{{ Auth::guard('customer')->user()->name }}</span>
                        <!--<i class="ml-2 fas fa-chevron-down"></i>-->
                    </div>

                    <!-- Dropdown Menu -->
                    <div id="menu"
                        class="hidden absolute mt-8 w-56 left-0 top-0 z-10 bg-white border border-gray-300 rounded shadow-lg py-2">
                        <a href="{{ route('profile_customer_edit') }}" class="block px-4 py-2 hover:bg-gray-100">Thông
                            tin</a>
                        <a href="{{ route('order_history') }}" class="block px-4 py-2 hover:bg-gray-100">Lịch sử mua</a>
                        <a href="{{ route('customer_logout') }}" class="block px-4 py-2 hover:bg-gray-100">Đăng xuất</a>
                    </div>
                @endauth

                <!-- Search -->
                <form class="relative group" action="{{ route('product_filter') }}" method="GET">
                    <!-- Input field (hidden by default on mobile) -->
                    <input type="text" id="search-input" placeholder="Tìm kiếm sản phẩm" name="keyword"
                        class="border rounded px-3 py-2 text-gray-600 focus:outline-none focus:border-blue-400 md:block hidden w-full"
                        onkeyup="submitOnEnter(event)">

                    <!-- Search icon -->
                    <span id="search-icon"
                        class="absolute -right-2 -bottom-3 md:right-2 md:top-3 text-gray-500 cursor-pointer ">
                        <i class="fas fa-search"></i>
                    </span>
                </form>

                <!-- Cart -->
                <a href="{{ route('cart_show') }}" id="cart_hover"
                    class="relative group p-2 rounded-lg hover:bg-gray-100 transition-all">
                    <!-- Cart icon -->
                    <i class="fa-solid mt-3 fa-cart-flatbed-suitcase h-6 w-6 inline-block"></i>

                    <!-- Number of products -->
                    @auth('customer')
                        <span id="total_cart_show_quantity"
                            class="absolute top-2 right-0 h-6 w-6 bg-red-500 text-white text-xs rounded-full flex items-center justify-center transform translate-x-[-50%] translate-y-[-50%]">
                            {{ Auth::guard('customer')->user()->cart->total_item }}
                        </span>

                        <!-- Hover effect: Show cart details -->
                        <div id="menu_showbar"
                            class="dropdown-menu absolute right-0 mt-2 w-64 bg-white border border-gray-300 rounded shadow-lg py-2 hidden transition-opacity z-10 max-h-[300px] overflow-y-auto">
                            <!-- Single product in the cart -->
                            @foreach (Auth::guard('customer')->user()->cart->cart_items as $item)
                                <div class=" flex justify-between items-center hover:bg-gray-100 border border-cyan-200">
                                    <div class="flex items-center space-x-2 ">
                                        <img src="{{ asset('asset/all_pic/') }}/{{ $item->colorversionsize->color_version_image->image }}"
                                            class="h-10 w-10 object-cover rounded">
                                        <span>
                                            {{ $item->colorversionsize->color_version_image->version->product->name }}
                                            bản {{ $item->colorversionsize->color_version_image->version->name }}
                                            size {{ $item->colorversionsize->size->name }}
                                        </span>
                                    </div>
                                    <span class="font-semibold">{{ $item->quantity }} x {{ number_format($item->price) }}
                                        vnd</span>
                                </div>
                            @endforeach
                            <!-- Cart total -->
                            <div class="px-4 py-2 border-t border-gray-300 mt-2">
                                <div class="flex justify-between">
                                    <span>Tổng cộng:</span>
                                    <span
                                        class="font-semibold">{{ number_format(Auth::guard('customer')->user()->cart->total_price) }}
                                        vnd</span>
                                </div>
                            </div>
                        </div>
                    @endauth

                </a>
            </div>

        </div>
    </header>

    <!-- Middle Links Modal -->
    <div id="middle-links-modal"
        class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-60 z-50 flex justify-center items-center transition-opacity duration-500 ease-in-out hidden">
        <div
            class="transform scale-95 transition-transform duration-500 ease-in-out bg-white rounded-lg p-6 w-11/12 md:w-7/12 lg:w-5/12 space-y-5 shadow-2xl border border-gray-200">
            <!-- Links -->
            <div class="space-y-5">
                <button
                    class="block text-center font-semibold text-gray-800 hover:text-gray-900 transition-colors duration-300 relative w-full"
                    onclick="toggleMenu(document.getElementById('menu_danhmuc_mobile'))"
                    >
                    Danh mục
                    @php
                        $categories = App\Models\Category::where('status', 'show')->get();
                    @endphp
                    <div id="menu_danhmuc_mobile"
                        class="hidden absolute mt-0 w-56 left-1/2 transform -translate-x-1/2 top-full z-20 bg-white border border-gray-300 rounded shadow-lg py-2">
                        @foreach ($categories as $item)
                            <a href="{{ route('product_filter', ['category' => $item->id]) }}"
                                class="block px-4 py-2 hover:bg-gray-100">{{ $item->name }}</a>
                        @endforeach
                    </div>
                </button>
                <button class="block text-center font-semibold text-gray-800 hover:text-gray-900 transition-colors duration-300 relative w-full"
                    onclick="toggleMenu(document.getElementById('menu_gioitinh_mobile'))"
                    >
                    Giới tính
                    <div id="menu_gioitinh_mobile"
                        class="hidden absolute mt-0 w-56 left-1/2 transform -translate-x-1/2 top-full z-10 bg-white border border-gray-300 rounded shadow-lg py-2">
                        <a href="{{ route('product_filter', ['sex' => 'male']) }}"
                            class="block px-4 py-2 hover:bg-gray-100">Nam</a>
                        <a href="{{ route('product_filter', ['sex' => 'female']) }}"
                            class="block px-4 py-2 hover:bg-gray-100">Nữ</a>
                        <a href="{{ route('product_filter', ['sex' => 'unisex']) }}"
                            class="block px-4 py-2 hover:bg-gray-100">Unisex</a>
                    </div>
                </button>
                <a href="{{ route('page_user', 5) }}"
                    class="block text-center font-semibold text-gray-800 hover:text-gray-900 transition-colors duration-300">
                    Chính sách
                </a>
            </div>

            <!-- Search bar -->
            <form action="{{ route('product_filter') }}" method="GET"
                class="relative group border-2 border-gray-200 hover:border-gray-300 focus-within:border-gray-400 transition-colors duration-300 rounded px-3 py-2">
                <!-- Input field -->
                <input type="text" id="search-input" placeholder="Tìm kiếm sản phẩm" name="keyword"
                    onkeyup="submitOnEnter(event)"
                    class="bg-transparent border-0 focus:outline-none focus:ring-0 w-full text-gray-700 font-medium pl-3">

                <!-- Search icon -->
                <span id="search-icon"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 cursor-pointer hover:text-gray-700 transition-colors duration-300">
                    <i class="fas fa-search"></i>
                </span>
            </form>


            <!-- Close button -->
            <button id="close-modal"
                class="mt-4 w-full block text-center px-5 py-2 font-medium bg-gray-700 text-white rounded-lg hover:bg-gray-800 shadow-md transition-colors duration-300">Đóng</button>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto mt-6">
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

    @php
        $setting = App\Models\Setting::find(1);
    @endphp
    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12 py-10 shadow-md">
        <div
            class="container mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 items-center justify-items-center">
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-4">Vison.vn</h3>
                <ul class="space-y-2">
                    <li>Địa chỉ: {{ $setting->address }}</li>
                    <li>Số điện thoại: {{ $setting->phone }}</li>
                    <li>Email: {{ $setting->email }}</li>
                </ul>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-4">Thông tin</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('page_user', 4) }}"
                            class="text-gray-400 hover:text-white transition-colors duration-300">Liên
                            hệ</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Chính
                            sách</a></li>
                    <li><a href="{{ route('page_user', 6) }}"
                            class="text-gray-400 hover:text-white transition-colors duration-300">Quyền
                            lợi</a></li>
                    <li><a href="{{ route('page_user', 7) }}"
                            class="text-gray-400 hover:text-white transition-colors duration-300">Thời
                            gian giao hàng?</a></li>
                </ul>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-4">Câu hỏi thường gặp</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('page_user', 8) }}"
                            class="text-blue-400 hover:text-blue-300 transition-colors duration-300">Làm
                            cách nào để theo dõi đơn hàng?</a></li>
                    <li><a href="{{ route('page_user', 10) }}"
                            class="text-blue-400 hover:text-blue-300 transition-colors duration-300">Cách
                            đổi trả sản phẩm?</a></li>
                    <li><a href="{{ route('page_user', 11) }}"
                            class="text-blue-400 hover:text-blue-300 transition-colors duration-300">Phí
                            vận chuyển là bao nhiêu?</a></li>
                    <!-- ... thêm mục khác nếu cần -->
                </ul>
            </div>
        </div>
    </footer>

    <!-- Swiper JS from CDN -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        document.getElementById('hamburger-btn').addEventListener('click', function() {
            document.getElementById('middle-links-modal').classList.remove('hidden');
        });

        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('middle-links-modal').classList.add('hidden');
        });

        document.getElementById('search-icon').addEventListener('click', function() {
            document.getElementById('middle-links-modal').classList.remove('hidden');
        });

        var modal = document.getElementById('middle-links-modal');

        // Sự kiện đóng modal khi nhấp bên ngoài modal
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });

        // Ngăn sự kiện click từ bên trong modal lan ra ngoài
        const innerModal = modal.querySelector('.bg-white.rounded-lg');
        innerModal.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    </script>

    <script>
        var element_menu_cart_hover = document.querySelector('#cart_hover')
        var element_menu_showbar = document.querySelector('#menu_showbar');

        element_menu_cart_hover.addEventListener('mouseenter', function() {
            element_menu_showbar.classList.remove('hidden')
        });

        element_menu_cart_hover.addEventListener('mouseleave', function() {
            element_menu_showbar.classList.add('hidden')
        });
    </script>

    <!-- ấn enter để tìm kiếm -->
    <script>
        function submitOnEnter(event) {
            if (event.keyCode === 13) { // 13 là mã keyCode cho phím Enter
                event.preventDefault(); // Ngăn chặn hành vi mặc định của phím Enter
                event.target.form.submit(); // Submit form chứa input
            }
        }
    </script>
</body>

</html>
