@component('mail::message')
# Xin chào {{ $data['name'] }},

Yêu cầu gia hạn của bạn đã được **chấp nhận**. Vui lòng thanh toán để hoàn tất gia hạn thuê xe.

### Thông tin gia hạn:
- **Chi phí gia hạn:** {{ number_format($data['renewal_cost'], 0, ',', '.') }} VND
- **Ngày kết thúc mới:** {{ $data['new_end_date'] }}

@component('mail::button', ['url' => $data['payment_link']])
Thanh toán ngay
@endcomponent

Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!<br>
{{ config('app.name') }}
@endcomponent
