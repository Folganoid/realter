@extends('layouts.main')

@section('content')

    <h2>Edit user #{{ $user->id }}</h2>
    <br>
    {!! Form::open(['route' => 'admin.user_edit_save', 'method' => 'post']) !!}

    {{ Form::label('Name') }}
    {{ Form::text('name', $user->name, ['placeholder' => 'Name', 'required' => 'required']) }}
    @if ($errors->has('name'))
        <span class="help-block color_red">
           <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
    <br>
    {{ Form::label('Surname') }}
    {{ Form::text('surname', $user->surname, ['placeholder' => 'Surname', 'required' => 'required' ]) }}
    @if ($errors->has('surname'))
        <span class="help-block color_red">
           <strong>{{ $errors->first('surname') }}</strong>
        </span>
    @endif
    <br>
    {{ Form::label('Telephone') }}
    {{ Form::text('tel', $user->tel, ['placeholder' => 'Telephone', 'required' => 'required']) }}
    @if ($errors->has('tel'))
        <span class="help-block color_red">
           <strong>{{ $errors->first('tel') }}</strong>
        </span>
    @endif
    <br>
    {{ Form::label('Email') }}
    {{ Form::email('email', $user->email, ['placeholder' => 'Email', 'required' => 'required']) }}
    @if ($errors->has('email'))
        <span class="help-block color_red">
           <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
    <br>
    {{ Form::label('New password') }}
    {{ Form::text('password') }}
    <br>
    {{ Form::label('Verify') }}
    {{ Form::select('verify', ['0' => 'false', '1' => 'true'], $user->verify ) }}
    <br>
    {{ Form::label('Role') }}
    {{ Form::select('role', $roles, $user->role ) }}
    <br>
    {{ Form::label('Status') }}
    {{ Form::number('status', $user->status, ['required' => 'required']) }}

    <br>
    {{ Form::hidden('id', $user->id) }}
    {{ Form::submit('Change', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}

@endsection