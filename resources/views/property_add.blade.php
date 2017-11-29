@extends('layouts.main')

@section('content')
    <h2>Add property</h2>
    {!! Form::open(['route' => 'property.save', 'method' => 'post']) !!}

    {{ Form::label('Name') }}
    {{ Form::text('name', '', ['placeholder' => '50max', 'required' => 'required']) }}
    <br>
    {{ Form::label('Description') }}
    {{ Form::textarea('description', '', ['placeholder' => 'enter text', 'required' => 'required']) }}
    <br>
    {{ Form::label('Price') }}
    {{ Form::number('price', '', ['placeholder' => '1000000000.00', 'required' => 'required']) }}$
    {{ Form::select('rent_measure', $rent) }}

    <br>
    {{ Form::label('Square') }}
    {{ Form::number('square', '', ['placeholder' => '1000000000.00', 'required' => 'required']) }}
    {{ Form::select('square_measure', $square) }}

    <br>
    {{ Form::label('Address') }}
    {{ Form::text('address', '', ['placeholder' => 'Enter address', 'required' => 'required']) }}
    <br>
    {{ Form::label('Operation') }}
    {{ Form::select('operation', $operation) }}
    <br>
    {{ Form::label('Property type') }}
    {{ Form::select('house_type_id', $types) }}
    <br>
    {{ Form::label('openview_date', 'Open view') }}
    {{ Form::date('openview_date', \Carbon\Carbon::now()) }}
    {{ Form::time('openview_time', \Carbon\Carbon::now()) }}
    <br>
    {{ Form::label('open view minutes during') }}
    {{ Form::number('openview_min', 30) }}
    <br>
    {{ Form::label('Image') }}
    {{ Form::text('image', '', ['placeholder' => 'Do not work yet']) }}
    <br>
    {{ Form::label('Documents') }}
    {{ Form::text('doc', '', ['placeholder' => 'Do not work yet']) }}

    <br>
    {{ Form::submit('Update') }}
    {{ Form::token() }}

    {!! Form::close() !!}
@endsection