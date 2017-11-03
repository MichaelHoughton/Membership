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
                        {!! BootForm::text('card_number', 'Card Number', null, ['placeholder' => '1234 1234 1234 1234']) !!}

                        <div class="row">
                            <div class="col-lg-6">
                                @php
                                    $months = [
                                        '01' => '01',
                                        '02' => '02',
                                        '03' => '03',
                                        '04' => '04',
                                        '05' => '05',
                                        '06' => '06',
                                        '07' => '07',
                                        '08' => '08',
                                        '09' => '09',
                                        '10' => '10',
                                        '11' => '11',
                                        '12' => '12'
                                    ];
                                @endphp

                                {!! BootForm::select('exp_month', 'Expiry Month', $months, null, ['placeholder' => 'Select']) !!}
                            </div>
                            <div class="col-lg-6">
                                @php
                                    $ranges = range(0, 10);

                                    $years = [];
                                    foreach ($ranges as $range) {
                                        $year = date('Y') + $range;
                                        $years[$year] = $year;
                                    }
                                @endphp

                                {!! BootForm::select('exp_year', 'Expiry Year', $years, null, ['placeholder' => 'Select']) !!}
                            </div>
                        </div>

                        {!! BootForm::text('cvc', 'CVC number', null, ['placeholder' => '3 digits on back of card']) !!}

                        {!! BootForm::submit('Subscribe Now') !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
