<?php

use App\Game;
use App\GamePlayer;
use App\Player;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 500 random players
        for ($i = 0; $i < 500; $i++) {
            factory(Player::class)->create();
        }

        // create 3k random games between these players
        for ($i = 0; $i < 3000; $i++) {
            // find any player at random
            $player1 = Player::inRandomOrder()->first();

            // find any other player
            $player2 = Player::inRandomOrder()->where('id', '!=', $player1->id)->first();

            // generate two different scores (there needs to be a winner and a loser since ties aren't allowed)
            $score1 = rand(0, 50);
            do {
                $score2 = rand(0, 50);
            } while ($score1 == $score2);

            // persist the game and game player records
            $game = Game::create();

            $gamePlayer = new GamePlayer;
            $gamePlayer->game_id = $game->id;
            $gamePlayer->player_id = $player1->id;
            $gamePlayer->score = $score1;
            $gamePlayer->save();

            $gamePlayer = new GamePlayer;
            $gamePlayer->game_id = $game->id;
            $gamePlayer->player_id = $player2->id;
            $gamePlayer->score = $score2;
            $gamePlayer->save();
        }
    }
}
