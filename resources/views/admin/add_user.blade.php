@extends('layouts.dashboard')

@section('content')
    <div id="content" class="container mx-auto px-2 sm:px-4">
        <div class="bg-white border border-gray-300 rounded shadow-lg">
            <div class="py-2 px-4 sm:px-6 border-b border-gray-300 flex flex-col sm:flex-row justify-between items-center">
                <h5 class="text-3xl font-bold text-gray-700 mb-4 sm:mb-0">
                    Thêm người dùng mới
                </h5>
            </div>
            <div class="p-4 sm:p-6">
                <form action="{{ route('store_user') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên</label>
                        <input type="text" name="name" id="name" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    @error('name')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    @error('email')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror

                    <!-- Quyền -->
                    <div class="my-8 z-10">
                        <label for="role" class="block mb-1">Quyền</label>
                        <div class="relative">
                            <select id="role" name="role[]"
                                class="choices-multiple-selection w-full py-2 px-3 text-black border bg-gray-50 border-gray-300 rounded max-h-48 overflow-y-auto"
                                multiple="multiple">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @error('role')
                            <div class="mt-2 text-red-600">{{ $message }}</div>
                        @enderror
                        <script>
                            const choices = new Choices('.choices-multiple-selection', {
                                removeItemButton: true,
                            });
                        </script>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                        <input type="password" name="password" id="password" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    @error('password')
                        <div class="mt-2 text-red-600">{{ $message }}</div>
                    @enderror
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Xác nhận mật
                            khẩu</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Thêm
                            mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
