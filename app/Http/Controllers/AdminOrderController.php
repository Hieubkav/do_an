<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Image;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function list(Request $request)
    {
        // Lấy danh sách khách hàng có ít nhất một đơn hàng
        $customers = Customer::has('orders')->get();

        // Khởi tạo biến
        $customer = "";
        $keyword = "";

        // Khởi tạo truy vấn
        $ordersQuery = Order::query();

        // Thêm điều kiện cho truy vấn nếu có thông tin từ request
        if ($request->customer_name) {
            $customer = $request->customer_name;
            $ordersQuery->where('customer_id', '=', $customer);
        }

        if ($request->order_code) {
            $keyword = $request->order_code;
            $ordersQuery->where('id', 'LIKE', "%$keyword%");
        }

        // Xác định cách sắp xếp và phân trang
        $sort = $request->input('sort', 'updated_at');
        $order = $request->input('order', 'desc');

        $orders = $ordersQuery->orderBy($sort, $order)->paginate(10);

        return view('admin.list_order', compact('orders', 'customers', 'customer','keyword'));
    }
    function delete($id)
    {
        $order = Order::find($id);
        $order->delete();

        return back()->with('status', 'Bạn đã xoá thành công');
    }
    function detail($id)
    {
        $order = Order::find($id);
        return view('admin.detail_order', compact('order'));
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn trang để xoá');

        foreach ($list_check as $item) {
            $order = Order::find($item);
            $order->delete();
        }
        return back()->with('status', 'Bạn đã xoá trang đã chọn thành công');
    }
}
