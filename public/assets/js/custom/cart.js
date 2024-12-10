document.addEventListener('DOMContentLoaded', function () {
    const decreaseButtons = document.querySelectorAll('.decrease-quantity');
    const increaseButtons = document.querySelectorAll('.increase-quantity');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const totalPriceElement = document.getElementById('total-price');
    const checkboxes = document.querySelectorAll('.product-checkbox');

    // Hàm cập nhật tổng tiền
    function updateTotalPrice() {
        let total = 0;
    
        // Duyệt qua các checkbox sản phẩm
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const price = parseFloat(checkbox.getAttribute('data-price'));
                const quantity = parseInt(checkbox.getAttribute('data-quantity'));
                total += price * quantity;
            }
        });
    
        // Cập nhật tổng tiền
        if (totalPriceElement) {
            totalPriceElement.innerText = total.toLocaleString() + ' VND';
        }
    }

    // Cập nhật số lượng và tổng tiền sản phẩm
    function updateCartQuantity(productId, newQuantity) {
        fetch('/cart/update/quantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ accessory_id: productId, quantity: newQuantity })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to update quantity');
            }
            return response.json();
        })
        .then(data => {
            // Cập nhật tổng tiền sản phẩm
            const itemTotalElement = document.getElementById(`item-total-${productId}`);
            if (itemTotalElement && data.item_total !== undefined) {
                itemTotalElement.innerText = data.item_total.toLocaleString() + ' VND';
            }

            // Chỉ cập nhật tổng tiền nếu sản phẩm được tick
            const checkbox = document.querySelector(`.product-checkbox[data-id="${productId}"]`);
            if (checkbox && checkbox.checked) {
                updateTotalPrice();
            }
        })
        .catch(error => console.error('Error updating cart quantity:', error));
    }

    // Xử lý giảm số lượng
    decreaseButtons.forEach((button) => {
        button.addEventListener('click', function () {
            const productId = button.getAttribute('data-id');
            const quantityInput = document.querySelector(`.quantity-input[data-id="${productId}"]`);
            let currentQuantity = parseInt(quantityInput.value);

            if (currentQuantity > 1) {
                currentQuantity--;
                quantityInput.value = currentQuantity;

                // Cập nhật thuộc tính data-quantity của checkbox
                const checkbox = document.querySelector(`.product-checkbox[data-id="${productId}"]`);
                if (checkbox) {
                    checkbox.setAttribute('data-quantity', currentQuantity);
                }

                updateCartQuantity(productId, currentQuantity);
            }
        });
    });

    // Xử lý tăng số lượng
    increaseButtons.forEach((button) => {
        button.addEventListener('click', function () {
            const productId = button.getAttribute('data-id');
            const quantityInput = document.querySelector(`.quantity-input[data-id="${productId}"]`);
            let currentQuantity = parseInt(quantityInput.value);

            currentQuantity++;
            quantityInput.value = currentQuantity;

            // Cập nhật thuộc tính data-quantity của checkbox
            const checkbox = document.querySelector(`.product-checkbox[data-id="${productId}"]`);
            if (checkbox) {
                checkbox.setAttribute('data-quantity', currentQuantity);
            }

            updateCartQuantity(productId, currentQuantity);
        });
    });

    // Xử lý sự kiện "Select All"
    const selectAllCheckbox = document.getElementById('select-all');

    selectAllCheckbox.addEventListener('change', function () {
        checkboxes.forEach((checkbox) => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        updateTotalPrice();
    });

    // Xử lý sự kiện thay đổi checkbox sản phẩm
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', updateTotalPrice);
    });

    // Cập nhật tổng tiền khi trang được load
    updateTotalPrice();
});

document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    let itemToRemove = null;

    // Hiển thị overlay khi nhấn nút "Remove"
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function () {
            itemToRemove = this.dataset.id;
            document.getElementById('overlay-title').textContent = "Delete Confirmation";
            document.getElementById('confirmation-overlay').classList.remove('hidden');
        });
    });

    // Đóng overlay
    document.getElementById('close-overlay').addEventListener('click', closeOverlay);
    document.getElementById('cancel-remove').addEventListener('click', closeOverlay);

    function closeOverlay() {
        document.getElementById('confirmation-overlay').classList.add('hidden');
        itemToRemove = null;
    }

    // Xóa sản phẩm khi nhấn "Confirm"
    document.getElementById('confirm-remove').addEventListener('click', function () {
        if (itemToRemove) {
            fetch(`/cart/remove/${itemToRemove}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật lại danh sách giỏ hàng
                        refreshCart();
                    } else {
                        alert('Failed to remove item. Please try again.');
                    }
                })
                .finally(closeOverlay);
        }
    });

    // Hàm cập nhật danh sách giỏ hàng
    function refreshCart() {
        fetch('/cart/items', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
        })
            .then(response => response.json())  
            .then(data => {
                if (data.success) {
                    // Làm trống danh sách giỏ hàng hiện tại
                    const cartTableBody = document.querySelector('table tbody');
                    cartTableBody.innerHTML = '';

                    // Duyệt qua danh sách mới và thêm vào bảng
                    let totalPrice = 0;
                    data.cartItems.forEach(item => {
                        const itemTotal = item.accessory.price * item.quantity;
                        totalPrice += itemTotal;

                        const row = `
                            <tr>
                                <td class="border-b p-4">
                                    <input type="checkbox" class="product-checkbox" data-price="${item.accessory.price}" data-quantity="${item.quantity}" data-id="${item.accessory.accessory_id}">
                                </td>
                                <td class="border-b p-4">
                                    <img src="${item.accessory.image_url}" alt="${item.accessory.name}" class="w-16 h-16 object-cover mr-4 inline">
                                    ${item.accessory.name}
                                </td>
                                <td class="border-b p-4">${item.accessory.price.toLocaleString()} VND</td>
                                <td class="border-b p-4">
                                    <div class="flex items-center">
                                        <button type="button" class="decrease-quantity" data-id="${item.accessory.accessory_id}">-</button>
                                        <input type="number" value="${item.quantity}" class="quantity-input mx-2" data-id="${item.accessory.accessory_id}" readonly>
                                        <button type="button" class="increase-quantity" data-id="${item.accessory.accessory_id}">+</button>
                                    </div>
                                </td>
                                <td class="border-b p-4">${itemTotal.toLocaleString()} VND</td>
                                <td class="border-b p-4">
                                    <button type="button" class="remove-item text-red-500" data-id="${item.accessory.accessory_id}" data-name="${item.accessory.name}">Remove</button>
                                </td>
                            </tr>
                        `;
                        cartTableBody.insertAdjacentHTML('beforeend', row);
                    });

                    // Cập nhật tổng tiền
                    document.getElementById('total-price').textContent = `${totalPrice.toLocaleString()} VND`;

                    // Gán lại sự kiện "Remove" cho các nút mới
                    document.querySelectorAll('.remove-item').forEach(button => {
                        button.addEventListener('click', function () {
                            itemToRemove = this.dataset.id;
                            document.getElementById('overlay-title').textContent = "Delete Confirmation";
                            document.getElementById('confirmation-overlay').classList.remove('hidden');
                        });
                    });
                }
            });
    }
});


