<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\PlayerRanking;
use Illuminate\Http\Request;

class PlayerRankingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [
            'data' => []
        ];

        // eager load the player relationship to improve performance, since we'll need it for each record immediately
        // after loading
        $playerRankings = PlayerRanking::with('player')->get();
        foreach ($playerRankings as $playerRanking) {
            $response['data'][] =
                [
                    $playerRanking->rank,
                    $playerRanking->player->name,
                    $playerRanking->win_count,
                    $playerRanking->loss_count];
        }

        return response()->json($response);
    }
}
