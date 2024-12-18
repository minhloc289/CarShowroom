@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="accessories.create" />
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">

        <!-- Hiển thị thông báo thành công -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form thêm mới -->
        <form action="{{ route('accessories.store') }}" method="POST">
            @csrf

            <!-- Tên phụ kiện -->
            <div class="mb-3">
                <label for="name" class="form-label">Accessory Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <!-- Danh mục -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="Interior">Interior</option>
                    <option value="Exterior">Exterior</option>
                    <option value="Car Care">Car Care</option>
                </select>
            </div>

            <!-- Giá -->
            <div class="mb-3">
                <label for="price" class="form-label">Price (VNĐ)</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <!-- Số lượng -->
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>

            <!-- URL hình ảnh -->
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url" required>
            </div>

            <!-- Mô tả -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Accessory</button>
            <a href="{{ route('accessories.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
