<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Color;
use App\Models\ColorVersionSize;
use App\Models\Customer;
use App\Models\Design;
use App\Models\Material;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Shape;
use App\Models\Size;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    function store_front()
    {
        $setting = Setting::find(1);
        $categories = Category::where('status', 'show')->get();
        $products = Product::whereHas('versions', function ($query) {
            $query->whereHas('colorversionimages');
        })->get();

        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('main.store_front', compact('categories', 'products', 'posts', 'setting'));
    }

    function product_filter(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $designs = Design::all();
        $shapes = Shape::all();
        $sources = Source::all();
        $materials = Material::all();
        $colors = Color::all();
        $sizes = Size::all();
        $sort_by = "";
        $keyword = "";
        $condition = [];

        $category = "";
        $brand = "";
        $design = "";
        $shape = "";
        $source = "";
        $material = "";
        $sex = "";
        $nose_tick = "";
        $color = "";
        $size = "";

        // $products = Product::has('versions');
        $products = Product::whereHas('versions', function ($query) {
            $query->whereHas('colorVersionImages');
        });
        if ($request->keyword) {
            $keyword = $request->keyword;
            $products = $products->where('name', 'LIKE', "%$keyword%");
        }
        // Lọc dựa trên các tiêu chí
        if ($request->category) {
            $category = $request->category;

            $products = $products->whereHas('categories', function ($query) use ($request) {
                $query->where('category_id', $request->category);
            });
        }
        if ($request->brand) {
            $brand = $request->brand;

            $products = $products->where('brand_id', $request->brand);
        }
        if ($request->material) {
            $material = $request->material;

            $products = $products->where('material_id', $request->material);
        }
        if ($request->design) {
            $design = $request->design;

            $products = $products->where('design_id', $request->design);
        }
        if ($request->source) {
            $source = $request->source;
            $products = $products->where('source_id', $request->source);
        }
        if ($request->shape) {
            $shape = $request->shape;
            $products = $products->where('shape_id', $request->shape);
        }
        if ($request->color) {
            $color = $request->color;
            $products = $products->whereHas('versions.color', function ($query) use ($request) {
                $query->where('color_id', $request->color);
            });
        }
        if ($request->size) {
            $size = $request->size;

            $products = $products->whereHas('versions.colorversionimages.colorvertionsizes.size', function ($query) use ($request) {
                $query->where('size_id', $request->size);
            });
        }
        if ($request->sex) {
            $sex = $request->sex;

            $products = $products->where('sex', $request->sex);
        }

        if ($request->nose_tick) {
            $nose_tick = $request->nose_tick;

            $products = $products->where('nose_tick', $request->nose_tick);
        }

        // Khi truy vấn AI 
        if ($request->shape_face_ai) {
            if ($request->shape_face_ai == "Trái xoan") {
                $products = $products->whereIn('shape_id', [4, 9]);
            } else
            if ($request->shape_face_ai == "Dài") {
                $products = $products->whereIn('shape_id', [1, 2]);
            } else
            if ($request->shape_face_ai == "Tròn") {
                $products = $products->whereIn('shape_id', [4, 10]);
            } else
            if ($request->shape_face_ai == "Chữ nhật") {
                $products = $products->whereIn('shape_id', [1, 9]);
            } else
            if ($request->shape_face_ai == "Bầu dục") {
                $products = $products;
            } else
            if ($request->shape_face_ai == "Tam giác") {
                $products = $products->whereIn('shape_id', [1]);
            } else
            if ($request->shape_face_ai == "Trái tim") {
                $products = $products->whereIn('shape_id', [9, 10]);
            } else
            if ($request->shape_face_ai == "Vuông cân đối") {
                $products = $products->whereIn('shape_id', [1, 9]);
            } else
            if ($request->shape_face_ai == "Vuông cổ điển") {
                $products = $products->whereIn('shape_id', [9]);
            } else
            if ($request->shape_face_ai == "Vuông mềm mại") {
                $products = $products->whereIn('shape_id', [1]);
            } else
            if ($request->shape_face_ai == "Vuông") {
                $products = $products->whereIn('shape_id', [1, 9]);
            }
        }

        if ($request->sex_ai) {
            if ($request->sex_ai == 'nam') {
                $products = $products->where('sex', 'male');
            } else if ($request->sex_ai == 'nữ'){
                $products = $products->where('sex', 'female');
            }
        }

        if ($request->age_ai){
            // $tuoi = intval($request->age_ai);
            if ($request->age_ai < 18) {
                $products = $products->where('design_id', 8);
            } else if ($request->age_ai >= 18 && $request->age_ai <= 35) {
                $products = $products->where('design_id', 7);
            } else {
                $products = $products->where('design_id', 6);
            }
        }

        // Sắp xếp sản phẩm
        if ($request->sort_by) {
            $sort_by = $request->sort_by;

            if ($sort_by == 'price_asc') {
                $products = $products->orderBy('price', 'asc');
            } elseif ($sort_by == 'price_desc') {
                $products = $products->orderBy('price', 'desc');
            } elseif ($sort_by == 'newest') {
                $products = $products->orderBy('created_at', 'desc');
            } elseif ($sort_by == 'oldest') {
                $products = $products->orderBy('created_at', 'asc');
            } elseif ($sort_by == 'quantity_asc') {
                $products = Product::with('versions')
                    ->withCount(['versions as total_quantity' => function ($query) {
                        $query->select(DB::raw('SUM(quantity)'));
                    }])
                    ->orderBy('total_quantity', 'asc');
            } elseif ($sort_by == 'quantity_desc') {
                $products = Product::with('versions')
                    ->withCount(['versions as total_quantity' => function ($query) {
                        $query->select(DB::raw('SUM(quantity)'));
                    }])
                    ->orderBy('total_quantity', 'desc');
            }
        }

        if (empty($request->all())) {
            $products = $products->orderBy('created_at', 'desc');
        }

        $products = $products->paginate(12);

        return view(
            'main.product_filter',
            compact('sources', 'source', 'shapes', 'shape', 'design', 'designs', 'keyword', 'size', 'color', 'nose_tick', 'sex', 'material', 'brand', 'category', 'sort_by', 'products', 'categories', 'brands', 'materials', 'colors', 'sizes')
        );
    }

    public function product_detail($id)
    {
        $product = Product::find($id);

        $sex = "";
        if ($product->sex == 'male') $sex = "Nam";
        else if ($product->sex == 'female') $sex = "Nữ";
        else $sex = "Unisex";

        $nose_tick = "";
        if ($product->nose_tick == 'yes') $nose_tick = "Có";
        else $nose_tick = "Không";

        // Version của sản phẩm này 
        $versions = $product->versions;

        //List Pic Version
        $list_size = [];
        $list_pic = [];
        foreach ($versions as $version) {
            foreach ($version->colorversionimages as $pic) {
                foreach ($pic->colorvertionsizes as $size) {
                    $list_size[] = $size;
                }
                $list_pic[] = $pic;
            }
        }
        $list_size = array_unique($list_size);
        $list_pic  = array_unique($list_pic);

        return view('main.product_edit', compact('list_pic', 'product', 'sex', 'nose_tick', 'versions', 'list_size'));
    }

    public function cart_add(Request $request)
    {
        if (!empty($request->size_id) && !empty($request->color_id)) {
            $colorVersionSize = ColorVersionSize::find($request->size_id);

            if (!$colorVersionSize) {
                return response()->json(['status' => 'fail', 'message' => "Không tìm thấy size và màu sản phẩm"]);
            }

            $availableQuantity = $colorVersionSize->quantity;
            $cart = Auth::guard('customer')->user()->cart;
            $cart_item = CartItem::where('cart_id', $cart->id)->where('color_version_size_id', $request->size_id)->first();
            $quantityInCart = $cart_item ? $cart_item->quantity : 0;

            if ($request->lay_them + $quantityInCart > $availableQuantity) {
                return response()->json([
                    'status' => 'fail',
                    'message' => "Thêm quá số lượng (giỏ hàng: $quantityInCart sp,bạn thêm:$request->lay_them sp , chỉ còn: $availableQuantity sp).",
                ]);
            }

            $productPrice = $colorVersionSize->color_version_image->version->product->price;
            if ($quantityInCart == 0) {
                // Thêm sản phẩm
                CartItem::create([
                    'quantity' => $request->lay_them,
                    'price' => $productPrice,
                    'cart_id' => $cart->id,
                    'color_version_size_id' => $request->size_id,
                ]);
                // Giỏ hàng cập nhật
                $cart->update([
                    'total_item'  => $cart->cart_items->sum('quantity'),
                    'total_price' => $cart->cart_items->reduce(function ($carry, $item) {
                        return $carry + ($item->price * $item->quantity);
                    }, 0),
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => "Thêm và tạo mới",
                    'type' => "add_create",
                    'lay_them' => $request->lay_them,
                    'trong_gio' => $quantityInCart,
                    'price' => $productPrice,
                    'cart_id' => $cart->id,
                    'color_version_size_id' => $request->size_id,
                ]);
            } else {
                // Thêm sản phẩm
                $cart_item->update([
                    'quantity' => $request->lay_them + $quantityInCart,
                    'price' => $productPrice,
                ]);
                // Giỏ hàng cập nhật
                $cart->update([
                    'total_item'  => $cart->cart_items->sum('quantity'),
                    'total_price' => $cart->cart_items->reduce(function ($carry, $item) {
                        return $carry + ($item->price * $item->quantity);
                    }, 0),
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => "chỉ thêm",
                    'type' => "add",
                    'lay_them' => $request->lay_them,
                    'trong_gio' => $quantityInCart,
                    'price' => $productPrice,
                    'cart_id' => $cart->id,
                    'color_version_size_id' => $request->size_id,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'available_quantity' => $availableQuantity,
                'message' => "Thêm vào giỏ thành công",
                'added_quantity' => $request->lay_them,
                'quantity_in_cart' => $quantityInCart,
            ]);
        } else {
            return response()->json(['status' => 'fail', 'message' => "Vui lòng chọn màu và size"]);
        }
    }

    function cart()
    {
        $customer = Auth::guard('customer')->user();
        $cart = Cart::where('customer_id', $customer->id)->first();

        // Cập nhật lại giá của sản phẩm
        foreach ($cart->cart_items as $cart_items) {
            $cart_items->update([
                'price' => $cart_items->colorversionsize->color_version_image->version->product->price,
            ]);
        }
        // Cập nhật lại giá và số lượng giỏ hàng 
        $cart->update([
            'total_item'  => $cart->cart_items->sum('quantity'),
            'total_price' => $cart->cart_items->reduce(function ($carry, $item) {
                return $carry + ($item->price * $item->quantity);
            }, 0),
        ]);

        $totalQuantity = $cart->total_item;
        $totalPrice = $cart->total_price;
        $shipping = Setting::first()->shipping;
        $grandTotal = $totalPrice + $shipping;

        return view('main.cart_detail', [
            'cart' => $cart,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
            'shipping' => $shipping,
            'grandTotal' => $grandTotal,
        ]);
    }

    function delete_cart(Request $request, $cart_item_id)
    {
        $cart_item = CartItem::find($cart_item_id);

        $cart_item->delete();

        return back()->with('status', 'bạn đã xoá thành công');
    }

    function update_cart(Request $request)
    {
        $cart_item = CartItem::find($request->cartItemId);
        $limit = $cart_item->colorversionsize->quantity;

        if ($request->quantity > $limit) {
            return response()->json([
                'status' => 'fail',
                'quantity' => $limit,
            ]);
        }

        $cart = $cart_item->cart;
        $cart_item->update([
            'quantity' => $request->quantity,
        ]);

        $new_all_price = $request->quantity * $cart_item->price;

        // Giỏ hàng cập nhật
        $cart->update([
            'total_item'  => $cart->cart_items->sum('quantity'),
            'total_price' => $cart->cart_items->reduce(function ($carry, $item) {
                return $carry + ($item->price * $item->quantity);
            }, 0),
        ]);

        return response()->json([
            'status' => 'success',
            'new_all_price' => number_format($new_all_price) . " VND",
            'cart_quantity' => $cart->total_item,
            'all_price' => number_format($cart->total_price) . " VND",
            'grandTotal' => number_format($cart->total_price + $request->shipping) . " VND",
        ]);
    }
}
