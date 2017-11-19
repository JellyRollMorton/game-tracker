<?php

namespace App\Http\Controllers\API;

use App\Game;
use App\GamePlayer;
use App\Http\Controllers\Controller;
use App\Player;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'players.*.id' => 'required',
            'players.*.score' => 'required',
        ]);

        $request->validate([
            'players.*.id' => 'distinct',
            'players.*.score' => 'distinct'
        ]);

        $inputs = $request->input();

        // at least two players must be identified
        if (count($inputs['players']) > 1) {
            // validate that the players exists
            foreach ($inputs['players'] as $playerAttrs) {
                $player = Player::find($playerAttrs['id']);
                if (!$player) {
                    return response()->json(['error' => 'Player is invalid'], 400);
                }
            }

            $game = new Game;
            $game->save();

            // create a gamePlayer record for each player's score in the game
            foreach ($inputs['players'] as $playerAttrs) {
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
}