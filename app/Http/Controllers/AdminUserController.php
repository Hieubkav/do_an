<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ColorVersionSize;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // Lấy ra tất cả đơn hàng
        $orders = Order::all();

        // Lấy ra đơn hàng trong tháng hiện tại
        $ordersMonth = Order::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->get();

        // Lấy ra đơn hàng trong tuần hiện tại
        $startOfWeek = $now->startOfWeek()->toDateTimeString();
        $endOfWeek = $now->endOfWeek()->toDateTimeString();
        $ordersWeek = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();

        // Lấy ra đơn hàng trong ngày hiện tại
        $ordersDay = Order::whereDate('created_at', Carbon::today())->get();

        // Khởi tạo mảng để lưu trữ doanh thu theo tuần
        $data_month = [0, 0, 0, 0, 0];
        // foreach ($ordersMonth as $order) {
        //     // Tìm xem đơn hàng này thuộc tuần nào trong tháng
        //     $weekOfMonth = (int) $order->created_at->format('W') - (int) $now->startOfMonth()->format('W') + 1;
        //     // Cộng dồn total_price vào tuần tương ứng
        //     $data_month[$weekOfMonth - 1] += $order->total_price;
        // }
        foreach ($ordersMonth as $order) {
            $weekOfMonth = (int) $order->created_at->format('W') - (int) $now->startOfMonth()->format('W') + 1;

            // Đảm bảo weekOfMonth nằm trong khoảng 1 đến 5
            if ($weekOfMonth < 1) {
                $weekOfMonth = 1;
            } elseif ($weekOfMonth > 5) {
                $weekOfMonth = 5;
            }

            $data_month[$weekOfMonth - 1] += $order->total_price;
        }

        // Khởi tạo mảng để lưu trữ doanh thu theo ngày
        $data_week = [0, 0, 0, 0, 0, 0, 0];
        // foreach ($ordersWeek as $order) {
        //     // Tìm xem đơn hàng này thuộc ngày nào trong tuần
        //     $dayOfWeek = $order->created_at->dayOfWeek - 1;
        //     // Cộng dồn total_price vào ngày tương ứng
        //     $data_week[$dayOfWeek] += $order->total_price;
        // }
        foreach ($ordersWeek as $order) {
            // Tìm xem đơn hàng này thuộc ngày nào trong tuần
            $dayOfWeek = $order->created_at->dayOfWeek;

            // Trong PHP, Chủ Nhật có giá trị là 0, chuyển nó thành 7
            if ($dayOfWeek == 0) {
                $dayOfWeek = 7;
            }

            // Điều chỉnh chỉ số mảng để nó bắt đầu từ 0
            $data_week[$dayOfWeek - 1] += $order->total_price;
        }


        // Lấy ra 3 khách hàng có tổng tiền mua hàng lớn nhất trong tháng
        $topCustomers = Customer::withSum(['orders' => function ($query) use ($now) {
            $query->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year);
        }], 'total_price')
            ->orderByDesc('orders_sum_total_price')
            ->limit(3)
            ->get();

        // Lấy ra những sản phẩm bán chạy trong tuần 
        $list_order_item_size = $ordersMonth->pluck('order_items')
            ->flatten()
            ->groupBy('color_version_size_id')
            ->map(function ($group) {
                return $group->reduce(function ($carry, $item) {
                    if ($carry === null) {
                        return $item;
                    } else {
                        $carry->quantity += $item->quantity;
                        return $carry;
                    }
                });
            })->sortByDesc(function ($item) {
                return $item->quantity;
            })
            ->values()->take(5);
        // Truyền dữ liệu qua view
        return view('admin.dashboard', compact('list_order_item_size', 'now', 'orders', 'ordersMonth', 'ordersWeek', 'ordersDay', 'data_month', 'data_week', 'topCustomers'));
    }

    function info()
    {
        return view('admin.info');;
    }
    function setting()
    {
        $setting = Setting::first();
        return view('admin.setting', compact('setting'));
    }
    function setting_update(Request $request)
    {
        $request->validate([
            'banner1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner1_large_text' => 'required|string|max:255',
            'banner1_small_text' => 'required|string|max:255',
            'banner2_large_text' => 'required|string|max:255',
            'banner2_small_text' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'shipping_fee' => 'required',
        ], [
            'required' => ":attribute không được để trống",
            'string' => ":attribute phải là một chuỗi ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'image' => ':attribute phải là một hình ảnh',
            'mimes' => ':attribute phải có định dạng: :values',
            'email' => ':attribute phải là một địa chỉ email hợp lệ',
        ], [
            'banner1_image' => "Ảnh banner 1",
            'banner2_image' => 'Ảnh banner 2',
            'banner1_large_text' => 'Văn bản lớn banner 1',
            'banner1_small_text' => 'Văn bản nhỏ banner 1',
            'banner2_large_text' => 'Văn bản lớn banner 2',
            'banner2_small_text' => 'Văn bản nhỏ banner 2',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'email' => 'Địa chỉ email',
            'shipping_fee' => 'Phí ship'
        ]);

        // Lưu thông tin cơ bản
        $setting = Setting::find(1);
        $setting->update([
            'banner_one_big_text' => $request->banner1_large_text,
            'banner_one_small_text' => $request->banner1_small_text,
            'banner_two_big_text' => $request->banner2_large_text,
            'banner_two_small_text' => $request->banner2_small_text,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'shipping' => $request->shipping_fee,
        ]);

        if ($request->hasFile('banner1_image')) {
            // Xoá ảnh cũ 
            $old_pic = $setting->banner_one_pic;
            $filePath = public_path('asset/all_pic/' . $old_pic);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Thêm ảnh mới
            $image = $request->file('banner1_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Tạo tên mới cho file ảnh
            $image->move(public_path('asset/all_pic'), $imageName); // Di chuyển file ảnh vào thư mục đích

            $setting->update([
                'banner_one_pic' => $imageName,
            ]);
        }

        if ($request->hasFile('banner2_image')) {
            // Xoá ảnh cũ 
            $old_pic = $setting->banner_two_pic;
            $filePath = public_path('asset/all_pic/' . $old_pic);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Thêm ảnh mới
            $image = $request->file('banner2_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Tạo tên mới cho file ảnh
            $image->move(public_path('asset/all_pic'), $imageName); // Di chuyển file ảnh vào thư mục đích

            $setting->update([
                'banner_two_pic' => $imageName,
            ]);
        }

        return back()->with('status', 'Cài đặt đã được lưu!');
    }
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard')->with('status', 'Đăng nhập thành công');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('login')->with('status', 'Registration successful. Please login.');
    }

    public function logout()
    {
        Auth::logout();
        // Hủy các session liên quan đến guard web
        foreach (session()->all() as $key => $value) {
            if (Str::startsWith($key, 'login.web.')) {
                session()->forget($key);
            }
        }
        return redirect()->route('login');
    }
    // 
    public function edit()
    {
        $user = Auth::user();
        return view('admin.edit_profile', compact('user'));
    }

    public function update(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $id = Auth::id();
        $user = User::find($id);

        // Update name và email
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Nếu có mật khẩu mới, cập nhật mật khẩu
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('edit-profile')->with('status', 'Cập nhật tài khoản thành công');
    }
}
