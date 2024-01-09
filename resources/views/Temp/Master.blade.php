@extends('Layouts.IndexCustomer')
@section('Content')
<section class="dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll loaded dzsprx-readyall masterPage" data-options="{direction: &quot;reverse&quot;, settings_mode_oneelement_max_offset: &quot;150&quot;}">
    <div class="divimage dzsparallaxer--target w-100" style="height: 140%; background-image: url('{{asset("img/Banners/1920_791.jpg")}}'); transform: translate3d(0px, -83.849px, 0px);"></div>

    <!-- Promo Block Content -->
    <div style="height: 140%; background-image: url('{{asset("img/Banners/1920_791.jpg")}}'); transform: translate3d(0px, -83.849px, 0px);"
         class="g-bg-cover g-bg-pos-top-center g-bg-img-hero g-bg-bluegray-opacity-0_3--after g-py-150">
        <div class="container text-center g-z-index-1">
            <h1 class="d-none h1 g-color-white g-font-weight-600 g-mb-15">فروشگاه آنلاین پوشاک استوک و تاناکورا tanakora mahabad estok بدلیجات عینک زنانه پوشاک زنانه</h1>
            <h2 class="h1 g-color-primary g-font-weight-600 g-mb-15 bigDevice">تانا استایل
                <span class="g-color-white">استایلی خاص و متفاوت</span></h2>

            <h3 class="g-color-primary g-font-weight-600 g-mb-15 smallDevice">تانا استایل
                <span class="g-color-white">استایلی خاص و متفاوت</span></h3>
            <h4 class="g-color-white g-font-weight-600 g-mb-30">خریدی آسان، سریع و مطمئن</h4>
            <!-- Promo Blocks - Form -->
            <form style="direction: rtl" class="align-self-center text-center">
                <input oninput="productSearch('productSearch',$(this).attr('value'))"
                       onclick="$('#productSearch').removeClass('d-none')"
                       style="direction:rtl; padding: 10px; outline: none; border:none; opacity:0.9; border-radius: 0"
                       class="col-lg-6 col-12 g-font-size-16"
                       type="text" placeholder="تایپ کن و بگرد..">
                <ul id="productSearch" class="d-none p-0 col-lg-9 col-11 m-auto outSideClick"></ul>
            </form>
            <!-- End Promo Blocks - Form -->
        </div>
    </div>
    <!-- End Promo Block Content -->
</section>
<div class="container g-py-80">
    <div class="row m-0">
        <div class="col-lg-4 g-mb-0--lg g-mb-30">
            <!-- Icon Blocks -->
            <div class="text-center u-icon-block--hover">
                    <span
                        class="d-inline-block u-icon-v4 u-icon-v4-rounded-50x u-icon-size--xl u-icon-v4-bg-primary--hover g-color-white--hover g-mb-20">
                      <span class="u-icon-v4-inner">
                        <i class="icon-present g-mt-5 g-ml-5"></i>
                      </span>
                    </span>
                <h1 class="h5 g-color-black mb-3">کسب 3 امتیاز در تانا استایل</h1>
                <p class="g-color-gray-dark-v4">ارسال محصول برای همیشه رایگان</p>
            </div>
            <!-- End Icon Blocks -->
        </div>

        <div class="col-lg-4 g-mb-0--lg g-mb-30">
            <!-- Icon Blocks -->
            <div class="text-center u-icon-block--hover">
                    <span
                        class="d-inline-block u-icon-v4 u-icon-v4-rounded-50x u-icon-size--xl u-icon-v4-bg-primary--hover g-color-white--hover g-mb-20">
                      <span class="u-icon-v4-inner">
                        <i class="icon-present g-mt-5"></i>
                      </span>
                    </span>
                <h1 class="h5 g-color-black mb-3">کسب 15 امتیاز در تانا استایل</h1>
                <p class="g-color-gray-dark-v4">ورود به قرعه کشی یک سال خرید با تخفیف مازاد</p>
            </div>
            <!-- End Icon Blocks -->
        </div>

        <div class="col-lg-4 g-mb-0--lg g-mb-30">
            <!-- Icon Blocks -->
            <div class="text-center u-icon-block--hover">
                    <span
                        class="d-inline-block u-icon-v4 u-icon-v4-rounded-50x u-icon-size--xl u-icon-v4-bg-primary--hover g-color-white--hover g-mb-20">
                      <span class="u-icon-v4-inner">
                        <i class="icon-present g-mt-5"></i>
                      </span>
                    </span>
                <h1 class="h5 g-color-black mb-3">کسب 8 امتیاز در تانا استایل</h1>
                <p class="g-color-gray-dark-v4">یک خرید رایگان تا سقف محدود</p>
            </div>
            <!-- End Icon Blocks -->
        </div>
    </div>
</div>
<div id="newProductContainer">
    <div>
        <div class="dzsparallaxer auto-init height-is-based-on-content use-loading g-bg-cover g-bg-black-opacity-0_5--after mode-scroll">
            <div class="divimage dzsparallaxer--target w-100" style="height: 140%; background-image: url({{asset('img/Other/newProduct/bigWall.jpg?v=873')}}); transform: translate3d(0px, -76.6067px, 0px);"></div>

            <div class="container g-z-index-1 g-py-120">
                <div class="js-carousel g-pb-80"
                     data-infinite="1"
                     data-arrows-classes="u-arrow-v1 g-width-40 g-height-40 g-brd-1 g-brd-style-solid g-brd-white-opacity-0_6 g-brd-primary--hover g-color-white-opacity-0_5 g-bg-primary--hover g-color-white--hover g-absolute-centered--x g-bottom-0"
                     data-arrow-left-classes="fa fa-angle-left g-ml-minus-25"
                     data-arrow-right-classes="fa fa-angle-right g-ml-25">
                    <div class="js-slide">
                        <!-- Testimonials Advanced -->
                        <div class="text-center g-px-100--lg">
                            <h1 class="h3 g-color-primary">جدید ترین های پوشاک زنانه</h1>
                            <blockquote style="direction: rtl" class="g-color-white g-font-size-25 g-py-40">ما همواره سعی داریم جدیدترین های پوشاک را در فروشگاهمان گرد هم آوریم تا مخاطبان عزیز بتوانند محصولات ترند رو در زمانی کوتاه تر پیدا کرده و استایل خود را به روز نگه دارند.</blockquote>
                            <h4 class="h6 g-color-white-opacity-0_7 text-uppercase g-mb-0">
                                محصولات اخیر
                                <em class="g-font-style-normal g-color-primary">تانا استایل</em>
                            </h4>
                        </div>
                        <!-- End Testimonials Advanced -->
                    </div>


                    <div class="js-slide">
                        <!-- Testimonials Advanced -->
                        <div class="text-center g-px-100--lg">
                            <i class="d-block g-color-primary g-font-size-60 g-line-height-0_7 g-pos-rel g-top-20">“</i>
                            <blockquote class="g-color-white g-font-size-25 g-py-40">عینک آفتابی، بند عینک، گوشواره، گردنبند، دستبند، انگشتر، پا بند، پیراهن</blockquote>
                            <h4 class="h6 g-color-white-opacity-0_7 text-uppercase g-mb-0">
                                محصولات موجود در فروشگاه
                                <em class="g-font-style-normal g-color-primary">هم اکنون</em>
                            </h4>
                        </div>
                        <!-- End Testimonials Advanced -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container g-px-0--lg">


        <div id="js-carousel-0" class="js-carousel g-mb-15--lg g-mb-60 g-mx-minus-10 g-py-60--lg g-pt-20 g-pb-60"
             data-infinite="true"
             data-slides-show="4"
             data-autoplay="0"
             data-speed="5000"
             data-arrows-classes="u-arrow-v1 g-pos-abs g-bottom-0 g-width-45 g-height-45 g-color-gray-dark-v5 g-bg-secondary g-color-white--hover g-bg-primary--hover rounded"
             data-arrow-left-classes="fa fa-angle-left g-left-20 rounded-0"
             data-arrow-right-classes="fa fa-angle-right g-right-20 rounded-0"
             data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center">
            @foreach($newProduct as $key =>$row)
                <div class="js-slide g-mx-10">
                    <!-- Product -->
                    <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-15">
                        <div>
                            <div id="carousel-08-{{$key}}"
                                 class="js-carousel text-center g-mb-5"
                                 data-infinite="1"
                                 data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                                 data-nav-for="#carousel-08-{{$key}}">
                                <div class="js-slide">
                                    <a href="{{ route('productDetail',[$row->ProductID, $row->Size]) }}">
                                        <img class="img-fluid w-100" loading="lazy"
                                             src="{{ $row->PicPath.$row->SampleNumber.'.jpg' }}"
                                             alt="{{ $row->Name.' '.$row->Model.' '.$row->Gender.' '.$row->Brand.' '.$row->Size.' '.$row->Color  }}">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- مشخصات محصول -->
                        <div style="direction: rtl" class="media g-mt-5 g-brd-top g-brd-gray-light-v4 g-pt-5">
                            <!-- نام و مدل و جنسیت و دسته و تخفیف و قیمت -->
                            <div class="d-flex flex-column col-12 g-px-5">
                                <h1 class="h6 g-color-black my-1 text-left">
                                    {{$row->Brand}}
                                </h1>
                                <h4 class="h6 g-color-black my-1">
                                    <span class="u-link-v5 g-color-black"
                                          tabindex="0">
                                        {{ $row->Name }}
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Model }}</span>
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Gender }}</span>
                                    </span>
                                </h4>
                                <div>
                                    <span class="g-ml-5">سایز
                                        <span class="g-color-primary">{{ $row->Size }}</span>
                                    </span>
                                    <span>رنگ
                                        <span class="g-color-primary">{{ $row->Color }}</span>
                                    </span>
                                </div>
                                <span class="{{ $row->Qty ==0 ?'opacity-0': '' }}">موجودی <span id="{{ 'cartQty'.$key }}"
                                                   class="g-color-primary">{{ $row->Qty }}</span> عدد</span>
                            </div>
                        </div>
                        <div
                            class="d-block g-color-black g-font-size-17 g-ml-5">
                            <div style="direction: rtl" class="text-left">
                                <s class="g-color-lightred g-font-weight-500 g-font-size-13">
                                    {{  number_format($row->FinalPriceWithoutDiscount) }}
                                </s>
                                <span>{{ number_format($row->FinalPrice) }}</span>
                                <span
                                    class="d-block g-color-gray-light-v2 g-font-size-10">تومان</span>
                            </div>
                        </div>
                    </figure>
                    <!-- End Product -->
                </div>
            @endforeach
            <div class="js-slide g-mx-10">
                <!-- Product -->
                <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-5">
                    <div>
                        <div id="carousel-08-{{$key+1}}"
                             class="js-carousel text-center g-mb-5"
                             data-infinite="1"
                             data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                             data-nav-for="#carousel-08-{{$key+1}}">
                            <div class="js-slide">
                                <a href="{{ route('moreItem','newProduct') }}" class="customLinkHover">
                                    <div class="moreItem">
                                        <span style="position: absolute; left:45px; text-shadow: 0 0 5px navy;" class="h1 g-color-white g-top-50x">بیشتر ببینید</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </figure>
                <!-- End Product -->
            </div>
        </div>
    </div>
</div>
<div id="sunGlassContainer">
    <div>
        <div class="dzsparallaxer auto-init height-is-based-on-content use-loading g-bg-cover g-bg-black-opacity-0_5--after mode-scroll">
            <div class="divimage dzsparallaxer--target w-100" style="height: 140%; background-image: url({{asset('img/Other/sunglass/bigWall.jpg?v=873')}}); transform: translate3d(0px, -76.6067px, 0px);"></div>

            <div class="container g-z-index-1 g-py-120">
                <div class="js-carousel g-pb-80" data-infinite="1" data-arrows-classes="u-arrow-v1 g-width-40 g-height-40 g-brd-1 g-brd-style-solid g-brd-white-opacity-0_6 g-brd-primary--hover g-color-white-opacity-0_5 g-bg-primary--hover g-color-white--hover g-absolute-centered--x g-bottom-0" data-arrow-left-classes="fa fa-angle-left g-ml-minus-25" data-arrow-right-classes="fa fa-angle-right g-ml-25">
                    <div class="js-slide">
                        <!-- Testimonials Advanced -->
                        <div class="text-center g-px-100--lg">
                            <h1 class="h3 g-color-primary">عینک و بند عینک زنانه</h1>
                            <blockquote style="direction: rtl" class="g-color-white g-font-size-25 g-py-40">محافظ اشعه uv400 خورشید، عدسی مخصوص هوای ابری و آفتابی (cat.1)،  عدسی پلی کربنات فشرده نشکن، فریم تمام کائوچویی عاری از پلاستیک، دارای شناسنامه و برچسب اصالت، دارای بارکد آنلاین فروشگاهی</blockquote>
                            <h4 class="h6 g-color-white-opacity-0_7 text-uppercase g-mb-0">
                                خاص ترین های عینک
                                <em class="g-font-style-normal g-color-primary">تانا استایل</em>
                            </h4>
                        </div>
                        <!-- End Testimonials Advanced -->
                    </div>

                    <div class="js-slide">
                        <!-- Testimonials Advanced -->
                        <div class="text-center g-px-100--lg">
                            <i class="d-block g-color-primary g-font-size-60 g-line-height-0_7 g-pos-rel g-top-20">“</i>
                            <blockquote class="g-color-white g-font-size-25 g-pt-40 m-0">مخصوص هوای ابری (Cat 0)</blockquote>
                            <blockquote class="g-color-white g-font-size-25 g-py-0 m-0">مخصوص هوای ابری و آفتابی (Cat 1)</blockquote>
                            <blockquote class="g-color-white g-font-size-25 g-py-0 m-0">مخصوص هوای آفتابی (Cat 2)</blockquote>
                            <blockquote class="g-color-white g-font-size-25 g-py-0 m-0">مخصوص هوای آفتابی نسبتا شدید (Cat 3)</blockquote>
                            <blockquote class="g-color-white g-font-size-25 g-pb-40 m-0">مخصوص هوای آفتابی شدید (Cat 4)</blockquote>
                        </div>
                        <!-- End Testimonials Advanced -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container g-px-0--lg">


        <div id="js-carousel-1" class="js-carousel g-mb-15--lg g-mb-60 g-mx-minus-10 g-py-60--lg g-pt-20 g-pb-60"
             data-infinite="true"
             data-slides-show="4"
             data-autoplay="0"
             data-speed="5000"
             data-arrows-classes="u-arrow-v1 g-pos-abs g-bottom-0 g-width-45 g-height-45 g-color-gray-dark-v5 g-bg-secondary g-color-white--hover g-bg-primary--hover rounded"
             data-arrow-left-classes="fa fa-angle-left g-left-20 rounded-0"
             data-arrow-right-classes="fa fa-angle-right g-right-20 rounded-0"
             data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center">
            @foreach($glass as $key =>$row)
                <div class="js-slide g-mx-10">
                    <!-- Product -->
                    <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-15">
                        <div>
                            <div id="carousel-08-{{$key}}"
                                 class="js-carousel text-center g-mb-5"
                                 data-infinite="1"
                                 data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                                 data-nav-for="#carousel-08-{{$key}}">
                                <div class="js-slide">
                                    <a href="{{ route('productDetail',[$row->ProductID, $row->Size]) }}">
                                        <img class="img-fluid w-100" loading="lazy"
                                             src="{{ $row->PicPath.$row->SampleNumber.'.jpg' }}"
                                             alt="{{ $row->Name.' '.$row->Model.' '.$row->Gender.' '.$row->Brand.' '.$row->Size.' '.$row->Color  }}">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- مشخصات محصول -->
                        <div style="direction: rtl" class="media g-mt-5 g-brd-top g-brd-gray-light-v4 g-pt-5">
                            <!-- نام و مدل و جنسیت و دسته و تخفیف و قیمت -->
                            <div class="d-flex flex-column col-12 g-px-5">
                                <h1 class="h6 g-color-black my-1 text-left">
                                    {{$row->Brand}}
                                </h1>
                                <h4 class="h6 g-color-black my-1">
                                    <span class="u-link-v5 g-color-black"
                                          tabindex="0">
                                        {{ $row->Name }}
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Model }}</span>
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Gender }}</span>
                                    </span>
                                </h4>
                                <div>
                                    <span class="g-ml-5">سایز
                                        <span class="g-color-primary">{{ $row->Size }}</span>
                                    </span>
                                    <span>رنگ
                                        <span class="g-color-primary">{{ $row->Color }}</span>
                                    </span>
                                </div>
                                <span class="{{ $row->Qty ==0 ?'opacity-0': '' }}">موجودی <span id="{{ 'cartQty'.$key }}"
                                                   class="g-color-primary">{{ $row->Qty }}</span> عدد</span>
                            </div>
                        </div>
                        <div
                            class="d-block g-color-black g-font-size-17 g-ml-5">
                            <div style="direction: rtl" class="text-left">
                                <s class="g-color-lightred g-font-weight-500 g-font-size-13">
                                    {{  number_format($row->FinalPriceWithoutDiscount) }}
                                </s>
                                <span>{{ number_format($row->FinalPrice) }}</span>
                                <span
                                    class="d-block g-color-gray-light-v2 g-font-size-10">تومان</span>
                            </div>
                        </div>
                    </figure>
                    <!-- End Product -->
                </div>
            @endforeach
                <div class="js-slide g-mx-10">
                    <!-- Product -->
                    <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-5">
                        <div>
                            <div id="carousel-08-{{$key+1}}"
                                 class="js-carousel text-center g-mb-5"
                                 data-infinite="1"
                                 data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                                 data-nav-for="#carousel-08-{{$key+1}}">
                                <div class="js-slide">
                                    <a href="{{ route('moreItem','730') }}" class="customLinkHover">
                                        <div class="moreItem">
                                            <span style="position: absolute; left:45px; text-shadow: 0 0 5px navy;" class="h1 g-color-white g-top-50x">بیشتر ببینید</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </figure>
                    <!-- End Product -->
                </div>
        </div>
    </div>
</div>
<div id="dressContainer">
    <div>
        <div class="dzsparallaxer auto-init height-is-based-on-content use-loading g-bg-cover g-bg-black-opacity-0_5--after mode-scroll">
            <div class="divimage dzsparallaxer--target w-100" style="height: 140%; background-image: url({{asset('img/Other/dress/bigWall.jpg?v=873')}}); transform: translate3d(0px, -76.6067px, 0px);"></div>

            <div class="container g-z-index-1 g-py-120">
                <div class="js-carousel g-pb-80" data-infinite="1" data-arrows-classes="u-arrow-v1 g-width-40 g-height-40 g-brd-1 g-brd-style-solid g-brd-white-opacity-0_6 g-brd-primary--hover g-color-white-opacity-0_5 g-bg-primary--hover g-color-white--hover g-absolute-centered--x g-bottom-0" data-arrow-left-classes="fa fa-angle-left g-ml-minus-25" data-arrow-right-classes="fa fa-angle-right g-ml-25">
                    <div class="js-slide">
                        <!-- Testimonials Advanced -->
                        <div class="text-center g-px-100--lg">
                            <h1 class="h3 g-color-primary">پیراهن زنانه </h1>

                            <blockquote style="direction: rtl" class="g-color-white g-font-size-25 g-py-40">با پارچه های دوست دار پوست و بهترین الگوهای برش و همراه با کیفیت بالای دوخت</blockquote>
                            <h4 class="h6 g-color-white-opacity-0_7 text-uppercase g-mb-0">
                                پیراهن های مجلسی، کژوال
                                <em class="g-font-style-normal g-color-primary">تانا استایل</em>
                            </h4>
                        </div>
                        <!-- End Testimonials Advanced -->
                    </div>

                    <div class="js-slide">
                        <!-- Testimonials Advanced -->
                        <div dir="rtl" class="text-center g-px-100--lg">
                            <i class="d-block g-color-primary g-font-size-60 g-line-height-0_7 g-pos-rel g-top-20">“</i>
                            <blockquote class="g-color-white g-font-size-20 g-py-20">پیراهن مدل مردانه، نیم تنه، تمام تنه، ساحلی، ماکسی..</blockquote>
                            <h4 class="h6 g-color-white-opacity-0_7 text-uppercase g-mb-0">
                                در انواع طرح و رنگ مختلف
                            </h4>
                        </div>
                        <!-- End Testimonials Advanced -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container g-px-0--lg">
        <div id="js-carousel-6" class="js-carousel g-mb-15--lg g-mb-60 g-mx-minus-10 g-py-60--lg g-pt-20 g-pb-60"
             data-infinite="true"
             data-slides-show="4"
             data-autoplay="0"
             data-speed="5000"
             data-arrows-classes="u-arrow-v1 g-pos-abs g-bottom-0 g-width-45 g-height-45 g-color-gray-dark-v5 g-bg-secondary g-color-white--hover g-bg-primary--hover rounded"
             data-arrow-left-classes="fa fa-angle-left g-left-20 rounded-0"
             data-arrow-right-classes="fa fa-angle-right g-right-20 rounded-0"
             data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center">
            @foreach($dress as $key =>$row)
                <div class="js-slide g-mx-10">
                    <!-- Product -->
                    <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-15">
                        <div>
                            <div id="carousel-08-{{$key}}"
                                 class="js-carousel text-center g-mb-5"
                                 data-infinite="1"
                                 data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                                 data-nav-for="#carousel-08-{{$key}}">
                                <div class="js-slide">
                                    <a href="{{ route('productDetail',[$row->ProductID, $row->Size]) }}">
                                        <img class="img-fluid w-100" loading="lazy"
                                             src="{{ $row->PicPath.$row->SampleNumber.'.jpg' }}"
                                             alt="{{ $row->Name.' '.$row->Model.' '.$row->Gender.' '.$row->Brand.' '.$row->Size.' '.$row->Color  }}">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- مشخصات محصول -->
                        <div style="direction: rtl" class="media g-mt-5 g-brd-top g-brd-gray-light-v4 g-pt-5">
                            <!-- نام و مدل و جنسیت و دسته و تخفیف و قیمت -->
                            <div class="d-flex flex-column col-12 g-px-5">
                                <h1 class="h6 g-color-black my-1 text-left">
                                    {{$row->Brand}}
                                </h1>
                                <h4 class="h6 g-color-black my-1">
                                    <span class="u-link-v5 g-color-black"
                                          tabindex="0">
                                        {{ $row->Name }}
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Model }}</span>
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Gender }}</span>
                                    </span>
                                </h4>
                                <div>
                                    <span class="g-ml-5">سایز
                                        <span class="g-color-primary">{{ $row->Size }}</span>
                                    </span>
                                    <span>رنگ
                                        <span class="g-color-primary">{{ $row->Color }}</span>
                                    </span>
                                </div>
                                <span class="{{ $row->Qty ==0 ?'opacity-0': '' }}">موجودی <span id="{{ 'cartQty'.$key }}"
                                                   class="g-color-primary">{{ $row->Qty }}</span> عدد</span>
                            </div>
                        </div>
                        <div
                            class="d-block g-color-black g-font-size-17 g-ml-5">
                            <div style="direction: rtl" class="text-left">
                                <s class="g-color-lightred g-font-weight-500 g-font-size-13">
                                    {{  number_format($row->FinalPriceWithoutDiscount) }}
                                </s>
                                <span>{{ number_format($row->FinalPrice) }}</span>
                                <span
                                    class="d-block g-color-gray-light-v2 g-font-size-10">تومان</span>
                            </div>
                        </div>
                    </figure>
                    <!-- End Product -->
                </div>
            @endforeach
            <div class="js-slide g-mx-10">
                <!-- Product -->
                <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-5">
                    <div>
                        <div id="carousel-08-{{$key+1}}"
                             class="js-carousel text-center g-mb-5"
                             data-infinite="1"
                             data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                             data-nav-for="#carousel-08-{{$key+1}}">
                            <div class="js-slide">
                                <a href="{{ route('moreItem','24') }}" class="customLinkHover">
                                    <div class="moreItem">
                                        <span style="position: absolute; left:45px; text-shadow: 0 0 5px navy;" class="h1 g-color-white g-top-50x">بیشتر ببینید</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </figure>
                <!-- End Product -->
            </div>
        </div>
    </div>
</div>
<div id="earringContainer">
    <div>
        <div class="dzsparallaxer auto-init height-is-based-on-content use-loading g-bg-cover g-bg-black-opacity-0_5--after mode-scroll">
            <div class="divimage dzsparallaxer--target w-100" style="height: 140%; background-image: url({{asset('img/Other/earring/bigWall.jpg?v=873')}}); transform: translate3d(0px, -76.6067px, 0px);"></div>

            <div class="container g-z-index-1 g-py-120">
                <div class="js-carousel g-pb-80" data-infinite="1" data-arrows-classes="u-arrow-v1 g-width-40 g-height-40 g-brd-1 g-brd-style-solid g-brd-white-opacity-0_6 g-brd-primary--hover g-color-white-opacity-0_5 g-bg-primary--hover g-color-white--hover g-absolute-centered--x g-bottom-0" data-arrow-left-classes="fa fa-angle-left g-ml-minus-25" data-arrow-right-classes="fa fa-angle-right g-ml-25">
                    <div class="js-slide">
                        <!-- Testimonials Advanced -->
                        <div class="text-center g-px-100--lg">
                            <h1 class="h3 g-color-primary">گوشواره و گردنبند زنانه</h1>
                            <blockquote style="direction: rtl" class="g-color-white g-font-size-20 g-py-20">گوشواره های ترکیبی خاص و تمام منجوق کاری شده، آنتی آلرژی، آنتی باکتریال، رنگ ثابت و ضد زنگ، دارای بارکد آنلاین فروشگاهی</blockquote>
                            <blockquote style="direction: rtl" class="g-color-white g-font-size-20 g-pb-20">گردنبند های استيل و مشتقات استیل، با روكش و آبكارى طلا و نقره، با نگين هاى مولتى كالر، كيفيت ابكارى درجه يك، انتى آلرژى، انتى باكتريال، بارکد آنلاین فروشگاهی</blockquote>
                            <h4 class="h6 g-color-white-opacity-0_7 text-uppercase g-mb-0">
                                خاصترین های اکسسوری گوش و آویز رو لباسی
                                <em class="g-font-style-normal g-color-primary">تانا استایل</em>
                            </h4>
                        </div>
                        <!-- End Testimonials Advanced -->
                    </div>

                    <div class="js-slide">
                        <!-- Testimonials Advanced -->
                        <div class="text-center g-px-100--lg">
                            <i class="d-block g-color-primary g-font-size-60 g-line-height-0_7 g-pos-rel g-top-20">“</i>
                            <blockquote class="g-color-white g-font-size-20 g-py-20">گوشواره میخی، گوشواره حلقه ای، گوشواره صدفی، گوشواره لوستری، گوشواره بخیه ای، گوشواره اهرمی، گوشواره قلاب دار، گوشواره کلیپسی</blockquote>
                            <blockquote class="g-color-white g-font-size-20 g-py-20">گردنبند نگلژ، مروارید، مهره ای، آویز، زنجیر، سوتوا، چوکر و ریور</blockquote>
                            <h4 class="h6 g-color-white-opacity-0_7 text-uppercase g-mb-0">
                                تنوعی زیبا و چشم نواز از رنگ بندی های مختلف
                            </h4>
                        </div>
                        <!-- End Testimonials Advanced -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container g-px-0--lg">
        <div id="js-carousel-2" class="js-carousel g-mb-15--lg g-mb-60 g-mx-minus-10 g-py-60--lg g-pt-20 g-pb-60"
             data-infinite="true"
             data-slides-show="4"
             data-autoplay="0"
             data-speed="5000"
             data-arrows-classes="u-arrow-v1 g-pos-abs g-bottom-0 g-width-45 g-height-45 g-color-gray-dark-v5 g-bg-secondary g-color-white--hover g-bg-primary--hover rounded"
             data-arrow-left-classes="fa fa-angle-left g-left-20 rounded-0"
             data-arrow-right-classes="fa fa-angle-right g-right-20 rounded-0"
             data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center">
            @foreach($earring as $key =>$row)
                <div class="js-slide g-mx-10">
                    <!-- Product -->
                    <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-15">
                        <div>
                            <div id="carousel-08-{{$key}}"
                                 class="js-carousel text-center g-mb-5"
                                 data-infinite="1"
                                 data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                                 data-nav-for="#carousel-08-{{$key}}">
                                <div class="js-slide">
                                    <a href="{{ route('productDetail',[$row->ProductID, $row->Size]) }}">
                                        <img class="img-fluid w-100" loading="lazy"
                                             src="{{ $row->PicPath.$row->SampleNumber.'.jpg' }}"
                                             alt="{{ $row->Name.' '.$row->Model.' '.$row->Gender.' '.$row->Brand.' '.$row->Size.' '.$row->Color  }}">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- مشخصات محصول -->
                        <div style="direction: rtl" class="media g-mt-5 g-brd-top g-brd-gray-light-v4 g-pt-5">
                            <!-- نام و مدل و جنسیت و دسته و تخفیف و قیمت -->
                            <div class="d-flex flex-column col-12 g-px-5">
                                <h1 class="h6 g-color-black my-1 text-left">
                                    {{$row->Brand}}
                                </h1>
                                <h4 class="h6 g-color-black my-1">
                                    <span class="u-link-v5 g-color-black"
                                          tabindex="0">
                                        {{ $row->Name }}
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Model }}</span>
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Gender }}</span>
                                    </span>
                                </h4>
                                <div>
                                    <span class="g-ml-5">سایز
                                        <span class="g-color-primary">{{ $row->Size }}</span>
                                    </span>
                                    <span>رنگ
                                        <span class="g-color-primary">{{ $row->Color }}</span>
                                    </span>
                                </div>
                                <span class="{{ $row->Qty ==0 ?'opacity-0': '' }}">موجودی <span id="{{ 'cartQty'.$key }}"
                                                   class="g-color-primary">{{ $row->Qty }}</span> عدد</span>
                            </div>
                        </div>
                        <div
                            class="d-block g-color-black g-font-size-17 g-ml-5">
                            <div style="direction: rtl" class="text-left">
                                <s class="g-color-lightred g-font-weight-500 g-font-size-13">
                                    {{  number_format($row->FinalPriceWithoutDiscount) }}
                                </s>
                                <span>{{  number_format($row->UnitPrice) }}</span>
                                <span
                                    class="d-block g-color-gray-light-v2 g-font-size-10">تومان</span>
                            </div>
                        </div>
                    </figure>
                    <!-- End Product -->
                </div>
            @endforeach
            <div class="js-slide g-mx-10">
                <!-- Product -->
                <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-5">
                    <div>
                        <div id="carousel-08-{{$key+1}}"
                             class="js-carousel text-center g-mb-5"
                             data-infinite="1"
                             data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                             data-nav-for="#carousel-08-{{$key+1}}">
                            <div class="js-slide">
                                <a href="{{ route('moreItem','700') }}" class="customLinkHover">
                                    <div class="moreItem">
                                        <span style="position: absolute; left:45px; text-shadow: 0 0 5px navy;" class="h1 g-color-white g-top-50x">بیشتر ببینید</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </figure>
                <!-- End Product -->
            </div>
        </div>
    </div>
</div>
<div id="braceletContainer">
    <div>
        <div class="dzsparallaxer auto-init height-is-based-on-content use-loading g-bg-cover g-bg-black-opacity-0_5--after mode-scroll">
            <div class="divimage dzsparallaxer--target w-100" style="height: 140%; background-image: url({{asset('img/Other/bracelet/bigWall.jpg?v=873')}}); transform: translate3d(0px, -76.6067px, 0px);"></div>

            <div class="container g-z-index-1 g-py-120">
                <div class="js-carousel g-pb-80" data-infinite="1" data-arrows-classes="u-arrow-v1 g-width-40 g-height-40 g-brd-1 g-brd-style-solid g-brd-white-opacity-0_6 g-brd-primary--hover g-color-white-opacity-0_5 g-bg-primary--hover g-color-white--hover g-absolute-centered--x g-bottom-0" data-arrow-left-classes="fa fa-angle-left g-ml-minus-25" data-arrow-right-classes="fa fa-angle-right g-ml-25">
                    <div class="js-slide">
                        <!-- Testimonials Advanced -->
                        <div class="text-center g-px-100--lg">
                            <h1 class="h3 g-color-primary">دست بند و پابند زنانه</h1>

                            <blockquote style="direction: rtl" class="g-color-white g-font-size-25 g-py-40">با نگين های زيركنيا و مرواريدهای پرورشى، انتى آلرژى، انتى باکتریال، بارکد آنلاین فروشگاهی</blockquote>
                            <h4 class="h6 g-color-white-opacity-0_7 text-uppercase g-mb-0">
                                دستبند، پابند و اکسسوری های دست و پا
                                <em class="g-font-style-normal g-color-primary">تانا استایل</em>
                            </h4>
                        </div>
                        <!-- End Testimonials Advanced -->
                    </div>

                    <div class="js-slide">
                        <!-- Testimonials Advanced -->
                        <div class="text-center g-px-100--lg">
                            <i class="d-block g-color-primary g-font-size-60 g-line-height-0_7 g-pos-rel g-top-20">“</i>
                            <blockquote class="g-color-white g-font-size-20 g-py-20">دستبند مولتی کالر، دستبند کارتیه، دستبند کشی نگین دار، دستبند کراواتی، دستبند تنیسی، دستبند دوستی، دستبند النگویی، دستبند مهره ای، دستبند زنجیر، دستبند تمیمه یا انگشتری یا عربی، دستبند آیدی، دستبند افسون یا چارم</blockquote>
                            <blockquote class="g-color-white g-font-size-20 g-pb-20">پابند تمیمه، افسون، صدفی، مهره ای</blockquote>
                            <h4 class="h6 g-color-white-opacity-0_7 text-uppercase g-mb-0">
                                همگام با ترندهای جهانی
                            </h4>
                        </div>
                        <!-- End Testimonials Advanced -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container g-px-0--lg">


        <div id="js-carousel-5" class="js-carousel g-mb-15--lg g-mb-60 g-mx-minus-10 g-py-60--lg g-pt-20 g-pb-60"
             data-infinite="true"
             data-slides-show="4"
             data-autoplay="0"
             data-speed="5000"
             data-arrows-classes="u-arrow-v1 g-pos-abs g-bottom-0 g-width-45 g-height-45 g-color-gray-dark-v5 g-bg-secondary g-color-white--hover g-bg-primary--hover rounded"
             data-arrow-left-classes="fa fa-angle-left g-left-20 rounded-0"
             data-arrow-right-classes="fa fa-angle-right g-right-20 rounded-0"
             data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center">
            @foreach($bracelet as $key =>$row)
                <div class="js-slide g-mx-10">
                    <!-- Product -->
                    <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-15">
                        <div>
                            <div id="carousel-08-{{$key}}"
                                 class="js-carousel text-center g-mb-5"
                                 data-infinite="1"
                                 data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                                 data-nav-for="#carousel-08-{{$key}}">
                                <div class="js-slide">
                                    <a href="{{ route('productDetail',[$row->ProductID, $row->Size]) }}">
                                        <img class="img-fluid w-100" loading="lazy"
                                             src="{{ $row->PicPath.$row->SampleNumber.'.jpg' }}"
                                             alt="{{ $row->Name.' '.$row->Model.' '.$row->Gender.' '.$row->Brand.' '.$row->Size.' '.$row->Color  }}">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- مشخصات محصول -->
                        <div style="direction: rtl" class="media g-mt-5 g-brd-top g-brd-gray-light-v4 g-pt-5">
                            <!-- نام و مدل و جنسیت و دسته و تخفیف و قیمت -->
                            <div class="d-flex flex-column col-12 g-px-5">
                                <h1 class="h6 g-color-black my-1 text-left">
                                    {{$row->Brand}}
                                </h1>
                                <h4 class="h6 g-color-black my-1">
                                    <span class="u-link-v5 g-color-black"
                                          tabindex="0">
                                        {{ $row->Name }}
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Model }}</span>
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Gender }}</span>
                                    </span>
                                </h4>
                                <div>
                                    <span class="g-ml-5">سایز
                                        <span class="g-color-primary">{{ $row->Size }}</span>
                                    </span>
                                    <span>رنگ
                                        <span class="g-color-primary">{{ $row->Color }}</span>
                                    </span>
                                </div>
                                <span>موجودی <span id="{{ 'cartQty'.$key }}"
                                                   class="g-color-primary">{{ $row->Qty }}</span> عدد</span>
                            </div>
                        </div>
                        <div
                            class="d-block g-color-black g-font-size-17 g-ml-5">
                            <div style="direction: rtl" class="text-left">
                                <s class="g-color-lightred g-font-weight-500 g-font-size-13">
                                    {{  number_format($row->FinalPriceWithoutDiscount) }}
                                </s>
                                <span>{{ number_format($row->FinalPrice) }}</span>
                                <span
                                    class="d-block g-color-gray-light-v2 g-font-size-10">تومان</span>
                            </div>
                        </div>
                    </figure>
                    <!-- End Product -->
                </div>
            @endforeach
            <div class="js-slide g-mx-10">
                <!-- Product -->
                <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-5">
                    <div>
                        <div id="carousel-08-{{$key+1}}"
                             class="js-carousel text-center g-mb-5"
                             data-infinite="1"
                             data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                             data-nav-for="#carousel-08-{{$key+1}}">
                            <div class="js-slide">
                                <a href="{{ route('moreItem','703') }}" class="customLinkHover">
                                    <div class="moreItem">
                                        <span style="position: absolute; left:45px; text-shadow: 0 0 5px navy;" class="h1 g-color-white g-top-50x">بیشتر ببینید</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </figure>
                <!-- End Product -->
            </div>
        </div>
    </div>
</div>
<div id="discountsContainer">
{{--    <h5 style="direction: rtl" class="container g-bg-primary g-color-white g-mb-0 g-pa-10 g-pr-15"> تخفیفات ویژه</h5>--}}
    <div class="col-12 p-0 text-center">
        <img style="object-fit: cover" src="{{asset('img/Other/discounts.jpg?v=1')}}" alt="" class="col-12 p-0 g-mb-20 bigDevice">
        <img style="object-fit: cover" src="{{asset('img/Other/discounts.jpg?v=1')}}" alt="" class="col-12 p-0 g-height-250 g-mb-20 smallDevice">
        <h1 style="direction: rtl" class="h5 container g-color-gray-dark-v1 g-mb-0 g-pa-10 g-pr-15">تخفیفات ویژه امروز</h1>
    </div>
    <div class="container g-mb-100 g-px-0--lg g-pt-15">


        <div id="js-carousel-7" class="js-carousel g-mb-15 g-mx-minus-10 g-pb-60"
             data-infinite="true"
             data-slides-show="4"
             data-autoplay="0"
             data-speed="5000"
             data-arrows-classes="u-arrow-v1 g-pos-abs g-bottom-0 g-width-45 g-height-45 g-color-gray-dark-v5 g-bg-secondary g-color-white--hover g-bg-primary--hover rounded"
             data-arrow-left-classes="fa fa-angle-left g-left-20 rounded-0"
             data-arrow-right-classes="fa fa-angle-right g-right-20 rounded-0"
             data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center">
            @foreach($discounts as $key =>$row)
                <div class="js-slide g-mx-10">
                    <!-- Product -->
                    <figure style="direction: ltr;" class="g-px-10 g-pt-10 productFrame u-shadow-v24 g-pb-15">
                        <div>
                            <div id="carousel-08-{{$key}}"
                                 class="js-carousel text-center g-mb-5"
                                 data-infinite="1"
                                 data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-20 text-center"
                                 data-nav-for="#carousel-08-{{$key}}">
                                <div class="js-slide">
                                    <a href="{{ route('productDetail',[$row->ProductID, $row->Size]) }}">
                                        <img class="img-fluid w-100" loading="lazy"
                                             src="{{ $row->PicPath.$row->SampleNumber.'.jpg' }}"
                                             alt="{{ $row->Name.' '.$row->Model.' '.$row->Gender.' '.$row->Brand.' '.$row->Size.' '.$row->Color  }}">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- مشخصات محصول -->
                        <div style="direction: rtl" class="media g-mt-5 g-brd-top g-brd-gray-light-v4 g-pt-5">
                            <!-- نام و مدل و جنسیت و دسته و تخفیف و قیمت -->
                            <div class="d-flex flex-column col-12 g-px-5">
                                <h1 class="h6 g-color-black my-1 text-left">
                                    {{$row->Brand}}
                                </h1>
                                <h4 class="h6 g-color-black my-1">
                                    <span class="u-link-v5 g-color-black"
                                          tabindex="0">
                                        {{ $row->Name }}
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Model }}</span>
                                        <span
                                            class="g-font-size-12 g-font-weight-300"> {{ $row->Gender }}</span>
                                    </span>
                                </h4>
                                <div>
                                    <span class="g-ml-5">سایز
                                        <span class="g-color-primary">{{ $row->Size }}</span>
                                    </span>
                                    <span>رنگ
                                        <span class="g-color-primary">{{ $row->Color }}</span>
                                    </span>
                                </div>
                                <span class="{{ $row->Qty ==0 ?'opacity-0': '' }}">موجودی <span id="{{ 'cartQty'.$key }}"
                                                   class="g-color-primary">{{ $row->Qty }}</span> عدد</span>
                            </div>
                        </div>
                        <div
                            class="d-block g-color-black g-font-size-17 g-ml-5">
                            <div style="direction: rtl" class="text-left">
                                <s class="g-color-lightred g-font-weight-500 g-font-size-13">
                                    {{  number_format($row->FinalPriceWithoutDiscount) }}
                                </s>
                                <span>{{  number_format($row->FinalPrice) }}</span>
                                <span
                                    class="d-block g-color-gray-light-v2 g-font-size-10">تومان</span>
                            </div>
                        </div>
                    </figure>
                    <!-- End Product -->
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
