@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto px-2 sm:px-4 ">
        <div class="bg-white border border-gray-300 rounded shadow-lg">
            <div class="py-2 px-4 sm:px-6 border-b border-gray-300 flex flex-col sm:flex-row justify-between items-center">
                <h5 class="text-xl font-semibold mb-2 sm:mb-0">
                    Danh sách thương hiệu

                    <button id="openModalBtn"
                        class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded focus:outline-none">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </h5>
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center space-x-2 italic text-sm text-gray-400">
                    {{ $brands->count() }} thương hiệu
                </div>
            </div>
            <div class="p-4 sm:p-6 overflow-x-auto">

                <div class="mb-5 grid md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-6 gap-3 " action="#">
                    <div class="relative flex col-span-2">
                        <input id="search_input" value="{{ $keyword }}" name="keyword" type="text"
                            class="text-gray-800 py-2 px-3 border border-gray-200 rounded" placeholder="Tìm kiếm theo tên">
                        <button id="search_button" type="submit"
                            class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Tìm
                            kiếm</button>
                    </div>
                </div>
                <form action="{{ route('action_brand') }}" method="POST">
                    @csrf
                    <div class="mb-6 flex items-center space-x-4">
                        <button onclick="return confirm('Bạn có thực sự muốn xoá không?')" type="submit"
                            class="bg-red-500 text-white py-3 px-8 rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 transition-shadow  duration-300 ease-in-out shadow-md font-semibold">
                            Xoá mục chọn
                        </button>
    
                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 ">
                                        <input type="checkbox" class="check_list_all">
                                    </th>
                                    {{-- # --}}
                                    <th scope="col" class="px-6 py-3">
                                        <span class="text-blue-800  cursor-pointer" id="thu_tu">
                                            #
                                            @php
                                                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                                $order = isset($_GET['order']) ? $_GET['order'] : '';

                                                if ($sort == 'id') {
                                                    if ($order == 'asc') {
                                                        echo '
                                                        <i class="fa-solid fa-caret-down"></i>
                                                    ';
                                                    } else {
                                                        echo '
                                                        <i class="fa-solid fa-caret-up"></i>
                                                        ';
                                                    }
                                                }
                                            @endphp
                                        </span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="text-blue-800  cursor-pointer" id="tieu_de">
                                            Tên
                                            @php
                                                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                                $order = isset($_GET['order']) ? $_GET['order'] : '';

                                                if ($sort == 'name') {
                                                    if ($order == 'asc') {
                                                        echo '
                                                        <i class="fa-solid fa-caret-down"></i>
                                                    ';
                                                    } else {
                                                        echo '
                                                        <i class="fa-solid fa-caret-up"></i>
                                                        ';
                                                    }
                                                }
                                            @endphp
                                        </span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="text-blue-800  cursor-pointer" id="so_luong">
                                            Sản phẩm
                                            @php
                                                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                                $order = isset($_GET['order']) ? $_GET['order'] : '';

                                                if ($sort == 'quantity') {
                                                    if ($order == 'asc') {
                                                        echo '
                                                        <i class="fa-solid fa-caret-down"></i>
                                                    ';
                                                    } else {
                                                        echo '
                                                        <i class="fa-solid fa-caret-up"></i>
                                                        ';
                                                    }
                                                }
                                            @endphp
                                        </span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tác vụ
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $count = ($brands->currentPage() - 1) * $brands->perPage();
                                @endphp
                                @foreach ($brands as $brand)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            <input class="check_item" type="checkbox" name="list_check[]"
                                                value="{{ $brand->id }}">
                                        </td>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $count }}
                                        </th>
                                        <td class="px-6 py-4">{{ $brand->name }}</td>
                                        <td class="px-6 py-4">{{ $brand->products->count() }}</td>
                                        <td class="px-6 py-4 grid grid-cols-2 sm:grid-cols-1 gap-2">
                                            <button type="button"
                                                class="openEditModalBtn flex items-center justify-center  px-2 py-1 text-white bg-green-500 rounded hover:bg-green-600"
                                                data-id="{{ $brand->id }}" data-name="{{ $brand->name }}"
                                                >
                                                <i class="fa-solid fa-highlighter"></i>
                                            </button>

                                            <a href="{{ route('delete_brand', $brand->id) }}"
                                                onclick="return confirm('Bạn có thực sự muốn xoá không?')"
                                                class="flex items-center justify-center  px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700"
                                                type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa-regular fa-trash-can "></i>
                                            </a>
                                            <a href="{{ route('list_product', [
                                                'brand' => $brand->name,
                                            ]) }}"
                                                class="flex items-center justify-center  px-2 py-1 text-white bg-orange-600 rounded hover:bg-orange-700"
                                                type="button" data-toggle="tooltip" data-placement="top"
                                                title="List product">
                                                <i class="fa-solid fa-list-ol"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </form>
                {{ $brands->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <!-- Container cho modal và nền mờ -->
    <div id="myModal" class="fixed inset-0 items-center justify-center z-50 hidden">
        <!-- Nền mờ khi hiển thị modal -->
        <div class="absolute inset-0 bg-black opacity-40"></div>

        <!-- Modal -->
        <div class="bg-white p-4 rounded-lg shadow-xl w-full max-w-md relative z-10">
            <!-- Nút đóng modal -->
            <div class="flex justify-end">
                <button id="closeModal" class="p-1 hover:bg-gray-200 rounded-full focus:outline-none">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="mt-3">
                <h2 class="text-xl font-semibold mb-3">Thêm thương hiệu</h2>

                <!-- Form thêm thương hiệu -->
                <form action="{{ route('store_brand') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tên thương hiệu:</label>
                        <input type="text" name="name" id="name" class="border rounded-md p-2 w-full"
                            placeholder="Nhập tên thương hiệu">
                    </div>

                    <button type="submit"
                        class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none">Thêm
                        mới</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal chỉnh sửa -->
    <!-- Modal sửa thương hiệu -->
    <div id="editModal" class="fixed inset-0 items-center justify-center z-50 hidden">
        <!-- Nền mờ khi hiển thị modal -->
        <div class="absolute inset-0 bg-black opacity-40"></div>

        <!-- Modal -->
        <div class="bg-white p-4 rounded-lg shadow-xl w-full max-w-md relative z-10">
            <!-- Nút đóng modal -->
            <div class="flex justify-end">
                <button id="closeEditModal" class="p-1 hover:bg-gray-200 rounded-full focus:outline-none">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="mt-3">
                <h2 class="text-xl font-semibold mb-3">Sửa thương hiệu</h2>

                <!-- Form sửa thương hiệu -->
                <form action="{{ route('update_brand', 'ID_HERE') }}" method="post" id="editForm">
                    @csrf
                    <div class="mb-4">
                        <label for="editName" class="block text-sm font-medium text-gray-700 mb-2">Tên thương hiệu:</label>
                        <input type="text" name="name" id="editName" class="border rounded-md p-2 w-full"
                            value="{{ $brand->name }}">
                    </div>

                    <button type="submit"
                        class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none">
                        Cập nhật
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal điều chỉnh thương hiệu -->
    <script>
        document.querySelectorAll('.openEditModalBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                // Lấy thông tin từ nút "Sửa"
                const categoryId = button.getAttribute('data-id');
                const categoryName = button.getAttribute('data-name');

                // Cập nhật form trên modal
                document.getElementById('editName').value = categoryName;

                // Cập nhật action của form dựa trên ID của thương hiệu
                const form = document.getElementById('editForm');
                form.setAttribute('action', form.getAttribute('action').replace('ID_HERE', categoryId));

                // Hiển thị modal sửa
                editModal.style.display = 'flex';
            });
        });

        const closeEditModalBtn = document.getElementById('closeEditModal'); // thêm dòng này
        closeEditModalBtn.addEventListener('click', function() { // và đoạn này
            editModal.style.display = 'none';
        });
    </script>

    <!-- JavaScript để điều khiển modal -->
    <script>
        const modal = document.getElementById('myModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModal');

        // Mở modal
        openModalBtn.addEventListener('click', function() {
            modal.style.display = 'flex';
        });

        // Đóng modal
        closeModalBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Đóng modal khi nhấp vào nền mờ bên ngoài
        const editModal = document.getElementById('editModal'); // thêm dòng này

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
            if (event.target === editModal) { // thêm đoạn này
                editModal.style.display = 'none';
            }
        });
    </script>

    <script>
        // search button-----------------
        var search_input = document.querySelector("#search_input");
        var search_button = document.querySelector('#search_button')

        search_input.addEventListener('keyup', function(event) {
            // Kiểm tra xem phím vừa nhấn có phải là Enter hay không
            if (event.key === 'Enter' || event.keyCode === 13) {
                // Kích hoạt sự kiện click cho searchButton
                search_button.click();
            }
        });
        search_button.addEventListener('click', function() {
            // Tạo một đối tượng URL từ URL hiện tại
            let currentUrl = new URL(window.location.href);
            // Thêm hoặc chỉnh sửa các tham số truy vấn
            currentUrl.searchParams.set('keyword', search_input.value);
            // Cập nhật URL trên trình duyệt (chuyển hướng đến URL mới)
            window.location.href = currentUrl.toString();
        });

        // lọc dữ liệu 
        var thu_tu = document.querySelector("#thu_tu");
        thu_tu.addEventListener('click', function() {
            let currentUrl = new URL(window.location.href);

            if (currentUrl.searchParams.get('sort') != 'id') {
                currentUrl.searchParams.set('sort', 'id');
                currentUrl.searchParams.set('order', 'asc');
            } else if (currentUrl.searchParams.get('order') == 'asc') {
                currentUrl.searchParams.set('order', 'desc');
            } else if (currentUrl.searchParams.get('order') == 'desc') {
                currentUrl.searchParams.set('order', 'asc');
            }

            window.location.href = currentUrl.toString();
        });
        var tieu_de = document.querySelector("#tieu_de");
        tieu_de.addEventListener('click', function() {
            let currentUrl = new URL(window.location.href);

            if (currentUrl.searchParams.get('sort') != 'name') {
                currentUrl.searchParams.set('sort', 'name');
                currentUrl.searchParams.set('order', 'asc');
            } else if (currentUrl.searchParams.get('order') == 'asc') {
                currentUrl.searchParams.set('order', 'desc');
            } else if (currentUrl.searchParams.get('order') == 'desc') {
                currentUrl.searchParams.set('order', 'asc');
            }

            window.location.href = currentUrl.toString();
        });
        var so_luong = document.querySelector("#so_luong");
        so_luong.addEventListener('click', function() {
            let currentUrl = new URL(window.location.href);

            if (currentUrl.searchParams.get('sort') != 'quantity') {
                currentUrl.searchParams.set('sort', 'quantity');
                currentUrl.searchParams.set('order', 'asc');
            } else if (currentUrl.searchParams.get('order') == 'asc') {
                currentUrl.searchParams.set('order', 'desc');
            } else if (currentUrl.searchParams.get('order') == 'desc') {
                currentUrl.searchParams.set('order', 'asc');
            }

            window.location.href = currentUrl.toString();
        });

        ////////////////////////////////
        let checkall = document.querySelector('.check_list_all')
        let check_items = document.querySelectorAll('.check_item')

        checkall.addEventListener('change', function() {
            check_items.forEach(element => {
                element.checked = checkall.checked
            });
        })
        // ///////////
        function toggleOptions(optionListId, show) {
            const div = document.getElementById(optionListId);
            if (show) {
                div.classList.remove('hidden');
            } else {
                div.classList.add('hidden');
            }
        }

        function filterOptions(optionListId) {
            const input = document.getElementById('searchBox' + optionListId.charAt(optionListId.length - 1));
            const filter = input.value.toUpperCase();
            const div = document.getElementById(optionListId);
            const options = div.getElementsByTagName('div');
            for (let i = 0; i < options.length; i++) {
                const txtValue = options[i].textContent || options[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    options[i].style.display = '';
                } else {
                    options[i].style.display = 'none';
                }
            }
        }

        function selectOption(option, searchBoxId) {
            const input = document.getElementById(searchBoxId);
            input.value = option;
            toggleOptions(searchBoxId.replace('searchBox', 'optionList'), false);
        }
        // Close options when clicking outside
        document.addEventListener('click', function(event) {
            const optionLists = document.querySelectorAll('[id^="optionList"]');
            const searchBoxes = document.querySelectorAll('[id^="searchBox"]');
            let clickedOutside = true;

            for (let i = 0; i < optionLists.length; i++) {
                if (optionLists[i].contains(event.target) || searchBoxes[i].contains(event.target)) {
                    clickedOutside = false;
                    break;
                }
            }

            if (clickedOutside) {
                for (let i = 0; i < optionLists.length; i++) {
                    toggleOptions(optionLists[i].id, false);
                }
            }
        });
    </script>
@endsection
