<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveGames;
use App\Models\Game;
use App\Models\GamePlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('game.list')->with('platforms', GamePlatform::with('games')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function create()
    {
        if (!Auth::check()) {
            abort(403);
        }
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
        if (!Auth::check()) {
            abort(403);
        }
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
                $game                 = Game::whereId($data['id'])->firstOrFail();
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
