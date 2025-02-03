<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRoleController extends Controller
{
    // Thương hiệu
    function list(Request $request)
    {
        $keyword = "";
        $conditions = [];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
        }
        $roles = Role::where($conditions);

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            if ($sort == 'quantity') {
                $roles = $roles->withCount('users')
                    ->orderBy('users_count', $order);
            } else {
                $roles = $roles->orderBy($sort, $order);
            }
        }

        $roles = $roles->paginate(10);

        return view('admin.list_role', compact('roles', 'keyword'));
    }
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
        ], [
            'name' => "Tên",
        ]);

        Role::create([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Thêm mới thành công');
    }
    function delete($id)
    {
        $roles = Role::find($id);
        $roles->delete();

        return back()->with('status', 'Bạn đã xoá thành công');
    }
    function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($id),
            ],
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
            'unique' => ':attribute đã tồn tại',
        ], [
            'name' => "Tên ",
        ]);

        $role = Role::find($id);
        $role->update([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Cập nhật thành công');
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn mục tiêu để xoá');

        foreach ($list_check as $item) {
            $role = Role::find($item);
            $role->delete();
        }
        return back()->with('status', 'Bạn đã xoá mục tiêu đã chọn thành công');
    }
}
