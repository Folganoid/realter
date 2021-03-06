@extends('layouts.main')

@section('content')

    <script src="{{ asset('js/rent.js') }}"></script>

    <h2>Add property</h2>

    {!! Form::open(['route' => 'property.save', 'method' => 'post', 'enctype' => "multipart/form-data"]) !!}

    {{ Form::label('Name') }}
    {{ Form::text('name', '', ['placeholder' => '50max', 'required' => 'required']) }}
    <br>
    {{ Form::label('Description') }}
    {{ Form::textarea('description', '', ['placeholder' => 'enter text', 'rows' => 3, 'required' => 'required']) }}
    <br>
    {{ Form::label('Price') }}
    {{ Form::text('price', '', ['placeholder' => '100000.00', 'size' => 8, 'required' => 'required', 'pattern' => '^[1-9]\d{0,7}(?:\.\d{0,2})?$', 'title' => '10 digits max . 2 digits max']) }}{{$money}}
    <br>
    {{ Form::label('Operation') }}
    {{ Form::select('operation', $operation, '', ['class' => 'list_operation']) }}
    {{ Form::select('rent_measure', $rent, '', ['class' => 'list_rent']) }}
    <br>
    {{ Form::label('Square') }}
    {{ Form::text('square', '', ['placeholder' => '1000.00', 'size' => 6, 'required' => 'required', 'pattern' => '^[1-9]\d{0,7}(?:\.\d{0,2})?$']) }}
    {{ Form::select('square_measure', $square) }}

    <br>
    {{ Form::label('Address') }}
    {{ Form::text('address', '', ['placeholder' => 'Enter address', 'required' => 'required']) }}

    <br>
    {{ Form::label('Property type') }}
    {{ Form::select('house_type_id', $types) }}
    <br>
    {{ Form::label('openview_date', 'Open view') }}
    {{ Form::date('openview_date', \Carbon\Carbon::now()) }}
    {{ Form::time('openview_time', \Carbon\Carbon::now()) }}

    <div class="form-group{{ $errors->has('openview_min') ? ' color_red' : '' }}">
        {{ Form::label('open view minutes during') }}
        {{ Form::number('openview_min', 30, ['pattern' => '\d{0,3}', 'title' => '3 digits max']) }}

        @if ($errors->has('openview_min'))
            <span class="help-block"> - May not be greater than 3 digits</span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('image') ? ' color_red' : '' }}">
    {{ Form::label('Image') }}
    {{ Form::file('image') }}

        @if ($errors->has('image'))
            <br>
            <b class="help-block">2MB maximum size !</b>
        @endif
    </div>

    <br>
    {{ Form::submit('Save') }}
    {{ Form::token() }}

    {!! Form::close() !!}
@endsection