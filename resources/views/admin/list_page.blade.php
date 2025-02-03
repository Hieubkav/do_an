@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto p-6 min-h-screen">
        <div class="bg-white border border-gray-300 rounded shadow-lg p-6">

            <!-- Header -->
            <h5 class="block py-3 text-3xl font-bold text-gray-700 mb-4 md:mb-0">Danh sách trang</h5>
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                
                <div class="flex items-center space-x-4 max-w-full">
                    <form action="#" class="flex border border-gray-300 rounded overflow-hidden">
                        <input value="{{ $keyword }}" name="keyword" type="text"
                            class="py-2 px-3 text-gray-800 bg-gray-100 focus:outline-none w-64" placeholder="Tìm kiếm...">
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-4 rounded-r hover:bg-blue-700 focus:outline-none">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <!-- Thêm nút "Thêm trang" ở đây -->
                    {{-- <a href="{{ route('add_page') }}"
                        class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded focus:outline-none">
                        <i class="fa-solid fa-plus"></i>
                    </a> --}}
                </div>
            </div>

            <!-- Main Content -->
            <form action="{{ url('/admin/page/action') }}" method="POST">
                @csrf
                <div class="mb-6 flex items-center space-x-4">
                    {{-- <button onclick="return confirm('Bạn có thực sự muốn xoá không?')" type="submit"
                        class="bg-red-500 text-white py-3 px-8 rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 transition-shadow  duration-300 ease-in-out shadow-md font-semibold">
                        Xoá mục chọn
                    </button> --}}

                </div>

                <div class="overflow-x-auto">
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md rounded-lg overflow-hidden">
                        <thead class="text-xs text-gray-700 uppercase bg-indigo-500 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                {{-- <th scope="col" class="px-6 py-3 ">
                                    <input type="checkbox" class="check_list_all">
                                </th> --}}
                                @php
                                    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                    $order = isset($_GET['order']) ? $_GET['order'] : '';
                                    
                                    if ($sort != 'id') {
                                        echo '
                                    <th scope="col" class="px-6 py-3">
                                        <a class="text-blue-800" href="?sort=id&order=asc" id="tieu_de">#</a>
                                    </th>
                                    ';
                                    } else {
                                        if ($order == 'asc') {
                                            echo '
                                    <th scope="col" class="px-6 py-3">
                                        <a class="text-blue-800" href="?sort=id&order=desc" id="tieu_de">#</a>
                                        <i class="fa-solid fa-caret-down"></i>
                                    </th>
                                    ';
                                        } else {
                                            echo '
                                    <th scope="col" class="px-6 py-3">
                                        <a class="text-blue-800" href="?sort=id&order=asc" id="tieu_de">#</a>
                                        <i class="fa-solid fa-caret-up"></i>
                                    </th>
                                    ';
                                        }
                                    }
                                @endphp
                                <th scope="col" class="px-6 py-3">
                                    Ảnh
                                </th>
                                @php
                                    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                    $order = isset($_GET['order']) ? $_GET['order'] : '';
                                    
                                    if ($sort != 'title') {
                                        echo '
                                <th scope="col" class="px-6 py-3">
                                    <a class="text-blue-800" href="?sort=title&order=asc" id="tieu_de">Tiêu đề</a>
                                </th>
                                ';
                                    } else {
                                        if ($order == 'asc') {
                                            echo '
                                    <th scope="col" class="px-6 py-3">
                                        <a class="text-blue-800" href="?sort=title&order=desc" id="tieu_de">Tiêu đề</a>
                                        <i class="fa-solid fa-caret-down"></i>
                                    </th>
                                    ';
                                        } else {
                                            echo '
                                    <th scope="col" class="px-6 py-3">
                                        <a class="text-blue-800" href="?sort=title&order=asc" id="tieu_de">Tiêu đề</a>
                                        <i class="fa-solid fa-caret-up"></i>
                                    </th>
                                    ';
                                        }
                                    }
                                @endphp
                                <th scope="col" class="px-6 py-3">
                                    Cập nhật
                                </th>
                                @php
                                    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                    $order = isset($_GET['order']) ? $_GET['order'] : '';
                                    
                                    if ($sort != 'created_at') {
                                        echo '
                                <th scope="col" class="px-6 py-3">
                                    <a class="text-blue-800" href="?sort=created_at&order=asc" id="tieu_de">Ngày tạo</a>
                                </th>
                                ';
                                    } else {
                                        if ($order == 'asc') {
                                            echo '
                                    <th scope="col" class="px-6 py-3">
                                        <a class="text-blue-800" href="?sort=created_at&order=desc" id="tieu_de">Ngày tạo</a>
                                        <i class="fa-solid fa-caret-down"></i>
                                    </th>
                                    ';
                                        } else {
                                            echo '
                                    <th scope="col" class="px-6 py-3">
                                        <a class="text-blue-800" href="?sort=created_at&order=asc" id="tieu_de">Ngày tạo</a>
                                        <i class="fa-solid fa-caret-up"></i>
                                    </th>
                                    ';
                                        }
                                    }
                                @endphp
                                <th scope="col" class="px-6 py-3">
                                    Tác vụ
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @php
                                $count = ($pages->currentPage() - 1) * $pages->perPage();
                            @endphp
                            @foreach ($pages as $page)
                                @php
                                    $count++;
                                @endphp
                                <tr
                                    class="{{ $loop->iteration % 2 ? 'bg-white' : 'bg-gray-200' }} hover:bg-indigo-200 dark:hover:bg-gray-700">
                                    {{-- <td class="px-6 py-4">
                                        <input class="check_item" type="checkbox" name="list_check[]"
                                            value="{{ $page->id }}">
                                    </td> --}}
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $count }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <img class=" w-24 h-auto"
                                            src="{{ asset('asset/all_pic/') }}/{{ $page->image->link }}" alt="">
                                    </td>
                                    <td class="px-6 py-4">{{ $page->title }}</td>
                                    <td class="px-6 py-4">{{ $page->user->name }}</td>
                                    @php
                                        $new_date = ('App\Helpers\Support')::change_date($page->created_at);
                                    @endphp
                                    <td class="px-6 py-4">{{ $new_date }}</td>
                                    <td class="px-6 py-4 grid grid-cols-2 sm:grid-cols-1 gap-2">
                                        <a href="{{ route('detail_page', $page->id) }}"
                                            class="flex items-center justify-center  px-2 py-1 text-white bg-green-600 rounded hover:bg-green-700"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fa-solid fa-highlighter"></i>
                                        </a>
                                        {{-- <a href="{{ route('delete_page', $page->id) }}"
                                            onclick="return confirm('Bạn có thực sự muốn xoá không?')"
                                            class="flex items-center justify-center  px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="fa-regular fa-trash-can "></i>
                                        </a> --}}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </form>

            <div class="mt-6">
                {{ $pages->links('pagination::tailwind') }}
            </div>
        </div>

        <script>
            let checkall = document.querySelector('.check_list_all')
            let check_items = document.querySelectorAll('.check_item')

            checkall.addEventListener('change', function() {
                check_items.forEach(element => {
                    element.checked = checkall.checked
                });
            })
        </script>
    </div>
@endsection
