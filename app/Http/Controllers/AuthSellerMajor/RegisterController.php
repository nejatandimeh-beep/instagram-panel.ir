<?php

namespace App\Http\Controllers\AuthSellerMajor;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\SellerMajor;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use File;
use Kavenegar;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/Seller-Major-Panel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => ['required', 'string', 'min:11'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */


    // Superadmin Register
    public function registerForm()
    {
        return view('auth.sellerMajorAuth.register');
    }

    public function checkUserName($userName)
    {
        $data = DB::table('sellersmajor')
            ->select('id','name')
            ->where('name', $userName)
            ->first();

        if (isset($data->id))
            return 'exist';
        else
            return 'noExist';
    }

    public function uploadImage(Request $request)
    {
        $mobile = $request->get('mobileHint');
        $picNum = $request->get('picNum');
        $image = $request->file('imageUrl');
        $path = public_path('img/imagesTemp/SellerMajorProfileImage/') . $mobile;
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
        $imageFullPath = $picNum==='12'?$path . '/profileImg.jpg':$path . '/instaProfileImg.jpg';
        imagejpeg($thumb, $imageFullPath, 80);
        imagedestroy($thumb);
        imagedestroy($source);

        return 'Success';
    }

    protected function createSeller(Request $request)
    {
        $mobile = $request->get('mobile');
        $tempPath = public_path('img/imagesTemp/SellerMajorProfileImage/') . $mobile;
        $path = public_path('img/SellerMajorProfileImage/') . $mobile;
        $file = new Filesystem();
        $file->moveDirectory($tempPath, $path, true);

        $name = $request['name'];
        $category = $request['category'];
        $instaAccount = $request['instaAccount'];
        $instaPic=$instaAccount!=null?'img/SellerMajorProfileImage/' . $mobile.'/instaProfileImg.jpg':'img/SellerMajorProfileImage/Default/icon.jpg';
        $sellerMajor = SellerMajor::create([
            'name' => $name,
            'Mobile' => $mobile,
            'Category' => $category,
            'CatCode' => $request['catCode'],
            'HintCategory' => $request['hintCategory'],
            'Pic' => 'img/SellerMajorProfileImage/' . $mobile,
            'InstaPic' => $instaPic,
            'Instagram' => $instaAccount,
            'password' => Hash::make($request['password']),
        ]);

        //--------------
        try {
            $api_key = Config::get('kavenegar.apikey');
            $var = new Kavenegar\KavenegarApi($api_key);
            $template = "registerSellerMajor";
            $type = "sms";

            $result = $var->VerifyLookup($mobile, $name, null, null, $template, $type);
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
        //--------------
        Auth::guard('sellerMajor')->loginUsingId($sellerMajor->id, TRUE);
        return redirect()->route('sellerMajorPanel');
    }

    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890#$%!@&';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
