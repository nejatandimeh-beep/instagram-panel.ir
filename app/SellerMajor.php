<?php

namespace App;

use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Session;

class SellerMajor extends Authenticatable
{
    use Notifiable;

    protected $table = 'sellersmajor';


    protected $fillable = [
        'name','Mobile','email','password','Category','HintCategory','CatCode','Pic','InstaPic','Instagram','remember_token',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getAuthPassword()
    {
        return $this->password;
    }

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new CustomResetPasswordNotification($token));
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
