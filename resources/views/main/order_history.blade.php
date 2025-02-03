@extends('layouts.main')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="px-4 py-8 sm:px-0">
            <!-- Danh sách đơn hàng -->
            <div class="bg-gradient-to-r from-gray-100 to-white p-1 sm:rounded-lg shadow-md">
                <div class="bg-white overflow-hidden sm:rounded-lg">
                    <div class="p-6 overflow-x-auto">
                        <h2 class="text-3xl font-extrabold mb-6 text-gray-900">Lịch Sử Đơn Hàng </h2>
                        <table class="min-w-full ">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Mã đơn</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Số Lượng Sản Phẩm</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Tổng Giá</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition duration-300 ease-in-out">
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{'#'.str_pad($order->id,4,'0',STR_PAD_LEFT); }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $order->total_item }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ number_format($order->total_price) }} VNĐ</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button hx-get="{{ route('getOrderDetails', $order->id) }}"
                                                hx-target="#orderDetails" hx-trigger="click" id="orderModalTrigger"
                                                class="text-indigo-600 hover:text-indigo-800 transition duration-300 ease-in-out">
                                                <i class="fa-solid fa-eye w-6 h-6 inline-block"></i>
                                                Xem
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="orderModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white p-4 rounded-lg max-w-3xl w-full">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold">Chi Tiết Đơn Hàng</h3>
                <button onclick="closeModal()" class="text-gray-700 font-bold text-lg">&times;</button>
            </div>
            <div id="orderDetails" class="mt-4"></div>
        </div>
    </div>
    <script>
        function closeModal() {
            document.getElementById('orderModal').classList.add('hidden');
        }

        document.addEventListener('htmx:afterRequest', function(event) {
            if (event.target.id === 'orderModalTrigger') {
                document.getElementById('orderModal').classList.remove('hidden');
            }
        });

        // Đóng modal khi nhấp chuột ngoài nó
        document.getElementById('orderModal').addEventListener('click', function(event) {
            // Kiểm tra xem nhấp chuột có nằm ngoài phần tử modal-content không
            if (event.target === this) {
                closeModal();
            }
        });

        // Ngăn chặn sự kiện nổi bọt từ modal-content
        document.querySelector('#orderModal .bg-white').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
@endsection
