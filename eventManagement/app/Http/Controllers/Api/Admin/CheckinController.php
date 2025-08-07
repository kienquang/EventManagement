<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CheckedInNotification;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckinController extends Controller
{
    public function checkin($id)
    {
        $registration = Registration::find($id);

        if (!$registration) {
            return response()->json(['message' => 'Không tìm thấy đăng ký.'], 404);
        }

        if ($registration->checked_in_at) {
            return response()->json(['message' => 'Người này đã check-in.'], 200);
        }

        $registration->checked_in_at = now();
        $registration->save();

        Mail::to($registration->user->email)->send(new CheckedInNotification($registration));

        return response()->json([
            'message' => 'Check-in thành công!',
            'user' => $registration->user->name,
            'event' => $registration->event->title,
            'checked_in_at' => $registration->checked_in_at
        ]);
    }
}
