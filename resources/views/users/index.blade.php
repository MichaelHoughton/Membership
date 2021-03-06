@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <p>Welcome to {{ config('app.name') }}!</p>

                    @include('users.partials.membership_status')

                    @include('events.partials.list')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
