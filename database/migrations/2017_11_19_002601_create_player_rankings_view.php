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
        $viewSql = <<<EOT
CREATE VIEW player_rankings
AS
WITH ranked_games
AS (SELECT
  game_id,
  player_id,
  RANK()
  OVER (
  PARTITION BY game_id
  ORDER BY score DESC) game_rank
FROM game_players)
SELECT
  player_id,
  win_count,
  loss_count,
  win_ratio,
  RANK()
  OVER (
  ORDER BY win_ratio DESC)
FROM (SELECT
  player_id,
  win_count,
  loss_count,
  CASE
    WHEN win_count = 0 THEN 0
    ELSE win_count / (win_count + loss_count) ::float
  END win_ratio
FROM (SELECT
  players.id player_id,
  COALESCE(win_count, 0) win_count,
  COALESCE(loss_count, 0) loss_count
FROM players
LEFT JOIN (SELECT
  player_id,
  COUNT(*) win_count
FROM (SELECT
  game_id,
  player_id,
  game_rank
FROM ranked_games) game_wins
WHERE game_rank = 1
GROUP BY player_id) win_table
  ON win_table.player_id = players.id
LEFT JOIN (SELECT
  player_id,
  COUNT(*) loss_count
FROM (SELECT
  game_id,
  player_id,
  game_rank
FROM ranked_games) game_wins
WHERE game_rank != 1
GROUP BY player_id) loss_table
  ON loss_table.player_id = players.id) win_totals) win_ratios
EOT;        
  
        DB::statement($viewSql);
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
