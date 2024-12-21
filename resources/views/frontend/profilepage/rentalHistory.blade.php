@extends('frontend.profilepage.viewprofile')

@section('main')
<div class="bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Lịch sử thuê xe của bạn</h2>

        <div class="space-y-4">
            @forelse ($rentalReceipts as $receipt)
            <a href="{{ route('rentalHistory.showReceipt', ['receiptId' => $receipt->receipt_id]) }}"
               class="block transition duration-150 ease-in-out hover:shadow-md">
                <div class="bg-white rounded-xl border border-gray-100 p-4">
                    <div class="flex items-center justify-between">
                        <!-- Ảnh xe và tên -->
                        <div class="flex items-center gap-4">
                            <img src="{{ $receipt->rentalCar->carDetails->image_url ?? 'default-image.jpg' }}"
                                 alt="{{ $receipt->rentalCar->carDetails->name }}"
                                 class="w-25 h-20 object-cover rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $receipt->rentalCar->carDetails->name }}
                            </h3>
                        </div>

                        <!-- Trạng thái -->
                        <div class="flex items-center gap-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($receipt->status === 'Active')
                                    bg-green-100 text-green-800
                                @elseif($receipt->status === 'Canceled')
                                    bg-red-100 text-red-800
                                @else
                                    bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $receipt->status }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="bg-white rounded-xl border border-gray-100 p-6 text-center">
                <p class="text-gray-500">Không có giao dịch thuê xe nào.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection