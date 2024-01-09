<?php

namespace App\Http\Controllers\AuthSellerMajor;

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
    protected $redirectTo = '/Seller-Major-Panel';

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

    public function loginForm()
    {
        if (isset(Auth::guard('sellerMajor')->user()->id))
            return redirect()->route('sellerMajorPanel');
        else
            return view('auth.sellerMajorAuth.login');
    }

    public function login(Request $request)
    {
        $messages = [
            "mobile.required" => "موبایل الزامیست",
            "mobile.mobile" => "موبایل صحیح نیست",
            "password.required" => "رمز ورود الزامیست",
        ];
        $this->validate($request, [
            'mobile' => ['required', 'min:11'],
            'password' => 'required|min:8'
        ], $messages);

        $credentials = [
            'Mobile' => $request->input('mobile'),
            'password' => $request->input('password')
        ];

        if (Auth::guard('sellerMajor')->attempt($credentials, $request->get('remember'))) {
            return redirect()->intended(route('sellerMajorPanel'));
        }

        return back()->withInput($request->only('mobile', 'remember', 'password', 'remember'))->with('fails', 'رمز یا موبایل اشتباه است!');
//        return Redirect::route('sellerLog')
//            ->with('fails', 'رمز یا ایمیل اشتباه است!');
    }

    public function logout(Request $request)
    {

        Auth::guard('sellerMajor')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->guest(route('sellerMajorLog'));
    }
}
