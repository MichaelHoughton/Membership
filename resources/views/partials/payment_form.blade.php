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