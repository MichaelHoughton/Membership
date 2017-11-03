@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Manage Your Subscription
                </div>

                <div class="panel-body">
                    <p>
                        You have an active subscription.

                        @if ($subscription->ends_at)
                            Your subscription is due to end on the {{ $subscription->ends_at->format('jS F Y') }}.
                        @else
                            Your subscription is due to auto renew on the {{ $user->subscriptionExpiry()->format('jS F Y') }}.
                        @endif
                    </p>

                    @if (!$subscription->ends_at)
                        <p>
                            <a href="/cancel-subscription">Click here if you would like to prevent your subscription from automatically renewing</a>.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
