<h2>Up And Coming Events</h2>

@forelse ($events as $event)
    <h3>
        <a href="/event/{{ $event->slug }}">
            {{ $event->title }}
        </a>
    </h3>

    <p>
        {!! nl2br($event->brief) !!}
    </p>
@empty
    <p>There are no up and coming events at the moment!</p>
@endforelse