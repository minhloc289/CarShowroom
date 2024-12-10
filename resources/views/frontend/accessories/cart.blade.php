@extends('frontend.layouts.app')
<script src="{{asset('/assets/js/custom/cart.js')}}"></script>
<link rel="stylesheet" href="{{asset('/assets/css/cart.css')}}"> 
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Your Cart</h1>

    @if($cartItems->isEmpty())
        <p class="text-gray-600">Your cart is empty.</p>
    @else
        <form id="cart-form">
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b p-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="select-all" class="checkbox-all">
                                <label for="select-all" class="ml-2 text-sm font-semibold">Select All</label>
                            </div>
                        </th>
                        <th class="border-b p-4">Product</th>
                        <th class="border-b p-4">Price</th>
                        <th class="border-b p-4">Quantity</th>
                        <th class="border-b p-4">Total</th>
                        <th class="border-b p-4"></th> <!-- Thêm cột Remove -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td class="border-b p-4">
                                <input type="checkbox" class="product-checkbox" data-price="{{ $item->accessory->price }}" data-quantity="{{ $item->quantity }}" data-id="{{ $item->accessory->accessory_id }}">
                            </td>
                            <td class="border-b p-4">
                                <img src="{{ $item->accessory->image_url }}" alt="{{ $item->accessory->name }}" class="w-16 h-16 object-cover mr-4 inline">
                                {{ $item->accessory->name }}
                            </td>
                            <td class="border-b p-4">{{ number_format($item->accessory->price, 0, ',', '.') }} VND</td>
                            <td class="border-b p-4">
                                <div class="flex items-center">
                                    <button type="button" class="decrease-quantity" data-id="{{ $item->accessory->accessory_id }}">-</button>
                                    <input type="number" value="{{ $item->quantity }}" class="quantity-input mx-2" data-id="{{ $item->accessory->accessory_id }}" readonly>
                                    <button type="button" class="increase-quantity" data-id="{{ $item->accessory->accessory_id }}">+</button>
                                </div>
                            </td>
                            <td class="border-b p-4" id="item-total-{{ $item->accessory->accessory_id }}">
                                {{ number_format($item->accessory->price * $item->quantity, 0, ',', '.') }} VND
                            </td>
                            <td class="border-b p-4">
                                <button type="button" class="remove-item text-red-500" data-id="{{ $item->accessory->accessory_id }}">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                <h3 class="text-xl font-semibold">Total: <span id="total-price">{{ number_format($totalPrice, 0, ',', '.') }} VND</span></h3>
            </div>
        </form>

        <!-- Overlay xác nhận -->
        <div id="confirmation-overlay" class="fixed inset-0 z-40 min-h-full overflow-y-auto overflow-x-hidden transition flex items-center hidden">
            <div aria-hidden="true" class="fixed inset-0 w-full h-full bg-black/50 cursor-pointer"></div>
            <div class="relative w-full cursor-pointer pointer-events-none transition my-auto p-4">
                <div class="w-full py-2 bg-white cursor-default pointer-events-auto relative rounded-xl mx-auto max-w-sm">
                    <!-- Nút đóng overlay -->
                    <button tabindex="-1" type="button" class="absolute top-2 right-2" id="close-overlay">
                        <svg title="Close" tabindex="-1" class="h-4 w-4 cursor-pointer text-black"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Nội dung overlay -->
                    <div class="space-y-2 p-2">
                        <div class="p-4 space-y-2 text-center">
                            <h2 class="text-xl font-bold tracking-tight text-black" id="overlay-title"></h2>
                            <p class="text-gray-700">Are you sure you want to remove this item?</p>
                        </div>
                    </div>

                    <!-- Nút điều hướng -->
                    <div class="space-y-2">
                        <div aria-hidden="true" class="border-t border-gray-300 px-2"></div>
                        <div class="px-6 py-2">
                            <div class="grid gap-2 grid-cols-[repeat(auto-fit,minmax(0,1fr))]">
                                <!-- Nút Cancel -->
                                <button type="button" id="cancel-remove"
                                    class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                                <!-- Nút Confirm -->
                                <button type="button" id="confirm-remove"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Confirm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>
@endsection