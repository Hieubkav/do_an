<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    function list(Request $request)
    {
        $keyword = $request->input('keyword', ''); // Mặc định giá trị là chuỗi rỗng

        // Mặc định giá trị sắp xếp
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');

        // Truy vấn sắp xếp mặc định hoặc theo input
        $posts = Post::orderBy($sort, $order);

        // Nếu có keyword, thì thêm điều kiện tìm kiếm
        if (!empty($keyword)) {
            $posts = $posts->where('title', 'LIKE', "%$keyword%");
        }

        // Phân trang
        $posts = $posts->paginate(10);

        return view('admin.list_post', compact('posts', 'keyword'));
    }
    function add()
    {
        return view('admin.add_post');
    }
    function store(Request $request)
    {
        // Bắt đầu xác minh dữ liệu từ người dùng
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp,svg|max:4048', // Đảm bảo ảnh tải lên có đúng định dạng và không quá lớn
            'name' => 'required|max:255|string', // Tiêu đề bài viết là chuỗi và không quá 255 ký tự
            'content' => 'required', // Nội dung bài viết không được để trống
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

        $imageName = ''; // Khởi tạo biến trả về

        // Kiểm tra xem người dùng có tải ảnh lên không
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Tạo tên mới cho file ảnh dựa trên thời gian hiện tại
            $image->move(public_path('asset/all_pic'), $imageName); // Di chuyển file ảnh vào thư mục đích
        }

        // Tạo ảnh mới 
        $image_pic = Image::create([
            'name' => $imageName,
            'link' => $imageName,
        ]);

        // Tạo bài viết mới với dữ liệu từ người dùng
        Post::create([
            'title' => $request->input('name'),
            'image_id' => $image_pic->id,
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);

        // Chuyển hướng người dùng về trang danh sách bài viết với thông báo
        return back()->with('status', 'Thêm bài viết thành công');
    }
    function delete($id)
    {
        $post = Post::find($id);
        $post->delete();

        return back()->with('status', 'Bạn đã xoá bài viết thành công');
    }
    function detail($id)
    {
        $post = Post::find($id);
        return view('admin.detail_post', compact('post'));
    }
    function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255|string',
            'pic' => 'mimes:jpg,jpeg,png,gif,webp,svg|max:4048',
            'content' => 'required|max:255000|string',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
        ], [
            'name' => "Tiêu đề trang",
            'image' => 'Ảnh trang',
            'content' => 'Nội dung trang'
        ]);

        $post = Post::find($id);
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        if ($request->hasFile('pic')) {
            // Xoá ảnh cũ 
            $old_pic = $post->image;
            $filePath = public_path('asset/all_pic/' . $old_pic->link);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Thêm ảnh mới
            $image = $request->file('pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Tạo tên mới cho file ảnh
            $image->move(public_path('asset/all_pic'), $imageName); // Di chuyển file ảnh vào thư mục đích

            $old_pic->update([
                'name' => $imageName,
                'link' => $imageName,
            ]);
        }

        return back()->with('status', 'Cập nhật thành công');
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn bài viết để xoá');

        foreach ($list_check as $item) {
            $post = Post::find($item);
            $post->delete();
        }
        return back()->with('status', 'Bạn đã xoá bài viết đã chọn thành công');
    }

    function post_user($id){
        $post = Post::find($id);
        return view('main.post', compact('post'));
    }

    function page_user($id){
        $page = Page::find($id);
        return view('main.page', compact('page'));
    }
}
