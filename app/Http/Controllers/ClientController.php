<?php

namespace App\Http\Controllers;

use App\House_type;
use App\Search;
use App\Watch;
use Illuminate\Http\Request;
use App\User;
use App\House;
use Auth;

class ClientController extends Controller
{
    //
    public function showClient($id) {

        $client = User::where('id' , $id)->with(['house'])->first()->toArray();
        $watch = Watch::where('user_id', $id)->orderBy('created_at', 'DESC')->with('house')->get()->toArray();
        $search = Search::where('user_id', $id)->orderBy('created_at', 'DESC')->get()->toArray();

        for($i = 0 ; $i < count($search); $i++) {
            $search[$i]['json'] = json_decode($search[$i]['json']);
        }

        return view('client')->with([
            'client' => $client,
            'watch' => $watch,
            'search' => $search,
            'types' => $this->types,
            'rent' => $this->rent,
            'operation' => $this->operation
        ]);
    }

    public function showAgent($id) {

        $agent = User::find($id);
        $houses = House::where('user_id', $id)->with(['image', 'document', 'watch'])->orderBy('created_at', 'DESC')->get()->toArray();

        return view('agent')->with([
            'agent' => $agent,
            'houses' => $houses,
            'types' => $this->types,
            'rent' => $this->rent,
            'operation' => $this->operation,
            'square' => $this->square,
        ]);
    }
}
