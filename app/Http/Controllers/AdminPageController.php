<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Page;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    function list(Request $request)
    {
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $pages = Page::where('title', 'LIKE', "%$keyword%")->paginate(10);

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');
            $pages = Page::orderBy($sort,$order)->paginate(10);
        }

        return view('admin.list_page', compact('pages', 'keyword'));
    }
    function add()
    {
        return view('admin.add_page');
    }
    function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp,svg|max:4048',
            'name' => 'required|max:255|string',
            'content' => 'required',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'confirmed' => "Xác nhận nhận mật không thành công",
        ], [
            'name' => "Tiêu đề trang",
            'image' => 'Ảnh trang',
            'content' => 'Nội dung trang'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Tạo tên mới cho file ảnh
            $image->move(public_path('asset/all_pic'), $imageName); // Di chuyển file ảnh vào thư mục đích
        }

        // Tạo ảnh mới 
        $image_pic = Image::create([
            'name' => $imageName,
            'link' => $imageName,
        ]);

        Page::create([
            'title' => $request->input('name'),
            'image_id' => $image_pic->id,
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);
        return back()->with('status', 'Thêm trang thành công');
    }
    function delete($id)
    {
        $page = Page::find($id);
        $page->delete();

        return back()->with('status', 'Bạn đã xoá trang thành công');
    }
    function detail($id)
    {
        $page = Page::find($id);
        
        return view('admin.detail_page',compact('page'));
    }
    function update(Request $request,$id)
    {
        $request->validate([
            'title'=> 'required|max:255|string',
            'pic' => 'mimes:jpg,jpeg,png,gif,webp,svg|max:4048',
            'content'=>'required|max:255000|string',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png,webp,svg hoặc gif',
        ], [
            'name' => "Tiêu đề trang",
            'image' => 'Ảnh trang',
            'content' => 'Nội dung trang'
        ]);

        $page = Page::find($id);
        $page->update([
            'title'=> $request->title,
            'content'=>$request->content,
            'user_id' => auth()->id(),
        ]);

        if ($request->hasFile('pic')) {
            // Xoá ảnh cũ 
            $old_pic = $page->image;
            $filePath = public_path('asset/all_pic/' . $old_pic->link);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Thêm ảnh mới
            $image = $request->file('pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Tạo tên mới cho file ảnh
            $image->move(public_path('asset/all_pic'), $imageName); // Di chuyển file ảnh vào thư mục đích

            $old_pic->update([
                'name'=>$imageName,
                'link'=>$imageName,
            ]);
        }

        return back()->with('status','Cập nhật thành công');
     
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check==null) 
        return redirect('/admin/page/list')->with('status', 'Vui lòng chọn trang để xoá');

        foreach ($list_check as $item) {
            $page = Page::find($item);
            $page->delete();
        }
        return back()->with('status', 'Bạn đã xoá trang đã chọn thành công');
    }
}
