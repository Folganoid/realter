@extends('layouts.main')

@section('content')
    <h2>Admin</h2>
    <br>
    <h5>Add property type</h5>
    {!! Form::open(['route' => 'admin.save_type', 'method' => 'post']) !!}

    {{ Form::label('name', 'Name') }}
    {{ Form::text('name', '', ['placeholder' => '30max', 'required' => 'required']) }}
    <br>
    {{ Form::label('json', 'JSON') }}
    {{ Form::text('json') }}
    <br>
    {{ Form::submit('Add') }}
    {{ Form::token() }}
    {!! Form::close() !!}
@endsection