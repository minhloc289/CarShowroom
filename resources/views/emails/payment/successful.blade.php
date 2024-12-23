@component('mail::message')
# Xác nhận thanh toán gia hạn

Chào {{ $name }},

Thanh toán gia hạn của bạn đã thành công. Dưới đây là thông tin chi tiết:

- **Mã đơn hàng:** {{ $order_id }}
- **Mã hóa đơn:** {{ $receipt_id }}
- **Ngày bắt đầu:** {{ $start_date }}
- **Ngày kết thúc:** {{ $end_date }}
- **Tổng chi phí:** {{ number_format($total_cost, 0, ',', '.') }} VND

Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!

@component('mail::button', ['url' => route('rentalHistory')])
Xem lịch sử thuê xe
@endcomponent

Trân trọng,<br>
{{ config('app.name') }}
@endcomponent
