@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto px-2 sm:px-4 ">
        <div class="bg-white border border-gray-300 rounded shadow-lg">
            <div class="py-2 px-4 sm:px-6 border-b border-gray-300 flex flex-col sm:flex-row justify-between items-center">
                <h5 class="text-3xl font-bold text-gray-700 mb-4 md:mb-0">
                    Danh sách sản phẩm
                </h5>

                <div class="flex items-center space-x-2 italic text-sm text-gray-400">
                    {{ App\Models\Product::count() }} sản phẩm
                </div>

            </div>
            <div class="p-4 sm:p-6 overflow-x-auto">

                <div class="mb-5 grid md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-6 gap-3 " action="#">
                    <!-- hình dạng -->
                    <div class="relative">
                        <input type="text" id="searchBox_shape" class="border p-2 rounded w-full z-10" placeholder="Hình dạng"
                            name="shape" value="{{ $shape }}" onkeyup="filterOptions('optionList_shape')"
                            onclick="toggleOptions('optionList_shape', true)">
                        <div id="optionList_shape"
                            class="hidden absolute w-full max-h-40 overflow-x-auto mt-4 border border-gray-300 rounded z-20">
                            @foreach ($shapes as $item)
                                <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                    onclick="selectOption('{{ $item->name }}', 'searchBox_shape')">{{ $item->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Xuất xứ -->
                    <div class="relative">
                        <input type="text" id="searchBox_source" class="border p-2 rounded w-full z-10" placeholder="Xuất xứ"
                            name="source" value="{{ $source }}" onkeyup="filterOptions('optionList_source')"
                            onclick="toggleOptions('optionList_source', true)">
                        <div id="optionList_source"
                            class="hidden absolute w-full max-h-40 overflow-x-auto mt-4 border border-gray-300 rounded z-20">
                            @foreach ($sources as $item)
                                <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                    onclick="selectOption('{{ $item->name }}', 'searchBox_source')">{{ $item->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Thiết kế -->
                    <div class="relative">
                        <input type="text" id="searchBox_design" class="border p-2 rounded w-full z-10" placeholder="Thiết kế"
                            name="design" value="{{ $design }}" onkeyup="filterOptions('optionList_design')"
                            onclick="toggleOptions('optionList_design', true)">
                        <div id="optionList_design"
                            class="hidden absolute w-full max-h-40 overflow-x-auto mt-4 border border-gray-300 rounded z-20">
                            @foreach ($designs as $item)
                                <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                    onclick="selectOption('{{ $item->name }}', 'searchBox_design')">{{ $item->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    

                    <div class="relative ">
                        <input name="category" value="{{ $category }}" type="text" id="searchBox1"
                            class="border p-2 rounded w-full z-10" placeholder="Danh mục"
                            onkeyup="filterOptions('optionList1')" onclick="toggleOptions('optionList1', true)">
                        <div id="optionList1"
                            class="hidden absolute w-full max-h-40 overflow-x-auto mt-4 border border-gray-300 rounded z-20">
                            @foreach ($categories as $item)
                                <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                    onclick="selectOption('{{ $item->name }}', 'searchBox1')">{{ $item->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative">
                        <input type="text" id="searchBox2" class="border p-2 rounded w-full z-10" placeholder="Chất liệu"
                            name="material" value="{{ $material }}" onkeyup="filterOptions('optionList2')"
                            onclick="toggleOptions('optionList2', true)">
                        <div id="optionList2"
                            class="hidden absolute w-full max-h-40 overflow-x-auto mt-4 border border-gray-300 rounded z-20">
                            @foreach ($materials as $material)
                                <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                    onclick="selectOption('{{ $material->name }}', 'searchBox2')">{{ $material->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative">
                        <input type="text" id="searchBox3" class="border p-2 rounded w-full z-10" placeholder="Giới tính"
                            name="sex" value="{{ $sex }}" onkeyup="filterOptions('optionList3')"
                            onclick="toggleOptions('optionList3', true)">
                        <div id="optionList3"
                            class="hidden absolute w-full max-h-40 overflow-x-auto mt-4 border border-gray-300 rounded z-20">
                            <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                onclick="selectOption('Nam', 'searchBox3')">Nam</div>
                            <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                onclick="selectOption('Nữ', 'searchBox3')">Nữ</div>
                            <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                onclick="selectOption('Unisex', 'searchBox3')">Unisex</div>
                        </div>
                    </div>

                    <!-- Ve kính -->
                    <div class="relative">
                        <input type="text" id="searchBox_nose_tick" class="border p-2 rounded w-full z-10" placeholder="Ve kính"
                            name="nose_tick" value="{{ $nose_tick }}" onkeyup="filterOptions('optionList_nose_tick')"
                            onclick="toggleOptions('optionList_nose_tick', true)">
                        <div id="optionList_nose_tick"
                            class="hidden absolute w-full max-h-40 overflow-x-auto mt-4 border border-gray-300 rounded z-20">
                            <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                onclick="selectOption('yes', 'searchBox_nose_tick')">yes</div>
                            <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                onclick="selectOption('no', 'searchBox_nose_tick')">no</div>
                        </div>
                    </div>

                    <div class="relative">
                        <input type="text" id="searchBox4" class="border p-2 rounded w-full z-10"
                            placeholder="Thương hiệu" onkeyup="filterOptions('optionList4')"
                            onclick="toggleOptions('optionList4', true)" name="brand" value="{{ $brand }}">
                        <div id="optionList4"
                            class="hidden absolute w-full max-h-40 overflow-x-auto mt-4 border border-gray-300 rounded z-20">
                            @foreach ($brands as $brand)
                                <div class="p-2 bg-gray-200 cursor-pointer hover:bg-blue-400"
                                    onclick="selectOption('{{ $brand->name }}', 'searchBox4')">{{ $brand->name }}</div>
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



                <form action="{{ url('/admin/product/action') }}" method="POST">
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
                                        <span class="text-blue-800  cursor-pointer" id="gia_ca">
                                            Giá
                                            @php
                                                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                                $order = isset($_GET['order']) ? $_GET['order'] : '';

                                                if ($sort == 'price') {
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
                                            Số lượng
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
                                        Giới tính
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="text-blue-800  cursor-pointer" id="phien_ban">
                                            Phiên bản
                                            @php
                                                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                                $order = isset($_GET['order']) ? $_GET['order'] : '';

                                                if ($sort == 'version') {
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
                                    $count = ($products->currentPage() - 1) * $products->perPage();
                                @endphp
                                @foreach ($products as $product)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            <input class="check_item" type="checkbox" name="list_check[]"
                                                value="{{ $product->id }}">
                                        </td>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $count }}
                                        </th>

                                        <td class="px-6 py-4">{{ $product->name }}</td>
                                        @php
                                            $change_price = ('App\Helpers\Support')::change_vnd($product->price);
                                        @endphp
                                        <td class="px-6 py-4">{{ $change_price }}</td>
                                        <td class="px-6 py-4">{{ $product->versions->sum('quantity') }}</td>
                                        @php
                                            if ($product->sex == 'male') {
                                                $sex_change = 'Nam';
                                            } elseif ($product->sex == 'female') {
                                                $sex_change = 'Nữ';
                                            } else {
                                                $sex_change = 'Unisex';
                                            }
                                        @endphp
                                        <td class="px-6 py-4">{{ $sex_change }}</td>
                                        <td class="px-6 py-4">{{ $product->versions->count() }}</td>
                                        <td class="px-6 py-4 grid grid-cols-2 sm:grid-cols-1 gap-2">
                                            <a href="{{ route('detail_product', $product->id) }}"
                                                class="flex items-center justify-center  px-2 py-1 text-white bg-green-600 rounded hover:bg-green-700"
                                                type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa-solid fa-highlighter"></i>
                                            </a>
                                            <a href="{{ route('delete_product', $product->id) }}"
                                                onclick="return confirm('Bạn có thực sự muốn xoá không?')"
                                                class="flex items-center justify-center  px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700"
                                                type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa-regular fa-trash-can "></i>
                                            </a>
                                            <a href="{{ route('list_version', $product->id) }}"
                                                class="flex items-center justify-center  px-2 py-1 text-white bg-orange-600 rounded hover:bg-orange-700"
                                                type="button" data-toggle="tooltip" data-placement="top" title="List version">
                                                <i class="fa-solid fa-list-ol"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </form>
                {{ $products->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <script>
        // search button-----------------
        var search_input = document.querySelector("#search_input");
        var search_button = document.querySelector('#search_button')
        var searchBox1 = document.querySelector('#searchBox1')
        var searchBox2 = document.querySelector('#searchBox2')
        var searchBox3 = document.querySelector('#searchBox3')
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
            if (searchBox1 != null) {
                currentUrl.searchParams.set('category', searchBox1.value);
            }
            if (searchBox2 != null) {
                currentUrl.searchParams.set('material', searchBox2.value);
            }
            if (searchBox3 != null) {
                currentUrl.searchParams.set('sex', searchBox3.value);
            }
            if (searchBox4 != null) {
                currentUrl.searchParams.set('brand', searchBox4.value);
            }
            if (searchBox_shape != null) {
                currentUrl.searchParams.set('shape', searchBox_shape.value);
            }
            if (searchBox_source != null) {
                currentUrl.searchParams.set('source', searchBox_source.value);
            }
            if (searchBox_nose_tick != null) {
                currentUrl.searchParams.set('nose_tick', searchBox_nose_tick.value);
            }
            if (searchBox_design != null) {
                currentUrl.searchParams.set('design', searchBox_design.value);
            }
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
        var gia_ca = document.querySelector("#gia_ca");
        gia_ca.addEventListener('click', function() {
            let currentUrl = new URL(window.location.href);

            if (currentUrl.searchParams.get('sort') != 'price') {
                currentUrl.searchParams.set('sort', 'price');
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
        var phien_ban = document.querySelector("#phien_ban");
        phien_ban.addEventListener('click', function() {
            let currentUrl = new URL(window.location.href);

            if (currentUrl.searchParams.get('sort') != 'version') {
                currentUrl.searchParams.set('sort', 'version');
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
