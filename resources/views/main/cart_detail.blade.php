@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-6">
        <h1
            class="text-4xl font-extrabold text-gray-900 mb-8 border-b-4 pb-2 border-gray-300 hover:text-gray-700 transition-all duration-300">
            Giỏ hàng
        </h1>
        @if (!$cart->cart_items->isEmpty())
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <!-- Danh sách sản phẩm -->
                <div class="space-y-8">
                    @foreach ($cart->cart_items as $cart_item)
                        <div
                            class="flex flex-col sm:flex-row items-start p-6 bg-white border rounded-lg shadow-lg transition-transform transform hover:scale-105">
                            <img src="{{ asset('asset/all_pic/') }}/{{ $cart_item->colorversionsize->color_version_image->image }}"
                                alt="ảnh sản phẩm trong giỏ" class="w-full sm:w-1/4 rounded-lg shadow-inner mr-8 mb-4 sm:mb-0">
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h2 class="text-2xl font-semibold text-blue-700">
                                        <a
                                            href="{{ route('product_webpage_detail', $cart_item->colorversionsize->color_version_image->version->product->id) }}">
                                            {{ $cart_item->colorversionsize->color_version_image->version->product->name }}
                                            - {{ $cart_item->colorversionsize->color_version_image->version->name }}
                                        </a>
                                    </h2>
                                    <a href="{{ route('delete_cart', $cart_item->id) }}"
                                        class="text-red-500 hover:text-red-600 transition-colors duration-300">
                                        Xoá sản phẩm
                                    </a>
                                </div>
                                <p class="text-lg text-gray-600">
                                    Kích thước: {{ $cart_item->colorversionsize->size->name }}
                                </p>
                                <p class="text-lg text-gray-600">Màu sắc:
                                    {{ $cart_item->colorversionsize->color_version_image->color->name }}</p>
                                <div class="flex items-center justify-between mt-4 ">
                                    <span class="text-xl text-gray-900 font-semibold">{{ number_format($cart_item->price) }}
                                        VND</span>
                                    <div class="flex items-center space-x-4">
                                        <input type="number" value="{{ $cart_item->quantity }}"
                                            data-cart-item-id="{{ $cart_item->id }}"
                                            class="quantity-input border rounded-md w-20 p-2 text-center text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                                        <span data-cart-item-all="{{ $cart_item->id }}"
                                            class="text-xl text-gray-900 font-semibold">
                                            {{ number_format($cart_item->price * $cart_item->quantity) }} VND
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Thông tin tổng kết giỏ hàng -->
                <div class="">
                    <div class="bg-white p-6 border rounded-lg shadow-md ">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 pb-4 border-gray-300">Tổng kết giỏ hàng
                        </h2>
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-lg text-gray-700 font-medium">Tổng số lượng sản phẩm:</span>
                                <span class="text-lg text-gray-900" id="totalQuantity">{{ $totalQuantity }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-lg text-gray-700 font-medium">Tổng tiền:</span>
                                <span class="text-lg text-gray-900" id="totalPrice">{{ number_format($totalPrice) }}
                                    VND</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-lg text-gray-700 font-medium">Tiền ship:</span>
                                <span class="text-lg text-gray-900" id="shipping"
                                    data-ship="{{ $shipping }}">{{ number_format($shipping) }} VND</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold">
                                <span class="text-gray-800">Tổng cộng:</span>
                                <span class="text-gray-900" id="grandTotal">{{ number_format($grandTotal) }} VND</span>
                            </div>
                        </div>
                        <a href="{{ route('payment_show') }}"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg shadow-md transition-all duration-300">
                            Thanh toán
                        </a>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <a href="/" class="text-blue-600 hover:text-blue-700 transition-colors duration-300">
                            Tiếp tục mua hàng
                        </a>

                    </div>
                </div>

            </div>
        @else
            <div class="flex items-center justify-center  bg-gray-100 p-4">
                <div class="max-w-lg w-full bg-white rounded-lg shadow-lg p-8">
                    <div class="flex flex-col items-center">
                        <!-- Icon giỏ hàng -->
                        <div class="p-4 bg-indigo-100 rounded-full">
                            <img class="h-64 w-64 text-indigo-500" alt=""
                                src="{{ asset('asset/local/empty_cart.svg') }}">
                        </div>

                        <!-- Tiêu đề và thông báo -->
                        <h2 class="mt-4 text-2xl font-extrabold text-gray-800">Giỏ Hàng Của Bạn Đang Trống</h2>

                        <!-- Nút tiếp tục mua sắm -->
                        <a href="{{route('store_front')}}"
                            class="mt-6 px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-300 ease-in-out">Tiếp
                            Tục Mua Sắm
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var quantityInputs = document.querySelectorAll('.quantity-input');
            quantityInputs.forEach(input => {
                input.addEventListener('change', handleQuantityChange);
            });
        });

        function handleQuantityChange(e) {
            var cartItemId = e.target.getAttribute('data-cart-item-id');
            var correspondingSpan = document.querySelector(`span[data-cart-item-all="${cartItemId}"]`);
            var cartItemLimit = e.target.getAttribute('data-cart-limit');
            var newQuantity = e.target.value;
            var shipping = document.querySelector('#shipping').dataset.ship;


            // Check if newQuantity is 0 and prompt user
            if (newQuantity == 0) {
                var isConfirmed = confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');
                if (isConfirmed) {
                    // Redirect to delete route
                    window.location.href = `{{ route('delete_cart', ['cart_item_id' => 'PLACEHOLDER']) }}`.replace(
                        'PLACEHOLDER', cartItemId);
                    return;
                } else {
                    // Reset value to 1 or old value
                    e.target.value = 1; // or previous value
                    return;
                }
            }

            // Send fetch request
            fetch(`{{ route('update_cart') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: new URLSearchParams({
                        cartItemId: cartItemId,
                        quantity: parseInt(newQuantity),
                        shipping: parseInt(shipping),
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        correspondingSpan.innerHTML = data.new_all_price;
                        document.querySelector('#totalQuantity').innerHTML = data.cart_quantity;
                        document.querySelector('#totalPrice').innerHTML = data.all_price;
                        document.querySelector('#grandTotal').innerHTML = data.grandTotal;
                        document.querySelector('#total_cart_show_quantity').innerHTML = data.cart_quantity
                    } else {
                        customAlert("Bạn đã thêm vượt quá số lượng");
                        e.target.value = data.quantity;
                    }

                })
        }
    </script>

    <!-- Cảnh báo (ban đầu ẩn)- Customer Alert -->
    <div id="customAlert"
        class="fixed top-0 left-0 w-full h-full flex items-center justify-center transition-opacity duration-300"
        style="display: none; background-color: rgba(0, 0, 0, 0.5);">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-lg mx-4 md:mx-0">
            <div class="p-6">
                <p id="alertMessage" class="text-xl font-medium mb-4">Đây là nội dung cảnh báo</p>
                <div class="text-right">
                    <button
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                        onclick="closeAlert()">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- -->
    
@endsection
