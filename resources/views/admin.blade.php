@extends('layouts.main')

@section('content')
    <h2>Admin</h2>
    <br>
    <h3>User's control</h3>
    <br>
    @for ( $i = 0 ; $i < count($users) ; $i++)

        <dd><a href="{{ route(($users[$i]->role == 1) ? 'client' : 'agent' , ['id' => $users[$i]->id]) }}">{{ $users[$i]->name . ' ' . $users[$i]->surname }}</a> / {{ $users[$i]->email }}
        <a href="{{ route('admin.user_edit', ['id' => $users[$i]->id]) }}" class="btn-primary btn-sm">Edit user</a>
        </dd>

    @endfor
@endsection