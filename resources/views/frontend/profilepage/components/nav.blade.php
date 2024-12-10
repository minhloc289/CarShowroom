<div class="py-4 px-6">
    <h2 class="text-lg font-semibold text-gray-800">THÔNG TIN XE</h2>
    <ul class="mt-4 space-y-2">
        <li>
            <a href="" class="flex items-center text-gray-600 hover:text-blue-600" data-section="xe-cua-toi">
                <i class="fas fa-car mr-3"></i> Xe của tôi
            </a>
        </li>
    </ul>

    <h2 class="text-lg font-semibold text-gray-800 mt-6">ĐẶT HÀNG VÀ DỊCH VỤ</h2>
    <ul class="mt-4 space-y-2">
        <li>
            <a href="" class="flex items-center text-gray-600 hover:text-blue-600" data-section="lich-su-giao-dich">
                <i class="fas fa-file-invoice-dollar mr-3"></i> Lịch sử giao dịch
            </a>
        </li>
        <li>
            <a href="" class="flex items-center text-gray-600 hover:text-blue-600" data-section="bao-duong-sua-chua">
                <i class="fas fa-tools mr-3"></i> Bảo dưỡng - Sửa chữa
            </a>
        </li>
        <li>
            <a href="" class="flex items-center text-gray-600 hover:text-blue-600" data-section="thue-pin">
                <i class="fas fa-battery-three-quarters mr-3"></i> Thuê Pin
            </a>
        </li>
        <li>
            <a href="" class="flex items-center text-gray-600 hover:text-blue-600" data-section="lich-su-sac-pin">
                <i class="fas fa-charging-station mr-3"></i> Lịch sử Sạc Pin
            </a>
        </li>
        <li>
            <a href="" class="flex items-center text-gray-600 hover:text-blue-600" data-section="dang-ky-lai-thu">
                <i class="fas fa-clipboard-check mr-3"></i> Đăng ký lái thử
            </a>
        </li>
    </ul>

    <h2 class="text-lg font-semibold text-gray-800 mt-6">TÀI KHOẢN</h2>
    <ul class="mt-4 space-y-2">
        <li>
            <a href="{{ route('view.profile') }}" class="flex items-center text-gray-600 hover:text-blue-600 active" data-section="thong-tin-ca-nhan">
                <i class="fas fa-user mr-3"></i> Thông tin cá nhân
            </a>
        </li>
        <li>
            <a href="" class="flex items-center text-gray-600 hover:text-blue-600" data-section="thong-tin-xuat-hoa-don">
                <i class="fas fa-file-invoice mr-3"></i> Thông tin xuất hóa đơn
            </a>
        </li>
        <li>
            <a href="" class="flex items-center text-gray-600 hover:text-blue-600" data-section="yeu-cau-ho-tro">
                <i class="fas fa-headset mr-3"></i> Yêu cầu hỗ trợ
            </a>
        </li>
        <li>
            <a href="" class="flex items-center text-gray-600 hover:text-blue-600" data-section="lien-he">
                <i class="fas fa-envelope mr-3"></i> Liên hệ
            </a>
        </li>
    </ul>

    <ul class="mt-6">
        <li>
            <form method="POST" action="{{ route('account.logout') }}">
                @csrf
                <button type="submit" class="flex items-center text-red-600 hover:text-red-800">
                    <i class="fas fa-sign-out-alt mr-3"></i> Đăng xuất
                </button>
            </form>
        </li>
    </ul>
</div>

<style>
    /* Màu sắc mặc định khi active */
a.active {
    color: #2563eb; /* Màu xanh đậm */
    font-weight: bold; /* Tùy chọn */
}

/* Khi hover trên mục đang active */
a.active:hover {
    color: #1e40af; /* Màu xanh đậm hơn khi hover */
}

</style>
<script>
   document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('[data-section]'); // Chọn tất cả các mục có `data-section`

    menuItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault(); // Ngăn chặn hành vi mặc định

            // Loại bỏ `active` khỏi tất cả các mục
            menuItems.forEach(menu => menu.classList.remove('active'));

            // Thêm `active` vào mục được nhấp
            item.classList.add('active');
            
            // Chuyển hướng tới route tương ứng
            const route = item.getAttribute('href');
            if (route) {
                window.location.href = route;
            }
        });
    });
});

</script>