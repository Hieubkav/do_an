@extends('layouts.main')

@section('content')
    <div class="w-full mx-auto bg-white p-8 rounded-lg shadow-md hover:shadow-2xl transition-shadow bg-gradient-to-r from-indigo-500 to-blue-500">
        <!-- Tiêu đề bài viết -->
        <h1 class="text-3xl md:text-5xl font-bold mb-4 text-center text-white border-b-2 pb-2">{{ $post->title }}</h1>

        <!-- Thông tin tác giả -->
        <div class="flex items-center justify-between mt-6 mb-6">
            <div class="flex items-center">
                {{-- <img src="{{ $post->user->avatar }}" alt="Ảnh đại diện của tác giả" class="w-12 h-12 rounded-full border-2 border-white mr-4"> --}}
                <div>
                    <p class="text-xl font-semibold text-white"><i class="fas fa-user-circle"></i> {{ $post->user->name }}</p>
                    <p class="text-sm text-white"><i class="fas fa-calendar-alt"></i> {{ $post->updated_at->format('d M, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Hình ảnh cho bài viết -->
        <div class="relative overflow-hidden rounded-lg mb-6">
            <img src="{{ asset('asset/all_pic') }}/{{ $post->image->link }}" alt="Ảnh minh họa cho bài viết" class="w-full max-h-96 object-cover rounded transform hover:scale-110 transition-transform">
        </div>

        <!-- Nội dung bài viết -->
        <div class="prose max-w-none text-gray-700 leading-relaxed bg-white p-6 rounded-lg">
            {!! $post->content !!}
        </div>
        
    </div>
@endsection
