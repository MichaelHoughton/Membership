@extends('layouts.app')

@section('title', 'Admin - Users')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body">
                    @if (count($users))
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Is Member</th>
                                    <th>Is Admin</th>
                                    <th>Date Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <a href="mailto:{{ $user->email }}">
                                        {{ $user->email }}
                                        </a>
                                    </td>
                                    <td>{{ $user->isMember() ? 'Yes' : 'No' }}</td>
                                    <td>{{ $user->admin ? 'Yes' : 'No' }}</td>
                                    <td>
                                        {{ $user->created_at ? $user->created_at->format('jS F Y') : '' }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div>
                            {!! $users->links() !!}
                        </div>
                    @else
                        <p>
                            There are no users at the moment!
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
