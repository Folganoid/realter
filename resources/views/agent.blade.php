@extends('layouts.main')

@section('content')
    <h2>Agent: <b>{{ $agent->name . ' ' . $agent->surname }}</b></h2>
    <br>
    <dd>Registered: {{ $agent['created_at'] }}</dd>
    <dd>Telephone: <b>{{ $agent['tel'] }}</b></dd>
    <dd>Email: <b>{{ $agent['email'] }}</b></dd>
    <br>

    @if(!empty($houses))
        @for( $i = 0 ; $i < count($houses); $i++)
            <div class="card">
                <h5 class="card-header">{{ $houses[$i]['name'] }} - <b>({{ $operation[$houses[$i]['operation']] }})</b></h5>
                <div class="card-body row">
                    <div class="col-8">
                        <sup>Created at : {{ $houses[$i]['created_at'] }} / Updated at
                            : {{ $houses[$i]['updated_at'] }}</sup>
                        <h6 class="card-title">{{ $types[$houses[$i]['house_type_id']] }} - {{ $houses[$i]['desc'] }}</h6>
                        <p class="card-text">Address: {{$houses[$i]['address']}}</p>
                        <ul>
                            <li>Square : {{ $houses[$i]['square'] }} {{ $square[$houses[$i]['square_measure_id']] }}</li>
                            <li>Price : <b>{{ $houses[$i]['price'] }}</b>
                                @if($houses[$i]['operation_measure_id'] && ($houses[$i]['operation'] == 1))
                                    <i>{{ $rent[$houses[$i]['operation_measure_id']] }}</i>
                                @endif
                            </li>
                            @if($houses[$i]['openview'])
                                @if($houses[$i]['openview_min'])
                                    <li>Open view : {{ date('F d, Y', strtotime($houses[$i]['openview'])) }} -
                                        <b>({{ date('H:i:s', strtotime($houses[$i]['openview'])) }}
                                            - {{ date('H:i:s', strtotime( $houses[$i]['openview'] . ' + '. $houses[$i]['openview_min'] .' minutes')) }}
                                            )</b></li>
                                @else
                                    <li>Open view : {{ date('F d, Y', strtotime($houses[$i]['openview'])) }} -
                                        <b>({{ date('H:i:s', strtotime($houses[$i]['openview'])) }})</b></li>
                                @endif
                            @endif
                            <li>Watched : {{ count($houses[$i]['watch']) }}</li>
                        </ul>
                        <a href="{{ route('property.view', ['id' => $houses[$i]['id']]) }}" class="btn btn-primary">More info ...</a>
                    </div>
                    <div class="col-4">
                        <div align="center">
                        @if(count($houses[$i]['image']) > 0)
                            <img src="{{ Config::get('settings.cloudinary')['path'] . $houses[$i]['image'][0]['path'] }}" class="rounded img-fluid"
                                 alt="{{ $houses[$i]['image'][0]['name'] }}">
                        @else
                            <img src="{{ asset( 'img/none.jpeg') }}" class="rounded img-fluid" alt="No image">
                        @endif
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endfor
    @else
        <br><br>
        <h5>Agent haven't properties !</h5>
    @endif
@endsection