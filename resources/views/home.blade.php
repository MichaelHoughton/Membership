@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                    <h2>Membership Status</h2>

                    @if ($user->isMember())
                        You are currently subscribed to our membership.
                    @else
                        <p>
                            You are currently not subscribed to our membership. <a href="{{ url('subscribe') }}">Click here to sign up for our membership now</a>.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
