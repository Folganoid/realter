@extends('layouts.main')

@section('content')

    <h2>Edit my profile</h2>
    <br>
    {!! Form::open(['route' => 'profile.change', 'method' => 'post']) !!}

    {{ Form::label('Name') }}
    {{ Form::text('name', $user->name, ['placeholder' => 'Name', 'required' => true]) }}
    @if ($errors->has('name'))
        <span class="help-block color_red">
           <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
    <br>
    {{ Form::label('Surname') }}
    {{ Form::text('surname', $user->surname, ['placeholder' => 'Surname']) }}
    @if ($errors->has('surname'))
        <span class="help-block color_red">
           <strong>{{ $errors->first('surname') }}</strong>
        </span>
    @endif
    <br>
    {{ Form::label('Telephone') }}
    {{ Form::text('tel', $user->tel, ['placeholder' => 'Telephone']) }}
    @if ($errors->has('tel'))
        <span class="help-block color_red">
           <strong>{{ $errors->first('tel') }}</strong>
        </span>
    @endif
    <br>
    {{ Form::label('Email') }}
    {{ Form::email('email', $user->email, ['placeholder' => 'Email']) }}
    @if ($errors->has('email'))
        <span class="help-block color_red">
           <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
    <br>
    {{ Form::label('Old password') }}
    {{ Form::password('pass_old') }}
    <br>
    {{ Form::label('New password') }}
    {{ Form::password('pass') }}
    @if ($errors->has('pass'))
        <span class="help-block color_red">
           <strong>{{ $errors->first('pass') }}</strong>
        </span>
    @endif
    <br>
    {{ Form::label('Confirm new password') }}
    {{ Form::password('pass_confirmation') }}
    <br>
    {{ Form::submit('Change', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}



@endsection