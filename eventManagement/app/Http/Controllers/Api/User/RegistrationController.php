<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationSuccessMail;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = $request->user();

        $event = Event::where('id', $id)->whereNull('deleted_at')->firstOrFail();

        if (Registration::where('user_id', $user->id)->where('event_id', $event->id)->exists()) {
            return response()->json(['message' => 'Bạn đã đăng ký sự kiện này rồi.'], 400);
        }

        $registeredCount = Registration::where('event_id', $event->id)->count();
        if ($event->limit && $registeredCount >= $event->limit) {
            return response()->json(['message' => 'Sự kiện đã đầy.'], 400);
        }

        $registration = Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'registered',
        ]);

        Mail::to($user->email)->send(new RegistrationSuccessMail($registration,$event));

        return response()->json(['message' => 'Đăng ký thành công!', 'registration' => $registration], 201);
    }

    public function destroy(Request $request, $eventId)
    {
        $user = $request->user();

        // Tìm sự kiện
        $event = Event::findOrFail($eventId);

        // Tìm bản đăng ký
        $registration = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if (! $registration) {
            return response()->json(['message' => 'Bạn chưa đăng ký sự kiện này.'], 404);
        }

        if ($registration->checked_in_at) {
            return response()->json(['message' => 'Bạn đã điểm danh, không thể hủy đăng ký.'], 400);
        }

        // Hủy đăng ký bằng soft delete
        $registration->delete();

        return response()->json(['message' => 'Hủy đăng ký thành công.']);
    }


}
