@extends('layouts.admin')

@php
    $title = !empty($event) ? 'Update Event Details' : 'Create Event';
@endphp

@section('title', 'Admin - ' . $title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $title }}
                </div>

                <div class="panel-body">
                    @if (isset($event))
                        {{ Form::model($event, [
                            'url' => 'admin/events/'.$event->id,
                            'method' => 'patch'
                        ]) }}
                    @else
                        {!! Form::open(['route' => 'admin.events.store'])
                        !!}
                    @endif

                        {!! BootForm::text('title') !!}

                        {!! BootForm::textarea('brief') !!}

                        {!! BootForm::textarea('description') !!}

                        {!! BootForm::text('venue') !!}

                        {!! BootForm::textarea('location') !!}

                        {!! BootForm::text('date') !!}

                        {!! BootForm::text('start_time') !!}

                        {!! BootForm::text('end_time') !!}

                        @if (!empty($event))
                            {!! BootForm::submit('Save Changes') !!}
                        @else
                            {!! BootForm::submit('Add Event') !!}
                        @endif

                        @if (!empty($event))
                            {!! Form::hidden('id', $event->id) !!}
                        @endif

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('partials.datepicker')
@append