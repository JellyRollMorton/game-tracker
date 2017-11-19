<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
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
            'name' => 'required'
        ]);

        $player = new Player;
        $player->name = $request->input('name');
        $player->save();
    }

    /**
     * Allow for player names to be searched for via the Datatables remote data source API
     *
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $response = [
            'results' => []
        ];

        $searchQuery = $request->input()['q'];

        // the term parameter only exists if the user has typed more than one character
        if (array_key_exists('term', $searchQuery)) {
            // the search value is processed as a bind variable, so it's protected against SQL injection
            $players = Player::where('name', 'ilike', '%' . $searchQuery['term'] . '%')->limit(10)->get();

            foreach ($players as $player) {
                $response['results'][] = [
                    'id' => $player->id,
                    'text' => $player->name
                ];
            }
        }

        return response()->json($response);
    }
}
