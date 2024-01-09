<?php

namespace App\Http\Controllers\AuthSellerMajor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Kavenegar;
use App\SellerMajor;

class VerifyController extends Controller
{
    function checkMobile()
    {
        if($_GET['source'] ==='forget') {
            $mobileNum=DB::table('sellersmajor')
                ->select('Mobile')
                ->where('Mobile',(string)$_GET['mobile'])
                ->first();
            if(is_null($mobileNum))
                return redirect()->route('requestSellerMajorMobile', ['source' => 'forget'])->with('message', 'شما قبلا ثبت نام نکرده اید');
        }
        session_start();
        if (!isset($_SESSION['SENDSellerMajor'])) {
            $_SESSION['SENDSellerMajor']=time();
            $sellerMajor = new SellerMajor();
            $mobile = (string)$_GET['mobile'];
            Session::put('mobile', $mobile);
            $sellerMajorExist = SellerMajor::where('Mobile', $mobile)->first();
            if (Session::get('source') === 'register') {
                if (!isset($sellerMajorExist)) {
                    try {
                        $this->sendToken($mobile);
                    } catch (\Exception $e) {
                        unset($_SESSION['SENDSellerMajor']);
                        return redirect()->route('requestSellerMajorMobile', ['source' => 'register'])->with('message', 'شماره موبایل نامعتبر است');
                    }

                    return view('auth.sellerMajorAuth.verifyMobile');
                } else {
                    unset($_SESSION['SENDSellerMajor']);
                    return redirect()->route('requestSellerMajorMobile', ['source' => 'register'])->with('message', 'شماره موبایل قبلا ثبت نام کرده است');
                }
            } else {
                try {
                    $this->sendToken($mobile);
                } catch (\Exception $e) {
                    unset($_SESSION['SENDSellerMajor']);
                    return redirect()->route('requestSellerMajorMobile', ['source' => 'forget'])->with('message', 'شماره موبایل نامعتبر است');
                }
                return view('auth.sellerMajorAuth.verifyMobile');
            }
        } else {
            $timer = time() - $_SESSION['SENDSellerMajor'];
            if($timer>=120) {
                unset($_SESSION['SENDSellerMajor']);
                $source=Session::get('source');
                return redirect()->route('requestSellerMajorMobile',compact('source'));
            } else {
                $timer=120-$timer;
                return view('auth.sellerMajorAuth.verifyMobile',compact('timer'));
            }
        }
    }

    public function sendToken($mobile)
    {
        $token = mt_rand(100000, 999999);
        Session::put('token', $token);
//        Session::put('token', $token2);
//        Session::put('token', $token3);

        $api_key = Config::get('kavenegar.apikey');
        $var = new Kavenegar\KavenegarApi($api_key);
        $template = "verifySellerMajor";
        $type = "sms";

        $result = $var->VerifyLookup($mobile, $token, null, null, $template, $type);
    }

    public function resetPassword()
    {
        return view('auth.sellerMajorAuth.passwords.resetPassword');
    }

    public function verifyMobile(Request $req)
    {
        session_start();
        $sellerMajor = new SellerMajor();
        $verifyCode = $req->get('verifyCode');
        $source = Session::get('source');
        if ($sellerMajor->validateToken($verifyCode)) {
            unset($_SESSION['SENDSellerMajor']);
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
