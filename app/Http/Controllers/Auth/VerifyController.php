<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Kavenegar;
use App\Customer;

class VerifyController extends Controller
{
    function getMobile()
    {
        if($_GET['source'] ==='forget') {
            $mobileNum=DB::table('customers')
                ->select('Mobile')
                ->where('Mobile',(string)$_GET['mobile'])
                ->first();
            if(is_null($mobileNum))
                return redirect()->route('requestMobile', ['source' => 'forget'])->with('message', 'شما قبلا ثبت نام نکرده اید');
        }
        session_start();
        if (!isset($_SESSION['SEND'])) {
            $_SESSION['SEND']=time();
            $customer = new Customer();
            $mobile = (string)$_GET['mobile'];
            Session::put('mobile', $mobile);
            $customerExist = Customer::where('Mobile', $mobile)->first();
            if (Session::get('source') === 'register') {
                if (!isset($customerExist)) {
                    try {

                        $this->sendToken($mobile);

                    } catch (\Exception $e) {
                        unset($_SESSION['SEND']);
                        return redirect()->route('requestMobile', ['source' => 'register'])->with('message', 'شماره موبایل نامعتبر است');
                    }

                    return view('auth.verifyMobile');
                } else {
                    unset($_SESSION['SEND']);
                    return redirect()->route('requestMobile', ['source' => 'register'])->with('message', 'شماره موبایل قبلا ثبت نام کرده است');
                }
            } else {
                try {

                    $this->sendToken($mobile);

                } catch (\Exception $e) {
                    unset($_SESSION['SEND']);
                    return redirect()->route('requestMobile', ['source' => 'forget'])->with('message', 'شماره موبایل نامعتبر است');
                }
                return view('auth.verifyMobile');
            }
        } else {
            $timer = time() - $_SESSION['SEND'];
            if($timer>=120) {
                unset($_SESSION['SEND']);
                $source=Session::get('source');
                return redirect()->route('requestMobile',compact('source'));
            } else {
                $timer=120-$timer;
                return view('auth.verifyMobile',compact('timer'));
            }
        }
    }

    public function sendToken($mobile)
    {

        $token = mt_rand(100000, 999999);
        $token2 = mt_rand(100000, 999999);
        $token3 = mt_rand(100000, 999999);
        Session::put('token', $token);
//        Session::put('token', $token2);
//        Session::put('token', $token3);

        $api_key = Config::get('kavenegar.apikey');
        $var = new Kavenegar\KavenegarApi($api_key);
        $template = "verifyUserSM";
        $type = "sms";

        $result = $var->VerifyLookup($mobile, $token, $token2, $token3, $template, $type);

    }

    public function resetPassword()
    {
        return view('auth.passwords.resetPassword');
    }

    public function verifyMobile(Request $req)
    {
        session_start();
        $customer = new Customer();
        $verifyCode = $req->get('verifyCode');
        $source = Session::get('source');
        $mobile = Session::get('mobile');

        if ($customer->validateToken($verifyCode)) {
            unset($_SESSION['SEND']);
//            echo "Success";
//            $tel = Auth::user()->phone_number;
//            echo $tel;
              return array('true',$source);
        } else {
//            $this->create($mobile);
//            $customer = Customer::where('phone_number', $mobile)->first();
//            Auth::login($customer);
            return 'false';
        }
    }
}
