@component('mail::message')
# Đăng ký thành công!

Bạn đã đăng ký tham gia sự kiện:

**{{ $event->title }}**
📍 Địa điểm: {{ $event->location }}
🗓 Thời gian: {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}

@component('mail::button', ['url' => 'https://your-frontend.com/events/' . $event->id])
Xem chi tiết
@endcomponent

Cảm ơn bạn đã tham gia!

@endcomponent
