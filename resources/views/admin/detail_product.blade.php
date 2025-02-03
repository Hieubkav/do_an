@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto p-6 min-h-screen">
        <div class="bg-white border border-gray-300 rounded shadow-lg p-6">

            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h5 class="text-3xl font-bold text-gray-700 mb-4 md:mb-0">Chỉnh sửa sản phẩm</h5>
                <div class="flex space-x-4">
                    {{-- <a href="{{ route('list_version', $product->id) }}"
                        class="bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded focus:outline-none">
                        <i class="fa-solid fa-list"></i>
                    </a> --}}
                    <a href="" class="bg-green-500 hover:bg-green-700 text-black py-2 px-4 rounded focus:outline-none">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                </div>
            </div>

            <!-- Form -->
            <form id="myForm" action="{{ route('update_product', $product->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- Product Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-500 font-bold mb-2">Tên sản phẩm</label>
                    <input class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                        type="text" name="name" id="name" value="{{ $product->name }}">
                    @error('name')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Product Price -->
                <div class="mb-4">
                    <label for="price" class="block text-gray-500 font-bold mb-2">Giá (vnd)</label>
                    <input type="hidden" id="actualPrice" name="price" value="{{ $product->price }}">
                    <input id="numberInput"
                        class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                        type="text" id="price" value="{{ $product->price }}">
                    @error('price')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Additional Product Info -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- Quantity -->
                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-500 font-bold mb-2">Tổng số lượng</label>
                        <input
                            class="w-full py-2 px-3 bg-gray-100 text-green-700 border border-gray-300 rounded focus:outline-none"
                            type="text" name="quantity" id="quantity" value="{{ $product->versions->sum('quantity') }}"
                            readonly>
                        @error('quantity')
                            <div class="mt-2 text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Version Count -->
                    <div class="mb-4">
                        <label for="count_ver" class="block text-gray-500 font-bold mb-2">Tổng phiên bản</label>
                        <input
                            class="w-full py-2 px-3 bg-gray-100 text-green-700 border border-gray-300 rounded focus:outline-none"
                            type="text" name="count_ver" id="count_ver" value="{{ $product->versions->count() }}"
                            readonly>
                        @error('count_ver')
                            <div class="mt-2 text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Danh mục -->
                <div class="mb-4 z-10">

                    <label for="category" class="block mb-1">Danh mục</label>
                    <div class="relative">
                        <select id="category" name="category[]"
                            class="choices-multiple-selection w-full py-2 px-3 text-black border bg-gray-50 border-gray-300 rounded max-h-48 overflow-y-auto"
                            multiple="multiple">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                    @if ($category->products()->wherePivot('product_id', $product->id)->exists()) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @error('category')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                    <script>
                        const choices = new Choices('.choices-multiple-selection', {
                            removeItemButton: true,
                        });
                    </script>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
                    <!-- Thương hiệU -->
                    <div class="mb-4 p-4 bg-gradient-to-r from-indigo-400 to-blue-500 rounded-lg shadow-2xl transform transition-transform  hover:shadow-3xl perspective-1500">
                        <!-- Label with subtle animation -->
                        <div class="flex justify-between items-center mb-4">
                            <label for="brand"
                                class="text-white font-semibold mb-2 transition-transform transform 3d-hover">
                                Thương hiệu
                            </label>
                            <div class="flex items-center space-x-2 animate-pulse">
                                <div class="bg-white p-1 rounded-full">
                                    <i class="fa-brands fa-bandcamp w-full text-indigo-400 animate-bounce"></i>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <!-- Animated border input -->
                            <div
                                class="border-4 border-transparent focus-within:border-white rounded-lg transition-transform transform 3d-hover">
                                <select id="brand" name="brand"
                                    class="w-full py-2 px-4 text-black bg-white rounded-lg focus:outline-none transition-transform transform ">
                                    @foreach ($brands as $brand)
                                        <option 
                                            value="{{ $brand->id }}"
                                            @php if ($brand->id==$product->brand_id) echo "selected" @endphp>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @error('brand')
                            <div class="mt-2 text-red-200 bg-red-600 p-2 rounded-lg animate-shake 3d-hover">{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Chất liệU -->
                    <div class="mb-4 p-4 bg-gradient-to-r from-indigo-400 to-blue-500 rounded-lg shadow-2xl transform transition-transform  hover:shadow-3xl perspective-1500">
                        <!-- Label with subtle animation -->
                        <div class="flex justify-between items-center mb-4">
                            <label for="material"
                                class="text-white font-semibold mb-2 transition-transform transform  3d-hover">
                                Chất liệu
                            </label>
                            <div class="flex items-center space-x-2 animate-pulse">
                                <div class="bg-white p-1 rounded-full">
                                    <i class="fa-solid fa-cable-car w-full text-indigo-400 animate-bounce"></i>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <!-- Animated border input -->
                            <div
                                class="border-4 border-transparent focus-within:border-white rounded-lg transition-transform transform  3d-hover">
                                <select id="material" name="material"
                                    class="w-full py-2 px-4 text-black bg-white rounded-lg focus:outline-none transition-transform transform ">
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->id }}"
                                            @php if ($material->id==$product->material_id) echo "selected" @endphp>
                                            {{ $material->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Animated arrow icon for dropdown -->
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none transform translate-x-1 transition-transform">
                                <svg class="w-5 h-5 text-white transform transition-transform hover:rotate-180 3d-hover"
                                    viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                    <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" strokeLinecap="round" strokeLinejoin="round"
                                        strokeWidth="1.5"></path>
                                </svg>
                            </div>
                        </div>

                        @error('material')
                            <div class="mt-2 text-red-200 bg-red-600 p-2 rounded-lg animate-shake 3d-hover">{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Hình dạng -->
                    <div class="mb-4 p-4 bg-gradient-to-r from-indigo-400 to-blue-500 rounded-lg shadow-2xl transform transition-transform  hover:shadow-3xl perspective-1500">
                        <!-- Label with subtle animation -->
                        <div class="flex justify-between items-center mb-4">
                            <label for="shape"
                                class="text-white font-semibold mb-2 transition-transform transform  3d-hover">
                                Hình dạng
                            </label>
                            <div class="flex items-center space-x-2 animate-pulse">
                                <div class="bg-white p-1 rounded-full">
                                    <i class="fa-solid fa-shapes w-full text-indigo-400 animate-bounce"></i>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <!-- Animated border input -->
                            <div
                                class="border-4 border-transparent focus-within:border-white rounded-lg transition-transform transform  3d-hover">
                                <select id="shape" name="shape"
                                    class="w-full py-2 px-4 text-black bg-white rounded-lg focus:outline-none transition-transform transform ">
                                    @foreach ($shapes as $shape)
                                        <option value="{{ $shape->id }}"
                                            @php if ($shape->id==$product->shape_id) echo "selected" @endphp>
                                            {{ $shape->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @error('shape')
                            <div class="mt-2 text-red-200 bg-red-600 p-2 rounded-lg animate-shake 3d-hover">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Thiết kế -->
                    <div class="mb-4 p-4 bg-gradient-to-r from-indigo-400 to-blue-500 rounded-lg shadow-2xl transform transition-transform  hover:shadow-3xl perspective-1500">
                        <!-- Label with subtle animation -->
                        <div class="flex justify-between items-center mb-4">
                            <label for="design"
                                class="text-white font-semibold mb-2 transition-transform transform  3d-hover">
                                Thiết kế
                            </label>
                            <div class="flex items-center space-x-2 animate-pulse">
                                <div class="bg-white p-1 rounded-full">
                                    <i class="fa-solid fa-object-group w-full text-indigo-400 animate-bounce"></i>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <!-- Animated border input -->
                            <div
                                class="border-4 border-transparent focus-within:border-white rounded-lg transition-transform transform  3d-hover">
                                <select id="design" name="design"
                                    class="w-full py-2 px-4 text-black bg-white rounded-lg focus:outline-none transition-transform transform ">
                                    @foreach ($designs as $design)
                                        <option value="{{ $design->id }}"
                                            @php if ($design->id==$product->design_id) echo "selected" @endphp>
                                            {{ $design->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @error('design')
                            <div class="mt-2 text-red-200 bg-red-600 p-2 rounded-lg animate-shake 3d-hover">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Xuất xứ -->
                    <div class="mb-4 p-4 bg-gradient-to-r from-indigo-400 to-blue-500 rounded-lg shadow-2xl transform transition-transform  hover:shadow-3xl perspective-1500">
                        <!-- Label with subtle animation -->
                        <div class="flex justify-between items-center mb-4">
                            <label for="source"
                                class="text-white font-semibold mb-2 transition-transform transform  3d-hover">
                                Xuất xứ
                            </label>
                            <div class="flex items-center space-x-2 animate-pulse">
                                <div class="bg-white p-1 rounded-full">
                                    <i class="fa-brands fa-sourcetree w-full text-indigo-400 animate-bounce"></i>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <!-- Animated border input -->
                            <div
                                class="border-4 border-transparent focus-within:border-white rounded-lg transition-transform transform  3d-hover">
                                <select id="source" name="source"
                                    class="w-full py-2 px-4 text-black bg-white rounded-lg focus:outline-none transition-transform transform ">
                                    @foreach ($sources as $source)
                                        <option value="{{ $source->id }}"
                                            @php if ($source->id==$product->source_id) echo "selected" @endphp>
                                            {{ $source->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @error('source')
                            <div class="mt-2 text-red-200 bg-red-600 p-2 rounded-lg animate-shake 3d-hover">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Nội dung -->
                <div class="mb-4">
                    <label for="des" class="block mb-1">
                        Nội dung
                    </label>
                    <textarea id="basic-conf" name="des" class="w-full py-2 px-3 text-gray-800 border border-gray-300 rounded">
                        {{ $product->des }}
                    </textarea>
                    @error('des')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mb-4">
                    <!-- giới tính -->
                    <div class="mb-4">
                        <label for="sex" class="block mb-1">Giới tính </label>
                        <div class="flex items-center mb-4">
                            <input @php if($product->sex=="male")  echo "checked"; @endphp id="sex-1" type="radio"
                                value="male" name="sex"
                                class="w-4 h-4 text-blue-600 bg-blue-600 border-gray-300 focus:ring-blue-50 dark:focus:ring-blue-600 dark:ring-offset-blue-800 focus:ring-2 dark:bg-blue-700 dark:border-blue-600">
                            <label for="sex-1"
                                class="ml-2 text-base font-medium text-gray-900 dark:text-gray-300">Nam</label>
                        </div>
                        <div class="flex items-center mb-4">
                            <input @php if($product->sex=="female")  echo "checked"; @endphp id="sex-2" type="radio"
                                value="female" name="sex"
                                class="w-4 h-4 text-blue-600 bg-blue-600 border-gray-300 focus:ring-blue-50 dark:focus:ring-blue-600 dark:ring-offset-blue-800 focus:ring-2 dark:bg-blue-700 dark:border-blue-600">
                            <label for="sex-2"
                                class="ml-2 text-base font-medium text-gray-900 dark:text-gray-300">Nữ</label>
                        </div>
                        <div class="flex items-center mb-4">
                            <input @php if($product->sex=="unisex")  echo "checked"; @endphp id="sex-3" type="radio"
                                value="unisex" name="sex"
                                class="w-4 h-4 text-blue-600 bg-blue-600 border-gray-300 focus:ring-blue-50 dark:focus:ring-blue-600 dark:ring-offset-blue-800 focus:ring-2 dark:bg-blue-700 dark:border-blue-600">
                            <label for="sex-3"
                                class="ml-2 text-base font-medium  animate-color-change dark:text-gray-300 rainbow-text">Unisex</label>
                        </div>
                        @error('sex')
                            <div class="mt-2 text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ve kính -->
                    <div class="mb-4">
                        <label for="nose_tick" class="block mb-1">Ve kính</label>
                        <div class="flex items-center mb-4">
                            <input @php if($product->nose_tick=="yes")  echo "checked"; @endphp id="nose_tick-1"
                                type="radio" value="yes" name="nose_tick"
                                class="w-4 h-4 text-blue-600 bg-blue-600 border-gray-300 focus:ring-blue-50 dark:focus:ring-blue-600 dark:ring-offset-blue-800 focus:ring-2 dark:bg-blue-700 dark:border-blue-600">
                            <label for="nose_tick-1"
                                class="ml-2 text-base font-medium text-gray-900 dark:text-gray-300">yes</label>
                        </div>
                        <div class="flex items-center mb-4">
                            <input @php if($product->nose_tick=="no")  echo "checked"; @endphp id="nose_tick-2"
                                type="radio" value="no" name="nose_tick"
                                class="w-4 h-4 text-blue-600 bg-blue-600 border-gray-300 focus:ring-blue-50 dark:focus:ring-blue-600 dark:ring-offset-blue-800 focus:ring-2 dark:bg-blue-700 dark:border-blue-600">
                            <label for="nose_tick-2"
                                class="ml-2 text-base font-medium text-gray-900 dark:text-gray-300">no</label>
                        </div>
                        @error('nose_tick')
                            <div class="mt-2 text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <!-- Last Update -->
                <div class="mb-4">
                    <label for="last_up" class="block text-gray-500 font-bold mb-2">Cập nhật cuối</label>
                    <input
                        class="w-full py-2 px-3 bg-gray-100 text-green-700 border border-gray-300 rounded focus:outline-none"
                        type="text" value="Lúc : {{ ('App\Helpers\Support')::change_date($product->updated_at) }}"
                        readonly>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3 px-6 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-shadow  duration-300 ease-in-out shadow-md font-semibold">Cập
                    nhật</button>
            </form>
        </div>
    </div>

    <script>
        // Lấy phần tử input file và phần tử hiển thị ảnh trước khi tải lên
        var inputImage = document.getElementById('pic');
        var imagePreview = document.getElementById('image-preview');

        // Bắt sự kiện khi người dùng chọn tệp ảnh
        inputImage.addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Hiển thị ảnh trước khi tải lên
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('new_pic', 'h-auto', 'max-w-md', 'transition-all', 'duration-300',
                        'rounded-lg', 'cursor-pointer', 'filter', 'scale-100', 'hover:scale-110',
                        'brightness-100', 'hover:brightness-125');
                    imagePreview.innerHTML = ''; // Xóa bất kỳ ảnh trước đó
                    imagePreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        // gửi link ảnh đến input
        var current_pic = document.getElementById('current_pic')
        var pic_show = document.getElementById('pic_show')

        current_pic.value = pic_show.src
        // Thêm sự kiện cho nút cập nhật nếu ảnh được Chỉnh
        var btn_add = document.getElementById('btn-add')
        var form = document.getElementById('myForm')

        btn_add.addEventListener('click', function(event) {
            event.preventDefault();
            var new_pic = document.querySelector('.new_pic')
            if (new_pic !== null) {
                current_pic.value = new_pic.src
            }

            form.submit();
        })
    </script>
    <script>
        const choices = new Choices('.choices-multiple-selection', {
            removeItemButton: true,
        });
    </script>
    <script>
        let timer;

        function formatInputValue(inputElement, hiddenInputElement) {
            // Lấy giá trị từ input và loại bỏ dấu phẩy
            let value = inputElement.value.replace(/,/g, '');

            // Cập nhật giá trị cho input ẩn
            hiddenInputElement.value = value;

            // Kiểm tra nếu giá trị không phải là chuỗi trống
            if (value) {
                // Định dạng số
                inputElement.value = parseFloat(value).toLocaleString('en-US');

                // Đặt con trỏ về vị trí cuối cùng sau khi định dạng
                inputElement.setSelectionRange(inputElement.value.length, inputElement.value.length);
            } else {
                // Đặt giá trị của input về chuỗi trống
                inputElement.value = "";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputElement = document.getElementById('numberInput');
            const hiddenInputElement = document.getElementById('actualPrice');

            // Định dạng giá trị mặc định
            formatInputValue(inputElement, hiddenInputElement);

            // Định dạng giá trị khi có sự kiện nhập
            inputElement.addEventListener('input', function() {
                clearTimeout(timer); // Hủy bỏ việc định dạng trước đó nếu có
                timer = setTimeout(() => formatInputValue(this, hiddenInputElement),
                    200); // Trì hoãn việc định dạng trong 200ms
            });
        });
    </script>
@endsection
