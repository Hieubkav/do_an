@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto px-2 sm:px-4 ">
        <div class="bg-white border border-gray-300 rounded shadow-lg">
            <div class="py-2 px-4 sm:px-6 border-b border-gray-300 flex flex-col sm:flex-row justify-between items-center">
                <h5 class="text-xl font-semibold mb-2 sm:mb-0">
                    Danh sách quyền
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
                    {{ $roles->count() }} quyền
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


                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
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
                                        Nhân viên có quyền
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
                                $count = ($roles->currentPage() - 1) * $roles->perPage();
                            @endphp
                            @foreach ($roles as $role)
                                @php
                                    $count++;
                                @endphp
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $count }}
                                    </th>
                                    <td class="px-6 py-4">{{ $role->name }}</td>
                                    <td class="px-6 py-4">{{ $role->users->count() }}</td>
                                    <td class="px-6 py-4 grid grid-cols-2 sm:grid-cols-1 gap-2">
                                        <a href="{{ route('list_user', [
                                            'role' => $role->name,
                                        ]) }}"
                                            class="flex items-center justify-center  px-2 py-1 text-white bg-orange-600 rounded hover:bg-orange-700"
                                            type="button" data-toggle="tooltip" data-placement="top" title="List product">
                                            <i class="fa-solid fa-list-ol"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $roles->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

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

       
    </script>
@endsection
