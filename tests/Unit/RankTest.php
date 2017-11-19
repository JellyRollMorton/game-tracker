<?php

namespace Tests\Unit;

use App\Game;
use App\GamePlayer;
use App\Player;
use App\PlayerRanking;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RankTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that player ranking are properly calculated and displayed
     *
     * @return void
     */
    public function testRankings()
    {
        $player1 = Player::create(['name' => 'Player1']);
        $player2 = Player::create(['name' => 'Player2']);
        $player3 = Player::create(['name' => 'Player3']);
        $player4 = Player::create(['name' => 'Player4']);

        $game = Game::create();
        GamePlayer::create(['player_id' => $player1->id, 'score' => 5, 'game_id' => $game->id]);
        GamePlayer::create(['player_id' => $player2->id, 'score' => 3, 'game_id' => $game->id]);

        // player one should be ranked first, with everyone else tied for second
        $this->assertEquals(1, PlayerRanking::where(['player_id' => $player1->id])->first()->rank);
        $this->assertEquals(2, PlayerRanking::where(['player_id' => $player2->id])->first()->rank);
        $this->assertEquals(2, PlayerRanking::where(['player_id' => $player3->id])->first()->rank);
        $this->assertEquals(2, PlayerRanking::where(['player_id' => $player4->id])->first()->rank);

        $game = Game::create();
        GamePlayer::create(['player_id' => $player2->id, 'score' => 5, 'game_id' => $game->id]);
        GamePlayer::create(['player_id' => $player3->id, 'score' => 3, 'game_id' => $game->id]);

        // player one still has 100% wins, player two has 50%, and three and four are at 0%
        $this->assertEquals(1, PlayerRanking::where(['player_id' => $player1->id])->first()->win_ratio);
        $this->assertEquals(.5, PlayerRanking::where(['player_id' => $player2->id])->first()->win_ratio);
        $this->assertEquals(0, PlayerRanking::where(['player_id' => $player3->id])->first()->win_ratio);
        $this->assertEquals(0, PlayerRanking::where(['player_id' => $player4->id])->first()->win_ratio);

        // the rankings should be 1, 2, 3 and 3
        $this->assertEquals(1, PlayerRanking::where(['player_id' => $player1->id])->first()->rank);
        $this->assertEquals(2, PlayerRanking::where(['player_id' => $player2->id])->first()->rank);
        $this->assertEquals(3, PlayerRanking::where(['player_id' => $player3->id])->first()->rank);
        $this->assertEquals(3, PlayerRanking::where(['player_id' => $player4->id])->first()->rank);

        $game = Game::create();
        GamePlayer::create(['player_id' => $player3->id, 'score' => 5, 'game_id' => $game->id]);
        GamePlayer::create(['player_id' => $player4->id, 'score' => 3, 'game_id' => $game->id]);

        // player one still has 100% wins, player two still has 50%, three now has 50% too, and four still 0%
        $this->assertEquals(1, PlayerRanking::where(['player_id' => $player1->id])->first()->win_ratio);
        $this->assertEquals(.5, PlayerRanking::where(['player_id' => $player2->id])->first()->win_ratio);
        $this->assertEquals(.5, PlayerRanking::where(['player_id' => $player3->id])->first()->win_ratio);
        $this->assertEquals(0, PlayerRanking::where(['player_id' => $player4->id])->first()->win_ratio);

        // the rankings should be 1, 2, 2, and 4.  Player 4 should still be ranked fourth even
        // though there is nobody assigned the rank of third, since the 2nd and 3rd spots are tied.
        $this->assertEquals(1, PlayerRanking::where(['player_id' => $player1->id])->first()->rank);
        $this->assertEquals(2, PlayerRanking::where(['player_id' => $player2->id])->first()->rank);
        $this->assertEquals(2, PlayerRanking::where(['player_id' => $player3->id])->first()->rank);
        $this->assertEquals(4, PlayerRanking::where(['player_id' => $player4->id])->first()->rank);

        // prepare for authenticated tests
        $user = factory(User::class)->create();

        // ensure that, after we authenticate, we can load the player rankings api
        $response = $this->actingAs($user)->get('/api/player_rankings');
        $response->assertStatus(200);

        // make sure that the rankings are what we expect (rank, name, wins, losses)
        $response->assertJson([
            'data' => [
                [1, 'Player1', 1, 0],
                [2, 'Player2', 1, 1],
                [2, 'Player3', 1, 1],
                [4, 'Player4', 0, 1]
            ]
        ]);
    }
}
