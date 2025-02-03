<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginAdmin
{
    public function handle($request, Closure $next)
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect()->route('login');  // Điều hướng đến trang đăng nhập nếu chưa đăng nhập
        }

        return $next($request);  // Tiếp tục xử lý yêu cầu nếu đã đăng nhập
    }
}
