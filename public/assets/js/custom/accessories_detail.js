axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener("DOMContentLoaded", function () {
    const decreaseButton = document.getElementById("decrease");
    const increaseButton = document.getElementById("increase");
    const quantityInput = document.getElementById("quantity");
    const totalPriceElement = document.getElementById("total-price");
    const pricePerUnit = parseInt(document.getElementById("accessory-price").getAttribute("data-price"), 10);

    // Hàm cập nhật tổng tiền
    function updateTotalPrice() {
        const quantity = parseInt(quantityInput.value, 10);
        const totalPrice = pricePerUnit * quantity;
        totalPriceElement.textContent = new Intl.NumberFormat('vi-VN').format(totalPrice) + " VND";
    }

    // Hàm thay đổi số lượng
    function changeQuantity(change) {
        let currentValue = parseInt(quantityInput.value, 10);
        currentValue = Math.max(1, currentValue + change); // Đảm bảo giá trị >= 1
        quantityInput.value = currentValue;
        updateTotalPrice();
    }

    // Gắn sự kiện cho các nút
    decreaseButton.addEventListener("click", function () {
        changeQuantity(-1);
    });

    increaseButton.addEventListener("click", function () {
        changeQuantity(1);
    });

    // Khởi tạo tổng tiền ban đầu
    updateTotalPrice();
});


document.addEventListener("DOMContentLoaded", function () {
    // Tìm nút Add to Cart và gắn sự kiện click vào nút đó
    const addToCartButton = document.getElementById('add-to-cart-button');
    if (addToCartButton) {
        addToCartButton.addEventListener('click', function() {
            const accessoryId = this.getAttribute('data-accessory-id');
            const quantityInput = document.getElementById('quantity');
            const quantity = parseInt(quantityInput.value, 10);

            if (isNaN(quantity) || quantity < 1) {
                toastr.error('Please enter a valid quantity.');
                return;
            }

            // Sử dụng axios để gửi yêu cầu POST
            axios.post('/cart/add', {
                accessory_id: accessoryId,
                quantity: quantity
            })
            .then(response => {
                // Nếu thêm sản phẩm thành công
                toastr.success(response.data.message);
                document.getElementById('cart-count').innerText = response.data.cart_count;
            })
            .catch(error => {
                if (error.response && error.response.status === 401) {
                    // Nếu chưa đăng nhập (status 401), thông báo và chuyển hướng tới trang đăng nhập
                    toastr.warning('You need to log in first!');
                    // window.location.href = '/login'; // Điều chỉnh lại đường dẫn trang đăng nhập của bạn
                    openLoginOverlay();
                } else {
                    // Xử lý các lỗi khác
                    console.error('Error:', error);
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });
    }
});

// Hiển thị overlay đăng nhập (nếu cần)
function openLoginOverlay() {
    const loginOverlay = document.getElementById('login-overlay');
    loginOverlay.classList.remove('overlay-hidden'); // Đảm bảo overlay không ẩn
    loginOverlay.classList.add('show'); // Thêm lớp `show` để hiển thị overlay
}

// Lấy số lượng giỏ hàng
function updateCartCount() {
    // Gọi API để lấy số lượng sản phẩm trong giỏ
    fetch("{{ route('cart.count') }}") 
        .then(response => {
            // Kiểm tra nếu response trả về không phải JSON
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Chuyển dữ liệu thành JSON
        })
        .then(data => {
            console.log(data); // Kiểm tra dữ liệu trả về
            const cartCount = data.cart_count; // Lấy số lượng từ response
            // Cập nhật lên nút giỏ hàng
            document.getElementById("cart-count").innerText = cartCount;
        })
        .catch(error => {
            // Xử lý lỗi nếu có
            console.error("Error fetching cart count:", error);
        });
}

// Gọi hàm để cập nhật số lượng giỏ hàng khi trang được tải
document.addEventListener('DOMContentLoaded', updateCartCount);