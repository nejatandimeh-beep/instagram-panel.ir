<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Kavenegar;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'customers';


    protected $fillable = [
         'Mobile', 'password','status','name'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getAuthPassword()
    {
        return $this->password;
    }



    public function validateToken($token)
    {

        $validToken = Session::get('token');
        if ($token == $validToken) {
//            Session::forget('token');
//            Auth::login($this);
//            return true;
            return true;

        } else {
            return false;
        }
    }


}
