@extends('layouts.app')

@section('title', 'Admin - Payments')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Payments</div>

                <div class="panel-body">
                    @if (count($payments))
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Created</th>
                                    <th>User</th>
                                    <th>Event</th>
                                    <th>Stripe ID</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>
                                        {{ $payment->created_at ? $payment->created_at->format('jS F Y') : '' }}
                                    </td>
                                    <td>
                                        {{ $payment->user ? $payment->user->name : '' }}
                                    </td>
                                    <td>
                                        {{ $payment->event ? $payment->event->title : '' }}
                                    </td>
                                    <td>
                                        {{ $payment->stripe_id }}
                                    </td>
                                    <td>
                                        ${{ $payment->amount }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div>
                            {!! $payments->links() !!}
                        </div>
                    @else
                        <p>
                            There are no payments at the moment!
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
