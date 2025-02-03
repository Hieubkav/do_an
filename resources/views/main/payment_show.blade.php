@extends('layouts.main')

@section('content')
    <form id="payment-form" class="container mx-auto px-4 py-8" method="POST"
        action="{{ route('payment_momo_qr', ['customer_id' => $customer->id]) }}">
        @csrf
        <!-- Phần Grid: 1. Thông tin vận chuyển & thanh toán + Giỏ hàng. 2. Bảo mật và quy định + Tổng hợp -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Cột 1: Thông tin vận chuyển & Giỏ hàng -->
            <div class="col-span-1 bg-white p-6 shadow-md rounded-lg">
                <!-- Thông tin vận chuyển -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">
                        Thông tin vận chuyển
                        <div class="italic text-cyan-500 text-sm">(Lấy từ thông tin tài khoản)</div>
                    </h2>
                    <div class="space-y-4">
                        <div class="relative">
                            <i class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-user"></i>
                            </i>
                            <input value="{{ $customer->name }}" name="name" type="text" placeholder="Họ và tên"
                                class="w-full p-2 pl-10 border rounded">
                            @error('name')
                                <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="relative">
                            <i class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-map-marker-alt"></i>
                            </i>
                            <input value="{{ $customer->address }}" name="address" type="text" placeholder="Địa chỉ"
                                class="w-full p-2 pl-10 border rounded">
                            @error('address')
                                <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="relative">
                            <i class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-phone"></i>
                            </i>
                            <input value="{{ $customer->phone }}" name="phone" type="text" placeholder="Số điện thoại"
                                class="w-full p-2 pl-10 border rounded">
                            @error('phone')
                                <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="relative">
                            <i class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </i>
                            <input value="{{ $customer->email }}" name="email" type="email" placeholder="Email"
                                class="w-full p-2 pl-10 border rounded">
                            @error('email')
                                <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>


                <!-- Tuỳ chọn thanh toán -->
                <style>
                    .payment-option:checked+label {
                        background-color: #f7f9fc;
                        border-color: #3182ce;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    }
                </style>
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Tuỳ chọn thanh toán</h2>
                    <div class="flex space-x-4">

                        <!-- MOMO -->
                        <input type="radio" id="momo-option" class="form-radio payment-option hidden"
                            name="payment_option" value="momo" checked>
                        <label for="momo-option"
                            class="flex items-center space-x-2 p-4 border-2 border-gray-300 rounded-lg cursor-pointer transition hover:shadow-md">
                            <img class="text-blue-500 text-2xl"
                                src="https://payment.momo.vn/v2/gateway/images/logo-momo-3b8deb874c6d3b77f976f35310d8e50a.png"
                                alt="momo">
                            <span class="text-lg font-medium text-gray-600">MOMO</span>
                        </label>

                        <!-- ATM -->
                        <input type="radio" id="atm-option" class="form-radio payment-option hidden" name="payment_option"
                            value="atm">
                        <label for="atm-option"
                            class="flex items-center space-x-2 p-4 border-2 border-gray-300 rounded-lg cursor-pointer transition hover:shadow-md">
                            <i class="fa-solid fa-credit-card text-emerald-600 text-2xl "></i>
                            <span class="text-lg font-medium text-gray-600">ATM</span>
                        </label>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const paymentForm = document.getElementById('payment-form');
                        const momoOption = document.getElementById('momo-option');
                        const atmOption = document.getElementById('atm-option');

                        momoOption.addEventListener('change', function() {
                            if (this.checked) {
                                paymentForm.action = "{{ route('payment_momo_qr', ['customer_id' => $customer->id]) }}";
                            }
                        });

                        atmOption.addEventListener('change', function() {
                            if (this.checked) {
                                paymentForm.action =
                                    "{{ route('payment_momo_atm', ['customer_id' => $customer->id]) }}";
                            }
                        });
                    });
                </script>


                <!-- Bảo mật và quy định -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Bảo mật và quy định</h2>
                    <ul class="list-disc pl-5">
                        <li class="mb-2">
                            <a href="#" class="text-blue-500 hover:underline">Chính sách bảo mật</a>: Chúng tôi cam
                            kết bảo mật thông tin cá nhân của bạn.
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-blue-500 hover:underline">Chính sách đổi trả</a>: Đổi trả sản phẩm
                            trong vòng 30 ngày.
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-blue-500 hover:underline">Điều khoản và điều kiện</a>: Các điều
                            khoản sử dụng dịch vụ của chúng tôi.
                        </li>
                    </ul>
                </div>


            </div>

            <!-- Cột 2: Bảo mật và quy định + Tổng hợp -->
            <div class="col-span-1 space-y-8">
                <!-- Giỏ hàng -->
                <div class="col-span-1 lg:col-span-2 bg-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-4">Giỏ hàng</h2>

                    <ul class="space-y-6">
                        @foreach ($cart_items as $item)
                            <li class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-md transition">
                                <div class="flex items-center">
                                    <img src="{{ asset('asset/all_pic/') }}/{{ $item->colorversionsize->color_version_image->image }}"
                                        alt="Tên sản phẩm"
                                        class="w-24 h-24 object-cover rounded-lg shadow-lg flex-shrink-0">

                                    <div class="ml-6 flex-1">
                                        <h3 class="text-lg font-medium text-gray-800">
                                            {{ $item->colorversionsize->color_version_image->version->product->name }} -
                                            {{ $item->colorversionsize->color_version_image->version->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">Giá/sản phẩm:
                                            {{ number_format($item->price) }} ₫</p>
                                    </div>

                                    <div class="ml-auto text-right">
                                        <p class="text-lg font-semibold text-gray-700">
                                            {{ number_format($item->quantity * $item->price) }} ₫</p>
                                        <p class="text-sm text-gray-600 mt-1">Số lượng: x{{ $item->quantity }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tổng hợp -->
                <div class="col-span-1 bg-white p-6 shadow-lg rounded-lg">
                    <h2 class="text-2xl font-semibold mb-6 text-gray-700 border-b pb-4">Tổng hợp</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Tổng tiền:</span>
                            <span class="text-lg text-gray-700 font-medium">{{ number_format($cart->total_price) }}
                                ₫</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Tổng số món:</span>
                            <span class="text-lg text-gray-700 font-medium">{{ $cart->total_item }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Tiền ship:</span>
                            <span class="text-lg text-gray-700 font-medium">{{ number_format($shipping) }} ₫</span>
                        </div>
                        <div class="flex justify-between my-4 border-t pt-4">
                            <span class="text-lg text-gray-800">Tổng cộng:</span>
                            <span
                                class="text-2xl text-gray-900 font-semibold">{{ number_format($shipping + $cart->total_price) }}
                                ₫</span>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-8 rounded-full shadow-md hover:shadow-lg transition">
                            Tiến hành thanh toán
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </form>
@endsection
