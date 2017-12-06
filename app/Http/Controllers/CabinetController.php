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
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {

        if(Gate::denies('is-agent')) {
            return redirect()->route('home')->with(['status' => 'You are not agent!', 'class' => 'danger']);
        }

        $houses = House::where('user_id', Auth::id())->with(['image', 'document', 'watch'])->get()->toArray();

        return view('cabinet')->with([
            'houses' => $houses,
            'types' => $this->types,
            'rent' => $this->rent,
            'operation' => $this->operation,
            'square' => $this->square,
            'money' => $this->money
        ]);
    }
}
