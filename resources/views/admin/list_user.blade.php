@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto px-2 sm:px-4 ">
        <div class="bg-white border border-gray-300 rounded shadow-lg">
            <div class="py-2 px-4 sm:px-6 border-b border-gray-300 flex flex-col sm:flex-row justify-between items-center">
                <h5 class="text-3xl font-bold text-gray-700 mb-4 md:mb-0">
                    Danh sách nhân viên
                    <a href="{{ route('add_user') }}"
                        class="p-1 bg-green-500 hover:bg-green-900 rounded focus:outline-none">
                        <i class="fa-solid fa-plus h-6 w-6 text-white"></i>
                    </a>
                </h5>

                <div class="flex items-center space-x-2 italic text-sm text-gray-400">
                    {{ $users->count() }} nhân viên
                </div>

            </div>
            <div class="p-4 sm:p-6 overflow-x-auto">
                <div class="mb-5 grid md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-6 gap-3 " action="#">
                    <div class="relative">
                        <input type="text" id="searchBox4" class="border p-2 rounded w-full z-10"
                            placeholder="Quyền" onkeyup="filterOptions('optionList4')"
                            onclick="toggleOptions('optionList4', true)" name="role" value="{{ $role }}">
                        <div id="optionList4"
                            class="hidden absolute w-full max-h-40 overflow-x-auto mt-4 border border-gray-300 rounded z-20">
                            @foreach ($roles as $role)
                                <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                    onclick="selectOption('{{ $role->name }}', 'searchBox4')">{{ $role->name }}</div>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative flex col-span-2">
                        <input id="search_input" value="{{ $keyword }}" name="keyword" type="text"
                            class="text-gray-800 py-2 px-3 border border-gray-200 rounded" placeholder="Tìm kiếm theo tên">
                        <button id="search_button" type="submit"
                            class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Tìm
                            kiếm</button>
                    </div>
                </div>

                <form action="{{ route('action_user') }}" method="POST">
                    @csrf
                    <div class="flex items-center space-x-2 mb-4">
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
                                        <span class="text-blue-800  cursor-pointer" id="email">
                                            Email
                                            @php
                                                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                                $order = isset($_GET['order']) ? $_GET['order'] : '';

                                                if ($sort == 'email') {
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
                                        <span class="text-blue-800  cursor-pointer" id="quantity">
                                            Số quyền
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
                                    $count = ($users->currentPage() - 1) * $users->perPage();
                                @endphp
                                @foreach ($users as $user)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            <input class="check_item" type="checkbox" name="list_check[]"
                                                value="{{ $user->id }}">
                                        </td>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $count }}
                                        </th>

                                        <td class="px-6 py-4">{{ $user->name }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">{{ $user->roles->count() }}</td>
                                        <td class="px-6 py-4 grid grid-cols-2 sm:grid-cols-1 gap-2">
                                            <a href="{{ route('detail_user', $user->id) }}"
                                                class="flex items-center justify-center  px-2 py-1 text-white bg-green-600 rounded hover:bg-green-700"
                                                type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa-solid fa-highlighter"></i>
                                            </a>
                                            <a href="{{ route('delete_user', $user->id) }}"
                                                onclick="return confirm('Bạn có thực sự muốn xoá không?')"
                                                class="flex items-center justify-center  px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700"
                                                type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa-regular fa-trash-can "></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </form>
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <script>
        // search button-----------------
        var search_input = document.querySelector("#search_input");
        var search_button = document.querySelector('#search_button')
        var searchBox4 = document.querySelector('#searchBox4')

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
            if (searchBox4 != null) {
                currentUrl.searchParams.set('role', searchBox4.value);
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
        var email = document.querySelector("#email");
        email.addEventListener('click', function() {
            let currentUrl = new URL(window.location.href);

            if (currentUrl.searchParams.get('sort') != 'email') {
                currentUrl.searchParams.set('sort', 'email');
                currentUrl.searchParams.set('order', 'asc');
            } else if (currentUrl.searchParams.get('order') == 'asc') {
                currentUrl.searchParams.set('order', 'desc');
            } else if (currentUrl.searchParams.get('order') == 'desc') {
                currentUrl.searchParams.set('order', 'asc');
            }

            window.location.href = currentUrl.toString();
        });
        var quantity = document.querySelector("#quantity");
        quantity.addEventListener('click', function() {
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
