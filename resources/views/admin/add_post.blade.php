@extends('layouts.dashboard')

@section('content')
<div id="content" class="container mx-auto p-6 min-h-screen">
    <div class="bg-white border border-gray-300 rounded shadow-lg p-6">

        <!-- Notification Messages -->
        @foreach(['success', 'error'] as $msg)
            @if(session($msg))
            <div class="mb-4 p-4 text-sm font-bold {{ $msg === 'error' ? 'text-red-700 bg-red-200 border-red-400' : 'text-green-700 bg-green-200 border-green-400' }} border-l-4 rounded">
                {{ session($msg) }}
            </div>
            @endif
        @endforeach

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h5 class="text-3xl font-bold text-gray-700 mb-4 md:mb-0">Thêm bài viết</h5>
        </div>

        <!-- Main Content -->
        <form action="{{ url('/admin/post/add/store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Tiêu đề</label>
                <input class="w-full px-4 py-2 border rounded-lg focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-shadow" type="text" name="name" id="name">

                @error('name')
                <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Ảnh bài viết</label>
                <input type="file" name="image" id="image" class="w-full px-4 py-2 border rounded-lg focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-shadow">
                <div id="image-preview" class="mt-4"></div> <!-- Image preview -->

                @error('image')
                <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-medium mb-2">Nội dung</label>
                <textarea id="basic-conf" name="content" class="w-full px-4 py-2 border rounded-lg focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-shadow"></textarea>

                @error('content')
                <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button value="Thêm mới" type="submit" name="btn-add" class="py-2 px-4 bg-indigo-600 text-white font-medium rounded hover:bg-indigo-700 transition-colors duration-300">
                Thêm mới
            </button>
        </form>

        <!-- Image preview script -->
        <script>
            var inputImage = document.getElementById('image');
            var imagePreview = document.getElementById('image-preview');

            inputImage.addEventListener('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-32', 'h-32', 'object-cover', 'rounded-md', 'shadow-lg');
                        imagePreview.innerHTML = '';
                        imagePreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </div>
</div>
@endsection
