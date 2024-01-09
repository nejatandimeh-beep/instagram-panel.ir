<?php

use App\Http\Controllers\SitemapXmlController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
// Test Pages
Route::get('/test', 'Customer\Basic@test')->name('test');
// site map
Route::get('/SiteMap', 'SitemapController@index')->name('sitemap');
// ******************************************** ( Customer Routes ) ******************************************************
// Customer Login Links
Auth::routes(['verify' => true]);
//customer register links
Route::get('/request-customer-mobile/{source}', function ($source) {
    Session::put('source', $source);
    return view('auth.requestMobile',compact('source'));
})->name('requestMobile');
Route::get('/Login-Mode', 'Auth\LoginController@loginMode')->name('loginMode');
Route::get('/check-customer-mobile', 'Auth\VerifyController@getMobile')->name('checkMobile');
Route::post('verify-customer-mobile', 'Auth\VerifyController@verifyMobile')->name('verifyMobile');
Route::get('/reset/password', 'Auth\VerifyController@resetPassword')->name('resetPassword');
Route::post('reset-password', 'Auth\ResetPasswordController@resetCustomerPassword')->name('mobileResetPassword');
Route::get('/Customer-checkUserName/{userName}', 'Auth\RegisterController@checkUserName');
// Customer Change Password Links with email
//Route::get('change-password', 'Auth\ChangePasswordController@index')->name('changePass');
//Route::post('change-password', 'Auth\ChangePasswordController@store')->name('change.password');
Route::get('/home', 'HomeController@index')->name('home');
// *********************************************** ( Customer Routes ) *************************************************
// Master Page
Route::get('/', 'Customer\Basic@Master')->name('Master');
// sign up all type of seller
Route::get('/Seller-Register-Mode', 'Customer\Basic@registerMode')->name('registerMode');
Route::get('/Customer-Verify', 'Customer\Basic@customerVerify')->name('customerVerify');
// Profile
Route::get('/Customer-Profile', 'Customer\Basic@userProfile')->name('userProfile');
Route::get('/Customer-Connection', 'Customer\Basic@connection')->name('customerConnection');
Route::get('/Customer-Connection-Detail/{id}/{status}', 'Customer\Basic@connectionDetail')->name('customerConnectionDetail');
Route::post('/Customer-Connection-New', 'Customer\Basic@connectionNew')->name('customerConnectionNew');
Route::post('/Customer-Connection-NewMsg', 'Customer\Basic@connectionNewMsg')->name('customerConnectionNewMsg');
Route::get('/Customer-SellerMajor-Help', 'Customer\Basic@help')->name('help');

// -------------------[ Ajax ]-----------------------
Route::post('/Customer-Profile-Update', 'Customer\Basic@profileUpdate')->name('profileUpdate');
Route::get('/About-Me', 'Customer\Basic@aboutMe')->name('aboutMe');
// -------------------[ Customer Feed ]-----------------------
Route::get('/Feed', 'Customer\Feed@feed')->name('feed');
Route::get('/Customer-Event-Reply/{eventID}/{val}', 'Customer\Feed@eventReply');
Route::get('/Customer-Event-Visit/{eventID}', 'Customer\Feed@eventVisit');
Route::get('/Customer-Event-Like/{eventID}/{status}/{sellerMajorID}', 'Customer\Feed@eventLike');
Route::get('/Customer-Event-Save/{eventID}/{status}', 'Customer\Feed@eventSave');
Route::get('/Customer-Send-Comment/{postID}/{text}/{replyID}/{sellerMajorID}', 'Customer\Feed@sendComment');
Route::get('/Customer-LikeComment/{id}/{replyID}/{status}/{likeStatus}', 'Customer\Feed@likeComments');
Route::get('/Customer-Load-Post', 'Customer\Feed@loadPost');
Route::get('/Customer-SellerMajor-Load-Post/{sellerMajorID}', 'Customer\Feed@loadPostSellerMajor');
Route::get('/Customer-Like-Post/{postID}/{status}/{sellerMajorID}', 'Customer\Feed@likePost');
Route::get('/Customer-Save-Post/{postID}/{bookmark}', 'Customer\Feed@savePost');
Route::get('/Customer-Msg-Post/{postID}/{text}', 'Customer\Feed@postMsg');
Route::get('/Customer-Post-Visit/{postID}', 'Customer\Feed@postVisit');
Route::get('/Customer-AddComment/{postID}', 'Customer\Feed@addComments');
Route::get('/Customer-Comment-Delete/{id}/{status}', 'Customer\Feed@deleteComments');
Route::get('/Customer-Follow-SellerMajor/{sellerMajorID}', 'Customer\Feed@follow');
Route::get('/Customer-Following-SellerMajor', 'Customer\Feed@following')->name('sellerMajorFollowing');
Route::get('/Customer-Following-Delete/{sellerMajorID}', 'Customer\Feed@deleteFollowing');
Route::get('/Customer-SellerMajor-Panel/{id}', 'Customer\Feed@sellerMajorPanel')->name('cSmPanel');
Route::get('/Customer-SellerMajor-Reactions', 'Customer\Feed@reaction')->name('customerReaction');
Route::get('/Customer-SellerMajor-Messages', 'Customer\Feed@messages')->name('cSmMessages');
Route::get('/Customer-SellerMajor-Messages-Detail/{sellerMajorID}', 'Customer\Feed@messagesDetail')->name('cSmDetail');
Route::post('/Customer-SellerMajor-Messages-Answer', 'Customer\Feed@messagesAnswer')->name('cSmMessagesAnswer');
Route::get('/Customer-SellerMajor-Messages-Delete/{msgDetailID}', 'Customer\Feed@messagesDelete');
Route::get('/Customer-Seller-Major-UserMessages-Delete/{msgID}', 'Customer\Feed@userMsgDelete');
Route::get('/Customer-SellerMajor-Saved', 'Customer\Feed@saved')->name('cSmSaved');
Route::get('/Customer-Saved-LoadPost', 'Customer\Feed@loadPostSaved');
Route::get('/Customer-SellerMajor-Search/{cat}', 'Customer\Feed@search')->name('cSSearch');
Route::get('/Customer-Search-LoadPost/{cat}', 'Customer\Feed@loadPostSearch');
Route::get('/Customer-SellerMajor-LiveSearch/{val}/{page}', 'Customer\Feed@liveSearch');
Route::get('/Customer-Browser-backPressed/{status}/{url}', 'Customer\Feed@backPressed');

// -------------------[ Products Filter [ Ajax ] ]-----------------------
Route::get('/Customer-Product-Custom-Filter/{gender}/{cat}/{size}/{priceMin}/{priceMax}/{color}/{filterChange}', 'Customer\Basic@productFilter');
Route::get('/Customer-Product-Load', 'Customer\Basic@productLoad');
Route::get('/Customer-Spacial-Discounts', 'Customer\Basic@discounts');
Route::get('/Customer-Similar-Products/{genderCode}/{catCode}/{productID}/{cat}', 'Customer\Basic@sameProduct');
// -------------------[ Cropper.js ]-----------------------
Route::post('/Customer-Profile-Image', 'Customer\Basic@uploadImage')->name('uploadImage');

Route::get('/email-test', function () {
    return view('vendor.mail.html.test');
});
//------------------[ Regulation ]-----------------------------
Route::get('/Customer-Regulation/{tab}', 'Customer\Basic@regulation')->name('regulation');

// *********************************************** ( Admin Routes ) *************************************************
Route::get('/login/admin', 'AuthAdmin\LoginController@showAdminLoginForm')->name('adminLog');
Route::post('/logout/admin', 'AuthAdmin\LoginController@adminLogout')->name('adminLogout');
Route::get('/register/admin', 'AuthAdmin\RegisterController@showAdminRegisterForm')->name('adminRegister');
Route::post('/login/admin', 'AuthAdmin\LoginController@adminLogin')->name('adminLogin');
//Route::post('/register/admin', 'AuthAdmin\RegisterController@createAdmin')->name('adminSave'); for add admin pls enable
Route::get('/change-admin-password', 'AuthAdmin\ChangePasswordController@index')->name('changeAdminPass');
Route::post('/change-admin-password', 'AuthAdmin\ChangePasswordController@store')->name('changeAdminPassword');
Route::group(['prefix' => 'admins'], function() {
    //   Route::post('/password/email','Auth\CustomerForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');
    route::get('/requestEmail', 'AuthAdmin\ForgotPasswordController@showLinkRequestForm')->name('admins.showEmailRequestForm');
    route::post('/sendEmail', 'AuthAdmin\ForgotPasswordController@sendResetLinkEmail')->name('admins.sendResetLink');
    route::get('/reset/{token}', 'AuthAdmin\ResetPasswordController@showResetForm')->name('admins.password.email');
    route::post('/reset', 'AuthAdmin\ResetPasswordController@reset')->name('admins.password.update');
});
Route::get('/Administrator-Master', 'Administrator\Admin@AdministratorMaster')->name('administratorMaster');
Route::get('/Administrator-Kiosk-SignatureEdit/{newCode}/{id}', 'Delivery\Basic@signatureEdit');
// -------------------------[Customer]
Route::get('/Administrator-Customer-List', 'Administrator\Customer@customer')->name('customerList');
Route::get('/Administrator-Customer-Support', 'Administrator\Customer@support')->name('customerSupport');
Route::get('/Administrator-Customer-Control/{id}/{tab}', 'Administrator\Customer@controlPanel')->name('customerControlPanel');
Route::post('/Administrator-Customer-Update', 'Administrator\Customer@update')->name('updateCustomer');
Route::get('/Administrator-Customer-Search/{mobile}', 'Administrator\Customer@mobileSearch');
Route::post('/Administrator-Customer-AddressUpdate', 'Administrator\Customer@addressUpdate')->name('adminAddressUpdate');
Route::post('/Administrator-Customer-AddressAdd', 'Administrator\Customer@addAddress')->name('customerAddAddress');
Route::get('/Administrator-Customer-AddressDelete/{id}', 'Administrator\Customer@addressDelete');
Route::get('/Administrator-Customer-OrderDetail/{addressId}/{id}', 'Administrator\Customer@orderDetail')->name('adminCustomerOrderDetail');
Route::get('/Administrator-Customer-ConnectionDetail/{id}/{status}', 'Administrator\Customer@connectionDetail')->name('adminCustomerConnectionDetail');
Route::post('/Administrator-Customer-ConnectionNew', 'Administrator\Customer@adminToCustomersMsg')->name('adminToCustomersMsg');
Route::post('/Administrator-Customer-Connection-NewMsg', 'Administrator\Customer@connectionNewMsg')->name('adminCustomerConnectionNewMsg');
Route::get('/Administrator-Customer-Sale/{id}', 'Administrator\Customer@sale')->name('adminCustomerSale');
Route::get('/Administrator-Customer-Return/{id}', 'Administrator\Customer@return')->name('adminCustomerReturn');
Route::get('/Administrator-Customer-Block/{id}/{status}', 'Administrator\Customer@accountBlock');

// -------------------------[SellerMajor]
Route::get('/Administrator-SellerMajor', 'Administrator\SellerMajor@list')->name('sellerMajorList');
Route::get('/Administrator-SellerMajor-ControlPanel/{id}/{tab}', 'Administrator\SellerMajor@controlPanel')->name('sellerMajorControlPanel');
Route::get('/Seller-Major-StartAd', 'Administrator\SellerMajor@startAd')->name('startAd');
Route::get('/SMA/{id}', 'Administrator\SellerMajor@adSource')->name('adSource');
Route::get('/Administrator-SellerMajor-AdList', 'Administrator\SellerMajor@adList')->name('sellerMajorAdList');
Route::get('/Administrator-SellerMajor-Support', 'Administrator\SellerMajor@support')->name('sellerMajorSupport');
Route::post('/Administrator-SellerMajor-ConnectionNew', 'Administrator\SellerMajor@connectionNew')->name('adminSellerMajorConnectionNew');
Route::get('/Administrator-SellerMajor-ConnectionDetail/{id}/{status}', 'Administrator\SellerMajor@connectionDetail')->name('adminSellerMajorConnectionDetail');
Route::post('/Administrator-SellerMajor-Connection-NewMsg', 'Administrator\SellerMajor@connectionNewMsg')->name('adminSellerMajorConnectionNewMsg');
Route::post('/Administrator-SellerMajor-Update', 'Administrator\SellerMajor@update')->name('updateSellerMajor');
Route::get('/Administrator-SellerMajor-Panel/{id}', 'Administrator\SellerMajor@panel')->name('adminSellerMajorPanel');
Route::get('/Administrator-SellerMajor-removeEvent/{item}', 'Administrator\SellerMajor@removeEvent')->name('adminSellerMajorRemoveEvent');
Route::get('/Administrator-SellerMajor-profileImgRemove', 'Administrator\SellerMajor@removeProfileImage')->name('adminSellerMajorRemoveProfileImg');
Route::get('/Administrator-SellerMajor-Messages/{id}', 'Administrator\SellerMajor@messages')->name('adminSellerMajorMessages');
Route::post('/Administrator-SellerMajor-Messages-Detail', 'Administrator\SellerMajor@messagesDetail')->name('adminSellerMajorMessagesDetail');
Route::get('/Administrator-SellerMajor-Messages-Delete/{msgDetailID}', 'Administrator\SellerMajor@messagesDelete');
Route::get('/Administrator-SellerMajor-UserMessages-Delete/{msgID}', 'Administrator\SellerMajor@userMsgDelete');
Route::get('/Administrator-SellerMajor-Load-Post', 'Administrator\SellerMajor@loadPost');
Route::get('/Administrator-SellerMajor-Delete-Post/{postID}', 'Administrator\SellerMajor@deletePost');
Route::get('/Administrator-SellerMajor-Chart-Post/{postID}', 'Administrator\SellerMajor@chartPost');
Route::get('/Administrator-SellerMajor-Comment-Delete/{id}/{status}', 'Administrator\SellerMajor@deleteComments');
Route::get('/Administrator-SellerMajor-Reactions/{id}', 'Administrator\SellerMajor@reaction')->name('adminSellerMajorReaction');
Route::get('/Administrator-SellerMajor-AddComment/{postID}', 'Administrator\SellerMajor@addComments');
Route::post('/Administrator-SellerMajor-SendToAll', 'Administrator\SellerMajor@adminToSellerMajorMsg')->name('adminToSellerMajorMsg');
Route::get('/Administrator-SellerMajor-AdLimit/{id}/{status}', 'Administrator\SellerMajor@adLimit');
Route::get('/Administrator-SellerMajor-Block/{id}/{status}', 'Administrator\SellerMajor@accountBlock');
Route::get('/Administrator-SellerMajor-Search-Name/{val}', 'Administrator\SellerMajor@searchName');
Route::get('/Administrator-SellerMajor-Search-Mobile/{val}', 'Administrator\SellerMajor@searchMobile');
Route::get('/Administrator-SellerMajor-Invitation', 'Administrator\SellerMajor@invitation')->name('adminInvitation');
Route::get('/Administrator-SellerMajor-Invite/{mobile}/{name}/{family}', 'Administrator\SellerMajor@sellerMajorInvite')->name('sellerMajorInvite');
// -------------------------[instagram]
Route::get('/Instagram', 'Customer\Basic@instagram')->name('instagram');
Route::post('/Instagram-Request-PdId', 'Customer\Basic@requestPdId')->name('requestPdId');

// *********************************************** ( Bank Routes ) *************************************************
Route::post('/Payment-Status', 'Customer\Basic@paymentStatus')->name('paymentStatus');
//Route::get('/samanTest', 'Customer\Basic@samanTest')->name('samanTest');
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    echo 'route-clear: ok';
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    echo 'config-cache: ok';
});
Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    echo 'cache-clear: ok';
});
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    echo 'route:cache: ok';
});
Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:clear');
    echo 'config:clear: ok';
});
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    echo 'optimize: ok';
});
Route::get('/migrate', function() {
    $exitCode = Artisan::call('migrate');
    echo 'migrate: ok';
});
Route::get('/session-table', function() {
    $exitCode = Artisan::call(' session:table');
    echo 'table create: ok';
});

// -----------------------------[zarinpal]--------------------------------
Route::get('/Confirmation','Customer\Basic@orderZarinpal');

// *********************************************** ( sellerMajor Routes ) *************************************************
Route::get('/request-sellerMajor-mobile/{source}', function ($source) {
    Session::put('source', $source);
    return view('auth.sellerMajorAuth.requestMobile',compact('source'));
})->name('requestSellerMajorMobile');
Route::get('/login/sellerMajor-login-Mode', 'Customer\Basic@sellerLoginMode')->name('sellerLoginMode');
Route::get('/login/sellerMajor', 'AuthSellerMajor\LoginController@loginForm')->name('sellerMajorLog');
Route::post('/logout/sellerMajor', 'AuthSellerMajor\LoginController@logout')->name('sellerMajorLogout');
Route::get('/register/sellerMajor', 'AuthSellerMajor\RegisterController@registerForm')->name('sellerMajorRegister');
Route::get('/sellerMajor/checkUserName/{userName}', 'AuthSellerMajor\RegisterController@checkUserName');
Route::post('/login/sellerMajor', 'AuthSellerMajor\LoginController@login')->name('sellerMajorLogin');
Route::post('/register/sellerMajor', 'AuthSellerMajor\RegisterController@create')->name('sellerMajorSave');
Route::post('/verify-sellerMajor-mobile', 'AuthSellerMajor\VerifyController@verifyMobile')->name('verifySellerMajorMobile');
Route::post('/reset-sellerMajor-password', 'AuthSellerMajor\ResetPasswordController@resetPassword')->name('sellerMajorMobileResetPassword');
Route::get('/reset/sellerMajor/password', 'AuthSellerMajor\VerifyController@resetPassword')->name('sellerMajorResetPassword');
// Seller Change Password Links
Route::get('/change-sellerMajor-password', 'AuthSellerMajor\ChangePasswordController@index')->name('changeSellerMajorPass');
Route::post('/change-sellerMajor-password', 'AuthSellerMajor\ChangePasswordController@store')->name('changeSellerMajorPassword');
// Add Seller reset password routes
Route::group(['prefix' => 'sellersmajor'], function() {
    //   Route::post('/password/email','Auth\CustomerForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');
    route::get('/requestEmail', 'AuthSellerMajor\ForgotPasswordController@showLinkRequestForm')->name('sellersmajor.showEmailRequestForm');
    route::post('/sendEmail', 'AuthSellerMajor\ForgotPasswordController@sendResetLinkEmail')->name('sellersmajor.sendResetLink');
    route::get('/reset/{token}', 'AuthSellerMajor\ResetPasswordController@showResetForm')->name('sellersmajor.password.email');
    route::post('/reset', 'AuthSellerMajor\ResetPasswordController@reset')->name('sellersmajor.password.update');
});
// add image profile
Route::post('/sellerMajor/profile/image', 'AuthSellerMajor\RegisterController@uploadImage')->name('sellerMajorProfileImage');
Route::post('/SellerMajor-Register-Request', 'AuthSellerMajor\RegisterController@createSeller')->name('sellerMajorNew');
Route::get('/check-SellerMajor-mobile', 'AuthSellerMajor\VerifyController@checkMobile')->name('checkMobileSellerMajor');
//SellerMajor Self route
Route::get('/Seller-Major-Panel', 'SellerMajor\Basic@panel')->middleware('IsSellerMajor')->name('sellerMajorPanel');
Route::get('/Seller-Major-bioUpdate/{bioText}', 'SellerMajor\Basic@bioUpdate');
Route::get('/Seller-Major-addressUpdate/{address}', 'SellerMajor\Basic@addressUpdate');
Route::get('/Seller-Major-CategoryUpdate/{hintCategory}/{category}/{catCode}', 'SellerMajor\Basic@categoryUpdate');
Route::get('/Seller-Major-instagramUpdate/{instagramLink}', 'SellerMajor\Basic@instagramUpdate');
Route::post('/Seller-Major-profileImgUpdate', 'SellerMajor\Basic@updateProfileImage')->name('sellerMajorEditProfileImg');
Route::get('/Seller-Major-profileImgRemove', 'SellerMajor\Basic@removeProfileImage')->name('sellerMajorRemoveProfileImg');
Route::get('/Seller-Major-Remove-InstaProfileImg', 'SellerMajor\Basic@removeInstaProfileImage');
Route::post('/Seller-Major-addEvent', 'SellerMajor\Basic@addEvent')->name('sellerMajorAddEvent');
Route::get('/Seller-Major-removeEvent/{item}', 'SellerMajor\Basic@removeEvent')->name('sellerMajorRemoveEvent');
Route::get('/Seller-Major-Messages', 'SellerMajor\Basic@messages')->name('sellerMajorMessages');
Route::post('/Seller-Major-Messages-Detail', 'SellerMajor\Basic@messagesDetail')->name('sellerMajorMessagesDetail');
Route::post('/Seller-Major-Messages-Answer', 'SellerMajor\Basic@messagesAnswer')->name('sellerMajorMessagesAnswer');
Route::get('/Seller-Major-Messages-Delete/{msgDetailID}', 'SellerMajor\Basic@messagesDelete');
Route::get('/Seller-Major-UserMessages-Delete/{msgID}', 'SellerMajor\Basic@userMsgDelete');
Route::get('/Seller-Major-Send-Comment/{postID}/{text}/{replyID}', 'SellerMajor\Basic@sendComment');
Route::post('/Seller-Major-addPost', 'SellerMajor\Basic@addPost')->name('sellerMajorAddPost');
Route::get('/Seller-Major-addPostForm', 'SellerMajor\Basic@addPostForm')->name('sellerMajorAddPostForm');
Route::post('/Seller-Major-Edit-Post', 'SellerMajor\Basic@editPost');
Route::get('/Seller-Major-Load-Post', 'SellerMajor\Basic@loadPost');
Route::get('/Seller-Major-Like-Post/{postID}/{status}', 'SellerMajor\Basic@likePost');
Route::get('/Seller-Major-Chart-Post/{postID}', 'SellerMajor\Basic@chartPost');
Route::get('/Seller-Major-Delete-Check/{sellerMajorID}/{postID}', 'SellerMajor\Basic@checkPostLen');
Route::get('/Seller-Major-Delete-Post/{postID}', 'SellerMajor\Basic@deletePost');
Route::get('/Seller-Major-AddComment/{postID}', 'SellerMajor\Basic@addComments');
Route::get('/Seller-Major-Comment-Delete/{id}/{status}', 'SellerMajor\Basic@deleteComments');
Route::get('/Seller-Major-LikeComment/{id}/{replyID}/{status}/{likeStatus}', 'SellerMajor\Basic@likeComments');
Route::get('/Seller-Major-Reactions', 'SellerMajor\Basic@reaction')->name('sellerMajorReaction');
Route::get('/Seller-Major-Advertising/{id}/{status}/{instagram}', 'SellerMajor\Basic@advertising');
Route::post( '/Seller-Major-uploadImage', 'SellerMajor\Basic@uploadImage');
Route::get( '/Seller-Major-Regulation', 'SellerMajor\Basic@regulation')->name('sellerMajorRegulation');
Route::get('/SellerMajor-Connection', 'SellerMajor\Basic@connection')->name('sellerMajorConnection');
Route::post('/SellerMajor-Connection-New', 'SellerMajor\Basic@connectionNew')->name('sellerMajorConnectionNew');
Route::get('/SellerMajorConnection-Detail/{id}/{status}', 'SellerMajor\Basic@connectionDetail')->name('sellerMajorConnectionDetail');
Route::post('/SellerMajor-Connection-NewMsg', 'SellerMajor\Basic@connectionNewMsg')->name('sellerMajorConnectionNewMsg');
Route::get('/Seller-Major-Panel-AdSource/{id}', 'SellerMajor\Basic@adSource')->name('adSourcePanel');
Route::Post('/sellerMajor-story-Cancel', 'SellerMajor\Basic@actionCancel');
Route::post('/sellerMajor/instaProfile/imageUpdate', 'SellerMajor\Basic@uploadInstaImage');

