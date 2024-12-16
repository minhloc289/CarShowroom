@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="accessories.edit" />
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <h1>Edit Accessory: {{ $accessory->name }}</h1>

        <!-- Hiển thị thông báo thành công -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form chỉnh sửa phụ kiện -->
        <form action="{{ route('accessories.update', $accessory->accessory_id) }}" method="POST">
            @csrf
            @method('POST')

            <!-- Tên phụ kiện -->
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $accessory->name }}" required>
            </div>

            <!-- Danh mục -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="Interior" {{ $accessory->category == 'Interior' ? 'selected' : '' }}>Interior</option>
                    <option value="Exterior" {{ $accessory->category == 'Exterior' ? 'selected' : '' }}>Exterior</option>
                    <option value="Car Care" {{ $accessory->category == 'Car Care' ? 'selected' : '' }}>Car Care</option>
                </select>
            </div>
            
            <!-- Giá -->
            <div class="mb-3">
                <label for="price" class="form-label">Price (VNĐ)</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $accessory->price }}" required>
            </div>

            <!-- Số lượng -->
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $accessory->quantity }}" required>
            </div>

            <!-- URL Hình ảnh -->
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="url" class="form-control" id="image_url" name="image_url" value="{{ $accessory->image_url }}" required>
            </div>

            <!-- Mô tả -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4">{{ $accessory->description }}</textarea>
            </div>

            <!-- Nút cập nhật -->
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('accessories.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
