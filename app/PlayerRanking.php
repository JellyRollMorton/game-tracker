<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerRanking extends Model
{
    public function player()
    {
        return $this->belongsTo('App\Player');
    }
}
