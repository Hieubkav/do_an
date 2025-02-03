<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Design;
use App\Models\Material;
use App\Models\Product;
use App\Models\Shape;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    function list(Request $request)
    {
        $conditions = [];
        $hasConditions = false;  // Biến kiểm tra xem có áp dụng điều kiện nào không

        // Các biến khởi tạo ban đầu
        $keyword = "";
        $category = "";
        $material = "";
        $brand = "";
        $shape = "";
        $source = "";
        $design = "";
        $sex = "";
        $nose_tick = "";
        $quantity = "";
        $version = "";
        $categories = Category::all();
        $materials = Material::all();
        $brands = Brand::all();
        $shapes = Shape::all();
        $sources = Source::all();
        $designs = Design::all();

        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $conditions[] = ["name", "LIKE", "%$keyword%"];
            $hasConditions = true;
        }

        if ($request->input('sex')) {
            $sex = $request->input('sex');
            if ($sex == 'Nam') {
                $conditions[] = ['sex', '=', 'male'];
            } elseif ($sex == 'Nữ') {
                $conditions[] = ['sex', '=', 'female'];
            } elseif ($sex == 'Unisex') {
                $conditions[] = ['sex', '=', 'unisex'];
            }
            $hasConditions = true;
        }

        if ($request->input('nose_tick')) {
            $nose_tick = $request->input('nose_tick');
            if ($nose_tick == 'yes') {
                $conditions[] = ['nose_tick', '=', 'yes'];
            } elseif ($nose_tick == 'no') {
                $conditions[] = ['nose_tick', '=', 'no'];
            }
            $hasConditions = true;
        }

        $products = Product::where($conditions);

        if ($request->input('category')) {
            $category = $request->input('category');
            $products = $products->whereHas('categories', function ($query) use ($category) {
                $query->where('name', $category);
            });
            $hasConditions = true;
        }

        if ($request->input('material')) {
            $material = $request->input('material');

            $products = $products->whereHas('material', function ($query) use ($material) {
                $query->where('name', $material);
            });
        }
        if ($request->input('brand')) {
            $brand = $request->input('brand');

            $products = $products->whereHas('brand', function ($query) use ($brand) {
                $query->where('name', $brand);
            });
        }
        if ($request->input('shape')) {
            $shape = $request->input('shape');

            $products = $products->whereHas('shape', function ($query) use ($shape) {
                $query->where('name', $shape);
            });
        }
        if ($request->input('source')) {
            $source = $request->input('source');

            $products = $products->whereHas('source', function ($query) use ($source) {
                $query->where('name', $source);
            });
        }
        if ($request->input('design')) {
            $design = $request->input('design');

            $products = $products->whereHas('design', function ($query) use ($design) {
                $query->where('name', $design);
            });
        }

        if ($request->input('sort')) {
            $sort = $request->input('sort');
            $order = $request->input('order');
            if ($sort == 'quantity') {
                $subquery = DB::table('versions')
                    ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
                    ->groupBy('product_id');

                $products = Product::select('products.*', 'sub.total_quantity')
                    ->leftJoinSub($subquery, 'sub', function ($join) {
                        $join->on('products.id', '=', 'sub.product_id');
                    })
                    ->orderBy('sub.total_quantity', $order);
                $hasConditions = true;
            } elseif ($sort == 'version') {
                $products = $products->withCount('versions')->orderBy('versions_count', $order);
                $hasConditions = true;
            } else {
                $products = $products->orderBy($sort, $order);
                $hasConditions = true;
            }
        }

        if (!$hasConditions) {
            $products = $products->orderBy('created_at', 'desc');  // Sắp xếp sản phẩm từ mới đến cũ
        }

        $products = $products->paginate(10);

        return view(
            'admin.list_product',
            compact('source', 'sources', 'design', 'designs', 'nose_tick', 'shapes', 'shape', 'products', 'keyword', 'categories', 'materials', 'brands', 'category', 'material', 'brand', 'sex')
        );
    }

    function add()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $materials = Material::all();
        $shapes = Shape::all();
        $designs = Design::all();
        $sources = Source::all();
        return view('admin.add_product', compact('sources', 'designs', 'shapes', 'brands', 'materials', 'categories'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'brand' => 'required|exists:brands,id',
                'material' => 'required|exists:materials,id',
                'shape' => 'required|exists:shapes,id',
                'design' => 'required|exists:designs,id',
                'source' => 'required|exists:sources,id',
                'des' => 'nullable|string',
                'sex' => 'required',
                'nose_tick' => 'required',
            ],
            [
                'required' => ":attribute không được để trống",
                'string' => ":attribute phải là chuỗi",
                'max' => ':attribute không được vượt quá :max ký tự',
                'min' => ":attribute phải có ít nhất :min ký tự hoặc giá trị",
                'numeric' => ":attribute phải là một số",
                'exists' => ":attribute không tồn tại trong hệ thống",
            ],
            [
                'name' => "Tên sản phẩm",
                'price' => 'Giá sản phẩm',
                'brand' => 'Thương hiệu',
                'material' => 'Chất liệu',
                'shape' => 'Hình dạng',
                'design' => 'Thiết kế',
                'des' => 'Nội dung',
                'sex' => 'Giới tính',
                'source' => 'Xuất xứ',
                'nose_tick' => 'Ve mũi',
            ]
        );

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'des' => $request->des,
            'sex' => $request->sex,
            'brand_id' => $request->brand,
            'material_id' => $request->material,
            'shape_id' => $request->shape,
            'design_id' => $request->design,
            'source_id' => $request->source,
            'nose_tick' => $request->nose_tick,
            'quantity' => 0,
            'quantity_version' => 0,
        ]);

        $categories = $request->input('category');
        $product->categories()->sync($categories);

        // return redirect('/admin/product/list')->with('status', 'Thêm sản phẩm thành công');
        return back()->with('status', 'Thêm sản phẩm thành công');
    }
    function delete($id)
    {
        $product = Product::find($id);

        $product->delete();

        return redirect('/admin/product/list')->with('status', 'Bạn đã xoá sản phẩm thành công');
    }
    function detail($id)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $materials = Material::all();
        $shapes = Shape::all();
        $designs = Design::all();
        $sources = Source::all();
        $product = Product::find($id);

        return view('admin.detail_product', compact('designs', 'shapes', 'sources', 'product', 'brands', 'materials', 'categories'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'brand' => 'required|exists:brands,id',
                'material' => 'required|exists:materials,id',
                'shape' => 'required|exists:shapes,id',
                'design' => 'required|exists:designs,id',
                'source' => 'required|exists:sources,id',
                'des' => 'nullable|string',
                'sex' => 'required',
                'nose_tick' => 'required',
            ],
            [
                'required' => ":attribute không được để trống",
                'string' => ":attribute phải là chuỗi",
                'max' => ':attribute không được vượt quá :max ký tự',
                'min' => ":attribute phải có ít nhất :min ký tự hoặc giá trị",
                'numeric' => ":attribute phải là một số",
                'exists' => ":attribute không tồn tại trong hệ thống",
            ],
            [
                'name' => "Tên sản phẩm",
                'price' => 'Giá sản phẩm',
                'brand' => 'Thương hiệu',
                'material' => 'Chất liệu',
                'shape' => 'Hình dạng',
                'design' => 'Thiết kế',
                'des' => 'Nội dung',
                'sex' => 'Giới tính',
                'source' => 'Xuất xứ',
                'nose_tick' => 'Ve mũi',
            ]
        );

        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'des' => $request->des,
            'sex' => $request->sex,
            'brand_id' => $request->brand,
            'material_id' => $request->material,
            'shape_id' => $request->shape,
            'design_id' => $request->design,
            'source_id' => $request->source,
            'nose_tick' => $request->nose_tick,
        ]);

        $categories = $request->input('category');
        $product->categories()->sync($categories);

        return back()->with('status', 'Cập nhật thành công');
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check == null)
            return redirect('/admin/product/list')->with('status', 'Vui lòng chọn bài viết để xoá');

        foreach ($list_check as $item) {
            $post = Product::find($item);
            $post->delete();
        }
        return redirect('/admin/product/list')->with('status', 'Bạn đã xoá bài viết đã chọn thành công');
    }
}
