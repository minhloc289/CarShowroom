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


document.addEventListener('DOMContentLoaded', function () {
    const cartButton = document.getElementById('cart-button');

    cartButton.addEventListener('click', function (event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định

        // Gửi yêu cầu kiểm tra trạng thái đăng nhập
        fetch('/accessories/cart')
            .then(response => {
                if (response.status === 401) {
                    // Nếu chưa đăng nhập, hiển thị overlay login
                    openLoginOverlay();
                } else if (response.ok) {
                    // Nếu đã đăng nhập, chuyển hướng đến trang giỏ hàng
                    window.location.href = '/accessories/cart';
                } else {
                    console.error('Unexpected response:', response);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const cartCountElement = document.getElementById('cart-count');
    const addToCartButton = document.getElementById('add-to-cart-button');

    // Hàm lấy số lượng sản phẩm trong giỏ hàng
    function updateCartCount() {
        fetch('/cart/count', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (cartCountElement) {
                cartCountElement.textContent = data.cart_count;
            }
        })
        .catch(error => console.error('Error fetching cart count:', error));
    }

    // Gọi hàm để cập nhật số lượng ngay khi trang load
    updateCartCount();

    // Hàm xử lý khi nhấn nút "Add to Cart"
    if (addToCartButton) {
        addToCartButton.addEventListener('click', function () {
            const accessoryId = this.getAttribute('data-accessory-id');
            const quantityInput = document.getElementById('quantity');
            const quantity = parseInt(quantityInput.value, 10);

            if (isNaN(quantity) || quantity < 1) {
                toastr.error('Please enter a valid quantity.');
                return;
            }

            // Gửi yêu cầu thêm vào giỏ hàng
            axios.post('/cart/add', {
                accessory_id: accessoryId,
                quantity: quantity
            })
            .then(response => {
                showOverlayMessage('Product added to cart successfully!');

                // Cập nhật bộ đếm bằng cách gọi lại hàm `updateCartCount`
                updateCartCount();
            })
            .catch(error => {
                if (error.response && error.response.status === 401) {
                    openLoginOverlay(); // Hiển thị login overlay
                } else {
                    console.error('Error:', error);
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });
    }
});


// Hiển thị overlay login
function openLoginOverlay() {
    const loginOverlay = document.getElementById('login-overlay');
    if (loginOverlay) {
        loginOverlay.classList.remove('overlay-hidden'); // Bỏ lớp ẩn
        loginOverlay.classList.add('show'); // Hiển thị overlay
    } else {
        console.error('Login overlay not found!');
    }
}

// Hàm hiển thị overlay thông báo
function showOverlayMessage(message) {
    // Tạo overlay nếu chưa tồn tại
    let overlay = document.getElementById('notification-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'notification-overlay';
        overlay.className = 'fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden';
        overlay.innerHTML = `
            <div class="bg-white rounded-lg p-4 shadow-lg text-center">
                <p id="notification-message" class="text-lg font-bold text-green-600"></p>
            </div>
        `;
        document.body.appendChild(overlay);
    }

    // Cập nhật nội dung thông báo
    const messageElement = document.getElementById('notification-message');
    messageElement.textContent = message;

    // Hiển thị overlay
    overlay.classList.remove('hidden');

    // Tự động ẩn overlay sau 1 giây
    setTimeout(() => {
        overlay.classList.add('hidden');
    }, 1000);
}
