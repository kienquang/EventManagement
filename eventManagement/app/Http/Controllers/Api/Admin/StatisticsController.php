<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $events = Event::withCount('registrations')->get();

        $data = $events->map(function ($event) {
            return [
                'title' => $event->title,
                'registrations' => $event->registrations_count,
            ];
        });

        return response()->json($data);
    }
}
