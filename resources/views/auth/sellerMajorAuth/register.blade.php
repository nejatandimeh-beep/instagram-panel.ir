@extends('Layouts.SellerMajor.app')

@section('content')
    <div class="container g-mb-40">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header text-right">افزودن کسب و کار</h5>
                    <div class="card-body p-0">
                        <form action="{{route('sellerMajorNew')}}" method="POST" style="direction: rtl"
                              id="registerForm"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="container g-pt-20 g-py-30--lg g-px-60--lg text-left">
                                {{--نام--}}
                                <div class="form-group row g-mb-15">
                                    <label
                                        class="col-sm-4 col-form-label align-self-center text-right">نام
                                        کاربری</label>
                                    <div class="col-sm-8 force-col-12">
                                        <div style="position: relative" class="input-group g-brd-primary--focus">
                                            <div
                                                style="display: none; position: absolute; z-index: 100; top: 10px; right: 10px"
                                                class="userNameSpinner">
                                                <i class="fa fa-spin fa-spinner g-font-size-16"></i>
                                            </div>
                                            <input style="direction: ltr" id="user-name"
                                                   class="form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16 g-brd-red need text-left"
                                                   type="text"
                                                   value=""
                                                   autofocus
                                                   autocomplete="off"
                                                   spellcheck="false"
                                                   oninput="checkUserName($(this).val())"
                                                   tabindex="1"
                                                   name="name"
                                                   maxlength="50"
                                                   onblur=" if($(this).val().length>1 && $('.checkUserAlarm').is(':hidden') && $('.checkUserAlarm2').is(':hidden')) $(this).removeClass('g-brd-red'); else $(this).addClass('g-brd-red');">
                                            <div
                                                class="input-group-addon g-brd-around g-brd-gray-light-v2 g-brd-right-none d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                                                <i class="fa fa-at g-font-size-18"></i>
                                            </div>
                                        </div>
                                        <div style="display: none" class="text-right checkUserAlarm">
                                            <small class="g-color-red">نام کاربری موجود است</small>
                                        </div>
                                        <div style="display: none" class="text-right checkUserAlarm2">
                                            <small class="g-color-red">نام کاربری مجاز نیست</small>
                                        </div>
                                        <div style="display: none" class="text-right checkUserAlarm3">
                                            <small class="g-color-red">نام کاربری باید بیشتر از 1 حرف باشد</small>
                                        </div>
                                    </div>
                                </div>

                                {{--موبایل--}}
                                <div class="form-group row g-mb-15">
                                    <label
                                        class="col-sm-4 col-form-label align-self-center text-right">تلفن
                                        همراه</label>
                                    <div class="col-sm-8 force-col-12">
                                        <input style="direction: ltr"
                                               class="text-left form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16 need"
                                               id="mobile"
                                               tabindex="12"
                                               name="mobile"
                                               maxlength="11"
                                               value="{{Session::get('mobile')}}"
                                               readonly>
                                    </div>
                                </div>

                                {{--دسته شغلی--}}
                                <div class="customDisable form-group row g-mb-15">
                                    <label class="col-sm-4 col-form-label align-self-center text-right">دسته
                                        شغلی</label>
                                    <div class="col-sm-8 force-col-12">
                                        <div id="accordion-04" class="u-accordion" role="tablist"
                                             aria-multiselectable="true">
                                            <!-- Card -->
                                            <div class="card rounded-0 g-mb-5 g-brd-red">
                                                <div id="accordion-04-heading-01"
                                                     class="u-accordion__header g-brd-bottom g-brd-gray-light-v4 "
                                                     role="tab">
                                                    <h5 class="mb-0 g-font-weight-300">
                                                        <a class="u-link-v5 g-color-main g-color-primary--hover g-font-size-16 d-block text-right"
                                                           href="#accordion-04-body-01" data-toggle="collapse"
                                                           data-parent="#accordion-04" aria-expanded="true"
                                                           aria-controls="accordion-04-body-01" id="selectedItem">
                                                            انتخاب کنید
                                                        </a>
                                                        <input style="display: none" id="hintCategory"
                                                               name="hintCategory" value="empty">
                                                        <input style="display: none" id="category" name="category"
                                                               value="empty">
                                                        <input style="display: none" id="catCode" name="catCode"
                                                               value="empty">
                                                    </h5>
                                                </div>
                                                <div id="accordion-04-body-01" class="collapse g-py-10 g-px-5"
                                                     role="tabpanel"
                                                     aria-labelledby="accordion-04-heading-01"
                                                     data-parent="#accordion-04">
                                                    <div style="height: 230px !important;"
                                                         class="u-accordion__body g-color-gray-dark-v5 customScrollBar">
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">پوشاک</strong>
                                                            <ul>
                                                                <li>
                                                                    <span style="cursor: pointer" id="lebas"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'clothes')">لباس</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="kif"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'clothes')">کیف</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="kafsh"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'clothes')">کفش</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="varzeshi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'clothes')">ورزشی</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="aksesori"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'clothes')">اکسسوری</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="makhloot"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'clothes')">مخلوط</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">وسایل نقلیه</strong>
                                                            <ul>
                                                                <li>
                                                                    <span style="cursor: pointer" id="khodro"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'vehicles')">خودرو</span>
                                                                </li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="motorSiklet"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'vehicles')">موتور
                                                                            سیکلت</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="khodroKlasik"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'vehicles')">خودرو
                                                                            کلاسیک</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="khodroSangin"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'vehicles')">سنگین
                                                                            و نیمه سنگین</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="khodroKeshavarzi"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'vehicles')">کشاورزی
                                                                            و عمرانی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="khodroLavazem"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'vehicles')">لوازم
                                                                            و قطعات وسایل نقلیه</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="khodroSayer"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'vehicles')">سایر
                                                                            وسایل نقلیه</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="khodroEjare"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'vehicles')">اجاره
                                                                            خودرو</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="khodroKeshavarziEjare"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'vehicles')">اجاره
                                                                            کشاورزی و عمرانی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="ghayeghVaTafrihat"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'vehicles')">قایق
                                                                            و تفریحات آبی</span></li>
                                                                <li>
                                                                    <span style="cursor: pointer"
                                                                          id="vasileNaghlieSayer"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'vehicles')">سایر وسایل نقلیه</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">وسایل ورزشی</strong>
                                                            <ul>
                                                                <li>
                                                                    <span style="cursor: pointer" id="docharkhe"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'sports')">دوچرخه</span>
                                                                </li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="toreMosaferati"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'sports')">تور
                                                                            مسافرتی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="sargarmiBazi"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'sports')">سرگرمی
                                                                            و اسباب بازی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="heyvanatVaLavazem"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'sports')">حیوانات
                                                                            و لوازم</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="SazVaMoosighi"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'sports')">انواع
                                                                            ساز و آلات موسیقی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="honarVaSanayeDasti"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'sports')">هنر
                                                                            و صنایع دستی</span></li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="koleksion"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'sports')">کلکسیونی</span>
                                                                </li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="sayerSargarmi"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'sports')">
                                                                            سرگرمی ها</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="sayerVarzeshi"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'sports')">
                                                                            سایر وسایل ورزشی</span></li>
                                                            </ul>
                                                        </div>
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">املاک</strong>
                                                            <ul>
                                                                <li>
                                                                        <span style="cursor: pointer" id="ejareKhane"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'estate')">رهن
                                                                            و اجاره خانه و آپارتمان</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="foroshKhane"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'estate')">خرید
                                                                            و فروش خانه و آپارتمان</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="ejereKhaneKootah"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'estate')">اجاره
                                                                            کوتاه مدت ویلا، سوئیت</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="ejareEdariTejari"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'estate')">رهن
                                                                            و اجاره اداری، تجاری و صنعتی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="foroshEdariTejari"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'estate')">خرید
                                                                            و فروش اداری، تجاری و صنعتی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="zaminVaBagh"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'estate')">زمین
                                                                            و باغ</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="sayereAmlak"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'estate')">سایر
                                                                            املاک</span></li>
                                                            </ul>
                                                        </div>
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">لوازم الکترونیکی</strong>
                                                            <ul>
                                                                <li>
                                                                        <span style="cursor: pointer" id="computer"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'electronic')">لپ
                                                                            تاپ و کامپیوتر</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="sotiTasviri"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'electronic')">صوتی
                                                                            و تصویری</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="doorbin"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'electronic')">دوربین
                                                                            عکاسی و فیلمبرداری و لوازم</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="consoleBazi"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'electronic')">کنسول
                                                                            بازی و لوازم</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="internetBazi"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'electronic')">بازی
                                                                            های اینترنتی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="sayerLavazemElektriki"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'electronic')">سایر
                                                                            لوازم الکترونیکی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="lavazemeComputerPrinter"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'electronic')">لوازم
                                                                            کامپیوتر و پرینتر</span></li>
                                                                <li>
                                                                    <span style="cursor: pointer"
                                                                          id="sayerVasayeleElektriki"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'electronic')">سایر وسایل الکتریکی</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">صنعتی، اداری و تجاری</strong>
                                                            <ul>
                                                                <li>
                                                                        <span style="cursor: pointer" id="mashinSanati"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'industrial')">ماشین
                                                                            الات و تجهیزات صنعتی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="abzarVaYaragh"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'industrial')">ابزار
                                                                            و یراق آلات</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="lavazemeEdari"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'industrial')">لوازم
                                                                            اداری</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="tajhizatPezeshki"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'industrial')">تجهیزات
                                                                            پزشکی و آزمایشگاهی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="LavazemeKafeRestooran"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'industrial')">تجهیزات
                                                                            و لوازم کافه و رستوران</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="tajhizateTejariVaFroshgah"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'industrial')">تجهیزات
                                                                            تجاری و فروشگاه</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="tajhizateOmraniSakhtman"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'industrial')">تجهیزات
                                                                            عمرانی و ساختمانی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="tajhizateKeshavarziDamdari"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'industrial')">تجهیزات
                                                                            کشاورزی و دامداری</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="ejareTajhizateSanati"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'industrial')">اجاره
                                                                            تجهیزات صنعتی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer" id="ketabTahrir"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'industrial')">کتاب
                                                                            و لوازم تحریر</span></li>
                                                                <li>
                                                                    <span style="cursor: pointer"
                                                                          id="sayereVasayeleSanati"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'industrial')">سایر وسایل صنعتی</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer"
                                                                          id="sayereVasaeleEdari"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'industrial')">سایر وسایل اداری</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer"
                                                                          id="sayereVasaeleTejari"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'industrial')">سایر وسایل تجاری</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">خدمات و کسب و کار</strong>
                                                            <ul>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">آرایشگری
                                                                            و زیبایی</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">آموزش</span>
                                                                </li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">اجاره
                                                                            لوازم</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">اسباب
                                                                            کشی و حمل و نقل</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">اینترنت
                                                                            ، رایانه و موبایل</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">باغبانی
                                                                            و فضای سبز</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">پزشکی
                                                                            و درمانی</span></li>
                                                                <li class=""><a
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">ترجمه
                                                                        و تایپ</a></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">تعمیرات</span>
                                                                </li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">خرید
                                                                            و فروش عمده</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">خودرو
                                                                            و موتورسیکلت</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">رویدادهای
                                                                            اجتماعی</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">ساختمان
                                                                            و دکوراسیون داخلی</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">گرافیک،
                                                                            تبلیغات و چاپ</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">مالی،
                                                                            حقوقی و بیمه</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">مراسم
                                                                            و کترینگ</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">معرفی
                                                                            و تبلیغات کسب و کار</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">مواد
                                                                            غذایی</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">نظافت
                                                                            و خدمات منزل</span></li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">هنری</span>
                                                                </li>
                                                                <li class=""><span
                                                                        style="cursor: pointer"
                                                                        class="g-font-weight-500 g-color-primary--hover"
                                                                        onclick="categorySelect($(this),'services')">سایر
                                                                            خدمات و کسب و کار</span></li>
                                                            </ul>
                                                        </div>
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">وسایل ارتباطی</strong>
                                                            <ul>
                                                                <li>
                                                                        <span style="cursor: pointer" id="mobileTablet"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'connections')">موبایل
                                                                            و تبلت</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="lavazemeMobile"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'connections')">لوازم
                                                                            موبایل</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="ayfonVaTelefon"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'connections')">
                                                                            آیفون و تلفن</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="sayereErtebatat"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'connections')">
                                                                            سایر وسایل ارتباطی</span></li>
                                                            </ul>
                                                        </div>
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">لوازم خانگی</strong>
                                                            <ul>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="moblemanVaCharm"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'appliances')">مبلمان
                                                                            و لوازم چوبی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="vasaeleBarghiAshpazkhane"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'appliances')">وسایل
                                                                            برقی خانه و آشپزخانه</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="zoroofVaLavazemAshpazkhane"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'appliances')">ظروف
                                                                            و لوازم آشپزخانه</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="dekorasionDakheliRoshanaei"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'appliances')">دکوراسیون
                                                                            داخلی و روشنایی</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="farshGlimGhaliche"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'appliances')">فرش،
                                                                            گلیم و قالیچه</span></li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="antik"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'appliances')">آنتیک</span>
                                                                </li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="sayereLavazemeKhane"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'appliances')">سایر
                                                                            لوازم خانه و حیاط</span></li>
                                                                <li>
                                                                        <span style="cursor: pointer"
                                                                              id="sarmayeshVaGarmayesh"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this),'appliances')">لوازم
                                                                            سرمایش و گرمایش</span></li>
                                                                <li>
                                                                    <span style="cursor: pointer"
                                                                          id="sayereLavazemeKhanegi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'appliances')">سایر لوازم خانگی</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">لوازم شخصی</strong>
                                                            <ul>
                                                                <li>
                                                                    <span style="cursor: pointer" id="lavazemeArayeshi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'personal')">لوازم آرایشی</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="lavazemeBehdashti"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'personal')">لوازم بهداشتی</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="lavazemeArayeshiVaBehdashti"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'personal')">لوازم آرایشی و بهداشتی</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="lavazemePezeshki"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'personal')">لوازم پزشکی</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer"
                                                                          id="sayereLavazemeShakhsi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'personal')">سایر لوازم شخصی</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="text-right">
                                                            <strong class="g-color-insta">تولید محتوا</strong>
                                                            <ul>
                                                                <li>
                                                                    <span style="cursor: pointer" id="mohtava-amoozeshi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">آموزشی</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="mohtava-elmi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">علمی</span>
                                                                </li>
                                                                <li>
                                                                    <span style="cursor: pointer" id="mohtava-pezeshki"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">پزشکی</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-blager"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">بلاگر</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-ashpazi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">آشپزی</span>
                                                                </li>
                                                                <li><span style="cursor: pointer"
                                                                          id="mohtava-ravanshenasi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">روانشناسی</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-varzeshi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">ورزشی</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-tarikhi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">تاریخی</span>
                                                                </li>
                                                                <li><span style="cursor: pointer"
                                                                          id="mohtava-gardeshgari"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">گردشگری</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-khabari"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">خبری</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-honari"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">هنری</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-tejari"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">تجاری</span>
                                                                </li>
                                                                <li><span style="cursor: pointer"
                                                                          id="mohtava-maliVaeghtesad"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">مالی و اقتصادی</span>
                                                                </li>
                                                                <li><span style="cursor: pointer"
                                                                          id="mohtava-komediVaTanz"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">کمدی و طنز</span>
                                                                </li>
                                                                <li><span style="cursor: pointer"
                                                                          id="mohtava-fileVaSinema"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">فیلم و سبنما</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-moosighi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">موسیقی</span>
                                                                </li>
                                                                <li><span style="cursor: pointer"
                                                                          id="mohtava-etelaateOmmomi"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">اطلاعات عمومی</span>
                                                                </li>
                                                                <li><span style="cursor: pointer"
                                                                          id="mohtava-dekorasion"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">دکوراسیون</span>
                                                                </li>
                                                                <li><span style="cursor: pointer"
                                                                          id="mohtava-estaylvaMod"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">استایل و مد</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-sanati"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">صنعتی</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-khadamati"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">خدماتی</span>
                                                                </li>
                                                                <li><span style="cursor: pointer" id="mohtava-sayere"
                                                                          class="g-font-weight-500 g-color-primary--hover"
                                                                          onclick="categorySelect($(this),'content')">سایر محتوا</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Card -->
                                        </div>
                                    </div>
                                </div>

                                {{--لوگو--}}
                                <div class="form-group row g-mb-15">
                                    <label class="col-sm-4 col-form-label align-self-center text-right"
                                           for="fileShow12"
                                           id="img-file-label12">
                                        تصویر پروفایل
                                    </label>
                                    <div class="col-sm-8 force-col-12">
                                        <div class="input-group u-file-attach-v1 g-brd-gray-light-v2">
                                            <span style="cursor: default"
                                                  class="d-none align-self-center g-mr-5 g-pa-10 g-color-primary"
                                                  id="uploadingIcon12"><i class="fa fa-spinner fa-spin"></i></span>
                                            <input style="direction: rtl" id="uploadingText12"
                                                   class="need d-none form-control form-control-md rounded-0 g-font-size-16 g-brd-red"
                                                   type="text"
                                                   placeholder="درحال بارگذاری.." readonly="">
                                            <input id="{{ 'fileShow12' }}"
                                                   class="form-control form-control-md rounded-0 g-font-size-16 g-brd-red"
                                                   type="text"
                                                   placeholder="فاقد تصویر" readonly="">
                                            <div class="input-group-btn">
                                                <button id="picUploadBtn12" class="btn btn-md u-btn-insta rounded-0"
                                                        tabindex="20">
                                                    بارگذاری
                                                </button>
                                                <input id="{{'pic12'}}"
                                                       onclick="$('#fileShow12').removeClass('g-brd-lightred')"
                                                       value=""
                                                       type="file"
                                                       name="{{'pic12'}}"
                                                       accept="image/*">
                                                <div id="userImageDiv12">
                                                    <input type="text" id="imageUrl12" name="imageUrl12"
                                                           style="display: none">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="direction: rtl">
                                            <p class="text-muted g-font-size-13 g-line-height-1_5 text-right g-pt-5 m-0">
                                                تصویر پروفایل کاربری در پنل فروشنده ساده</p>
                                        </div>
                                    </div>
                                </div>

                                {{--رمز عبور--}}
                                <div class="form-group row g-mb-15">
                                    <label
                                        class="col-sm-4 col-form-label align-self-center text-right">رمز
                                        عبور</label>
                                    <div class="col-sm-8 force-col-12">
                                        <div class="input-group g-brd-primary--focus">
                                            <div
                                                class="input-group-addon text-center g-brd-around g-brd-gray-light-v2 g-brd-left-none align-items-center">
                                                <a style="cursor: pointer"
                                                   class="u-link-v5 g-color-main g-color-primary--hover g-font-size-16 d-block g-mt-7"
                                                   onmousedown="showPassword()">
                                                    <i id="showPassword"
                                                       class="fa fa-eye g-color-primary--hover  g-color-gray-dark-v5 g-font-size-18"></i>
                                                    <i id="hidePassword"
                                                       class="d-none fa fa-eye-slash g-color-primary--hover g-color-gray-dark-v5 g-font-size-18"></i>
                                                </a>
                                            </div>
                                            <input style="direction: rtl"
                                                   class="text-left form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16 g-brd-red need"
                                                   id="password"
                                                   tabindex="12"
                                                   oninput="
                                                   if($(this).val().length>7) {
                                                       $(this).removeClass('g-brd-red');
                                                   } else $(this).addClass('g-brd-red')"
                                                   name="password"
                                                   type="password"
                                                   maxlength="20"
                                                   value=""
                                                   placeholder="زبان انگلیسی">
                                        </div>
                                        <div class="form-group row g-mb-0">
                                            <div id="passwordHint"
                                                 class="col-12">
                                                <div id="length"
                                                     class="d-inline-block g-bg-red g-mb-5 g-mb-0--lg g-mt-5 align-top g-py-1 col-2"></div>
                                                <div id="number"
                                                     class="d-inline-block g-bg-red g-mb-5 g-mb-0--lg align-top g-mt-5 g-py-1 col-2"></div>
                                                <div id="uppercase"
                                                     class="d-inline-block g-bg-red g-mb-5 g-mb-0--lg align-top g-mt-5 g-py-1 col-2"></div>
                                                <div id="lowercase"
                                                     class="d-inline-block g-bg-red g-mb-5 g-mb-0--lg align-top g-mt-5 g-py-1 col-2"></div>
                                            </div>
                                        </div>
                                        <div style="direction: rtl" class="g-mt-5" id="passwordAlert">
                                            <div
                                                class="alert alert-danger alert-dismissible fade show text-right g-pa-20--lg g-px-10 g-py-10">
                                                <span><i class="fa fa-info-circle g-font-size-16 g-pa-2 g-ml-5"></i>رمز عبور باید شامل اعداد، حروف بزرگ، حروف کوچک و بیشتر از 8 کاراکتر باشد.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--مودال تصاویر--}}
                                <div style="direction: rtl" class="modal fade bd-example-modal-lg" id="modal"
                                     tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalCenterTitle"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">تنظیم اندازه
                                                    تصویر</h5>
                                                <button type="button"
                                                        class="g-brd-none g-bg-transparent g-font-size-20 g-line-height-0 align-self-center"
                                                        data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="img-container">
                                                    <div class="col-md-12 p-0">
                                                        <img style="width: 100%;" src="" id="sample_image">
                                                    </div>
                                                    {{--                        <div class="col-md-4">--}}
                                                    {{--                            <div class="preview rounded-circle mx-auto g-mt-20"></div>--}}
                                                    {{--                        </div>--}}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-secondary" data-dismiss="modal">انصراف
                                                </button>
                                                <button type="button" id="crop" class="btn u-btn-insta g-mr-5">برش
                                                </button>
                                                <i id="waitingCrop"
                                                   class="d-none fa fa-spinner fa-spin g-mx-10 g-font-size-20 g-color-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Danger Alert -->
                                <div style="direction: rtl"
                                     class="alert alert-warning alert-dismissible fade show text-right g-pa-20--lg g-px-10 g-py-10"
                                     role="alert">
                                    <h4 class="h5"><i class="fa fa-warning"></i> موافقت با قوانین</h4>
                                    <p class="g-mb-10">کاربر گرامی و گرانقدر تمامی هدف تیم تانا استایل بر
                                        این است که بتوانیم در کنار هم با کمترین هزینه ممکن شغل و کسب و کار خود را
                                        رونق بخشیم. این تلاش مستلزم آن است که قوانین و مقررات فضای مجازی را رعایت
                                        نماییم. لذا قبل از ثبت نام، مقررات و قوانین پنل فروشنده ساده را به دقت مطالعه
                                        فرمائید.</p>
                                    <a style="font-weight: bold" class="g-color-blue-dark-v1 g-color-primary--hover"
                                       data-toggle="modal"
                                       data-target="#modalRegulation"
                                       href="#">
                                        مطالعه قوانین
                                    </a>
                                    <div class="text-left">
                                        <div class="d-inline-block">
                                            <div style="cursor: pointer"
                                                 id="noAgree"
                                                 tabindex="22"
                                                 onclick="regulationCheck('noAgree')"
                                                 class="g-py-10 g-px-15 g-brd-red g-brd-around g-bg-white g-color-gray-dark-v5">
                                                موافقم
                                            </div>
                                        </div>
                                        <div class="d-inline-block">
                                            <div style="cursor: pointer;"
                                                 id="agree"
                                                 tabindex="22"
                                                 onclick="regulationCheck('agree')"
                                                 class="d-none g-py-10 g-brd-white g-brd-around g-px-15 g-bg-primary g-color-white">
                                                موافقم
                                            </div>
                                            <input style="display: none" id="signature" name="signature" type="text"
                                                   value="">
                                        </div>
                                    </div>
                                </div>
                                <!-- مودال قوانین-->
                                <div class="modal fade text-center" id="modalRegulation" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog m-0 mx-lg-auto modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="d-flex g-pa-15 justify-content-between g-bg-gray-light-v5">
                                                <h4 class="m-0">قوانین و شرایط فروشندگان</h4>
                                                <button style="outline: none" type="button" class="g-font-size-25 close"
                                                        data-dismiss="modal"
                                                        aria-label="Close">
                                                    ×
                                                </button>
                                            </div>
                                            <!-- شرایط استفاده -->
                                            <div style="background-color: white; direction: rtl"
                                                 class="hideScrollBar text-justify g-pa-30">
                                                <h5 class="m-0 text-right g-py-5">شرایط استفاده از پنل فروشنده ساده</h5>
                                                <div class="g-mb-30">
                                                    <p class="m-0">کاربر گرامی درود</p>
                                                    <p class="m-0">قبل از هر چیز لازم به ذکر است قوانین موجود در وب سایت
                                                        تانا استایل تنها در جهت حفاظت از حقوق کاربران در بستر تانا
                                                        استایل و همچنین حفاظت از حقوق شرکت تابش پس زمینه مکریان که تولید
                                                        کننده وب سایت تانا استایل است می باشد.</p>
                                                    <p>در این راستا برای ثبت نام در پنل فروشنده ساده لازم و ضروری است،
                                                        قوانین این پنل را به دقت مطالغه فرموده و در صورت تایید و ثبت نام
                                                        تمامی قوانین را رعایت فرمائید.</p>
                                                    <h6>با تشکر فراوان شرکت تابش پس زمینه مکریان</h6>
                                                </div>
                                                <h4 class="m-0 text-right p-0 g-pb-10">مقررات و شرایط فروشندگان</h4>
                                                <div class="g-pb-20">
                                                    <div style="direction: rtl" class="col-12 p-0 col-lg-6">
                                                        <!--Nav tabs -->
                                                        <ul class="nav flex-column u-nav-v1-2 u-nav-primary g-pa-0"
                                                            role="tablist" data-target="nav-1-2-primary-ver"
                                                            data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-primary g-mb-20">
                                                            <li class="nav-item col-12 p-0">
                                                                <a class="nav-link active g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                                                   data-toggle="tab"
                                                                   href="#nav-1-2-primary-ver--1"
                                                                   onclick="windowScrollTo()" role="tab">کالای مورد
                                                                    مبادله</a>
                                                            </li>
                                                            <li class="nav-item col-12 p-0">
                                                                <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                                                   id="kanoonOzviat"
                                                                   data-toggle="tab" href="#nav-1-2-primary-ver--2"
                                                                   onclick="windowScrollTo()" role="tab">عضویت در
                                                                    کانون</a>
                                                            </li>
                                                            <li class="nav-item col-12 p-0">
                                                                <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                                                   id="falseProduct"
                                                                   data-toggle="tab" href="#nav-1-2-primary-ver--3"
                                                                   onclick="windowScrollTo()" role="tab">محتوای
                                                                    نامناسب</a>
                                                            </li>
                                                            <li class="nav-item col-12 p-0">
                                                                <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                                                   id="emptyProduct"
                                                                   data-toggle="tab" href="#nav-1-2-primary-ver--4"
                                                                   onclick="windowScrollTo()" role="tab">مبادلات مالی و
                                                                    بانکی</a>
                                                            </li>
                                                            <li class="nav-item col-12 p-0">
                                                                <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                                                   id="deliveryProduct"
                                                                   data-toggle="tab" href="#nav-1-2-primary-ver--5"
                                                                   onclick="windowScrollTo()" role="tab">کپی رایت</a>
                                                            </li>
                                                            <li class="nav-item col-12 p-0">
                                                                <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                                                   id="sellerCheckout"
                                                                   data-toggle="tab" href="#nav-1-2-primary-ver--6"
                                                                   onclick="windowScrollTo()" role="tab">ارتباطات و
                                                                    پشتیبانی</a>
                                                            </li>
                                                            <li class="nav-item col-12 p-0">
                                                                <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                                                   id="offlineSelling"
                                                                   data-toggle="tab" href="#nav-1-2-primary-ver--7"
                                                                   onclick="windowScrollTo()" role="tab">به روز
                                                                    رسانی</a>
                                                            </li>
                                                        </ul>
                                                        <!--End Nav tabs -->
                                                    </div>
                                                </div>
                                                <div id="regulationContainer" class="col-md-12 p-0">
                                                    <div id="nav-1-2-primary-ver" class="tab-content g-mb-100">
                                                        <!-- کالای مورد مبادله -->
                                                        <div style="background-color: white; direction: rtl"
                                                             class="tab-pane fade show active text-justify"
                                                             id="nav-1-2-primary-ver--1" role="tabpanel">
                                                            <div>
                                                                <h5> 1) کالای مورد مبادله</h5>
                                                                <div>
                                                                    <p class="g-font-weight-600 m-0">1-1) فروش کالا</p>
                                                                    <p>فروشنده ساده متعهد می شود که مسئولیت تمامی جوانب
                                                                        فروش کالا در پنل فروشنده ساده را بر عهده می گیرد
                                                                        و همچنین می پذیرد که کالای فروش رفته طبق تصاویر
                                                                        و توضیحات مربوطه تحویل خریدار گردد و جبران
                                                                        تمامی خسارتهای ناشی از فروش کالا بر عهده فروشنده
                                                                        ساده می باشد و شرکت تابش پس زمینه مکریان هیچگونه
                                                                        مسئولیتی در قبال
                                                                        خرید و فروش و مبادله کالا ندارد.</p>
                                                                </div>
                                                                <div class="g-mt-15">
                                                                    <p class="g-font-weight-600 m-0">1-2) ایراد در
                                                                        کالا</p>
                                                                    <p>هرگونه ایراد و مشکلی در رابطه با کالاهای بارگذاری
                                                                        شده از سوی فروشنده ساده بر روی پنل خود اعم از
                                                                        پارگی، زدگی، سوختگی، سایز و رنگ نادرست، اصل یا
                                                                        غیر اصل بودن و در نهایت هر نوع ایرادی در کالا
                                                                        و همچنین عدم انطباق توضیحات و تصاویر با کالا به
                                                                        عهده فروشنده ساده می باشد و شرکت تابش پس زمینه
                                                                        مکریان
                                                                        هیچگونه تعهد و مسئولیتی در قبال کالای مورد
                                                                        مبادله در بستر تانا استایل را ندارد.</p>
                                                                </div>
                                                                <div class="g-mt-15">
                                                                    <p class="g-font-weight-600 m-0">1-3) اصالت کالا</p>
                                                                    <p>شرکت تابش پس زمینه مکریان هیچگونه مسئولیتی در
                                                                        قبال اصل یا غیر اصل بودن کالا ندارد و تمامی
                                                                        مسئولیت
                                                                        ها در خصوص اصل یا غیر اصل بودن کالا به عهده
                                                                        فروشنده ساده می باشد و جبران تمامی خسارتهای ناشی
                                                                        از
                                                                        اصل یا غیر اصل بودن کالا بر عهده فروشنده ساده
                                                                        است.</p>
                                                                </div>
                                                                <div class="g-mt-15">
                                                                    <p class="g-font-weight-600 m-0">1-4) تصاویر و
                                                                        توضیحات کالا</p>
                                                                    <p>تمامی محتوای تولیدی و ارائه شده در پنل فروشنده
                                                                        ساده از سوی فروشنده ساده در پنل خود درج می شود
                                                                        لذا
                                                                        مسئولیت نادرستی و اظهار خلاف واقع و درج تصاویر و
                                                                        متون توهین آمیز در رابطه با هر شخص، قشر و
                                                                        اجتماعی و همچنین قراردادن تصاویر و توضیحات غیر
                                                                        اخلاقی و مستهجن و مغایر با قوانین جمهوری
                                                                        اسلامی ایران کاملا به عهده فروشنده ساده بوده و
                                                                        شرکت تابش پس زمینه مکریان هیچگونه مسئولیتی در
                                                                        قبال
                                                                        محتوای تولید شده در پنل فروشنده ساده را
                                                                        ندارد.</p>
                                                                </div>
                                                                <div class="g-mt-15">
                                                                    <p class="g-font-weight-600 m-0">1-5) ارسال و تحویل
                                                                        کالا</p>
                                                                    <p>تمامی امور مربوط به ارسال و تحویل کالا اعم از
                                                                        بسته بندی، تاخیر در ارسال، عدم ارسال و روش های
                                                                        پستی بر عهده فروشنده ساده است و فروشنده ساده می
                                                                        پذیرد کالای ارائه شده در بستر تانا استایل
                                                                        را در اسرع وقت ارسال و تحویل خریدار نماید. تمامی
                                                                        خسارتهای ناشی از دیرکرد یا عدم ارسال و
                                                                        تحویل بعهده فروشنده ساده است و شرکت تابش پس
                                                                        زمینه مکریان هیچگونه مسئولیتی در قبال ارسال و
                                                                        تحویل کالا را
                                                                        ندارد.</p>
                                                                </div>
                                                                <div class="g-mt-15">
                                                                    <p class="g-font-weight-600 m-0">1-6) برگشت کالا</p>
                                                                    <p>تمامی امور مربوط به برگشت کالا و جزئیات مربوط به
                                                                        دلایل برگشت به عهده فروشنده ساده بوده و شرکت
                                                                        تابش پس زمینه مکریان
                                                                        هیچگونه مسئولیتی در قبال کالاهای برگشتی
                                                                        ندارد.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- عضویت در کانون -->
                                                        <div style="background-color: white; direction: rtl"
                                                             class="tab-pane fade text-justify"
                                                             id="nav-1-2-primary-ver--2" role="tabpanel">
                                                            <div>
                                                                <h5> 2) عضویت در کانون</h5>
                                                                <div>
                                                                    <p>فروشنده ساده پس از عضویت در کانون انعکاس تانا
                                                                        استایل بایستی طبق برنامه ارائه شده
                                                                        از سوی تانا استایل به فعالیت خود در کانون
                                                                        بپردازد. عدم اجرای تعهدات کانون، خود به خود موجب
                                                                        می شود تا فروشنده ساده از کانون انعکاس حذف و
                                                                        محدودیت های دسترسی به کانون بر روی پنل وی اعمال
                                                                        شود.</p>
                                                                    <p>فروشنده ساده با عضویت در کانون انعکاس بایستی
                                                                        برنامه زمان بندی شده کانون (که از طریق
                                                                        پیامک برای وی ارسال می شود و همچنین لینک آن در
                                                                        پنل وی وجود دارد) را در زمان مقرر اجرا
                                                                        نماید.</p>
                                                                    <p></p>

                                                                    <p><span
                                                                            class="g-font-weight-600 g-color-orange g-mx-5">نکته مهم:</span>فروشنده
                                                                        ساده باید به یاد داشته باشد در صورت دریافت نکردن
                                                                        پیامک روزانه کانون (احتمال اشکال در سیستم
                                                                        ارتباطات مخابرات وجود دارد) هر روز حداقل یکبار
                                                                        قبل از ساعت 11 شب به پنل خود سر بزند و از طریق
                                                                        لینک مربوطه که در قسمت اینستاگرام می باشد استوری
                                                                        تبلیغاتی روزانه خود را بررسی نماید. و در صورتی
                                                                        که تمایل به شرکت در تبلیغ آن شب داشته باشد کلید
                                                                        'تایید' را انتخاب و در صورتی که تمایل نداشته
                                                                        باشد کلید 'عدم شرکت در تبلیغ' را انتخاب نمایید.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- محتوای نامناسب -->
                                                        <div style="background-color: white; direction: rtl"
                                                             class="tab-pane fade text-justify"
                                                             id="nav-1-2-primary-ver--3" role="tabpanel">
                                                            <div>
                                                                <h5> 3) محتوای نامناسب</h5>
                                                                <div>
                                                                    <p>تمامی مسئولیت های محتوای تولید و ارائه شده بر روی
                                                                        پنل فروشنده ساده اعم از تصویر، متن، نظر،
                                                                        پیام و هرگونه محتوای دیگر بر عهده فروشنده ساده
                                                                        بوده و شرکت تابش پس زمینه مکریان هیچگونه
                                                                        مسئولیتی در قبال محتوای
                                                                        بارگذاری شده از سوی فروشنده ساده بر روی پنل وی
                                                                        را ندارد.</p>
                                                                    <p>فروشنده ساده می پذیرد عواقب ناشی از بارگذاری
                                                                        محتوای نادرست و اظهار خلاف واقع و تصاویر و متون
                                                                        توهین
                                                                        آمیز به شخص یا اشخاص یا قشر و اجتماعی و همچنین
                                                                        قراردادن تصاویر و توضیحات غیر اخلاقی و مستهجن
                                                                        و مغایر با قوانین جمهوری اسلامی ایران کاملا به
                                                                        عهده وی بوده و خسارات ناشی از نقض ماده جاری
                                                                        بعهده فروشنده ساده است و شرکت تابش پس زمینه
                                                                        مکریان از طرح هرگونه ادعایی مبرا می باشد.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- مبادلات مالی و بانکی -->
                                                        <div style="background-color: white; direction: rtl"
                                                             class="tab-pane fade text-justify"
                                                             id="nav-1-2-primary-ver--4" role="tabpanel">
                                                            <div>
                                                                <h5> 4) مبادلات مالی و بانکی</h5>
                                                                <div>
                                                                    <p>تمامی امور مربوط به مبادلات مالی و بانکی و غیر
                                                                        بانکی در رابطه با فعالیت بر روی پنل فروشنده
                                                                        ساده اعم از واریز وجه، ارائه رسید وجه و برگشت
                                                                        وجه به عهده فروشنده ساده بوده و شرکت تابش پس
                                                                        زمینه مکریان
                                                                        هیچگونه مسئولیتی در قبال امورات مالی و بانکی و
                                                                        غیر بانکی بر روی بستر تانا استایل را
                                                                        ندارد.</p>
                                                                    <p>هرگونه پول شوئی و خلاف مالی و مالیاتی که طبق
                                                                        قوانین جمهوری اسلامی ایران وضع شده است کاملا به
                                                                        عهده فروشنده ساده می باشد و شرکت تابش پس زمینه
                                                                        مکریان از هرگونه مسئولیت قانونی و قضایی مبرا
                                                                        است.</p>
                                                                    <p>با توجه به اینکه امورات انتقال وجه در بستر تانا
                                                                        استایل به حساب بانکی خود فروشنندگان ساده
                                                                        انجام می شود شرکت تابش پس زمینه مکریان قرارداد
                                                                        هیچگونه مسئولیتی در قبال امورات مالیاتی ندارد و
                                                                        مالیات ناشی از
                                                                        کسب درآمد در تانا استایل به عهده خود فروشنده
                                                                        ساده می باشد.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- کپی رایت -->
                                                        <div style="background-color: white; direction: rtl"
                                                             class="tab-pane fade text-justify"
                                                             id="nav-1-2-primary-ver--5" role="tabpanel">
                                                            <div>
                                                                <h5> 5) کپی رایت</h5>
                                                                <div>
                                                                    <p>فروشنده ساده می پذیرد که هرگونه ادعای قانونی مطرح
                                                                        شده در مورد محتوای تولید و ارائه شده در پنل خود
                                                                        و مغایر با قوانین کپی رایت جمهوری
                                                                        اسلامی ایران به عهده
                                                                        وی بوده و شرکت تابش پس زمینه مکریان هیچگونه
                                                                        مسئولیتی در قبال نقض قوانین کپی رایت کشور را
                                                                        ندارد.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- ارتباطات و پشتیبانی -->
                                                        <div style="background-color: white; direction: rtl"
                                                             class="tab-pane fade text-justify"
                                                             id="nav-1-2-primary-ver--6" role="tabpanel">
                                                            <div>
                                                                <h5> 5) ارتباطات و پشتیبانی</h5>
                                                                <div>
                                                                    <p>فروشنده ساده می پذیرد اعلان ها، آگهی ها و برنامه
                                                                        های تانا استایل را از طریق پیامک دریافت نماید و
                                                                        در صورت نیاز به پشتیبانی از دو طریق تیکت و تماس
                                                                        تلفنی در ساعت کاری با پشتیبانی تانا استایل
                                                                        تماس حاصل نماید.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- به روز رسانی -->
                                                        <div style="background-color: white; direction: rtl"
                                                             class="tab-pane fade text-justify"
                                                             id="nav-1-2-primary-ver--7" role="tabpanel">
                                                            <div>
                                                                <h5> 6) به روز رسانی</h5>
                                                                <div>
                                                                    <p class="g-font-weight-600 m-0">6-1) نرم افزاری</p>
                                                                    <p>به دلیل تمایل مدیریت و تیم تانا استایل برای به
                                                                        روز بودن و پیشرفت همه روزه این بستر، در صورت
                                                                        لزوم به روز رسانی های جدید بر روی وب سایت تانا
                                                                        استایل اعمال خواهد شد و فروشنده ساده ملزم به
                                                                        تبعیت
                                                                        از نسخه های جدید نرم افزاری می باشد.</p>
                                                                </div>
                                                                <div class="g-mt-15">
                                                                    <p class="g-font-weight-600 m-0">6-2) مقررات</p>
                                                                    <p>با توجه به بروز بودن نرم افزار و ارتقاء کمی و
                                                                        کیفی به موازات آن قوانین موجود در بستر تانا
                                                                        استایل نیز دست خوش تغییر خواهد بود لذا فروشنده
                                                                        ساده با تایید و ثبت نام در پنل فروشنده ساده
                                                                        متعهد
                                                                        می شود تمامی قوانین و ضوابط موجود در بستر تانا
                                                                        استایل را در هر زمان پذیرفته و ملزم به اجرا و
                                                                        رعایت آن خواهد بود.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button style="outline: none" type="button"
                                                    class="close col-12 g-py-8 g-bg-primary" data-dismiss="modal"
                                                    aria-label="Close">
                                                بستن
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Danger Alert -->
                                <div style="direction: rtl"
                                     class="alert alert-success alert-dismissible fade show text-right g-pa-20--lg g-px-10 g-py-10"
                                     role="alert">
                                    <h4 class="h5"><i class="fa fa-check"></i> شرکت در کانون انعکاس</h4>
                                    <p class="g-mb-10">هدف از کانون انعکاس افزایش بازدیدکنندگان از محصولات و صفحات شغلی
                                        شما می باشد. روش کار به این صورت است که
                                        هر روز برای شما در موتورهای جستجو و همچنین صفحات اینستاگرام تبلیغ خواهد شد در
                                        ازای آن شما تنها یک استوری تبلیغاتی در لیست استوریهای خود روزانه قرار خواهید
                                        داد.
                                        هیچگونه هزینه ی مالی شامل حال اعضای کانون نخواهد شد.
                                        در صورتی که عضو می شوید لطفا بعد از ثبت نام و <span class="g-color-black">ورود به پنل</span>
                                        خود، از طریق دکمه حاوی <span class="g-color-black">آیکون اینستاگرام</span> ،
                                        آپشن شرکت در کانون انعکاس را <span class="g-color-black">فعال</span> کنید.
                                    </p>
                                    <a style="font-weight: bold" class="g-color-blue-dark-v1 g-color-primary--hover"
                                       data-toggle="modal"
                                       data-target="#modalRegulation"
                                       onclick="setTimeout(function() {$('#kanoonOzviat').trigger('click')},500)"
                                       href="#">
                                        مطالعه قوانین
                                    </a>
                                    <div class="text-left">
                                        <div class="d-inline-block">
                                            <div style="cursor: pointer"
                                                 id="tablighBtn"
                                                 tabindex="22"
                                                 class="g-py-10 g-px-15 g-bg-white g-brd-white g-brd-around g-color-gray-dark-v5">
                                                عضو شدن
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--اینستاگرام--}}
                                <div id="instaContainer" class="d-none">
                                    <div class="form-group row g-mb-15">
                                        <label
                                            class="col-sm-5 col-form-label align-self-center text-right">نام
                                            کاربری اینستاگرام</label>
                                        <div class="col-sm-7 force-col-12">
                                            <div class="input-group g-brd-primary--focus">
                                                <input style="direction: ltr"
                                                       class="form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16 g-brd-red need text-left"
                                                       type="text"
                                                       value=""
                                                       autofocus
                                                       spellcheck="false"
                                                       tabindex="1"
                                                       id="instaAccount"
                                                       name="instaAccount"
                                                       maxlength="50"
                                                       oninput="if($(this).val().length>1) $(this).removeClass('g-brd-red'); else $(this).addClass('g-brd-red');">
                                                <div
                                                    class="input-group-addon g-brd-around g-brd-gray-light-v2 g-brd-right-none d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                                                    <i class="fa fa-at g-font-size-18"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row g-mb-15">
                                        <label class="col-sm-5 col-form-label text-right"
                                               for="fileShow11"
                                               id="img-file-label12">
                                            تصویر پروفایل اینستاگرام
                                        </label>
                                        <div class="col-sm-7 force-col-12">
                                            <div class="input-group u-file-attach-v1 g-brd-gray-light-v2">
                                            <span style="cursor: default"
                                                  class="d-none align-self-center g-mr-5 g-pa-10 g-color-primary"
                                                  id="uploadingIcon11"><i class="fa fa-spinner fa-spin"></i></span>
                                                <input style="direction: rtl" id="uploadingText11"
                                                       class="need d-none form-control form-control-md rounded-0 g-font-size-16 g-brd-red"
                                                       type="text"
                                                       placeholder="درحال بارگذاری.." readonly="">
                                                <input id="fileShow11"
                                                       class="form-control form-control-md rounded-0 g-font-size-16 g-brd-red"
                                                       type="text"
                                                       placeholder="فاقد تصویر" readonly="">
                                                <div class="input-group-btn">
                                                    <button id="picUploadBtn11" class="btn btn-md u-btn-insta rounded-0"
                                                            tabindex="20">
                                                        بارگذاری
                                                    </button>
                                                    <input id="pic11"
                                                           value=""
                                                           type="file"
                                                           name="pic11"
                                                           accept="image/*">
                                                    <div id="userImageDiv11">
                                                        <input type="text" id="imageUrl11" name="imageUrl11"
                                                               style="display: none">
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="direction: rtl">
                                                <p class="text-muted g-font-size-13 g-line-height-1_5 text-justify g-pt-5 m-0">
                                                    جهت تسریع در پیدا کردن اکانت شما در اینستاگرام از سوی سایر اعضای
                                                    کانون، بروزترین تصویر پروفایل اینستاگرام خود را آپلود نمایید. <span
                                                        class="text-muted g-font-size-13 g-line-height-1_5 text-right g-pt-5 m-0 g-color-orange">در صورت نبود عکس کافیست از خود تصویر پروفایل اینستاگرام اسکرین شات بگیرید.</span>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Danger Alert -->
                                <button id="save" type="button"
                                        class="btn btn-md u-btn-insta rounded-0 force-col-12 g-mt-15"
                                        onclick="saveUserData()">
                                    <span id="submitText">ثبت نام</span>
                                    <span id="waitingSubmit"
                                          style="display: none"
                                          class="m-0 g-color-white">منتظر بمانید..</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
