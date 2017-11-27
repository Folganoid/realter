@extends('layouts.main')

@section('content')
    <h2>Enhanced view of prop #{{ $property['id'] }}</h2>
        <br>

    <div class="card">
        <h5 class="card-header">{{ $property['name'] }} - <b>({{ $property['operation'] }})</b></h5>
        <div class="card-body row">
            <div class="col-8">
                <sup>Created at : {{ $property['created_at'] }} / Updated at
                    : {{ $property['created_at'] }}</sup>
                <h6 class="card-title">{{$property['house_type']['name']}} - {{ $property['desc'] }}</h6>
                <p class="card-text">Address: {{$property['address']}}</p>
                <ul>
                    <li>Square : {{ $property['square'] }}</li>
                    <li>Price : <b>{{ $property['price'] }}</b></li>
                    @if($property['openview'])
                        @if($property['openview_min'])
                            <li>Open view : {{ date('F d, Y', strtotime($property['openview'])) }} -
                                <b>({{ date('H:i:s', strtotime($property['openview'])) }}
                                    - {{ date('H:i:s', strtotime( $property['openview'] . ' + '. $property['openview_min'] .' minutes')) }}
                                    )</b></li>
                        @else
                            <li>Open view : {{ date('F d, Y', strtotime($property['openview'])) }} -
                                <b>({{ date('H:i:s', strtotime($property['openview'])) }})</b></li>
                        @endif
                    @endif
                    <li>Watched : {{ count($property['watch']) }}</li>
                    @if(count($watch) > 0)
                    <table>
                        <tr>
                            <td>Date</td>
                            <td>Name</td>
                            <td>Surname</td>
                            <td>Telephone</td>
                            <td>Email</td>
                        </tr>
                        @for($i = 0 ; $i < count($watch) ; $i++ )
                            <tr>
                                <td>{{ $watch[$i]['user']['created_at'] }}</td>
                                <td>{{ $watch[$i]['user']['name'] }}</td>
                                <td>{{ $watch[$i]['user']['surname'] }}</td>
                                <td>{{ $watch[$i]['user']['tel'] }}</td>
                                <td>{{ $watch[$i]['user']['email'] }}</td>
                            </tr>
                        @endfor
                    </table>
                    @endif
                </ul>
            </div>
            <div class="col-4">
                @if(count($property['image']) > 0)
                    <img src="{{ asset( 'img/' . $property['image'][0]['path']) }}" class="rounded img-fluid"
                         alt="{{ $property['image'][0]['name'] }}">
                @else
                    <img src="{{ asset( 'img/none.jpeg') }}" class="rounded img-fluid" alt="No image">
                @endif
            </div>
        </div>
    </div>


@endsection