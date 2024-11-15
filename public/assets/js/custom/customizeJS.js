function showEmployeeDetails(employeeId) {
    // Set a loading message initially
    document.getElementById('employeeName').textContent = 'Loading...';
    document.getElementById('employeePosition').textContent = 'Loading...';
    document.getElementById('employeeEmail').textContent = 'Loading...';
    document.getElementById('employeePhone').textContent = 'Loading...';
    document.getElementById('employeeAddress').textContent = 'Loading...';
    document.getElementById('employeeDescription').textContent = 'Loading...';

    // Show the modal
    var employeeDetailModal = new bootstrap.Modal(document.getElementById('employeeDetailModal'));
    employeeDetailModal.show();

    // Fetch employee details using AJAX
    fetch(`/admin/user/details/${employeeId}`)
        .then(response => {
            if (!response.ok) throw new Error('Failed to fetch data');
            return response.json();
        })
        .then(data => {
            // Populate the modal content with employee details
            document.getElementById('employeeName').textContent = data.name;
            document.getElementById('employeePosition').textContent = data.is_quanly ? 'Quản lý' : 'Nhân viên';
            document.getElementById('employeeEmail').textContent = data.email;
            document.getElementById('employeePhone').textContent = data.phone || 'N/A';
            document.getElementById('employeeAddress').textContent = data.address || 'N/A';
            document.getElementById('employeeDescription').textContent = data.description || 'N/A';
            document.getElementById('employeeImage').src = data.image ? `/storage/${data.image}` : '/assets/media/avatars/150-11.jpg';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('employeeDetailContent').innerHTML = '<p class="text-red-500">Error loading details.</p>';
        });
}
