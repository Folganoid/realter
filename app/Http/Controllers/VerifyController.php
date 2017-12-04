<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function index(Request $request){

        $secret = $request->secret;
        $user = User::where('verify_string', $secret)->first();

       if(!empty($user)) {
           $user->verify = 1;
           $user->verify_string = null;
           $user->save();

           return redirect()->route('home')->with(['status' => 'Your account verified successful', 'class' => 'success']);
       }

       return redirect()->route('home');

    }
}
