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

    /**
     * Each GamePlayer record is associated with a Player record
     *
     * @return mixed
     */
    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    /**
     * Each GamePlayer record is associated with a Game record
     *
     * @return mixed
     */
    public function game()
    {
        return $this->belongsTo('App\Game');
    }
}
