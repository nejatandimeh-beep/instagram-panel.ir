<?php

namespace App\Http\Controllers\AuthSellerMajor;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    public function __construct()
    {
     //   $this->middleware('IsSeller');
    }

    public function showLinkRequestForm(){

        return view('auth.sellerMajorAuth.passwords.email');
    }

    public function broker(){
        return Password::broker('sellersmajor');
    }

    protected function guard()
    {
        return Auth::guard('sellerMajor');
    }

}
