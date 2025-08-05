<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Event $event){
        return $event->registrations()->with('user')->paginate(20);
    }
}
