@extends('layouts.app')

@section('title', 'Admin - Bookings')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Bookings</div>

                <div class="panel-body">
                    @if (count($bookings))
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Created</th>
                                    <th>User</th>
                                    <th>Event</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>
                                        {{ $booking->created_at ? $booking->created_at->format('jS F Y') : '' }}
                                    </td>
                                    <td>
                                        {{ !empty($booking->payment->user) ? $booking->payment->user->name : '' }}
                                    </td>
                                    <td>
                                        {{ $booking->event ? $booking->event->title : '' }}
                                    </td>
                                    <td>
                                        {{ $booking->name }}
                                    </td>
                                    <td>
                                        @if ($booking->email)
                                            <a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div>
                            {!! $bookings->links() !!}
                        </div>
                    @else
                        <p>
                            There are no bookings at the moment!
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
