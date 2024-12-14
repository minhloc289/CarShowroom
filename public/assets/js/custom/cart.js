document.addEventListener('DOMContentLoaded', function () {
    const totalPriceElement = document.getElementById('total-price');
    let itemToRemove = null;

    // Hàm cập nhật tổng tiền
    function updateTotalPrice() {
        let total = 0;

        const checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const price = parseFloat(checkbox.getAttribute('data-price'));
                const quantity = parseInt(checkbox.getAttribute('data-quantity'));
                total += price * quantity;
            }
        });

        if (totalPriceElement) {
            totalPriceElement.innerText = total.toLocaleString('en-US') + ' VND';
        }
    }

    // Cập nhật số lượng và tổng tiền sản phẩm
    function updateCartQuantity(productId, newQuantity) {
        fetch('/cart/update/quantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
                const itemTotalElement = document.getElementById(`item-total-${productId}`);
                if (itemTotalElement && data.item_total !== undefined) {
                    itemTotalElement.innerText = data.item_total.toLocaleString('en-US') + ' VND';
                }

                const checkbox = document.querySelector(`.product-checkbox[data-id="${productId}"]`);
                if (checkbox && checkbox.checked) {
                    updateTotalPrice();
                }
            })
            .catch(error => console.error('Error updating cart quantity:', error));
    }

    // Hàm làm mới giỏ hàng
    function refreshCart() {
        fetch('/cart/items', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartTableBody = document.querySelector('table tbody');

                    if (data.cartItems.length === 0) {
                        cartTableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4">Your cart is empty.</td></tr>';
                        totalPriceElement.innerText = '0 VND';
                        return;
                    }

                    cartTableBody.innerHTML = '';
                    data.cartItems.forEach(item => {
                        const itemTotal = item.accessory.price * item.quantity;

                        const row = `
                            <tr>
                                <td class="border-b p-4">
                                    <input type="checkbox" class="product-checkbox" data-price="${item.accessory.price}" data-quantity="${item.quantity}" data-id="${item.accessory.accessory_id}">
                                </td>
                                <td class="border-b p-4">
                                    <img src="${item.accessory.image_url}" alt="${item.accessory.name}" class="w-16 h-16 object-cover mr-4 inline">
                                    ${item.accessory.name}
                                </td>
                                <td class="border-b p-4">${Number(item.accessory.price).toLocaleString()} VND</td>
                                <td class="border-b p-4">
                                    <div class="flex items-center">
                                        <button type="button" class="decrease-quantity" data-id="${item.accessory.accessory_id}">-</button>
                                        <input type="number" value="${item.quantity}" class="quantity-input mx-2" data-id="${item.accessory.accessory_id}" readonly>
                                        <button type="button" class="increase-quantity" data-id="${item.accessory.accessory_id}">+</button>
                                    </div>
                                </td>
                                <td class="border-b p-4" id="item-total-${item.accessory.accessory_id}">${itemTotal.toLocaleString('en-US')} VND</td>
                                <td class="border-b p-4">
                                    <button type="button" class="remove-item text-red-500" data-id="${item.accessory.accessory_id}">Remove</button>
                                </td>
                            </tr>`;

                        cartTableBody.insertAdjacentHTML('beforeend', row);
                    });

                    attachEventListeners();
                    updateTotalPrice();
                }
            })
            .catch(error => console.error('Error refreshing cart:', error));
    }

    // Gán sự kiện
    function attachEventListeners() {
        const decreaseButtons = document.querySelectorAll('.decrease-quantity');
        const increaseButtons = document.querySelectorAll('.increase-quantity');
        const checkboxes = document.querySelectorAll('.product-checkbox');

        decreaseButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const quantityInput = document.querySelector(`.quantity-input[data-id="${productId}"]`);
                let currentQuantity = parseInt(quantityInput.value);

                if (currentQuantity > 1) {
                    currentQuantity--;
                    quantityInput.value = currentQuantity;

                    const checkbox = document.querySelector(`.product-checkbox[data-id="${productId}"]`);
                    if (checkbox) {
                        checkbox.setAttribute('data-quantity', currentQuantity);
                    }

                    updateCartQuantity(productId, currentQuantity);
                }
            });
        });

        increaseButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const quantityInput = document.querySelector(`.quantity-input[data-id="${productId}"]`);
                let currentQuantity = parseInt(quantityInput.value);

                currentQuantity++;
                quantityInput.value = currentQuantity;

                const checkbox = document.querySelector(`.product-checkbox[data-id="${productId}"]`);
                if (checkbox) {
                    checkbox.setAttribute('data-quantity', currentQuantity);
                }

                updateCartQuantity(productId, currentQuantity);
            });
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTotalPrice);
        });

        const selectAllCheckbox = document.getElementById('select-all');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateTotalPrice();
            });
        }

        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function () {
                itemToRemove = this.dataset.id;
                document.getElementById('confirmation-overlay').classList.remove('hidden');
            });
        });

        document.getElementById('cancel-remove').addEventListener('click', function () {
            document.getElementById('confirmation-overlay').classList.add('hidden');
            itemToRemove = null;
        });

        document.getElementById('confirm-remove').addEventListener('click', function () {
            if (itemToRemove) {
                fetch(`/cart/remove/${itemToRemove}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            refreshCart();
                        }
                    })
                    .catch(error => console.error('Error removing item:', error))
                    .finally(() => {
                        document.getElementById('confirmation-overlay').classList.add('hidden');
                        itemToRemove = null;
                    });
            }
        });
    }

    attachEventListeners();
    updateTotalPrice();
});