<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function list(Request $request)
    {
        // Khởi tạo biến
        $keyword = "";

        // Khởi tạo truy vấn
        $customersQuery = Customer::query();

        if ($request->keyword) {
            $keyword = $request->keyword;
            $customersQuery->where('name', 'LIKE', "%$keyword%");
        }

        // Xác định cách sắp xếp và phân trang
        $sort = $request->input('sort', 'updated_at');
        $order = $request->input('order', 'desc');

        $customers = $customersQuery->orderBy($sort, $order)->paginate(10);

        return view('admin.list_customer', compact('customers','keyword'));
    }
    function detail($id)
    {
        $order = Customer::find($id);
        return view('admin.detail_customer', compact('customer'));
    }
}
