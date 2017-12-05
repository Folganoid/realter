@extends('layouts.main')

@section('content')
    <h2>Client: {{ $client['name'] }} {{ $client['surname'] }}</h2>
    <br>
    <dd>Registered: {{ $client['created_at'] }}</dd>
    <dd>Telephone: {{ $client['tel'] }}</dd>
    <dd>Email: <b>{{ $client['email'] }}</b></dd>
    <br>
    <div class="row">
        <div class="col-6">
            <h3>Watched:</h3>
            <ul class="list-group">
            @for($i = 0 ; $i < count($watch); $i++ )
                <li class="list-group-item">
                    {{ $watch[$i]['house']['name'] }}
                    ({{ $types[$watch[$i]['house']['house_type_id']] }}) /
                    {{ $operation[$watch[$i]['house']['operation']] }}
                    <b>{{ $watch[$i]['house']['price'] }}</b>
                    @if(isset($watch[$i]['house']['operation_measure_id']))
                        ({{ $rent[$watch[$i]['house']['operation_measure_id']] }})
                    @endif
                    <div class="float-right"><a href="{{ route('property.view', ['id' => $watch[$i]['house']['id']]) }}" class="btn btn-primary">View</a></div>

                </li>
            @endfor
            </ul>
        </div>
        <div class="col-6">
            <h3>Search:</h3>
                <ul class="list-group">
                    @for($i = 0 ; $i < count($search); $i++ )
                    <li class="list-group-item">
                        <dd><b>{{ $search[$i]['created_at'] }}</b>

                        @if(isset($search[$i]['json']->operation))
                            <i> / Operation:</i> <b>{{ $operation[$search[$i]['json']->operation] }}</b>
                        @endif

                        @if(isset($search[$i]['json']->type))
                            <i> / Property type:</i> <b>{{ $types[$search[$i]['json']->type] }}</b>
                            @endif

                        </dd>
                        @if(isset($search[$i]['json']->string))
                            <dd><i>Search string:</i> <b>{{ $search[$i]['json']->string }}</b></dd>
                        @endif

                        @if(isset($search[$i]['json']->min) && isset($search[$i]['json']->max))
                            <dd><i>Price:</i> <b>{{ $search[$i]['json']->min }} - {{ $search[$i]['json']->max }}</b>
                        @elseif(isset($search[$i]['json']->min))
                            <dd><i>Price above:</i> <b>{{ $search[$i]['json']->min }}$</b>
                        @elseif(isset($search[$i]['json']->max))
                            <dd><i>Price less than:</i> <b>{{ $search[$i]['json']->max }}</b>
                        @endif

                        @if(isset($search[$i]['json']->operation_measure_id))
                            ({{ $rent[$search[$i]['json']->operation_measure_id] }})
                        @endif
                            </dd>

                    </li>
                    @endfor
                </ul>

        </div>
    </div>




@endsection