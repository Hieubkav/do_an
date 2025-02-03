@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto p-6 min-h-screen">
        <div class="bg-white border border-gray-300 rounded shadow-lg p-6">
            <!-- Header -->
            <h5 class="text-3xl font-bold text-gray-700 mb-4 md:mb-0">
                Danh sách phiên bản của sản phẩm
                <a href="{{ route('detail_product', $product->id) }}" class="italic text-cyan-400">"{{ $product->name }}"</a>
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

            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <div class="flex items-center space-x-4 max-w-full">
                    <form action="#" class="flex border border-gray-300 rounded overflow-hidden">
                        <input value="{{ $keyword }}" name="keyword" type="text"
                            class="py-2 px-3 text-gray-800 bg-gray-100 focus:outline-none w-64"
                            placeholder="Tìm kiếm theo tên">
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-4 rounded-r hover:bg-blue-700 focus:outline-none">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <button id="openModal"
                        class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded focus:outline-none">
                        <i class="fa-solid fa-plus"></i>
                    </button>

                </div>
            </div>

            <!-- Main Content -->
            <form action="{{ route('action_version',$product->id) }}" method="POST">
                @csrf
                <div class="mb-6 flex items-center space-x-4">
                    <button onclick="return confirm('Bạn có thực sự muốn xoá không?')" type="submit"
                        class="bg-red-500 text-white py-3 px-8 rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 transition-shadow  duration-300 ease-in-out shadow-md font-semibold">
                        Xoá mục chọn
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md rounded-lg overflow-hidden">
                        <thead class="text-xs text-gray-700 uppercase bg-indigo-500 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 ">
                                    <input type="checkbox" class="check_list_all">
                                </th>
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
                                    Ảnh
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
                                    <span class="text-blue-800  cursor-pointer" id="mau_sac">
                                        Màu
                                        @php
                                            $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                            $order = isset($_GET['order']) ? $_GET['order'] : '';

                                            if ($sort == 'color') {
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
                        <tbody class="divide-y">
                            @php
                                $count = ($versions->currentPage() - 1) * $versions->perPage();
                            @endphp
                            @foreach ($versions as $version)
                                @php
                                    $count++;
                                @endphp
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        <input class="check_item" type="checkbox" name="list_check[]"
                                            value="{{ $version->id }}">
                                    </td>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $count }}
                                    </th>
                                    <td class="px-6 py-4">
                                        @php
                                            $color_version_image = $version->colorversionimages->where('color_id', $version->color->id)->first();
                                        @endphp
                                        <img class=" w-24 h-auto"
                                            src="{{ asset('asset/all_pic') }}/{{ $color_version_image->image }}"
                                            alt="">
                                    </td>
                                    <td class="px-6 py-4">{{ $version->name }}</td>
                                    <td class="px-6 py-4">{{ $version->quantity }}</td>
                                    <td class="px-6 py-4">{{ $version->color->name }}</td>
                                    <td class="px-6 py-4 grid grid-cols-2 sm:grid-cols-1 gap-2">
                                        <a href="{{ route('detail_version', [$version->product->id, $version->id, $version->color->id]) }}"
                                            class="flex items-center justify-center  px-2 py-1 text-white bg-green-500 rounded hover:bg-green-600"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete_version', [$version->product->id, $version->id]) }}"
                                            onclick="return confirm('Bạn có thực sự muốn xoá không?')"
                                            class="flex items-center justify-center  px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
            <div class="mt-6">
                {{ $versions->links('pagination::tailwind') }}
            </div>
        </div>

        <div id="myModal"
            class="fixed top-0 left-0 w-full h-full items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded shadow-lg p-8 w-96 relative">
                <button id="closeModal" class="absolute top-2 right-2">
                    <i class="fa-solid fa-xmark text-red-600 m-4"></i>
                </button>
                <h2 class="text-2xl mb-4 ">
                    Thêm phiên bản mới
                </h2>

                <form action="{{ route('store_version', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="versionName" class="block text-gray-700 mb-2">Tên phiên bản:</label>
                        <input type="text" id="versionName" name="title" class="border rounded w-full py-2 px-3">
                    </div>
                    <div class="mb-4">
                        <label for="pic" class="block text-gray-700 mb-2">Ảnh phiên bản:</label>
                        <input type="file" id="pic" name="pic" class="border rounded w-full py-2 px-3">
                        <!-- Thẻ img để xem trước hình ảnh -->
                        <img id="imagePreview" src="" alt="Ảnh xem trước" class="mt-4 w-full h-32 object-cover">
                    </div>
                    <div class="mb-4">
                        <label for="colorSelect" class="block text-gray-700 mb-2">Màu:</label>
                        <select id="colorSelect" name="color"
                            class="border bg-white text-gray-700 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent shadow-sm max-h-48 overflow-y-auto">
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            let openModalButton = document.getElementById('openModal');
            let closeModalButton = document.getElementById('closeModal');
            let modal = document.getElementById('myModal');

            openModalButton.addEventListener('click', function() {
                modal.style.display = 'flex';
            });

            closeModalButton.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
            // ảnh demo
            document.getElementById('pic').addEventListener('change', function(event) {
                let reader = new FileReader();
                reader.onload = function() {
                    let image = document.getElementById('imagePreview');
                    image.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            });
        </script>


        <script>
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
            var mau_sac = document.querySelector("#mau_sac");
            mau_sac.addEventListener('click', function() {
                let currentUrl = new URL(window.location.href);

                if (currentUrl.searchParams.get('sort') != 'color') {
                    currentUrl.searchParams.set('sort', 'color');
                    currentUrl.searchParams.set('order', 'asc');
                } else if (currentUrl.searchParams.get('order') == 'asc') {
                    currentUrl.searchParams.set('order', 'desc');
                } else if (currentUrl.searchParams.get('order') == 'desc') {
                    currentUrl.searchParams.set('order', 'asc');
                }

                window.location.href = currentUrl.toString();
            });
        </script>
    </div>
@endsection
