<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Authentication tests
     *
     * @return void
     */
    public function testNoAuthentication()
    {
        // we should be redirected to perform authentication
        $response = $this->get('/');
        $response->assertStatus(302);

        // we should be redirected to the auth login page
        $this->assertEquals('http://localhost/login', $response->getTargetUrl());
    }

    public function testAuthentication()
    {
        // prepare for authenticated tests
        $user = factory(User::class)->create();

        // ensure that, after we authenticate, we can load the dashboard
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        // make sure that the authenticated user's name is displayed
        $response->assertSeeText($user->name);
    }
}
