<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\User;

class AdminController extends Controller
{
    //
    public function index() {

        if(Gate::denies('is-admin')) {
            return redirect()->route('home')->with(['status' => 'You are not admin!', 'class' => 'danger']);
        }
                $user = User::find(Auth::id());

                //$secret = md5($user->)


                $data = array (
                    'verify' => ';lk;lk;lk;lk;lk;lk;'
                );

            Mail::send ( 'emails.test', $data, function ($message) {

                $message->from ( '', 'realtor222_Admin' );
                $message->to ( 'folgan@i.ua' )->subject( 'Just Laravel demo email using SendGrid' );
            } );

        return view('admin');
    }
}
