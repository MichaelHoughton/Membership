<?php

namespace Tests;

use App\User;
use App\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->user = factory(User::class)->create();

        $this->admin = factory(User::class)->create([
            'admin' => true
        ]);

        $this->paymentAttributes = [
            'card_number' => 4242424242424242,
            'exp_month' => '01',
            'exp_year' => date('Y') + 1,
            'cvc' => 123
        ];
    }

    protected function subscribedUser()
    {
        $subscription = Subscription::first();

        if ($subscription) {
            return $subscription->user;
        }

        $subscribed = factory(User::class)->create();
        $this->subscribe($subscribed);

        return $subscribed;
    }

    /**
     * Subscribes a user to the membership plan
     * @return App\User
     */
    protected function subscribe(User $user)
    {
        $user->newSubscription(config('app.membership_name'), config('app.membership_plan'))
            ->create('tok_ie');
    }
}
