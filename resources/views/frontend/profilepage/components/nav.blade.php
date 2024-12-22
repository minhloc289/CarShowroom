@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::guard('account')->user();
@endphp

<div class="py-4 px-6">
    <!-- Profile Section -->
    <div class="flex items-center p-4 bg-white rounded-lg mb-4">
        <div class="flex items-center justify-center w-10 h-10 mr-3 -ml-1 bg-blue-500 rounded-full text-white">
            <i class="text-lg fas fa-user"></i>
        </div>
        <div class="flex flex-col leading-none">
            <p class="text-sm text-gray-500 truncate">Xin chào,</p>
            <p class="text-base font-semibold text-gray-800 truncate">{{ $user->name }}</p>
        </div>
    </div>

    <div class="h-1 bg-gradient-to-r from-blue-500 via-gray-300 to-blue-500 my-4"></div>

    <!-- THÔNG TIN XE -->
    <h2 class="text-lg font-semibold text-gray-800">THÔNG TIN XE</h2>
    <ul class="mt-4 space-y-2">
        <li>
            <a href="#" class="flex items-center text-gray-600 hover:text-blue-600" data-section="xe-cua-toi">
                <i class="fas fa-car mr-3"></i> Xe của tôi
            </a>
        </li>
    </ul>

    <!-- ĐẶT HÀNG VÀ DỊCH VỤ -->
    <h2 class="text-lg font-semibold text-gray-800 mt-6">ĐẶT HÀNG VÀ DỊCH VỤ</h2>
    <ul class="mt-4 space-y-2">
        <li>
            <a href="{{ route('transaction.history') }}" class="flex items-center text-gray-600 hover:text-blue-600" data-section="lich-su-giao-dich">
                <i class="fas fa-file-invoice-dollar mr-3"></i> Lịch sử giao dịch
            </a>
        </li>
        <li>
            <a href="{{route('rentalHistory')}}" class="flex items-center text-gray-600 hover:text-blue-600" data-section="dang-ky-lai-thu">
                <i class="fas fa-clipboard-check mr-3"></i> Lịch sử thuê xe
            </a>
        </li>
    </ul>

    <!-- TÀI KHOẢN -->
    <h2 class="text-lg font-semibold text-gray-800 mt-6">TÀI KHOẢN</h2>
    <ul class="mt-4 space-y-2">
        <li>
            <a href="{{ route('view.profile') }}" class="flex items-center text-gray-600 hover:text-blue-600" data-section="thong-tin-ca-nhan">
                <i class="fas fa-user mr-3"></i> Thông tin cá nhân
            </a>
        </li>
        <li>
            <a href="#" class="flex items-center text-gray-600 hover:text-blue-600" data-section="thong-tin-xuat-hoa-don">
                <i class="fas fa-file-invoice mr-3"></i> Thông tin xuất hóa đơn
            </a>
        </li>
        <li>
            <a href="https://www.facebook.com/minhloc.caingoc" target="_blank" class="flex items-center text-gray-600 hover:text-blue-600" data-section="yeu-cau-ho-tro">
                <i class="fas fa-headset mr-3"></i> Yêu cầu hỗ trợ
            </a>
        </li>
        <li>
            <a href="https://www.linkedin.com/in/l%E1%BB%99c-c%C3%A1i-b5b9b9259/" target="_blank" class="flex items-center text-gray-600 hover:text-blue-600" data-section="lien-he">
                <i class="fas fa-envelope mr-3"></i> Liên hệ
            </a>
        </li>
    </ul>

    <div class="h-0.5 bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200 my-4"></div>

    <!-- Đăng Xuất -->
    <ul class="mt-4">
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
        color: #2563eb;
        /* Màu xanh đậm */
        font-weight: bold;
        /* Tùy chọn */
    }

    /* Khi hover trên mục đang active */
    a.active:hover {
        color: #1e40af;
        /* Màu xanh đậm hơn khi hover */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuItems = document.querySelectorAll('[data-section]'); // Chọn tất cả các mục có `data-section`
        const currentPath = window.location.pathname; // Lấy đường dẫn hiện tại

        // Xóa tất cả trạng thái active trước đó
        menuItems.forEach(item => item.classList.remove('active'));

        // Xác định và thêm trạng thái active cho mục phù hợp
        menuItems.forEach(item => {
            const sectionHref = item.getAttribute('href');
            if (currentPath === new URL(sectionHref, window.location.origin).pathname) {
                item.classList.add('active');
            }
        });

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
