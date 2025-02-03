@extends('layouts.main')

@section('content')
    <div class="gradient-background h-screen flex justify-center items-center">
        <div class="bg-white p-10 rounded-lg shadow-lg w-full max-w-lg transform transition-all hover:scale-105">

            <h2 class="text-3xl mb-8 text-center font-semibold text-blue-700 border-b pb-4">Chỉnh sửa thông tin</h2>

            <form action="{{ route('profile_customer_update') }}" method="POST">
                @csrf
                <div class="mb-6 space-y-4">
                    <div>
                        <label class="text-gray-700 text-sm font-medium mb-2 flex items-center">
                            <i class="fas fa-user-circle mr-2 text-blue-600"></i>
                            Tên:
                        </label>
                        <input value="{{$customer->name}}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-outline-blue"
                               id="name" type="text" placeholder="Nhập tên của bạn" name="name">
                        @error('name')
                            <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700 text-sm font-medium mb-2 flex items-center">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>
                            Email:
                        </label>
                        <div class="bg-green-200 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-outline-blue">{{$customer->email}}</div>
                    </div>

                    <div>
                        <label class="text-gray-700 text-sm font-medium mb-2 flex items-center">
                            <i class="fas fa-phone-alt mr-2 text-blue-600"></i>
                            Số điện thoại:
                        </label>
                        <input value="{{$customer->phone}}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-outline-blue"
                               id="phone" type="text" placeholder="Nhập số điện thoại của bạn" name="phone">
                        @error('phone')
                            <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700 text-sm font-medium mb-2 flex items-center">
                            <i class="fas fa-home mr-2 text-blue-600"></i>
                            Địa chỉ:
                        </label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-outline-blue"
                                  id="address" placeholder="Nhập địa chỉ của bạn" name="address" rows="3">{{$customer->address}}</textarea>
                        @error('address')
                            <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700 text-sm font-medium mb-2 flex items-center">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>
                            Mật khẩu:
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-outline-blue"
                               id="password" type="password" placeholder="Nhập mật khẩu mới nếu bạn muốn thay đổi"
                               name="password">
                        @error('password')
                            <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700 text-sm font-medium mb-2 flex items-center">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>
                            Xác nhận mật khẩu:
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-outline-blue"
                               id="password_confirmation" type="password" placeholder="Xác nhận mật khẩu của bạn"
                               name="password_confirmation">
                    </div>

                </div>

                <div class="flex items-center justify-end">
                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded focus:outline-none focus:shadow-outline-blue transform transition-all hover:scale-105"
                        type="submit">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
@endsection
