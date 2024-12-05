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

document.addEventListener("mousemove", function (e) {
    const magnify = document.querySelector(".magnify");
    if (magnify) {
        const rect = magnify.parentNode.getBoundingClientRect(); // Vùng hiển thị hình ảnh
        const offsetX = e.clientX - rect.left; // Tính vị trí chuột so với ảnh
        const offsetY = e.clientY - rect.top;

        const percentageX = (offsetX / rect.width) * 100; // Tính tỷ lệ theo chiều ngang
        const percentageY = (offsetY / rect.height) * 100; // Tính tỷ lệ theo chiều dọc

        // Đặt vị trí chuột trong phần phóng to
        magnify.style.setProperty("--mouse-x", `${offsetX}px`);
        magnify.style.setProperty("--mouse-y", `${offsetY}px`);
        magnify.style.backgroundPosition = `${percentageX}% ${percentageY}%`;
    }
});

