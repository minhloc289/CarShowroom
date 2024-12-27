**Car Showroom Management System**

**Giới thiệu**

Đây là đồ án môn học **Lập trình và phát triển ứng dụng Web** với mục tiêu xây dựng một hệ thống quản lý showroom ô tô. Đề tài được phát triển bằng Laravel Framework, cung cấp các chức năng chính như quản lý mua bán xe, thuê xe, quản lý phụ kiện, và tích hợp thanh toán trực tuyến.

**Ngôn ngữ và Công nghệ Sử Dụng**

- **Ngôn ngữ lập trình:** PHP, HTML, Tailwind CSS, Javascript
- **Database:** MySQL

**Các chức năng chính**

### 1. Accessories (Phụ kiện)
- Xem giỏ hàng.
- Thêm phụ kiện vào giỏ hàng.

### 2. So sánh và mua xe
- So sánh các mẫu xe trước khi đưa ra quyết định.
- Tích hợp thanh toán online qua VNPay (môi trường test).

### 3. Thuê xe
- Lựa chọn các loại xe có sẵn để thuê.
- Lên lịch thuê xe.
- Thanh toán đặt cọc trực tuyến qua VNPay.
- Gia hạn khi xe thuê hết hạn.

### 4. Các chức năng phụ khác
- Quản lý đơn lái thử
- Quản lý nhân viên
- Quản lý đơn hàng
- Thống kê doanh thu
- Gửi email hóa đơn, trạng thái thanh toán cho khách hàng

**Chạy dự án**
### 1. Clone dự án
git clone https://github.com/minhloc289/CarShowroom.git 

### 2. Cài đặt dependencies
composer install

### 3. Cài đặt file .env
cp .env.example .env

### 4. Cài đặt key cho dự án
php artisan key:generate

### 5. Chạy database
- Ưu tiên chạy các bảng sau trước: order, rental_order
- Copy path của các file migration trên
php artisan migrate --path=/database/migrations/...
- Chạy toàn bộ database
php artisan migrate

### 6. Chạy dự án
php artisan serve



