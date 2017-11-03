<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class SubscriptionsTest extends TestCase
{
    /** @test */
    public function a_non_subscribed_user_views_the_subscription_page()
    {
        $this->actingAs($this->user)
            ->get('/subscribe')
            ->assertStatus(200)
            ->assertSee('Subscribe Now!');
    }

    /** @test */
    public function a_subscribed_user_views_the_subscription_page()
    {
        $subscribed = $this->subscribedUser();

        $this->actingAs($subscribed)
            ->get('/subscribe')
            ->assertStatus(200)
            ->assertSee('You have an active subscription.');
    }

    /** @test */
    public function a_non_subscribed_user_tries_to_subscribe_with_invalid_card()
    {
        $attributes = [
            'card_number' => 1234567812345678,
            'exp_month' => null,
            'exp_year' => null,
            'cvc' => 'This is not valid'
        ];

        $this->withExceptionHandling()
            ->actingAs($this->user)
            ->post('/subscribe', $attributes)
            ->assertStatus(302)
            ->assertSessionHasErrors('card_number')
            ->assertSessionHasErrors('exp_month')
            ->assertSessionHasErrors('exp_year')
            ->assertSessionHasErrors('cvc');
    }

    /** @test */
    public function a_non_subscribed_user_tries_to_subscribe_with_expired_card()
    {
        $attributes = $this->paymentAttributes;
        $attributes['exp_year'] = '2016';

        $this->actingAs($this->user)
            ->post('/subscribe', $attributes)
            ->assertStatus(302)
            ->assertSessionHas('error')
            ->assertRedirect('/subscribe');
    }

    /** @test */
    public function a_non_subscribed_user_subscribes()
    {
        $this->actingAs($this->user)
            ->post('/subscribe', $this->paymentAttributes)
            ->assertStatus(302)
            ->assertSessionHas('success')
            ->assertRedirect('/subscribe');
    }

    /** @test */
    public function a_non_subscribed_user_tries_to_cancels_their_subscription()
    {
        $this->withExceptionHandling()
            ->actingAs($this->user)
            ->get('/cancel-subscription')
            ->assertStatus(403);
    }

    /** @test */
    public function a_subscribed_user_cancels_their_subscription()
    {
        $subscribed = $this->subscribedUser();

        $this->actingAs($subscribed)
            ->get('/cancel-subscription')
            ->assertStatus(302)
            ->assertSessionHas('success')
            ->assertRedirect('/subscribe');

        $subscription = $subscribed->subscription(config('app.membership_name'));
        $this->assertNotNull($subscription->ends_at);
    }
}
