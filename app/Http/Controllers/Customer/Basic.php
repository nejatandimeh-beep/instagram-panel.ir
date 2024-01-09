<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\lib\ZarinPal;
use App\Picture;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use DateTime;
use File;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Kavenegar;
use nusoap_client;
use Illuminate\Console\Scheduling\Schedule;
use SoapClient;

class Basic extends Controller
{
    public function __construct()
    {
        session_start();
        if(isset(Auth::user()->id)){
            $this->middleware(function ($request, $next) {
                $_SESSION['userProfilePic']=$request->user()->PicPath;
                return $next($request);
            });
        }
    }

    public function Master()
    {
        return view('Customer.Master');
    }

    public function userProfile()
    {
        try {
            $customer = DB::table('customers')
                ->select('*')
                ->where('id', Auth::user()->id)
                ->first();
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        $address = DB::table('customer_address')
            ->select('*')
            ->where('CustomerID', Auth::user()->id)
            ->orderBy('Status', 'DESC')
            ->get();

        $userName = !is_null(Auth::user()->name) ? Auth::user()->name : 'کاربر' . Auth::user()->id;
        $notification = DB::table('seller_major_post_comment as pc')
            ->select('pc.ID', 'pc.Status as Status', 'pcr.CommentID', 'pcr.Status', 'pcr.CommentReplyText')
            ->leftJoin('seller_major_post_comment_reply as pcr', function ($join) {
                $join->on('pc.ID', 'pcr.CommentID')
                    ->where('pcr.Status', 2);
            })
            ->where('pc.CommenterID', isset(Auth::user()->id) ? Auth::user()->id : null)
            ->where('pc.Status', 2)
            ->get()->count();
        $notificationMsg = DB::table('seller_major_msg')
            ->where('CustomerID', isset(Auth::user()->id) ? Auth::user()->id : null)
            ->where('Status', 2)
            ->get()->count();
        return view('Customer.Profile', compact('customer', 'address', 'notification', 'notificationMsg'));
    }

    public function profileUpdate(Request $request)
    {
        $name = $request->get('name');
        $family = $request->get('family');
        $nationalId = $request->get('nationalId');
        $day = $request->get('day');
        $mon = $request->get('mon');
        $year = $request->get('year');
        $gender = $request->get('gender');
        $prePhone = $request->get('prePhone');
        $phone = $request->get('phone');
        $state = $request->get('state');
        $city = $request->get('city');

        DB::table('customers')
            ->where('id', Auth::user()->id)
            ->update([
                'name' => $name,
                'Family' => $family,
                'NationalID' => $nationalId,
                'BirthdayD' => $day,
                'BirthdayM' => $mon,
                'BirthdayY' => $year,
                'Gender' => $gender,
                'Phone' => $phone,
                'PrePhone' => $prePhone,
                'State' => $state,
                'City' => $city,
            ]);

        return redirect()->route('userProfile', 'personData');
    }

    public function customerVerify()
    {
        return redirect()->route('Master');
    }

    public function uploadImage(Request $request)
    {
        $image = $request->file('imageUrl');

//        return $image;
        $folderPath = public_path('img/CustomerProfileImage/');
        $imageName = Auth::user()->id . '.png';
        $imageFullPath = $folderPath . $imageName;

        $source = '';
        switch ($image->getMimeType()) {
            case 'image/jpeg':
            case 'image/jpg':
                $source = imagecreatefromjpeg($image);
                break;
            case 'image/png':
                $source = imagecreatefrompng($image);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($image);
                break;
        }
        imagejpeg($source, $imageFullPath);

        DB::table('customers')
            ->where('id', Auth::user()->id)
            ->update([
                'PicPath' => 'img/CustomerProfileImage/' . $imageName,
            ]);
        return true;
    }

    public function connection()
    {
        try {
            $data = DB::table('customer_conversation as cc')
                ->select('cc.*',
                    'ccd.QuestionDate as qDate',
                    'ccd.QuestionTime as qTime',
                    'ccd.AnswerDate as aDate',
                    'ccd.AnswerTime as aTime',
                    'ccd.Replay',
                    'ccd.ConversationID',
                    'ccd.ID as conversationDetailID')
                ->leftJoin('customer_conversation_detail as ccd', 'ccd.ConversationID', '=', 'cc.ID')
                ->where('cc.CustomerID', Auth::user()->id)
                ->orderBy('cc.Status')
                ->orderBy(DB::raw('IF(cc.Status=0 || cc.Status=1, cc.Priority, false)'), 'ASC')
                ->orderBy('cc.ID', 'DESC')
                ->get();
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        $alarmMsg = DB::table('customer_alarm_msg')
            ->select('*')
            ->where('CustomerID', Auth::user()->id)
            ->get();

        // Convert Date
        $persianDate = array();
        foreach ($data as $key => $rec) {
            $d = $rec->Date;
            $persianDate[$key] = $this->convertDateToPersian($d);
        }

        return view('Customer.Conversation', compact('data', 'persianDate', 'alarmMsg'));
    }

    public function connectionDetail($id, $status)
    {
        $data = DB::table('customer_conversation_detail as ccd')
            ->select('ccd.*', 'cc.Subject', 'cc.Status', 'cc.ID as ConversationID', 'cc.CustomerID', 'c.Name', 'c.Family', 'cc.Priority')
            ->leftJoin('customer_conversation as cc', 'cc.ID', '=', 'ccd.ConversationID')
            ->leftJoin('customers as c', 'c.ID', '=', 'cc.CustomerID')
            ->where('ccd.ConversationID', $id)
            ->paginate(10);

        if ($status === '0') {
            foreach ($data as $key => $rec)
                if ($rec->Replay !== 0) {
                    DB::table('customer_conversation')
                        ->where('ID', $id)
                        ->update(['Status' => 2]);
                } else {
                    DB::table('customer_conversation')
                        ->where('ID', $id)
                        ->update(['Status' => 2]);
                }
        }

        $questionMinuets = array();
        $answerMinuets = array();
        $questionHowDay = array();
        $answerHowDay = array();
        foreach ($data as $key => $rec) {
            $d = $rec->QuestionDate;
            $qPersianDate[$key] = $this->convertDateToPersian($d);
            $d = $rec->AnswerDate;
            $aPersianDate[$key] = $this->convertDateToPersian($d);
            $questionMinuets[$key] = $this->dateLenToNow($rec->QuestionDate, $rec->QuestionTime);
            $answerMinuets[$key] = $this->dateLenToNow($rec->AnswerDate, $rec->AnswerTime);
            $questionHowDay[$key] = null;
            $answerHowDay[$key] = null;
            if (($questionMinuets[$key] < 11520) || ($answerMinuets[$key] < 11520)) {
                $questionHowDay[$key] = $this->howDays($questionMinuets[$key]);
                $answerHowDay[$key] = $this->howDays($answerMinuets[$key]);
            }
        }

        $title = $data[0]->Subject;

        return view('Customer.ConversationDetail', compact('data', 'answerHowDay', 'questionHowDay', 'qPersianDate', 'aPersianDate', 'title'));
    }

    public function connectionNew(Request $request)
    {
        $title = $request->get('title');
        $priority = $request->get('priority');
        $section = $request->get('section');

        return view('Customer.ConversationDetail', compact('title', 'priority', 'section'));
    }

    public function connectionNewMsg(Request $request)
    {

        date_default_timezone_set('Asia/Tehran');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $customerID = Auth::user()->id;
        $question = $request->get('question');
        $title = $request->get('title');

        if (isset($title)) {
            $priority = $request->get('priority');
            $section = $request->get('section');
            // Insert Data to Conversation
            DB::table('customer_conversation')->insert([
                [
                    'CustomerID' => $customerID,
                    'Subject' => $title,
                    'Section' => $section,
                    'priority' => $priority,
                    'Status' => 1,
                    'Date' => $date,
                    'Time' => $time,
                ],
            ]);

            $conversationID = DB::table('customer_conversation')
                ->select('ID')
                ->latest('ID')
                ->first();

            $conversationID = $conversationID->ID;
        } else {
            $conversationID = $request->get('conversationID');
        }
        DB::table('customer_conversation')
            ->where('ID', $conversationID)
            ->update(['Status' => 1]);

        // Insert Data to Conversation_detail
        DB::table('customer_conversation_detail')->insert([
            [
                'ConversationID' => $conversationID,
                'Question' => $question,
                'Answer' => '',
                'QuestionDate' => $date,
                'QuestionTime' => $time,
                'Replay' => 0,
            ],
        ]);

        try {
            $api_key = Config::get('kavenegar.apikey');
            $var = new Kavenegar\KavenegarApi($api_key);
            $template = "support";
            $type = "sms";

            $result = $var->VerifyLookup('09144426149', 'Administrator-Master', 'Customer', null, $template, $type);
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
        return redirect('/Customer-Connection')->with('status', 'success');
    }

    public function help()
    {
        return view('Customer.Help');
    }

// ---------------------------------------------[Product List]----------------------------------------------------------
    public function aboutMe()
    {
        return view('Customer.AboutMe');
    }

// ----------------------------------------------[ Regulation ]---------------------------------------------------------
    public function regulation($tab)
    {
        return view('Customer.Regulation', compact('tab'));
    }

// ----------------------------------------------[ Instagram ]----------------------------------------------------------
    public function instagram()
    {
        return view('Customer.Instagram');
    }

    public function requestPdId(Request $request)
    {
        $data = DB::table('product_detail')
            ->where('ID', $request->get('pdId'))
            ->first();

        if (isset($data->ID))
            return redirect()->route('productDetail', [$data->ProductID, $data->Size]);
        else
            return redirect()->route('instagram')->with('error', 'find');

    }

// -----------------------------------------[ Seller Register Mode ]----------------------------------------------------
    public function registerMode()
    {
        return view('auth.sellerMajorAuth.registerMode');
    }

    public function sellerLoginMode()
    {
        return view('auth.sellerMajorAuth.LoginMode');
    }
// --------------------------------------------[ MY FUNCTION ]----------------------------------------------------------
    //  Convert Date to Iranian Calender
    public function convertDateToPersian($d)
    {
        if ($d === 0)
            return 0;
        else
            $da = new DateTime($d);

        $day = $da->format('d');
        $mon = $da->format('m');
        $year = $da->format('Y');

        // Convert Date to Iranian
        return Verta::getJalali($year, $mon, $day);
    }

    //  Minutes Passed of Spacial Time
    public function dateLenToNow($date, $time)
    {
        $orderDateTime = $date . ' ' . $time;
        $today = new DateTime('Asia/Tehran');
        $result = $today->format('Y-m-d H:i:s');
        $datetime1 = strtotime($orderDateTime);
        $datetime2 = strtotime($result);
        $interval = abs($datetime2 - $datetime1);
        $minutes = round($interval / 60);

        return (int)$minutes;
    }

    //    how past Days of Current Days
    public function howDays($day)
    {
        switch (true) {
            case  ($day < 55):
                return 'لحضاتی پیش';
                break;
            case  (($day > 55) && ($day < 65)):
                return 'یک ساعت پیش';
                break;
            case  (($day > 65) && ($day < 130)):
                return 'دو ساعت پیش';
                break;
            case  (($day > 130) && ($day < 1440)):
                return 'امروز';
                break;
            case  (($day > 1440) && ($day < 2880)):
                return 'یک روز پیش';
                break;
            case  (($day > 2880) && ($day < 4320)):
                return 'دو روز پیش';
                break;
            case  (($day > 4320) && ($day < 5760)):
                return 'سه روز پیش';
                break;
            case  (($day > 5760) && ($day < 7200)):
                return 'چهار روز پیش';
                break;
            case  (($day > 7200) && ($day < 8640)):
                return 'پنج روز پیش';
                break;
            case  (($day > 8640) && ($day < 10080)):
                return 'شش روز پیش';
                break;
            case  (($day > 10080) && ($day < 11520)):
                return 'یک هفته پیش';
                break;
            default :
                break;
        }
    }

    public function month($mon)
    {
        switch ($mon) {
            case 1:
                return 'فروردین';
            case 2:
                return 'اردیبهشت';
            case 3:
                return 'خرداد';
            case 4:
                return 'تیر';
            case 5:
                return 'مرداد';
            case 6:
                return 'شهریور';
            case 7:
                return 'مهر';
            case 8:
                return 'آبان';
            case 9:
                return 'آذر';
            case 10:
                return 'دی';
            case 11:
                return 'بهمن';
            case 12:
                return 'اسفند';
            default:
                return false;
        }

    }

    public function test()
    {
        return view('Temp/test');
    }
}
