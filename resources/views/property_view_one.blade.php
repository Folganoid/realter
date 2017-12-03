@extends('layouts.main')

@section('content')



    <br>
    <div class="card">
        <h5 class="card-header">{{ $property['name'] }} - <b>({{ $operation[$property['operation']] }})</b></h5>
        <div class="card-body row">
            <div class="col-6">

                @if(Gate::allows('is-admin') || $property['user_id'] == Auth::id())
                    <a href="{{ route('property.edit', ['id' => $property['id']]) }}" class="btn btn-danger">Edit</a><br>
                @endif

                <sup>Created at : {{ $property['created_at'] }} / Updated at: {{ $property['created_at'] }}</sup>
                <h6 class="card-title">{{ $types[$property['house_type_id']] }} - {{ $property['desc'] }}</h6>
                <p class="card-text">Address: {{$property['address']}}</p>
                <ul>
                    <li>Square : {{ $property['square'] }} {{ $square[$property['square_measure_id']] }}</li>
                    <li>Price : <b>{{ $property['price'] }}$</b>
                        @if($property['operation_measure_id'] &&($property['operation'] == 1))
                            <i>{{ $rent[$property['operation_measure_id']] }}</i>
                        @endif
                    </li>
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
                </ul>

                    <p><b>Agent:</b> <a href="{{ route('agent', ['id' => $property['user_id']]) }}">{{ $property['user']['name'] . ' ' . $property['user']['surname'] }}</a></p>

                <h5>Watched ({{ count($property['watch']) }}):</h5>
                @if(count($watch) > 0)
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Name</th>
                            <th scope="col">Telephone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0 ; $i < count($watch) ; $i++ )
                            <tr>
                                <td>{{ $watch[$i]['created_at'] }}</td>
                                <td>
                                    <a href="{{ route(($watch[$i]['user']['role'] > 1) ? 'agent' : 'client', ['id' => $watch[$i]['user']['id']]) }}">{{ $watch[$i]['user']['name'] }} {{ $watch[$i]['user']['surname'] }}</a>
                                </td>
                                <td>{{ $watch[$i]['user']['tel'] }}</td>
                                <td>{{ $watch[$i]['user']['email'] }}</td>
                                <td>{{ ($watch[$i]['user']['role'] == 10) ? 'Admin' : (($watch[$i]['user']['role'] > 1) ? 'Agent' : 'Client') }}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                @endif

            </div>
            <div class="col-6">

                @if(count($property['image']) == 1)
                    <img class="rounded img-fluid" src="{{ Config::get('settings.cloudinary')['path'] . $property['image'][0]['path'] }}"
                         alt="{{ $property['image'][0]['name'] }}">

                @elseif(count($property['image']) > 1)
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            @for( $i = 1 ; $i < count($property['image']) ; $i++)
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}"></li>
                            @endfor
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ Config::get('settings.cloudinary')['path'] . $property['image'][0]['path'] }}"
                                     alt="{{ $property['image'][0]['name'] }}">
                                <div class="carousel-caption d-none d-md-block">
                                    <p class="text_conture">{{ $property['image'][0]['name'] }}</p>
                                    <a href="{{ Config::get('settings.cloudinary')['path'] . $property['image'][0]['path'] }}"><span class="glyphicon glyphicon-zoom-in text_conture"></span></a>
                                </div>
                            </div>
                            @for( $i = 1 ; $i < count($property['image']) ; $i++)
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ Config::get('settings.cloudinary')['path'] . $property['image'][$i]['path'] }}"
                                         alt="{{ $property['image'][$i]['name'] }}">
                                    <div class="carousel-caption d-none d-md-block">
                                        <p class="text_conture">{{ $property['image'][$i]['name'] }}</p>
                                        <a href="{{ Config::get('settings.cloudinary')['path'] . $property['image'][$i]['path'] }}"><span class="glyphicon glyphicon-zoom-in text_conture"></span></a>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                @else
                    <img src="{{ asset( 'img/none.jpeg') }}" class="rounded img-fluid" alt="No image">
                @endif

                @if(count($property['document']) > 0)
                    <br>
                    <h5>Documents:</h5>
                    <ul>
                        @for( $i = 0 ; $i < count($property['document']) ; $i++  )
                            <li><a href="{{  Config::get('settings.cloudinary')['path'] . $property['document'][$i]['path'] }}">{{ $property['document'][$i]['name'] }}</a></li>
                        @endfor
                    </ul>
                @endif

            </div>
        </div>
    </div>


@endsection