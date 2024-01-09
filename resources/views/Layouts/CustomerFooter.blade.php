@section('CustomerFooter')

    <div>
        <!-- Contact Info -->
        <div class="g-bg-black g-color-white text-center g-py-100">
            <div class="container">
                <header class="u-heading-v8-2 text-center g-width-70x--md mx-auto g-mb-80">
                    <h2 class="u-heading-v8__title text-uppercase g-font-weight-600 g-mb-25">در باره ما</h2>
                    <p class="lead g-mb-40 g-font-size-14">نیاز روز افزون جامعه به خدمات حرفه ای در دنیای مجازی ما را بر
                        آن داشت تا در توسعه مشاغل اینترنتی این بستر را در سراسر کشور ارتقا دهیم.
                        دستیار اینستاگرام با هدف ساده سازی فرایند دسترسی، تعامل و رشد هر چه بیشتر صفحات اینستاگرام و همچنین نشر محتوای شغلی شما در سراسر وب، برای اولین بار در ایران در تلاش است بستری مناسب برای شما
                        عزیزان در این زمینه فراهم آورد.<a href="{{route('aboutMe')}}" class="g-mr-5 g-color-insta">بیشتر</a>
                    </p>

                    {{--                    <p class="lead g-mb-40 g-font-size-14">نیاز روز افزون جامعه به خدمات حرفه ای در دنیای مجازی ما را بر آن داشت تا در--}}
                    {{--                        صنعت مد و پوشاک این بستر را در سرار کشور ارتقا دهیم. تانا استایل با هدف ساده سازی فرایند خرید پوشاک در فضای مجازی و همچنین با عرضه مستقیم بهترین برندهای پوشاک از بازارچه های مرزی در تلاش است بستری مناسب برای شما عزیزان در زمینه مد و پوشاک فراهم آورد.<a href="#" class="g-mr-5">بیشتر</a> </p>--}}

                    <address class="row g-color-white-opacity-0_8 mb-0">
                        <div class="col-sm-6 col-md-3 g-brd-right--md g-brd-white-opacity-0_3 g-mb-60 g-mb-0--md">
                            <i class="icon-user-following d-inline-block display-5 g-color-insta g-mb-25"></i>
                            <h4 class="small text-uppercase g-mb-5">افزودن کسب و کار</h4>
                            <a href="{{ route('sellerLoginMode') }}" class="g-color-insta"><strong>.. شروع کن</strong></a>
                        </div>

                        <div class="col-sm-6 col-md-3 g-brd-right--md g-brd-white-opacity-0_3 g-mb-60 g-mb-0--md">
                            <i class="icon-notebook d-inline-block display-5 g-color-insta g-mb-25"></i>
                            <h4 class="small text-uppercase g-mb-5">راهنمای استفاده</h4>
                            <a href="{{route('help')}}" class="g-color-insta"><strong>پنل دستیار اینستاگرام</strong></a>
                        </div>

                        <div class="col-sm-6 col-md-3 g-brd-right--md g-brd-white-opacity-0_3 g-mb-60 g-mb-0--md">
                            <i class="icon-envelope d-inline-block display-5 g-color-insta g-mb-25"></i>
                            <h4 class="small text-uppercase g-mb-5">ایمیل ما</h4>
                            <a class="g-color-white-opacity-0_8" href="mailto:hello@unify-gym.com"><strong>info@instagram-panel.com</strong></a>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <i class="icon-earphones-alt d-inline-block display-5 g-color-insta g-mb-25"></i>
                            <h4 class="small text-uppercase g-mb-5">پشتیبانی</h4>
                            <a href="#" onclick="newConnection()" class="g-color-insta"><strong>آغاز گفتگو</strong></a>
                        </div>
                    </address>
                </header>
            </div>
        </div>
        <!-- End Contact Info -->

        <!-- Social Links -->
        <ul class="row no-gutters list-inline g-mb-0">
            <li class="col list-inline-item g-mr-0">
                <a style="text-decoration: none; color: white !important;"
                   class="d-block g-bg-insta g-bg-instagram--hover g-font-size-16 text-center g-transition-0_2 g-pa-15"
                   href="https://www.instagram.com/insta.panel.ir/">
                    <i style="color: white !important;" class="fa fa-instagram"></i> Instagram
                </a>
            </li>
            <li class="col list-inline-item g-mr-0">
                <a style="text-decoration: none; color: white !important;"
                   class="d-block g-bg-insta g-bg-instagram--hover g-font-size-16 text-center g-transition-0_2 g-pa-15"
                   href="https://www.t.me/insta_panel_ir">
                    <i style="color: white !important;" class="fa fa-telegram"></i> Telegram
                </a>
            </li>
        </ul>
        <!-- End Social Links -->

        <!-- Copyright and Subscribe -->
        <footer class="text-center g-py-2">
            <div class="col-12 p-0">
                <div id="shortcode10">
                    <div class="shortcode-html">
                        <!-- Contact Info -->
                        <div class="row no-gutters g-color-white text-center">
{{--                            <div class="col-md-6 col-lg-6 g-bg-primary-dark-v3 g-py-60">--}}
{{--                                <a referrerpolicy="origin"--}}
{{--                                   target="_blank"--}}
{{--                                   href="https://trustseal.enamad.ir/?id=241578&amp;Code=gEEBxepfVp0Ayi5kPrbt">--}}
{{--                                    <img referrerpolicy="origin"--}}
{{--                                         src="{{asset('img/Other/enamad.jpg')}}"--}}
{{--                                         alt=""--}}
{{--                                         style="cursor:pointer"--}}
{{--                                         id="gEEBxepfVp0Ayi5kPrbt">--}}
{{--                                </a>--}}
{{--                                <strong class="d-block g-font-size-16 g-mt-10">نشان اعتماد الکترونیک</strong>--}}
{{--                            </div>--}}

                            <div class="col-md-12 col-lg-12 g-bg-insta g-py-60">
                                <a href="{{route('regulation','regular')}}">
                                    <div class="d-inline-block g-px-15 g-pt-15 g-pb-15">
                                        <img referrerpolicy="origin"
                                             src="{{asset('img/Other/regulation.png')}}"
                                             alt="قوانین و مقررات فروشگاه پوشاک" width="82">
                                    </div>
                                </a>
                                <strong class="d-block g-color-white g-font-size-16 g-mt-10">قوانین و مقررات استفاده</strong>
                            </div>
                        </div>

                        <!-- End Contact Info -->
                    </div>
                </div>
                {{--                <form>--}}
                {{--                    <div class="form-group g-width-60x--md mx-auto g-mb-20">--}}
                {{--                        <label class="h5 text-uppercase g-mb-20">از جدیدترین ها با خبر شوید</label>--}}
                {{--                        <div class="input-group g-brd-gray-light-v2 g-brd-primary--focus">--}}
                {{--                            <input class="form-control form-control-md g-brd-right-none rounded-0 pr-0" type="text"--}}
                {{--                                   placeholder="ایمیل شما">--}}
                {{--                            <div--}}
                {{--                                class="input-group-addon d-flex align-items-center g-color-gray-light-v2 g-bg-white rounded-0">--}}
                {{--                                <i class="icon-envelope"></i>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </form>--}}

                <small class="d-block g-pa-15">تمامی حقوق این وب سایت برای شرکت تابش پس زمینه مکریان
                    محفوظ است 1400</small>
            </div>
        </footer>
        <!-- End Copyright and Subscribe -->
    </div>
@endsection
