<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GamePlayer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id', 'game_id', 'score',
    ];

    public function player()
    {
        return $this->belongsTo('App\Player');
    }
}
