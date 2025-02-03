<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Design;
use App\Models\Material;
use App\Models\Shape;
use App\Models\Size;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminTypeController extends Controller
{
    // Thương hiệu
    function list_brand(Request $request)
    {
        $keyword = "";
        $conditions = [];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
        }
        $brands = Brand::where($conditions);

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            if ($sort == 'quantity') {
                $brands = $brands->withCount('products')
                    ->orderBy('products_count', $order);
            } else {
                $brands = $brands->orderBy($sort, $order);
            }
        }

        $brands = $brands->paginate(10);

        return view('admin.list_brand', compact('brands', 'keyword'));
    }
    function store_brand(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
        ], [
            'name' => "Tên",
        ]);

        Brand::create([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Thêm mới thành công');
    }
    function delete_brand($id)
    {
        $brands = Brand::find($id);
        $brands->delete();

        return back()->with('status', 'Bạn đã xoá thành công');
    }
    function update_brand(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'name')->ignore($id),
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

        $brand = Brand::find($id);
        $brand->update([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Cập nhật thành công');
    }
    function action_brand(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn mục tiêu để xoá');

        foreach ($list_check as $item) {
            $brand = Brand::find($item);
            $brand->delete();
        }
        return back()->with('status', 'Bạn đã xoá mục tiêu đã chọn thành công');
    }
    ////

    // Thiết kế
    function list_design(Request $request)
    {
        $keyword = "";
        $conditions = [];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
        }
        $designs = Design::where($conditions);

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            if ($sort == 'quantity') {
                $designs = $designs->withCount('products')
                    ->orderBy('products_count', $order);
            } else {
                $designs = $designs->orderBy($sort, $order);
            }
        }

        $designs = $designs->paginate(10);

        return view('admin.list_design', compact('designs', 'keyword'));
    }
    function store_design(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:designs,name',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
        ], [
            'name' => "Tên",
        ]);

        Design::create([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Thêm mới thành công');
    }
    function delete_design($id)
    {
        $designs = Design::find($id);
        $designs->delete();

        return back()->with('status', 'Bạn đã xoá thành công');
    }
    function update_design(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('designs', 'name')->ignore($id),
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

        $design = Design::find($id);
        $design->update([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Cập nhật thành công');
    }
    function action_design(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn mục tiêu để xoá');

        foreach ($list_check as $item) {
            $design = Design::find($item);
            $design->delete();
        }
        return back()->with('status', 'Bạn đã xoá mục tiêu đã chọn thành công');
    }

    // Hình dạng 
    function list_shape(Request $request)
    {
        $keyword = "";
        $conditions = [];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
        }
        $shapes = Shape::where($conditions);

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            if ($sort == 'quantity') {
                $shapes = $shapes->withCount('products')
                    ->orderBy('products_count', $order);
            } else {
                $shapes = $shapes->orderBy($sort, $order);
            }
        }

        $shapes = $shapes->paginate(10);

        return view('admin.list_shape', compact('shapes', 'keyword'));
    }
    function store_shape(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:shapes,name',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
        ], [
            'name' => "Tên",
        ]);

        Shape::create([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Thêm mới thành công');
    }
    function delete_shape($id)
    {
        $shapes = Shape::find($id);
        $shapes->delete();

        return back()->with('status', 'Bạn đã xoá thành công');
    }
    function update_shape(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('shapes', 'name')->ignore($id),
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

        $shape = Shape::find($id);
        $shape->update([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Cập nhật thành công');
    }
    function action_shape(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn mục tiêu để xoá');

        foreach ($list_check as $item) {
            $shape = Shape::find($item);
            $shape->delete();
        }
        return back()->with('status', 'Bạn đã xoá mục tiêu đã chọn thành công');
    }

    // Chất liệu
    function list_material(Request $request)
    {
        $keyword = "";
        $conditions = [];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
        }
        $materials = Material::where($conditions);

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            if ($sort == 'quantity') {
                $materials = $materials->withCount('products')
                    ->orderBy('products_count', $order);
            } else {
                $materials = $materials->orderBy($sort, $order);
            }
        }

        $materials = $materials->paginate(10);

        return view('admin.list_material', compact('materials', 'keyword'));
    }
    function store_material(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:materials,name',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
        ], [
            'name' => "Tên",
        ]);

        Material::create([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Thêm mới thành công');
    }
    function delete_material($id)
    {
        $materials = Material::find($id);
        $materials->delete();

        return back()->with('status', 'Bạn đã xoá thành công');
    }
    function update_material(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('materials', 'name')->ignore($id),
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

        $material = Material::find($id);
        $material->update([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Cập nhật thành công');
    }
    function action_material(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn mục tiêu để xoá');

        foreach ($list_check as $item) {
            $material = Material::find($item);
            $material->delete();
        }
        return back()->with('status', 'Bạn đã xoá mục tiêu đã chọn thành công');
    }

    // Xuất xứ
    function list_source(Request $request)
    {
        $keyword = "";
        $conditions = [];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
        }
        $sources = Source::where($conditions);

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            if ($sort == 'quantity') {
                $sources = $sources->withCount('products')
                    ->orderBy('products_count', $order);
            } else {
                $sources = $sources->orderBy($sort, $order);
            }
        }

        $sources = $sources->paginate(10);

        return view('admin.list_source', compact('sources', 'keyword'));
    }
    function store_source(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sources,name',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
        ], [
            'name' => "Tên",
        ]);

        Source::create([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Thêm mới thành công');
    }
    function delete_source($id)
    {
        $sources = Source::find($id);
        $sources->delete();

        return back()->with('status', 'Bạn đã xoá thành công');
    }
    function update_source(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sources', 'name')->ignore($id),
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

        $source = Source::find($id);
        $source->update([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Cập nhật thành công');
    }
    function action_source(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn mục tiêu để xoá');

        foreach ($list_check as $item) {
            $source = Source::find($item);
            $source->delete();
        }
        return back()->with('status', 'Bạn đã xoá mục tiêu đã chọn thành công');
    }

    // Kích thước
    function list_size(Request $request)
    {
        $keyword = "";
        $conditions = [];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
        }
        $sizes = Size::where($conditions);

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            $sizes = $sizes->orderBy($sort, $order);
        }

        $sizes = $sizes->paginate(10);

        return view('admin.list_size', compact('sizes', 'keyword'));
    }
    function store_size(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
        ], [
            'name' => "Tên",
        ]);

        Size::create([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Thêm mới thành công');
    }
    function delete_size($id)
    {
        $sizes = Size::find($id);
        $sizes->delete();

        return back()->with('status', 'Bạn đã xoá thành công');
    }
    function update_size(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sizes', 'name')->ignore($id),
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

        $size = Size::find($id);
        $size->update([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Cập nhật thành công');
    }
    function action_size(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn mục tiêu để xoá');

        foreach ($list_check as $item) {
            $size = Size::find($item);
            $size->delete();
        }
        return back()->with('status', 'Bạn đã xoá mục tiêu đã chọn thành công');
    }
    // Màu sắc 
    function list_color(Request $request)
    {
        $keyword = "";
        $conditions = [];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
        }
        $colors = Color::where($conditions);

        $sort = 'id';
        $order = 'asc';
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            $colors = $colors->orderBy($sort, $order);
        }

        $colors = $colors->paginate(10);

        return view('admin.list_color', compact('colors', 'keyword'));
    }
    function store_color(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:colors,name',
        ], [
            'required' => ":attribute không được để trống",
            'min' => ":attribute có độ dài ít nhất :min ký tự",
            'max' => ':attribute có độ dài tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'mimes' => 'Bức ảnh phải có đuôi là jpg,jpeg,png hoặc gif',
        ], [
            'name' => "Tên",
        ]);

        Color::create([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Thêm mới thành công');
    }
    function delete_color($id)
    {
        $colors = Color::find($id);
        $colors->delete();

        return back()->with('status', 'Bạn đã xoá thành công');
    }
    function update_color(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('colors', 'name')->ignore($id),
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

        $color = Color::find($id);
        $color->update([
            'name' => $request->name,
        ]);

        return back()->with('status', 'Cập nhật thành công');
    }
    function action_color(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return back()->with('status', 'Vui lòng chọn mục tiêu để xoá');

        foreach ($list_check as $item) {
            $color = Color::find($item);
            $color->delete();
        }
        return back()->with('status', 'Bạn đã xoá mục tiêu đã chọn thành công');
    }
}
