@include('Layouts.BaseCssLink')
@yield('BaseCssLink')
</head>
<body>
<span id="sellerMajorInstaID" class="d-none">{{$instagram}}</span>
<div class="container g-my-20">
    <div class="g-brd-around g-brd-primary g-pa-10 col-11 col-lg-4 mx-auto">
        <img class="w-100"
             src="{{asset($pic.'?'.date('Y-m-d H:i:s'))}}"
             alt="Image Description">

        <div class="container">
            <div style="direction: rtl" class="g-py-15 text-right">
                <h5>ابتدا تصویر رو ذخیره کنید و پیرو قوانین بارگذاری، استوری را ساعت 11 امشب در استوری حساب اینستاگرام خود
                    قرار دهید.</h5>
                <div class="text-right g-mb-30">
                    <a
                        class="h6 g-color-primary text-center"
                        data-toggle="modal"
                        data-target="#regulation"
                        href="#!">
                        <i class="icon-notebook"></i> راهنمای بارگذاری
                    </a>
                </div>
                <h6>متنی که باید در استوری قید شود:</h6>
                <h5 class="m-0 g-color-blue">اگه میخوای بیشتر ببینی حتما به پیجشون سر بزن!</h5>
            </div>
            <div class="text-right g-color-gray-dark-v1">
                <h5 class="d-flex text-left g-mx-5">
                    <a id="instaLink" class="d-flex col-12 p-0 justify-content-start"
                       href="https://instagram.com/{{$instagram_ad}}">
                        <img id="instaProfileImg"
                             class="g-width-55 g-height-55 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                             src="{{asset('img/SellerMajorProfileImage/'.$mobile.'/instaProfileImg.jpg?'.date('Y-m-d H:i:s'))}}"
                             alt="Image Description">
                        <span id="instagramID" class="align-self-center g-ml-5">{{'@'.$instagram_ad}}</span>
                    </a>
                </h5>
                <div class="g-mt-25 g-py-5">
                    <h5 style="display: none" id="copyAlarm" class="g-color-primary">کپی شد</h5>
                    <p style="direction: rtl" class="m-0 small g-mb-15" id="copyText"
                       onclick="navigator.clipboard.writeText($('#instagramID').text());
                   $(this).addClass('d-none'); $('#copyAlarm').show();
                   setTimeout(function() {$('#copyAlarm').hide();$('#copyText').removeClass('d-none')},1200)">
                        <i class="fa fa-copy"></i> با کلیک روی این متن،آیدی کپی می شود..
                    </p>
                    <div  style="direction: rtl" class="alert alert-warning" role="alert">
                        <strong>توجه! </strong>لطفا قبل از تایید استوری بر روی آیدی طرف مقایل خود در بالا کلیک کنید و از صحت نام حساب در اینستاگرام اطمینان حاصل نمایید.
                    </div>
                </div>
            </div>
            <div style="direction: rtl" class="text-right g-mt-30">
                <h5 class="d-inline-block g-ml-5">تعداد انصرافهای باقی مانده شما</h5>
                <span class="g-color-red h5">{{$cancelRemaining<0?'0':$cancelRemaining}}</span> عدد
            </div>
            <span id="storyCanceled"
                  class="{{is_null($cancel)?'d-none':''}} col-12 g-mt-20 btn btn-l u-btn-outline-lightred u-btn-content g-font-weight-600 g-letter-spacing-0_5 g-brd-2 g-mr-10 g-mb-5">
                <i class="fa fa-close pull-left g-font-size-42 g-mr-10"></i>
                <span style="direction: rtl" class="float-right text-right">لغو شده<span class="d-block g-font-size-11">توسط {{!is_null($canceller)?$canceller:''}}</span></span>
            </span>
            <span id="storyAccepted"
                  class="{{is_null($accept)?'d-none':''}} col-12 g-mt-20 btn btn-l u-btn-outline-primary u-btn-content g-font-weight-600 g-letter-spacing-0_5 g-brd-2 g-mr-10 g-mb-15">
                <i class="fa fa-check pull-left g-font-size-42 g-mr-10"></i>
                <span class="float-right text-right">
                  تایید شده
                  <span class="d-block g-font-size-11">شرکت در این تبلیغ را تایید کرده اید</span>
                </span>
            </span>
            @if(is_null($cancel) && is_null($accept))
                <div id="storyCancelContainer" class="text-center g-mt-20">
                    @if($cancelRemaining>0)
                        <a class="col-12 btn btn-l u-btn-outline-lightred u-btn-content g-font-weight-600 g-letter-spacing-0_5 g-brd-2 g-mr-10 g-mb-5"
                           href="#"
                           data-toggle="modal"
                           data-target="#cancelStoryModal">
                            <i class="fa fa-close pull-left g-font-size-42 g-mr-10"></i>
                            <span class="float-right text-right">انصراف<span class="d-block g-font-size-11">عدم شرکت در این تبلیغ</span></span>
                        </a>
                    @endif
                    <a class="col-12 btn btn-l u-btn-outline-primary u-btn-content g-font-weight-600 g-letter-spacing-0_5 g-brd-2 g-mr-10 g-mb-15"
                       href="#"
                       onclick="actionStory('{{$listSourceID}}','{{$sellerMajorID}}','{{$sellerMajorID_ad}}','accept'),'{{$mobile}}'">
                        <i class="fa fa-check pull-left g-font-size-42 g-mr-10"></i>
                        <span class="float-right text-right">
                  تایید
                  <span class="d-block g-font-size-11">شرکت در این تبلیغ</span>
                </span>
                    </a>
                    <div class="modal fade text-center" id="cancelStoryModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog m-0 mx-lg-auto" role="document">
                            <div style="min-height: 100vh" class="modal-content">
                                <div style="direction: rtl" class="modal-header g-pr-20 g-pl-20">
                                    <h5 class="m-0">دلایل رد تبلیغ</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </div>
                                <div style="direction: rtl" class="modal-body mx-3">
                                    <div class="form-group g-mb-10 text-right">
                                        <label class="d-block u-check g-pr-25">
                                            <input id="colleague" name="colleague"
                                                   class="reason hidden-xs-up g-pos-abs g-top-0 g-right-0"
                                                   type="checkbox">
                                            <div
                                                class="u-check-icon-checkbox-v4 g-absolute-centered--y g-right-0">
                                                <i class="fa" data-check-icon=""></i>
                                            </div>
                                            <span id="reason-0">صفحه مورد نظر همکار است</span>
                                        </label>
                                        <label class="d-block u-check g-pr-25">
                                            <input id="lowFollower" name="lowFollower"
                                                   class="reason hidden-xs-up g-pos-abs g-top-0 g-right-0"
                                                   type="checkbox">
                                            <div
                                                class="u-check-icon-checkbox-v4 g-absolute-centered--y g-right-0">
                                                <i class="fa" data-check-icon=""></i>
                                            </div>
                                            <span id="reason-1">تعداد فالورهای صفحه مورد نظر مورد قبولم نیست</span>
                                        </label>
                                        <label class="d-block u-check g-pr-25">
                                            <input id="unlikeContent" name="unlikeContent"
                                                   class="reason hidden-xs-up g-pos-abs g-top-0 g-right-0"
                                                   type="checkbox">
                                            <div
                                                class="u-check-icon-checkbox-v4 g-absolute-centered--y g-right-0">
                                                <i class="fa" data-check-icon=""></i>
                                            </div>
                                            <span id="reason-2">محتوای صفحه مورد نظر باب میلم نیست</span>
                                        </label>
                                        <label class="d-block u-check g-pr-25">
                                            <input id="unlikeStyle" name="unlikeStyle"
                                                   class="reason hidden-xs-up g-pos-abs g-top-0 g-right-0"
                                                   type="checkbox">
                                            <div
                                                class="u-check-icon-checkbox-v4 g-absolute-centered--y g-right-0">
                                                <i class="fa" data-check-icon=""></i>
                                            </div>
                                            <span id="reason-3">استایل صفحه مورد نظر باب میلم نیست</span>
                                        </label>
                                        <label class="d-block u-check g-pr-25">
                                            <input id="lowPost" name="lowPost"
                                                   class="reason hidden-xs-up g-pos-abs g-top-0 g-right-0"
                                                   type="checkbox">
                                            <div
                                                class="u-check-icon-checkbox-v4 g-absolute-centered--y g-right-0">
                                                <i class="fa" data-check-icon=""></i>
                                            </div>
                                            <span id="reason-4">تعداد پست های صفحه مورد نظر مورد قبولم نیست</span>
                                        </label>
                                        <label class="d-block u-check g-pr-25">
                                            <input id="personalReason" name="lowPost"
                                                   class="reason hidden-xs-up g-pos-abs g-top-0 g-right-0"
                                                   type="checkbox">
                                            <div
                                                class="u-check-icon-checkbox-v4 g-absolute-centered--y g-right-0">
                                                <i class="fa" data-check-icon=""></i>
                                            </div>
                                            <span id="reason-5">دلایل شخصی</span>
                                        </label>
                                    </div>
                                </div>
                                <a onclick="actionStory('{{$listSourceID}}','{{$sellerMajorID}}','{{$sellerMajorID_ad}}','cancel','{{$mobile}}')"
                                   class="btn btn-md u-btn-lightred rounded-0 g-pa-15 g-color-white">
                                    <span id="cancelStoryText">رد تبلیغ</span>
                                    <i id="cancelStoryWaiting"
                                       class="d-none fa fa-spinner fa-spin m-0 g-font-size-20 g-color-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<div style="direction: rtl" class="modal fade text-center" id="regulation"
     tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog m-0 mx-lg-auto" role="document">
        <div style="min-height: 100vh" class="modal-content">
            <div style="position: sticky; top: 0; z-index: 100" class="modal-header g-bg-white g-pr-20 g-pl-20">
                <h5 class="m-0">راهنمای بارگذاری استوری اینستاگرام</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <i class="fa fa-close g-font-size-16"></i>
                </button>
            </div>
            <div style="direction: rtl"
                 class="alert alert-warning alert-dismissible fade show text-right g-pa-20--lg g-px-10 g-py-10"
                 role="alert">
                <h4 class="h5"><i class="fa fa-warning"></i>راهنمایی با یک مثال</h4>
                <p>کاربر عزیز جهت سهولت در یادگیری فرآیند کار، مراحل را با یک مثال توضیح داده ایم و تصاویر و آیدی زیر تنها
                    یک مثال است.</p>
            </div>
            <div style="direction: rtl" class="modal-body mx-3 text-right">
                <div class="g-pb-30">
                    <h4 style="direction: rtl" class="text-right">1. فعالیت امشب من</h4>
                    <p>فعالیت امشب من در کانون انعکاس که از طریق لینک پیامک برای من ارسال شده است.</p>
                    <img class="w-100 g-rounded-15"
                         src="{{asset('img/AdvertisingHelp/1.jpg?v=1')}}"
                         alt="Image Description">
                </div>
                <div class="g-py-30">
                    <h4 style="direction: rtl" class="text-right">2. ذخیره عکس</h4>
                    <p>با کلیک بر روی تصویر و نگه داشتن آن حالت ذخیره نمایان می شود.</p>
                    <img class="w-100 g-rounded-15"
                         src="{{asset('img/AdvertisingHelp/2.jpg')}}"
                         alt="Image Description">
                </div>
                <div class="g-py-30">
                    <h4 style="direction: rtl" class="text-right">3. کپی کردن آیدی</h4>
                    <img class="w-100 g-rounded-15"
                         src="{{asset('img/AdvertisingHelp/3.jpg?v=1')}}"
                         alt="Image Description">
                </div>
                <div class="g-py-30">
                    <h4 style="direction: rtl" class="text-right">4. گذاشتن استوری و افزودن متن</h4>
                    <img class="w-100 g-rounded-15"
                         src="{{asset('img/AdvertisingHelp/4.jpg')}}"
                         alt="Image Description">
                </div>
                <div class="g-py-30">
                    <h4 style="direction: rtl" class="text-right">5.تگ کردن آیدی</h4>
                    <img class="w-100 g-rounded-15"
                         src="{{asset('img/AdvertisingHelp/5.jpg')}}"
                         alt="Image Description">
                </div>
                <div class="g-py-30">
                    <h4 style="direction: rtl" class="text-right">6. بررسی تگ کامل</h4>
                    <img class="w-100 g-rounded-15"
                         src="{{asset('img/AdvertisingHelp/6.jpg')}}"
                         alt="Image Description">
                </div>
                <div class="g-py-30">
                    <h4 style="direction: rtl" class="text-right">7.اصلاح استایل و بارگذاری</h4>
                    <img class="w-100 g-rounded-15"
                         src="{{asset('img/AdvertisingHelp/7.jpg')}}"
                         alt="Image Description">
                </div>
                <div class="g-py-30">
                    <h4 style="direction: rtl" class="text-right g-color-orange">توجه مهم</h4>
                    <img class="w-100 g-rounded-15"
                         src="{{asset('img/AdvertisingHelp/8.jpg')}}"
                         alt="Image Description">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery-confirm.min.js') }}"></script>
<script>
    function actionStory(listSourceID, sellerMajorID, sellerMajorID_ad, status, mobile) {
        let reason = '';
        $('.reason').each(function (i) {
            if ($(this).is(":checked")) {
                reason = reason + $('#reason-' + i).text() + '. ';
            }
        })
        if (reason !== '' || status === 'accept') {
            let userOnline = window.location.pathname.split('/'), form = new FormData(),
                title = status === 'accept' ? 'تایید تبلیغ' : 'رد تبلیغ';
            form.append('userOnline', userOnline[2]);
            form.append('listSourceID', listSourceID);
            form.append('sellerMajorID', sellerMajorID);
            form.append('sellerMajorID_ad', sellerMajorID_ad);
            form.append('reason', reason);
            form.append('status', status);
            form.append('mobile', mobile);
            form.append('instagram', $('#sellerMajorInstaID').text());
            $('#cancelStoryText').addClass('d-none');
            $('#cancelStoryWaiting').removeClass('d-none');
            $.confirm({
                title: title,
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    بله: function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            data: form,
                            processData: false,
                            contentType: false,
                            url: '/sellerMajor-story-Cancel',
                            success: function (data) {
                                location.reload();
                            },
                            error: function () {
                                $('#cancelStoryText').removeClass('d-none');
                                $('#cancelStoryWaiting').addClass('d-none');
                                alert(title + ' ناموفق بود دوباره تلاش کنید..')
                            }
                        });
                    },
                    انصراف: function () {
                    },
                }
            });
        } else {
            alert('لطفا یک دلیل برای رد تبلیغ را بیان کنید.')
        }
    }
</script>
</body>

