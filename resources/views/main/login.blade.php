@extends('layouts.main')

@section('content')
<div class="gradient-background h-screen flex justify-center items-center">
    <div class="bg-white p-10 rounded-lg shadow-lg w-full max-w-md transform transition-all hover:scale-105">
        <h2 class="text-2xl mb-8 text-center font-bold text-blue-700">Đăng nhập</h2>
        <form action="{{route('customer_login_store')}}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-outline-blue" id="email" type="email" placeholder="Nhập email của bạn" name="email" required>
            </div>
            <div class="mb-7">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Mật khẩu:</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:shadow-outline-blue" id="password" type="password" placeholder="Nhập mật khẩu của bạn" name="password" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue transform transition-all hover:scale-105" type="submit">Đăng nhập</button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800 transition-colors duration-200" href="/register">Đăng ký tài khoản</a>
            </div>
        </form>
    </div>
</div>
@endsection
