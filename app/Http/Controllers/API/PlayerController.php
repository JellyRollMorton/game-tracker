<?php

namespace App\Http\Controllers\API;

use \App\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
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
            'name' => 'required'
        ]);

        $player = new Player;
        $player->name = $request->input('name');
        $player->save();
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

    public function search(Request $request)
    {
        $response = [
            'results' => []
        ];

        $searchQuery= $request->input()['q'];

        // the term parameter only exists if the user has typed more than one character
        if (array_key_exists('term', $searchQuery)) {
            // the search value is processed as a bind variable, so it's protected against
            // SQL injection
            $players = Player::where('name', 'like', '%' . $searchQuery['term'] . '%')->limit(10)->get();

            foreach($players as $player) {
                $response['results'][] = [
                    'id' => $player->id,
                    'text' => $player->name
                ];
            }            
        }

        return response()->json($response);
    }
}
