<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{

    public function loginForm()
    {
        return view('main.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect('/');
        }

        return redirect()->back()->with('error', 'Email hoặc mật khẩu không chính xác.');
    }

    public function registerForm()
    {
        return view('main.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'name' => 'required|string|max:255',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Tạo tài khoản mới
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->password = bcrypt($request->input('password')); // Mã hóa mật khẩu trước khi lưu
        $customer->save();

        //Tạo giỏ hàng tương ứng cho khách hàng này 
        Cart::create([
            'total_item' => 0,
            'total_price' => 0,
            'customer_id' => $customer->id,
        ]);

        // Đăng nhập người dùng
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Điều hướng người dùng đến trang chính sau khi đăng ký thành công
            return redirect()->intended('/');
        }

        return back()->with('status', 'Đã xảy ra lỗi khi tạo tài khoản. Vui lòng thử lại.');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();

        // Hủy các session liên quan đến guard customer
        foreach (session()->all() as $key => $value) {
            if (Str::startsWith($key, 'login.customer.')) {
                session()->forget($key);
            }
        }

        return redirect()->route('store_front');
    }

    public function profile_edit()
    {
        // Lấy thông tin người dùng hiện tại
        $customer = Auth::guard('customer')->user();

        // Trả về view chỉnh sửa thông tin với dữ liệu của người dùng
        return view('main.profile_edit', compact('customer'));
    }
    public function profile_update(Request $request)
    {
        // Xác thực dữ liệu gửi về
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed', // Đảm bảo bạn thêm trường password_confirmation vào form
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Chuẩn bị dữ liệu cập nhật
        $data = [
            'name' => $request->name,
            // Không cần cập nhật email vì trong form bạn không cho phép người dùng thay đổi email
            'phone' => $request->phone,
            'address' => $request->address
        ];

        // Nếu người dùng muốn thay đổi mật khẩu
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Cập nhật thông tin người dùng
        $customer_id = Auth::guard('customer')->id();
        $customer = Customer::find($customer_id);
        $customer->update($data);

        // Điều hướng người dùng với thông báo cập nhật thành công
        return back()->with('status', 'Thông tin đã được cập nhật thành công.');
    }

    function order_history()
    {
        $orders = Order::where('customer_id', Auth::guard('customer')->id())
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('main.order_history', compact('orders'));
    }
    public function getOrderDetails($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('partials.order_details', compact('order'));
    }
}
