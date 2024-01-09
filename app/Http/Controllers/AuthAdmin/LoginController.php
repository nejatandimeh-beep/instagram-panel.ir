<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
    protected $redirectTo = '/login/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        //$this->middleware('auth:seller')->except('sellerLogout');
        //$this->middleware('auth:seller');
        // $this->middleware('IsSeller');
    }


    // Seller Authentication

    public function showAdminLoginForm()
    {

        return view('auth.adminAuth.login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            if (Auth::guard('admin')->user()->role === 1)
                return redirect()->intended('/Administrator-Master');
            elseif (Auth::guard('admin')->user()->role === 2)
                return redirect()->intended('/Kiosk-Panel');
            else
                return redirect()->intended('/Delivery-Panel');

        }

        // return back()->withInput($request->only('email', 'remember'));
        return Redirect::route('adminLog')
            ->with('fails', 'رمز یا ایمیل اشتباه است');
    }

    public function adminLogout(Request $request)
    {

        Auth::guard('admin')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->guest(route('adminLog'));
    }
}
