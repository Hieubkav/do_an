@extends('layouts.dashboard')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold mb-8 text-gray-800">Tổng Quan </h1>

        <!-- đầu trang -->
        <div class="bg-gradient-to-br from-blue-500 to-indigo-700 text-white rounded my-10">
            <div class="px-8 py-6">
                <h1 class="text-4xl font-bold mb-8">KẾT QUẢ KINH DOANH TRONG NGÀY </h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Doanh Thu -->
                    <div
                        class="bg-white text-gray-800 p-6 rounded-lg shadow-lg card transition-transform transform hover:shadow-2xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Doanh Thu</p>
                                <p class="text-3xl font-bold">
                                    {{ number_format($ordersDay->sum('total_price'), 0, ',', '.') . 'đ' }}
                                </p>
                            </div>
                            <div class="text-green-500 text-4xl">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Đơn Hàng -->
                    <div
                        class="bg-white text-gray-800 p-6 rounded-lg shadow-lg card transition-transform transform hover:shadow-2xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Đơn Hàng</p>
                                <p class="text-3xl font-bold">{{ $ordersDay->count() }}</p>
                            </div>
                            <div class="text-blue-500 text-4xl">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Khách Hàng -->
                    <div
                        class="bg-white text-gray-800 p-6 rounded-lg shadow-lg card transition-transform transform hover:shadow-2xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Khách Hàng</p>
                                <p class="text-3xl font-bold">{{ $ordersDay->count('customer_id') }}</p>
                            </div>
                            <div class="text-purple-500 text-4xl">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Số Sản Phẩm Bán -->
                    <div
                        class="bg-white text-gray-800 p-6 rounded-lg shadow-lg card transition-transform transform hover:shadow-2xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Số Sản Phẩm Bán</p>
                                <p class="text-3xl font-bold">{{ $ordersDay->sum('total_item') }}</p>
                                <!-- Cập nhật số lượng sản phẩm bán tại đây -->
                            </div>
                            <div class="text-green-500 text-4xl">
                                <i class="fas fa-boxes"></i> <!-- Thay đổi biểu tượng nếu muốn -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Doanh thu tháng -->
            <div class="card bg-white p-5 rounded-xl shadow-xl mb-6 lg:mb-0">
                <h2 class="card-title text-2xl font-semibold mb-5">Doanh Thu Tháng</h2>
                <canvas id="monthlyRevenueChart"></canvas>
            </div>

            <!-- Doanh thu tuần -->
            <div class="card bg-white p-5 rounded-xl shadow-xl">
                <h2 class="card-title text-2xl font-semibold mb-5">Doanh Thu Tuần</h2>
                <canvas id="weeklyRevenueChart"></canvas>
            </div>
        </div>

        <!-- -->
        <div class="p-4 my-10 flex justify-center items-center">
            <div class="max-w-lg w-full">
                <h1 class="text-4xl font-extrabold text-gray-800 mb-8 text-center neon-text">Top 3 Khách Hàng Tháng</h1>
                <div class="bg-white shadow-2xl rounded-lg overflow-hidden">
                    @foreach ($topCustomers as $index => $item)
                        <div class="p-6 hover:bg-gray-50 transition duration-300 transform hover:scale-105 hover:shadow-xl">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div
                                        class="rounded-full h-12 w-12 bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center neon-box">
                                        <span class="text-white font-bold">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-xl font-bold text-gray-800">{{ $item->name }}</h2>
                                        <p class="text-sm text-gray-500">{{ $item->address }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-semibold text-green-500">{{ $item->orders->count() }} đơn hàng
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        Tổng tiền: {{ number_format($item->orders->sum('total_price'), 0, ',', '.') . 'đ' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top sản phẩm bán chạy trong tháng -->
        <div
            class="p-8 rounded-lg flex justify-center items-center bg-gradient-to-br from-blue-50 to-cyan-100 relative overflow-hidden">
            <!-- Background Animation -->
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="absolute inset-0 bg-white opacity-5"></div>

            <!-- Main Content -->
            <div class="max-w-7xl mx-auto w-full relative px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-amber-600 mb-16 text-center">
                    Top 5 Sản Phẩm Bán Chạy trong tháng
                </h1>
                <div class="bg-white p-4 rounded-lg overflow-x-auto shadow-2xl ">
                    <ul>
                        @foreach ($list_order_item_size as $item)
                            <li class="transform hover:scale-105 transition duration-300 mb-4 hover:shadow-xl">
                                <div
                                    class="bg-gradient-to-r from-blue-100 to-indigo-100 p-4 rounded-lg flex items-center group">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('asset/all_pic') }}/{{ $item->color_version_size->color_version_image->image }}"
                                            alt="Product"
                                            class="h-20 w-auto object-cover rounded-lg shadow-md transition-transform transform group-hover:scale-110">
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <h2
                                            class="text-xl sm:text-2xl font-bold text-gray-800 group-hover:text-indigo-700 transition-colors">
                                            {{ $item->color_version_size->color_version_image->version->product->name }} -
                                            {{ $item->color_version_size->color_version_image->version->name }} - size
                                            {{ $item->color_version_size->size->name }}
                                        </h2>
                                        <p class="text-lg text-indigo-700 font-semibold">
                                            {{ number_format($item->price, 0, ',', '.') . ' vnd' }}
                                        </p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <div class="text-sm font-bold text-green-600">Tổng bán:
                                            {{ number_format($item->quantity * $item->price, 0, ',', '.') . ' vnd' }}</div>
                                        <div class="text-xs text-indigo-500 mt-1 font-semibold">Số bán:
                                            {{ $item->quantity }}</div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
            var weeklyRevenueCtx = document.getElementById('weeklyRevenueChart').getContext('2d');
            var data_month = @json($data_month);
            var data_week = @json($data_week);

            new Chart(monthlyRevenueCtx, {
                type: 'line', // Loại biểu đồ: đường
                data: {
                    labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'], // Các nhãn trên trục X
                    datasets: [{
                        label: 'Doanh Thu (VND)', // Tên dataset
                        data: data_month, // Dữ liệu (theo tuần)
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Màu nền
                        borderColor: 'rgba(75, 192, 192, 1)', // Màu viền
                        borderWidth: 1 // Độ dày đường viền
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Bắt đầu trục Y từ 0
                        }
                    }
                }
            });
            new Chart(weeklyRevenueCtx, {
                type: 'bar', // Loại biểu đồ: cột
                data: {
                    labels: ['Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy',
                        'Chủ Nhật'
                    ], // Các nhãn trên trục X
                    datasets: [{
                        label: 'Doanh Thu (VND)', // Tên dataset
                        data: data_week, // Dữ liệu (theo ngày)
                        backgroundColor: 'rgba(255, 99, 132, 0.2)', // Màu nền
                        borderColor: 'rgba(255, 99, 132, 1)', // Màu viền
                        borderWidth: 1 // Độ dày đường viền
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Bắt đầu trục Y từ 0
                        }
                    }
                }
            });
        });
    </script>
@endsection
