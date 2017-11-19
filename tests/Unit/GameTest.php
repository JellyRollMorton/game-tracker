<?php

namespace Tests\Unit;

use App\Player;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testGameCreate()
    {
        // prepare for authenticated tests
        $user = factory(User::class)->create();

        // at least two players should be required (this should fail)
        $response = $this->actingAs($user)->call('POST', '/api/games', ['players' => []]);
        $response->assertStatus(400);

        // players can't be the same (this should fail)
        $response = $this->actingAs($user)->json('POST', '/api/games', ['players' => [
            ['id' => 1, 'score' => 1],
            ['id' => 1, 'score' => 2]
        ]]);

        $response->assertStatus(422);

        // scores can't be the same (this should fail)
        $response = $this->actingAs($user)->json('POST', '/api/games', ['players' => [
            ['id' => 1, 'score' => 1],
            ['id' => 2, 'score' => 1]
        ]]);

        $response->assertStatus(422);

        // players should be valid (this should fail since no players exist)
        $response = $this->actingAs($user)->json('POST', '/api/games', ['players' => [
            ['id' => 1000, 'score' => 1],
            ['id' => 1001, 'score' => 2]
        ]]);

        $response->assertStatus(400);

        // set up real players
        $player1 = Player::create(['name' => 'Player1']);
        $player2 = Player::create(['name' => 'Player2']);

        // scores should be different (this should fail)
        $response = $this->actingAs($user)->json('POST', '/api/games', ['players' => [
            ['id' => $player1->id, 'score' => 1],
            ['id' => $player2->id, 'score' => 1]
        ]]);

        $response->assertStatus(422);

        // this should work
        $response = $this->actingAs($user)->json('POST', '/api/games', ['players' => [
            ['id' => $player1->id, 'score' => 1],
            ['id' => $player2->id, 'score' => 2]
        ]]);

        $response->assertStatus(200);
    }
}
