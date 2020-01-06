<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $event = Event::where('date', '>', 'now')->where('show_on_frontpage', 1)->orderBy('date')->get()->first();
        return view('index')->with('event', $event);
    }
}
