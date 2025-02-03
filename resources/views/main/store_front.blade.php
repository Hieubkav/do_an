@extends('layouts.main')

@section('content')
    <!-- Banner !-->
    <banner>
        <div class="h-96 relative group overflow-hidden clip-banner my-12">

            <!-- Parallax background with brightness hover effect -->
            <div class="absolute top-0 left-0 w-full h-full transform scale-110 group-hover:scale-100 transition-transform duration-700 ease-in-out brightness-75 group-hover:brightness-100"
                style="background-image: url('{{ asset('asset/all_pic') }}/{{ $setting->banner_one_pic }}'); background-size: cover; background-position: center;">
            </div>

            <!-- Text effects with background overlay -->
            <div class="absolute bottom-10 left-10 transform transition-all duration-700 ease-in-out">
                <div class="bg-black bg-opacity-50 p-4 rounded-xl">
                    <h1
                        class="text-4xl text-transparent bg-clip-text font-bold mb-2 shadow-2xl transform group-hover:scale-105 transition-transform duration-700 ease-in-out bg-gradient-to-r from-blue-400 via-purple-500 to-red-400">
                        {{ $setting->banner_one_big_text }}
                    </h1>
                    <p
                        class="text-xl text-transparent bg-clip-text shadow-md transform group-hover:scale-105 transition-transform duration-700 ease-in-out bg-gradient-to-r from-cyan-400 via-blue-400 to-purple-500">
                        {{ $setting->banner_one_small_text }}
                    </p>
                </div>
            </div>

        </div>
        <!-- Additional styles for the banner shape -->
        <style>
            .clip-banner {
                clip-path: polygon(0 0, 100% 0%, 85% 100%, 0% 100%);
            }
        </style>
    </banner>

    <!-- Danh mục  -->
    <swiper_category>
        <!-- Swiper CSS -->
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <!-- Swiper JS -->
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

        <div class="swiper-container_cat relative">
            <div class="swiper-wrapper">
                @foreach ($categories as $category)
                    <a href="{{ route('product_filter', ['category' => $category->id]) }}" class="swiper-slide p-4">
                        <div
                            class="flex flex-col items-center justify-center h-32 md:h-40 w-32 md:w-40 bg-white rounded-xl border border-gray-300 shadow-xl transform transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl relative overflow-hidden hover:border-gray-400 cursor-pointer">

                            <!-- Biểu tượng đại diện cho mỗi danh mục -->
                            <i
                                class="fas fa-glasses text-xl md:text-2xl text-gray-600 hover:text-gray-700 transform transition-all duration-500 hover:scale-110"></i>

                            <!-- Tên danh mục -->
                            <span
                                class="text-lg md:text-xl text-center font-bold mt-2 text-gray-800 hover:text-gray-900 transition-all duration-300">{{ $category->name }}</span>

                            <!-- Hiệu ứng hoạt ảnh nền -->
                            <div
                                class="absolute top-0 left-0 opacity-60 w-full h-full bg-gradient-to-br from-transparent to-gray-200 hover:from-gray-100 hover:to-gray-300 transition-all duration-500 z-0">
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Swiper Navigation -->
            <div
                class="swiper-button-prev absolute top-1/2 left-0 transform -translate-y-1/2  p-2 rounded-r shadow-md hover:bg-gray-100">
                <svg width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 14L7 10l5-4"></path>
                </svg>
            </div>
            <div
                class="swiper-button-next absolute top-1/2 right-0 transform -translate-y-1/2  p-2 rounded-l shadow-md hover:bg-gray-100">
                <svg width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 14l5-4-5-4"></path>
                </svg>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const mySwiper = new Swiper('.swiper-container_cat', {
                    slidesPerView: 2, // số lượng slide hiển thị trên màn hình nhỏ
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        // khi độ rộng màn hình là 640px trở lên
                        640: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        // khi độ rộng màn hình là 1024px trở lên
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 30,
                        },
                    }
                });
            });
        </script>
    </swiper_category>

    <!-- Sản phẩm mới tạo -->
    <newest_product>
        <div class="container mx-auto px-4 py-6">
            <h2 class="text-2xl font-bold mb-6">Sản Phẩm Mới Nhất</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products->sortByDesc('created_at')->take(8) as $product)
                    <div
                        class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow {{ $product->quantity == 0 ? 'out-of-stock' : '' }}">
                        <!-- Hình ảnh sản phẩm -->
                        <img src="{{ asset('asset/all_pic/') }}/{{ $product->versions->first()->colorversionimages->first()->image }}"
                            alt="{{ $product->name }}" class="w-full h-48 object-cover">

                        <!-- Nội dung sản phẩm -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2 hover:text-blue-600 transition-colors">
                                {{ $product->name }}
                            </h3>
                            @php
                                $change_vnd = App\Helpers\Support::change_vnd($product->price);
                            @endphp
                            <span class="text-red-500 font-bold">{{ $change_vnd }}</span>
                            <a href="" class="flex items-center mt-2">
                                <span class="ml-2 text-gray-600">Mua ngay </span>
                            </a>
                        </div>

                        <!-- Hiệu ứng xem nhanh khi di chuột qua sản phẩm -->
                        <div
                            class="absolute top-0 left-0 w-full h-full bg-gray-900 bg-opacity-60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('product_webpage_detail', $product->id) }}"
                                class="text-white font-bold px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 transition-colors">
                                Chi tiết sản phẩm
                            </a>
                        </div>

                        <!-- Thêm biểu tượng hoặc thông  báo hết hàng nếu sản phẩm hết hàng -->
                        @if ($product->quantity == 0 || $product->quantity == null)
                            <div class="absolute top-4 right-4 bg-red-500 text-white text-xs rounded-full px-3 py-1">Hết
                                hàng</div>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </newest_product>

    <!-- Banner 2 -->
    <banner_two>
        <div class="max-w-screen-lg mx-auto p-6">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-200">
                <div class="relative">
                    <img src="{{ asset('asset/all_pic') }}/{{ $setting->banner_two_pic }}" alt="Mắt Kính"
                        class="w-full h-96 object-cover">

                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent p-6">
                        <div class="absolute bottom-0 left-0 pb-8 pl-8">
                            <h2 class="text-4xl font-semibold text-white leading-tight mb-3">
                                {{ $setting->banner_two_big_text }}</h2>
                            <p class="text-xl text-gray-300">{{ $setting->banner_two_small_text }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </banner_two>

    <!-- Bài viết  -->
    <article>
        <div class="container mx-auto px-4 my-10">
            <h1 class="text-3xl font-bold mb-8 text-center">Bài viết</h1>

            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($posts as $post)
                        <div class="swiper-slide">
                            <a href="{{ route('post_user', $post->id) }}"
                                class="bg-white rounded-lg overflow-hidden shadow-lg transition transform hover:scale-105 duration-300">
                                <img class="w-full h-56 object-cover object-center"
                                    src="{{ asset('asset/all_pic/') }}/{{ $post->image->link }}"
                                    alt="{{ $post->title }}">
                                <div class="p-6">
                                    <h2 class="font-semibold text-xl mb-3 hover:text-blue-600 transition">
                                        {{ $post->title }}</h2>
                                    <p class="text-gray-600 text-base truncate ... h-20">
                                        xem bài viết
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                {{-- <div class="swiper-pagination"></div> --}}
                <!-- Add Arrows -->
                {{-- <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div> --}}
            </div>
        </div>

        <script>
            const swiper = new Swiper('.swiper-container', {
                // Optional parameters
                slidesPerView: 4,
                spaceBetween: 20,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    // when window width is >= 1280px
                    1280: {
                        slidesPerView: 4,
                        spaceBetween: 30
                    },
                    // when window width is >= 768px
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    // when window width is >= 640px
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 15
                    },
                    // when window width is >= 320px
                    320: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    }
                }
            });
        </script>
    </article>

    <!-- Đánh giá sản phẩm  -->
@endsection
