<?php

namespace App\Http\Controllers;

use App\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;

class CabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        if(Gate::denies('is-agent')) {
            return redirect('/')->with(['status' => 'You are not agent!', 'class' => 'danger']);
        }

        $houses = House::where('user_id', Auth::id())->with(['image', 'document', 'houseType', 'watch'])->get()->toArray();
       // dd($houses);

        return view('cabinet')->with(['houses' => $houses]);
    }
}
