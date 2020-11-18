<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\ActiveYear;
use App\Models\Barcode;
use App\Models\Category;
use App\Models\CommitteeMember;
use App\Models\Event;
use App\Models\Game;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LoehkController extends Controller
{
    public function index ()
    {
        return response(view('loehk'));
    }

    public function stats ()
    {
        return response()->json([
                                    'products'            => Product::all()->count(),
                                    'product_updated'     => Product::whereNotNull('updated_at')->orderBy('updated_at', 'desc')->first([
                                                                                                               'name',
                                                                                                               'updated_at',
                                                                                                           ]),
                                    'product_latest'      => Product::latest()->first([
                                                                                          'name',
                                                                                          'created_at',
                                                                                      ]),
                                    'investment_accounts' => Account::all()->count(),
                                    'investment_latest'   => Account::latest()->first([
                                                                                          'uid',
                                                                                          'name',
                                                                                          'created_at',
                                                                                      ]),
                                    'investment_updated'  => Account::whereNotNull('updated_at')->orderBy('updated_at', 'desc')->first([
                                                                                                               'uid',
                                                                                                               'name',
                                                                                                               'updated_at',
                                                                                                           ]),
                                    'events'              => Event::all()->count(),
                                    'event_latest'        => Event::latest()->first([
                                                                                        'title',
                                                                                        'created_at',
                                                                                        'date',
                                                                                    ]),
                                    'event_updated'       => Event::whereNotNull('updated_at')->orderBy('updated_at', 'desc')->first([
                                                                                                             'title',
                                                                                                             'updated_at',
                                                                                                             'date',
                                                                                                         ]),
                                    'games'               => Game::all()->count(),
                                    'games_latest'        => Game::latest()->first([
                                                                                       'name',
                                                                                       'created_at',
                                                                                   ]),
                                    'games_updated'       => Game::whereNotNull('updated_at')->orderBy('updated_at', 'desc')->first([
                                                                                                            'name',
                                                                                                            'updated_at',
                                                                                                        ]),
                                ]);
    }

    public function active_year ()
    {
        return response()->json([
                                    'all_years' => ActiveYear::with('committee_members')->orderBy('year', 'desc')->get(),
                                    'current'   => ActiveYear::getLatest(false),
                                ]);
    }

    public function update (Request $request, ActiveYear $active_year)
    {
        Cache::forget('active_year');
        if (count($request->allFiles())) {
            foreach ($request->allFiles() as $type => $file) {
                $path = $file->storePubliclyAs('public/' . $active_year->year, $type . '.' . $file->extension());
                $active_year->$type = str_replace('public/', '', $path);
                Log::info($type);
            }
        } else {
            $active_year->description = $request->post('description');
        }
        $active_year->save();
        return $active_year;
    }

    public function updateCommitteeMember (Request $request, CommitteeMember $committee_member)
    {
        Cache::forget('active_year');
        $committee_member->load('active_year');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->storePubliclyAs('public/' . $committee_member->active_year->year . '/members', $committee_member->name . '_profile.' . $file->extension());
            $committee_member->image = str_replace('public/', '', $path);
        } else {
            foreach ($request->all() as $field => $value) {
                $committee_member->$field = $value;
            }
        }
        $committee_member->save();
        return $committee_member;
    }

    public function deleteCommitteeMember (CommitteeMember $committee_member)
    {
        Cache::forget('active_year');
        Storage::delete([
                            $committee_member->image,
                            'public/' . $committee_member->image,
                        ]);
        $committee_member->delete();
    }

    public function newCommitteeMember (Request $request)
    {
        Cache::forget('active_year');
        $committee_member = new CommitteeMember();
        $committee_member->name = '';
        $committee_member->role = '';
        foreach ($request->all() as $field => $value) {
            $committee_member->$field = $value;
        }
        $committee_member->active_year_id = $request->post('active_year_id');
        $committee_member->save();
        return $committee_member;
    }

    public function newActiveYear ()
    {
        Cache::forget('active_year');
        $active_year = new ActiveYear();
        $active_year->year = Carbon::now();
        $active_year->save();
        return $active_year;
    }

    public function newEvent (Request $request)
    {
        Log::debug(print_r($request->toArray(), true));
        $event = new Event($request->toArray());
        Log::debug($event->toJson());
        $event->save();
        return response()->json($event);
    }

    public function getEvents ()
    {
        return response()->json(Event::orderBy('date', 'asc')->get());
    }

    public function updateEvent (Request $request, Event $event)
    {
        foreach ($request->toArray() as $field => $value) {
            $event->$field = $value;
        }
        $event->save();
    }

    public function deleteEvent (Event $event)
    {
        $event->delete();
    }

    public function getPrices ()
    {
        return response()->json([
                                    'products'   => Product::with([
                                                                      'barcodes',
                                                                      'category',
                                                                  ])->orderBy('name')->get(),
                                    'categories' => Category::all(),
                                ]);
    }
}
