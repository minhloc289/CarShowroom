@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="profile" />
    <div class="container mt-4">
        <div class="bg-white shadow rounded-lg p-5">
            <h1 class="text-primary mb-4 text-center text-3xl fw-bold">Quản lý thông tin cá nhân</h1>
    
            <!-- Form hiển thị và chỉnh sửa thông tin -->
            <form action="{{ route('Profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
    
                <div class="row align-items-center">
                    <!-- Ảnh đại diện -->
                    <div class="col-md-4 text-center">
                        <div class="position-relative">
                            <label for="image" class="position-absolute w-100 h-100 top-0 start-0" 
                                style="z-index: 1; cursor: pointer;"></label>
                            <img 
                                src="{{ $user->image ? asset('storage/' . $user->image) : asset('default-avatar.png') }}" 
                                class="rounded-circle border shadow mx-auto d-block"
                                alt="User Avatar" 
                                style="width: 150px; height: 150px; object-fit: cover; transition: transform 0.3s; cursor: pointer;"
                                onmouseover="this.style.transform='scale(1.1)'"
                                onmouseout="this.style.transform='scale(1)'"
                            >
                            <p class="text-muted mt-3" style="font-size: 0.9rem;">Nhấp vào ảnh để thay đổi</p>
                            <input type="file" name="image" id="image" class="d-none" accept="image/*">
                        </div>
                    </div>
                
                    <!-- Thông tin cá nhân -->
                    <div class="col-md-8">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label text-primary fw-bold">Họ và tên</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    class="form-control border-primary shadow-sm" 
                                    value="{{ old('name', $user->name) }}" 
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label text-primary fw-bold">Email</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    class="form-control border-primary shadow-sm" 
                                    value="{{ old('email', $user->email) }}" 
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label text-primary fw-bold">Số điện thoại</label>
                                <input 
                                    type="text" 
                                    name="phone" 
                                    id="phone" 
                                    class="form-control border-primary shadow-sm" 
                                    value="{{ old('phone', $user->phone) }}"
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="birthday" class="form-label text-primary fw-bold">Ngày sinh</label>
                                <input 
                                    type="date" 
                                    name="birthday" 
                                    id="birthday" 
                                    class="form-control border-primary shadow-sm" 
                                    value="{{ old('birthday', $user->birthday ? $user->birthday->format('Y-m-d') : '') }}"
                                >
                            </div>
                            <div class="col-md-12">
                                <label for="address" class="form-label text-primary fw-bold">Địa chỉ</label>
                                <input 
                                    type="text" 
                                    name="address" 
                                    id="address" 
                                    class="form-control border-primary shadow-sm" 
                                    value="{{ old('address', $user->address) }}"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Nút hành động -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-5 py-3 rounded-pill shadow" 
                        style="font-size: 1.2rem; font-weight: bold; transition: background-color 0.3s; transform: scale(1);"
                        onmouseover="this.style.backgroundColor='#28a745cc'; this.style.transform='scale(1.1)'"
                        onmouseout="this.style.backgroundColor='#28a745'; this.style.transform='scale(1)'">
                        Cập nhật thông tin
                    </button>
                </div>
            </form>
        </div>
    </div>
    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput = document.getElementById('image');
            const avatar = document.querySelector('.rounded-circle');

            avatar.addEventListener('click', function () {
                imageInput.click(); // Khi nhấp vào avatar, mở chọn file
            });

            imageInput.addEventListener('change', function () {
                const reader = new FileReader();
                reader.onload = function (e) {
                    avatar.src = e.target.result; // Cập nhật ảnh ngay khi người dùng chọn
                };
                if (imageInput.files[0]) {
                    reader.readAsDataURL(imageInput.files[0]);
                }
            });
        });
    </script>
@endsection
