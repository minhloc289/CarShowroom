document.addEventListener('DOMContentLoaded', function () {
    const carTypeDropdown = document.getElementById('car_type');
    const carModelDropdown = document.getElementById('car_model');
    const carImage = document.getElementById('car_image');
    const carurl= document.getElementById('car_url');
    const carid = document.getElementById('car_id');

    if (carTypeDropdown && carModelDropdown && carImage) {
        carTypeDropdown.addEventListener('change', function () {
            const selectedBrand = this.value;
            // Clear existing options in car_model dropdown
            carModelDropdown.innerHTML = '<option value="">Select Car Name</option>';

            // Add new options based on selected brand
            if (carsByBrand[selectedBrand]) {
                carsByBrand[selectedBrand].forEach(car => {
                    const option = document.createElement('option');
                    option.value = `${car.name} - ${car.model}`;
                    option.textContent = `${car.name} - ${car.model}`;
                    option.setAttribute('data-image', car.image_url);
                    option.setAttribute('data-id', car.car_id);
                    carModelDropdown.appendChild(option);
                });
            }
        });

        carModelDropdown.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const imageUrl = selectedOption.getAttribute('data-image') || 'assets/img/logo (2).png';
            const carID = selectedOption.getAttribute('data-id') || 100;
            carImage.setAttribute('src', imageUrl);
            carurl.setAttribute('value',imageUrl);
            carid.setAttribute('value',carID); // Set car_id hidden input value
        });
    }
});

function setupCharacterCount(textareaId, counterId) {
    const textarea = document.getElementById(textareaId);
    const charCount = document.getElementById(counterId);
    const maxLength = textarea.getAttribute('maxlength'); // Lấy giá trị maxlength

    textarea.addEventListener('input', function () {
        const currentLength = textarea.value.length; // Độ dài hiện tại của chuỗi nhập
        charCount.textContent = `${currentLength}/${maxLength}`; // Cập nhật số ký tự
    });
}
document.addEventListener('DOMContentLoaded', function () {
    setupCharacterCount('other_request', 'charCount');
});

document.addEventListener('DOMContentLoaded', function () {
    // Lấy input chọn ngày
    const testDriveDateInput = document.getElementById('test_drive_date');

    // Lấy ngày hiện tại theo định dạng YYYY-MM-DD
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
    const dd = String(today.getDate()).padStart(2, '0');
    const minDate = `${yyyy}-${mm}-${dd}`;

    // Gán min cho input ngày
    if (testDriveDateInput) {
        testDriveDateInput.setAttribute('min', minDate);

        // Thêm sự kiện kiểm tra ngày khi người dùng nhập
        testDriveDateInput.addEventListener('change', function () {
            const selectedDate = new Date(this.value);
            if (selectedDate < today) {
                alert('Please select a date greater than today.');
                this.value = ''; // Xóa giá trị nếu không hợp lệ
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Lấy checkbox và nút đăng ký
    const subscribeCheckbox = document.getElementById('subscribe'); // Checkbox
    const registerButton = document.getElementById('register-button'); // Nút đăng ký

    if (subscribeCheckbox && registerButton) {
        // Khởi tạo trạng thái ban đầu của nút
        registerButton.disabled = true; // Vô hiệu hóa nút
        registerButton.classList.add('bg-gray-400', 'cursor-not-allowed'); // Thêm màu xám và không cho click

        // Lắng nghe sự kiện thay đổi trạng thái checkbox
        subscribeCheckbox.addEventListener('change', function () {
            if (this.checked) {
                // Nếu checkbox được tick
                registerButton.disabled = false; // Bật nút
                registerButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                registerButton.classList.add('bg-blue-800'); // Thêm lớp CSS cho trạng thái bật
            } else {
                // Nếu checkbox bị bỏ tick
                registerButton.disabled = true; // Tắt nút
                registerButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                registerButton.classList.remove('bg-blue-800', 'hover:bg-gray-500'); // Xóa lớp CSS trạng thái bật
            }
        });

        // Lắng nghe sự kiện click vào nút để xử lý
        registerButton.addEventListener('click', function (event) {
            if (registerButton.disabled) {
                // Ngăn chặn hành động nếu nút bị vô hiệu hóa
                event.preventDefault();
                alert('Please agree to the terms to proceed.');
            }
        });
    } else {
        console.error('Checkbox or button not found.');
    }
});


