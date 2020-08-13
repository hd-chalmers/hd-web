<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveGames;
use App\Models\Game;
use App\Models\GamePlatform;
use Composer\Util\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * GameController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'index',
                'show'
            ],
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (\request()->query('json')) {
            return response()->json(Game::all());
        }
        return view('game.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function create()
    {
        return response(view('game.create', ['platforms' => GamePlatform::all(['id', 'name', 'type', 'bgg_type'])]));

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Game $game
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        $platforms = GamePlatform::orderBy('type')->get([
                                                            'id',
                                                            'name',
                                                            'type',
                                                        ]);
        $game->load([
                        'game_owner',
                        'expansions',
                        'expansion_to',
                        'game_platform',
                    ]);
        return response(view('game.edit')->with('game', $game)->with('platforms', $platforms));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function save(SaveGames $request)
    {
        try {
            \DB::beginTransaction();
            foreach ($request->post('games') as $data) {
                /** @var Game $game */
                $game                 = Game::findOrFail($data['id'])->get();
                $game->published_year = $data['published_year'];
                $game->max_players    = $data['max_players'];
                $game->min_players    = $data['min_players'];
                $game->min_playtime   = $data['min_playtime'];
                $game->max_playtime   = $data['max_playtime'];
                $game->name           = $data['name'];
                $game->update();
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }
}
