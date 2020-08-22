<?php

namespace App\Http\Controllers;

use App\Models\ActiveYear;
use App\Models\DoorStatus;
use App\Models\Event;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function index() {
        $event = Event::where('date', '>', 'now')->where('show_on_frontpage', 1)->orderBy('date')->get()->first();
        return view('index')->with(['event' => $event, 'active_year' => ActiveYear::latest()->first(['front_image'])]);
    }

    public function door(Request $request) {
        //$door = DoorStatus::latest()->firstOrFail();
        //return response()->json($door);
        $client = new Client();
        if (env('APP_ENV') === 'local') {
            return '{"status":"'.Cache::remember('random-door', 15, static function() {return random_int(0, 1);}).'","updated":"2020-08-21 09:38:15.759791"}';
        }
        return response()->json(\GuzzleHttp\json_decode($client->get('https://hd.chalmers.se/getstatus/')->getBody()->getContents()));
    }
}
