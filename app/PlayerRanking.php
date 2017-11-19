<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * The PlayerRanking model uses an underlying player_ranking view, which was created to improve query performance and
 * facilitate ease of access via Eloquent.  Since all computation is done in the database, computing player rankings
 * is much more efficient than if this code were to be done in code.  This view could potentially be swapped out with
 * a materialized view for improved performance if the database grows very large, but this likely isn't needed
 * even for very large data sets.
 *
 * Class PlayerRanking
 * @package App
 */
class PlayerRanking extends Model
{
    /**
     * Each PlayerRanking record belongs to a Player
     *
     * @return mixed
     */
    public function player()
    {
        return $this->belongsTo('App\Player');
    }
}
