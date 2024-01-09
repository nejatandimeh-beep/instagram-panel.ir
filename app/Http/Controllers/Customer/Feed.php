<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use File;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Feed extends Controller
{
    public function __construct()
    {
        session_start();
        $_SESSION['userProfilePic'] = '';
        $this->middleware(function ($request, $next) {
            if (isset(Auth::user()->id)) {
                $_SESSION['userProfilePic'] = $request->user()->PicPath;
            }
            return $next($request);
        });
    }

    public function feed()
    {
        $operator = '=';
        if (isset(Auth::user()->id)) {
            $operator = '<>';
        }
        $eventHowDay = array();
        $events = DB::table('seller_major_event as e')
            ->select('*', 'e.ID as eventID', 'e.Time as eventTime', 's.id as sellerMajorID', 'e.Pic as eventPic', 's.Category',
                's.Pic as profileImage', 'el.ID as eventLike', 'es.ID as eventSave', 'sf.ID as following')
            ->leftJoin('seller_major_event_like as el', function ($join) {
                $join->on('el.EventID', 'e.ID');
                $join->where('el.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_event_visit as ev', 'ev.EventID', 'e.ID')
            ->leftJoin('seller_major_event_save as es', function ($join) {
                $join->on('es.EventID', 'e.ID');
                $join->where('es.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('sellersmajor as s', 's.id', 'e.SellerMajorID')
            ->leftJoin('seller_major_follower as sf', function ($join) {
                $join->on('sf.SellerMajorID', 'e.SellerMajorID');
                $join->where('sf.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            //            ->whereNull('ev.VisitorID') // remove visited event
            ->where("e.Time", ">", Carbon::now()->subHours(24)->toDateTimeString())
//            ->where('sf.CustomerID', $operator, null) //only following post
            ->groupBy('e.ID')
            ->orderBy('e.SellerMajorID', 'ASC')
            ->orderBy('e.ID', 'ASC')
            ->orderBy('sf.ID', 'DESC')
            ->get();

        $eventDate = array();
        $eventTime = array();
        $tempUserID = null;
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
        if (!isset($_SESSION['loadPostFeed'])) {
            $_SESSION['loadPostFeed'] = 6;
        }
        if (!isset($_SESSION['backPressed'])) {
            $_SESSION['backPressed'] = false;
            if (!$_SESSION['backPressed']) {
                $_SESSION['loadPostFeed'] = 6;
            }
        }
        $postsCount = DB::table('seller_major_post')
            ->select('SellerMajorID')
            ->get()
            ->count();

        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic',
                'pc.ID as CommentID', 's.pic as sellerMajorPic', 'p.SellerMajorID as sellerMajorID', 'ps.ID as save', 'sf.ID as following')
            ->leftJoin('seller_major_post_like as pl', function ($join) {
                $join->on('pl.PostID', 'p.ID');
                $join->where('pl.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->leftJoin('seller_major_post_save as ps', function ($join) {
                $join->on('ps.PostID', 'p.ID');
                $join->where('ps.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_follower as sf', function ($join) {
                $join->on('sf.SellerMajorID', 'p.SellerMajorID');
                $join->where('sf.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
//            ->where('sf.CustomerID', $operator, null) //only following post
            ->groupBy('p.ID')
            ->orderBy('p.ID', 'DESC')
            ->orderBy('sf.ID', 'DESC')
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
        $userName = null;
        if (isset(Auth::user()->id)) {
            $userName = !is_null(Auth::user()->name) ? Auth::user()->name : 'کاربر' . Auth::user()->id;
        }
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

        return view('Customer.Feed', compact('events', 'eventHowDay', 'posts', 'postsCount',
            'postHowDay', 'commentCount', 'notification', 'notificationMsg'));
    }

    public function loadPost()
    {
        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic',
                'pc.ID as CommentID', 's.pic as sellerMajorPic', 'p.SellerMajorID as sellerMajorID', 'ps.ID as save', 'sf.ID as following')
            ->leftJoin('seller_major_post_like as pl', function ($join) {
                $join->on('pl.PostID', 'p.ID');
                $join->where('pl.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->leftJoin('seller_major_post_save as ps', 'ps.PostID', 'p.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->leftJoin('seller_major_follower as sf', function ($join) {
                $join->on('sf.SellerMajorID', 'p.SellerMajorID');
                $join->where('sf.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->groupBy('p.ID')
            ->orderBy('p.ID', 'DESC')
            ->orderBy('sf.ID', 'DESC')
            ->skip($_SESSION['loadPostFeed'])
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

        $startStep = $_SESSION['loadPostFeed'];
        $_SESSION['loadPostFeed'] = $_SESSION['loadPostFeed'] + 6;
        return array($posts, $startStep, $postHowDay, $commentCount, isset(Auth::user()->PicPath) ? asset(Auth::user()->PicPath) : '');
    }

    public function eventReply($eventID, $text)
    {
        $data = DB::table('seller_major_event')
            ->select('Pic', 'ID', 'SellerMajorID')
            ->where('ID', $eventID)
            ->first();
        $attachmentImg = $data->Pic . '/' . $data->ID;
        $msg = DB::table('seller_major_msg')
            ->select('ID', 'SellerMajorID')
            ->where('SellerMajorID', $data->SellerMajorID)
            ->where('CustomerID', Auth::user()->id)
            ->first();
        if (isset($msg->SellerMajorID)) {
            DB::table('seller_major_msg_detail')
                ->insert([
                    'MessageID' => $msg->ID,
                    'CustomerID' => Auth::user()->id,
                    'Sender' => 'customer',
                    'EventID' => (int)$eventID,
                    'Reply' => $text,
                    'AttachPath' => $attachmentImg,
                ]);

            DB::table('seller_major_msg')
                ->where('CustomerID', Auth::user()->id)
                ->update([
                    'Status' => '0',
                ]);
        } else {
            DB::table('seller_major_msg')
                ->insert([
                    'SellerMajorID' => $data->SellerMajorID,
                    'CustomerID' => Auth::user()->id,
                    'Status' => '0',
                ]);

            $msgID = DB::table('seller_major_msg')
                ->select('ID')
                ->latest('ID')
                ->first();

            DB::table('seller_major_msg_detail')
                ->insert([
                    'MessageID' => $msgID->ID,
                    'CustomerID' => Auth::user()->id,
                    'Sender' => 'customer',
                    'EventID' => (int)$eventID,
                    'Reply' => $text,
                    'AttachPath' => $attachmentImg,
                ]);
        }
        return array($eventID, $text);
    }

    public function eventVisit($eventID)
    {
        $data = DB::table('seller_major_event_visit')
            ->where('EventID', $eventID)
            ->first();

        if (isset(Auth::user()->id) && !isset($data->EventID)) {
            DB::table('seller_major_event_visit')
                ->insert([
                    'EventID' => $eventID,
                    'VisitorID' => Auth::user()->id,
                ]);
        }

        DB::table('seller_major_event')
            ->where('ID', $eventID)
            ->update([
                'VisitCount' => DB::raw('VisitCount + 1')
            ]);
    }

    public function eventLike($eventID, $status, $sellerMajorID)
    {
        $data = DB::table('seller_major_event_like')
            ->select('ID')
            ->where('ID', $eventID)
            ->where('CustomerID', Auth::user()->id)
            ->first();

        if ($status === 'like') {
            if (!isset($data->ID)) {
                DB::table('seller_major_event_like')
                    ->insert([
                        'CustomerID' => Auth::user()->id,
                        'SellerMajorID' => $sellerMajorID,
                        'EventID' => $eventID,
                        'Status' => 0,
                    ]);
                Db::table('seller_major_event')
                    ->where('ID', $eventID)
                    ->update([
                        'LikeCount' => DB::raw('LikeCount + 1')
                    ]);
            } else {
                Db::table('seller_major_event')
                    ->where('ID', $eventID)
                    ->update([
                        'LikeCount' => DB::raw('LikeCount - 1'),
                        'Status' => 0,
                    ]);
            }
        } else {
            DB::table('seller_major_event_like')
                ->where('EventID', $eventID)
                ->delete();

            Db::table('seller_major_event')
                ->where('ID', $eventID)
                ->update([
                    'LikeCount' => DB::raw('LikeCount - 1')
                ]);
        }
    }

    public function eventSave($eventID, $status)
    {
        $data = DB::table('seller_major_event_save')
            ->select('ID')
            ->where('ID', $eventID)
            ->where('CustomerID', Auth::user()->id)
            ->first();

        if ($status === 'save') {
            if (!isset($data->ID)) {
                DB::table('seller_major_event_save')
                    ->insert([
                        'CustomerID' => Auth::user()->id,
                        'EventID' => $eventID,
                    ]);
                Db::table('seller_major_event')
                    ->where('ID', $eventID)
                    ->update([
                        'SaveCount' => DB::raw('SaveCount + 1')
                    ]);
            } else {
                Db::table('seller_major_event')
                    ->where('ID', $eventID)
                    ->update([
                        'SaveCount' => DB::raw('SaveCount + 1')
                    ]);
            }
        } else {
            DB::table('seller_major_event_save')
                ->where('EventID', $eventID)
                ->delete();

            Db::table('seller_major_event')
                ->where('ID', $eventID)
                ->update([
                    'SaveCount' => DB::raw('SaveCount - 1')
                ]);
        }
    }

    public function likePost($postID, $status, $sellerMajorID)
    {
        if ($status === 'like') {
            $temp = DB::table('seller_major_post_like')
                ->select('PostID')
                ->where('PostID', $postID)
                ->where('CustomerID', Auth::user()->id)
                ->first();
            if (!is_null($temp)) {
                DB::table('seller_major_post')
                    ->where('ID', $postID)
                    ->update([
                        'LikeCount' => DB::raw('LikeCount + 1')
                    ]);
                DB::table('seller_major_post_like')
                    ->where('PostID', $postID)
                    ->where('CustomerID', Auth::user()->id)
                    ->update([
                        'Like' => 1,
                        'Status' => 0,
                    ]);
            } else {
                DB::table('seller_major_post')
                    ->where('ID', $postID)
                    ->update([
                        'LikeCount' => DB::raw('LikeCount + 1')
                    ]);
                DB::table('seller_major_post_like')
                    ->insert([
                        'CustomerID' => Auth::user()->id,
                        'SellerMajorID' => $sellerMajorID,
                        'PostID' => $postID,
                        'Like' => 1,
                        'Status' => 0,
                    ]);
            }
        } else {
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'LikeCount' => DB::raw('LikeCount - 1')
                ]);
            DB::table('seller_major_post_like')
                ->where('PostID', $postID)
                ->where('CustomerID', Auth::user()->id)
                ->update([
                    'Like' => 0,
                    'Status' => 3,
                ]);
        }

        $like = DB::table('seller_major_post')
            ->select('LikeCount', 'ID')
            ->where('ID', $postID)
            ->first();
        return $like->LikeCount;
    }

    public function chartPost($postID)
    {
        return array(DB::table('seller_major_post')
            ->select('*')
            ->where('ID', $postID)
            ->first());
    }

    public function postVisit($postID)
    {
        $data = DB::table('seller_major_post_visit')
            ->where('PostID', $postID)
            ->first();
        if (isset($data->ID)) {
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'VisitCount' => DB::raw('VisitCount + 1')
                ]);
        } else {
            DB::table('seller_major_post_visit')
                ->insert([
                    'PostID' => $postID,
                    'VisitorID' => Auth::user()->id,
                ]);

            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'VisitCount' => DB::raw('VisitCount + 1'),
                    'UniqueVisitCount' => DB::raw('UniqueVisitCount + 1')
                ]);
        }


        return 'success';
    }

    public function sendComment($id, $text, $replyID, $sellerMajorID)
    {
        date_default_timezone_set('Asia/Tehran');
        if ($replyID === 'comment') {
            DB::table('seller_major_post_comment')
                ->insert([
                    'PostID' => $id,
                    'SellerMajorID' => $sellerMajorID,
                    'CommenterID' => Auth::user()->id,
                    'Commenter' => 'customer',
                    'CommentText' => $text,
                    'CommentTime' => date('Y-m-d H:i:s'),
                    'Status' => 0,
                ]);
            $data = DB::table('seller_major_post_comment as pc')
                ->select('*', 'pc.ID as commentId', 'c.id as customerID', 'c.PicPath', 'c.name as customerName', 'pc.PostID')
                ->leftJoin('seller_major_post as p', 'p.ID', 'pc.PostID')
                ->leftJoin('seller_major_post_comment_reply as pcr', 'pcr.CommentID', 'pc.ID')
                ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
                ->leftJoin('customers as c', 'c.id', 'pc.CommenterID')
                ->latest('pc.ID')
                ->first();
        } else {
            DB::table('seller_major_post_comment_reply')
                ->insert([
                    'PostID' => $id,
                    'CommentID' => $replyID,
                    'CommenterID' => Auth::user()->id,
                    'CommenterReply' => 'customer',
                    'CommentReplyText' => $text,
                    'CommentReplyTime' => date('Y-m-d H:i:s'),
                    'Status' => 0,
                ]);
            DB::table('seller_major_post_comment')
                ->where('ID', $replyID)
                ->update([
                    'Status' => 0,
                ]);
            $data = DB::table('seller_major_post_comment as pc')
                ->select('*', 'pc.ID as commentId', 'pcr.ID as commentReplyId', 'c.id as customerID', 'c.PicPath', 'c.name as customerName')
                ->leftJoin('seller_major_post as p', 'p.ID', 'pc.PostID')
                ->leftJoin('seller_major_post_comment_reply as pcr', 'pcr.CommentID', 'pc.ID')
                ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
                ->leftJoin('customers as c', 'c.id', 'pcr.CommenterID')
                ->latest('pcr.ID')
                ->first();
        }

        $temp = explode(' ', $replyID === 'comment' ? $data->CommentTime : $data->CommentReplyTime);
        $postCommentDate = $this->convertDateToPersian($temp[0]);
        $postCommentDate = $this->addZero($postCommentDate);
        $postCommentTime = $this->dateLenToNow($temp[0], $temp[1]);

        if ($postCommentTime < 11520) {
            $postCommentHowDay = $this->howDays($postCommentTime);
        } else {
            $postCommentHowDay = $postCommentDate;
        }
        return array($data, $postCommentHowDay);
    }

    public function likeComments($id, $replyID, $status, $likeStatus)
    {
        $commentID = DB::table('seller_major_post_comment_reply')
            ->select('CommentID')
            ->where('CommentID', $id)
            ->first();
        if ($status === "comment") {
            DB::table('seller_major_post_comment')
                ->where('ID', $id)
                ->update([
                    'CommentLike' => DB::raw($likeStatus == 1 ? 'CommentLike - 1' : 'CommentLike + 1')
                ]);

            $checkLike = DB::table('seller_major_post_comment_like')
                ->select('ID')
                ->where('CommentID', $id)
                ->where('CustomerID', Auth::user()->id)
                ->first();
            if (!isset($checkLike->ID)) {
                DB::table('seller_major_post_comment_like')
                    ->insert([
                        'CommentID' => $id,
                        'CustomerID' => Auth::user()->id,
                        'LikeStatus' => $likeStatus == 1 ? 0 : 1,
                    ]);

                return 'success';
            } else {
                DB::table('seller_major_post_comment_like')
                    ->where('CommentID', $id)
                    ->where('CustomerID', Auth::user()->id)
                    ->update([
                        'LikeStatus' => $likeStatus == 1 ? 0 : 1,
                    ]);

                return 'success';
            }
        } else {
            DB::table('seller_major_post_comment_reply')
                ->where('ID', $replyID)
                ->update([
                    'CommentReplyLike' => DB::raw($likeStatus == 1 ? 'CommentReplyLike - 1' : 'CommentReplyLike + 1')
                ]);

            $checkLike = DB::table('seller_major_post_comment_reply_like')
                ->select('ID')
                ->where('CommentReplyID', $replyID)
                ->where('CustomerID', Auth::user()->id)
                ->first();

            if (!isset($checkLike->ID)) {
                DB::table('seller_major_post_comment_reply_like')
                    ->insert([
                        'Comment_ID' => $commentID->CommentID,
                        'CommentReplyID' => $replyID,
                        'CustomerID' => Auth::user()->id,
                        'LikeStatus' => $likeStatus == 1 ? 0 : 1,
                    ]);

                return 'success';
            } else {
                DB::table('seller_major_post_comment_reply_like')
                    ->where('CommentReplyID', $replyID)
                    ->where('CustomerID', Auth::user()->id)
                    ->update([
                        'LikeStatus' => $likeStatus == 1 ? 0 : 1,
                    ]);

                return 'success';
            }
        }
    }

    public function addComments($postID)
    {
        $comment = DB::table('seller_major_post_comment as pc')
            ->select('*', 'pc.ID as commentId', 'p.SellerMajorID', 'c.id', 'c.PicPath', 'c.name as customerName', 'c.id as customerID', 's.name as sellerMajorName')
            ->leftJoin('seller_major_post as p', 'p.ID', 'pc.PostID')
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->leftJoin('seller_major_post_comment_like as pcl', function ($join) {
                $join->on('pcl.CommentID', 'pc.ID');
                $join->where('pcl.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
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
            ->select('*', 'pcr.ID as commentReplyID', 'pcr.CommenterID as replyCustomerID', 'p.SellerMajorID', 'c.id', 'c.PicPath', 'c.name as customerName', 'c.id as customerID', 's.name as sellerMajorName')
            ->leftJoin('seller_major_post_comment as pc', 'pc.ID', 'pcr.CommentID')
            ->leftJoin('seller_major_post as p', 'p.ID', 'pc.PostID')
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->leftJoin('seller_major_post_comment_reply_like as pcrl', function ($join) {
                $join->on('pcrl.CommentReplyID', 'pcr.ID');
                $join->where('pcrl.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
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

    public function savePost($postID, $bookmark)
    {
        if ($bookmark === 'save') {
            DB::table('seller_major_post_save')
                ->insert([
                    'PostID' => $postID,
                    'CustomerID' => Auth::user()->id,
                ]);
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'SaveCount' => DB::raw('SaveCount + 1')
                ]);
            return $postID . ' saved';
        } else {
            Db::table('seller_major_post_save')
                ->where('PostID', $postID)
                ->delete();
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'SaveCount' => DB::raw('SaveCount - 1')
                ]);
            return $postID . ' remove';
        }
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

    public function follow($sellerMajorID)
    {
        Db::table('seller_major_follower')
            ->insert([
                'SellerMajorID' => $sellerMajorID,
                'CustomerID' => Auth::user()->id,
            ]);
        DB::table('sellersmajor')
            ->where('ID', $sellerMajorID)
            ->update([
                'Followers' => DB::raw('Followers + 1')
            ]);
        return 'success';
    }

    public function following()
    {
        $data = DB::table('seller_major_follower as sf')
            ->select('*')
            ->leftJoin('sellersmajor  as s', 's.id', 'sf.SellerMajorID')
            ->where('CustomerID', Auth::user()->id)
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
        return view('Customer.Following', compact('data', 'notification', 'notificationMsg'));
    }

    public function sellerMajorPanel($sellerMajorID)
    {
        $data = DB::table('sellersmajor as s')
            ->select('*', 'sf.ID as following')
            ->leftJoin('seller_major_follower as sf', function ($join) {
                $join->on('sf.SellerMajorID', 's.id');
                $join->where('sf.CustomerID', Auth::user()->id);
            })
            ->where('s.id', $sellerMajorID)
            ->first();

        $eventHowDay = array();
        $events = DB::table('seller_major_event as e')
            ->select('*', 'e.ID as eventID', 'e.Time as eventTime', 's.id as sellerMajorID', 'e.Pic as eventPic',
                's.Pic as profileImage', 'el.ID as eventLike', 'es.ID as eventSave', 'sf.ID as following')
            ->leftJoin('seller_major_event_like as el', 'el.EventID', 'e.ID')
            ->leftJoin('seller_major_event_visit as ev', 'ev.EventID', 'e.ID')
            ->leftJoin('seller_major_event_save as es', 'es.EventID', 'e.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'e.SellerMajorID')
            ->leftJoin('seller_major_follower as sf', 'sf.SellerMajorID', 'e.SellerMajorID')
            ->where('e.SellerMajorID', $sellerMajorID)
            ->where("e.Time", ">", Carbon::now()->subHours(24)->toDateTimeString())
            ->groupBy('e.ID')
            ->orderBy('e.SellerMajorID', 'ASC')
            ->orderBy('e.ID', 'ASC')
            ->get();

        $eventDate = array();
        $eventTime = array();
        $tempUserID = null;
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

        if (!isset($_SESSION['loadPostPanel'])) {
            $_SESSION['loadPostPanel'] = 6;
        }
        if (!isset($_SESSION['backPressed'])) {
            $_SESSION['backPressed'] = false;
            if (!$_SESSION['backPressed']) {
                $_SESSION['loadPostPanel'] = 6;
            }
        }
        $postsCount = DB::table('seller_major_post')
            ->select('SellerMajorID')
            ->where('SellerMajorID', $sellerMajorID)
            ->get()
            ->count();

        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic',
                'pc.ID as CommentID', 's.pic as sellerMajorPic', 'p.SellerMajorID as sellerMajorID', 'ps.ID as save', 'sf.ID as following')
            ->leftJoin('seller_major_post_like as pl', function ($join) {
                $join->on('pl.PostID', 'p.ID');
                $join->where('pl.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->leftJoin('seller_major_post_save as ps', function ($join) {
                $join->on('ps.PostID', 'p.ID');
                $join->where('ps.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_follower as sf', 'sf.SellerMajorID', 'p.SellerMajorID')
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->where('p.SellerMajorID', $sellerMajorID)
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
        return view('Customer.SellerMajor', compact('data', 'events', 'eventHowDay', 'posts',
            'postsCount', 'postHowDay', 'commentCount', 'sellerMajorID', 'notification', 'notificationMsg'));
    }

    public function loadPostSellerMajor($sellerMajorID)
    {
        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic',
                'pc.ID as CommentID', 's.pic as sellerMajorPic', 'p.SellerMajorID as sellerMajorID', 'ps.ID as save', 'sf.ID as following')
            ->leftJoin('seller_major_post_like as pl', function ($join) {
                $join->on('pl.PostID', 'p.ID');
                $join->where('pl.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->leftJoin('seller_major_post_save as ps', 'ps.PostID', 'p.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->leftJoin('seller_major_follower as sf', function ($join) {
                $join->on('sf.SellerMajorID', 'p.SellerMajorID');
                $join->where('sf.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->where('p.SellerMajorID', $sellerMajorID)
            ->groupBy('p.ID')
            ->orderBy('p.ID', 'DESC')
            ->orderBy('sf.ID', 'DESC')
            ->skip($_SESSION['loadPostPanel'])
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

        $startStep = $_SESSION['loadPostPanel'];
        $_SESSION['loadPostPanel'] = $_SESSION['loadPostPanel'] + 6;
        return array($posts, $startStep, $postHowDay, $commentCount, isset(Auth::user()->PicPath) ? asset(Auth::user()->PicPath) : '');
    }

    public function deleteFollowing($sellerMajorID)
    {
        DB::table('seller_major_follower')
            ->where('SellerMajorID', $sellerMajorID)
            ->where('CustomerID', Auth::user()->id)
            ->delete();

        DB::table('sellersmajor')
            ->where('ID', $sellerMajorID)
            ->update([
                'Followers' => DB::raw('Followers - 1')
            ]);
    }

    public function reaction()
    {
        $data = Auth::user();
        $userName = !is_null($data->name) ? $data->name : 'کاربر' . $data->id;
        $postsCommentReply = DB::table('seller_major_post_comment_reply as pcr')
            ->select('*', 'pc.SellerMajorID', 'pcr.ID as commentReplyID', 'pcr.CommenterID as commenterReplyID',
                's.pic as sellerImg', 'p.Pic as postImg', 'c.name as customerName', 's.name as sellerName')
            ->leftJoin('seller_major_post_comment as pc', 'pc.id', 'pcr.CommentID')
            ->leftJoin('seller_major_post as p', 'p.ID', 'pc.PostID')
            ->leftJoin('seller_major_post_comment_reply_like as pcrl', 'pcrl.Comment_ID', 'pc.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'pc.SellerMajorID')
            ->leftJoin('customers as c', 'c.id', 'pcr.CommenterID')
            ->where('pcr.CommentReplyText', 'like', '@' . $userName . '%')
            ->where('pcr.CommenterID', '<>', $data->id)
            ->where("pcr.CommentReplyTime", ">", Carbon::now()->subMonth(30)->toDateTimeString())
            ->orderBy('pcr.ID', 'DESC')
            ->get();
        $date = array();
        $time = array();
        $postsCommentReplyHowDay = array();
        foreach ($postsCommentReply as $key => $rec) {
            $temp = explode(' ', $rec->CommentReplyTime);
            $date[$key] = $this->convertDateToPersian($temp[0]);
            $date[$key] = $this->addZero($date[$key]);
            $time[$key] = $this->dateLenToNow($temp[0], $temp[1]);

            if ($time[$key] < 11520) {
                $postsCommentReplyHowDay[$key] = $this->howDays($time[$key]);
            } else {
                $postsCommentReplyHowDay[$key] = $date[$key];
            }
        }
        DB::table('seller_major_post_comment')
            ->where('CommenterID', Auth::user()->id)
            ->update([
                'Status' => 1,
            ]);
        if (isset($postsCommentReply[0]->CommentID)) {
            $userName = !is_null(Auth::user()->name) ? Auth::user()->name : 'کاربر' . Auth::user()->id;
            DB::table('seller_major_post_comment_reply')
                ->where('CommentID', $postsCommentReply[0]->CommentID)
                ->where('CommentReplyText', 'like', '@' . $userName . '%')
                ->update([
                    'Status' => 1,
                ]);
        }
        $notification = 0;
        $notificationMsg = DB::table('seller_major_msg')
            ->where('CustomerID', isset(Auth::user()->id) ? Auth::user()->id : null)
            ->where('Status', 2)
            ->get()->count();
        return view('Customer.Reaction', compact('data', 'postsCommentReply', 'postsCommentReplyHowDay', 'notification', 'notificationMsg'));
    }

    public function postMsg($postID, $text)
    {
        $data = DB::table('seller_major_post')
            ->select('Pic', 'ID', 'SellerMajorID')
            ->where('ID', $postID)
            ->first();

        $attachmentImg = $data->Pic . '/' . $data->ID;

        $msg = DB::table('seller_major_msg')
            ->select('ID', 'SellerMajorID')
            ->where('SellerMajorID', $data->SellerMajorID)
            ->where('CustomerID', Auth::user()->id)
            ->first();

        if (isset($msg->SellerMajorID)) {
            DB::table('seller_major_msg_detail')
                ->insert([
                    'MessageID' => $msg->ID,
                    'CustomerID' => Auth::user()->id,
                    'Sender' => 'customer',
                    'PostID' => (int)$postID,
                    'Reply' => $text,
                    'AttachPath' => $attachmentImg,
                ]);

            DB::table('seller_major_msg')
                ->where('CustomerID', Auth::user()->id)
                ->update([
                    'Status' => 0,
                ]);
        } else {
            DB::table('seller_major_msg')
                ->insert([
                    'SellerMajorID' => $data->SellerMajorID,
                    'CustomerID' => Auth::user()->id,
                    'Status' => 0,
                ]);

            $msgID = DB::table('seller_major_msg')
                ->select('ID')
                ->latest('ID')
                ->first();

            DB::table('seller_major_msg_detail')
                ->insert([
                    'MessageID' => $msgID->ID,
                    'CustomerID' => Auth::user()->id,
                    'Sender' => 'customer',
                    'PostID' => (int)$postID,
                    'Reply' => $text,
                    'AttachPath' => $attachmentImg,
                ]);
        }

        return array($postID, $text);
    }

    public function messages()
    {
        $msg = DB::table('seller_major_msg as m')
            ->select('m.*', 'm.ID as msgID', 'md.ID', 'md.Time', 'md.MessageID', 's.Pic', 's.name')
            ->leftJoin('seller_major_msg_detail as md', 'md.MessageID', 'm.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'm.SellerMajorID')
            ->where('m.CustomerID', Auth::user()->id)
            ->orderBy('md.ID', 'DESC')
            ->groupBy('m.SellerMajorID')
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
        return view('Customer.Messages', compact('msg', 'howDay', 'notification', 'notificationMsg'));
    }

    public function messagesDetail($sellerMajorID)
    {
        $msgTemp = DB::table('seller_major_msg')
            ->select('ID', 'CustomerID', 'SellerMajorID', 'Status')
            ->where('CustomerID', Auth::user()->id)
            ->where('SellerMajorID', $sellerMajorID)
            ->first();
        $eventDate = array();
        $eventTime = array();
        $msgHowDay = array();
        $msg = null;
        if (!isset($msgTemp->ID)) {
            DB::table('seller_major_msg')
                ->insert([
                    'SellerMajorID' => $sellerMajorID,
                    'CustomerID' => Auth::user()->id,
                    'Status' => 0,
                ]);
            $msg = DB::table('seller_major_msg as m')
                ->select('m.*', 'md.*', 's.Pic as sellerPic', 's.name as sellerName', 'm.ID as msgID', 'md.ID as msgDetailID')
                ->leftJoin('seller_major_msg_detail as md', 'md.MessageID', 'm.ID')
                ->leftJoin('seller_major_event as e', 'e.ID', 'md.EventID')
                ->leftJoin('sellersmajor as s', 's.id', 'm.SellerMajorID')
                ->where('m.CustomerID', Auth::user()->id)
                ->where('m.SellerMajorID', $sellerMajorID)
                ->orderBy('md.ID')
                ->get();
            $msgTemp = $msg[0];
        } else {
            $msg = DB::table('seller_major_msg as m')
                ->select('m.*', 'md.*', 's.Pic as sellerPic', 's.name as sellerName', 'm.ID as msgID', 'md.ID as msgDetailID')
                ->leftJoin('seller_major_msg_detail as md', 'md.MessageID', 'm.ID')
                ->leftJoin('seller_major_event as e', 'e.ID', 'md.EventID')
                ->leftJoin('sellersmajor as s', 's.id', 'm.SellerMajorID')
                ->where('m.CustomerID', Auth::user()->id)
                ->where('m.SellerMajorID', $sellerMajorID)
                ->orderBy('md.ID')
                ->get();

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
        }

        if ($msgTemp->Status !== 0 && !session()->has('redirect')) {
            DB::table('seller_major_msg')
                ->where('SellerMajorID', $sellerMajorID)
                ->where('CustomerID', Auth::user()->id)
                ->update([
                    'Status' => 1,
                ]);
        }

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
        $notificationMsg = 0;

        return view('Customer.MessagesDetail', compact('msg', 'msgHowDay', 'notification', 'notificationMsg'));
    }

    public function messagesAnswer(Request $request)
    {
        $msgID = $request->get('msgID');
        $msgDetailID = $request->get('msgDetailID');
        $answer = $request->get('answer');
        $attachmentImg = $request->file('attachmentImg');
        if (!is_null($attachmentImg)) {
            $source = '';
            $picPath = public_path('/img/CustomerMsg/') . Auth::user()->id . '/' . $msgDetailID;
            File::makeDirectory($picPath, 0777, true, true);
            switch ($attachmentImg->getMimeType()) {
                case 'image/jpeg':
                case 'image/jpg':
                    $source = imagecreatefromjpeg($attachmentImg);
                    break;
                case 'image/png':
                    $source = imagecreatefrompng($attachmentImg);
                    break;
                case 'image/gif':
                    $source = imagecreatefromgif($attachmentImg);
                    break;
            }
            $attachFullPath = $picPath . '/0.jpg';
            imagejpeg($source, $attachFullPath);

            list($width, $height) = getimagesize($attachmentImg);
            $newWidth = (25 * $width) / 100;
            $newHeight = (25 * $height) / 100;
            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            $white = imagecolorallocate($thumb, 255, 255, 255);
            imagefill($thumb, 0, 0, $white);
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            $imageFullPath = $picPath . '/sample.jpg';
            imagejpeg($thumb, $imageFullPath, 80);
            imagedestroy($thumb);
            imagedestroy($source);
            $attachFullPath = '/img/CustomerMsg/' . Auth::user()->id . '/' . $msgDetailID;
        } else {
            $attachFullPath = '';
        }

        $sellerMajorID = $request->get('sellerMajorID');
        $msg = DB::table('seller_major_msg')
            ->select('CustomerID')
            ->where('SellerMajorID', $sellerMajorID)
            ->first();
        if (!isset($msg->CustomerID)) {
            DB::table('seller_major_msg')->insert([
                [
                    'SellerMajorID' => $sellerMajorID,
                    'CustomerID' => Auth::user()->id,
                    'Status' => 0,
                ],
            ]);

            $msgIDTemp = DB::table('seller_major_msg')
                ->select('ID')
                ->orderBy('ID', 'DESC')
                ->first();

            DB::table('seller_major_msg_detail')->insert([
                [
                    'MessageID' => $msgIDTemp->ID,
                    'CustomerID' => Auth::user()->id,
                    'Sender' => 'customer',
                    'Reply' => !is_null($answer) ? $answer : '',
                    'AttachPath' => $attachFullPath,
                ],
            ]);
        } else {
            DB::table('seller_major_msg_detail')->insert([
                [
                    'MessageID' => $msgID,
                    'CustomerID' => Auth::user()->id,
                    'Sender' => 'customer',
                    'Reply' => !is_null($answer) ? $answer : '',
                    'AttachPath' => $attachFullPath,
                ],
            ]);
        }

        DB::table('seller_major_msg')
            ->where('SellerMajorID', $sellerMajorID)
            ->where('CustomerID', Auth::user()->id)
            ->update([
                'Status' => 0,
            ]);
        return redirect()->route('cSmDetail', $sellerMajorID)->with('redirect', 'true');
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

    public function saved()
    {
        $eventHowDay = array();
        $events = DB::table('seller_major_event as e')
            ->select('*', 'e.ID as eventID', 'e.Time as eventTime', 's.id as sellerMajorID', 'e.Pic as eventPic',
                's.Pic as profileImage', 'el.ID as eventLike', 'es.ID as eventSave', 'sf.ID as following')
            ->leftJoin('seller_major_event_like as el', 'el.EventID', 'e.ID')
            ->leftJoin('seller_major_event_visit as ev', 'ev.EventID', 'e.ID')
            ->leftJoin('seller_major_event_save as es', 'es.EventID', 'e.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'e.SellerMajorID')
            ->leftJoin('seller_major_follower as sf', 'sf.SellerMajorID', 'e.SellerMajorID')
            ->where("e.Time", ">", Carbon::now()->subHours(24)->toDateTimeString())
            ->where("es.ID", "<>", null)
            ->where("es.CustomerID", Auth::user()->id)
            ->groupBy('e.ID')
            ->orderBy('e.SellerMajorID', 'ASC')
            ->orderBy('e.ID', 'ASC')
            ->get();
        $eventDate = array();
        $eventTime = array();
        $tempUserID = null;
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

        if (!isset($_SESSION['loadPostSaved'])) {
            $_SESSION['loadPostSaved'] = 12;
        }
        if (!isset($_SESSION['backPressed'])) {
            $_SESSION['backPressed'] = false;
            if (!$_SESSION['backPressed']) {
                $_SESSION['loadPostSaved'] = 12;
            }
        }
        $postsCount = DB::table('seller_major_post')
            ->select('SellerMajorID')
            ->get()
            ->count();

        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic',
                'pc.ID as CommentID', 's.pic as sellerMajorPic', 'p.SellerMajorID as sellerMajorID', 'ps.ID as save', 'sf.ID as following')
            ->leftJoin('seller_major_post_like as pl', function ($join) {
                $join->on('pl.PostID', 'p.ID');
                $join->where('pl.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->leftJoin('seller_major_post_save as ps', 'ps.PostID', 'p.ID')
            ->leftJoin('seller_major_follower as sf', function ($join) {
                $join->on('sf.SellerMajorID', 'p.SellerMajorID');
                $join->where('sf.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->where("ps.ID", "<>", null)
            ->where("ps.CustomerID", Auth::user()->id)
            ->groupBy('p.ID')
            ->orderBy('p.ID', 'DESC')
            ->take(12)
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
        return view('Customer.Saved', compact('events', 'eventHowDay', 'posts', 'postsCount', 'postHowDay', 'commentCount', 'notification', 'notificationMsg'));
    }

    public function loadPostSaved()
    {
        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic',
                'pc.ID as CommentID', 's.pic as sellerMajorPic', 'p.SellerMajorID as sellerMajorID', 'ps.ID as save', 'sf.ID as following')
            ->leftJoin('seller_major_post_like as pl', function ($join) {
                $join->on('pl.PostID', 'p.ID');
                $join->where('pl.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->leftJoin('seller_major_post_save as ps', 'ps.PostID', 'p.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->leftJoin('seller_major_follower as sf', function ($join) {
                $join->on('sf.SellerMajorID', 'p.SellerMajorID');
                $join->where('sf.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->whereNotNull('ps.CustomerID')
            ->groupBy('p.ID')
            ->orderBy('p.ID', 'DESC')
            ->skip($_SESSION['loadPostSaved'])
            ->take(12)
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

        $startStep = $_SESSION['loadPostSaved'];
        $_SESSION['loadPostSaved'] = $_SESSION['loadPostSaved'] + 12;
        return array($posts, $startStep, $postHowDay, $commentCount, isset(Auth::user()->PicPath) ? asset(Auth::user()->PicPath) : '');
    }

    public function search($cat)
    {
        $operator = '=';
        if ($cat === 'all') {
            $operator = '<>';
        }
        DB::table('post_temp')->truncate();
        if (!isset($_SESSION['loadPostSearch'])) {
            $_SESSION['loadPostSearch'] = 12;
        }
        if (!isset($_SESSION['backPressed'])) {
            $_SESSION['backPressed'] = false;
            if (!$_SESSION['backPressed']) {
                $_SESSION['loadPostSearch'] = 12;
            }
        }
        $postsCount = DB::table('seller_major_post')
            ->select('SellerMajorID')
            ->get()
            ->count();

        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic',
                'pc.ID as CommentID', 's.pic as sellerMajorPic', 'p.SellerMajorID as sellerMajorID', 'ps.ID as save', 'sf.ID as following')
            ->leftJoin('seller_major_post_like as pl', function ($join) {
                $join->on('pl.PostID', 'p.ID');
                $join->where('pl.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->leftJoin('seller_major_post_save as ps', 'ps.PostID', 'p.ID')
            ->leftJoin('seller_major_follower as sf', function ($join) {
                $join->on('sf.SellerMajorID', 'p.SellerMajorID');
                $join->where('sf.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->where('s.Category', $operator, $cat)
            ->groupBy('p.ID')
            ->inRandomOrder()
            ->take(12)
            ->get();

        $postDate = array();
        $postTime = array();
        $postHowDay = array();
        $commentCount = array();
        foreach ($posts as $key => $rec) {
            DB::table('post_temp')
                ->insert([
                    'PostID' => $rec->postID,
                ]);
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
        $userName = '';
        if (isset(Auth::user()->id)) {
            $userName = !is_null(Auth::user()->name) ? Auth::user()->name : 'کاربر' . Auth::user()->id;
        }
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
        return view('Customer.Search', compact('posts', 'postsCount', 'postHowDay', 'commentCount', 'notification', 'notificationMsg', 'cat'));
    }

    public function loadPostSearch($cat)
    {
        $operator = '=';
        if ($cat === 'all') {
            $operator = '<>';
        }
        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic',
                'pc.ID as CommentID', 's.pic as sellerMajorPic', 'p.SellerMajorID as sellerMajorID', 'ps.ID as save', 'sf.ID as following')
            ->leftJoin('seller_major_post_like as pl', function ($join) {
                $join->on('pl.PostID', 'p.ID');
                $join->where('pl.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->leftJoin('seller_major_post_save as ps', 'ps.PostID', 'p.ID')
            ->leftJoin('sellersmajor as s', 's.id', 'p.SellerMajorID')
            ->leftJoin('post_temp as pt', 'pt.PostID', 'p.ID')
            ->leftJoin('seller_major_follower as sf', function ($join) {
                $join->on('sf.SellerMajorID', 'p.SellerMajorID');
                $join->where('sf.CustomerID', isset(Auth::user()->id) ? Auth::user()->id : -1);
            })
            ->where('s.Category', $operator, $cat)
            ->whereNull('pt.PostID')
            ->groupBy('p.ID')
            ->inRandomOrder()
            ->take(12)
            ->get();

        $postDate = array();
        $postTime = array();
        $postHowDay = array();
        $commentCount = array();
        foreach ($posts as $key => $rec) {
            DB::table('post_temp')
                ->insert([
                    'PostID' => $rec->postID,
                ]);
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

        $startStep = $_SESSION['loadPostSearch'];
        $_SESSION['loadPostSearch'] = $_SESSION['loadPostSearch'] + 12;
        return array($posts, $startStep, $postHowDay, $commentCount, isset(Auth::user()->PicPath) ? asset(Auth::user()->PicPath) : '');
    }

    public function liveSearch($val, $page)
    {
        $data = null;
        if ($page === 'explore') {
            $data = DB::table('sellersmajor')
                ->select('name', 'Pic', 'id')
                ->where('name', 'like', $val . '%')
                ->take(10)
                ->get();
        } else {
            $data = DB::table('seller_major_follower as sf')
                ->select('s.name', 's.Pic', 's.id')
                ->leftJoin('sellersmajor as s', 's.id', 'sf.SellerMajorID')
                ->where('s.name', 'like', $val . '%')
                ->take(10)
                ->get();
        }
        $items = '';
        foreach ($data as $key => $rec) {
            $items .= '<li class="g-brd-around g-brd-gray-light-v4 g-pa-10 g-mb-minus-1">
<a href="' . route('cSmPanel', $rec->id) . '">
<div class="media">
<div class="d-flex g-mt-2 g-mr-15">
<img class="g-width-40 g-height-40 rounded-circle" src="' . asset($rec->Pic) . '/profileImg.jpg" alt="Image Description">
</div>
<div class="media-body align-self-center">
<p class="m-0">' . $rec->name . '</p>
</div>
</div>
</a>
</li>';
        }
        return $items;
    }

    public function backPressed($status,$url)
    {
        $url=str_replace('*','/',$url);
        if($status == 1){
            $_SESSION['backPressed'] = true;
        } else {
            $_SESSION['backPressed'] = false;
            $url==='/Feed'?$_SESSION['loadPostFeed']=6:true;
            strpos($url,'/Customer-SellerMajor-Panel')?$_SESSION['loadPostPanel']=6:true;
            $url==='/Customer-SellerMajor-Saved'?$_SESSION['loadPostSaved']=12:true;
            strpos($url,'/Customer-SellerMajor-Search')?$_SESSION['loadPostSearch']=12:true;
        }

        return array($status,$url);
    }
//------------------------------------------------
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
    public function addZero($d)
    {
        for ($i = 0; $i < 3; $i++)
            if (strlen($d[$i]) < 2)
                $d[$i] = '0' . $d[$i];
        return $d[0] . '.' . $d[1] . '.' . $d[2];
    }
}
