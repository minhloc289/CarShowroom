@extends('frontend.layouts.App')

@section('content')

<div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
      
      <!-- Mục Giới thiệu -->
      <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900">PHỤ KIỆN</h1>
        <p class="mt-4 text-lg text-gray-600">
          Tại đây, chúng tôi cung cấp những phụ kiện ô tô chất lượng cao, đa dạng mẫu mã và giá cả hợp lý. 
          Hãy khám phá ngay để tìm thấy những sản phẩm phù hợp nhất cho chiếc xe của bạn.
        </p>
      </div>

      <!-- Danh sách sản phẩm -->
      <h2 class="sr-only">Products</h2>
  
      <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
        @foreach ($accessories as $accessory)
        <a href="#" class="group">
          <img src="{{ $accessory->image_url }}" 
               alt="{{ $accessory->name }}" 
               class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-[7/8]">
          <h3 class="mt-4 text-sm text-gray-700">{{ $accessory->name }}</h3>
          <p class="mt-1 text-lg font-medium text-gray-900">{{ number_format($accessory->price, 0, ',', '.') }} VND</p>
        </a>
        @endforeach
      </div>
    </div>
  </div>

@endsection
