<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\ColorVersionImage;
use App\Models\ColorVersionSize;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use App\Models\Version;
use Illuminate\Http\Request;

class AdminVersionController extends Controller
{
    function list(Request $request, $product_id)
    {
        $conditions = [];
        $keyword = "";
        $product = Product::find($product_id);
        // Lấy ra danh sách color_id trong bảng Version với product_id cho trước
        $existingColorIds = Version::where('product_id', $product_id)->pluck('color_id');
        // Lấy ra danh sách Color mà không nằm trong danh sách $existingColorIds
        $colors = Color::whereNotIn('id', $existingColorIds)->get();


        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
        }

        $versions = $product->versions()->where($conditions);

        // --sort
        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');
        }
        if ($sort == "color") {
            $versions = $versions->join('colors', 'versions.color_id', '=', 'colors.id')
                ->select('versions.*')  // Lấy tất cả các trường của bảng versions
                ->orderBy('colors.color', $order);
        } else if ($sort == "size") {
            $versions = $versions->join('sizes', 'versions.size_id', '=', 'sizes.id')
                ->select('versions.*')  // Lấy tất cả các trường của bảng versions
                ->orderBy('sizes.size', $order);
        } else $versions = $versions->orderBy($sort, $order);

        $versions = $versions->paginate(10);

        return view('admin.list_version', compact('colors', 'versions', 'keyword', 'product'));
    }
    function add($product_id)
    {
        $product = Product::find($product_id);
        $colors = Color::all();
        $sizes  = Size::all();

        return view('admin.add_version', compact('product', 'colors', 'sizes'));
    }
    function store(Request $request, $product_id)
    {
        $request->validate(
            [
                'name' => 'nullable|string|max:255',
                'pic' => 'required|mimes:jpg,jpeg,png,gif,webp,svg|max:4048',
            ],
            [
                'required' => ":attribute không được để trống",
                'string' => ":attribute phải là chuỗi",
                'max' => ':attribute không được vượt quá :max ký tự',
                'min' => ":attribute phải có ít nhất :min ký tự hoặc giá trị",
                'numeric' => ":attribute phải là một số",
                'exists' => ":attribute không tồn tại trong hệ thống",
                'distinct' => ':attribute không được trùng lặp.',
            ],
            [
                'name' => "Tên phiên bản",
                'pic' => 'Hình ảnh',
                'quantity' => "số lượng",
            ]
        );

        $version = Version::create([
            'name' => $request->name,
            'color_id' => $request->color,
            'quantity' => 0,
            'product_id' => $product_id,
        ]);

        if ($version->name == "") {
            $version->update([
                'name' => "Phiên bản màu " . $version->color->name,
            ]);
        }

        $color_version_image = $version->colorversionimages->where('color_id', $version->color->id)->first();
        if ($request->hasFile('pic')) {
            // /////////////
            // Thêm ảnh mới
            $image = $request->file('pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Tạo tên mới cho file ảnh
            $image->move(public_path('asset/all_pic'), $imageName); // Di chuyển file ảnh vào thư mục đích

            ColorVersionImage::create([
                'color_id' => $version->color->id,
                'version_id' => $version->id,
                'image' => $imageName,
            ]);
        }

        return back()->with('status', 'Thêm phiên bản thành công');
    }
    function delete($product_id, $version_id)
    {
        $version = Version::find($version_id);

        // Kiểm tra xem $version có tồn tại hay không
        if (!$version) {
            // Bạn có thể trả về một thông báo lỗi hoặc redirect đến một trang khác tại đây
            return redirect('/somewhere')->with('status', 'Phiên bản không tồn tại');
        }

        $version->delete();

        // Cập nhật số lượng sản phẩm và số lượng phiên bản
        $list_ver = Version::where('product_id', $product_id);
        $sum_version = 0;
        $sum_quantity = 0;
        foreach ($list_ver as $item) {
            $sum_version++;
            $sum_quantity += $item->quantity;
        }

        $product = Product::find($product_id);
        $product->update([
            'quantity' => $sum_quantity,
            'quantity_version' => $sum_version,
        ]);

        return back()->with('status', 'Bạn đã xoá phiên bản thành công');
    }
    function detail($product_id, $version_id, $color_id)
    {
        $colors = Color::all();
        $sizes  = Size::all();
        $version = Version::find($version_id);
        $product = Product::find($product_id);
        $color = Color::find($color_id);
        $color_version_image = $version->colorversionimages->where('color_id', $color->id)->first();
        return view('admin.detail_version', compact('color_version_image', 'color', 'product', 'version', 'colors', 'sizes'));
    }
    function update(Request $request, $product_id, $version_id)
    {
        $request->validate(
            [
                'name' => 'nullable|string|max:255',
                'pic' => 'mimes:jpg,jpeg,png,gif,webp,svg|max:4048',
                'quantity.*' => 'required|numeric|min:0',
                'size.*' => 'required|distinct',
            ],
            [
                'required' => ":attribute không được để trống",
                'string' => ":attribute phải là chuỗi",
                'max' => ':attribute không được vượt quá :max ký tự',
                'min' => ":attribute phải có ít nhất :min ký tự hoặc giá trị",
                'numeric' => ":attribute phải là một số",
                'exists' => ":attribute không tồn tại trong hệ thống",
                'distinct' => ':attribute không được trùng lặp.',
            ],
            [
                'name' => "Tên phiên bản",
                'quantity' => 'Số lượng',
                'pic' => 'Hình ảnh',
                'size' => "kích thước",
            ]
        );

        $version = Version::find($version_id);


        $version->update([
            'name' => $request->name,
        ]);
        if ($version->name == "") {
            $version->update([
                'name' => "Phiên bản màu " . $version->color->name,
            ]);
        }

        $color_version_image = $version->colorversionimages->where('color_id', $version->color->id)->first();
        if ($request->hasFile('pic')) {
            // /////////////
            // Xoá ảnh cũ 
            $old_pic = $color_version_image->image;
            $filePath = public_path('asset/all_pic/' . $old_pic);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Thêm ảnh mới
            $image = $request->file('pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Tạo tên mới cho file ảnh
            $image->move(public_path('asset/all_pic'), $imageName); // Di chuyển file ảnh vào thư mục đích

            $image_new = ColorVersionImage::find($color_version_image->id);
            $image_new->update([
                'image' => $imageName,
            ]);
        }

        ////////////////////////// Check size
        $list_size = $request->input('size');
        $list_quantity = $request->input('quantity');

        //Tìm ra colorversionimage
        $color_version_image = $version->colorversionimages->where('color_id', $version->color->id)->first();

        // Xoá đi toàn bộ size hiện tại 
        if (is_array($list_size) || is_object($list_size)) {
            foreach ($list_size as $item) {
                $colorversionsize = ColorVersionSize::where('color_version_image_id', $color_version_image->id)
                    ->where('size_id', $item)->first();
                if ($colorversionsize != null) $colorversionsize->delete();
            }
        }

        $sum_quantity = 0;
        // Thêm lại size mới-- đếm số lượng quantity
        if (is_array($list_size) || is_object($list_size)) {
            foreach ($list_size as $index => $item) {
                ColorVersionSize::create([
                    'color_version_image_id' => $color_version_image->id,
                    'size_id' => $item,
                    'quantity' => $list_quantity[$index],
                ]);

                $sum_quantity += $list_quantity[$index];
            }
        }

        $version->update([
            'quantity' => $sum_quantity,
        ]);

        // Cập nhật số lượng sản phẩm và số lượng phiên bản
        $list_ver = Version::where('product_id', $product_id);
        $sum_version = 0;
        foreach ($list_ver as $item) {
            $sum_version++;
        }

        $product = Product::find($product_id);
        $product->update([
            'quantity' => $sum_quantity,
            'quantity_version' => $sum_version,
        ]);

        return back()->with('status', 'Cập nhật thành công !');
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn phiên bản để xoá');

        foreach ($list_check as $item) {
            $verison = Version::find($item);
            $verison->delete();
        }

        $first_ver_id = $list_check[0];
        $first_ver = Version::find($first_ver_id);
        $product_id = $first_ver->id;

        // Cập nhật số lượng sản phẩm và số lượng phiên bản
        $list_ver = Version::where('product_id', $product_id);
        $sum_version = 0;
        $sum_quantity = 0;
        foreach ($list_ver as $item) {
            $sum_version++;
            $sum_quantity += $item->quantity;
        }

        $product = Product::find($product_id);
        $product->update([
            'quantity' => $sum_quantity,
            'quantity_version' => $sum_version,
        ]);

        return back()->with('status', 'Bạn đã xoá phiên bản đã chọn thành công');
    }
}
