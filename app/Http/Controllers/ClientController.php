<?php

namespace App\Http\Controllers;

use App\House_type;
use App\Search;
use App\Watch;
use Illuminate\Http\Request;
use App\User;

class ClientController extends Controller
{
    //
    public function showClient($id) {

        $client = User::where('id' , $id)->with(['house'])->first()->toArray();
        $watch = Watch::where('user_id', $id)->with('house')->get()->toArray();
        $search = Search::where('user_id', $id)->get()->toArray();

        for($i = 0 ; $i < count($search); $i++) {
            $search[$i]['json'] = json_decode($search[$i]['json']);
        }

       // dd($this->rent);

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

        return view('agent')->with(['id' => $id]);
    }
}