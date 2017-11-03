<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /** @test */
    public function a_non_logged_in_user_cannot_see_the_dashboard()
    {
        $this->withExceptionHandling()
            ->get('/home')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_non_subscribed_user_views_the_dashboard()
    {
        $this->actingAs($this->user)
            ->get('/home')
            ->assertStatus(200)
            ->assertSee('You are currently not subscribed to our membership.');
    }

    /** @test */
    public function a_subscribed_user_views_the_dashboard()
    {
        $subscribed = $this->subscribedUser();

        $this->actingAs($subscribed)
            ->get('/home')
            ->assertStatus(200)
            ->assertSee('You are currently subscribed to our membership.');
    }
}
