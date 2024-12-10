// Khi trang được load, hiển thị overlay và form đăng nhập ngay lập tức
document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('login-overlay');
    const form = document.getElementById('login-form');
    
    if (overlay && form) {
        overlay.classList.add('show'); // Hiển thị overlay
        form.classList.add('show'); // Hiển thị form với hiệu ứng
    }

    // Ẩn form đăng nhập khi nhấp chuột ra ngoài form
    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) { // Kiểm tra xem có click ra ngoài form
            overlay.classList.remove('show'); // Ẩn overlay
            form.classList.remove('show'); // Ẩn form
            setTimeout(() => {
                overlay.style.display = 'none'; // Đặt lại display về none sau khi animation hoàn tất
            }, 500);
        }
    });
});


