document.addEventListener('DOMContentLoaded', function () {
    const carTypeDropdown = document.getElementById('car_type');
    const carModelDropdown = document.getElementById('car_model');
    const carImage = document.getElementById('car_image');

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
                    carModelDropdown.appendChild(option);
                });
            }
        });

        carModelDropdown.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const imageUrl = selectedOption.getAttribute('data-image') || 'assets/img/logo (2).png';
            carImage.setAttribute('src', imageUrl);
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
