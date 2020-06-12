<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCommittee;
use App\Models\ActiveYear;
use App\Models\CommitteeMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CommitteeController extends Controller
{
    /**
     * GameController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'index',
                'show',
            ],
        ]);

        $this->middleware('optimizeImages', [
            'only' => [
                'update',
                'store'
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('committee.list')->with('active_year', ActiveYear::with('committee_members')->latest()->first());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('committee.list')->with('active_year', ActiveYear::with('committee_members')->findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('committee.edit')->with('active_year', ActiveYear::with('committee_members')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommittee $request
     * @param ActiveYear      $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function update(UpdateCommittee $request, $id)
    {
        try {
            DB::beginTransaction();
        $activeYear = ActiveYear::findOrFail($id);
        $activeYear->load("committee_members");

        $activeYear->year        = Carbon::createFromTimeString($request->input('year').'-05-01 00:00');
        $activeYear->description = $request->input('description');

        foreach ($request->input('member') as $key => $requestMember) {
            $member                  = CommitteeMember::findOrNew($requestMember['id']);
            $member->name            = $requestMember['name'];
            $member->role            = $requestMember['role'];
            $member->description     = $requestMember['description'];
            $member->quote           = $requestMember['quote'];
            $member->favourite_game  = $requestMember['favourite_game'];
            $member->favourite_sugar = $requestMember['favourite_sugar'];

            if ($request->hasFile('member.' . $key . '.image')) {
                $file     = $request->file('member.' . $key . ".image");
                $fileName = $activeYear->year . '_' . $member->name . '.' . $file->extension();
                $path     = 'public' . $member->image;
                if ($activeYear->background_image && Storage::exists($path)) {
                    Storage::delete($path);
                }
                if ($newFile = $file->storePubliclyAs('img/members/' . $activeYear->year, $fileName, ['disk' => 'public'])) {
                    $member->image = $newFile;
                } else {
                    return abort(400, "Unable to save image for " . $member->name);
                }

            }
            if ($member->exists) {
                $member->save();
            } else {
                $activeYear->committee_members->add($member);
            }
        }

        foreach ([
                     'background_image' => 'backgrounds',
                     'group_photo'      => 'group_photos',
                     'front_image'      => 'front_images',
                 ] as $image => $folder) {
            if ($request->hasFile($image)) {
                $file     = $request->file($image);
                $fileName = $activeYear->year . '_' . $image . '.' . $file->extension();
                $path     = 'public' . $activeYear->background_image;
                if ($activeYear->background_image && Storage::exists($path)) {
                    Storage::delete($path);
                }
                if ($newFile = $file->storePubliclyAs('img/' . $folder . '/' . $activeYear->year, $fileName, ['disk' => 'public'])) {
                    $activeYear->$image = $newFile;
                } else {
                    return abort(400, "Unable to save " . $image);
                }
            }
        }
        $activeYear->save();
        DB::commit();
        } catch (\Exception $e) {
            return abort(400, $e->getMessage());
        }
        return redirect(route('committee.show', ['committee' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
