<?php

namespace App\Http\Controllers;

use App\House_type;
use App\Search;
use App\Watch;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Config;

class ClientController extends Controller
{
    //
    public function showClient($id) {

        $client = User::where('id' , $id)->with(['house'])->first()->toArray();
        $watch = Watch::where('user_id', $id)->with('house')->get()->toArray();
        $search = Search::where('user_id', $id)->get()->toArray();
        $types = Config::get('settings.types');;

        for($i = 0 ; $i < count($search); $i++) {
            $search[$i]['json'] = json_decode($search[$i]['json']);
        }

      //  dd($search);

        return view('client')->with(['client' => $client, 'watch' => $watch, 'search' => $search, 'types' => $types]);
    }

    public function showAgent($id) {

        return view('agent')->with(['id' => $id]);
    }
}
