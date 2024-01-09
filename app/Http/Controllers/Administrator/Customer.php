<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Picture;
use Illuminate\Support\Facades\Auth;
use DateTime;
use File;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Kavenegar;

class Customer extends Controller
{
    public function __construct()
    {
        $this->middleware('IsAdmin');
    }

    public function customer()
    {
        $data = DB::table('customers')
            ->select('*')
            ->get();

        $newSupport=DB::table('customer_conversation')
            ->select('CustomerID','Status')
            ->where('Status','1')
            ->get()
            ->count();

        $data = DB::table('customers as c')
            ->select('*','c.Mobile as customerMobile')
            ->leftJoin('customer_address as ca' , 'ca.CustomerID','=','c.id')
            ->groupBy('c.id')
            ->get();

        return view('Administrator.Customer.Customer',compact('data','newSupport'));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        DB::table('customers')
            ->where('id', $id)
            ->update([
                'Name' => $request->get('name'),
                'Family' => $request->get('family'),
                'Email' => $request->get('email'),
                'NationalID' => $request->get('nationalId'),
                'BirthdayY' => $request->get('year'),
                'BirthdayM' =>  $request->get('mon'),
                'BirthdayD' =>  $request->get('day'),
                'Gender' => (int)$request->get('gender'),
                'Phone' =>$request->get('phone'),
                'PrePhone' => $request->get('prePhone'),
                'Mobile' => $request->get('mobile'),
                'State' => $request->get('state'),
                'City' => $request->get('city'),
                'PicPath' => $request->get('userImage'),
            ]);

        return redirect()->route('customerControlPanel', ['id' => $id, 'tab' => 'userInfo']);
    }

    public function addressUpdate(Request $request)
    {
        $id = $request->get('receiver-id');
        $name = $request->get('receiver-name');
        $family = $request->get('receiver-family');
        $postalCode = $request->get('receiver-postalCode');
        $prePhone = $request->get('receiver-prePhone');
        $phone = $request->get('receiver-phone');
        $mobile = $request->get('receiver-mobile');
        $state = $request->get('receiver-state');
        $city = $request->get('receiver-city');
        $address = $request->get('receiver-address');

        DB::table('customer_address')
            ->where('ID', $id)
            ->update([
                'ReceiverName' => $name,
                'ReceiverFamily' => $family,
                'PostalCode' => $postalCode,
                'PrePhone' => $prePhone,
                'Phone' => $phone,
                'Mobile' => $mobile,
                'State' => $state,
                'City' => $city,
                'Address' => $address,
            ]);
        return redirect()->route('customerControlPanel', ['id' => $request->get('id'), 'tab' => 'address']);
    }

    public function addAddress(Request $request)
    {
        $id=$request->get('id');
        $name = $request->get('receiver-name');
        $family = $request->get('receiver-family');
        $postalCode = $request->get('receiver-postalCode');
        $prePhone = $request->get('receiver-prePhone');
        $phone = $request->get('receiver-phone');
        $mobile = $request->get('receiver-mobile');
        $state = $request->get('receiver-state');
        $city = $request->get('receiver-city');
        $address = $request->get('receiver-address');

        DB::table('customer_address')
            ->where('CustomerID', $id)
            ->update([
                'Status' => 0,
            ]);

        DB::table('customer_address')->insert([
            'CustomerID' =>$id,
            'ReceiverName' => $name,
            'ReceiverFamily' => $family,
            'PostalCode' => $postalCode,
            'PrePhone' => $prePhone,
            'Phone' => $phone,
            'Mobile' => $mobile,
            'State' => $state,
            'City' => $city,
            'Address' => $address,
            'Status' => 1,
        ]);

        return redirect()->route('customerControlPanel', ['id' => $id, 'tab' => 'address']);
    }

    public function addressDelete($id)
    {
        DB::table('customer_address')
            ->select('ID')
            ->where('ID', $id)
            ->delete();
    }

    public function controlPanel($id, $tab)
    {
        $customerInfo = DB::table('customers')
            ->select('*')
            ->where('id', $id)
            ->first();

        $support = DB::table('customer_conversation as cc')
            ->select('cc.*',
                'ccd.QuestionDate as qDate',
                'ccd.QuestionTime as qTime',
                'ccd.AnswerDate as aDate',
                'ccd.AnswerTime as aTime',
                'ccd.Replay',
                'ccd.ConversationID',
                'ccd.ID as conversationDetailID')
            ->leftJoin('customer_conversation_detail as ccd', 'ccd.ConversationID', '=', 'cc.ID')
            ->where('cc.CustomerID',$id)
            ->orderBy('cc.Status')
            ->orderBy(DB::raw('IF(cc.Status=0 || cc.Status=1, cc.Priority, false)'), 'ASC')
            ->orderBy('cc.ID', 'DESC')
            ->get();

        $newSupport=DB::table('customer_conversation')
            ->select('CustomerID','Status')
            ->where('CustomerID',$id)
            ->where('Status','1')
            ->get()
            ->count();

        $alarmMsg=DB::table('customer_alarm_msg')
            ->select('*')
            ->where('CustomerID',$id)
            ->get();

        $supportPersianDate = array();
        foreach ($support as $key => $rec) {
            $d = $rec->Date;
            $supportPersianDate[$key] = $this->convertDateToPersian($d);
        }

        return view('Administrator.Customer.ControlPanel', compact('customerInfo',
            'tab','alarmMsg','support','supportPersianDate','newSupport'));
    }

    public function saleTableLoad($val, $customerId)
    {
        if ($val === 'all') {

            $generalInfo = array(
                'todayOrder' => 0,
                'monthOrder' => 0,
                'allOrder' => 0,
                'totalSaleAmount' => 0);

            $data = DB::table('product_order_detail as pod')
                ->select('pod.*', 'po.*', 'pod.ID as orderDetailID', 'po.ID as orderID', 'c.ID as customerID', 'p.Gender as Gender', 'p.Name as Name', 'p.FinalPrice as FinalPrice', 'p.PicPath as PicPath', 'fp.id as fpID', 'pd.ID as pDetailID','pd.SampleNumber')
                ->leftjoin('product_order as po', 'po.ID', '=', 'pod.OrderID')
                ->leftjoin('customers as c', 'c.ID', '=', 'po.CustomerID')
                ->leftjoin('product_false as fp', 'fp.ProductDetailID', '=', 'pod.ProductDetailID')
                ->leftjoin('product_detail as pd', 'pd.ID', '=', 'pod.ProductDetailID')
                ->leftjoin('product as p', 'p.ID', '=', 'pod.ProductID')
                ->where('po.CustomerID', $customerId)
                ->get();

            foreach ($data as $d) {
                $createOrder = $d->Date; // Get Order Table Column Date and Convert String Date To Object Date
                $date = new DateTime($createOrder);
                $today = new DateTime();
                $dateOrder = $date->diff($today)->format("%d");

                if ($dateOrder == 0) $generalInfo['todayOrder'] += 1;
                if (($dateOrder == 0) || ($dateOrder < 30)) $generalInfo['monthOrder'] += 1;

                $generalInfo['allOrder'] += 1;

                $generalInfo['totalSaleAmount'] += ($d->FinalPrice * $d->Qty);
            }

            return $generalInfo;
        }

        if ($val === 'pagination') {
            $data = DB::table('product_order_detail as pod')
                ->select('pod.*', 'po.*', 'pod.ID as orderDetailID', 'po.ID as orderID', 'c.ID as customerID', 'p.Gender as Gender', 'p.Name as Name', 'p.FinalPrice as FinalPrice', 'p.PicPath as PicPath', 'fp.id as fpID', 'pd.ID as pDetailID','pd.SampleNumber')
                ->leftjoin('product_order as po', 'po.ID', '=', 'pod.OrderID')
                ->leftjoin('customers as c', 'c.ID', '=', 'po.CustomerID')
                ->leftjoin('product_false as fp', 'fp.ProductDetailID', '=', 'pod.ProductDetailID')
                ->leftjoin('product_detail as pd', 'pd.ID', '=', 'pod.ProductDetailID')
                ->leftjoin('product as p', 'p.ID', '=', 'pod.ProductID')
                ->where('po.CustomerID', $customerId)
                ->orderby('pod.ID','DESC')
                ->paginate(10);

            return $data;
        }
    }

    public function orderDetail($addressID, $id)
    {
//      Get Customer Data
        $dataDetail = DB::table('customer_address')
            ->where('ID', $addressID)
            ->first();

        // Get Product Data
        $data = DB::table('product_order_detail as pod')
            ->select('pod.*', 'pod.ID as orderDetailID', 'po.*', 'p.*', 'pf.ID as falseProduct','pdd.SampleNumber','ca.*')
            ->leftJoin('product_order as po', 'po.ID', '=', 'pod.OrderID')
            ->leftJoin('product as p', 'p.ID', '=', 'pod.ProductID')
            ->leftJoin('product_detail as pdd', 'pdd.ID', '=', 'pod.ProductDetailID')
            ->leftJoin('product_false as pf', 'pf.ProductDetailID', '=', 'pod.ProductDetailID')
            ->leftjoin('customer_address as ca', 'ca.ID', '=', 'po.AddressID')
            ->where('pod.ID', $id)
            ->first();

        // Get Product False State
        $falseProduct = DB::table('product_false')
            ->where('ProductDetailID', $data->ProductDetailID)
            ->first();

        // Convert Date
        $d = $data->Date;
        $persianDate = $this->convertDateToPersian($d);

        return view('Administrator.Customer.OrderDetail', compact('data', 'falseProduct', 'persianDate','dataDetail'));
    }

    public function mobileSearch($mobile)
    {
        $output = '';
        $data = DB::table('customers')
            ->select('Mobile', 'id')
            ->where('Mobile', 'like', $mobile . '%')
            ->get();

        foreach ($data as $key => $row) {
            $output .= '<li style="border-radius: 0 !important;"
                        class="list-group-item g-color-gray-dark-v3 g-letter-spacing-0 g-opacity-0_8--hover">
                            <a  href="' . route('customerControlPanel',['id'=>$row->id,'tab'=>'all']) . '"
                                style="text-decoration: none"
                                class="col-12 p-0 text-left g-color-gray-dark-v3 g-color-primary--hover">
                             ' . $row->Mobile . '
                            </a>
                        </li>';
        }

        return $output;
    }

    public function support()
    {
        $support = DB::table('customer_conversation as sc')
            ->select('sc.*',
                'scd.QuestionDate as qDate',
                'scd.QuestionTime as qTime',
                'scd.AnswerDate as aDate',
                'scd.AnswerTime as aTime',
                'scd.Replay',
                'scd.ConversationID',
                'c.name',
                'c.Family',
                'scd.ID as conversationDetailID')
            ->leftJoin('customer_conversation_detail as scd', 'scd.ConversationID', '=', 'sc.ID')
            ->leftJoin('customers as c', 'sc.CustomerID', '=', 'c.id')
            ->orderBy('sc.Status')
            ->orderBy(DB::raw('IF(sc.Status=0 || sc.Status=1, sc.Priority, false)'), 'ASC')
            ->orderBy('sc.ID', 'DESC')
            ->get();

        $newSupport = DB::table('customer_conversation')
            ->select('CustomerID', 'Status')
            ->where('Status', '1')
            ->get()
            ->count();

        $alarmMsg=DB::table('customer_alarm_msg')
            ->select('*')
            ->where('CustomerID',-1)
            ->get();

        $supportPersianDate = array();
        foreach ($support as $key => $rec) {
            $d = $rec->Date;
            $supportPersianDate[$key] = $this->convertDateToPersian($d);
        }

        return view('Administrator.Customer.Support', compact('support', 'supportPersianDate', 'newSupport','alarmMsg'));
    }

    public function connectionDetail($id, $status)
    {
        $data = DB::table('customer_conversation_detail as ccd')
            ->select('ccd.*', 'cc.Subject', 'cc.Status', 'cc.ID as ConversationID', 'cc.CustomerID', 'c.Name', 'c.Family')
            ->leftJoin('customer_conversation as cc', 'cc.ID', '=', 'ccd.ConversationID')
            ->leftJoin('customers as c', 'c.ID', '=', 'cc.CustomerID')
            ->where('ccd.ConversationID', $id)
            ->paginate(10);
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

        return view('Administrator.Customer.ConnectionDetail', compact('data', 'answerHowDay', 'questionHowDay', 'qPersianDate', 'aPersianDate'));
    }

    public function connectionNewMsg(Request $request)
    {

        date_default_timezone_set('Asia/Tehran');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $title = $request->get('title');
        $customerID = $request->get('customerId');
        $answer = $request->get('answer');
        $detailId = $request->get('detailId');
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
            ->update(['Status' => 0]);
        $conversationDetailID = DB::table('customer_conversation_detail')
            ->select('ID','Answer','ConversationID','Replay')
            ->where('ID',$detailId)
            ->first();

        if ($conversationDetailID->Answer !=='') {
            DB::table('customer_conversation_detail')->insert([
                [
                    'ConversationID' => $conversationDetailID->ConversationID,
                    'Answer' => $answer,
                    'AnswerDate' => $date,
                    'AnswerTime' => $time,
                    'Replay' => 1,
                ],
            ]);
        } else {
            DB::table('customer_conversation_detail')
                ->where('ID', $detailId)
                ->update([
                    'Answer' => $answer,
                    'AnswerDate' => $date,
                    'AnswerTime' => $time,
                    'Replay' => 1,
                ]);
        }

        return redirect()->route('adminCustomerConnectionDetail', ['id' => $conversationID, 'status' => '0']);
    }

    public function adminToCustomersMsg(Request $request)
    {
        $title = $request->get('title');
        $priority = $request->get('priority');
        $section = $request->get('section');
        $msg = $request->get('msg');
        $link = $request->get('msgLink');
        $userID = $request->get('userID');
        $mobile = $request->get('mobile');

        DB::table('customer_alarm_msg')
            ->insert([
                'CustomerID'=>$userID==='all'?-1:(int)$userID,
                'Title'=>$title,
                'Priority'=>$priority,
                'Section'=>$section,
                'Message'=>$msg,
            ]);

        if ($userID==='all'){
            $customers=DB::table('customers')
                ->select('id','Mobile')
                ->get();

            foreach ($customers as $key => $row){
                try {
                    $api_key = Config::get('kavenegar.apikey');
                    $var = new Kavenegar\KavenegarApi($api_key);
                    $template = "adminToUserSM";
                    $type = "sms";

                    $result = $var->VerifyLookup($row->Mobile, $link, null, null, $template, $type);
                } catch (\Kavenegar\Exceptions\ApiException $e) {
                    // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                    echo $e->errorMessage();
                } catch (\Kavenegar\Exceptions\HttpException $e) {
                    // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                    echo $e->errorMessage();
                }
            }
            return redirect()->route('customerSupport')->with('status', 'success');
        } else {
            try {
                $api_key = Config::get('kavenegar.apikey');
                $var = new Kavenegar\KavenegarApi($api_key);
                $template = "adminToUserSM";
                $type = "sms";

                $result = $var->VerifyLookup($mobile, $link, null, null, $template, $type);
            } catch (\Kavenegar\Exceptions\ApiException $e) {
                // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                echo $e->errorMessage();
            } catch (\Kavenegar\Exceptions\HttpException $e) {
                // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
            return redirect()->route('customerControlPanel',[$userID,'support'])->with('status', 'success');
        }
    }

    public function sale($id)
    {
        $customerInfo = DB::table('customers')
            ->select('*')
            ->where('id', $id)
            ->first();

        $saleSum = $this->saleTableLoad( 'all', $id);
        $saleTable = $this->saleTableLoad('pagination', $id);

        $persianDate = array();
        $pf='';
        foreach ($saleTable as $key => $rec) {
            $d = $rec->Date;
            $persianDate[$key] = $this->convertDateToPersian($d);
            if(isset($rec->fpID))
                $pf='error';
        }

        return view('Administrator.Customer.Sale',compact('customerInfo','saleSum', 'saleTable', 'persianDate','pf'));
    }

    public function return($customerID)
    {
        $customerInfo = DB::table('customers')
            ->select('*')
            ->where('id', $customerID)
            ->first();

        $data = DB::table('product_return as pr')
            ->select('pod.*', 'po.*', 'pod.ID as orderDetailID', 'po.ID as orderID', 'p.Gender as Gender', 'p.Name as Name'
                , 'p.PriceWithDiscount', 'p.PriceWithDiscount', 'p.PicPath as PicPath',  'pd.ID as pDetailID', 'pd.SampleNumber', 'p.Brand','pr.*','pr.Date as returnDate')
            ->leftjoin('product_order_detail as pod', 'pod.ID', '=', 'pr.OrderDetailID')
            ->leftjoin('product_order as po', 'po.ID', '=', 'pod.OrderID')
            ->leftjoin('product_detail as pd', 'pd.ID', '=', 'pod.ProductDetailID')
            ->leftjoin('product as p', 'p.ID', '=', 'pod.ProductID')
            ->where('po.CustomerID', $customerID)
            ->orderby('returnDate', 'ASC')
            ->paginate(10);

        //      Convert Date
        $persianDate = array();
        $returnPersianDate = array();
        foreach ($data as $key => $rec) {
            $returnPersianDate[$key] = $this->convertDateToPersian($rec->Date);
            $persianDate[$key] = $this->convertDateToPersian($rec->returnDate);
        }

        return view('Administrator.Customer.ReturnProduct', compact('data','persianDate','returnPersianDate','customerInfo'));
    }

    public function accountBlock($id, $status)
    {
        switch ($status) {
            case 'on':
                DB::table('customers')
                    ->where('id', $id)
                    ->update([
                        'status' => 0,
                    ]);
                break;
            case 'off':
                DB::table('customers')
                    ->where('id', $id)
                    ->update([
                        'status' => 1,
                    ]);
                break;
        }

        return $status;
    }

// --------------------------------------------[ MY FUNCTION ]----------------------------------------------------------

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

    public function convertDateToGregorian($d)
    {
        return Verta::getGregorian($d->y, $d->m, $d->d);
    }

    public function addZero($d)
    {
        for ($i = 0; $i < 3; $i++)
            if (strlen($d[$i]) < 2)
                $d[$i] = '0' . $d[$i];

        return $d[0] . '-' . $d[1] . '-' . $d[2];
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
}
