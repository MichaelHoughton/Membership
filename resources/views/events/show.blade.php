@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $event->title }}</div>

                <div class="panel-body">
                    <p>
                        <strong>Date:</strong> {{ $event->date->format('jS F Y') }}
                    </p>

                    <p>
                        <strong>Start Time:</strong> {{ substr($event->start_time, 0, 5) }}
                    </p>

                    @if ($event->end_time)
                        <p>
                            <strong>End Time:</strong> {{ substr($event->end_time, 0, 5) }}
                        </p>
                    @endif

                    <p>
                        <strong>Description:</strong><br>
                        {!! nl2br($event->description) !!}
                    </p>

                    <p>
                        <strong>Venue:</strong> {{ $event->venue }}
                    </p>

                    @if ($event->location)
                        <p>
                            <strong>Location:</strong><br>
                            {!! nl2br($event->location) !!}
                        </p>
                    @endif

                    @if ($event->member_price)
                        <p>
                            <strong>Non Members Price:</strong> ${{ $event->public_price }}
                        </p>

                        <p>
                            <strong>Members Price:</strong> ${{ $event->member_price }}
                        </p>
                    @else
                        <p>
                            <strong>Price:</strong> ${{ $event->public_price }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Book a Place</div>

                <div class="panel-body">
                    @auth
                        {!! Form::open(['url' => '/event/' . $event->id]) !!}
                            @include('partials.payment_form')

                            {!! BootForm::submit('Book a Place') !!}
                        {!! Form::close() !!}
                    @else
                        <p>
                            You need to <a href="/login">login</a> or
                            <a href="/register">register</a> to book a place in this event.
                        </p>

                        <p>
                            Registration is free and only takes a minute!
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
