<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function event()
    {
        $events = Event::all();
        return view('events.event', compact('events'));
    }

    public function eventDetail($id)
    {
        $events = Event::where('id', $id)->first();
        return view('events.event_detail', compact('events'));
    }
}
