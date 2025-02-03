@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto p-6 min-h-screen">
        <div class="bg-white border border-gray-300 rounded shadow-lg p-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h5 class="text-3xl font-bold text-gray-700 mb-4 md:mb-0">Chỉnh sửa phiên bản</h5>
                <a href="{{ route('list_version', $product->id) }}"
                    class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded focus:outline-none">
                    <i class="fa-solid fa-list"></i>
                </a>
            </div>

            <!-- Form -->
            <form id="myForm" action="{{ route('update_version', [$product->id, $version->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-500 font-bold mb-2">Tên phiên bản</label>
                    <input class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                        type="text" name="name" id="name" value="{{ $version->name }}">
                    @error('name')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Màu sắc -->
                <div class="mb-4">
                    <label for="title" class="block text-gray-500 font-bold mb-2">Màu</label>
                    <div class="w-full py-2 px-3 border bg-indigo-500 border-blue-300 rounded focus:outline-none focus:border-blue-500">
                        {{$color->name}}
                    </div>
                </div>

                <!-- Image Upload and Preview -->
                <div class="mb-4">
                    <label for="pic" class="block text-gray-500 font-bold mb-2">Ảnh phiên bản</label>
                    <input type="file" name="pic" id="pic"
                        class="w-full border rounded py-2 px-3 text-gray-700 focus:border-blue-500">
                    <div id="image-preview" class="mt-4">
                        <img src="{{ asset('asset/all_pic') }}/{{ $color_version_image->image }}" id="pic_show"
                            class="h-auto w-64 rounded shadow">
                    </div>
                    @error('pic')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- List Size -->
                <div class="my-8 ">
                    <label for="size" class="block text-gray-500 font-bold mb-2">
                        Danh sách size
                        <span class="italic text-red-400">(không nhập cùng size quá 1 lần, hoặc để trống số lượng)</span>
                        <button type="button" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded" onclick="addSizeRow()">
                            Add Size
                        </button>
                    </label>

                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-3xl mx-auto">
                        <div id="sizeList">
                            @foreach ($color_version_image->colorvertionsizes as $index => $item)
                                <div class="flex items-center mb-4">
                                    <select name="size[]" class="p-2 border rounded w-1/3 mr-4">
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->id }}"
                                                {{ $item->size->name === $size->name ? 'selected' : '' }}>
                                                {{ $size->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <input type="number" value="{{ $item->quantity }}" name="quantity[]"
                                        placeholder="Quantity" class="p-2 border rounded w-1/3 mr-4">
                                    <button type="button" class="px-2 py-1 bg-red-500 text-white rounded"
                                        onclick="removeSizeRow(this)">Remove</button>
                                </div>
                                @error('quantity.' . $index)
                                    <div class="mt-2 text-red-600">{{ $message }}</div>
                                @enderror
                            @endforeach
                        </div>
                    </div>
                    <script>
                        let selectedSizes = [];
                        function addSizeRow() {
                            const sizeRow = document.createElement('div');
                            sizeRow.classList.add('flex', 'items-center', 'mb-4');
                            sizeRow.innerHTML = `
                                <select name="size[]" class="p-2 border rounded w-1/3 mr-4">
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">
                                            {{ $size->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" name="quantity[]" placeholder="Quantity" class="p-2 border rounded w-1/3 mr-4">
                                <button type="button" class="px-2 py-1 bg-red-500 text-white rounded" onclick="removeSizeRow(this)">Remove</button>
                            `;

                            document.getElementById('sizeList').appendChild(sizeRow);
                        }


                        function removeSizeRow(button) {
                            button.parentElement.remove();
                        }
                    </script>
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
