<h2>Membership Status</h2>

@if ($user->isMember())
    You are currently subscribed to our membership.
    <a href="{{ url('subscribe') }}">
        Click here to manage your subscription.
    </a>
@else
    <p>
        You are currently not subscribed to our membership. <a href="{{ url('subscribe') }}">Click here to sign up for our membership now</a>.
    </p>
@endif