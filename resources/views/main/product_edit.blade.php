@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">

            <!-- Main Image -->
            <div class="w-full md:w-1/2 flex flex-col items-center bg-white">
                <div class="container w-full overflow-hidden bg-white">
                    <img id="mainImage"
                        class="image w-full h-96  transition-transform duration-500 ease-in-out transform hover:scale-150"
                        src="{{ asset('asset/all_pic') }}/{{ reset($list_pic)->image }}" alt="Zoom Image">
                </div>
                {{-- <img id="mainImage" src="{{ asset('asset/all_pic') }}/{{ reset($list_pic)->image }}" alt="Mắt kính chính"
                    class="w-full h-96 object-cover rounded-lg shadow-lg"> --}}

                <style>
                    .image {
                        transition: transform 0.1s ease, transform-origin 0.1s ease;
                        /* Cập nhật thời gian chuyển đổi */
                        will-change: transform;
                        /* Tối ưu hóa hiệu suất cho thuộc tính transform */
                    }
                </style>
                <script>
                    <script>
                    let frame;
                    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                    const mainImage = document.getElementById('mainImage');
                    const scale = isMobile ? 1.2 : 1.5; // Điều chỉnh tỷ lệ phóng to tùy theo thiết bị

                    const handleMouseMove = (e) => {
                        if (frame) {
                            cancelAnimationFrame(frame);
                        }

                        frame = requestAnimationFrame(() => {
                            const rect = e.target.getBoundingClientRect();
                            const x = (e.clientX || e.touches[0].clientX) - rect.left;
                            const y = (e.clientY || e.touches[0].clientY) - rect.top;

                            e.target.style.transformOrigin = `${x}px ${y}px`;
                            e.target.style.transform = `scale(${scale})`;
                        });
                    };

                    const handleMouseLeave = (e) => {
                        cancelAnimationFrame(frame);
                        e.target.style.transform = 'scale(1)';
                        e.target.style.transformOrigin = 'center center';
                    };

                    mainImage.addEventListener(isMobile ? 'touchmove' : 'mousemove', handleMouseMove);
                    mainImage.addEventListener(isMobile ? 'touchend' : 'mouseleave', handleMouseLeave);
                </script>
                </script>

                <!-- Add Pagination if needed -->
                <div class="swiper-pagination relative top-0"></div>
                <!-- Thumbnails with Swiper -->
                <div class="mt-6 w-full">
                    <div class="swiper-container">
                        <div class="swiper-wrapper overflow-x-hidden">
                            @foreach ($list_pic as $item)
                                <div class="swiper-slide">
                                    <img onclick='changeImage("{{ asset('asset/all_pic') }}/{{ $item->image }}")'
                                        data-image_id = "{{ $item->id }}"
                                        src="{{ asset('asset/all_pic') }}/{{ $item->image }}" alt="Ảnh sản phẩm 1"
                                        class="w-full h-24 object-cover rounded-lg shadow cursor-pointer hover:opacity-80">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button onclick="openModal()"
                    class="mt-4 bg-blue-500 text-white py-1 px-4 rounded-full hover:bg-blue-600 transition duration-300">Xem
                    toàn bộ ảnh</button>
            </div>

            <!-- Phần thông tin sản phẩm -->
            <div class="w-full md:w-1/2 space-y-8 bg-white p-8 rounded-lg shadow-xl border border-gray-200">
                <h1 class="text-4xl font-bold text-gray-800">{{ $product->name }}</h1>

                @php
                    $change_vnd = App\Helpers\Support::change_vnd($product->price);
                @endphp
                <span class="text-3xl text-red-600 font-bold">{{ $change_vnd }}</span>

                <div class="space-y-4">
                    <div>
                        <label for="color" class="block text-lg text-gray-700 mb-2">Màu sắc:</label>
                        <select id="color"
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-transparent">
                            <option>Chọn màu sắc: </option>
                            @foreach ($versions as $item)
                                <option data-color_id="{{ $item->color_id }}"
                                    data-image_id="{{ $item->colorversionimages->where('color_id', $item->color_id)->first()->id }}">
                                    {{ $item->color->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="size" class="block text-lg text-gray-700 mb-2">Size:</label>
                        <select id="size"
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-transparent">
                            <option>Chọn size: </option>
                            @foreach ($list_size as $item)
                                <option data-image_id="{{ $item->color_version_image_id }}"
                                    data-size_id="{{ $item->id }}">
                                    {{ $item->size->name }}--số lượng : {{ $item->quantity }} cái
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="flex items-center space-x-4">
                        <label for="quantity" class="text-lg text-gray-700">Số lượng:</label>
                        <input type="number" id="quantity"
                            class="w-24 p-2 border rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-transparent"
                            value="1">
                    </div>
                </div>

                @if ($product->quantity == 0)
                    <button disabled
                        class="w-full py-3 bg-gray-400 text-white font-semibold rounded-lg hover:bg-gray-500 cursor-not-allowed transition-all duration-300 transform hover:scale-95 shadow-inner">
                        Hết hàng
                    </button>
                @else
                    <!-- Check đăng nhập -->
                    @if (Auth::guard('customer')->check())
                        <button id="add_to_cart"
                            class="w-full py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-all duration-300 transform hover:scale-105 shadow-md">
                            Thêm vào giỏ hàng
                        </button>
                    @else
                        <a href="{{ route('customer_login') }}">
                            <button
                                class="w-full py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-all duration-300 transform hover:scale-105 shadow-md">
                                Thêm vào giỏ hàng
                            </button>
                        </a>
                    @endif
                @endif

            </div>

        </div>

        <!-- Mô tả sản phẩm -->
        <div class="mt-12 space-y-8 bg-white p-8 rounded-lg shadow-xl border border-gray-200">
            <div class="border-b-2 pb-2">
                <h2 class="text-3xl font-bold text-gray-800">Mô tả sản phẩm:</h2>
            </div>
            <p class="text-lg text-gray-700 leading-relaxed italic">
                @php
                    echo $product->des;
                @endphp
            </p>

            <div class="border-b-2 pb-2 mt-6">
                <h2 class="text-3xl font-bold text-gray-800">Thông số kỹ thuật:</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-tag text-xl text-gray-600"></i>
                    <span class="text-lg text-gray-700">Thương hiệu: {{ $product->brand->name }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-venus-mars text-xl text-gray-600"></i>
                    <span class="text-lg text-gray-700">Giới tính: {{ $sex }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-cogs text-xl text-gray-600"></i>
                    <span class="text-lg text-gray-700">Chất liệu: {{ $product->material->name }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-glasses text-xl text-gray-600"></i>
                    <span class="text-lg text-gray-700">Hình dạng mặt kính: {{ $product->shape->name }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-map-marker-alt text-xl text-gray-600"></i>
                    <span class="text-lg text-gray-700">Xuất xứ: {{ $product->source->name }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-ruler-vertical text-xl text-gray-600"></i>
                    <span class="text-lg text-gray-700">Ve kính: {{ $nose_tick }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-palette text-xl text-gray-600"></i>
                    <span class="text-lg text-gray-700">Phong cách thiết kế: {{ $product->design->name }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex justify-center items-center">
        <div class="bg-white rounded-lg p-4 max-w-6xl w-full h-5/6 overflow-y-auto relative">
            <button onclick="closeModal()" class="absolute top-2 right-2 text-black hover:text-gray-600">&times;</button>

            <!-- Danh sách ảnh -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($list_pic as $item)
                    <div class="swiper-slide">
                        <img src="{{ asset('asset/all_pic') }}/{{ $item->image }}" alt="Ảnh sản phẩm 1"
                            class="w-full object-cover rounded-lg shadow">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        const modal = document.getElementById('myModal');

        function openModal() {
            modal.style.display = 'flex';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

    <script>
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }

        // Khởi tạo Swiper
        const swiper = new Swiper('.swiper-container', {
            slidesPerView: 4, // số ảnh hiển thị cùng một lúc
            spaceBetween: 10, // khoảng cách giữa các ảnh
            loop: true, // cho phép lặp lại ảnh khi kéo đến cuối danh sách
            freeMode: false, // tắt chế độ tự do kéo
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>

    <!--  đổi màu=> đổi hình -->
    <script>
        document.getElementById('color').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const imageId = selectedOption.getAttribute('data-image_id');

            // Tìm ảnh trong danh sách ảnh nhỏ dựa trên data-image_id
            const correspondingImage = document.querySelector(`img[data-image_id="${imageId}"]`);

            if (correspondingImage) {
                // Thay đổi hình ảnh chính
                document.getElementById('mainImage').src = correspondingImage.src;
            }

            // Cập nhật danh sách size dựa trên data-image_id
            const sizeSelect = document.getElementById('size');
            for (let i = 0; i < sizeSelect.options.length; i++) {
                const sizeOption = sizeSelect.options[i];
                const sizeImageId = sizeOption.getAttribute('data-image_id');
                if (sizeImageId === imageId || !sizeImageId) {
                    // Hiển thị các option có data-image_id tương ứng hoặc không có data-image_id (ví dụ: "Chọn size")
                    sizeOption.style.display = "";
                } else {
                    // Ẩn các option không tương ứng
                    sizeOption.style.display = "none";
                }
            }
            // Đặt lại giá trị mặc định cho select size
            sizeSelect.value = "Chọn size: ";
        });
    </script>

    <!-- AJAX -->
    <script>
        document.querySelector('#add_to_cart').addEventListener('click', function() {
            var sizeSelect = document.getElementById('size');
            var selectedSizeOption = sizeSelect.options[sizeSelect.selectedIndex];
            var selectedSizeId = selectedSizeOption.dataset.size_id;

            var colorSelect = document.getElementById('color');
            var selectedColorOption = colorSelect.options[colorSelect.selectedIndex];
            var selectedColorId = selectedColorOption.dataset.color_id;
            var quantityInput = document.getElementById('quantity');
            var desiredQuantity = parseInt(quantityInput.value);

            fetch("{{ route('cart_add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        size_id: selectedSizeId,
                        color_id: selectedColorId,
                        lay_them: desiredQuantity,
                    })
                })
                .then(response => response.json()) // đọc dữ liệu nhận được dưới dạng json
                .then(data => {
                    if (data.status === 'success') {
                        customAlert("Thêm vào giỏ thành công");
                        location.reload();
                    } else customAlert(data.message);
                })
        });
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
