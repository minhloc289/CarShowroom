@extends('frontend.profilepage.viewprofile')

@section('main')
<div class="bg-gray-50 pt-8 pb-2">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Chi tiết giao dịch</h2>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 md:p-8 grid md:grid-cols-2 gap-8">
                <!-- Thông tin giao dịch -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin chung</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Mã giao dịch</span>
                                <span class="font-medium text-gray-900">{{ $rentalReceipt->receipt_id }}</span>
                            </div>
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Trạng thái</span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($rentalReceipt->status === 'Active')
                                        bg-green-100 text-green-800
                                    @elseif($rentalReceipt->status === 'Canceled')
                                        bg-red-100 text-red-800
                                    @else
                                        bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $rentalReceipt->status }}
                                </span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Ngày bắt đầu</span>
                                <span class="font-medium text-gray-900">{{ $rentalReceipt->rental_start_date }}</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Ngày kết thúc</span>
                                <span class="font-medium text-gray-900">{{ $rentalReceipt->rental_end_date }}</span>
                            </div>

                            <div class="flex justify-between text-sm pt-3 border-t">
                                <span class="text-gray-900 font-medium">Tổng chi phí</span>
                                <span class="text-blue-600 font-semibold">{{ number_format($rentalReceipt->total_cost, 0, ',', '.') }} VND</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin xe -->
                <div class="flex flex-col items-center">
                    <div class="w-full aspect-video rounded-lg overflow-hidden bg-gray-100">
                        <img 
                            src="{{ $rentalReceipt->rentalCar->carDetails->image_url ?? 'default-image.jpg' }}" 
                            alt="Rental Car"
                            class="w-full h-full object-cover"
                        >
                    </div>
                    
                    <div class="mt-4 text-center">
                        <h4 class="text-lg font-semibold text-gray-900">
                            {{ $rentalReceipt->rentalCar->carDetails->name }}
                        </h4>
                        <div class="mt-2 flex items-center justify-center gap-x-2">
                            <span class="text-sm text-gray-600">Giá thuê mỗi ngày:</span>
                            <span class="text-sm font-semibold text-blue-600">
                                {{ number_format($rentalReceipt->rental_price_per_day, 0, ',', '.') }} VND
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông báo lưu ý -->
        <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded-lg text-sm mb-1">
            <div class="flex items-center">
                <div class="shrink-0">
                    <svg class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-2">
                    <p class="text-yellow-700">
                        Vui lòng trả xe đúng thời hạn để tránh phát sinh phí phụ trội và đảm bảo trải nghiệm tốt nhất cho các khách hàng khác.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
