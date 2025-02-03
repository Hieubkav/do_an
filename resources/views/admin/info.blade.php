@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="container mx-auto">
        <!-- Tiêu đề và mô tả -->
        <header class="mb-10">
            <h1 class="text-3xl font-extrabold mb-4">Hướng Dẫn Sử Dụng Bảng Điều Khiển</h1>
            <p class="text-lg text-gray-600">Dưới đây là hướng dẫn chi tiết về cách sử dụng các chức năng trong bảng điều khiển của bạn. Hãy đảm bảo bạn đã đọc kỹ và hiểu rõ về cách thức hoạt động của từng phần để tận dụng tối đa các tính năng mà chúng tôi cung cấp.</p>
        </header>

        <!-- Hướng dẫn cho từng chức năng -->
        <div class="space-y-12">
             <!-- Tổng quan -->
             <section>
                <h2 class="text-xl font-semibold">Tổng Quan</h2>
                <p>Trang Tổng Quan cung cấp cái nhìn tổng quan về tình hình hoạt động của website. Bạn có thể xem số liệu thống kê, biểu đồ hoạt động, và các thông báo quan trọng ở đây.</p>
            </section>

            <!-- Trang -->
            <section>
                <h2 class="text-xl font-semibold">Trang</h2>
                <p>Chức năng này cho phép bạn quản lý các trang tĩnh trên website của mình. Bạn có thể thêm, chỉnh sửa, và xóa các trang từ khu vực này.</p>
            </section>

            <!-- Bài viết -->
            <section>
                <h2 class="text-xl font-semibold">Bài Viết</h2>
                <p>Quản lý nội dung bài viết, bao gồm việc thêm mới, chỉnh sửa và xóa bài viết. Bạn cũng có thể thiết lập các danh mục và thẻ cho bài viết.</p>
            </section>

            <!-- Sản phẩm -->
            <section>
                <h2 class="text-xl font-semibold">Sản Phẩm</h2>
                <p>Chức năng này giúp bạn quản lý kho sản phẩm, cập nhật thông tin sản phẩm, giá cả, và quản lý tồn kho.</p>
            </section>

            <!-- Bán hàng -->
            <section>
                <h2 class="text-xl font-semibold">Bán Hàng</h2>
                <p>Xem và quản lý các đơn đặt hàng, theo dõi doanh thu, và quản lý khách hàng từ khu vực này.</p>
            </section>

            <!-- Phân quyền -->
            <section>
                <h2 class="text-xl font-semibold">Phân Quyền</h2>
                <p>Thiết lập và quản lý các vai trò và quyền hạn cho người dùng trên website của bạn. Bạn có thể tạo vai trò mới và gán quyền cụ thể cho từng vai trò.</p>
            </section>

            <!-- Người dùng -->
            <section>
                <h2 class="text-xl font-semibold">Người Dùng</h2>
                <p>Quản lý thông tin người dùng, bao gồm việc thêm mới, chỉnh sửa, và xóa người dùng. Bạn cũng có thể xem lịch sử hoạt động của người dùng.</p>
            </section>

            <!-- Cài đặt -->
            <section>
                <h2 class="text-xl font-semibold">Cài Đặt</h2>
                <p>Chức năng này cho phép bạn cấu hình và thiết lập các tùy chọn cho website, bao gồm cài đặt chung, cài đặt email, và các tùy chọn khác.</p>
            </section>

            <!-- Phân quyền -->
            <section id="phan-quyen">
                <h2 class="text-2xl font-bold mb-4">Phân Quyền</h2>
                <p class="mb-4">Phân quyền giúp bạn quản lý quyền truy cập của người dùng đối với các chức năng khác nhau trong bảng điều khiển. Bạn có thể tạo các vai trò người dùng và gán quyền cụ thể cho từng vai trò.</p>
                
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-2">Cách Thiết Lập Phân Quyền</h3>
                    <ol class="list-decimal pl-6 space-y-2">
                        <li>Truy cập vào mục "Phân Quyền" từ menu chính.</li>
                        <li>Chọn "Thêm Vai Trò" để tạo vai trò mới. Điền tên và mô tả cho vai trò.</li>
                        <li>Chọn các quyền mà bạn muốn gán cho vai trò này. Hãy chắc chắn bạn chỉ gán những quyền cần thiết để tránh rủi ro về bảo mật.</li>
                        <li>Lưu vai trò.</li>
                    </ol>
                </div>
                
                <div class="bg-red-300 p-6 rounded-lg shadow-lg mt-6">
                    <h3 class="text-xl font-semibold mb-2">Lưu Ý Quan Trọng</h3>
                    <p class="mb-4">Người dùng không có quyền cần thiết sẽ không thể truy cập vào các chức năng bị hạn chế. Điều này giúp đảm bảo rằng chỉ những người có trách nhiệm mới có thể thực hiện các thao tác quan trọng trên hệ thống của bạn.</p>
                    <p>Nên kiểm tra cẩn thận và xác minh quyền của người dùng trước khi gán để tránh những sai sót có thể ảnh hưởng đến hoạt động của hệ thống.</p>
                </div>
            </section>

            <!-- ... Các phần khác ... -->
        </div>
    </div>
</div>
@endsection
