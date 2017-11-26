@extends('layouts.main')

@section('content')
    <h2>Common list</h2>
    <br>
    @if(!empty($houses))
        @for( $i = 0 ; $i < count($houses); $i++)
            <div class="card">
                <h5 class="card-header">{{ $houses[$i]['name'] }} - <b>({{ $houses[$i]['operation'] }})</b></h5>
                <div class="card-body row">
                    <div class="col-8">
                        <sup>Created at : {{ $houses[$i]['created_at'] }} / Updated at
                            : {{ $houses[$i]['created_at'] }}</sup>
                        <h6 class="card-title">{{$houses[$i]['house_type']['name']}} - {{ $houses[$i]['desc'] }}</h6>
                        <p class="card-text">Address: {{$houses[0]['address']}}</p>
                        <ul>
                            <li>Square : {{ $houses[$i]['square'] }}</li>
                            <li>Price : <b>{{ $houses[$i]['price'] }}</b></li>
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
                            <li><b>Agent: <i>{{ $houses[$i]['user']['name'] . ' '. $houses[$i]['user']['surname'] . '; tel: ' . $houses[$i]['user']['tel'] }}</i></b></li>
                        </ul>
                        <a href="{{ route('property.view', ['id' => $houses[$i]['id']]) }}" class="btn btn-primary">More info ...</a>
                    </div>
                    <div class="col-4">
                        @if(count($houses[$i]['image']) > 0)
                            <img src="{{ asset( 'img/' . $houses[$i]['image'][0]['path']) }}" class="rounded img-fluid"
                                 alt="{{ $houses[$i]['image'][0]['name'] }}">
                        @else
                            <img src="{{ asset( 'img/none.jpeg') }}" class="rounded img-fluid" alt="No image">
                        @endif
                    </div>
                </div>
            </div>
            <br>
        @endfor
    @else
        <br><br>
        <h5>List is empty !</h5>
    @endif

@endsection