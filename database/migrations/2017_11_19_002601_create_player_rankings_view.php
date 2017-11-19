<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The PlayerRanking model uses an underlying player_ranking view, which was created to improve query performance and
 * facilitate ease of access via Eloquent.  Since all computation is done in the database, computing player rankings
 * is much more efficient than if this code were to be done in code.  This view could potentially be swapped out with
 * a materialized view for improved performance if the database grows very large, but this likely isn't needed
 * even for very large data sets.
 */
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
-- This subquery identifies winners (game_rank = 1) and losers (game_rank > 1) for each player/game combo.  This
-- subquery is needed twice to identify both win and loss totals for a player, so it's identified as a CTE to avoid
-- code redundancy.
WITH ranked_games
AS (SELECT
  game_id,
  player_id,
  -- Use rank() identify the player's rank for every game.  The winner will have a rank of 1, and the loser will have
  -- rank greater than 1.
  RANK()
  OVER (
  PARTITION BY game_id
  ORDER BY score DESC) game_rank
FROM game_players)
-- begin the main query
SELECT
  player_id,
  win_count,
  loss_count,
  win_ratio,
  -- Use rank() to identify overall rankings based on total win ratios.  rank() ensures that if there are two players
  -- with the same win_ratio, that they have the same ranking.  For example, this makes it possible for two players to
  -- be ranked #1, but the third player is ranked #3 (skipping a #2 ranking since there are two better players)
  RANK()
  OVER (
  ORDER BY win_ratio DESC)
FROM (SELECT
  player_id,
  win_count,
  loss_count,
  -- Avoid division by zero errors by considering cases where somebody has zero wins.  In this case, their win ratio
  -- can be set to 0.
  CASE
    WHEN win_count = 0 THEN 0
    ELSE win_count / (win_count + loss_count) ::float
  END win_ratio
FROM (SELECT
  players.id player_id,
  -- If a player doesn't explicitly have any wins/loses recorded, default to 0
  COALESCE(win_count, 0) win_count,
  COALESCE(loss_count, 0) loss_count
FROM players
-- Include the count of won games from the ranked_games CTE.  A player may not have any recorded wins, so a
-- relationship between players and ranked_games (i.e., game_players) is not required
LEFT JOIN (SELECT
  player_id,
  COUNT(*) win_count
FROM (SELECT
  game_id,
  player_id,
  game_rank
FROM ranked_games) game_wins
WHERE game_rank = 1 -- factor in wins only
GROUP BY player_id) win_table
  ON win_table.player_id = players.id
-- Include the count of lost games from the ranked_games CTE.  A player may not have any recorded losses, so a
-- relationship between players and ranked_games (i.e., game_players) is not required
LEFT JOIN (SELECT
  player_id,
  COUNT(*) loss_count
FROM (SELECT
  game_id,
  player_id,
  game_rank
FROM ranked_games) game_wins
WHERE game_rank != 1 -- factor in losses only
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
