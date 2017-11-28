@extends('layouts.main')

@section('content')
    <h2>Client: {{ $client['name'] }} {{ $client['surname'] }}</h2>
    <br>
    <dd>Registered: {{ $client['created_at'] }}</dd>
    <dd>Telephone: {{ $client['tel'] }}</dd>
    <dd>Email: {{ $client['email'] }} <button>Send Email (don't wrk yet)</button></dd>
    <br>
    <div class="row">
        <div class="col-6">
            <h3>Watched:</h3>
            <ul class="list-group">
            @for($i = 0 ; $i < count($watch); $i++ )
                <li class="list-group-item">
                    {{ $watch[$i]['house']['name'] }}
                    {{ $types[$watch[$i]['house']['house_type_id']] }}
                    {{ $watch[$i]['house']['operation'] }}
                    {{ $watch[$i]['house']['price'] }}$
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
                            <i> / Operation:</i> <b>{{ $search[$i]['json']->operation }}</b>
                        @endif

                        @if(isset($search[$i]['json']->type))
                            <i> / Property type:</i> <b>{{ $types[$search[$i]['json']->type] }}</b>
                            @endif

                        </dd>
                        @if(isset($search[$i]['json']->string))
                            <dd><i>Search string:</i> <b>{{ $search[$i]['json']->string }}</b></dd>
                        @endif

                        @if(isset($search[$i]['json']->min) && isset($search[$i]['json']->max))
                            <dd><i>Price:</i> <b>{{ $search[$i]['json']->min }}$ - {{ $search[$i]['json']->min }}$</b></dd>
                        @elseif(isset($search[$i]['json']->min))
                            <dd><i>Price above:</i> <b>{{ $search[$i]['json']->min }}$</b></dd>
                        @elseif(isset($search[$i]['json']->max))
                            <dd><i>Price less than:</i> <b>{{ $search[$i]['json']->max }}$</b></dd>
                        @endif

                    </li>
                    @endfor
                </ul>

        </div>
    </div>




@endsection