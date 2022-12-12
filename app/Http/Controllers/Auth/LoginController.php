<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {   
        $input = $request->all();
   
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'], 'status' => 'active')))
        {
            if(auth()->user()->role == 'user') {
                return redirect()->route('client');
            }
            elseif(auth()->user()->role == 'merchant') {
                return redirect()->route('merchantdashboard');
            }
            elseif(auth()->user()->role == 'corporate') {
                return redirect()->route('corporatedashboard');
            }
            elseif(auth()->user()->role == 'partner') {
                return redirect()->route('partnerdashboard');
            }
            elseif (auth()->user()->role == 'admin') {
                return redirect()->route('dashboard');
            }
            elseif (auth()->user()->role == 'super') {
                return redirect()->route('superAdminDashboard');
            }


        }
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'], 'status' => 'inactive')))
        {
            
            return redirect()->route('login')->with('message', 'Your Account Is Inactive!Please Contact To Administrator!');
        }
        else{
            //return redirect()->route('login', ['messag' => 'Your messge']);
            return redirect()->route('login')->with('message', 'Email ID Or Password Is Wrong!');
           // return redirect()->route('login')
             //   ->withErrors('msg','Email-Address And Password Are Wrong.');
        }
    }
}
