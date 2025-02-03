@extends('layouts.dashboard')

@section('content')
    <div class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold mb-4">Cài đặt trang web</h2>

        <form action="{{ route('setting_update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Banner 1 -->
                <div>
                    <label class="block mb-2 text-sm font-medium">Ảnh banner 1:</label>
                    <input type="file" name="banner1_image" class="border p-2 rounded w-full">
                    <img id="banner1-preview" src="{{ asset('asset/all_pic') }}/{{$setting->banner_one_pic}}" alt="Ảnh xem trước banner 1" class=" mt-2 w-64">
                    @error('banner1_image')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">Chữ Lớn banner 1:</label>
                    <input type="text" name="banner1_large_text" class="border p-2 rounded w-full"
                        placeholder="Nhập chữ lớn cho banner 1" value="{{$setting->banner_one_big_text}}">
                    @error('banner1_large_text')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label class="block mb-2 text-sm font-medium">Chữ nhỏ banner 1:</label>
                    <input type="text" name="banner1_small_text" class="border p-2 rounded w-full"
                        placeholder="Nhập chữ nhỏ cho banner 1" value="{{$setting->banner_one_small_text}}">
                    @error('banner1_small_text')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Banner 2 -->
                <div>
                    <label class="block mb-2 text-sm font-medium">Ảnh banner 2:</label>
                    <input type="file" name="banner2_image" class="border p-2 rounded w-full">
                    <img id="banner2-preview" src="{{ asset('asset/all_pic') }}/{{$setting->banner_two_pic}}" alt="Ảnh xem trước banner 2" class=" mt-2 w-64">
                    @error('banner2_image')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium">Chữ Lớn banner 2:</label>
                    <input type="text" name="banner2_large_text" class="border p-2 rounded w-full"
                        placeholder="Nhập chữ lớn cho banner 2" value="{{$setting->banner_two_big_text}}">
                    @error('banner2_large_text')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label class="block mb-2 text-sm font-medium">Chữ nhỏ banner 2:</label>
                    <input type="text" name="banner2_small_text" class="border p-2 rounded w-full"
                        placeholder="Nhập chữ nhỏ cho banner 2" value="{{$setting->banner_two_small_text}}">
                    @error('banner2_small_text')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Địa chỉ -->
                <div class="col-span-2">
                    <label class="block mb-2 text-sm font-medium">Địa chỉ:</label>
                    <!-- Địa chỉ dạng text -->
                    <input type="text" name="address" class="border p-2 rounded w-full mb-2" placeholder="Nhập địa chỉ" value="{{$setting->address}}">
                    <!-- Đoạn này giả sử có thể nhập trực tiếp trên Google Maps (bạn cần sử dụng API của Google Maps để thực hiện) -->
                    <!-- <div id="google-map"></div> -->
                    @error('address')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số điện thoại và Email -->
                <div>
                    <label class="block mb-2 text-sm font-medium">Số điện thoại:</label>
                    <input type="tel" value="{{$setting->phone}}" name="phone" class="border p-2 rounded w-full" placeholder="Nhập số điện thoại" >
                    @error('phone')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium">Email:</label>
                    <input type="email" value="{{$setting->email}}" name="email" class="border p-2 rounded w-full" placeholder="Nhập email">
                    @error('email')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-6">
                    <label class="block mb-2 text-sm font-medium">Phí ship:</label>
                    <input type="number" name="shipping_fee" class="border p-2 rounded w-full" placeholder="Nhập phí ship" min="0" value="{{$setting->shipping}}">
                    @error('shipping_fee')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit button -->
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded">
                    Lưu cài đặt
                </button>
            </div>
        </form>

        <script>
            document.querySelector('input[name="banner1_image"]').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewImage = document.getElementById('banner1-preview');
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden'); // Hiển thị ảnh xem trước
                    }
                    reader.readAsDataURL(file);
                }
            });

            document.querySelector('input[name="banner2_image"]').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewImage = document.getElementById('banner2-preview');
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden'); // Hiển thị ảnh xem trước
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </div>
@endsection
