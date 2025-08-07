@component('mail::message')
# Check in thành công

Bạn đã check in sự kiện:

**{{ $registration->event->title }}**
📍 Địa điểm: {{ $registration->event->location }}
🗓 Thời gian: {{ \Carbon\Carbon::parse($registration->event->date)->format('d/m/Y H:i') }}

Cảm ơn bạn đã tham gia!

@endcomponent
