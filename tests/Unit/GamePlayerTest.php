<?php

namespace Tests\Unit;

use App\GamePlayer;
use App\Game;
use App\Player;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GamePlayerTest extends TestCase
{
	use DatabaseMigrations;

    /**
     * @expectedException \Illuminate\Database\QueryException
     *
     * @return void
     */
    public function testGamePlayerNoGame()
    {
    	// If there is no game defined, an exception should be thrown
    	$gamePlayer = new GamePlayer();
    	$gamePlayer->score = 5;
    	$gamePlayer->player_id = factory(Player::class)->create()->id;
    	$gamePlayer->save();
    }

    /**
     * @expectedException \Illuminate\Database\QueryException
     *
     * @return void
     */
    public function testGamePlayerNoScore()
    {
    	// If there is no score defined, an exception should be thrown
    	$gamePlayer = new GamePlayer();
    	$gamePlayer->game_id = \App\Game::create()->id;
    	$gamePlayer->player_id = factory(Player::class)->create()->id;
    	$gamePlayer->save();
    }    

    /**
     * @expectedException \Illuminate\Database\QueryException
     *
     * @return void
     */
    public function testGamePlayerNoPlayer()
    {
    	// If there is no player is defined, an exception should be thrown
    	$gamePlayer = new GamePlayer();
    	$gamePlayer->score = 5;
    	$gamePlayer->game_id = \App\Game::create()->id;
    	$gamePlayer->save();
    }    

    /**
     *
     * @return void
     */
    public function testGamePlayer()
    {
    	// If all required fields are present, the record should get created
    	$gamePlayer = new GamePlayer();
    	$gamePlayer->score = 5;
    	$gamePlayer->game_id = \App\Game::create()->id;
    	$gamePlayer->player_id = factory(Player::class)->create()->id;
    	$this->assertTrue($gamePlayer->save());
    }       
}
