@extends('Backend.dashboard.layout')

@section('content') 
<style>
    table td {
        white-space: normal;    /* Cho phép xuống dòng */
        word-wrap: break-word;  /* Tự động ngắt dòng khi quá dài */
    }
    table {
        width: 100%;         /* Chiếm toàn bộ chiều ngang */
    }
</style>
<x-breadcrumbs breadcrumb="Accessories" />
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Quản lý phụ kiện</h1>
            <div class="d-flex justify-content-end">
                <!-- Delete Selected Button -->
                <button type="submit" form="bulkDeleteForm" id="deleteSelected" class=" me-2 btn btn-danger" style="display: none;">
                    <i class="fas fa-trash-alt"></i>
                    Xóa hàng loạt
                </button>
                <!-- Add Dropdown -->
                <div class="dropdown me-2">
                    <button class="btn btn-primary dropdown-toggle" id="addAccessoryButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Thêm
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="addAccessoryButton">
                        <li><a class="dropdown-item" href="{{ route('accessories.create') }}">Thêm một sản phẩm </a></li>
                        <li><a class="dropdown-item" href="{{ route('accessories.upload') }}">Thêm nhiều sản phẩm</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="flex items-center space-x-4 mb-4">
            <input type="text" id="accessorySearchInput" placeholder="Search"
                class="rounded-lg border border-gray-300 px-4 py-2 w-64">

            <!-- Select Category -->
            <select id="categoryFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                <option value="">Tất cả các loại</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>

        <div id="accessoriesContainer" class="container">
            <form id="bulkDeleteForm" action="{{ route('accessories.bulkDelete') }}" method="POST">
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>#</th>
                            <th>Hình ảnh</th>
                            <th>Tên phụ kiện</th>
                            <th>Phân loại</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accessories as $index => $accessory)
                            <tr class="accessory-item">
                                <td>
                                    <input type="checkbox" name="selected[]" value="{{ $accessory->accessory_id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ $accessory->image_url }}" class="rounded-lg" alt="{{ $accessory->name }}" 
                                        style="width: 80px; height: auto;">
                                </td>
                                <td style="font-family: 'Baloo 2', Arial, sans-serif; font-weight: bold; font-size: 1.35rem;">
                                    {{ $accessory->name }}
                                </td>
                                <td>{{ $accessory->category }}</td>
                                <td style="font-weight: bold; color: #007bff; font-size: 1.25rem;">
                                    {{ number_format($accessory->price) }} VNĐ
                                </td>
                                <td>{{ $accessory->quantity }}</td>
                                <td>
                                    <a href="{{ route('accessories.details', ['id' => $accessory->accessory_id]) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                                    <a href="{{ route('accessories.edit', ['id' => $accessory->accessory_id]) }}" class="btn btn-warning btn-sm">Chỉnh sửa</a>
                                    <form action="{{ route('accessories.destroy', ['id' => $accessory->accessory_id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>    
        </div>
        
        <!-- View More Button -->
        <div class="d-flex justify-content-center align-items-center">
            <button id="viewMoreButton" class="text-blue-500 text-sm font-semibold hover:underline">
                Xem thêm →
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('selectAll'); // Checkbox chọn tất cả
        const checkboxes = document.querySelectorAll('input[name="selected[]"]'); // Các checkbox trong bảng
        const deleteSelected = document.getElementById('deleteSelected'); // Nút Delete Selected

        // Hàm kiểm tra checkbox để hiện/ẩn nút Delete
        const toggleDeleteButton = () => {
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            deleteSelected.style.display = anyChecked ? 'inline-block' : 'none'; // Hiện nếu có checkbox được chọn
        };

        // Xử lý khi thay đổi trạng thái checkbox
        selectAll.addEventListener('change', () => {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            toggleDeleteButton();
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleDeleteButton);
        });

        // Ẩn nút khi trang được load lần đầu
        toggleDeleteButton();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('accessorySearchInput'); // Ô tìm kiếm
        const categoryFilter = document.getElementById('categoryFilter'); // Dropdown danh mục
        const accessoryRows = document.querySelectorAll('.accessory-item'); // Tất cả hàng phụ kiện
        const viewMoreButton = document.getElementById('viewMoreButton'); // Nút View More
        const selectAll = document.getElementById('selectAll'); // Checkbox chọn tất cả
        const checkboxes = document.querySelectorAll('input[name="selected[]"]'); // Các checkbox trong bảng
        const deleteSelected = document.getElementById('deleteSelected'); // Nút xóa hàng loạt
        const bulkDeleteForm = document.getElementById('bulkDeleteForm'); // Form submit xóa hàng loạt

        let visibleCount = 10; // Số dòng hiển thị mặc định ban đầu

        // Hàm ẩn/hiển các dòng ngoài phạm vi hiển thị
        const hideExtraRows = () => {
            let visibleRows = 0;
            accessoryRows.forEach(row => {
                if (row.dataset.visible === "true") {
                    if (visibleRows < visibleCount) {
                        row.style.display = ""; // Hiển thị dòng
                        visibleRows++;
                    } else {
                        row.style.display = "none"; // Ẩn dòng vượt phạm vi
                        row.querySelector('input[type="checkbox"]').checked = false;
                    }
                } else {
                    row.style.display = "none"; // Ẩn dòng không khớp
                    row.querySelector('input[type="checkbox"]').checked = false;
                }
            });

            // Ẩn/hiển nút View More
            viewMoreButton.style.display = visibleRows >= accessoryRows.length ? "none" : "block";
        };

        // Xử lý khi nhấn nút View More
        viewMoreButton.addEventListener("click", () => {
            visibleCount += 10; // Tăng giới hạn hiển thị
            hideExtraRows();
        });

        // Hàm lọc phụ kiện dựa trên tìm kiếm và danh mục
        const filterAccessories = () => {
            const searchQuery = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value.toLowerCase();

            accessoryRows.forEach(row => {
                const name = row.querySelector("td:nth-child(4)").textContent.toLowerCase();
                const category = row.querySelector("td:nth-child(5)").textContent.toLowerCase();

                row.dataset.visible = name.includes(searchQuery) && (!selectedCategory || category.includes(selectedCategory)) ? "true" : "false";
            });

            visibleCount = 10; // Reset số dòng hiển thị
            hideExtraRows();
        };

        // Gắn sự kiện lọc cho input tìm kiếm và dropdown danh mục
        searchInput.addEventListener('input', filterAccessories);
        categoryFilter.addEventListener('change', filterAccessories);

        // Xử lý checkbox chọn tất cả
        selectAll.addEventListener('change', () => {
            checkboxes.forEach(checkbox => checkbox.checked = selectAll.checked);
        });

        // Xử lý nút xóa các dòng được chọn
        deleteSelected.addEventListener('click', () => {
            const checkedBoxes = document.querySelectorAll('input[name="selected[]"]:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select at least one accessory to delete.');
            } else {
                bulkDeleteForm.submit();
            }
        });

        // Khởi tạo trạng thái hiển thị ban đầu
        accessoryRows.forEach(row => row.dataset.visible = "true");
        hideExtraRows();
    });
</script>
@endsection
