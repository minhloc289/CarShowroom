# Car Showroom Management System

## Giới thiệu

Đây là đồ án môn học **Lập trình Web** với mục tiêu xây dựng một hệ thống quản lý showroom ô tô. Đề tài được phát triển bằng **Laravel Framework**, cung cấp các chức năng chính như quản lý mua bán xe, thuê xe, quản lý phụ kiện, và tích hợp thanh toán trực tuyến.

## Ngôn ngữ và Công nghệ Sử Dụng

- **Ngôn ngữ lập trình**: PHP, HTML, Tailwind CSS, Javascript
- **Database**: MySQL

## Các Chức Năng Chính

### 1. Accessories (Phụ kiện)

- Người dùng có thể:
  - Xem giỏ hàng
  - Thêm phụ kiện vào giỏ hàng

### 2. So sánh và mua xe

- Người dùng có thể:
  - So sánh các mẫu xe trước khi đưa ra quyết định.
  - Tích hợp thanh toán online qua **VNPay** (môi trường test).

### 3. Thuê xe

- Người dùng có thể:
  - Lựa chọn các loại xe có sẵn để thuê.
  - Lên lịch thuê xe.
  - Thanh toán đặt cọc trực tuyến qua **VNPay**.
  - Gia hạn khi xe thuê hết hạn.

### 4. Các chức năng phụ khác

- **Quản lý đơn lái thử**:
  - Người dùng có thể đăng ký lái thử xe và quản lý các lịch hẹn.
- ***Quản lý nhân viên****:*
  - Admin có thể thêm, sửa, xóa và quản lý thông tin nhân viên showroom.
- **Thống kê doanh thu**:
  - Hiển thị biểu đồ và dữ liệu thống kê doanh thu bán xe, thuê xe và phụ kiện.

### 5. Chức năng gửi email

- Hệ thống sẽ tự động gửi email:
  - Hóa đơn mua hàng và thuê xe.
  - Trạng thái thanh toán.

---

## Cách Chạy Dự Án

1. **Clone dự án**:
   ```bash
   git clone https://github.com/minhloc289/CarShowroom.git
   ```
2. **Cài đặt các dependencies**:
   ```bash
   composer install
   ```
3. **Cấu hình file .env**:
    ```bash
    cp .env.example .env
    ```
4. Chạy database
    - Ưu tiên chạy các bảng sau trước: order, rental_order
    - Copy path của các file migration:
      ```bash
      php artisan migrate --path=/database/migrations/...
      ```
    - Chạy toàn bộ database:
      ```bash
      php artisan migrate
      ```
5. **Chạy dự án**:
   ```bash
   php artisan serve
   ```
6. **Truy cập**:
   Mở trình duyệt và truy cập `http://localhost:8000`.

