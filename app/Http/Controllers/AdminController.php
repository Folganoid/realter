<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Exception;
use Mail;
use App\User;

class AdminController extends Controller
{
    /**
     * admin panel
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function index() {

        if(Gate::denies('is-admin')) {
            return redirect()->route('home')->with(['status' => 'You are not admin!', 'class' => 'danger']);
        }

        $users = User::orderBy('name')->get();

        return view('admin')->with(['users' => $users]);
    }

    /**
     * edit User page
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function userEdit($id) {
        if(Gate::denies('is-admin')) {
            return redirect()->route('home')->with(['status' => 'You are not admin!', 'class' => 'danger']);
        }
            $user = User::find($id);
            if (empty($user)) {
                return redirect()->route('home')->with(['status' => 'user don\'t find', 'class' => 'danger']);
            }
        return view('user_edit')->with(['user' => $user, 'roles' => $this->roles]);
    }

    /**
     * user change save
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userEditSave(Request $request) {

        if(Gate::denies('is-admin')) {
            return redirect()->route('home')->with(['status' => 'You are not admin!', 'class' => 'danger']);
        }

        $data = $request->all();
        $user = User::find($data['id']);

        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->tel = $data['tel'];
        $user->verify = $data['verify'];
        $user->email = $data['email'];

        if($data['password']) {
            $user->password = bcrypt($data['password']);
        }

        $user->role = $data['role'];
        $user->save();

        return redirect()->route('admin')->with(['status' => 'User profile had changed', 'class' => 'success']);
    }
}
