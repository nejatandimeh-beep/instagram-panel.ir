<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Picture;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use DateTime;
use File;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Kavenegar;

class SellerMajor extends Controller
{
    public function adList()
    {
        $data = DB::table('ad_list as adc')
            ->select('adc.*', 's.name')
            ->leftJoin('sellersmajor as s', 's.id', 'adc.SellerMajorID')
            ->get();

        $adGroup=DB::table('ad_list_source')
            ->select('*')
            ->get();

        $acceptList=DB::table('ad_accept')
            ->select('*')
            ->get();

        $cancelList=DB::table('ad_cancel')
            ->select('*')
            ->get();

        return view('Administrator.SellerMajor.Ad', compact('data','adGroup','acceptList','cancelList'));
    }

    public function startAd()
    {
        $data = DB::table('ad_list as adc')
            ->select('adc.*', 'sp.Pic', 's.Instagram', 'sp.ID as postID', 's.Mobile', 's.name','s.id as sellerMajorID')
            ->leftJoin('sellersmajor as s', 's.id', 'adc.SellerMajorID')
            ->leftJoin('seller_major_post as sp', 'sp.SellerMajorID', 'adc.SellerMajorID')
            ->groupBy('adc.ID')
            ->get();

        $adLen = count($data);
        $loopLen = $adLen % 2 === 0 ? $adLen : $adLen - 1;
        $arr1 = array();
        $arr2 = array();
        for ($i = $loopLen - 1; $i >= 0; $i = $i - 2) {
            $arr1[$i] = $data[$i];
            $arr2[$i - 1] = $data[$i - 1];
        }
        DB::table('ad_list')
            ->insert([
                'SellerMajorID' => $data[0]->SellerMajorID,
                'PostID' => $data[0]->PostID,
                'Instagram' => $data[0]->Instagram,
            ]);
        DB::table('ad_list')
            ->where('ID', $data[0]->ID)
            ->delete();
        $arr1 = array_values($arr1);
        $arr2 = array_values($arr2);
        DB::table('ad_list_source')->truncate();
        DB::table('ad_cancel')->truncate();
        foreach ($arr1 as $key => $a1) {
            $link = '/SMA/' . $arr2[$key]->sellerMajorID;
            DB::table('ad_list_source')
                ->insert([
                    'SellerMajorID'=>$arr2[$key]->sellerMajorID,
                    'SellerMajorID_AD'=>$a1->sellerMajorID,
                    'PostID'=>$a1->PostID,
                    'Instagram'=>$arr2[$key]->Instagram,
                    'Instagram_AD'=>$a1->Instagram,
                    'Pic_AD'=>str_replace('-', '/', $a1->Pic),
                    'Link'=>$link,
                ]);
            try {
                $api_key = Config::get('kavenegar.apikey');
                $var = new Kavenegar\KavenegarApi($api_key);
                $template = "adSource";
                $type = "sms";

                $result = $var->VerifyLookup($arr2[$key]->Mobile, $link, null, null, $template, $type);
            } catch (\Kavenegar\Exceptions\ApiException $e) {
                // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                echo $e->errorMessage();
            } catch (\Kavenegar\Exceptions\HttpException $e) {
                // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
        }
        foreach ($arr2 as $key => $a2) {
            $link = '/SMA/' . $arr1[$key]->sellerMajorID;
            DB::table('ad_list_source')
                ->insert([
                    'SellerMajorID'=>$arr1[$key]->sellerMajorID,
                    'SellerMajorID_AD'=>$a2->sellerMajorID,
                    'PostID'=>$a2->PostID,
                    'Instagram'=>$arr1[$key]->Instagram,
                    'Instagram_AD'=>$a2->Instagram,
                    'Pic_AD'=>str_replace('-', '/', $a2->Pic),
                    'Link'=>$link,
                ]);
            try {
                $api_key = Config::get('kavenegar.apikey');
                $var = new Kavenegar\KavenegarApi($api_key);
                $template = "adSource";
                $type = "sms";

                $result = $var->VerifyLookup($arr1[$key]->Mobile, $link, null, null, $template, $type);
            } catch (\Kavenegar\Exceptions\ApiException $e) {
                // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                echo $e->errorMessage();
            } catch (\Kavenegar\Exceptions\HttpException $e) {
                // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
        }
        dd('success');
    }

    public function adSource($id)
    {
        if (!isset(Auth::guard('sellerMajor')->user()->id)) {
            Auth::guard('sellerMajor')->loginUsingId($id, true);
        }
        $data=DB::table('ad_list_source as ads')
            ->select('ads.*','s.id','s.Mobile','s.Pic','ads.ID as ListSourceID','aa.ID as accept','aa.AcceptorID')
            ->leftJoin('sellersmajor as s','s.id','ads.SellerMajorID_AD')
            ->leftJoin('ad_accept as aa','aa.ListSourceID','ads.ID')
            ->where('ads.SellerMajorID',$id)
            ->first();

        $cancelData=DB::table('ad_cancel')
            ->where('SellerMajorID',$id)
            ->orWhere('SellerMajorID_AD',$id)
            ->first();

        $cancelRemaining=DB::table('ad_cancel_history')
            ->select('*')
            ->where('SellerMajorID',$id)
            ->get()->count();

        $cancelRemaining=10-$cancelRemaining;
        if(isset($data->ID)){
            $instagram=$data->Instagram;
            $instagram_ad=$data->Instagram_AD;
            $pic = $data->Pic_AD . '/' . $data->PostID . '/0.jpg';
            $mobile=$data->Mobile;
            $sellerMajorID_ad=$data->SellerMajorID_AD;
            $sellerMajorID=$data->SellerMajorID;
            $listSourceID=$data->ListSourceID;
            $cancel=isset($cancelData->ID)?$cancelData->ID:null;
            $canceller=isset($cancelData->CancellerID)?$cancelData->CancellerID:null;
            $accept=$data->accept;
            $acceptor=$data->AcceptorID;
        }
        try {
            return view('Administrator.SellerMajor.AdSource',
                compact('instagram','instagram_ad', 'pic','mobile','cancel', 'canceller',
                    'listSourceID','sellerMajorID','sellerMajorID_ad','cancelRemaining','accept','acceptor'));
        } catch (\Exception $e) {
            return redirect('/Seller-Major-Panel')->with('advertising','null');
        }

    }

    public function support()
    {
        $support = DB::table('seller_major_conversation as sc')
            ->select('sc.*',
                'scd.QuestionDate as qDate',
                'scd.QuestionTime as qTime',
                'scd.AnswerDate as aDate',
                'scd.AnswerTime as aTime',
                'scd.Replay',
                'scd.ConversationID',
                'scd.ID as conversationDetailID')
            ->leftJoin('seller_major_conversation_detail as scd', 'scd.ConversationID', '=', 'sc.ID')
            ->orderBy('sc.Status')
            ->orderBy(DB::raw('IF(sc.Status=0 || sc.Status=1, sc.Priority, false)'), 'ASC')
            ->orderBy('sc.ID', 'DESC')
            ->get();

        $newSupport = DB::table('seller_major_conversation')
            ->select('SellerMajorID', 'Status')
            ->where('Status', '1')
            ->get()
            ->count();

        $alarmMsg = DB::table('seller_major_alarm_msg')
            ->select('*')
            ->where('SellerMajorID', -1)
            ->get();

        $supportPersianDate = array();
        foreach ($support as $key => $rec) {
            $d = $rec->Date;
            $supportPersianDate[$key] = $this->convertDateToPersian($d);
        }

        return view('Administrator.SellerMajor.Support', compact('support', 'supportPersianDate', 'newSupport', 'alarmMsg'));
    }

    public function connectionDetail($id, $status)
    {
        $data = DB::table('seller_major_conversation_detail as ccd')
            ->select('ccd.*', 'cc.Subject', 'cc.Status', 'cc.ID as ConversationID', 'cc.SellerMajorID', 's.Name')
            ->leftJoin('seller_major_conversation as cc', 'cc.ID', '=', 'ccd.ConversationID')
            ->leftJoin('sellersmajor as s', 's.ID', '=', 'cc.SellerMajorID')
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

        return view('Administrator.SellerMajor.ConnectionDetail', compact('data', 'answerHowDay', 'questionHowDay', 'qPersianDate', 'aPersianDate'));
    }

    public function connectionNew(Request $request)
    {
        $title = $request->get('title');
        $priority = $request->get('priority');
        $section = $request->get('section');

        return view('Administrator.SellerMajor.ConnectionDetail', compact('title', 'priority', 'section'));
    }

    public function connectionNewMsg(Request $request)
    {

        date_default_timezone_set('Asia/Tehran');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $title = $request->get('title');
        $sellerMajorID = $request->get('sellerMajorID');
        $answer = $request->get('answer');
        $detailId = $request->get('detailId');
        if (isset($title)) {
            $priority = $request->get('priority');
            $section = $request->get('section');
            // Insert Data to Conversation
            DB::table('seller_major_conversation')->insert([
                [
                    'SellerMajorID' => $sellerMajorID,
                    'Subject' => $title,
                    'Section' => $section,
                    'priority' => $priority,
                    'Status' => 1,
                    'Date' => $date,
                    'Time' => $time,
                ],
            ]);

            $conversationID = DB::table('seller_major_conversation')
                ->select('ID')
                ->latest('ID')
                ->first();

            $conversationID = $conversationID->ID;
        } else {
            $conversationID = $request->get('conversationID');
        }
        DB::table('seller_major_conversation')
            ->where('ID', $conversationID)
            ->update(['Status' => 0]);
        $conversationDetailID = DB::table('seller_major_conversation_detail')
            ->select('ID', 'Answer', 'ConversationID', 'Replay')
            ->where('ID', $detailId)
            ->first();

        if ($conversationDetailID->Answer !== '') {
            DB::table('seller_major_conversation_detail')->insert([
                [
                    'ConversationID' => $conversationDetailID->ConversationID,
                    'Answer' => $answer,
                    'AnswerDate' => $date,
                    'AnswerTime' => $time,
                    'Replay' => 1,
                ],
            ]);
        } else {
            DB::table('seller_major_conversation_detail')
                ->where('ID', $detailId)
                ->update([
                    'Answer' => $answer,
                    'AnswerDate' => $date,
                    'AnswerTime' => $time,
                    'Replay' => 1,
                ]);
        }

        return redirect()->route('adminSellerMajorConnectionDetail', ['id' => $conversationID, 'status' => '0']);
    }

    public function list()
    {
        $data = DB::table('sellersmajor as s')
            ->select('*')
            ->get();

        $newSupportSellerMajor = DB::table('seller_major_conversation')
            ->select('SellerMajorID', 'Status')
            ->where('Status', '1')
            ->get()
            ->count();

        return view('Administrator.SellerMajor.SellerMajor', compact('data', 'newSupportSellerMajor'));
    }

    public function controlPanel($id, $tab)
    {
        $sellerMajorInfo = DB::table('sellersmajor')
            ->select('*')
            ->where('id', $id)
            ->first();

        $support = DB::table('seller_major_conversation as sc')
            ->select('sc.*',
                'scd.QuestionDate as qDate',
                'scd.QuestionTime as qTime',
                'scd.AnswerDate as aDate',
                'scd.AnswerTime as aTime',
                'scd.Replay',
                'scd.ConversationID',
                'scd.ID as conversationDetailID')
            ->leftJoin('seller_major_conversation_detail as scd', 'scd.ConversationID', '=', 'sc.ID')
            ->orderBy('sc.Status')
            ->orderBy(DB::raw('IF(sc.Status=0 || sc.Status=1, sc.Priority, false)'), 'ASC')
            ->orderBy('sc.ID', 'DESC')
            ->get();

        $newSupport = DB::table('seller_major_conversation')
            ->select('SellerMajorID', 'Status')
            ->where('Status', '1')
            ->get()
            ->count();

        $alarmMsg = DB::table('seller_major_alarm_msg')
            ->select('*')
            ->where('SellerMajorID', $id)
            ->get();

        $supportPersianDate = array();
        foreach ($support as $key => $rec) {
            $d = $rec->Date;
            $supportPersianDate[$key] = $this->convertDateToPersian($d);
        }

        return view('Administrator.SellerMajor.ControlPanel', compact('sellerMajorInfo', 'support', 'newSupport', 'supportPersianDate', 'tab', 'alarmMsg'));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        DB::table('sellersmajor')
            ->where('id', $id)
            ->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'HintCategory' => $request->get('hintCategory'),
                'Category' => $request->get('category'),
                'Instagram' => $request->get('instaAccount'),
                'Telegram' => $request->get('telegramAccount'),
                'Bio' => $request->get('bio'),
                'Address' => $request->get('address'),
                'Pic' => $request->get('userImage'),
            ]);

        return redirect()->route('sellerMajorControlPanel', ['id' => $id, 'tab' => 'userInfo']);
    }

    //-----------------------------------------------seller major panel------------------------------------------//
    public function removeEvent($item)
    {
        $data = DB::table('seller_major_event')
            ->select('ID', 'Pic')
            ->where('ID', $item)
            ->first();

        File::delete(public_path($data->Pic . '/' . $item . '.jpg'));

        DB::table('seller_major_event_visit')
            ->where('EventID', $item)
            ->delete();

        DB::table('seller_major_event')
            ->where('ID', $item)
            ->delete();

        return redirect()->route('sellerMajorPanel');
    }

    public function removeProfileImage()
    {
        $data = $this->sellerMajorData;

        File::deleteDirectory(public_path($data->Pic));

        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->update([
                'Pic' => '',
            ]);

        return redirect()->route('sellerMajorPanel');
    }

    public function messages($id)
    {
        $data = DB::table('sellersmajor')
            ->select('*')
            ->where('id', $id)
            ->first();

        $msg = DB::table('seller_major_msg as m')
            ->select('m.*', 'm.ID as msgID', 'md.ID', 'md.Time', 'md.MessageID', 'c.PicPath', 'c.name', 'c.id as customerID')
            ->leftJoin('seller_major_msg_detail as md', 'md.MessageID', 'm.ID')
            ->leftJoin('customers as c', 'c.id', 'm.CustomerID')
            ->where('m.SellerMajorID', $id)
            ->orderBy('md.ID', 'DESC')
            ->groupBy('m.CustomerID')
            ->get();

        $date = array();
        $time = array();
        $howDay = array();
        foreach ($msg as $key => $rec) {
            $temp = explode(' ', $rec->Time);
            $date[$key] = $this->convertDateToPersian($temp[0]);
            $date[$key] = $this->addZero($date[$key]);
            $time[$key] = $this->dateLenToNow($temp[0], $temp[1]);

            if ($time[$key] < 11520) {
                $howDay[$key] = $this->howDays($time[$key]);
            } else {
                $howDay[$key] = $date[$key];
            }
        }

        session_start();
        $_SESSION['userProfileID'] = $data->id;
        $_SESSION['userProfileImg'] = $data->Pic;
        $_SESSION['jobCategory'] = $data->Category;
        $_SESSION['userName'] = $data->name;
        return view('Administrator.SellerMajor.Messages', compact('msg', 'howDay'));
    }

    public function messagesDetail(Request $request)
    {
        $sellerMajorID = $request->get('sellerMajorID');
        $data = DB::table('sellersmajor')
            ->select('*')
            ->where('id', $sellerMajorID)
            ->first();
        $customerID = $request->get('customerID');
        $msg = DB::table('seller_major_msg as m')
            ->select('m.*', 'md.*', 'c.id as customerID', 'c.PicPath as customerPic', 'c.name as customerName')
            ->leftJoin('seller_major_msg_detail as md', 'md.MessageID', 'm.ID')
            ->leftJoin('seller_major_event as e', 'e.ID', 'md.EventID')
            ->leftJoin('customers as c', 'c.id', 'md.CustomerID')
            ->where('m.SellerMajorID', $sellerMajorID)
            ->where('m.CustomerID', $customerID)
            ->orderBy('md.ID')
            ->get();

        $eventDate = array();
        $eventTime = array();
        $msgHowDay = array();
        foreach ($msg as $key => $rec) {
            $temp = explode(' ', $rec->Time);
            $eventDate[$key] = $this->convertDateToPersian($temp[0]);
            $eventDate[$key] = $this->addZero($eventDate[$key]);
            $eventTime[$key] = $this->dateLenToNow($temp[0], $temp[1]);

            if ($eventTime[$key] < 11520) {
                $msgHowDay[$key] = $this->howDays($eventTime[$key]);
            } else {
                $msgHowDay[$key] = $eventDate[$key];
            }
        }

        session_start();
        $_SESSION['userProfileID'] = $data->id;
        $_SESSION['userProfileImg'] = $data->Pic;
        $_SESSION['jobCategory'] = $data->Category;
        $_SESSION['userName'] = $data->name;

        return view('Administrator.SellerMajor.MessagesDetail', compact('msg', 'msgHowDay'));
    }

    public function messagesDelete($msgDetailID)
    {
        DB::table('seller_major_msg_detail')
            ->where('ID', $msgDetailID)
            ->delete();

        return 'success delete..';
    }

    public function userMsgDelete($msgID)
    {
        DB::table('seller_major_msg_detail')
            ->where('MessageID', $msgID)
            ->delete();

        DB::table('seller_major_msg')
            ->where('ID', $msgID)
            ->delete();

        return $msgID;
    }

    public function loadPost()
    {
        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic', 'pc.ID as CommentID')
            ->leftJoin('seller_major_post_like as pl', 'pl.PostID', 'p.ID')
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->where('p.SellerMajorID', $this->sellerMajorID)
            ->groupBy('p.ID')
            ->orderBy('p.ID', 'DESC')
            ->skip($_SESSION['loadPost'])
            ->take(6)
            ->get();

        $postDate = array();
        $postTime = array();
        $postHowDay = array();
        $commentCount = array();
        foreach ($posts as $key => $rec) {
            $temp = explode(' ', $rec->postTime);
            $postDate[$key] = $this->convertDateToPersian($temp[0]);
            $postDate[$key] = $this->addZero($postDate[$key]);
            $postTime[$key] = $this->dateLenToNow($temp[0], $temp[1]);

            if ($postTime[$key] < 11520) {
                $postHowDay[$key] = $this->howDays($postTime[$key]);
            } else {
                $postHowDay[$key] = $postDate[$key];
            }
            $comments = DB::table('seller_major_post_comment as pc')
                ->select('pc.ID')
                ->where('pc.PostID', $rec->postID)
                ->get()
                ->count();

            $commentsReply = DB::table('seller_major_post_comment_reply')
                ->where('PostID', $rec->postID)
                ->get()
                ->count();

            $commentCount[$key] = $comments + $commentsReply;
        }

        $startStep = $_SESSION['loadPost'];
        $_SESSION['loadPost'] = $_SESSION['loadPost'] + 6;

        return array($posts, $startStep, $postHowDay, $commentCount, $this->sellerMajorData, $_SESSION['loadPost']);
    }

    public function deletePost($postID)
    {
        DB::table('seller_major_post_visit')
            ->where('PostID', $postID)
            ->delete();

        DB::table('seller_major_post_like')
            ->where('PostID', $postID)
            ->delete();

        DB::table('seller_major_post_comment_reply_like as pcrl')
            ->leftJoin('seller_major_post_comment_reply as pcr', 'pcr.ID', 'pcrl.CommentReplyID')
            ->leftJoin('seller_major_post_comment as pc', 'pc.ID', 'pcr.CommentID')
            ->where('pc.PostID', $postID)
            ->delete();

        DB::table('seller_major_post_comment_reply as pcr')
            ->leftJoin('seller_major_post_comment as pc', 'pc.ID', 'pcr.CommentID')
            ->where('pc.PostID', $postID)
            ->delete();

        DB::table('seller_major_post_comment_like as pcl')
            ->leftJoin('seller_major_post_comment as pc', 'pc.ID', 'pcl.CommentID')
            ->where('pc.PostID', $postID)
            ->delete();

        DB::table('seller_major_post_comment')
            ->where('PostID', $postID)
            ->delete();

        DB::table('seller_major_post')
            ->where('ID', $postID)
            ->delete();

        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->decrement('Posts');
        return 'success';
    }

    public function chartPost($postID)
    {
        return array(DB::table('seller_major_post')
            ->select('*')
            ->where('ID', $postID)
            ->first());
    }

    public function addComments($postID)
    {
        $comment = DB::table('seller_major_post_comment as pc')
            ->select('*', 'pc.ID as commentId', 'p.SellerMajorID', 'c.id', 'c.PicPath', 'c.name as customerName', 'c.id as customerID', 's.name as sellerMajorName')
            ->leftJoin('seller_major_post as p', 'p.ID', 'pc.PostID')
            ->leftJoin('seller_major_post_comment_like_seller as pcl', 'pcl.CommentID', 'pc.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->leftJoin('customers as c', 'c.id', 'pc.CommenterID')
            ->where('pc.PostID', $postID)
            ->groupBy('pc.ID')
            ->get();

        $commentTime = array();
        foreach ($comment as $key => $rec) {
            $temp = explode(' ', $rec->CommentTime);
            $date[$key] = $this->convertDateToPersian($temp[0]);
            $date[$key] = $this->addZero($date[$key]);
            $time[$key] = $this->dateLenToNow($temp[0], $temp[1]);

            if ($time[$key] < 11520) {
                $commentTime[$key] = $this->howDays($time[$key]);
            } else {
                $commentTime[$key] = $date[$key];
            }
        }

        $commentReply = DB::table('seller_major_post_comment_reply as pcr')
            ->select('*', 'pcr.ID as commentReplyID', 'p.SellerMajorID', 'c.id', 'c.PicPath', 'c.name as customerName', 'c.id as customerID', 's.name as sellerMajorName')
            ->leftJoin('seller_major_post_comment as pc', 'pc.ID', 'pcr.CommentID')
            ->leftJoin('seller_major_post as p', 'p.ID', 'pc.PostID')
            ->leftJoin('seller_major_post_comment_reply_like_seller as pcrl', 'pcrl.CommentReplyID', 'pcr.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->leftJoin('customers as c', 'c.id', 'pcr.CommenterID')
            ->orderBy('pcr.ID')
            ->where('pc.PostID', $postID)
            ->get();

        $commentReplyTime = array();
        foreach ($commentReply as $key => $rec) {
            $temp = explode(' ', $rec->CommentReplyTime);
            $date[$key] = $this->convertDateToPersian($temp[0]);
            $date[$key] = $this->addZero($date[$key]);
            $time[$key] = $this->dateLenToNow($temp[0], $temp[1]);

            if ($time[$key] < 11520) {
                $commentReplyTime[$key] = $this->howDays($time[$key]);
            } else {
                $commentReplyTime[$key] = $date[$key];
            }
        }
        return array($comment, $commentTime, $commentReply, $commentReplyTime);
    }

    public function deleteComments($id, $status)
    {
        if ($status === 'comment') {
            DB::table('seller_major_post_comment_reply_like_seller')
                ->where('Comment_ID', $id)
                ->delete();
            DB::table('seller_major_post_comment_reply_like')
                ->where('Comment_ID', $id)
                ->delete();
            DB::table('seller_major_post_comment_reply')
                ->where('CommentID', $id)
                ->delete();
            DB::table('seller_major_post_comment_like_seller')
                ->where('CommentID', $id)
                ->delete();
            DB::table('seller_major_post_comment_like')
                ->where('CommentID', $id)
                ->delete();
            DB::table('seller_major_post_comment')
                ->where('ID', $id)
                ->delete();
            return array($id, $status);
        } else {
            DB::table('seller_major_post_comment_reply_like_seller')
                ->where('Comment_ID', $id)
                ->delete();
            DB::table('seller_major_post_comment_reply_like')
                ->where('Comment_ID', $id)
                ->delete();
            DB::table('seller_major_post_comment_reply')
                ->where('ID', $id)
                ->delete();
            return array($id, $status);
        }
    }

    public function reaction($id)
    {
        $data = DB::table('sellersmajor')
            ->select('*')
            ->where('id', $id)
            ->first();

        $eventLike = DB::table('seller_major_event_like as el')
            ->select('*', 'el.Time as eventLikeTime')
            ->leftJoin('seller_major_event as e', 'e.ID', 'el.EventID')
            ->leftJoin('customers as c', 'c.id', 'el.CustomerID')
            ->where('e.SellerMajorID', $id)
            ->where("el.Time", ">", Carbon::now()->subMonth(30)->toDateTimeString())
            ->orderBy('el.ID', 'DESC')
            ->get();

        $postsLike = DB::table('seller_major_post_like as pl')
            ->select('*', 'pl.Time as postLikeTime')
            ->leftJoin('seller_major_post as p', 'p.ID', 'pl.PostID')
            ->leftJoin('customers as c', 'c.id', 'pl.CustomerID')
            ->where('p.SellerMajorID', $id)
            ->where("pl.Time", ">", Carbon::now()->subMonth(30)->toDateTimeString())
            ->orderBy('pl.ID', 'DESC')
            ->get();

        $postsComment = DB::table('seller_major_post_comment as pc')
            ->select('*', 'pc.ID as commentID', 'pc.CommenterID as userId')
            ->leftJoin('seller_major_post as p', 'p.ID', 'pc.PostID')
            ->leftJoin('seller_major_post_comment_like_seller as pcls', 'pcls.CommentID', 'pc.ID')
            ->leftJoin('customers as c', 'c.id', 'pc.CommenterID')
            ->where('pc.SellerMajorID', $id)
            ->where("pc.Commenter", 'customer')
            ->where("pc.CommentTime", ">", Carbon::now()->subMonth(30)->toDateTimeString())
            ->orderBy('pc.ID', 'DESC')
            ->get();

        $postsCommentReply = DB::table('seller_major_post_comment_reply as pcr')
            ->select('*', 'pc.SellerMajorID', 'pcr.ID as commentReplyID', 'pcr.CommenterID as userId')
            ->leftJoin('seller_major_post_comment as pc', 'pc.id', 'pcr.CommentID')
            ->leftJoin('seller_major_post as p', 'p.ID', 'pc.PostID')
            ->leftJoin('seller_major_post_comment_reply_like_seller as pcrls', 'pcrls.Comment_ID', 'pc.ID')
            ->leftJoin('customers as c', 'c.id', 'pcr.CommenterID')
            ->where('pc.SellerMajorID', $id)
            ->where("pcr.CommenterReply", 'customer')
            ->where("pcr.CommentReplyTime", ">", Carbon::now()->subMonth(30)->toDateTimeString())
            ->orderBy('pcr.ID', 'DESC')
            ->get();

        $date = array();
        $time = array();
        $rowTime = array();
        $allRow = 0;
        $eventLikeHowDay = array();
        foreach ($eventLike as $key => $rec) {
            $temp = explode(' ', $rec->eventLikeTime);
            $date[$key] = $this->convertDateToPersian($temp[0]);
            $date[$key] = $this->addZero($date[$key]);
            $time[$key] = $this->dateLenToNow($temp[0], $temp[1]);
            $rowTime[$allRow] = $time[$key];
            $allRow++;
            if ($time[$key] < 11520) {
                $eventLikeHowDay[$key] = $this->howDays($time[$key]);
            } else {
                $eventLikeHowDay[$key] = $date[$key];
            }
        }

        $postsLikeHowDay = array();
        foreach ($postsLike as $key => $rec) {
            $temp = explode(' ', $rec->postLikeTime);
            $date[$key] = $this->convertDateToPersian($temp[0]);
            $date[$key] = $this->addZero($date[$key]);
            $time[$key] = $this->dateLenToNow($temp[0], $temp[1]);
            $rowTime[$allRow] = $time[$key];
            $allRow++;
            if ($time[$key] < 11520) {
                $postsLikeHowDay[$key] = $this->howDays($time[$key]);
            } else {
                $postsLikeHowDay[$key] = $date[$key];
            }
        }

        $postsCommentHowDay = array();
        foreach ($postsComment as $key => $rec) {
            $temp = explode(' ', $rec->CommentTime);
            $date[$key] = $this->convertDateToPersian($temp[0]);
            $date[$key] = $this->addZero($date[$key]);
            $time[$key] = $this->dateLenToNow($temp[0], $temp[1]);
            $rowTime[$allRow] = $time[$key];
            $allRow++;
            if ($time[$key] < 11520) {
                $postsCommentHowDay[$key] = $this->howDays($time[$key]);
            } else {
                $postsCommentHowDay[$key] = $date[$key];
            }
        }

        $postsCommentReplyHowDay = array();
        foreach ($postsCommentReply as $key => $rec) {
            $temp = explode(' ', $rec->CommentReplyTime);
            $date[$key] = $this->convertDateToPersian($temp[0]);
            $date[$key] = $this->addZero($date[$key]);
            $time[$key] = $this->dateLenToNow($temp[0], $temp[1]);
            $rowTime[$allRow] = $time[$key];
            $allRow++;
            if ($time[$key] < 11520) {
                $postsCommentReplyHowDay[$key] = $this->howDays($time[$key]);
            } else {
                $postsCommentReplyHowDay[$key] = $date[$key];
            }
        }

        session_start();
        $_SESSION['userProfileID'] = $data->id;
        $_SESSION['userProfileImg'] = $data->Pic;
        $_SESSION['jobCategory'] = $data->Category;
        $_SESSION['userName'] = $data->name;

        return view('Administrator.SellerMajor.Reaction', compact('data', 'eventLike', 'postsLike', 'eventLikeHowDay', 'postsLikeHowDay'
            , 'postsComment', 'postsCommentHowDay', 'postsCommentReply', 'postsCommentReplyHowDay', 'rowTime'));
    }

    public function panel($id)
    {
        $data = DB::table('sellersmajor')
            ->select('*')
            ->where('id', $id)
            ->first();

        $events = DB::table('seller_major_event as e')
            ->select('*', 'e.ID as eventID', 'e.Time as eventTime')
            ->leftJoin('seller_major_event_like as el', 'el.EventID', 'e.ID')
            ->where('e.SellerMajorID', $id)
            ->where("e.Time", ">", Carbon::now()->subday(30)->toDateTimeString())
            ->groupBy('e.ID')
            ->orderBy('e.ID', 'ASC')
            ->get();

        $eventDate = array();
        $eventTime = array();
        $eventHowDay = array();
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

        $message = DB::table('seller_major_msg')
            ->select('*')
            ->where('SellerMajorID', $id)
            ->where('Status', '0')
            ->orderBy('ID', 'ASC')
            ->get();

        $_SESSION['loadPost'] = 6;
        $postsCount = DB::table('seller_major_post')
            ->select('SellerMajorID')
            ->where('SellerMajorID', $id)
            ->get()
            ->count();

        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic', 'pc.ID as CommentID')
            ->leftJoin('seller_major_post_like as pl', 'pl.PostID', 'p.ID')
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->where('p.SellerMajorID', $id)
            ->groupBy('p.ID')
            ->orderBy('p.ID', 'DESC')
            ->take(6)
            ->get();

        $postDate = array();
        $postTime = array();
        $postHowDay = array();
        $commentCount = array();
        foreach ($posts as $key => $rec) {
            $temp = explode(' ', $rec->postTime);
            $postDate[$key] = $this->convertDateToPersian($temp[0]);
            $postDate[$key] = $this->addZero($postDate[$key]);
            $postTime[$key] = $this->dateLenToNow($temp[0], $temp[1]);

            if ($postTime[$key] < 11520) {
                $postHowDay[$key] = $this->howDays($postTime[$key]);
            } else {
                $postHowDay[$key] = $postDate[$key];
            }
            $comments = DB::table('seller_major_post_comment as pc')
                ->select('pc.ID')
                ->where('pc.PostID', $rec->postID)
                ->get()
                ->count();

            $commentsReply = DB::table('seller_major_post_comment_reply')
                ->where('PostID', $rec->postID)
                ->get()
                ->count();

            $commentCount[$key] = $comments + $commentsReply;
        }

        session_start();
        $_SESSION['userProfileID'] = $data->id;
        $_SESSION['userProfileImg'] = $data->Pic;
        $_SESSION['jobCategory'] = $data->Category;
        $_SESSION['userName'] = $data->name;

        return view('Administrator.SellerMajor.Panel', compact('data', 'events', 'eventHowDay', 'posts', 'postsCount',
            'message', 'postHowDay', 'commentCount'));
    }

    public function adminToSellerMajorMsg(Request $request)
    {
        $title = $request->get('title');
        $priority = $request->get('priority');
        $section = $request->get('section');
        $msg = $request->get('msg');
        $link = $request->get('msgLink');
        $userID = $request->get('userID');
        $mobile = $request->get('mobile');

        DB::table('seller_major_alarm_msg')
            ->insert([
                'SellerMajorID' => $userID === 'all' ? -1 : (int)$userID,
                'Title' => $title,
                'Priority' => $priority,
                'Section' => $section,
                'Message' => $msg,
            ]);

        if ($userID === 'all') {
            $sellerMajor = DB::table('sellersmajor')
                ->select('id', 'Mobile')
                ->get();

            foreach ($sellerMajor as $key => $row) {
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
            return redirect()->route('sellerMajorSupport')->with('status', 'success');
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
            return redirect()->route('sellerMajorControlPanel', [$userID, 'support'])->with('status', 'success');
        }
    }

    public function adLimit($id, $status)
    {
        $user=DB::table('sellersmajor as s')
            ->select('s.id','s.name','s.Mobile','p.ID as postID','s.Instagram')
            ->leftJoin('seller_major_post as p',function($join){
                $join->on('p.SellerMajorID','s.id')
                ->on('p.ID', '=', DB::raw("(select max(id) from seller_major_post)")); //get last record from second table
            })
            ->where('s.id',$id)
            ->first();

        switch ($status) {
            case 'on':
                DB::table('sellersmajor')
                    ->where('id', $id)
                    ->update([
                        'AdBlock' => '1',
                        'Advertising' => '0',
                    ]);

                DB::table('ad_list')
                    ->where('SellerMajorID',$id)
                    ->delete();
                break;
            case 'off':
                DB::table('sellersmajor')
                    ->where('id', $id)
                    ->update([
                        'AdBlock' => '0',
                        'Advertising' => '1',
                    ]);

                DB::table('ad_list')
                    ->insert([
                        'SellerMajorID'=>$id,
                        'PostID'=>$user->postID,
                        'Instagram'=>$user->Instagram,
                    ]);
                break;
            default:
                DB::table('sellersmajor')
                    ->where('id', $id)
                    ->increment('AdWarning');

                $data=DB::table('ad_list_source')
                    ->select('SellerMajorID','Time','Link')
                    ->where('SellerMajorID',$id)
                    ->where("Time", ">", Carbon::now()->subHours(24)->toDateTimeString())
                    ->latest('Time')
                    ->first();

                try {
                    $api_key = Config::get('kavenegar.apikey');
                    $var = new Kavenegar\KavenegarApi($api_key);
                    $template = "adWarning";
                    $type = "sms";

                    $result = $var->VerifyLookup($user->Mobile, $user->name, $data->Link, null, $template, $type);
                } catch (\Kavenegar\Exceptions\ApiException $e) {
                    // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                    echo $e->errorMessage();
                } catch (\Kavenegar\Exceptions\HttpException $e) {
                    // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                    echo $e->errorMessage();
                }
        }

        return $status;
    }

    public function accountBlock($id, $status)
    {
        switch ($status) {
            case 'on':
                DB::table('sellersmajor')
                    ->where('id', $id)
                    ->update([
                        'status' => 0,
                    ]);
                break;
            case 'off':
                DB::table('sellersmajor')
                    ->where('id', $id)
                    ->update([
                        'status' => 1,
                    ]);
                break;
        }

        return $status;
    }

    public function searchName($val)
    {
        $output = '';
        $data = DB::table('sellersmajor')
            ->select('name', 'id')
            ->where('name', 'like', $val . '%')
            ->take(10)
            ->get();
        foreach ($data as $key => $row) {
            $output .= '<li style="border-radius: 0 !important;"
                        class="list-group-item g-color-gray-dark-v3 g-letter-spacing-0 g-opacity-0_8--hover">
                            <a  href="' . route('sellerMajorControlPanel', ['id' => $row->id, 'tab' => 'all']) . '"
                                style="text-decoration: none"
                                class="col-12 p-0 text-left g-color-gray-dark-v3 g-color-primary--hover">
                             ' . $row->name . '
                            </a>
                        </li>';
        }

        return $output;
    }

    public function searchMobile($val)
    {
        $output = '';
        $data = DB::table('sellersmajor')
            ->select('Mobile', 'id')
            ->where('Mobile', 'like', $val . '%')
            ->take(10)
            ->get();

        foreach ($data as $key => $row) {
            $output .= '<li style="border-radius: 0 !important;"
                        class="list-group-item g-color-gray-dark-v3 g-letter-spacing-0 g-opacity-0_8--hover">
                            <a  href="' . route('sellerMajorControlPanel', ['id' => $row->id, 'tab' => 'all']) . '"
                                style="text-decoration: none"
                                class="col-12 p-0 text-left g-color-gray-dark-v3 g-color-primary--hover">
                             ' . $row->Mobile . '
                            </a>
                        </li>';
        }

        return $output;
    }

    public function invitation()
    {
        return view('Administrator.SellerMajor.Invitation');
    }

    public function sellerMajorInvite($mobile,$name,$family)
    {
        DB::table('seller_major_invite')
            ->insert([
                'Name'=>$name,
                'Family'=>$family,
                'Mobile'=>$mobile,
            ]);
        try {
            $api_key = Config::get('kavenegar.apikey');
            $var = new Kavenegar\KavenegarApi($api_key);
            $template = "invite";
            $type = "sms";

            $result = $var->VerifyLookup($mobile, $name, $family, null, $template, $type);
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }

        return redirect()->route('adminInvitation')->with('status', 'success');
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
