<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Administrator\Customer;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function showResetForm(Request $request, $token = null)
    {
        $password_resets = DB::table('password_resets')->get();
        $email="";

        foreach($password_resets as $password_reset)
        {
            if (Hash::check($token, $password_reset->token)) { // checking hash match with requested token
                // here if hash match with token
                $email = $password_reset->email;
            }
        }

        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function resetCustomerPassword(Request $request)
    {
        $customer=DB::table('customers')
        ->where('Mobile', Session::get('mobile'))
            ->update(['password' => Hash::make($request->get('password'))]);

        $customer=DB::table('customers')
            ->where('Mobile', Session::get('mobile'))
            ->first();

        Auth::loginUsingId($customer->id, TRUE);
        return redirect('/Customer-Profile');
    }

}
