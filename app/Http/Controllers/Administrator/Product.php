<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Picture;
use Illuminate\Support\Facades\Auth;
use DateTime;
use File;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Controller
{
    public function __construct()
    {
        $this->middleware('IsAdmin');
    }

    public function delivery()
    {
        $delivery = DB::table('product_delivery as pd')
            ->select('pod.*', 'po.*', 'p.Name', 'p.PicPath','pd.*','pdd.SampleNumber')
            ->leftJoin('product_order_detail as pod', 'pod.ID', '=', 'pd.OrderDetailID')
            ->leftJoin('product_order as po', 'po.ID', '=', 'pod.OrderID')
            ->leftJoin('product_detail as pdd', 'pdd.ID', '=', 'pod.ProductDetailID')
            ->leftJoin('product as p', 'p.ID', '=', 'pod.ProductID')
            ->where('pd.DeliveryStatus','<','4')
            ->where('pd.DeliveryStatus','<>','-1')
            ->paginate(10);

        $today = date('Y-m-d');
        $deliverPersianDate = array();
        $deliveryStatus = array();
        foreach ($delivery as $key => $row) {
            $rowDate = strtotime($row->Date . ' ' . $row->Time);
            $orderDate = date('Y-m-d', $rowDate);
            $reservation = date('Y-m-d', strtotime($row->Date . ' + 1 days'));

            if (($orderDate < $today))
                $deliveryStatus[$key] = $this->dateLenToNow($reservation, '08:00:00'); // get len past date to now by min
            else
                $deliveryStatus[$key] = 0; // get len past date to now by min

            $d = $row->Date;
            $deliverPersianDate[$key] = $this->convertDateToPersian($d);
        }

        return view('Administrator.Product.Delivery',compact('delivery','deliveryStatus','deliverPersianDate'));
    }

    public function storeTableLoad($val)
    {
        if ($val === 'all') {
            $generalInfo = array(
                'sumFPrice' => '0',
                'allQty' => '0',
                'female' => '0',
                'male' => '0',
                'girl' => '0',
                'boy' => '0',
                'babyGirl' => '0',
                'babyBoy' => '0',
                'avgRating' => '0');

            $data = DB::table('product as p')
                ->select('p.*', 'pod.ID as orderID', 'fp.ID as fpID', 'pd.ID as pDetailID', 'pd.Qty', 'pd.Size', 'pd.Color', 'pd.SampleNumber')
                ->leftjoin('product_detail as pd', 'p.ID', '=', 'pd.ProductID')
                ->leftJoin('product_order_detail as pod', 'pd.ID', '=', 'pod.ProductDetailID')
                ->leftJoin('product_false as fp', 'pd.ID', '=', 'fp.ProductDetailID')
                ->groupBy('pd.ID')
                ->get();

            foreach ($data as $d) {
                $generalInfo['sumFPrice'] += $d->Qty * $d->FinalPrice;
                $generalInfo['allQty'] += $d->Qty;
                if ($d->Gender === 'زنانه')
                    $generalInfo['female'] += $d->Qty;
                elseif ($d->Gender === 'مردانه')
                    $generalInfo['male'] += $d->Qty;
                elseif ($d->Gender === 'دخترانه')
                    $generalInfo['girl'] += $d->Qty;
                elseif ($d->Gender === 'پسرانه')
                    $generalInfo['boy'] += $d->Qty;
                elseif ($d->Gender === 'نوزادی پسرانه')
                    $generalInfo['babyGirl'] += $d->Qty;
                else
                    $generalInfo['babyBoy'] += $d->Qty;
            }

            return $generalInfo;
        }

        if ($val === 'pagination') {
            $data = DB::table('product as p')
                ->select('p.*', 'pod.ID as orderID', 'fp.ID as fpID', 'pd.ID as pDetailID', 'pd.Qty', 'pd.Size', 'pd.Color', 'pd.SampleNumber')
                ->leftjoin('product_detail as pd', 'p.ID', '=', 'pd.ProductID')
                ->join('product_order_detail as pod', 'pd.ID', '=', 'pod.ProductDetailID', 'left outer')
                ->join('product_false as fp', 'pd.ID', '=', 'fp.ProductDetailID', 'left outer')
                ->orderby('pd.ID','DESC')
                ->groupBy('pd.ID')
                ->paginate(10);

            return $data;
        }
    }

    public function saleTableLoad($val)
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
                ->leftjoin('product_false as fp', 'fp.ProductDetailID', '=', 'pod.ProductDetailID')
                ->leftjoin('product_detail as pd', 'pd.ID', '=', 'pod.ProductDetailID')
                ->leftjoin('product as p', 'p.ID', '=', 'pod.ProductID')
                ->leftjoin('customers as c', 'c.id', '=', 'po.CustomerID')
                ->get();

            foreach ($data as $d) {
                $createOrder = $d->Date; // Get Order Table Column Date and Convert String Date To Object Date
                $date = new DateTime($createOrder);
                $today = new DateTime();
                $dateOrder = $date->diff($today)->format("%y%m%d");
                if ($dateOrder == 0) $generalInfo['todayOrder'] += 1;
                if (($dateOrder == 0) || ($dateOrder < 30)) $generalInfo['monthOrder'] += 1;

                $generalInfo['allOrder'] += 1;

                $generalInfo['totalSaleAmount'] += ($d->OrderDetailFinalPrice * $d->Qty);
            }

            return $generalInfo;
        }

        if ($val === 'pagination') {
            $data = DB::table('product_order_detail as pod')
                ->select('pod.*', 'po.*', 'pod.ID as orderDetailID', 'po.ID as orderID', 'c.ID as customerID','c.Mobile as customerMobile', 'p.Gender as Gender', 'p.Name as Name', 'p.FinalPrice as FinalPrice', 'p.PicPath as PicPath', 'fp.id as fpID', 'pd.ID as pDetailID','pd.SampleNumber')
                ->leftjoin('product_order as po', 'po.ID', '=', 'pod.OrderID')
                ->leftjoin('customers as c', 'c.ID', '=', 'po.CustomerID')
                ->leftjoin('product_false as fp', 'fp.ProductDetailID', '=', 'pod.ProductDetailID')
                ->leftjoin('product_detail as pd', 'pd.ID', '=', 'pod.ProductDetailID')
                ->leftjoin('product as p', 'p.ID', '=', 'pod.ProductID')
                ->orderby('pod.ID','DESC')
                ->paginate(10);

            return $data;
        }
    }

    public function productDetail($id)
    {
        // Get Product Data Detail
        $dataDetail = DB::table('product_detail as pd')
            ->select('pd.*', 'pod.ID as orderDetailID', 'pod.OrderID')
            ->leftJoin('product_order_detail as pod', 'pod.ProductDetailID', '=', 'pd.ID')
            ->where('pd.ID', $id)
            ->first();

        // Get Product Data
        $ProductID = $dataDetail->ProductID;
        $data = DB::table('product')
            ->where('ID', $ProductID)
            ->first();

        // Get Product False State
        $falseProduct = DB::table('product_false')
            ->where('ProductDetailID', $id)
            ->first();

        return view('Administrator.Product.ProductDetail', compact('data', 'dataDetail', 'falseProduct'));
    }

    public function orderDetail($addressID, $id)
    {
//      Get Customer Data
        $dataDetail = DB::table('customer_address')
            ->where('ID', $addressID)
            ->first();

        // Get Product Data
        $data = DB::table('product_order_detail as pod')
            ->select('pod.*', 'pod.ID as orderDetailID', 'po.ID as orderID', 'po.Date', 'p.*', 'pf.ID as falseProduct','pdd.SampleNumber')
            ->leftJoin('product_order as po', 'po.ID', '=', 'pod.OrderID')
            ->leftJoin('product as p', 'p.ID', '=', 'pod.ProductID')
            ->leftJoin('product_detail as pdd', 'pdd.ID', '=', 'pod.ProductDetailID')
            ->leftJoin('product_false as pf', 'pf.ProductDetailID', '=', 'pod.ProductDetailID')
            ->where('pod.ID', $id)
            ->first();
        // Get Product False State
        $falseProduct = DB::table('product_false')
            ->where('ProductDetailID', $data->ProductDetailID)
            ->first();

        // Convert Date
        $d = $data->Date;
        $persianDate = $this->convertDateToPersian($d);

        return view('Administrator.Product.OrderDetail', compact('data', 'falseProduct', 'persianDate','dataDetail'));
    }

    public function store()
    {
        $storeSum = $this->storeTableLoad('all');
        $storeTable = $this->storeTableLoad('pagination');
        return view('Administrator.Product.Store',compact('storeSum','storeTable'));
    }

    public function sale()
    {
        $saleSum = $this->saleTableLoad( 'all');
        $saleTable = $this->saleTableLoad('pagination');
        $persianDate = array();
        $pf='';
        foreach ($saleTable as $key => $rec) {
            $d = $rec->Date;
            $persianDate[$key] = $this->convertDateToPersian($d);
            if(isset($rec->fpID))
                $pf='error';
        }
        return view('Administrator.Product.Sale',compact('saleSum','saleTable','persianDate','pf'));
    }

    public function return()
    {
        $data = DB::table('product_return as pr')
            ->select('pod.*', 'po.*', 'pod.ID as orderDetailID', 'po.ID as orderID', 'p.Gender as Gender', 'p.Name as Name'
                , 'p.PriceWithDiscount', 'p.PriceWithDiscount', 'p.PicPath as PicPath',  'pd.ID as pDetailID', 'pd.SampleNumber', 'p.Brand','pr.*','pr.Date as returnDate')
            ->leftjoin('product_order_detail as pod', 'pod.ID', '=', 'pr.OrderDetailID')
            ->leftjoin('product_order as po', 'po.ID', '=', 'pod.OrderID')
            ->leftjoin('product_detail as pd', 'pd.ID', '=', 'pod.ProductDetailID')
            ->leftjoin('product as p', 'p.ID', '=', 'pod.ProductID')
            ->orderby('returnDate', 'ASC')
            ->paginate(10);

        //      Convert Date
        $persianDate = array();
        $returnPersianDate = array();
        foreach ($data as $key => $rec) {
            $returnPersianDate[$key] = $this->convertDateToPersian($rec->Date);
            $persianDate[$key] = $this->convertDateToPersian($rec->returnDate);
        }

        return view('Administrator.Product.ReturnProduct', compact('data','persianDate','returnPersianDate'));
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
