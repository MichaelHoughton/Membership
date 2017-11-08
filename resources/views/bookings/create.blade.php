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
                        To book a place for this event, please enter in your credit card details below.
                    </p>

                    {!! Form::open(['url' => '/booking']) !!}

                    {{ Form::hidden('event_id', $event->id) }}

                    @php
                        $i = 1;
                    @endphp

                    @while ($i <= $guests)
                        {!! BootForm::text('guest[' . $i .'][name]', 'Guest Name ' . $i) !!}

                        {!! BootForm::text('guest[' . $i .'][email]', 'Guest Email Address ' . $i) !!}

                        <hr>
                        @php
                            $i++;
                        @endphp
                    @endwhile
                        <h3>Payment Details</h3>

                        @include('partials.payment_form')

                        {!! BootForm::submit('Confirm Booking') !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
