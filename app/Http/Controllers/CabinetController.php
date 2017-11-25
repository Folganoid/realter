<?php

namespace App\Http\Controllers;

use App\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        $property = House::where('user_id', Auth::id())->with(['image', 'document', 'houseType', 'watch'])->get();
        dd($property->toArray());

        return view('cabinet');
    }
}
