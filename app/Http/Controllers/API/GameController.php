<?php

namespace App\Http\Controllers\API;

use App\Game;
use App\Player;
use App\GamePlayer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validatedData = $request->validate([
            'players.*.id' => 'required',
            'players.*.score' => 'required',
            'players.*.id' => 'distinct',
            'players.*.score' => 'distinct'
        ]);

        $inputs = $request->input();

        if (count($inputs['players']) > 1) {
            // validate that the players exists
            foreach($inputs['players'] as $playerAttrs) {            
                $player = Player::find($playerAttrs['id']);
                if (!$player) {
                    return response()->json(['error' => 'Player is invalid'], 400);
                }
            }

            $game = new Game;
            $game->save();

            foreach($inputs['players'] as $playerAttrs) {
                $gamePlayer = new GamePlayer;
                $gamePlayer->game_id = $game->id;
                $gamePlayer->player_id = $playerAttrs['id'];
                $gamePlayer->score = $playerAttrs['score'];
                $gamePlayer->save();
            }

            return response()->json($game);
        } else {
            return response()->json(['error' => 'At least two players is required'], 400);
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
