@extends('layouts.main')

@section('content')

    <script src="{{ asset('js/property_edit.js') }}"></script>

    <h2>Edit property {{ $property['name'] }}</h2>

    <div class="row">
        <div class="col-6">
            {!! Form::open(['route' => 'property.edit_save', 'method' => 'post', 'enctype' => "multipart/form-data"]) !!}

            {{ Form::label('Name') }}
            {{ Form::text('name', $property['name'], ['placeholder' => '50max', 'required' => 'required']) }}
            <br>
            {{ Form::label('Description') }}
            {{ Form::textarea('description', $property['desc'], ['placeholder' => 'enter text', 'required' => 'required']) }}
            <br>
            {{ Form::label('Price') }}
            {{ Form::text('price', $property['price'], ['placeholder' => '100000.00', 'size' => 8, 'required' => 'required', 'pattern' => '^[1-9]\d{0,7}(?:\.\d{0,2})?$', 'title' => '10 digits max . 2 digits max']) }}
            $
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
            <br>
            {{ Form::label('Add documents') }}
            {{ Form::file('document[]', ['multiple' => true]) }}

            {{ Form::hidden('id', $property['id']) }}
            {{ Form::hidden('user_id', $property['user_id']) }}


            <br>
            {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
            {{ Form::token() }}

            {!! Form::close() !!}
        </div>
        <div class="col-6">
            <h3>Images</h3>
            <br>

            @if(!empty($property['image']))
            <table>
                @for ( $i = 0 ; $i < count($property['image']) ; $i++)
                    <tr>
                        <td>
                            <img src="{{ Config::get('settings.cloudinary')['path'] . $property['image'][$i]['path'] . Config::get('settings.cloudinary')['img_format'] }}"
                                 class="rounded img-fluid"
                                 alt="{{ $property['image'][$i]['name'] }}" width="100" />
                        </td>
                        <td>
                            <input id="{{ 'name' . $property['image'][$i]['id'] }}" value="{{ $property['image'][$i]['name'] }}" required/>
                            <button class="btn btn-primary image_edit" value="{{ $property['image'][$i]['id'] }}">Edit</button> <span class = "edit_msg" id="{{ 'edit_msg' . $property['image'][$i]['id'] }}"></span>
                            <br>
                            <button class="btn btn-danger image_delete" value="{{ $property['image'][$i]['id'] }}">Delete</button>  <span class = "delete_msg" id="{{ 'delete_msg' . $property['image'][$i]['id'] }}"></span>
                        </td>
                    </tr>
            @endfor
            </table>
            @else
                <h4>No images</h4>
            @endif

        </div>
    </div>

@endsection