<?php

namespace Tests\Unit;

use App\Player;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @expectedException \Illuminate\Database\QueryException
     *
     * @return void
     */
    public function testPlayerNoName()
    {
        // Test that a player can't be saved with no name.  This should
        // throw an exception.
        $player = new Player();
        $player->save();
    }

    public function testPlayerSearchApi()
    {
        // Test that the player search api finds names as expected

        // prepare for authenticated tests
        $user = factory(User::class)->create();

        // set up players
        $player1 = Player::create(['name' => 'Player1']);
        $player2 = Player::create(['name' => 'Player2']);

        // a 200 response should be received for a valid search
        $response = $this->actingAs($user)->json('GET', '/api/players/search',
            ['q' => ['term' => 'test']]
        );

        $response->assertStatus(200);

        // there should be no results for this query
        $responseArray = json_decode($response->getContent(), true);
        $responseCount = count($responseArray['results']);
        $this->assertTrue($responseCount === 0);

        // search for both players
        $response = $this->actingAs($user)->json('GET', '/api/players/search',
            ['q' => ['term' => 'player']]
        );

        // both players should be returned
        $response->assertJson(['results' => [
            ['id' => 1, 'text' => 'Player1'],
            ['id' => 2, 'text' => 'Player2']
        ]]);

        // search only for player 1
        $response = $this->actingAs($user)->json('GET', '/api/players/search',
            ['q' => ['term' => 'player1']]
        );

        // player 2 should not be present
        $response->assertJsonMissing(['results' => [
            ['id' => 2, 'text' => 'Player2']
        ]]);
    }
}
