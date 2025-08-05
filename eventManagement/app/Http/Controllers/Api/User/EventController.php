<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::whereNull('deleted_at')->latest()->get();
        return response()->json($events);
    }

    public function show($id)
    {
        $event = Event::where('id', $id)->whereNull('deleted_at')->firstOrFail();
        return response()->json($event);
    }
}
