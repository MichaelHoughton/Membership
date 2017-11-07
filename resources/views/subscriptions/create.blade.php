@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Subscribe Now!
                </div>

                <div class="panel-body">
                    <p>
                        Fill in your payment details below to sign up for our Annual Membership for ${{ config('app.membership_fee') }}.
                    </p>

                    <h3>Payment Details</h3>

                    {!! Form::open(['url' => '/subscribe']) !!}
                        @include('partials.payment_form')

                        {!! BootForm::submit('Subscribe Now') !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
