@extends('layouts.app')

@section('title', 'Admin - Events')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Events</div>

                <div class="panel-body">
                    @if (count($events))
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Venue</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Public Price</th>
                                    <th>Member Price</th>
                                    <th class="text-center">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->venue }}</td>
                                    <td>{{ $event->date->format('jS F Y') }}</td>
                                    <td>{{ substr($event->start_time, 0, 5) }}</td>
                                    <td>{{ $event->end_time ? substr($event->end_time, 0, 5) : '' }}</td>
                                    <td>{{ $event->public_price }}</td>
                                    <td>{{ $event->member_price }}</td>
                                    <td class="text-center">
                                        <a href="/admin/events/{{ $event->id }}/edit">Edit</a> /
                                        <a href="/admin/bookings?event_id={{ $event->id }}">Bookings</a> /
                                        <a href="/admin/payments?event_id={{ $event->id }}">Payments</a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div>
                            {!! $events->links() !!}
                        </div>
                    @else
                        <p>
                            There are no events at the moment!
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
