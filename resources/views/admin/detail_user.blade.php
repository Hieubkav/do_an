@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="w-full max-w-2xl bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Chỉnh sửa tài khoản</h2>
            <form action="{{ route('update_user',$user->id) }}" method="post" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-600">Tên</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" required
                        class="mt-1 w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                @error('name')
                    <div class="mt-2 text-red-600">{{ $message }}</div>
                @enderror
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" required
                        class="mt-1 w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                @error('email')
                    <div class="mt-2 text-red-600">{{ $message }}</div>
                @enderror

                <div class="my-8 z-10">
                    <label for="role" class="block mb-1">Quyền</label>
                    <div class="relative">
                        <select id="role" name="role[]"
                            class="choices-multiple-selection w-full py-2 px-3 text-black border bg-gray-50 border-gray-300 rounded max-h-48 overflow-y-auto"
                            multiple="multiple">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    @if ($role->users()->wherePivot('user_id', $user->id)->exists()) selected @endif>
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


                <div>
                    <label for="password" class="block text-sm font-medium text-gray-600">
                        Password 
                        <span class="italic text-blue-500">
                            (Bỏ trống nếu không muốn đổi)
                        </span> 
                    </label>
                    <input type="password" name="password" id="password"
                        class="mt-1 w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                @error('password')
                    <div class="mt-2 text-red-600">{{ $message }}</div>
                @enderror

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Confirm
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="mt-1 w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                @error('password_confirmation')
                    <div class="mt-2 text-red-600">{{ $message }}</div>
                @enderror

                <div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
