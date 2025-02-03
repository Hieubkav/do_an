<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user()->roles->pluck('id')->contains($role) and $request->user()->rule=='staff' ) {
            return redirect()->route('info')->with('status', 'Bạn không có quyền truy cập trang này!');
        }
        return $next($request);
    }
}
