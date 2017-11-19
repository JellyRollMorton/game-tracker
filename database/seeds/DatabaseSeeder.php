<?php

use App\Player;
use App\Game;
use App\GamePlayer;
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
        for($i=0; $i < 500; $i++) {
			factory(Player::class)->create();
        }

        for($i=0; $i < 3000; $i++) {
        	$player1 = Player::inRandomOrder()->first();
        	$player2 = Player::inRandomOrder()->where('id', '!=', $player1->id)->first();

        	// generate two different scores
        	$score1 = rand(0,50);
        	do {
        		$score2 = rand(0,50);
        	} while ($score1 == $score2);

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
