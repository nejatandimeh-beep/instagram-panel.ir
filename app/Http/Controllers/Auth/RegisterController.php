<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Customer;
use App\Seller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function checkUserName($userName)
    {
        $data = DB::table('customers')
            ->select('id', 'name')
            ->where('name', $userName)
            ->first();
        if (isset($data->id))
            return 'exist';
        else
            return 'noExist';
    }

    protected function redirectTo()
    {
        if (session('url.intended')) {
            return session('url.intended');
        }
        return '/';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:30'],
//            'family' => ['required', 'string', 'max:40'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'mobile' => ['required', 'string', 'min:11'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Customer::create([
            'name' => $data['name'],
//            'Family' => $data['family'],
//            'email' => $data['email'],
            'Mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);
    }


}
