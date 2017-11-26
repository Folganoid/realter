<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;

class ListController extends Controller
{
    public function index() {

        $houses = House::with(['image', 'document', 'houseType', 'watch', 'user'])->get()->toArray();
       // dd($houses);

        return view('list')->with('houses', $houses);
    }

}
