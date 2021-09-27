<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function authenticate(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(User::where([['email', $request->email],['employee_state_id', '!=' ,1]])->first()){

        }else{
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended('/');
                }
            }


        return back()->withErrors([
            'email' => 'The provided credentials do not match our record.',
        ]);
    }
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
}
