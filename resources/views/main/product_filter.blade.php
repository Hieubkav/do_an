@extends('layouts.main')

@section('content')
    <div class="container mx-auto p-6 flex flex-col md:flex-row">
        <!-- Nút mở Modal (chỉ hiển thị trên điện thoại) -->
        <div class="md:hidden flex justify-end mb-4">
            <button id="filterModalButton" class="p-2 rounded-full bg-blue-500 text-white">
                <i class="fa fa-filter"></i> Bộ lọc
            </button>
        </div>
        <!-- Sidebar: Bộ lọc sản phẩm -->
        <aside class="w-full md:w-1/4 pr-4 mb-6 md:mb-0 hidden md:block">
            <form action="" method="GET"
                class="bg-white rounded-lg shadow-md p-4 space-y-4 transform transition-transform duration-500 hover:scale-105">

                <!-- Danh mục -->
                <div class="relative hover:bg-gray-100 p-2 rounded">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                    <select name="category" id="category"
                        class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                        <option value="">Chọn danh mục</option>
                        @foreach ($categories as $item)
                            <option @php if ($category==str($item->id) ) echo "selected"; @endphp
                                value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Thương hiệu -->
                <div class="relative hover:bg-gray-100 p-2 rounded">
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Thương hiệu</label>
                    <select name="brand" id="brand"
                        class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                        <option value="">Chọn thương hiệu</option>
                        @foreach ($brands as $item)
                            <option @php if ($brand==str($item->id) ) echo "selected"; @endphp value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Chất liệu -->
                <div class="relative hover:bg-gray-100 p-2 rounded">
                    <label for="material" class="block text-sm font-medium text-gray-700 mb-1">Chất liệu</label>
                    <select name="material" id="material"
                        class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                        <option value="">Chọn chất liệu</option>
                        @foreach ($materials as $item)
                            <option @php if ($material==str($item->id) ) echo "selected"; @endphp
                                value="{{ $item->id }}">{{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Thiết kế -->
                <div class="relative hover:bg-gray-100 p-2 rounded">
                    <label for="design" class="block text-sm font-medium text-gray-700 mb-1">Thiết kế</label>
                    <select name="design" id="design"
                        class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                        <option value="">Chọn Thiết kế</option>
                        @foreach ($designs as $item)
                            <option @php if ($design==str($item->id) ) echo "selected"; @endphp value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Hình dạnng -->
                <div class="relative hover:bg-gray-100 p-2 rounded">
                    <label for="shape" class="block text-sm font-medium text-gray-700 mb-1">Hình dạnng</label>
                    <select name="shape" id="shape"
                        class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                        <option value="">Chọn Hình dạnng</option>
                        @foreach ($shapes as $item)
                            <option @php if ($shape==str($item->id) ) echo "selected"; @endphp value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Xuất xứ -->
                <div class="relative hover:bg-gray-100 p-2 rounded">
                    <label for="source" class="block text-sm font-medium text-gray-700 mb-1">Xuất xứ</label>
                    <select name="source" id="source"
                        class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                        <option value="">Chọn Xuất xứ</option>
                        @foreach ($sources as $item)
                            <option @php if ($source==str($item->id) ) echo "selected"; @endphp
                                value="{{ $item->id }}">{{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Giới tính -->
                <div class="relative hover:bg-gray-100 p-2 rounded">
                    <span class="block text-sm font-medium text-gray-700 mb-1">Giới tính</span>
                    <div class="mt-2 space-y-2">
                        <label class="block">
                            <input @php if ($sex=="male") echo "checked" @endphp type="radio" name="sex"
                                value="male" class="form-radio">
                            <span class="ml-2">Nam</span>
                        </label>
                        <label class="block">
                            <input @php if ($sex=="female") echo "checked" @endphp type="radio" name="sex"
                                value="female" class="form-radio">
                            <span class="ml-2">Nữ</span>
                        </label>
                        <label class="block">
                            <input @php if ($sex=="unisex") echo "checked" @endphp type="radio" name="sex"
                                value="unisex" class="form-radio">
                            <span class="ml-2">Unisex</span>
                        </label>
                    </div>
                </div>

                <!-- Ve mũi -->
                <div class="relative hover:bg-gray-100 p-2 rounded">
                    <span class="block text-sm font-medium text-gray-700 mb-1">Ve mũi</span>
                    <div class="mt-2 space-y-2">
                        <label class="block">
                            <input @php if ($nose_tick=="yes") echo "checked" @endphp type="radio" name="nose_tick"
                                value="yes" class="form-radio">
                            <span class="ml-2">Yes</span>
                        </label>
                        <label class="block">
                            <input @php if ($nose_tick=="no") echo "checked" @endphp type="radio" name="nose_tick"
                                value="no" class="form-radio">
                            <span class="ml-2">No</span>
                        </label>
                    </div>
                </div>

                <!-- Màu sắc -->
                <div class="relative hover:bg-gray-100 p-2 rounded">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Màu sắc</label>
                    <select name="color" id="color"
                        class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                        <option value="">Chọn màu sắc</option>
                        @foreach ($colors as $item)
                            <option @php if ($color==str($item->id) ) echo "selected"; @endphp
                                value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kích thước -->
                <div class="relative hover:bg-gray-100 p-2 rounded">
                    <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Kích thước</label>
                    <select name="size" id="size"
                        class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                        <option value="">Chọn kích thước</option>
                        @foreach ($sizes as $item)
                            <option @php if ($size==str($item->id) ) echo "selected"; @endphp
                                value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1">Lọc</button>
            </form>
        </aside>

        <!-- Main content: Hiển thị danh sách sản phẩm -->
        <main class="w-full md:w-3/4 pl-4">
            <!-- Bộ lọc sắp xếp sản phẩm -->
            <div class="mb-4 flex justify-between items-start">
                <div>
                    <label for="sort_by" class="text-gray-700 mr-2">Sắp xếp theo:</label>
                    <select name="sort_by" id="sort_by"
                        class="p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200"
                        onchange="location = this.value;">
                        <option selected value="{{ request()->fullUrlWithQuery(['sort_by' => '']) }}">Chọn loại sắp xếp
                        </option>
                        <option @php if ($sort_by=='price_asc') echo "selected"; @endphp
                            value="{{ request()->fullUrlWithQuery(['sort_by' => 'price_asc']) }}">Giá: Rẻ đến Đắt</option>
                        <option @php if ($sort_by=='price_desc') echo "selected"; @endphp
                            value="{{ request()->fullUrlWithQuery(['sort_by' => 'price_desc']) }}">Giá: Đắt đến Rẻ
                        </option>
                        <option @php if ($sort_by=='newest') echo "selected"; @endphp
                            value="{{ request()->fullUrlWithQuery(['sort_by' => 'newest']) }}">Mới nhất</option>
                        <option @php if ($sort_by=='oldest') echo "selected"; @endphp
                            value="{{ request()->fullUrlWithQuery(['sort_by' => 'oldest']) }}">Cũ nhất</option>
                        <option @php if ($sort_by=='quantity_asc') echo "selected"; @endphp
                            value="{{ request()->fullUrlWithQuery(['sort_by' => 'quantity_asc']) }}">Số lượng: Ít đến
                            Nhiều
                        </option>
                        <option @php if ($sort_by=='quantity_desc') echo "selected"; @endphp
                            value="{{ request()->fullUrlWithQuery(['sort_by' => 'quantity_desc']) }}">Số lượng: Nhiều đến
                            Ít</option>
                    </select>
                </div>

                <a href="{{ route('face.detection') }}" class="bg-red-500 text-white px-4 py-2 rounded-md">Tư vấn kính
                    <i class="fa-solid fa-video"></i>
                </a>
            </div>

            {{-- Nút hiển thị filter --}}
            <div class="mb-4">
                @if (!empty($category))
                    <button type="button"
                        class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 ">
                        @php
                            $category_id = intval($category);
                            echo $categories->find($category_id)->name;
                        @endphp
                        <i onclick="removeParamFromCurrentUrl('category', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif

                @if (!empty($brand))
                    <button type="button"
                        class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        @php
                            $brand_id = intval($brand);
                            echo $brands->find($brand_id)->name;
                        @endphp
                        <i onclick="removeParamFromCurrentUrl('brand', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif

                @if (!empty($material))
                    <button type="button"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        @php
                            $material_id = intval($material);
                            echo $materials->find($material_id)->name;
                        @endphp
                        <i onclick="removeParamFromCurrentUrl('material', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif

                @if (!empty($design))
                    <button type="button"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        @php
                            $design_id = intval($design);
                            echo $designs->find($design_id)->name;
                        @endphp
                        <i onclick="removeParamFromCurrentUrl('design', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif

                @if (!empty($source))
                    <button type="button"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        @php
                            $source_id = intval($source);
                            echo $sources->find($source_id)->name;
                        @endphp
                        <i onclick="removeParamFromCurrentUrl('source', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif

                @if (!empty($shape))
                    <button type="button"
                        class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        @php
                            $shape_id = intval($shape);
                            echo $shapes->find($shape_id)->name;
                        @endphp
                        <i onclick="removeParamFromCurrentUrl('shape', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif

                @if (!empty($sex))
                    <button type="button"
                        class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        @php
                            if ($sex == 'female') {
                                echo 'Nữ';
                            } elseif ($sex == 'male') {
                                echo 'Nam';
                            } else {
                                echo 'Unisex';
                            }

                        @endphp
                        <i onclick="removeParamFromCurrentUrl('sex', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif

                @if (!empty($nose_tick))
                    <button type="button"
                        class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        @php
                            if ($nose_tick == 'yes') {
                                echo 'Yes';
                            } elseif ($nose_tick == 'no') {
                                echo 'No';
                            }
                        @endphp
                        <i onclick="removeParamFromCurrentUrl('nose_tick', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif

                @if (!empty($color))
                    <button type="button"
                        class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        @php
                            $color_id = intval($color);
                            echo $colors->find($color_id)->name;
                        @endphp
                        <i onclick="removeParamFromCurrentUrl('color', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif

                @if (!empty($size))
                    <button type="button"
                        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        @php
                            $size_id = intval($size);
                            echo $sizes->find($size_id)->name;
                        @endphp
                        <i onclick="removeParamFromCurrentUrl('size', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif

                @if (!empty($keyword))
                    <button type="button"
                        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        "
                        @php
                            echo $keyword;
                        @endphp
                        "
                        <i onclick="removeParamFromCurrentUrl('keyword', '{{ url()->full() }}')"
                            class="fa-solid fa-xmark text-white hover:text-red-600">
                        </i>
                    </button>
                @endif
            </div>

            <!-- Số lượng sản phẩm -->
            <div class="mb-4 p-3 bg-indigo-100 rounded-lg shadow-md">
                <span class="text-indigo-600 font-semibold">{{ $products->total() }}</span>
                sản phẩm được tìm thấy
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                @foreach ($products as $product)
                    <div
                        class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-500 ease-in-out">
                        <!-- Swiper -->
                        <div class="swiper-container h-48">
                            <div class="swiper-wrapper">
                                @foreach ($product->versions as $version)
                                    @foreach ($version->colorversionimages as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ asset('asset/all_pic') }}/{{ $image->image }}"
                                                alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>

                        <!-- Product Details -->
                        <div class="p-5 bg-gray-50">
                            <h4
                                class="text-xl font-semibold mb-3 leading-tight hover:text-indigo-600 transition-colors duration-300">
                                {{ $product->name }}</h4>
                            @php
                                $change_vnd = App\Helpers\Support::change_vnd($product->price);
                            @endphp
                            <span class="text-indigo-500 text-lg font-extrabold block mb-3">{{ $change_vnd }}</span>

                            @if ($product->quantity == 0 || $product->quantity == null)
                                <a href="{{ route('product_webpage_detail', $product->id) }}"
                                    class="text-red-600 hover:text-red-700 transition-colors duration-300 font-semibold border-b-2 border-transparent hover:border-red-600 pb-1">
                                    Hết hàng
                                </a>
                            @else
                                <a href="{{ route('product_webpage_detail', $product->id) }}"
                                    class="text-indigo-600 hover:text-indigo-700 transition-colors duration-300 font-semibold border-b-2 border-transparent hover:border-indigo-600 pb-1">
                                    Xem ngay
                                </a>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>

            <script>
                function randomDelay() {
                    return Math.floor(Math.random() * (20000 - 5000 + 1)) + 5000; // Trả về một giá trị ngẫu nhiên từ 5000 đến 20000
                }
                document.addEventListener("DOMContentLoaded", function() {
                    var swipers = document.querySelectorAll('.swiper-container');
                    swipers.forEach(function(swiper) {
                        new Swiper(swiper, {
                            loop: true,
                            autoplay: {
                                delay: randomDelay(),
                                disableOnInteraction: false,
                            },
                            pagination: {
                                el: '.swiper-pagination',
                            },
                        });
                    });
                });
            </script>


            <!-- Phân trang -->
            <div class="mt-6">
                {{-- {{ $products->links() }} --}}
                @include('partials.custom-pagination', ['paginator' => $products])
            </div>
        </main>
    </div>

    <!-- Modal Bộ Lọc -->
    <div id="filterModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-11/12 shadow-lg rounded-md bg-white">
            <button id="closeModal"
                class="absolute top-2 right-2 text-gray-600 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                onclick="document.getElementById('filterModal').style.display='none'">
                <i class="fa fa-times"></i>
            </button>
            <div class="md:hidden">
                <form action="" method="GET"
                    class="bg-white rounded-lg  p-4 space-y-4 transform transition-transform duration-500 ">

                    <!-- Danh mục -->
                    <div class="relative hover:bg-gray-100 p-2 rounded">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                        <select name="category" id="category"
                            class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                            <option value="">Chọn danh mục</option>
                            @foreach ($categories as $item)
                                <option @php if ($category==str($item->id) ) echo "selected"; @endphp
                                    value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Thương hiệu -->
                    <div class="relative hover:bg-gray-100 p-2 rounded">
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Thương hiệu</label>
                        <select name="brand" id="brand"
                            class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                            <option value="">Chọn thương hiệu</option>
                            @foreach ($brands as $item)
                                <option @php if ($brand==str($item->id) ) echo "selected"; @endphp
                                    value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Chất liệu -->
                    <div class="relative hover:bg-gray-100 p-2 rounded">
                        <label for="material" class="block text-sm font-medium text-gray-700 mb-1">Chất liệu</label>
                        <select name="material" id="material"
                            class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                            <option value="">Chọn chất liệu</option>
                            @foreach ($materials as $item)
                                <option @php if ($material==str($item->id) ) echo "selected"; @endphp
                                    value="{{ $item->id }}">{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Thiết kế -->
                    <div class="relative hover:bg-gray-100 p-2 rounded">
                        <label for="design" class="block text-sm font-medium text-gray-700 mb-1">Thiết kế</label>
                        <select name="design" id="design"
                            class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                            <option value="">Chọn Thiết kế</option>
                            @foreach ($designs as $item)
                                <option @php if ($design==str($item->id) ) echo "selected"; @endphp
                                    value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Hình dạnng -->
                    <div class="relative hover:bg-gray-100 p-2 rounded">
                        <label for="shape" class="block text-sm font-medium text-gray-700 mb-1">Hình dạnng</label>
                        <select name="shape" id="shape"
                            class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                            <option value="">Chọn Hình dạnng</option>
                            @foreach ($shapes as $item)
                                <option @php if ($shape==str($item->id) ) echo "selected"; @endphp
                                    value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Xuất xứ -->
                    <div class="relative hover:bg-gray-100 p-2 rounded">
                        <label for="source" class="block text-sm font-medium text-gray-700 mb-1">Xuất xứ</label>
                        <select name="source" id="source"
                            class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                            <option value="">Chọn Xuất xứ</option>
                            @foreach ($sources as $item)
                                <option @php if ($source==str($item->id) ) echo "selected"; @endphp
                                    value="{{ $item->id }}">{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Giới tính -->
                    <div class="relative hover:bg-gray-100 p-2 rounded">
                        <span class="block text-sm font-medium text-gray-700 mb-1">Giới tính</span>
                        <div class="mt-2 space-y-2">
                            <label class="block">
                                <input @php if ($sex=="male") echo "checked" @endphp type="radio" name="sex"
                                    value="male" class="form-radio">
                                <span class="ml-2">Nam</span>
                            </label>
                            <label class="block">
                                <input @php if ($sex=="female") echo "checked" @endphp type="radio" name="sex"
                                    value="female" class="form-radio">
                                <span class="ml-2">Nữ</span>
                            </label>
                            <label class="block">
                                <input @php if ($sex=="unisex") echo "checked" @endphp type="radio" name="sex"
                                    value="unisex" class="form-radio">
                                <span class="ml-2">Unisex</span>
                            </label>
                        </div>
                    </div>

                    <!-- Ve mũi -->
                    <div class="relative hover:bg-gray-100 p-2 rounded">
                        <span class="block text-sm font-medium text-gray-700 mb-1">Ve mũi</span>
                        <div class="mt-2 space-y-2">
                            <label class="block">
                                <input @php if ($nose_tick=="yes") echo "checked" @endphp type="radio" name="nose_tick"
                                    value="yes" class="form-radio">
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="block">
                                <input @php if ($nose_tick=="no") echo "checked" @endphp type="radio" name="nose_tick"
                                    value="no" class="form-radio">
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    </div>

                    <!-- Màu sắc -->
                    <div class="relative hover:bg-gray-100 p-2 rounded">
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Màu sắc</label>
                        <select name="color" id="color"
                            class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                            <option value="">Chọn màu sắc</option>
                            @foreach ($colors as $item)
                                <option @php if ($color==str($item->id) ) echo "selected"; @endphp
                                    value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kích thước -->
                    <div class="relative hover:bg-gray-100 p-2 rounded">
                        <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Kích thước</label>
                        <select name="size" id="size"
                            class="w-full p-2 rounded-md border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 transition duration-300 hover:border-indigo-500">
                            <option value="">Chọn kích thước</option>
                            @foreach ($sizes as $item)
                                <option @php if ($size==str($item->id) ) echo "selected"; @endphp
                                    value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1">Lọc</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Ẩn hiện nút và modal */
        @media screen and (min-width: 768px) {
            #filterModalButton {
                display: none;
            }
        }
    </style>

    <script>
        document.getElementById('filterModalButton').addEventListener('click', function() {
            document.getElementById('filterModal').style.display = 'block';
        });
    </script>
@endsection
