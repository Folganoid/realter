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

        return view('admin');
    }
}
