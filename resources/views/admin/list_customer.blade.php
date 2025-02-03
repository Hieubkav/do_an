@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto p-6 min-h-screen">
        <div class="bg-white bcustomer bcustomer-gray-300 rounded shadow-lg p-6">

            <!-- Header -->
            <h5 class="block py-3 text-3xl font-bold text-gray-700 mb-4 md:mb-0">Danh sách khách hàng</h5>
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">

                <form action="#" method="GET" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                
                    <!-- Input để nhập mã khách hàng -->
                    <input type="text" value="{{$keyword}}" name="keyword" placeholder="Tìm tên khách" class="bcustomer rounded-md p-2 bg-white shadow-sm focus:bcustomer-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none w-full md:w-auto">
                
                    <!-- Nút tìm kiếm -->
                    <button type="submit" class="bg-indigo-600 text-white p-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:bcustomer-indigo-700 w-full md:w-auto">Tìm kiếm</button>
                
                </form>
                

            </div>

            <!-- Main Content -->
            <form action="{{ url('/admin/customer/action') }}" method="POST">
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
                                
                                <th scope="col" class="px-6 py-3">
                                    Stt
                                </th>
                                @php
                                    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                                    $customer = isset($_GET['customer']) ? $_GET['customer'] : '';

                                    if ($sort != 'title') {
                                        echo '
                                        <th scope="col" class="px-6 py-3">
                                            <a class="text-blue-800" href="?sort=title&customer=asc" id="tieu_de">Tên</a>
                                        </th>
                                        ';
                                    } else {
                                        if ($customer == 'asc') {
                                            echo '
                                            <th scope="col" class="px-6 py-3">
                                                <a class="text-blue-800" href="?sort=title&customer=desc" id="tieu_de">Tên</a>
                                                <i class="fa-solid fa-caret-down"></i>
                                            </th>
                                            ';
                                        } else {
                                            echo '
                                            <th scope="col" class="px-6 py-3">
                                                <a class="text-blue-800" href="?sort=title&customer=asc" id="tieu_de">Tên</a>
                                                <i class="fa-solid fa-caret-up"></i>
                                            </th>
                                            ';
                                        }
                                    }
                                @endphp

                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Số điện thoại
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Địa chỉ
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Số đơn mua 
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Tổng tiền mua 
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Tác vụ
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @php
                                $count = ($customers->currentPage() - 1) * $customers->perPage();
                            @endphp
                            @foreach ($customers as $customer)
                                @php
                                    $count++;
                                @endphp
                                <tr
                                    class="{{ $loop->iteration % 2 ? 'bg-white' : 'bg-gray-100' }} hover:bg-indigo-100 dark:hover:bg-gray-800 transition-colors">
                                    <th scope="row"
                                        class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $count }}
                                    </th>
                                    <td class="px-6 py-3">{{$customer->name}}</td>
                                    <td class="px-6 py-4">
                                        {{$customer->email}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$customer->phone}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$customer->address}}
                                    </td>
                                    <td class="px-6 py-3">{{ $customer->orders->count() }}</td>
                                    <td class="px-6 py-3">{{ number_format($customer->orders->sum('total_price'), 0, ',', '.') . ' vnd' }}
                                    </td>
                                    <td class="px-6 py-3 grid grid-cols-2 sm:grid-cols-1 gap-2">
                                        <a href="{{route('list_order',['customer_name'=>$customer->id])}}" title="Xem chi tiết" class="flex items-center justify-center px-2 py-1 text-white bg-green-500 rounded hover:bg-green-600 transition-colors">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </form>

            <div class="mt-6">
                {{ $customers->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

@endsection
