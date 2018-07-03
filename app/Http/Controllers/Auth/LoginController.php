<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
//use Auth;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        $this->middleware('guest')->except('logout');
    }

    public function login (Request $request) {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|alphaNum|min:3'
        );


        $validator = Validator::make($request->only('email', 'password'), $rules);


        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials, false)) {

                return redirect()->route('home');
            } else {
                return redirect()
                    ->back();
            }

        }
    }

    public function logout (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }


}
