@extends('layouts.main')

@section('content')

    <script src="{{ asset('js/rent.js') }}"></script>

    <h2>Common list</h2>
    <br>

    <div class="container search_form">
        <h5>Search</h5>
        <div>
            {!! Form::open(['route' => 'list', 'method' => 'get']) !!}

            {{ Form::text('string', '', ['placeholder' => 'Enter address, name etc']) }}

            {{ Form::select('type', $types) }}

            {{ Form::label('Price min') }}
            {{ Form::number('price_min') }}

            {{ Form::label('Price max') }}
            {{ Form::number('price_max') }}

            {{ Form::select('operation', $operation, '', ['class' => 'list_operation']) }}
            {{ Form::select('rent', $rent, '', ['class' => 'list_rent', 'disabled' => true]) }}

            {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
            <br>
            {{ Form::label('Sort by ') }}
            {{ Form::select('sort', [
            'price@DESC' => 'PRICE +',
            'price@ASC' => 'PRICE -',
            'created_at@DESC' => 'Date +',
            'created_at@ASC' => 'Date -',
             ], 'created_at@DESC') }}
            {!! Form::close() !!}
        </div>
    </div>

    <br>
    @if(!empty($houses))
        <div class="d-flex justify-content-center">{!! $houses->links('vendor.pagination.bootstrap-4') !!}</div>
        @foreach ($houses as $house)
            <div class="card">
                <h5 class="card-header">{{ $house['name'] }} - <b>({{ $operation[$house['operation']] }})</b></h5>
                <div class="card-body row">
                    <div class="col-8">
                        <sup>Created at : {{ $house['created_at'] }} / Updated at
                            : {{ $house['updated_at'] }}</sup>
                        <h6 class="card-title">{{ $types[$house['house_type_id']] }} - {{ $house['desc'] }}</h6>
                        <p class="card-text">Address: {{$house['address']}}</p>
                        <ul>
                            <li>Square : {{ $house['square'] }} {{ $square[$house['square_measure_id']] }}</li>
                            <li>Price : <b>{{ $house['price'] }}{{ $money }}</b>
                                @if($house['operation_measure_id'] && ($house['operation'] == 1))
                                <i>{{ $rent[$house['operation_measure_id']] }}</i>
                            @endif
                            </li>
                            @if($house['openview'])
                                @if($house['openview_min'])
                                    <li>Open view : {{ date('F d, Y', strtotime($house['openview'])) }} -
                                        <b>({{ date('H:i:s', strtotime($house['openview'])) }}
                                            - {{ date('H:i:s', strtotime( $house['openview'] . ' + '. $house['openview_min'] .' minutes')) }})</b></li>
                                @else
                                    <li>Open view : {{ date('F d, Y', strtotime($house['openview'])) }} -
                                        <b>({{ date('H:i:s', strtotime($house['openview'])) }})</b></li>
                                @endif
                            @endif
                            <li>Watched : {{ count($house['watch']) }}</li>
                            <li><b>Agent: <i>{{ $house['user']['name'] . ' '. $house['user']['surname'] . '; tel: ' . $house['user']['tel'] }}</i></b></li>
                        </ul>
                        <a href="{{ route('property.view', ['id' => $house['id']]) }}" class="btn btn-primary">More info ...</a>
                    </div>
                    <div class="col-4">
                        <div align="center">
                        @if(count($house['image']) > 0)
                            <img src="{{ Config::get('settings.cloudinary')['path'] . $house['image'][0]['path'] }}" class="rounded img-fluid"
                                 alt="{{ $house['image'][0]['name'] }}">
                        @else
                            <img src="{{ asset( 'img/none.jpeg') }}" class="rounded img-fluid align-content-center" alt="No image">
                        @endif
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endforeach
        <div class="d-flex justify-content-center">{!! $houses->links('vendor.pagination.bootstrap-4') !!}</div>

    @else
        <br><br>
        <h5>List is empty !</h5>
    @endif

@endsection