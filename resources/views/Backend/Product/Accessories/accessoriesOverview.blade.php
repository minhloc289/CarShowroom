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
            <h1>Manage Accessories</h1>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" id="addAccessoryButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Add
                </button>
                <ul class="dropdown-menu" aria-labelledby="addAccessoryButton">
                    <li><a class="dropdown-item" href="{{ route('accessories.create') }}">Add One Accessory</a></li>
                    <li><a class="dropdown-item" href="{{ route('accessories.upload') }}">Add Multiple Accessories</a></li>
                </ul>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="flex items-center space-x-4 mb-4">
            <input type="text" id="accessorySearchInput" placeholder="Search"
                class="rounded-lg border border-gray-300 px-4 py-2 w-64">

            <!-- Select Category -->
            <select id="categoryFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>

        <div id="accessoriesContainer" class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accessories as $index => $accessory)
                        <tr class="accessory-item">
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
                                <a href="{{ route('accessories.details', ['id' => $accessory->accessory_id]) }}" class="btn btn-primary btn-sm">View Details</a>
                                <a href="{{ route('accessories.edit', ['id' => $accessory->accessory_id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('accessories.destroy', ['id' => $accessory->accessory_id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- View More Button -->
        <div class="d-flex justify-content-center align-items-center">
            <button id="viewMoreButton" class="text-blue-500 text-sm font-semibold hover:underline">
                View more →
            </button>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('accessorySearchInput'); // Ô tìm kiếm
        const categoryFilter = document.getElementById('categoryFilter'); // Dropdown danh mục
        const accessoryRows = document.querySelectorAll('.accessory-item'); // Tất cả hàng phụ kiện
        const viewMoreButton = document.getElementById('viewMoreButton'); // Nút View More

        let visibleCount = 10; // Số dòng hiển thị mặc định ban đầu

        // Ẩn các dòng ngoài phạm vi hiển thị
        const hideExtraRows = () => {
            let visibleRows = 0; // Đếm số dòng hiển thị thực tế

            accessoryRows.forEach((row) => {
                // Kiểm tra nếu dòng không bị ẩn do tìm kiếm hoặc lọc
                if (row.dataset.visible === "true") {
                    if (visibleRows < visibleCount) {
                        row.style.display = ""; // Hiển thị dòng trong phạm vi
                        visibleRows++;
                    } else {
                        row.style.display = "none"; // Ẩn các dòng vượt phạm vi
                    }
                } else {
                    row.style.display = "none"; // Ẩn các dòng không khớp tìm kiếm/lọc
                }
            });

            // Hiển thị hoặc ẩn nút View More
            if (visibleRows >= accessoryRows.length || visibleCount >= accessoryRows.length) {
                viewMoreButton.style.display = "none"; // Ẩn nút nếu tất cả dòng đã hiển thị
            } else {
                viewMoreButton.style.display = "block"; // Hiển thị nút nếu còn dòng bị ẩn
            }
        };

        // Xử lý khi nhấn nút View More
        viewMoreButton.addEventListener("click", function () {
            visibleCount += 10; // Tăng số dòng hiển thị thêm 10
            hideExtraRows(); // Cập nhật lại hiển thị
        });

        // Hàm lọc phụ kiện
        const filterAccessories = () => {
            const searchQuery = searchInput.value.toLowerCase(); // Lấy giá trị tìm kiếm
            const selectedCategory = categoryFilter.value.toLowerCase(); // Lấy danh mục đã chọn

            accessoryRows.forEach(row => {
                const name = row.querySelector("td:nth-child(3)").textContent.toLowerCase(); // Tên phụ kiện
                const category = row.querySelector("td:nth-child(4)").textContent.toLowerCase(); // Danh mục

                const matchesSearchQuery = name.includes(searchQuery); // Khớp với tìm kiếm
                const matchesCategory = selectedCategory ? category.includes(selectedCategory) : true; // Khớp với danh mục

                // Cập nhật trạng thái dòng
                if (matchesSearchQuery && matchesCategory) {
                    row.dataset.visible = "true"; // Đánh dấu dòng phù hợp
                } else {
                    row.dataset.visible = "false"; // Đánh dấu dòng không phù hợp
                }
            });

            visibleCount = 10; // Reset lại số dòng hiển thị sau khi lọc
            hideExtraRows(); // Cập nhật lại hiển thị
        };

        // Gắn sự kiện cho tìm kiếm và lọc danh mục
        searchInput.addEventListener("input", filterAccessories); // Lọc khi nhập tìm kiếm
        categoryFilter.addEventListener("change", filterAccessories); // Lọc khi chọn danh mục

        // Ẩn các dòng dư thừa khi load trang
        accessoryRows.forEach(row => row.dataset.visible = "true"); // Đặt mặc định tất cả dòng đều hiển thị
        hideExtraRows();
    });

</script>
@endsection
