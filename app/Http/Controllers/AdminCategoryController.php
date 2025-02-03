<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    function list(Request $request)
    {
        $keyword = "";
        $conditions = [];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
        }
        $categories = Category::where($conditions);

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            if ($sort == 'quantity') {
                $categories = $categories->withCount('products')
                    ->orderBy('products_count', $order);
            } else {
                $categories = $categories->orderBy($sort, $order);
            }
        }

        $categories = $categories->paginate(10);

        return view('admin.list_category', compact('categories', 'keyword'));
    }
    function add()
    {
        return view('admin.add_category');
    }
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'des' => 'required|string|max:255000',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
        ], [
            'name' => "Tên ",
            'des' => 'Mô tả', 
        ]);
        

        Category::create([
            'name' => $request->name,
            'des' => $request->des,
        ]);

        return back()->with('status', 'Thêm mới thành công');
    }
    function detail($id)
    {
        $category = Category::find($id);
        return view('admin.edit_category', compact('category'));
    }
    function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'des' => 'required|max:255000|string',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
            'unique' => ':attribute đã tồn tại',
        ], [
            'name' => "Tên ",
            'des' => 'Mô tả',
        ]);

        $category = Category::find($id);
        $category->update([
            'name' => $request->name,
            'des' => $request->des,
            'status' => $request->status,
        ]);

        return back()->with('status', 'Cập nhật thành công');
    }
    function delete($id)
    {
        $category = Category::find($id);
        $category->delete();

        return back()->with('status', 'Bạn đã xoá danh mục thành công');
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn danh mục để xoá');

        foreach ($list_check as $item) {
            $category = Category::find($item);
            $category->delete();
        }
        return back()->with('status', 'Bạn đã xoá danh mục đã chọn thành công');
    }
}
