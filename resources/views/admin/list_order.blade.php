@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto p-6 min-h-screen">
        <div class="bg-white border border-gray-300 rounded shadow-lg p-6">

            <!-- Header -->
            <h5 class="block py-3 text-3xl font-bold text-gray-700 mb-4 md:mb-0">Danh sách đơn hàng</h5>
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">

                <form action="#" method="GET" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">

                    <!-- Dropdown selector cho tên khách hàng -->
                    <select name="customer_name" class="border rounded-md p-2 bg-white shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none w-full md:w-auto">
                        <option value="">Chọn khách hàng :</option>
                        @foreach($customers as $item)
                            <option 
                                @php
                                    if($item->id==$customer) echo "selected";
                                @endphp
                                value="{{ $item->id }}">
                                {{ $item->name }}
                        </option>
                        @endforeach
                    </select>
                
                    <!-- Input để nhập mã đơn hàng -->
                    <input type="text" value="{{$keyword}}" name="order_code" placeholder="Nhập mã đơn hàng" class="border rounded-md p-2 bg-white shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none w-full md:w-auto">
                
                    <!-- Nút tìm kiếm -->
                    <button type="submit" class="bg-indigo-600 text-white p-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-700 w-full md:w-auto">Tìm kiếm</button>
                
                </form>
                

            </div>

            <!-- Main Content -->
            <form action="{{ url('/admin/order/action') }}" method="POST">
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
                                @php
                                    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                    $order = isset($_GET['order']) ? $_GET['order'] : '';

                                    if ($sort != 'id') {
                                        echo '
                                        <th scope="col" class="px-6 py-3">
                                            <a class="text-blue-800" href="?sort=id&order=asc" id="thu_tu">#</a>
                                        </th>
                                        ';
                                    } else {
                                        if ($order == 'asc') {
                                            echo '
                                            <th scope="col" class="px-6 py-3">
                                                <a class="text-blue-800" href="?sort=id&order=desc" id="thu_tu">#</a>
                                                <i class="fa-solid fa-caret-down"></i>
                                            </th>
                                            ';
                                        } else {
                                            echo '
                                            <th scope="col" class="px-6 py-3">
                                                <a class="text-blue-800" href="?sort=id&order=asc" id="thu_tu">#</a>
                                                <i class="fa-solid fa-caret-up"></i>
                                            </th>
                                            ';
                                        }
                                    }
                                @endphp

                                @php
                                    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                    $order = isset($_GET['order']) ? $_GET['order'] : '';

                                    if ($sort != 'title') {
                                        echo '
                                        <th scope="col" class="px-6 py-3">
                                            <a class="text-blue-800" href="?sort=title&order=asc" id="tieu_de">Mã đơn</a>
                                        </th>
                                        ';
                                    } else {
                                        if ($order == 'asc') {
                                            echo '
                                            <th scope="col" class="px-6 py-3">
                                                <a class="text-blue-800" href="?sort=title&order=desc" id="tieu_de">Mã đơn</a>
                                                <i class="fa-solid fa-caret-down"></i>
                                            </th>
                                            ';
                                        } else {
                                            echo '
                                            <th scope="col" class="px-6 py-3">
                                                <a class="text-blue-800" href="?sort=title&order=asc" id="tieu_de">Mã đơn</a>
                                                <i class="fa-solid fa-caret-up"></i>
                                            </th>
                                            ';
                                        }
                                    }
                                @endphp

                                <th scope="col" class="px-6 py-3">
                                    Trạng thái
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Số lượng
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Tổng tiền
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Khách mua
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Tác vụ
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @php
                                $count = ($orders->currentPage() - 1) * $orders->perPage();
                            @endphp
                            @foreach ($orders as $order)
                                @php
                                    $count++;
                                @endphp
                                <tr
                                    class="{{ $loop->iteration % 2 ? 'bg-white' : 'bg-gray-100' }} hover:bg-indigo-100 dark:hover:bg-gray-800 transition-colors">
                                    <td class="px-6 py-3">
                                        <input class="check_item form-checkbox text-indigo-600 transition-colors"
                                            type="checkbox" name="list_check[]" value="{{ $order->id }}">
                                    </td>
                                    <th scope="row"
                                        class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $count }}
                                    </th>
                                    <td class="px-6 py-3">{{ '#' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-4">
                                        @if ($order->status == 'done')
                                            <div class="flex items-center justify-start space-x-2 text-green-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2l4 -4"></path>
                                                </svg>
                                                <span class="font-semibold">Hoàn thành</span>
                                            </div>
                                        @else
                                            <div class="flex items-center justify-start space-x-2 text-yellow-500">
                                                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19.428 14.963A8.001 8.001 0 1 0 12 20.001v-2.001a6.001 6.001 0 1 1 6.001-6.001h2.427z">
                                                    </path>
                                                </svg>
                                                <span class="font-semibold">Đang chờ</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3">{{ $order->total_item }}</td>
                                    <td class="px-6 py-3">{{ number_format($order->total_price, 0, ',', '.') . ' vnd' }}
                                    </td>
                                    <td class="px-6 py-3">{{ $order->customer->name }}</td>
                                    <td class="px-6 py-3 grid grid-cols-2 sm:grid-cols-1 gap-2">
                                        <button hx-get="{{ route('detail_order', $order->id) }}" hx-trigger="click"
                                            hx-target="#modal-content" hx-indicator="#loadingIndicator"
                                            class="flex items-center justify-center px-2 py-1 text-white bg-green-500 rounded hover:bg-green-600 transition-colors"
                                            type="button" title="Xem chi tiết">
                                            <i class="fa-solid fa-highlighter"></i>
                                        </button>


                                        <a href="{{ route('delete_order', $order->id) }}"
                                            onclick="return confirm('Bạn có thực sự muốn xoá không?')"
                                            class="flex items-center justify-center px-2 py-1 text-white bg-red-500 rounded hover:bg-red-600 transition-colors"
                                            type="button" title="Xóa đơn hàng">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </form>

            <div class="mt-6">
                {{ $orders->links('pagination::tailwind') }}
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

    <!-- Modal container -->
    <div id="detailModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
        <div class="bg-white  h-3/4 overflow-y-auto rounded-xl shadow-2xl p-6 relative">
            <!-- Close button at the top right of the modal -->
            <button onclick="document.getElementById('detailModal').style.display = 'none';"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <!-- Content will be loaded here via AJAX -->
            <div id="modal-content">
                <!-- AJAX Content -->
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        Loading...
    </div>
    <script>
        document.body.addEventListener('htmx:afterSettle', function(event) {
            if (event.target.id === 'modal-content') {
                document.getElementById('detailModal').style.display = 'flex';
            }
        });

        var modal = document.getElementById('detailModal');
        var modalContent = document.getElementById('modal-content');

        document.getElementById('detailModal').addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Để ngăn chặn sự kiện click trên nội dung modal lan truyền ra ngoài và tắt modal
        modalContent.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
@endsection
