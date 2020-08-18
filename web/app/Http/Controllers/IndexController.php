<?php

namespace App\Http\Controllers;

use App\Models\ActiveYear;
use App\Models\DoorStatus;
use App\Models\Event;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $event = Event::where('date', '>', 'now')->where('show_on_frontpage', 1)->orderBy('date')->get()->first();
        return view('index')->with(['event' => $event, 'active_year' => ActiveYear::latest()->first(['front_image'])]);
    }

    public function door(Request $request) {
        $door = DoorStatus::latest()->firstOrFail();
        return response()->json($door);
    }
}
