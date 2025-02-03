<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserMainController extends Controller
{
    function list(Request $request)
    {
        $keyword = "";
        $role = "";
        $roles = Role::all();
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $users = User::where('name', 'LIKE', "%$keyword%")
            ->where('rule', 'staff');
        if ($request->input('role')) {
            $role = $request->input('role');

            $users=$users->whereHas('roles', function ($query) use($role) {
                $query->where('name', $role);
            });
        }

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            if ($sort=="quantity"){
                $users = $users->withCount('roles')->orderBy('roles_count', $order);
            } else $users = $users->orderBy($sort, $order);
        }

        $users = $users->paginate(10);

        return view('admin.list_user', compact('users', 'keyword','roles','role'));
    }
    function add()
    {
        $roles = Role::all();
        return view('admin.add_user', compact('roles'));
    }
    function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'role.*' => 'exists:roles,id', // Đảm bảo mỗi quyền chọn đều tồn tại
            'password' => 'required|min:6|confirmed|alpha_num',
        ], [
            'required' => ":attribute không được để trống",
            'email' => ":attribute không đúng định dạng",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'confirmed' => ':attribute xác nhận không khớp',
            'alpha_num' => ':attribute phải chứa ít nhất một chữ cái và một số',
            'exists' => ':attribute không tồn tại'
        ], [
            'name' => "Tên",
            'email' => "Email",
            'password' => "Mật khẩu",
            'role.*' => 'Quyền'
        ]);

        $data['password'] = Hash::make($data['password']);

        $user =  User::create($data);

        // Thêm quyền
        $roles = $request->input('role');
        $user->roles()->sync($roles);

        return back()->with('status', 'Thêm thành công');
    }
    function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return back()->with('status', 'Bạn đã xoá trang thành công');
    }
    function detail(Request $request, $id)
    {
        $roles = Role::all();
        $user = User::find($id);

        return view('admin.detail_user', compact('user', 'roles'));
    }
    public function update(Request $request, $id)
    {

        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find($id);

        // Update name và email
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Nếu có mật khẩu mới, cập nhật mật khẩu
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        // Thêm quyền
        $roles = $request->input('role');
        $user->roles()->sync($roles);

        return back()->with('status', 'Cập nhật tài khoản thành công');
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return redirect('/admin/user/list')->with('status', 'Vui lòng chọn trang để xoá');

        foreach ($list_check as $item) {
            $user = User::find($item);
            $user->delete();
        }
        return back()->with('status', 'Bạn đã xoá trang đã chọn thành công');
    }
}
