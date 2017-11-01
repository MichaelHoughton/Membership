<?php

namespace Tests;

use App\User;
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

        $this->subscribed = factory(User::class)->create();

        $this->subscribe($this->subscribed);

        $this->paymentAttributes = [
            'card_number' => 4242424242424242,
            'exp_month' => '01',
            'exp_year' => date('Y') + 1,
            'cvc' => 123
        ];
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
