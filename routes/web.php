<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminTypeController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminUserMainController;
use App\Http\Controllers\AdminVersionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FaceController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CreateOrController;

// Route::get('/', function () {
//     return view('layouts.dashboard');
// });

// -- Tài khoản staff/admin
Route::get('admin/login', [AdminUserController::class, 'showLoginForm'])->name('login');
Route::post('admin/login', [AdminUserController::class, 'login']);
Route::get('admin/register', [AdminUserController::class, 'showRegistrationForm'])->name('register');
Route::post('admin/register', [AdminUserController::class, 'register']);
Route::get('admin/logout', [AdminUserController::class, 'logout'])->name('logout');

// -- Route dùng khi đăng nhập admin
Route::middleware(['CheckLoginAdmin'])->group(function () {
    //Role quản lý bài viết
    Route::group(['middleware' => ['role:3']], function () {
        // -- Bài viết
        Route::get('admin/post/list', [AdminPostController::class, 'list'])
            ->name('list_post');
        Route::get('admin/post/add', [AdminPostController::class, 'add'])
            ->name('add_post');
        Route::post('admin/post/add/store', [AdminPostController::class, 'store'])
            ->name('store_post');
        Route::get('admin/post/delete/{id}', [AdminPostController::class, 'delete'])
            ->name('delete_post');
        Route::get('admin/post/detail/{id}', [AdminPostController::class, 'detail'])
            ->name('detail_post');
        Route::post('admin/post/update/{id}', [AdminPostController::class, 'update'])
            ->name('update_post');
        Route::post('admin/post/action', [AdminPostController::class, 'action'])
            ->name('action_post');
    });

    //Role quản lý Trang
    Route::group(['middleware' => ['role:4']], function () {
        // -- Trang
        Route::get('admin/page/list', [AdminPageController::class, 'list'])
            ->name('list_page');
        Route::get('admin/page/add', [AdminPageController::class, 'add'])
            ->name('add_page');
        Route::post('admin/page/add/store', [AdminPageController::class, 'store'])
            ->name('store_page');
        Route::get('admin/page/delete/{id}', [AdminPageController::class, 'delete'])
            ->name('delete_page');
        Route::get('admin/page/detail/{id}', [AdminPageController::class, 'detail'])
            ->name('detail_page');
        Route::post('admin/page/update/{id}', [AdminPageController::class, 'update'])
            ->name('update_page');
        Route::post('admin/page/action', [AdminPageController::class, 'action'])
            ->name('action_page');
    });

    //Role quản Tổng quan
    Route::group(['middleware' => ['role:1']], function () {
        Route::get('admin/dashboard', [AdminUserController::class, 'index'])->name('dashboard');
    });

    //Role quản sản phẩm
    Route::group(['middleware' => ['role:5']], function () {
        // -- Sản phẩm
        Route::get('admin/product/list', [AdminProductController::class, 'list'])
            ->name('list_product');
        Route::get('admin/product/add', [AdminProductController::class, 'add'])
            ->name('add_product');
        Route::post('admin/product/add/store', [AdminProductController::class, 'store'])
            ->name('store_product');
        Route::get('admin/product/delete/{id}', [AdminProductController::class, 'delete'])
            ->name('delete_product');
        Route::get('admin/product/detail/{id}', [AdminProductController::class, 'detail'])
            ->name('detail_product');
        Route::post('admin/product/update/{id}', [AdminProductController::class, 'update'])
            ->name('update_product');
        Route::post('admin/product/action', [AdminProductController::class, 'action'])
            ->name('action_product');
        // -- Phiên bản
        Route::get('admin/version/{product_id}/list', [AdminVersionController::class, 'list'])
            ->name('list_version');
        Route::get('admin/version/{product_id}/add', [AdminVersionController::class, 'add'])
            ->name('add_version');
        Route::post('admin/version/{product_id}/add/store', [AdminVersionController::class, 'store'])
            ->name('store_version');
        Route::get('admin/version/{product_id}/delete/{version_id}', [AdminVersionController::class, 'delete'])
            ->name('delete_version');
        Route::get('admin/version/{product_id}/detail/{version_id}/color/{color_id}', [AdminVersionController::class, 'detail'])
            ->name('detail_version');
        Route::post('admin/version/{product_id}/update/{version_id}', [AdminVersionController::class, 'update'])
            ->name('update_version');
        Route::post('admin/version/{product_id}/action', [AdminVersionController::class, 'action'])
            ->name('action_version');
        // -- Danh mục 
        Route::get('admin/category/list', [AdminCategoryController::class, 'list'])
            ->name('list_category');
        Route::get('admin/category/add', [AdminCategoryController::class, 'add'])
            ->name('add_category');
        Route::post('admin/category/add/store', [AdminCategoryController::class, 'store'])
            ->name('store_category');
        Route::get('admin/category/delete/{id}', [AdminCategoryController::class, 'delete'])
            ->name('delete_category');
        Route::get('admin/category/detail/{id}', [AdminCategoryController::class, 'detail'])
            ->name('detail_category');
        Route::post('admin/category/update/{id}', [AdminCategoryController::class, 'update'])
            ->name('update_category');
        Route::post('admin/category/action', [AdminCategoryController::class, 'action'])
            ->name('action_category');
    });

    //Role quản bán hàng 
    Route::group(['middleware' => ['role:6']], function () {
        // -- Đơn hàng 
        Route::get('admin/order/list', [AdminOrderController::class, 'list'])
            ->name('list_order');
        Route::get('admin/order/delete/{id}', [AdminOrderController::class, 'delete'])
            ->name('delete_order');
        Route::get('admin/order/detail/{id}', [AdminOrderController::class, 'detail'])
            ->name('detail_order');
        Route::post('admin/order/action', [AdminOrderController::class, 'action'])
            ->name('action_order');

        // Khách hàng 
        Route::get('admin/customer/list', [AdminCustomerController::class, 'list'])
            ->name('list_customer');
        Route::get('admin/customer/detail/{id}', [AdminCustomerController::class, 'detail'])
            ->name('detail_customer');
    });

    //Role quản phân loại
    Route::group(['middleware' => ['role:7']], function () {
        // -- Phân loại 
        //-- thương hiệu
        Route::get('admin/brand/list', [AdminTypeController::class, 'list_brand'])
            ->name('list_brand');
        Route::post('admin/brand/add/store', [AdminTypeController::class, 'store_brand'])
            ->name('store_brand');
        Route::get('admin/brand/delete/{id}', [AdminTypeController::class, 'delete_brand'])
            ->name('delete_brand');
        Route::post('admin/brand/update/{id}', [AdminTypeController::class, 'update_brand'])
            ->name('update_brand');
        Route::post('admin/brand/action', [AdminTypeController::class, 'action_brand'])
            ->name('action_brand');

        //-- thiết kế 
        Route::get('admin/design/list', [AdminTypeController::class, 'list_design'])
            ->name('list_design');
        Route::post('admin/design/add/store', [AdminTypeController::class, 'store_design'])
            ->name('store_design');
        Route::get('admin/design/delete/{id}', [AdminTypeController::class, 'delete_design'])
            ->name('delete_design');
        Route::post('admin/design/update/{id}', [AdminTypeController::class, 'update_design'])
            ->name('update_design');
        Route::post('admin/design/action', [AdminTypeController::class, 'action_design'])
            ->name('action_design');

        //-- hình dạng
        Route::get('admin/shape/list', [AdminTypeController::class, 'list_shape'])
            ->name('list_shape');
        Route::post('admin/shape/add/store', [AdminTypeController::class, 'store_shape'])
            ->name('store_shape');
        Route::get('admin/shape/delete/{id}', [AdminTypeController::class, 'delete_shape'])
            ->name('delete_shape');
        Route::post('admin/shape/update/{id}', [AdminTypeController::class, 'update_shape'])
            ->name('update_shape');
        Route::post('admin/shape/action', [AdminTypeController::class, 'action_shape'])
            ->name('action_shape');

        //-- chất liệu
        Route::get('admin/material/list', [AdminTypeController::class, 'list_material'])
            ->name('list_material');
        Route::post('admin/material/add/store', [AdminTypeController::class, 'store_material'])
            ->name('store_material');
        Route::get('admin/material/delete/{id}', [AdminTypeController::class, 'delete_material'])
            ->name('delete_material');
        Route::post('admin/material/update/{id}', [AdminTypeController::class, 'update_material'])
            ->name('update_material');
        Route::post('admin/material/action', [AdminTypeController::class, 'action_material'])
            ->name('action_material');

        //-- Xuất xứ
        Route::get('admin/source/list', [AdminTypeController::class, 'list_source'])
            ->name('list_source');
        Route::post('admin/source/add/store', [AdminTypeController::class, 'store_source'])
            ->name('store_source');
        Route::get('admin/source/delete/{id}', [AdminTypeController::class, 'delete_source'])
            ->name('delete_source');
        Route::post('admin/source/update/{id}', [AdminTypeController::class, 'update_source'])
            ->name('update_source');
        Route::post('admin/source/action', [AdminTypeController::class, 'action_source'])
            ->name('action_source');

        //-- Kích thước
        Route::get('admin/size/list', [AdminTypeController::class, 'list_size'])
            ->name('list_size');
        Route::post('admin/size/add/store', [AdminTypeController::class, 'store_size'])
            ->name('store_size');
        Route::get('admin/size/delete/{id}', [AdminTypeController::class, 'delete_size'])
            ->name('delete_size');
        Route::post('admin/size/update/{id}', [AdminTypeController::class, 'update_size'])
            ->name('update_size');
        Route::post('admin/size/action', [AdminTypeController::class, 'action_size'])
            ->name('action_size');

        //-- Màu sắc
        Route::get('admin/color/list', [AdminTypeController::class, 'list_color'])
            ->name('list_color');
        Route::post('admin/color/add/store', [AdminTypeController::class, 'store_color'])
            ->name('store_color');
        Route::get('admin/color/delete/{id}', [AdminTypeController::class, 'delete_color'])
            ->name('delete_color');
        Route::post('admin/color/update/{id}', [AdminTypeController::class, 'update_color'])
            ->name('update_color');
        Route::post('admin/color/action', [AdminTypeController::class, 'action_color'])
            ->name('action_color');
        // --------
    });

    // Role quản lý cài đặt 
    Route::group(['middleware' => ['role:8']], function () {
        Route::get('admin/setting',[AdminUserController::class,'setting'])->name('setting');
    });

    Route::get('admin/info', [AdminUserController::class, 'info'])->name('info');
    
    Route::post('admin/setting/update',[AdminUserController::class,'setting_update'])->name('setting_update');
    // --thông tin tài khoản
    Route::get('admin/profile/edit', [AdminUserController::class, 'edit'])->name('edit-profile');
    Route::post('admin/profile/update', [AdminUserController::class, 'update'])->name('update-profile');

    //Role quản tài khoản 
    Route::group(['middleware' => ['role:10']], function () {
        // -- User 
        Route::get('admin/user/list', [AdminUserMainController::class, 'list'])
            ->name('list_user');
        Route::get('admin/user/add', [AdminUserMainController::class, 'add'])
            ->name('add_user');
        Route::post('admin/user/add/store', [AdminUserMainController::class, 'store'])
            ->name('store_user');
        Route::get('admin/user/delete/{id}', [AdminUserMainController::class, 'delete'])
            ->name('delete_user');
        Route::get('admin/user/detail/{id}', [AdminUserMainController::class, 'detail'])
            ->name('detail_user');
        Route::post('admin/user/update/{id}', [AdminUserMainController::class, 'update'])
            ->name('update_user');
        Route::post('admin/user/action', [AdminUserMainController::class, 'action'])
            ->name('action_user');

        // -- Role 
        Route::get('admin/role/list', [AdminRoleController::class, 'list'])
            ->name('list_role');
    });
});


//////////-- Route dành cho khách chưa đăng nhập

//Route face 
Route::get('/face', [FaceController::class, 'index'])->name('face.detection');
Route::get('/ask', [FaceController::class, 'ask_form']);
Route::post('/ask_gg', [FaceController::class, 'ask']);

Route::get('/', [WebController::class, 'store_front'])->name('store_front');
Route::get('/product/filter', [WebController::class, 'product_filter'])->name('product_filter');
Route::get('/product/detail/{id}', [WebController::class, 'product_detail'])->name('product_webpage_detail');
Route::get('/post/{post_id}', [AdminPostController::class, 'post_user'])->name('post_user');
Route::get('/page/{page_id}', [AdminPostController::class, 'page_user'])->name('page_user');

Route::get('/login', [CustomerController::class, 'loginForm'])->name('customer_login');
Route::post('/login', [CustomerController::class, 'login'])->name('customer_login_store');
Route::get('/register', [CustomerController::class, 'registerForm'])->name('customer_register');
Route::post('/register', [CustomerController::class, 'register'])->name('customer_register_store');
Route::get('/logout', [CustomerController::class, 'logout'])->name('customer_logout');

// Route cho người dùng đã được đăng nhập
Route::middleware(['customer.auth'])->group(function () {
    Route::get('/profile/edit', [CustomerController::class, 'profile_edit'])->name('profile_customer_edit');
    Route::post('/profile/update', [CustomerController::class, 'profile_update'])->name('profile_customer_update');
    Route::get('/profile/order/history', [CustomerController::class, 'order_history'])->name('order_history');
    Route::get('/get-order-details/{orderId}', [CustomerController::class, 'getOrderDetails'])->name('getOrderDetails');

    // Để thêm vào giỏ cần đăng nhập
    Route::post('/product/cart_add/', [WebController::class, 'cart_add'])->name('cart_add');
    Route::get('/product/cart/show', [WebController::class, 'cart'])->name('cart_show');
    Route::get('/product/cart/delete/{cart_item_id}', [WebController::class, 'delete_cart'])->name('delete_cart');
    Route::post('/product/cart/update/', [WebController::class, 'update_cart'])->name('update_cart');

    //Thanh toán
    Route::get('/product/payment/show', [PayController::class, 'payment_show'])->name('payment_show');
    Route::post('/momo/create-payment', [PayController::class, 'createPayment'])->name('createPayment');
    Route::post('/momo/callback', [PayController::class, 'handleCallback'])->name('handleCallback');
    Route::post('/momo/payment_momo/atm', [PayController::class, 'payment_momo_atm'])->name('payment_momo_atm');
    Route::post('/momo/payment_momo/qr', [PayController::class, 'payment_momo_qr'])->name('payment_momo_qr');
    Route::get('/momo/ipn-handler', [PayController::class, 'handleMomoIPN'])->name('momo_ipn_handler');
});

//-----
//Route cho landing page
Route::get('/lacafe',[LandingController::class,'landing'])->name('landing');

//Route tạo ra mã qr
Route::get('/makeqr',[CreateOrController::class,'makeqr'])->name('makeqr');
Route::post('makeqr/code', [CreateOrController::class, 'payment_momo_qr'])->name('makeqr_payment_momo_qr');
Route::get('makeqr/show', [CreateOrController::class, 'handleMomoIPN'])->name('makeqr_momo_ipn_handler');