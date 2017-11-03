<?php

namespace App;

use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Subscription;
use Coderity\Wallet\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Billable, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Checks if the user has an active membership subscription
     * @return boolean
     */
    public function isMember()
    {
        return $this->subscribed(config('app.membership_name'), config('app.membership_plan'));
    }

    public function subscriptionExpiry()
    {
        $subscriptionId = $this->subscription(config('app.membership_name'))->stripe_id;
        $apiKey = config('services.stripe.secret');
        Stripe::setApiKey($apiKey);

        $subscription = Subscription::retrieve($subscriptionId);

        return Carbon::createFromTimestamp($subscription->current_period_end);
    }
}
