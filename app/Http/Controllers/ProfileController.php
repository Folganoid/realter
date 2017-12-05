<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
    public function userEdit()
    {

        $user = User::find(Auth::id());
        return view('profile')->with([
            'user' => $user
        ]);
    }

    /**
     * change user profile params
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userChange(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'surname' => 'required|string|max:30',
            'tel' => 'required|string|max:15',
            'email' => 'required|string|email|max:255',
            'pass_old' => 'required',
            'pass' => 'confirmed',
        ]);


        $user = User::find(Auth::id());
        $data = $request->all();

        /**
         * check old pass
         */
        if (!Hash::check($data['pass_old'], $user->password)) {
            return back()->with(['status' => 'The specified password does not match the database password', 'class' => 'danger']);
        }

        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->tel = $data['tel'];

        /**
         * if email changed
         */
        if ($user->email != $data['email']) {
            if (!empty(User::where('email', $data['email'])->first())) {
                return back()->with(['status' => 'Email already engage', 'class' => 'danger']);
            };

            $user->verify = 0;
            $user->email = $data['email'];
            $user->verify_string = md5($data['name'] . $data['email']);

            // send verify email
            try {
                RegisterController::sendVerifyEmail($data['name'], $data['email']);
            } catch (Exception $e) {
                return redirect()->route('register')->with(['status' => 'Can not send Email !', 'class' => 'danger']);
            }
        }

        if ($data['pass']) {
            $user->password = bcrypt($data['pass']);
        }

        $user->save();

        return back()->with(['status' => 'Your profile is changed successful', 'class' => 'success']);

    }
}
