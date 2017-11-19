<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerRankingsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW player_rankings AS 
    WITH ranked_games 
     AS (SELECT game_id, 
                player_id, 
                Rank() 
                  over ( 
                    PARTITION BY game_id 
                    ORDER BY score DESC) game_rank 
         FROM   game_players) 
SELECT Row_number() 
         over ( 
           ORDER BY win_ratio DESC), 
       player_id, 
       win_count, 
       loss_count, 
       win_ratio, 
       Rank() 
         over ( 
           ORDER BY win_ratio DESC) 
FROM   (SELECT players.id              player_id, 
               Coalesce(win_count, 0)  win_count, 
               Coalesce(loss_count, 0) loss_count, 
               Coalesce(( win_count / ( win_count + loss_count ) :: FLOAT ) :: 
                        FLOAT, 0 
                      ) 
                                       win_ratio 
        FROM   players 
               left join (SELECT player_id, 
                                 Count(*) win_count 
                          FROM   (SELECT game_id, 
                                         player_id, 
                                         game_rank 
                                  FROM   ranked_games) game_wins 
                          WHERE  game_rank = 1 
                          GROUP  BY player_id) win_table 
                      ON win_table.player_id = players.id 
               left join (SELECT player_id, 
                                 Count(*) loss_count 
                          FROM   (SELECT game_id, 
                                         player_id, 
                                         game_rank 
                                  FROM   ranked_games) game_wins 
                          WHERE  game_rank != 1 
                          GROUP  BY player_id) loss_table 
                      ON loss_table.player_id = players.id) win_ratios; 
                      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS player_rankings');
    }
}
