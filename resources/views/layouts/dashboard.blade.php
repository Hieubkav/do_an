<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Thiết lập thông tin trang -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Nhúng các thư viện và tài nguyên -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/solid.min.css">
    <script src="{{ asset('js/tiny.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="{{ asset('js/tailwind.js') }}"></script>
    <!-- Bắt đầu - Thư viện hỗ trợ giao diện đẹp mắt cho selection -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <!-- Kết thúc - Thư viện hỗ trợ giao diện đẹp mắt cho selection -->

    <!-- dùng htmx -->
    <script src="https://unpkg.com/htmx.org"></script>

    <!-- ChartJS để vẽ sơ đồ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Cấu hình cho trình soạn thảo tinymce -->
    <script>
        var editor_config = {
            path_absolute: "http://127.0.0.1:8000/",
            selector: '#basic-conf',
            relative_urls: false,
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak nonbreaking save' +
                'autoresize code codesample emoticons media searchreplace table visualblocks wordcount visualchars' +
                'checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes directionality' +
                'advtemplate advtable advcode editimage tableofcontents mergetags powerpaste fullscreen insertdatetime' +
                'tinymcespellchecker autocorrect a11ychecker typography inlinecss template paste textpattern',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic underline strikethrough | link image media table mergetags | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | charmap emoticons | ' +
                'fullscreen | code codesample searchreplace checklist tableofcontents' +
                'insertfile undo redo | styleselect',
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document
                    .getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };

        tinymce.init(editor_config);
    </script>
    <!-- Các style tự định nghĩa -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f4f6f9;
        }

        .bg-indigo-700 {
            background-color: #34495E;
        }

        .text-indigo-100 {
            color: #EAEDED;
        }

        .text-indigo-300 {
            color: #BDC3C7;
        }

        .hover\\:bg-indigo-600:hover {
            background-color: #2C3E50;
        }
    </style>
    <style>
        .tox-statusbar__branding {
            display: none;
        }

        .tox-notification.tox-notification--in.tox-notification--warning {
            display: none;
        }
    </style>
</head>

<body>
    <div>
        <!-- Mobile menu -->
        <div id="menu_2" class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true">
            <!-- Nội dung menu trên điện thoại -->
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-indigo-700">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button type="button"
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <svg onclick="toggleMenu(document.getElementById('menu_2'), this)" class="h-6 w-6 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-shrink-0 flex items-center px-4">
                    <img class="h-8 w-auto" src="{{ asset('asset/local/light_logo.svg') }}" alt="Vision.vn">
                </div>
                <div class="mt-5 flex-1 h-0 overflow-y-auto">
                    <nav class="flex-1 px-2 pb-4 space-y-1">
                        <a href="{{ route('dashboard') }}"
                            class="text-indigo-100
                            @php if (!auth()->user()->hasRole(1)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/home -->
                            <i class="fa-solid fa-house text-indigo-300 mr-3 flex-shrink-0 text-lg "></i>
                            Tổng quan
                        </a>

                        <button onclick="toggleSide('sidemenu_baiviet')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(3)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/users -->
                            <i class="fa-solid fa-newspaper mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Bài viết
                        </button>
                        <div id="sidemenu_baiviet" class="space-y-2 hidden">
                            <!-- Đây là nội dung của menu con. Bạn có thể thêm hoặc chỉnh sửa các mục tại đây. -->
                            <a href="{{ route('add_post') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">Thêm mới</a>
                            <a href="{{ route('list_post') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">Danh sách </a>
                        </div>
                        <!--//////////// -->

                        <button onclick="toggleSide('sidemenu_trang')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(4)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/folder -->
                            <i class="fa-solid fa-file-lines mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Trang
                        </button>
                        <div id="sidemenu_trang" class="space-y-2 hidden">
                            <!-- Đây là nội dung của menu con. Bạn có thể thêm hoặc chỉnh sửa các mục tại đây. -->
                            {{-- <a href="{{ route('add_page') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Thêm mới
                            </a> --}}
                            <a href="{{ route('list_page') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Danh sách
                            </a>
                        </div>
                        <!--//////////// -->

                        <button onclick="toggleSide('sidemenu_sanpham')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(5)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/folder -->
                            <i class="fa-solid fa-box-open mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Sản phẩm
                        </button>
                        <div id="sidemenu_sanpham" class="space-y-2 hidden">
                            <!-- Đây là nội dung của menu con. Bạn có thể thêm hoặc chỉnh sửa các mục tại đây. -->
                            <a href="{{ route('add_product') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Thêm mới
                            </a>
                            <a href="{{ route('list_product') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Danh sách
                            </a>
                            <a href="{{ route('list_category') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Danh mục
                            </a>
                        </div>
                        <!--//////////// -->

                        <button onclick="toggleSide('sidemenu_banhang')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(6)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/calendar -->
                            <i class="fa-brands fa-first-order mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Bán hàng
                        </button>
                        <div id="sidemenu_banhang" class="space-y-2 hidden">
                            <a href="{{ route('list_order') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Danh sách đơn
                            </a>
                            <a href="{{ route('list_customer') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Khách hàng
                            </a>
                        </div>
                        <!--//////////// -->

                        <button onclick="toggleSide('sidemenu_phanloai')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(7)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/folder -->
                            <i class="fa-solid fa-quote-right mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Phân loại
                        </button>
                        <div id="sidemenu_phanloai" class="space-y-2 hidden">
                            <!-- Đây là nội dung của menu con. Bạn có thể thêm hoặc chỉnh sửa các mục tại đây. -->
                            <a href="{{ route('list_brand') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Thương hiệu
                            </a>
                            <a href="{{ route('list_design') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Thiết kế
                            </a>
                            <a href="{{ route('list_shape') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Hình dạng
                            </a>
                            <a href="{{ route('list_material') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Chất liệu
                            </a>
                            <a href="{{ route('list_source') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Xuất xứ
                            </a>
                            <a href="{{ route('list_size') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Kích thước
                            </a>
                            <a href="{{ route('list_color') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Màu sắc
                            </a>
                        </div>
                        <!--//////////// -->

                        <button onclick="toggleSide('sidemenu_user')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(10)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <i class="fa-solid fa-users-between-lines mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            User
                        </button>
                        <div id="sidemenu_user" class="space-y-2 hidden">
                            <!-- Đây là nội dung của menu con. Bạn có thể thêm hoặc chỉnh sửa các mục tại đây. -->
                            <a href="{{ route('add_user') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Thêm mới
                            </a>
                            <a href="{{ route('list_user') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Nhân viên
                            </a>
                            @php
                                $admin = App\Models\User::where('rule', 'admin')->first();
                            @endphp
                            <a href="{{ route('detail_user', $admin->id) }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Admin
                            </a>
                            <a href="{{ route('list_role') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Phân quyền
                            </a>
                        </div>

                        <!-- Line -->
                        <div class="w-5/6 mx-auto border-t border-indigo-500 my-4"></div>

                        <!-- Cài đặt -->
                        <a href="{{ route('setting') }}"
                            class="text-indigo-100
                            @php if (!auth()->user()->hasRole(8)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fa-solid fa-gears mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Cài đặt
                        </a>
                        <a href="{{ route('info') }}"
                            class="text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fa-solid fa-circle-info mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Thông tin
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Sidebar cho màn hình desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex flex-col flex-grow pt-5 bg-indigo-700 overflow-y-auto">

                <div class="flex items-center flex-shrink-0 px-2">
                    <a href="{{ route('store_front') }}" target="_blank">
                        <img class="h-auto w-1/2" src="{{ asset('asset/local/light_logo.svg') }}" alt="Vision.vn">
                    </a>
                </div>
                <div class="mt-5 flex-1 flex flex-col">
                    <nav class="flex-1 px-2 pb-4 space-y-1">
                        <a href="{{ route('dashboard') }}"
                            class="text-indigo-100
                            @php if (!auth()->user()->hasRole(1)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/home -->
                            <i class="fa-solid fa-house text-indigo-300 mr-3 flex-shrink-0 text-lg "></i>
                            Tổng quan
                        </a>

                        <button onclick="toggleSide('sidemenu_baiviet')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(3)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/users -->
                            <i class="fa-solid fa-newspaper mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Bài viết
                        </button>
                        <div id="sidemenu_baiviet" class="space-y-2 hidden">
                            <!-- Đây là nội dung của menu con. Bạn có thể thêm hoặc chỉnh sửa các mục tại đây. -->
                            <a href="{{ route('add_post') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">Thêm mới</a>
                            <a href="{{ route('list_post') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">Danh sách </a>
                        </div>
                        <!--//////////// -->

                        <button onclick="toggleSide('sidemenu_trang')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(4)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/folder -->
                            <i class="fa-solid fa-file-lines mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Trang
                        </button>
                        <div id="sidemenu_trang" class="space-y-2 hidden">
                            <!-- Đây là nội dung của menu con. Bạn có thể thêm hoặc chỉnh sửa các mục tại đây. -->
                            {{-- <a href="{{ route('add_page') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Thêm mới
                            </a> --}}
                            <a href="{{ route('list_page') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Danh sách
                            </a>
                        </div>
                        <!--//////////// -->

                        <button onclick="toggleSide('sidemenu_sanpham')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(5)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/folder -->
                            <i class="fa-solid fa-box-open mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Sản phẩm
                        </button>
                        <div id="sidemenu_sanpham" class="space-y-2 hidden">
                            <!-- Đây là nội dung của menu con. Bạn có thể thêm hoặc chỉnh sửa các mục tại đây. -->
                            <a href="{{ route('add_product') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Thêm mới
                            </a>
                            <a href="{{ route('list_product') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Danh sách
                            </a>
                            <a href="{{ route('list_category') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Danh mục
                            </a>
                        </div>
                        <!--//////////// -->

                        <button onclick="toggleSide('sidemenu_banhang')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(6)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/calendar -->
                            <i class="fa-brands fa-first-order mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Bán hàng
                        </button>
                        <div id="sidemenu_banhang" class="space-y-2 hidden">
                            <a href="{{ route('list_order') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Danh sách đơn
                            </a>
                            <a href="{{ route('list_customer') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Khách hàng
                            </a>
                        </div>
                        <!--//////////// -->

                        <button onclick="toggleSide('sidemenu_phanloai')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(7)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/folder -->
                            <i class="fa-solid fa-quote-right mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Phân loại
                        </button>
                        <div id="sidemenu_phanloai" class="space-y-2 hidden">
                            <!-- Đây là nội dung của menu con. Bạn có thể thêm hoặc chỉnh sửa các mục tại đây. -->
                            <a href="{{ route('list_brand') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Thương hiệu
                            </a>
                            <a href="{{ route('list_design') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Thiết kế
                            </a>
                            <a href="{{ route('list_shape') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Hình dạng
                            </a>
                            <a href="{{ route('list_material') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Chất liệu
                            </a>
                            <a href="{{ route('list_source') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Xuất xứ
                            </a>
                            <a href="{{ route('list_size') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Kích thước
                            </a>
                            <a href="{{ route('list_color') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Màu sắc
                            </a>
                        </div>
                        <!--//////////// -->

                        <button onclick="toggleSide('sidemenu_user')"
                            class="w-full text-indigo-100
                            @php if (!auth()->user()->hasRole(10)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <i class="fa-solid fa-users-between-lines mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            User
                        </button>
                        <div id="sidemenu_user" class="space-y-2 hidden">
                            <!-- Đây là nội dung của menu con. Bạn có thể thêm hoặc chỉnh sửa các mục tại đây. -->
                            <a href="{{ route('add_user') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Thêm mới
                            </a>
                            <a href="{{ route('list_user') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Nhân viên
                            </a>
                            @php
                                $admin = App\Models\User::where('rule', 'admin')->first();
                            @endphp
                            <a href="{{ route('detail_user', $admin->id) }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Admin
                            </a>
                            <a href="{{ route('list_role') }}"
                                class="block px-4 py-2 text-green-400 hover:bg-indigo-600">
                                Phân quyền
                            </a>
                        </div>

                        <!-- Line -->
                        <div class="w-5/6 mx-auto border-t border-indigo-500 my-4"></div>

                        <!-- Cài đặt -->
                        <a href="{{ route('setting') }}"
                            class="text-indigo-100
                            @php if (!auth()->user()->hasRole(8)) echo "hidden"; @endphp
                             hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fa-solid fa-gears mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Cài đặt
                        </a>
                        <a href="{{ route('info') }}"
                            class="text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fa-solid fa-circle-info mr-3 flex-shrink-0 text-lg text-indigo-300"></i>
                            Thông tin
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Nội dung chính của trang -->
        <div class="md:pl-64 flex flex-col flex-1">
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button type="button" onclick="toggleMenu(document.getElementById('menu_2'), this)"
                    class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <div class="flex-1 px-4 flex justify-between">
                    <!-- Toast start -->
                    <style>
                        @keyframes thinning {
                            to {
                                height: 0;
                            }
                        }

                        @keyframes progress {
                            0% {
                                width: 0;
                            }

                            100% {
                                width: 100%;
                            }
                        }

                        @keyframes slidein {
                            from {
                                transform: translateY(1rem);
                                opacity: 0;
                            }

                            to {
                                transform: translateY(0);
                                opacity: 1;
                            }
                        }

                        @keyframes fadeout {
                            from {
                                opacity: 1;
                            }

                            to {
                                opacity: 0;
                            }
                        }

                        #progress {
                            animation-timing-function: ease-in;
                        }
                    </style>
                    @if (session('status'))
                        <div id="toast"
                            class="fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 opacity-0 invisible "
                            role="alert">
                            <p>{{ session('status') }}</p>
                            <div id="progress" class="absolute bottom-0 left-0 h-1 bg-green-500"></div>
                        </div>
                    @endif
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const toast = document.getElementById('toast');
                            const progress = document.getElementById('progress');
                            if (toast) {
                                // Show the toast
                                toast.style.animation =
                                    'slidein 0.5s forwards, fadeout 0.5s 2.5s forwards, thinning 3s 2.5s forwards';
                                toast.style.visibility = 'visible';
                                progress.style.animation = 'progress 3s 0.5s forwards';

                                // Hide the toast after 3.5 seconds
                                setTimeout(() => {
                                    toast.style.visibility = 'hidden';
                                }, 3500);
                            }
                        });
                    </script>
                    <!-- Toast end -->
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Profile dropdown -->
                        <div class="ml-3 relative">
                            <div>
                                <button type="button" onclick="toggleMenu(document.getElementById('menu'), this)"
                                    class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>

                                    <i class="fa-solid fa-user-tie text-2xl h-8 w-8 rounded-full"></i>
                                </button>
                            </div>

                            <div id="menu"
                                class="hidden origin-top-right absolute left-0 border border-blue-400 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <!-- Active: "bg-gray-100", Not Active: "" -->
                                <a href="{{ route('edit-profile') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-cyan-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Tài khoản</a>

                                <a href="{{ route('logout') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-cyan-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-2">Đăng xuất</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <main>
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-1 sm:px-2 md:px-3">
                        @yield('content')
                        <div class="py-4">
                            <div></div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
