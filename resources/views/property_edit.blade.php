@extends('layouts.main')

@section('content')
<h2>Edit property {{ $property['id'] }}</h2>

{!! Form::open(['route' => 'property.edit_save', 'method' => 'post', 'enctype' => "multipart/form-data"]) !!}

{{ Form::label('Name') }}
{{ Form::text('name', $property['name'], ['placeholder' => '50max', 'required' => 'required']) }}
<br>
{{ Form::label('Description') }}
{{ Form::textarea('description', $property['desc'], ['placeholder' => 'enter text', 'required' => 'required']) }}
<br>
{{ Form::label('Price') }}
{{ Form::text('price', $property['price'], ['placeholder' => '100000.00', 'size' => 8, 'required' => 'required', 'pattern' => '^[1-9]\d{0,7}(?:\.\d{0,2})?$', 'title' => '10 digits max . 2 digits max']) }}$
<br>
{{ Form::label('Operation') }}
{{ Form::select('operation', $operation, $property['operation']) }}
{{ Form::select('rent_measure', $rent, $property['operation_measure_id']) }}
<br>
{{ Form::label('Square') }}
{{ Form::text('square', $property['square'], ['placeholder' => '1000.00', 'size' => 6, 'required' => 'required', 'pattern' => '^[1-9]\d{0,7}(?:\.\d{0,2})?$']) }}
{{ Form::select('square_measure', $square, $property['square_measure_id']) }}

<br>
{{ Form::label('Address') }}
{{ Form::text('address', $property['address'], ['placeholder' => 'Enter address', 'required' => 'required']) }}

<br>
{{ Form::label('Property type') }}
{{ Form::select('house_type_id', $types, $property['house_type_id']) }}
<br>
{{ Form::label('openview_date', 'Open view') }}
{{ Form::date('openview_date', ($property['openview']) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property['openview']) : \Carbon\Carbon::now()) }}
{{ Form::time('openview_time', ($property['openview']) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property['openview'])->format('H:i') : \Carbon\Carbon::now()) }}

<div class="form-group{{ $errors->has('openview_min') ? ' color_red' : '' }}">
    {{ Form::label('open view minutes during') }}
    {{ Form::number('openview_min', $property['openview_min'], ['pattern' => '\d{0,3}', 'title' => '3 digits max']) }}

    @if ($errors->has('openview_min'))
    <span class="help-block"> - May not be greater than 3 digits</span>
    @endif
</div>

{{ Form::label('Add images') }}
{{ Form::file('image[]', ['multiple' => true]) }}

{{ Form::label('Add documents') }}
{{ Form::file('document[]', ['multiple' => true]) }}
{{ Form::hidden('id', $property['id']) }}

<br>
{{ Form::submit('Save') }}
{{ Form::token() }}

{!! Form::close() !!}
@endsection