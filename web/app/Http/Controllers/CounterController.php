<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CounterController extends Controller
{
    public function index() {
        $counter = Cache::remember('counter', 60*60*24, function() {
           return 0;
        });
        return view('counter')->with('counter', $counter);
    }

    public function increase() {
        return response()->json(['count' => Cache::increment('counter')]);
    }

    public function decrease() {
        return response()->json(['count' => Cache::decrement('counter')]);
    }

    public function get() {
        return response()->json(['count' => Cache::get('counter') ?? 0]);
    }

    public function reset() {
        Cache::set('counter', 0);
        return response()->json(['count' => Cache::get('counter') ?? 0]);
    }
}
