@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="rentalCar.record.create"/>
    <div class="container space-y-6">
        <h2 class="mb-3">Thêm Dữ Liệu Xe Thuê Từ File Excel</h2>
    
        <!-- Liên kết tải về file mẫu -->
        <div class="mb-3">
            <a href="{{route('rentalCar.download.template')}}" class="btn btn-secondary" download>
                Tải về file mẫu Excel
            </a>
        </div>
    
        <!-- Form tải lên file Excel -->
        <form action="{{ route('rentalCar.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file" class="mb-3">Chọn file Excel</label>
                <input type="file" class="form-control mb-2" id="file" name="file" accept=".xlsx,.xls" required>
            </div>
        
            <button type="submit" class="btn btn-primary mt-3">Tải lên và Thêm Xe Thuê</button>
        </form>        
    </div>
@endsection