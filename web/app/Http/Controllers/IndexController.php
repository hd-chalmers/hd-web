<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDoor;
use App\Models\ActiveYear;
use App\Models\DoorStatus;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function index ()
    {
        $event = Event::where('date', '>', 'now')->where('show_on_frontpage', 1)->orderBy('date')->get()->first();
        return view('index')->with([
                                       'event'       => $event,
                                       'active_year' => ActiveYear::latest()->first(['front_image']),
                                   ]);
    }

    public function door (Request $request)
    {
//        if (env('APP_ENV') === 'local') {
//            return '{"status":"'.Cache::remember('random-door', 15, static function() {return random_int(0, 1);}).'","updated":"2020-08-21 09:38:15.759791"}';
//        }


        return response(DoorStatus::orderBy('created_at', 'desc')->first());
    }

    public function door_old (Request $request)
    {
        /** @var DoorStatus $status */
        $status = DoorStatus::orderBy('created_at', 'desc')->first();

        return response([
                            'status'  => $status->status ? 1 : 0,
                            'updated' => $status->updated,
                            'notice'  => 'This endpoint is deprecated, please use /api/door instead',
                        ]);
    }

    public function updateDoor (UpdateDoor $request)
    {
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
