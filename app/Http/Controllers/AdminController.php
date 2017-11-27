<?php

namespace App\Http\Controllers;

use App\House_type;
use Illuminate\Http\Request;
use Gate;

class AdminController extends Controller
{
    //
    public function index() {

        if(Gate::denies('is-admin')) {
            return redirect()->route('home')->with(['status' => 'You are not admin!', 'class' => 'danger']);
        }


        $house_types = House_type::all();

        return view('admin')->with('types', $house_types);
    }

    public function saveType(Request $request) {
        $data = $request->all();

        $type = new House_type();
        $type->name = $data['name'];
        $type->json = $data['json'];
        $type->save();

        return redirect()->route('home')->with(['status' => 'House type added', 'class' => 'success']);
    }
}
