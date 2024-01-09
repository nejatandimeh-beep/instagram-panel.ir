@extends('Layouts.IndexCustomer')
@section('Content')
    <span class="g-color-insta"></span>
    <div class="masterPage">
        <div>
            <div style="background-image: linear-gradient(to bottom, #ffffff,rgba(240,240,240,1),#ffffff);"
                 class="g-pt-50">
                <!-- بنر -->
                <div class="d-lg-flex justify-content-center mx-auto g-mb-100 g-mb-0--lg">
                    <div class="col-lg-6 p-0 text-center text-lg-right g-mb-50">
                        <a style="direction: rtl" href="{{route('feed')}}" class="w-100 text-decoration-none">
                            <img class="g-width-500--lg"
                                 src="{{asset('img/masterPage/master.png?v=222')}}"
                                 alt="">
                        </a>
                    </div>
                    <div class="text-lg-left col-lg-6 text-center align-self-center">
                        <div class="d-inline-block text-lg-right">
                            <h1 class="h3">دستیار اینستاگرام</h1>
                            <h2 style="color: #f02d4a !important;" class="h5">مجموعه ای از انواع مشاغل موجود در اینستاگرام</h2>
                            <h2 class="h5">هم ببین هم بخر هم دنبال کن و همچنین کسب و کارتو اضافه کن</h2>
                            <h5 class="g-mb-0 g-mt-15">
                                <a style="direction: rtl; border-radius: 10px 0 0 10px" href="{{route('feed')}}"
                                   class="btn btn-xl u-btn-insta ">
                                    دیدن پست ها
                                </a>
                                <a style="direction: rtl; border-radius: 0 10px 10px 0" href="{{ route('sellerLoginMode') }}"
                                   class="btn btn-xl u-btn-insta ">
                                    افزودن کسب وکار
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
                <div style="background-color: #231647" class="g-py-60">
                    <!-- معرفی دستیار اینستاگرام -->
                    <div class="g-px-10 g-color-white">
                        <!-- کسب و کار -->
                        <div class="d-lg-flex col-lg-8 justify-content-center g-py-20 mx-auto">
                            <div class="text-center col-lg-4 text-lg-left">
                                <img class="img-fluid" width="259" height="450"
                                     src="{{asset('img/masterPage/intro/business.jpg')}}"
                                     alt="">
                            </div>
                            <div class="text-right g-px-0 g-px-20--lg col-lg-8 align-self-center">
                                <h4>تو چطور</h4>
                                <p style="direction: rtl; text-align:justify">کسب و کارت رو <span class="g-color-insta">رونق</span> میدی؟ می دونستی سریعترین راه برای توسعه سریع یک شغل از طریق گنج بزرگی
                                    به نام <span class="g-color-insta">داده ها</span> و نشر آن توی اینترنت هستش!؟</p>
                            </div>
                        </div>
                        <!-- آمار -->
                        <div class="d-lg-flex col-lg-8 g-mt-40 justify-content-center g-py-20 mx-auto">
                            <div class="text-center col-lg-4 text-lg-left">
                                <img class="img-fluid" width="259" height="450"
                                     src="{{asset('img/masterPage/intro/rating.jpg')}}"
                                     alt="">
                            </div>
                            <div class="text-right g-px-0 g-px-20--lg col-lg-8 align-self-center">
                                <h4>طبق آمارهای جهانی و داخلی</h4>
                                <p style="direction: rtl; text-align:justify">با یک جستجوی ساده میشه پی برد در ژانویه ۲۰۲۲ (دی ۱۴۰۰) تعداد کاربران اینترنت در ایران <span
                                        class="g-color-insta">71.94</span> میلیون نفر بوده است. این درحالی‌ اسـت که جمعیت
                                    ایران <span class="g-color-insta">85.52</span> میلیون نفر بود. این یعنی بیش از <span
                                        class="g-color-insta">84</span> درصد ایرانیان بزرگتر از 10 سال در فضای مجازی حضور داشتند و این رقم
                                    اکنون بالای <span class="g-color-insta">90</span> درصد است که سهم بزرگ آن به ترتیب گوگل،
                                    واتس آپ و اینستاگرام و تلگرام بوده است.</p>
                            </div>
                        </div>
                        <!-- دونستن این موضوع -->
                        <div class="d-lg-flex col-lg-8 g-mt-40 justify-content-center g-py-20 mx-auto">
                            <div class="text-center col-lg-4 text-lg-left">
                                <img class="img-fluid" width="259" height="261"
                                     src="{{asset('img/masterPage/intro/data.jpg')}}"
                                     alt="">
                            </div>
                            <div class="text-right g-px-0 g-px-20--lg col-lg-8 align-self-center">
                                <h4>دونستن این موضوع</h4>
                                <p style="direction: rtl; text-align:justify"><span class="g-color-insta">برگ برنده</span> ایست برای انواع
                                    مشاغل تا از همین حالا در فکر معرفی و انتشار محتوای خود که همان <span
                                        class="g-color-insta">گنج داده ها</span> است در فضای مجازی باشند.</p>
                            </div>
                        </div>
                        <!-- اما -->
                        <div class="d-lg-flex col-lg-8 g-mt-40 justify-content-center g-py-20 mx-auto">
                            <div class="text-center col-lg-4 text-lg-left">
                                <img class="img-fluid" width="259" height="261"
                                     src="{{asset('img/masterPage/intro/tired.jpg')}}"
                                     alt="">
                            </div>
                            <div style="direction: rtl" class="text-right g-px-0 g-px-20--lg col-lg-8 align-self-center">
                                <h4>اما!</h4>
                                <p style="direction: rtl; text-align:justify">این راه مستلزم <span class="g-color-insta">توانایی فنی و صرف هزینه و زمان</span>
                                    زیادی است که از توانایی اکثریت مشاغل علل الخصوص مشاغل خرد خارج است. </p>
                            </div>
                        </div>
                        <!-- دستیار اینستاگرام -->
                        <div class="d-lg-flex col-lg-8 g-mt-40 justify-content-center g-py-20 mx-auto">
                            <div class="text-center col-lg-4 text-lg-left">
                                <img class="img-fluid" width="259" height="261"
                                     src="{{asset('img/masterPage/intro/assist.jpg')}}"
                                     alt="">
                            </div>
                            <div class="text-right g-px-0 g-px-20--lg col-lg-8 align-self-center">
                                <h4>دستیار اینستاگرام</h4>
                                <p style="direction: rtl; text-align:justify">راه را برایتان هموار کرده است تا با صرف <span
                                        class="g-color-insta">کمترین زمان و بدون هیچ هزینه</span>
                                    ای، محتوا و اطلاعات شغلی خود را در بستر بزرگ اینترنت نشر دهید و محصول یا محتوای خود را
                                    از
                                    سوی <span class="g-color-insta">موتورهای جستجو</span> همانند گوگل به دست مخاطبان بیشمار
                                    این
                                    بستر برسانید.</p>
                            </div>
                        </div>
                    </div>
                    <!-- تواناییهای دستیار -->
                    <div class="g-px-10 g-color-white">
                        <!-- اهداف -->
                        <div class="d-lg-flex col-lg-8 g-mt-40 justify-content-center g-pb-20 mx-auto">
                            <div class="text-center col-lg-4 text-lg-left">
                                <img class="img-fluid" width="259" height="450"
                                     src="{{asset('img/masterPage/intro/score.jpg')}}"
                                     alt="">
                            </div>
                            <div class="text-right g-px-0 g-px-20--lg col-lg-8 align-self-center">
                                <h4>اهداف پنل دستیار اینستاگرام</h4>
                                <h5 class="g-mb-0" style="direction: rtl">نشر محتوا در سراسر وب</h5>
                                <h5 class="g-mb-0" style="direction: rtl">کانون همکاری انعکاس</h5>
                                <h5 class="g-mb-0" style="direction: rtl">پشتیبان صفحه اینستاگرام</h5>
                            </div>
                        </div>
                        <!-- نشر محتوا -->
                        <div class="d-lg-flex col-lg-8 g-mt-40 justify-content-center g-pb-20 mx-auto">
                            <div class="text-center col-lg-4 text-lg-left">
                                <img class="img-fluid" width="259" height="450"
                                     src="{{asset('img/masterPage/intro/shareData.jpg')}}"
                                     alt="">
                            </div>
                            <div class="text-right g-px-0 g-px-20--lg col-lg-8 align-self-center">
                                <h4>نشر محتوای شما در سراسر وب</h4>
                                <p style="direction: rtl; text-align:justify">رشد و پیشرفت کاری در صفحات اجتماعی همانند اینستاگرام نیاز به فعالیت مداوم و همچنین شناخت کافی از الگوریتم های آن شبکه اجتماعی دارد. دستیار اینستاگرام با جدیدترین و کارامدترین متدهای طراحی وب راه اندازی شده و محصول یا محتوای شما را <span class="g-color-insta">از طریق موتورهای جستجو و ارتباط با صفحات اینستاگرام</span> به دست مخاطبان شما می رساند.</p>
                            </div>
                        </div>
                        <!-- کانون همکاری انعکاس -->
                        <div class="d-lg-flex col-lg-8 g-mt-40 justify-content-center g-pb-20 mx-auto">
                            <div class="text-center col-lg-4 text-lg-left">
                                <img class="img-fluid" width="259" height="450"
                                     src="{{asset('img/masterPage/intro/kanoon.jpg')}}"
                                     alt="">
                            </div>
                            <div class="text-right g-px-0 g-px-20--lg col-lg-8 align-self-center">
                                <h4>کانون همکاری انعکاس</h4>
                                <p style="direction: rtl; text-align:justify">اینستاگرام بستری مملو از کاربران ایرانیست بطوری که طبق آمار از هر <span class="g-color-insta">10</span> شغل <span class="g-color-insta">7</span> شغل دارای صفحات اینستاگرام است و همچنین زادگاه سیل عظیمی از کسب وکارهای نوین است. در چنین فضای پر محتوا و کاربری، دیده شدن یکی از کارهای پر هزینه و زمانبر خواهد بود. کانون انعکاس دستیار اینستاگرام بصورت کاملا خودکار و هوشمند از طریق استوری یک شرکت کننده در کانون، شما را <span class="g-color-insta">بدون صرف هیچ هزینه ای</span> به مخاطبان اینستاگرام معرفی خواهد کرد. و شما هم در قبال آن برای همان شرکت کننده یک استوری معرفی در حساب اینستاگرام خود قرار خواهید داد. تمامی فرایند <span class="g-color-insta">ساخت و تولید استوری</span> های معرفی بر اساس محتوای شما، بعهده دستیار اینستاگرام است و از <span class="g-color-insta">طریق پیامک</span> به سایر شرکت کنندگان ارسال خواهد شد.</p>
                            </div>
                        </div>
                        <!-- پشتیبان صفحه -->
                        <div class="d-lg-flex col-lg-8 g-mt-40 justify-content-center g-pb-20 mx-auto">
                            <div class="text-center col-lg-4 text-lg-left">
                                <img class="img-fluid" width="259" height="450"
                                     src="{{asset('img/masterPage/intro/dataLoss.jpg')}}"
                                     alt="">
                            </div>
                            <div class="text-right g-px-0 g-px-20--lg col-lg-8 align-self-center">
                                <h4>پشتیبان حساب اینستاگرام</h4>
                                <p style="direction: rtl; text-align:justify">بعضی از کاربران اینستاگرام براشون پیش اومده که از طرف هوش مصنوعی اینستاگرام با <span class="g-color-insta">محدودیت</span> هایی روبرو شدن و یا حساب کاربریشون کاملا از <span class="g-color-insta">دسترس خارج</span> شده!</p>
                                <p style="direction: rtl; text-align:justify">این به معنی از دست رفتن رد پای شما در فضای مجازی و سطح وب است و عملا تا حد بسیار زیادی ارتباط شما با مخاطبانتان قطع خواهد شد.</p>
                                <h5 style="direction: rtl" class="g-mb-0">چاره چیست؟</h5>
                                <p style="direction: rtl; text-align:justify"class="g-mb-0">اینجا است که تنها راه بقا در فضای مجازی و وب یک حساب پشتیبان است. دستیار اینستاگرام برای اولین بار در ایران یک حساب پشتیبان برای دارندگان صفحات اجتماعی محسوب می شود که داده های شما را برای همیشه در سطح اینترنت بصورت امن نگه می دارد تا زحمات شما عزیزان به طور کامل هدر نرود.</p>
                                <p style="direction: rtl; text-align:justify">هنگامی که شما محصول یا محتوای خود را به پنل اینستا گرام اضافه می کنید با توجه به اینکه بستر دستیار اینستاگرام بر پایه پلت فرم اینستاگرام طراحی شده، می توانید لینک حساب دستیار اینستاگرام خود را در پروفایل حساب جدیدتان در اینستاگرام قرار دهید تا کاربران به محض کلیک بر روی آن به داده های قبلی شما دسترسی پیدا کنند.</p>
                            </div>
                        </div>
                        <!-- نحوه ثبت نام -->
                        <div class="d-lg-flex col-lg-8 g-mt-40 justify-content-center g-pb-20 mx-auto">
                            <div class="text-center col-lg-4 text-lg-left">
                                <img class="img-fluid" width="259" height="450"
                                     src="{{asset('img/masterPage/intro/signup.jpg')}}"
                                     alt="">
                            </div>
                            <div class="text-right g-px-0 g-px-20--lg col-lg-8 align-self-center">
                                <h4>نحوه ثبت نام</h4>
{{--                                <p style="direction: rtl; text-align:justify">از طریق لینک زیر همین الان کسب و کار خودت رو اضافه و در کانون انعکاس شرکت کن تا در لیست شرکت کنندگان کانون انعکاس <span class="g-color-insta">بصورت رایگان</span> برای <span class="g-color-insta">همیشه</span> حضور داشته باشی.</p>--}}
                                <p style="direction: rtl; text-align:justify">از طریق لینک زیر همین الان کسب و کار خودت رو اضافه کن..</p>
                                <h5 style="direction: rtl" class="g-mb-0 g-color-yellow">توجه!</h5>
{{--                                <p style="direction: rtl; text-align:justify">مدت <span class="g-color-yellow"> طرح رایگان محدود</span> می باشد و پس از انقضای آن، برای <span class="g-color-yellow">شرکت کنندگان جدید تعرفه مالی</span> وضع خواهد شد.</p>--}}
                                <p style="direction: rtl; text-align:justify"><span class="g-color-yellow"> طرح رایگان</span> تنها شامل کاربرانی می شود که  <span class="g-color-yellow">دعوت نامه</span> برای آنها ارسال شده است.</p>
                                <h5 style="direction: rtl">
                                    <a href="{{ route('sellerLoginMode') }}" class="btn btn-xl rounded-0 u-btn-insta force-col-12 u-btn-content g-font-weight-600 g-letter-spacing-0_5 text-uppercase g-brd-2 g-mb-15">
                                    <span class="text-center">
                                        ثبت نام
                                      <span class="d-block g-font-size-11">افزودن کسب و کار</span>
                                    </span>
                                    </a>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
