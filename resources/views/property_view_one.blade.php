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
                    <li>Price : <b>{{ $property['price'] }}{{ $money }}</b>
                        @if($property['operation_measure_id'] &&($property['operation'] == 1))
                            <i>{{ $rent[$property['operation_measure_id']] }}</i>
                        @endif
                    </li>
                    @if($property['openview'])
                        @if($property['openview_min'])
                            <li>Open view : {{ date('F d, Y', strtotime($property['openview'])) }} -
                                <b>({{ date('H:i:s', strtotime($property['openview'])) }}
                                    - {{ date('H:i:s', strtotime( $property['openview'] . ' + '. $property['openview_min'] .' minutes')) }})</b></li>
                        @else
                            <li>Open view : {{ date('F d, Y', strtotime($property['openview'])) }} -
                                <b>({{ date('H:i:s', strtotime($property['openview'])) }})</b></li>
                        @endif
                    @endif
                </ul>

                    <p><b>Agent:</b> <a href="{{ route('agent', ['id' => $property['user_id']]) }}">{{ $property['user']['name'] . ' ' . $property['user']['surname'] }}</a></p>

            </div>
            <div class="col-6">
                @if($property['image'])
                @if(count($property['image']) == 1)
                    <div align="center">
                    <img class="rounded img-fluid mx-auto" src="{{ Config::get('settings.cloudinary')['path'] . $property['image'][0]['path'] }}"
                         alt="{{ $property['image'][0]['name'] }}">
                    </div>
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
                                <img class="mx-auto" src="{{ Config::get('settings.cloudinary')['path'] . $property['image'][0]['path'] }}"
                                     alt="{{ $property['image'][0]['name'] }}">
                                <div class="carousel-caption d-none d-md-block">
                                    <p class="text_conture">{{ $property['image'][0]['name'] }}</p>
                                    <a href="{{ Config::get('settings.cloudinary')['path'] . $property['image'][0]['path'] }}"><span class="glyphicon glyphicon-zoom-in text_conture"></span></a>
                                </div>
                            </div>
                            @for( $i = 1 ; $i < count($property['image']) ; $i++)
                                <div class="carousel-item">
                                    <img class="mx-auto" src="{{ Config::get('settings.cloudinary')['path'] . $property['image'][$i]['path'] }}"
                                         alt="{{ $property['image'][$i]['name'] }}">
                                    <div class="carousel-caption d-none d-md-block">
                                        <p class="text_conture">{{ $property['image'][$i]['name'] }}</p>
                                        <a href="{{ Config::get('settings.cloudinary')['path'] . $property['image'][$i]['path'] }}"><span class="glyphicon glyphicon-zoom-in text_conture"></span></a>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <h4 class="glyphicon glyphicon-chevron-left text_conture"></h4>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <h4 class="glyphicon glyphicon-chevron-right text_conture"></h4>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                @endif
                @else
                    <div align="center">
                        <img src="{{ asset( 'img/none.jpeg') }}" class="rounded img-fluid mx-auto" alt="No image">
                    </div>
                @endif

            @if($property['document'])
                @if(count($property['document']) > 0)
                    <br>
                    <h5>Documents:</h5>
                    <ul>
                        @for( $i = 0 ; $i < count($property['document']) ; $i++  )
                            <li><a href="{{  Config::get('settings.cloudinary')['path'] . $property['document'][$i]['path'] }}">{{ $property['document'][$i]['name'] }}</a></li>
                        @endfor
                    </ul>
                @endif
            @endif

            </div>
        </div>

        <h5>Watched ({{ (!empty($property['watch'])) ? count($property['watch']) : 0}}):</h5>
        @if(!empty($watch))
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
        @endif

    </div>


@endsection