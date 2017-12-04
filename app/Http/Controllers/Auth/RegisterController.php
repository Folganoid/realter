<?php

namespace App\Http\Controllers\Auth;

use App\Mail\VerifyMail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use League\Flysystem\Exception;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:30',
            'surname' => 'required|string|max:30',
            'tel' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
           // 'role' => 'required|integer|between:1,2',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        try {
            $this->sendVerifyEmail($data['name'], $data['email']);
        }
        catch (Exception $e) {
            return redirect()->route('register')->with(['status' => 'Can not send Email !', 'class' => 'danger']);
        }

        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'tel' => $data['tel'],
            'role' => $data['role'],
            'status' => 1,
            'password' => bcrypt($data['password']),
            'verify_string' => md5($data['name'] . $data['email']),
            'verify' => 0,
        ]);
    }

    /**
     * send verify email
     *
     * @param $name
     * @param $email
     */
    public function sendVerifyEmail($name, $email)
    {
        $secret = md5($name . $email);
        $data = array (
            'secret' => route('verify', ['secret' => $secret]),
        );
        Mail::to($email)->send(new VerifyMail($data['secret']));
    }

}


