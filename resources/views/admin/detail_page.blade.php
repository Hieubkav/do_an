@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto p-6 min-h-screen">
        <div class="bg-white border border-gray-300 rounded shadow-lg p-6">

            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h5 class="text-3xl font-bold text-gray-700 mb-4 md:mb-0">Chỉnh sửa trang</h5>
                <a href="{{ route('list_page') }}"
                    class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded focus:outline-none">
                    <i class="fa-solid fa-list"></i>
                </a>
            </div>

            <!-- Form -->
            <form id="myForm" action="{{ route('update_page', $page->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-gray-500 font-bold mb-2">Tên trang</label>
                    <input class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                        type="text" name="title" id="title" value="{{ $page->title }}">
                    @error('title')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Upload and Preview -->
                <div class="mb-4">
                    <label for="pic" class="block text-gray-500 font-bold mb-2">Ảnh trang</label>
                    <input type="file" name="pic" id="pic"
                        class="w-full border rounded py-2 px-3 text-gray-700 focus:border-blue-500">
                    <div id="image-preview" class="mt-4">
                        <img src="{{ asset('asset/all_pic') }}/{{ $page->image->link }}" id="pic_show"
                            class="h-auto w-64 rounded shadow">
                    </div>
                    @error('pic')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label for="content" class="block text-gray-500 font-bold mb-2">Nội dung</label>
                    <textarea id="basic-conf" name="content"
                        class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500">{{ $page->content }}</textarea>
                    @error('content')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Last Update -->
                <div class="mb-4">
                    <label for="last_up" class="block text-gray-500 font-bold mb-2">Cập nhật cuối</label>
                    <input
                        class="w-full py-2 px-3 bg-gray-100 text-green-700 border border-gray-300 rounded focus:outline-none"
                        type="text"
                        value="{{ $page->user->name }} - cập nhật lúc: {{ ('App\Helpers\Support')::change_date($page->updated_at) }}"
                        readonly>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3 px-6 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-shadow  duration-300 ease-in-out shadow-md font-semibold">Cập
                    nhật</button>
            </form>
        </div>

        <!-- JavaScript for Image Upload -->
        <script>
            // Elements
            var inputImage = document.getElementById('pic');
            var imagePreview = document.getElementById('image-preview');
            var currentPicInput = document.createElement('input');
            currentPicInput.setAttribute('type', 'hidden');
            currentPicInput.setAttribute('name', 'current_pic');
            document.getElementById('myForm').appendChild(currentPicInput);

            // Event Listener for Image Change
            inputImage.addEventListener('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = new Image();
                        img.src = e.target.result;
                        img.className = 'h-auto w-64 rounded shadow';
                        imagePreview.innerHTML = '';
                        imagePreview.appendChild(img);
                        currentPicInput.value = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endsection
