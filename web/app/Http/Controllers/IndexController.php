<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDoor;
use App\Models\ActiveYear;
use App\Models\DoorStatus;
use App\Models\Event;
use GuzzleHttp\Client;
use GuzzleHttp\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function index() {
        $event = Event::where('date', '>', 'now')->where('show_on_frontpage', 1)->orderBy('date')->get()->first();
        return view('index')->with(['event' => $event, 'active_year' => ActiveYear::latest()->first(['front_image'])]);
    }

    public function door(Request $request) {
//        if (env('APP_ENV') === 'local') {
//            return '{"status":"'.Cache::remember('random-door', 15, static function() {return random_int(0, 1);}).'","updated":"2020-08-21 09:38:15.759791"}';
//        }


        return response(DoorStatus::orderBy('created_at', 'desc')->first());
    }

    public function updateDoor(UpdateDoor $request) {
        /** @var DoorStatus $latest */
        $latest = DoorStatus::orderBy('created_at', 'desc')->first();
        try {
            if ($latest->exists && $latest->status === $request->boolean('status')) {
                return $latest;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        $door = new DoorStatus();
        $door->status = $request->input('status');
        $door->save();
        return $door;
    }
}
