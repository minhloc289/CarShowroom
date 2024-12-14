let isInfoConfirmed = false;

// Display tabs
function showTab(tab) {
    // Check if trying to switch to Deposit tab without confirming info
    if (tab === 'terms' && !isInfoConfirmed) {
        return; // Don't switch tab
    }

    // Hide all tabs
    document.getElementById('info-content').classList.add('hidden');
    document.getElementById('terms-content').classList.add('hidden');

    // Show the current tab
    if (tab === 'info') {
        document.getElementById('info-content').classList.remove('hidden');
    } else if (tab === 'terms') {
        document.getElementById('terms-content').classList.remove('hidden');
    }
}

// Switch to "Terms" tab if info is valid
function goToTermsTab() {
    if (validateInfo()) {
        updateTermsTab();
        isInfoConfirmed = true;
        document.getElementById('terms-tab').disabled = false;
        showTab('terms');
        document.getElementById('error-message').classList.add('hidden'); // Hide error message
    } else {
        alert("Thông tin không hợp lệ!");
    }
}

// Validate the form information
function validateInfo() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const startDate = document.getElementById('start_date').value;
    const phone = document.getElementById('phone').value;
    const rentalDays = document.getElementById('rental_days').value;

    return name && email && startDate && phone && rentalDays > 0;
}

// Enable "Confirm Payment" button when terms are agreed
document.getElementById('agree-terms').addEventListener('change', function () {
    const confirmButton = document.getElementById('confirm-payment');
    if (this.checked) {
        confirmButton.disabled = false; // Enable the button when the checkbox is checked
        confirmButton.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed'); // Ensure it appears enabled
    } else {
        confirmButton.disabled = true; // Disable the button when the checkbox is unchecked
        confirmButton.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed'); // Ensure it appears disabled
    }
});

// Confirm payment function
function confirmPayment() {
    const checkbox = document.getElementById('agree-terms');
    if (checkbox.checked) {
        alert("Bạn đã xác nhận thanh toán thành công!");
        document.getElementById('rental-form').submit();
    } else {
        alert("Vui lòng đồng ý với Điều khoản và Dịch vụ trước khi thanh toán.");
    }
}

