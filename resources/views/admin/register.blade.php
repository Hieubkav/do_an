<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Register</title>
</head>
<body class="bg-gradient-to-r from-blue-400 to-purple-500 h-screen font-sans">
    <div class="container mx-auto h-full flex justify-center items-center px-4 sm:px-0">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full sm:w-96 space-y-4">
            <h1 class="text-3xl font-bold text-center text-gray-600 mb-5">Join Us!</h1>

            <!-- Notification Area -->
            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Thông báo</p>
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            <form action="{{ route('register') }}" method="post">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-500 mb-2">Name</label>
                    <input type="text" name="name" id="name" class="mt-1 p-2 w-full border rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-500 mb-2">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-500 mb-2">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 p-2 w-full border rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-500 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 p-2 w-full border rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring-2 focus:ring-blue-200 active:bg-blue-700 transition duration-150 ease-in-out">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
