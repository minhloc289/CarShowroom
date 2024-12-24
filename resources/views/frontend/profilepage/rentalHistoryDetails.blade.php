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

                            @if($rentalReceipt->status === 'Active' || $rentalReceipt->status === 'Completed')
                                <div class="space-y-4" x-data="{ isFormVisible: false }">
                                    <button
                                        @click="isFormVisible = !isFormVisible"
                                        class="group relative w-auto px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg shadow-lg hover:from-red-700 hover:to-red-600 transition-all duration-300 ease-in-out transform hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                    >
                                        <span class="flex items-center justify-center space-x-2">
                                            <span>Gia hạn thuê xe</span>
                                            <svg 
                                                class="w-4 h-4 transition-transform duration-300"
                                                :class="{ 'rotate-180': isFormVisible }"
                                                fill="none" 
                                                stroke="currentColor" 
                                                viewBox="0 0 24 24"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </span>
                                    </button>

                                    <div
                                        x-show="isFormVisible"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                                        x-transition:enter-end="opacity-100 transform translate-y-0"
                                        x-transition:leave="transition ease-in duration-300"
                                        x-transition:leave-start="opacity-100 transform translate-y-0"
                                        x-transition:leave-end="opacity-0 transform -translate-y-4"
                                        class="transform transition-all duration-300 ease-in-out"
                                    >
                                        <form action="{{ route('rental.extend', $rentalReceipt->receipt_id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg border border-gray-100 space-y-4">
                                            @csrf
                                            <input type="hidden" name="receipt_id" value="{{ $rentalReceipt->receipt_id }}">
                                            
                                            <div class="space-y-2">
                                                <label for="extend_days" class="block text-sm font-medium text-gray-700">
                                                    Số ngày muốn gia hạn
                                                </label>
                                                <div class="relative">
                                                    <input
                                                        type="number"
                                                        name="extend_days"
                                                        id="extend_days"
                                                        min="1"
                                                        class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 shadow-sm"
                                                        required
                                                        placeholder="Nhập số ngày"
                                                    >
                                                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">
                                                        ngày
                                                    </span>
                                                </div>
                                                @error('extend_days')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button
                                                type="submit"
                                                class="w-full px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg shadow-lg hover:from-red-700 hover:to-red-600 transition-all duration-300 ease-in-out transform hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                            >
                                                Gửi yêu cầu gia hạn
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
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

<script src="//unpkg.com/alpinejs" defer></script>

@endsection
