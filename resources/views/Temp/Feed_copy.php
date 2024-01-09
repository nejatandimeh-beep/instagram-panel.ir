<?php

namespace App\Http\Controllers\SellerMajor;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use File;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Kavenegar;


class Feed extends Controller
{
    protected $sellerMajorID, $sellerMajorData;

    public function __construct()
    {
        $this->middleware('IsSellerMajor');
        $this->middleware(function ($request, $next) {
            session_start();
            $_SESSION['userProfileImg'] = Auth::guard('sellerMajor')->user()->Pic . '/profileImg.jpg';
            $_SESSION['userName'] = Auth::guard('sellerMajor')->user()->name;
            $this->sellerMajorID = Auth::guard('sellerMajor')->user()->id;
            $this->sellerMajorData = DB::table('sellersmajor')
                ->where('id', $this->sellerMajorID)
                ->first();

            return $next($request);
        });

    }

    public function feed()
    {
        $eventHowDay = array();
        $events = DB::table('seller_major_event as e')
            ->select('*', 'e.ID as eventID', 'e.Time as eventTime', 's.id as sellerMajorID','e.Pic as eventPic','s.Pic as profileImage')
            ->leftJoin('seller_major_event_like as el', 'el.EventID', 'e.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'e.SellerMajorID')
            ->where("e.Time", ">", Carbon::now()->subHours(24)->toDateTimeString())
            ->groupBy('e.ID')
            ->orderBy('e.SellerMajorID', 'ASC')
            ->orderBy('e.ID', 'ASC')
            ->get();

        $eventDate = array();
        $eventTime = array();
        $sellerMajorID=array();
        foreach ($events as $key => $rec) {
            $temp = explode(' ', $rec->eventTime);
            $eventDate[$key] = $this->convertDateToPersian($temp[0]);
            $eventDate[$key] = $this->addZero($eventDate[$key]);
            $eventTime[$key] = $this->dateLenToNow($temp[0], $temp[1]);

            if ($eventTime[$key] < 11520) {
                $eventHowDay[$key] = $this->howDays($eventTime[$key]);
            } else {
                $eventHowDay[$key] = $eventDate[$key];
            }
        }
        return view('SellerMajor.Feed', compact('events', 'eventHowDay','sellerMajorID'));
    }

    public function checkVisitEvent($userID)
    {
        $events=DB::table('seller_major_event as e')
            ->select('e.ID as eventID','e.SellerMajorID','ev.*')
            ->leftJoin('seller_major_event_visit as ev','ev.eventID','e.ID')
            ->where('e.SellerMajorID',$userID)
            ->get();

        $remainingVisit=array();
        foreach ($events as $key => $rec) {
            if($rec->VisitorID === null){
                $remainingVisit[$key]=$rec->eventID;
            }
        }
        return $remainingVisit;
    }
//------------------------------------------------
//  Convert Date to Iranian Calender
    public
    function convertDateToPersian($d)
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
    public
    function dateLenToNow($date, $time)
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
    public
    function howDays($day)
    {
        switch (true) {
            case  ($day < 3):
                return 'لحضاتی پیش';
                break;
            case  (($day >= 3) && ($day < 59)):
                return $day . ' د';
                break;
            case  (($day >= 60) && ($day <= 90)):
                return '1 س';
                break;
            case  (($day > 90) && ($day <= 150)):
                return '2 س';
                break;
            case  (($day > 150) && ($day <= 210)):
                return '3 س';
                break;
            case  (($day > 210) && ($day <= 270)):
                return '4 س';
                break;
            case  (($day > 270) && ($day <= 330)):
                return '5 س';
                break;
            case  (($day > 330) && ($day <= 390)):
                return '6 س';
                break;
            case  (($day > 390) && ($day <= 450)):
                return '7 س';
                break;
            case  (($day > 450) && ($day <= 510)):
                return '8 س';
                break;
            case  (($day > 510) && ($day <= 570)):
                return '9 س';
                break;
            case  (($day > 570) && ($day <= 630)):
                return '10 س';
                break;
            case  (($day > 630) && ($day <= 690)):
                return '11 س';
                break;
            case  (($day > 690) && ($day <= 750)):
                return '12 س';
                break;
            case  (($day > 750) && ($day <= 810)):
                return '13 س';
                break;
            case  (($day > 810) && ($day <= 870)):
                return '14 س';
                break;
            case  (($day > 870) && ($day <= 930)):
                return '15 س';
                break;
            case  (($day > 930) && ($day <= 990)):
                return '16 س';
                break;
            case  (($day > 990) && ($day <= 1050)):
                return '17 س';
                break;
            case  (($day > 1050) && ($day <= 1110)):
                return '18 س';
                break;
            case  (($day > 1110) && ($day <= 1170)):
                return '19 س';
                break;
            case  (($day > 1170) && ($day <= 1230)):
                return '20 س';
                break;
            case  (($day > 1230) && ($day <= 1290)):
                return '21 س';
                break;
            case  (($day > 1290) && ($day <= 1350)):
                return '22 س';
                break;
            case  (($day > 1350) && ($day <= 1410)):
                return '23 س';
                break;
            case  (($day > 1410) && ($day <= 1440)):
                return '24 س';
                break;
            case  (($day > 1440) && ($day < 2880)):
                return '1 روز';
                break;
            case  (($day > 2880) && ($day < 4320)):
                return '2 روز';
                break;
            case  (($day > 4320) && ($day < 5760)):
                return '3 روز';
                break;
            case  (($day > 5760) && ($day < 7200)):
                return '4 روز';
                break;
            case  (($day > 7200) && ($day < 8640)):
                return '5 روز';
                break;
            case  (($day > 8640) && ($day < 10080)):
                return '6 روز';
                break;
            case  (($day > 10080) && ($day < 11520)):
                return 'هفته قبل';
                break;
            default :
                break;
        }
    }

// Add Zero Number to Day and Month of Converted Dates
    public
    function addZero($d)
    {
        for ($i = 0; $i < 3; $i++)
            if (strlen($d[$i]) < 2)
                $d[$i] = '0' . $d[$i];
        return $d[0] . '.' . $d[1] . '.' . $d[2];
    }
}
