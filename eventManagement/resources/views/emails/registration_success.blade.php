@component('mail::message')
# Đăng ký thành công!

Bạn đã đăng ký tham gia sự kiện:

**{{ $event->title }}**
📍 Địa điểm: {{ $event->location }}
🗓 Thời gian: {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}

---

## Mã QR điểm danh:

<img src="data:image/png;base64,{{ $qr }}" alt="QR Code" />

---

@component('mail::button', ['url' => 'https://your-frontend.com/events/' . $event->id])
Xem chi tiết
@endcomponent

Cảm ơn bạn đã tham gia!

@endcomponent
