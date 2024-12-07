@extends('frontend.layouts.App')

@section('content')
@php
    $user = session('login_account');
@endphp
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Your Cart</h1>

    @if($cartItems->isEmpty())
        <p class="text-gray-600">Your cart is empty.</p>
    @else
        <table class="table-auto w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b p-4">Product</th>
                    <th class="border-b p-4">Price</th>
                    <th class="border-b p-4">Quantity</th>
                    <th class="border-b p-4">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td class="border-b p-4">{{ $item->accessory->name }}</td>
                        <td class="border-b p-4">{{ number_format($item->accessory->price, 0, ',', '.') }} VND</td>
                        <td class="border-b p-4">{{ $item->quantity }}</td>
                        <td class="border-b p-4">{{ number_format($item->total_price, 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
