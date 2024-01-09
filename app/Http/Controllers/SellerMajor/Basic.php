<?php

namespace App\Http\Controllers\SellerMajor;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use File;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Kavenegar;


class Basic extends Controller
{
    protected $sellerMajorID, $sellerMajorData;

    public function __construct()
    {
        $this->middleware('IsSellerMajor');
        $this->middleware(function ($request, $next) {
            session_start();
            $_SESSION['userProfileID'] = Auth::guard('sellerMajor')->user()->id;
            $_SESSION['userProfileImg'] = Auth::guard('sellerMajor')->user()->Pic;
            $_SESSION['jobCategory'] = Auth::guard('sellerMajor')->user()->Category;
            $_SESSION['userName'] = Auth::guard('sellerMajor')->user()->name;
            $this->sellerMajorID = Auth::guard('sellerMajor')->user()->id;
            $this->sellerMajorData = DB::table('sellersmajor')
                ->where('id', $this->sellerMajorID)
                ->first();

            return $next($request);
        });

    }

    public function panel()
    {
        $data = $this->sellerMajorData;

        $events = DB::table('seller_major_event as e')
            ->select('*', 'e.ID as eventID', 'e.Time as eventTime')
            ->leftJoin('seller_major_event_like as el', 'el.EventID', 'e.ID')
            ->where('e.SellerMajorID', $this->sellerMajorID)
            ->where("e.Time", ">", Carbon::now()->subHours(24)->toDateTimeString())
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
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', '0')
            ->orderBy('ID', 'ASC')
            ->get();

        $_SESSION['loadPost'] = 6;
        $postsCount = DB::table('seller_major_post')
            ->select('SellerMajorID')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->get()
            ->count();

        $posts = DB::table('seller_major_post as p')
            ->select('*', 'p.ID as postID', 'p.Time as postTime', 'p.Pic as postPic', 'pc.ID as CommentID')
            ->leftJoin('seller_major_post_like as pl', 'pl.PostID', 'p.ID')
            ->leftJoin('seller_major_post_comment as pc', 'pc.PostID', 'p.ID')
            ->where('p.SellerMajorID', $this->sellerMajorID)
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

        $notification = DB::table('seller_major_post_comment')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationLike = DB::table('seller_major_post_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationEventLike = DB::table('seller_major_event_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationMsg = DB::table('seller_major_msg')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();

        return view('SellerMajor.Panel', compact('data', 'events', 'eventHowDay', 'posts', 'postsCount',
            'message', 'postHowDay', 'commentCount', 'notification', 'notificationLike', 'notificationEventLike', 'notificationMsg'));
    }

    public function bioUpdate($bioText)
    {
        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->update([
                'Bio' => $bioText === 'null' ? null : $bioText,
            ]);

        return 'updated';
    }

    public function addressUpdate($address)
    {
        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->update([
                'Address' => $address,
            ]);

        return $address;
    }

    public function categoryUpdate($hintCategory, $category, $catCode)
    {
        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->update([
                'Category' => $category,
                'CatCode' => $catCode,
                'HintCategory' => $hintCategory,
            ]);

        return $hintCategory;
    }

    public function instagramUpdate($instagramLink)
    {
        $instagramLink = str_replace('88888888888888888888888', '/', $instagramLink);

        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->update([
                'Instagram' => $instagramLink,
            ]);

        return $instagramLink;
    }

    public function advertising($id, $status, $instagram)
    {
        DB::table('sellersmajor')
            ->where('id', $id)
            ->update([
                'Advertising' => $status == 'true' ? '1' : '0'
            ]);

        $postID = DB::table('seller_major_post')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->latest('ID')
            ->first();
        if (isset($postID)) {
            if ($status == 'true') {
                DB::table('ad_list')
                    ->insert([
                        'SellerMajorID' => $this->sellerMajorID,
                        'PostID' => $postID->ID,
                        'Instagram' => $instagram,
                    ]);
            } else {
                DB::table('ad_list_source')
                    ->where('SellerMajorID', $this->sellerMajorID)
                    ->delete();

                DB::table('ad_list')
                    ->where('SellerMajorID', $this->sellerMajorID)
                    ->delete();
            }
        }

        return 'success';
    }

    public function updateProfileImage(Request $request)
    {
        // Upload Images
        $mobile = Auth::guard('sellerMajor')->user()->Mobile;
        $image = $request->file('imageUrl');
        $path = public_path('img/SellerMajorProfileImage/') . $mobile;
        File::makeDirectory($path, 0777, true, true);

        // 1000*1000 pic save
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

        // 250*250 sample save
        list($width, $height) = getimagesize($image);
        $newWidth = 400;
        $newHeight = 400;
        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($thumb, 255, 255, 255);
        imagefill($thumb, 0, 0, $white);
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        $imageFullPath = $path . '/profileImg.jpg';
        imagejpeg($thumb, $imageFullPath, 80);
        imagedestroy($thumb);
        imagedestroy($source);

        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->update([
                'Pic' => 'img/SellerMajorProfileImage/' . $mobile,
            ]);

        return 'Success';
    }

    public function addEvent(Request $request)
    {
        $text = $request->get('text');
        DB::table('seller_major_event')
            ->insert([
                'SellerMajorID' => $this->sellerMajorID,
                'Text' => $text,
                'Pic' => 'img/SellerMajor/Events/' . $this->sellerMajorID,
            ]);

        $eventId = DB::table('seller_major_event')
            ->select('ID')
            ->latest('ID')
            ->first();

        $image = $request->file('imageUrl');
        $path = public_path('img/SellerMajor/Events/') . $this->sellerMajorID;
        File::makeDirectory($path, 0777, true, true);

        // 1000*1000 pic save
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

        // 250*250 sample save
        list($width, $height) = getimagesize($image);
        $newWidth = 1080;
        $newHeight = 1920;
        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($thumb, 255, 255, 255);
        imagefill($thumb, 0, 0, $white);
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        $imageFullPath = $path . '/' . $eventId->ID . '.jpg';
        imagejpeg($thumb, $imageFullPath, 80);
        imagedestroy($thumb);
        imagedestroy($source);

        return redirect(route('sellerMajorPanel'));
    }

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

        DB::table('seller_major_event_save')
            ->where('EventID', $item)
            ->delete();

        DB::table('seller_major_event_like')
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

        File::delete(public_path($data->Pic) . '/profileImg.jpg');

        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->update([
                'Pic' => 'img/SellerMajorProfileImage/Default/icon.jpg',
            ]);

        return redirect()->route('sellerMajorPanel');
    }

    public function removeInstaProfileImage()
    {
        $data = $this->sellerMajorData;

        File::delete(public_path($data->Pic) . '/instaProfileImg.jpg');

        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->update([
                'Advertising' => '0',
                'InstaPic' => 'img/SellerMajorProfileImage/Default/icon.jpg',
            ]);

        return redirect()->route('sellerMajorPanel');
    }

    public function messages()
    {
        $msg = DB::table('seller_major_msg as m')
            ->select('m.*', 'm.ID as msgID', 'md.ID', 'md.Time', 'md.MessageID', 'c.PicPath', 'c.name', 'c.id as customerID')
            ->leftJoin('seller_major_msg_detail as md', 'md.MessageID', 'm.ID')
            ->leftJoin('customers as c', 'c.id', 'm.CustomerID')
            ->where('m.SellerMajorID', $this->sellerMajorID)
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
        $notification = DB::table('seller_major_post_comment')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationLike = DB::table('seller_major_post_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationEventLike = DB::table('seller_major_event_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationMsg = DB::table('seller_major_msg')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        return view('SellerMajor.Messages', compact('msg', 'howDay', 'notification', 'notificationLike', 'notificationEventLike', 'notificationMsg'));
    }

    public function messagesDetail(Request $request)
    {
        $customerID = $request->get('customerID');
        $msg = DB::table('seller_major_msg as m')
            ->select('m.*', 'md.*', 'c.id as customerID', 'c.PicPath as customerPic', 'c.name as customerName')
            ->leftJoin('seller_major_msg_detail as md', 'md.MessageID', 'm.ID')
            ->leftJoin('seller_major_event as e', 'e.ID', 'md.EventID')
            ->leftJoin('customers as c', 'c.id', 'md.CustomerID')
            ->where('m.SellerMajorID', $this->sellerMajorID)
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

        $notification = DB::table('seller_major_post_comment')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationLike = DB::table('seller_major_post_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationEventLike = DB::table('seller_major_event_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationMsg = 0;
        if (!session()->has('redirect')) {
            DB::table('seller_major_msg')
                ->where('SellerMajorID', $this->sellerMajorID)
                ->where('CustomerID', $customerID)
                ->update([
                    'Status' => 3
                ]);
        }

        return view('SellerMajor.MessagesDetail', compact('msg', 'msgHowDay', 'notification', 'notificationLike', 'notificationEventLike', 'notificationMsg'));
    }

    public function messagesAnswer(Request $request)
    {
        $msgID = $request->get('msgID');
        $msgDetailID = $request->get('msgDetailID');
        $answer = $request->get('answer');
        $attachmentImg = $request->file('attachmentImg');
        if (!is_null($attachmentImg)) {
            $source = '';
            $picPath = public_path('/img/SellerMajor/Attachment/') . $this->sellerMajorID . '/' . $msgDetailID;
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
            $attachFullPath = '/img/SellerMajor/Attachment/' . $this->sellerMajorID . '/' . $msgDetailID;
        } else {
            $attachFullPath = '';
        }

        $customerID = $request->get('customerID');
        $msg = DB::table('seller_major_msg')
            ->select('CustomerID')
            ->where('CustomerID', $customerID)
            ->first();

        if (!isset($msg->CustomerID)) {
            DB::table('seller_major_msg')->insert([
                [
                    'SellerMajorID' => $this->sellerMajorID,
                    'CustomerID' => $customerID,
                    'Status' => 2,
                ],
            ]);

            $msgIDTemp = DB::table('seller_major_msg')
                ->select('ID')
                ->orderBy('ID', 'DESC')
                ->first();

            DB::table('seller_major_msg_detail')->insert([
                [
                    'MessageID' => $msgIDTemp->ID,
                    'CustomerID' => $customerID,
                    'Sender' => 'seller',
                    'Reply' => !is_null($answer) ? $answer : '',
                    'AttachPath' => $attachFullPath,
                ],
            ]);
        } else {
            DB::table('seller_major_msg_detail')->insert([
                [
                    'MessageID' => $msgID,
                    'CustomerID' => $customerID,
                    'Sender' => 'seller',
                    'Reply' => !is_null($answer) ? $answer : '',
                    'AttachPath' => $attachFullPath,
                ],
            ]);

            DB::table('seller_major_msg')
                ->where('SellerMajorID', $this->sellerMajorID)
                ->update([
                    'Status' => 2,
                ]);
        }

        $msg = DB::table('seller_major_msg as m')
            ->select('m.*', 'md.*')
            ->leftJoin('seller_major_msg_detail as md', 'md.MessageID', 'm.ID')
            ->latest('md.ID')
            ->first();

        return array($msg);
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

    public function uploadImage(Request $request)
    {
        // Upload Images
        $imgNumber = $request->get('imgNumber');
        $image = $request->file('imageUrl');
        $path = public_path('img/imagesTemp/sellerMajor/Posts/') . $this->sellerMajorID;

        File::makeDirectory($path, 0777, true, true);

        // 1000*1000 pic save
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
        $imageFullPath = $path . '/' . $imgNumber . '.jpg';
        imagejpeg($source, $imageFullPath);

        if ($imgNumber == 0) {
            // 250*250 sample save
            list($width, $height) = getimagesize($image);
            $newWidth = 300;
            $newHeight = 375;
            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            $white = imagecolorallocate($thumb, 255, 255, 255);
            imagefill($thumb, 0, 0, $white);
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            $imageFullPath = $path . '/' . 'sample.jpg';
            imagejpeg($thumb, $imageFullPath, 80);

            imagedestroy($thumb);
            imagedestroy($source);
        }

        return 'success';
    }

    public function uploadInstaImage(Request $request)
    {
        $image = $request->file('imageUrl');
        $path = public_path('img/SellerMajorProfileImage/') . $this->sellerMajorData->Mobile;

        // 1000*1000 pic save
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

        // 250*250 sample save
        list($width, $height) = getimagesize($image);
        $newWidth = 400;
        $newHeight = 400;
        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($thumb, 255, 255, 255);
        imagefill($thumb, 0, 0, $white);
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        $imageFullPath = $path . '/instaProfileImg.jpg';
        imagejpeg($thumb, $imageFullPath, 80);
        imagedestroy($thumb);
        imagedestroy($source);
        $url = 'img/SellerMajorProfileImage/' . $this->sellerMajorData->Mobile . '/instaProfileImg.jpg';
        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->update([
                'InstaPic' => $url,
            ]);
        return $url;
    }

    public function addPostForm()
    {
        $directory = Storage::disk("public")->allDirectories('img/imagesTemp/SellerMajor/Posts/');

        foreach ($directory as $dir) {
            $time = Storage::disk('public')->lastModified($dir);
            $dirModifiedDateTime = Carbon::parse($time);

            if (Carbon::now()->gt($dirModifiedDateTime->addHour(24))) {

                Storage::disk("public")->deleteDirectory($dir);
            }
        }
        $notification = DB::table('seller_major_post_comment')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationLike = DB::table('seller_major_post_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationEventLike = DB::table('seller_major_event_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationMsg = DB::table('seller_major_msg')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        return view('SellerMajor.AddPost', compact('notification', 'notificationLike', 'notificationEventLike', 'notificationMsg'));
    }

    public function addPost(Request $request)
    {
        date_default_timezone_set('Asia/Tehran');
        $cat = $request->get('cat');
        $catCode = $request->get('catCode');
        $name = $request->get('name');
        $nameCode = $request->get('nameCode');
        $gender = $request->get('gender');
        $genderCode = $request->get('genderCode');
        $size = $request->get('size');
        $price = $request->get('price');
        $discount = $request->get('discount');
        $finalPrice = $request->get('finalPrice');
        $color = $request->get('color');
        $colorCode = $request->get('colorCode');
        $text = $request->get('postText');
        $tag = '#';
        $picCount = $request->get('picCount');
        DB::table('seller_major_post')
            ->insert([
                'SellerMajorID' => $this->sellerMajorID,
                'Cat' => $cat,
                'CatCode' => $catCode,
                'ProductName' => $name,
                'ProductCode' => $nameCode,
                'Gender' => $gender,
                'GenderCode' => $genderCode,
                'Size' => $size,
                'Price' => $price,
                'Discount' => $discount,
                'FinalPrice' => $finalPrice,
                'Color' => $color,
                'ColorCode' => $colorCode,
                'Text' => $text,
                'Tag' => $tag,
                'Pic' => 'img/SellerMajor/Posts/' . $this->sellerMajorID,
                'PicCount' => $picCount,
                'Time' => date('Y-m-d H:i:s'),
            ]);

        $postId = DB::table('seller_major_post')
            ->select('ID')
            ->latest('ID')
            ->first();

        $source = public_path('img/imagesTemp/sellerMajor/Posts/') . $this->sellerMajorID;
        $destination = public_path('img/SellerMajor/Posts/') . $this->sellerMajorID . '/' . $postId->ID;
        File::makeDirectory($destination, 0777, true, true);
        $file = new Filesystem();
        $file->moveDirectory($source, $destination, true);

        DB::table('sellersmajor')
            ->where('id', $this->sellerMajorID)
            ->update([
                'Posts' => DB::raw('Posts + 1')
            ]);

        DB::table('ad_list')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->update([
                'PostID' => $postId->ID,
            ]);

        return redirect()->route('sellerMajorPanel');
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

    public function likePost($postID, $status)
    {
        if ($status === 'like') {
            $temp = DB::table('seller_major_post_like')
                ->select('PostID')
                ->where('PostID', $postID)
                ->first();
            if (!is_null($temp)) {
                DB::table('seller_major_post')
                    ->where('ID', $postID)
                    ->update([
                        'LikeCount' => DB::raw('LikeCount + 1')
                    ]);
                DB::table('seller_major_post_like')
                    ->where('PostID', $postID)
                    ->update([
                        'Like' => 1,
                    ]);
            } else {
                DB::table('seller_major_post')
                    ->where('ID', $postID)
                    ->update([
                        'LikeCount' => DB::raw('LikeCount + 1')
                    ]);
                DB::table('seller_major_post_like')
                    ->insert([
                        'SellerMajorID' => $this->sellerMajorID,
                        'PostID' => $postID,
                        'Like' => 1,
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
                ->update([
                    'Like' => 0,
                ]);
        }

        $like = DB::table('seller_major_post')
            ->select('LikeCount', 'ID')
            ->where('ID', $postID)
            ->first();
        return $like->LikeCount;
    }

    public function deletePost($postID)
    {
        DB::table('ad_list_source')
            ->where('PostID', $postID)
            ->delete();

        DB::table('ad_list')
            ->where('PostID',$postID)
            ->delete();

        DB::table('post_temp')
            ->where('PostID', $postID)
            ->delete();

        DB::table('seller_major_post_visit')
            ->where('PostID', $postID)
            ->delete();

        DB::table('seller_major_post_save')
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

        File::deleteDirectory(public_path('img/SellerMajor/Posts/' . $this->sellerMajorID.'/'.$postID));

        return 'success';
    }

    public function checkPostLen($sellerMajorID,$postID)
    {
        $ad_list_exist = DB::table('ad_list')
            ->select('PostID')
            ->where('PostID', $postID)
            ->first();

        $sellerMajor = DB::table('sellersmajor')
            ->select('id', 'Advertising')
            ->where('id', $sellerMajorID)
            ->first();

        $result = false;
        if (!isset($ad_list_exist) || $sellerMajor->Advertising === '0') {
            $result = true;
        }
        return $result;
    }

    public function editPost(Request $request)
    {
        $postID = $request->get('postID');
        $items = $request->get('items');
        $text = $request->get('text');
        $items = json_decode($items);
        if (isset($items[0]) && !is_null($items[0]))
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'Cat' => null
                ]);
        if (isset($items[1]) && !is_null($items[1]))
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'ProductName' => null
                ]);
        if (isset($items[2]) && !is_null($items[2]))
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'Size' => null
                ]);
        if (isset($items[3]) && !is_null($items[3]))
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'Color' => null
                ]);
        if (isset($items[4]) && !is_null($items[4]))
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'Price' => null
                ]);
        if (isset($items[5]) && !is_null($items[5]))
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'Discount' => null
                ]);
        if (isset($items[6]) && !is_null($items[6]))
            DB::table('seller_major_post')
                ->where('ID', $postID)
                ->update([
                    'FinalPrice' => null
                ]);

        DB::table('seller_major_post')
            ->where('ID', $postID)
            ->update([
                'Text' => $text
            ]);
    }

    public function chartPost($postID)
    {
        return array(DB::table('seller_major_post')
            ->select('*')
            ->where('ID', $postID)
            ->first());
    }

    public function sendComment($id, $text, $replyID)
    {
        date_default_timezone_set('Asia/Tehran');
        if ($replyID === 'comment') {
            DB::table('seller_major_post_comment')
                ->insert([
                    'PostID' => $id,
                    'SellerMajorID' => $this->sellerMajorID,
                    'CommenterID' => -1,
                    'Commenter' => 'seller',
                    'CommentText' => $text,
                    'CommentTime' => date('Y-m-d H:i:s'),
                    'Status' => 2,
                ]);
            $data = DB::table('seller_major_post_comment as pc')
                ->select('*', 'pc.ID as commentId', 'pc.PostID')
                ->leftJoin('seller_major_post_comment_reply as pcr', 'pcr.CommentID', 'pc.ID')
                ->leftJoin('sellersmajor as s', 's.id', 'pc.SellerMajorID')
                ->latest('pc.ID')
                ->first();
        } else {
            DB::table('seller_major_post_comment_reply')
                ->insert([
                    'PostID' => $id,
                    'CommentID' => $replyID,
                    'CommenterID' => -1,
                    'CommenterReply' => 'seller',
                    'CommentReplyText' => $text,
                    'CommentReplyTime' => date('Y-m-d H:i:s'),
                    'Status' => 2,
                ]);
            DB::table('seller_major_post_comment')
                ->where('ID', $replyID)
                ->update([
                    'Status' => 2,
                ]);
            $data = DB::table('seller_major_post_comment as pc')
                ->select('*', 'pc.ID as commentId', 'pcr.ID as commentReplyId', 'pc.PostID')
                ->leftJoin('seller_major_post_comment_reply as pcr', 'pcr.CommentID', 'pc.ID')
                ->leftJoin('sellersmajor as s', 's.id', 'pc.SellerMajorID')
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

            $checkLike = DB::table('seller_major_post_comment_like_seller')
                ->select('ID')
                ->where('CommentID', $id)
                ->where('SellerMajorID', $this->sellerMajorID)
                ->first();
            if (!isset($checkLike->ID)) {
                DB::table('seller_major_post_comment_like_seller')
                    ->insert([
                        'CommentID' => $id,
                        'SellerMajorID' => $this->sellerMajorID,
                        'LikeStatus' => $likeStatus == 1 ? 0 : 1,
                    ]);

                return 'success';
            } else {
                DB::table('seller_major_post_comment_like_seller')
                    ->where('CommentID', $id)
                    ->where('SellerMajorID', $this->sellerMajorID)
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

            $checkLike = DB::table('seller_major_post_comment_reply_like_seller')
                ->select('ID')
                ->where('CommentReplyID', $replyID)
                ->where('SellerMajorID', $this->sellerMajorID)
                ->first();

            if (!isset($checkLike->ID)) {
                DB::table('seller_major_post_comment_reply_like_seller')
                    ->insert([
                        'Comment_ID' => $id,
                        'CommentReplyID' => $replyID,
                        'SellerMajorID' => $this->sellerMajorID,
                        'LikeStatus' => $likeStatus == 1 ? 0 : 1,
                    ]);

                return 'success';
            } else {
                DB::table('seller_major_post_comment_reply_like_seller')
                    ->where('CommentReplyID', $replyID)
                    ->where('SellerMajorID', $this->sellerMajorID)
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

    public function reaction()
    {
        $data = $this->sellerMajorData;
        $eventLike = DB::table('seller_major_event_like as el')
            ->select('*', 'el.Time as eventLikeTime', 'c.id as customerID')
            ->leftJoin('seller_major_event as e', 'e.ID', 'el.EventID')
            ->leftJoin('customers as c', 'c.id', 'el.CustomerID')
            ->where('e.SellerMajorID', $this->sellerMajorID)
            ->where("el.Time", ">", Carbon::now()->subMonth(30)->toDateTimeString())
            ->orderBy('el.ID', 'DESC')
            ->get();

        $postsLike = DB::table('seller_major_post_like as pl')
            ->select('*', 'pl.Time as postLikeTime', 'customerID')
            ->leftJoin('seller_major_post as p', 'p.ID', 'pl.PostID')
            ->leftJoin('customers as c', 'c.id', 'pl.CustomerID')
            ->where('p.SellerMajorID', $this->sellerMajorID)
            ->where("pl.Time", ">", Carbon::now()->subMonth(30)->toDateTimeString())
            ->orderBy('pl.ID', 'DESC')
            ->get();

        $postsComment = DB::table('seller_major_post_comment as pc')
            ->select('*', 'pc.ID as commentID', 'pc.CommenterID as userId')
            ->leftJoin('seller_major_post as p', 'p.ID', 'pc.PostID')
            ->leftJoin('seller_major_post_comment_like_seller as pcls', 'pcls.CommentID', 'pc.ID')
            ->leftJoin('customers as c', 'c.id', 'pc.CommenterID')
            ->where('pc.SellerMajorID', $this->sellerMajorID)
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
            ->where('pc.SellerMajorID', $this->sellerMajorID)
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
        DB::table('seller_major_post_comment')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->update([
                'Status' => 3,
            ]);

        DB::table('seller_major_post_comment_reply')
            ->where('CommentID', isset($postsCommentReply[0]) ? $postsCommentReply[0]->CommentID : null)
            ->update([
                'Status' => 3,
            ]);

        DB::table('seller_major_post_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->update([
                'Status' => 3,
            ]);

        DB::table('seller_major_event_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->update([
                'Status' => 3,
            ]);
        $notification = 0;
        $notificationLike = 0;
        $notificationEventLike = 0;
        $notificationMsg = DB::table('seller_major_msg')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        return view('SellerMajor.Reaction', compact('data', 'eventLike', 'postsLike', 'eventLikeHowDay', 'postsLikeHowDay'
            , 'postsComment', 'postsCommentHowDay', 'postsCommentReply', 'postsCommentReplyHowDay', 'rowTime', 'notification',
            'notificationLike', 'notificationEventLike', 'notificationMsg'));
    }

    public function regulation()
    {
        $notification = DB::table('seller_major_post_comment')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationLike = DB::table('seller_major_post_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationEventLike = DB::table('seller_major_event_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationMsg = DB::table('seller_major_msg')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        return view('SellerMajor.Regulation', compact('notification', 'notificationLike', 'notificationEventLike', 'notificationMsg'));

    }

    public function connection()
    {
        $data = DB::table('seller_major_conversation as smc')
            ->select('smc.*',
                'smcd.QuestionDate as qDate',
                'smcd.QuestionTime as qTime',
                'smcd.AnswerDate as aDate',
                'smcd.AnswerTime as aTime',
                'smcd.Replay',
                'smcd.ConversationID',
                'smcd.ID as conversationDetailID')
            ->leftJoin('seller_major_conversation_detail as smcd', 'smcd.ConversationID', '=', 'smc.ID')
            ->where('smc.SellerMajorID', $this->sellerMajorID)
            ->orderBy('smc.Status')
            ->orderBy(DB::raw('IF(smc.Status=0 || smc.Status=1, smc.Priority, false)'), 'ASC')
            ->orderBy('smc.ID', 'DESC')
            ->get();


        $alarmMsg = DB::table('seller_major_alarm_msg')
            ->select('*')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->get();

        // Convert Date
        $persianDate = array();
        foreach ($data as $key => $rec) {
            $d = $rec->Date;
            $persianDate[$key] = $this->convertDateToPersian($d);
        }
        $notification = DB::table('seller_major_post_comment')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationLike = DB::table('seller_major_post_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationEventLike = DB::table('seller_major_event_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationMsg = DB::table('seller_major_msg')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        return view('SellerMajor.Conversation', compact('data', 'persianDate', 'alarmMsg',
            'notification', 'notificationLike', 'notificationEventLike', 'notificationMsg'));
    }

    public function connectionDetail($id, $status)
    {
        $data = DB::table('seller_major_conversation_detail as ccd')
            ->select('ccd.*', 'cc.Subject', 'cc.Status', 'cc.ID as ConversationID', 'cc.SellerMajorID', 's.Name', 'CC.Priority')
            ->leftJoin('seller_major_conversation as cc', 'cc.ID', '=', 'ccd.ConversationID')
            ->leftJoin('sellersmajor as s', 's.ID', '=', 'cc.SellerMajorID')
            ->where('ccd.ConversationID', $id)
            ->paginate(10);

        if ($status === '0') {
            foreach ($data as $key => $rec)
                if ($rec->Replay !== 0) {
                    DB::table('seller_major_conversation')
                        ->where('ID', $id)
                        ->update(['Status' => 2]);
                } else {
                    DB::table('seller_major_conversation')
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
        $notification = DB::table('seller_major_post_comment')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationLike = DB::table('seller_major_post_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationEventLike = DB::table('seller_major_event_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationMsg = DB::table('seller_major_msg')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        return view('SellerMajor.ConversationDetail', compact('data', 'answerHowDay', 'questionHowDay',
            'qPersianDate', 'aPersianDate', 'title', 'notification', 'notificationLike', 'notificationEventLike', 'notificationMsg'));
    }

    public function connectionNew(Request $request)
    {
        $title = $request->get('title');
        $priority = $request->get('priority');
        $section = $request->get('section');
        $notification = DB::table('seller_major_post_comment')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationLike = DB::table('seller_major_post_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationEventLike = DB::table('seller_major_event_like')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        $notificationMsg = DB::table('seller_major_msg')
            ->where('SellerMajorID', $this->sellerMajorID)
            ->where('Status', 0)
            ->get()->count();
        return view('SellerMajor.ConversationDetail', compact('title', 'priority', 'section', 'notification', 'notificationLike', 'notificationEventLike', 'notificationMsg'));
    }

    public function connectionNewMsg(Request $request)
    {

        date_default_timezone_set('Asia/Tehran');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $question = $request->get('question');
        $title = $request->get('title');

        if (isset($title)) {
            $priority = $request->get('priority');
            $section = $request->get('section');
            // Insert Data to Conversation
            DB::table('seller_major_conversation')->insert([
                [
                    'SellerMajorID' => $this->sellerMajorID,
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
            ->update(['Status' => 1]);

        // Insert Data to Conversation_detail
        DB::table('seller_major_conversation_detail')->insert([
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
            $template = "supportSM";
            $type = "sms";

            $result = $var->VerifyLookup('09144426149', 'Administrator-Master', 'SellerMajor', null, $template, $type);
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }

        return redirect('/SellerMajor-Connection')->with('status', 'success');
    }

    public function adSource($id)
    {
        $data = DB::table('ad_list_source as ads')
            ->select('ads.*', 's.id', 's.Mobile', 's.Pic', 'ads.ID as ListSourceID', 'aa.ID as accept', 'aa.AcceptorID')
            ->leftJoin('sellersmajor as s', 's.id', 'ads.SellerMajorID_AD')
            ->leftJoin('ad_accept as aa', 'aa.ListSourceID', 'ads.ID')
            ->where('ads.SellerMajorID', $id)
            ->first();

        $cancelData = DB::table('ad_cancel')
            ->where('SellerMajorID', $id)
            ->orWhere('SellerMajorID_AD', $id)
            ->first();

        $cancelRemaining = DB::table('ad_cancel_history')
            ->select('*')
            ->where('SellerMajorID', $id)
            ->get()->count();

        $cancelRemaining = 10 - $cancelRemaining;
        if (isset($data->ID)) {
            $instagram = $data->Instagram;
            $instagram_ad = $data->Instagram_AD;
            $pic = $data->Pic_AD . '/' . $data->PostID . '/0.jpg';
            $mobile = $data->Mobile;
            $sellerMajorID_ad = $data->SellerMajorID_AD;
            $sellerMajorID = $data->SellerMajorID;
            $listSourceID = $data->ListSourceID;
            $cancel = isset($cancelData->ID) ? $cancelData->ID : null;
            $canceller = isset($cancelData->CancellerID) ? $cancelData->CancellerID : null;
            $accept = $data->accept;
            $acceptor = $data->AcceptorID;
            return view('Administrator.SellerMajor.AdSource',
                compact('instagram', 'instagram_ad', 'pic', 'mobile', 'cancel', 'canceller',
                    'listSourceID', 'sellerMajorID', 'sellerMajorID_ad', 'cancelRemaining', 'accept', 'acceptor'));
        } else {
            return redirect('/Seller-Major-Panel')->with('advertising', 'null');
        }

    }

    public function actionCancel(Request $request)
    {
        $userOnline = $request->get('userOnline');
        $ListSourceID = $request->get('listSourceID');
        $sellerMajorID = $request->get('sellerMajorID');
        $sellerMajorID_ad = $request->get('sellerMajorID_ad');
        $reason = $request->get('reason');
        $status = $request->get('status');
        $mobile = $request->get('mobile');
        $instagram = '@' . $request->get('instagram');
        if ($status === 'cancel') {
            DB::table('ad_cancel')
                ->insert([
                    'ListSourceID' => $ListSourceID,
                    'SellerMajorID' => $sellerMajorID,
                    'SellerMajorID_AD' => $sellerMajorID_ad,
                    'CancellerID' => $instagram,
                    'Reason' => $reason,
                ]);

            DB::table('ad_cancel_history')
                ->insert([
                    'SellerMajorID' => $userOnline,
                    'Reason' => $reason,
                ]);

            DB::table('ad_accept')
                ->where('ListSourceID', $ListSourceID)
                ->delete();

            try {
                $api_key = Config::get('kavenegar.apikey');
                $var = new Kavenegar\KavenegarApi($api_key);
                $template = "storyCancel";
                $type = "sms";

                $result = $var->VerifyLookup($mobile, $instagram, null, null, $template, $type);
            } catch (\Kavenegar\Exceptions\ApiException $e) {
                // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                echo $e->errorMessage();
            } catch (\Kavenegar\Exceptions\HttpException $e) {
                // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
        } else {
            DB::table('ad_accept')
                ->insert([
                    'ListSourceID' => $ListSourceID,
                    'SellerMajorID' => $sellerMajorID,
                    'SellerMajorID_AD' => $sellerMajorID_ad,
                    'AcceptorID' => $instagram,
                ]);
        }

        return 'success';
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
