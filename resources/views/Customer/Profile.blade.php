@extends('Layouts.IndexCustomer')
@section('Content')
    <div style="min-height: 100vh" class="container-fluid modalBox">
        <div class="row">
            <div class="col-lg-12 g-brd-top g-brd-gray-light-v4">
                <!-- Figure -->
                <figure class="u-block-hover g-bg-white g-rounded-4 g-py-15">
                    <div style="direction: rtl" class="d-flex justify-content-start align-items-center">
                        <div class="col-md-9 d-flex g-pr-15--lg g-pr-0">
                            <!-- Figure Image -->
                            <img class="g-width-50 g-height-50 rounded-circle g-ml-15"
                                 id="userImage"
                                 src="{{ asset($customer->PicPath.'?'.time()) }}"
                                 {{--use ? and time() for refresh image--}}
                                 alt="Image Description">
                            <!-- Figure Image -->

                            <!-- Figure Info -->
                            <div class="d-flex flex-column justify-content-center">
                                <div class="g-mb-5">
                                    <h4 class="h5 g-mb-0">
                                        @if(Auth::user()->name===null || Auth::user()->name==='') {{Auth::user()->Mobile}} @else  {{Auth::user()->name.' '.Auth::user()->Family}} @endif
                                    </h4>
                                </div>
                                <em class="d-block g-color-gray-dark-v5 g-font-style-normal g-font-size-13 g-mb-2">
                                    {{(Auth::user()->name===null || Auth::user()->name==='')?'کاربر' . Auth::user()->id:Auth::user()->Mobile}}
                                </em>
                            </div>
                        </div>
                        <!-- End Figure Info -->

                        <!-- Figure Caption -->
                        <figcaption class="u-block-hover__additional--fade g-bg-white-opacity-0_9 g-pa-30">
                            <div
                                class="u-block-hover__additional--fade u-block-hover__additional--fade-down g-flex-middle">

                                <ul class="list-inline text-center g-flex-middle-item">
                                    <li class="list-inline-item justify-content-center g-mx-7">
                                                <span
                                                    class="g-color-gray-dark-v5 g-color-primary--hover g-font-size-20">
                                                    <i class="icon-user"></i>
                                                </span>
                                        <form class="d-inline-block" id="uploadImage"
                                              action="{{route('uploadImage')}}"
                                              enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <label class="customerCropper" for="upload_image" style="cursor: pointer">
                                                <span class="customLink">تنظیم تصویر حساب کاربری</span>
                                                <input type="file" name="image" id="upload_image" class="image"
                                                       style="display: none" accept="image/*">
                                            </label>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </figcaption>
                        <!-- End Figure Caption -->
                    </div>
                </figure>
                <!-- End Figure -->
            </div>
        </div>
        <div style="direction: rtl" class="modal fade bd-example-modal-lg" id="modal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">تنظیم اندازه تصویر</h5>
                        <button type="button" class="close"
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary" data-dismiss="modal">انصراف
                        </button>
                        <button type="button" id="crop" class="btn btn-primary g-mr-5">
                            <span id="cropText">برش</span>
                            <i id="waitingCrop"
                               style="display: none"
                               class="fa fa-spinner fa-spin g-px-10 m-0 g-font-size-20 g-color-white"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div style="direction: rtl" class="row g-brd-top g-brd-gray-light-v4">
            <!-- Filters -->
            <div class="col-md-3 flex-md-first g-brd-left--lg g-brd-gray-light-v4 filter">
                <div>
                    <div class="g-bg-white-opacity-0_9 bigDevice">
                        <div class="g-pr-15--lg d-flex g-pb-20 g-pt-20">
                            <h5 class="m-0 align-self-center">پنل کاربری</h5>
                        </div>
                        <hr style="z-index: 100 !important"
                            class="g-brd-gray-light-v4 g-mx-minus-15 g-mt-0 g-mb-0">
                    </div>

                    <div class="g-pr-15 g-pl-15 g-pl-0--lg g-pt-20">
                        <div style="direction: rtl" role="tablist" aria-multiselectable="true">
                            <!-- مشخصات فردی -->
                            <div class="card g-brd-0 g-mb-5">
                                <div id="accordion-100-heading-01" class="card-header g-pa-0" role="tab">
                                    <h5 class="h6 g-bg-white g-px-0 g-py-10 mb-0">
                                        <a style="cursor: pointer"
                                           id="filter-user-data"
                                           class="nav-link g-color-primary g-color-primary--hover p-0"
                                           onclick="showPanel('data');">
                                            مشخصات فردی
                                            <i class="icon-user float-left g-font-size-20 g-pb-5"></i>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                            <!-- دنبال شوندگان -->
                            <div class="card g-brd-0 g-mb-5">
                                <div id="accordion-100-heading-01" class="card-header g-pa-0" role="tab">
                                    <h5 style="position: relative" class="h6 g-bg-white g-px-0 g-py-10 mb-0">
                                        <a style="cursor: pointer"
                                           href="{{route('sellerMajorFollowing')}}"
                                           class="nav-link g-color-main g-color-primary--hover p-0">دنبال شوندگان
                                            <i class="icon-user-following float-left g-font-size-20 g-pb-5"></i>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                            <!-- پیام ها -->
                            <div class="card g-brd-0 g-mb-5">
                                <div id="accordion-100-heading-01" class="card-header g-pa-0" role="tab">
                                    <h5 class="h6 g-bg-white g-px-0 g-py-10 mb-0">
                                        <a style="cursor: pointer"
                                           href="{{route('cSmMessages')}}"
                                           class="nav-link g-color-main g-color-primary--hover p-0">پیام ها
                                            <div style="width: 20px; height: 20px"
                                                 class="{{$notificationMsg===0 ? 'd-none':'d-inline-block'}} g-bg-red text-center rounded-circle">
                                                <span style="color: white !important;">{{$notificationMsg}}</span>
                                            </div>
                                            <i class="icon-paper-plane float-left g-font-size-20 g-pb-5"></i>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                            <!-- ذخیره شده ها -->
                            <div class="card g-brd-0 g-mb-5">
                                <div id="accordion-100-heading-01" class="card-header g-pa-0" role="tab">
                                    <h5 style="position: relative" class="h6 g-bg-white g-px-0 g-py-10 mb-0">
                                        <a style="cursor: pointer"
                                           href="{{route('cSmSaved')}}"
                                           class="nav-link g-color-main g-color-primary--hover p-0">ذخیره شده ها
                                            <i class="fa fa-bookmark-o float-left g-font-size-20 g-pb-5"></i>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                            <!-- تغییر رمز -->
                            <div class="card g-brd-0 g-mb-5">
                                <div style="border: none" id="accordion-100-heading-01" class="card-header g-pa-0"
                                     role="tab">
                                    <h5 class="h6 g-bg-white g-px-0 g-py-10 mb-0">
                                        <a style="cursor: pointer"
                                           href="{{ route('requestMobile',['source'=>'forget']) }}"
                                           class="nav-link g-color-main p-0">تغییر رمز
                                            <i class="icon-lock float-left g-font-size-20 g-pb-5"></i>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                            <!-- خروج -->
                            <div class="card g-brd-0 g-mb-5">
                                <div style="border: none" id="accordion-100-heading-01" class="card-header g-pa-0"
                                     role="tab">
                                    <h5 class="h6 g-bg-white g-px-0 g-py-10 mb-0">
                                        <a style="cursor: pointer"
                                           class="nav-link g-color-main g-color-lightred--hover p-0"
                                           onclick="confirmLogout()">خروج
                                            <i class="icon-logout float-left g-font-size-20 g-pb-5"></i>
                                        </a>
                                        <form id="logout-customer-form" action="{{route('logout')}}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-md-9 flex-md-unordered">
                <!-- مشخصات فردی -->
                <div id="user-data">
                    <div class="g-bg-white-opacity-0_9 g-mb-30 g-mt-30 g-mt-0--lg">
                        <div style="padding-bottom: 18px;" class="g-pr-15 d-flex g-pt-20--lg g-pt-10 g-color-primary">
                            <i class="icon-user g-pl-5 g-font-size-20 g-font-weight-500"></i>

                            <h6 class="m-0 g-mt-7">
                                مشخصات فردی
                            </h6>
                        </div>
                        <hr class="g-brd-gray-light-v4 g-mx-minus-15 g-mt-0 g-mb-0 bigDevice">
                        <hr class="g-brd-primary g-mx-minus-15 g-mt-0 g-mb-0 smallDevice">
                    </div>
                    <form id="profileUpdate" action="{{route('profileUpdate')}}" method="POST">
                        @csrf
                        <div class="container g-py-30--lg g-px-60--lg">
                            {{--نام--}}
                            <div class="form-group row g-mb-15">
                                <label
                                    class="col-sm-2 col-form-label align-self-center">نام</label>
                                <div class="col-sm-10 force-col-12">
                                    <input id="user-name"
                                           class="form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16"
                                           type="text"
                                           value="{{ $customer->name }}"
                                           name="name"
                                           maxlength="15"
                                           placeholder="الزاما فارسی"
                                           {{--                                           lang="fa"--}}
                                           onkeyup="if (!(/^[\u0600-\u06FF\s]+$/.test($(this).val()))) {
                                                        str = $(this).val();
                                                        str = str.substring(0, str.length - 1);
                                                        $(this).val(str);
                                                        $(this).attr('autocomplete', 'off');
                                                    } else
                                                        $(this).attr('autocomplete', 'name');"
                                           readonly="">
                                </div>
                            </div>
                            {{--نام خانوادگی--}}
                            <div class="form-group row g-mb-15">
                                <label class="col-sm-2 col-form-label align-self-center">نام
                                    خانوادگی</label>
                                <div class="col-sm-10 force-col-12">
                                    <input
                                        class="form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16"
                                        id="user-family"
                                        name="family"
                                        maxlength="15"
                                        type="text"
                                        value="{{ $customer->Family }}"
                                        placeholder="الزاما فارسی"
                                        {{--                                           lang="fa"--}}
                                        onkeyup="if (!(/^[\u0600-\u06FF\s]+$/.test($(this).val()))) {
                                                        str = $(this).val();
                                                        str = str.substring(0, str.length - 1);
                                                        $(this).val(str);
                                                        $(this).attr('autocomplete', 'off');
                                                    } else
                                                        $(this).attr('autocomplete', 'name');"
                                        readonly="">
                                </div>
                            </div>
                            {{--کد ملی--}}
                            <div class="form-group row g-mb-15">
                                <label class="col-sm-2 col-form-label align-self-center">کد
                                    ملی</label>
                                <div dir="ltr" class="col-sm-10 force-col-12">
                                    <input
                                        class="form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16"
                                        id="user-notionalId"
                                        name="nationalId"
                                        value="{{ $customer->NationalID }}"
                                        oninput="forceEnglishNumber($(this).val(), $(this),'#birthday-day',10)"
                                        pattern="\d*"
                                        placeholder="فقط اعداد انگلیسی"
                                        readonly="">
                                </div>
                            </div>
                            {{--تاریخ تولد--}}
                            <div class="customDisable form-group row g-mb-15" style="pointer-events: none">
                                <label class="col-sm-2 col-form-label align-self-center">تاریخ
                                    تولد</label>
                                <div class="col-sm-10 force-col-12">
                                    <div class="d-flex">
                                        <select style="direction: ltr"
                                                class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none g-bg-gray-light-v5"
                                                id="birthday-day"
                                                name="day"
                                                tabindex="3">
                                            <option
                                                value="{{isset($customer->BirthdayD) ? $customer->BirthdayD:'0' }}">{{isset($customer->BirthdayD) ? $customer->BirthdayD:'روز' }}</option>
                                            <option value="01">1</option>
                                            <option value="02">2</option>
                                            <option value="03">3</option>
                                            <option value="04">4</option>
                                            <option value="05">5</option>
                                            <option value="06">6</option>
                                            <option value="07">7</option>
                                            <option value="08">8</option>
                                            <option value="09">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                        <select style="direction: ltr"
                                                id="birthday-mon"
                                                class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none g-bg-gray-light-v5"
                                                name="mon"
                                                tabindex="4">
                                            <option
                                                value="{{isset($customer->BirthdayM) ? $customer->BirthdayM:'0' }}">{{isset($customer->BirthdayM) ? $customer->BirthdayM:'ماه' }}</option>
                                            <option value="01">1</option>
                                            <option value="02">2</option>
                                            <option value="03">3</option>
                                            <option value="04">4</option>
                                            <option value="05">5</option>
                                            <option value="06">6</option>
                                            <option value="07">7</option>
                                            <option value="08">8</option>
                                            <option value="09">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        <select style="direction: ltr"
                                                id="birthday-year"
                                                class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-bg-gray-light-v5"
                                                name="year"
                                                tabindex="5">
                                            <option
                                                value="{{isset($customer->BirthdayY) ? $customer->BirthdayY:'0' }}">{{isset($customer->BirthdayY) ? $customer->BirthdayY:'سال' }}</option>
                                            <option value="1398">1398</option>
                                            <option value="1397">1397</option>
                                            <option value="1396">1396</option>
                                            <option value="1395">1395</option>
                                            <option value="1394">1394</option>
                                            <option value="1393">1393</option>
                                            <option value="1392">1392</option>
                                            <option value="1391">1391</option>
                                            <option value="1390">1390</option>
                                            <option value="1389">1389</option>
                                            <option value="1388">1388</option>
                                            <option value="1387">1387</option>
                                            <option value="1386">1386</option>
                                            <option value="1385">1385</option>
                                            <option value="1384">1384</option>
                                            <option value="1383">1383</option>
                                            <option value="1382">1382</option>
                                            <option value="1381">1381</option>
                                            <option value="1380">1380</option>
                                            <option value="1379">1379</option>
                                            <option value="1378">1378</option>
                                            <option value="1377">1377</option>
                                            <option value="1376">1376</option>
                                            <option value="1375">1375</option>
                                            <option value="1374">1374</option>
                                            <option value="1373">1373</option>
                                            <option value="1372">1372</option>
                                            <option value="1371">1371</option>
                                            <option value="1370">1370</option>
                                            <option value="1369">1369</option>
                                            <option value="1368">1368</option>
                                            <option value="1367">1367</option>
                                            <option value="1366">1366</option>
                                            <option value="1365">1365</option>
                                            <option value="1364">1364</option>
                                            <option value="1363">1363</option>
                                            <option value="1362">1362</option>
                                            <option value="1361">1361</option>
                                            <option value="1360">1360</option>
                                            <option value="1359">1359</option>
                                            <option value="1358">1358</option>
                                            <option value="1357">1357</option>
                                            <option value="1356">1356</option>
                                            <option value="1355">1355</option>
                                            <option value="1354">1354</option>
                                            <option value="1353">1353</option>
                                            <option value="1352">1352</option>
                                            <option value="1351">1351</option>
                                            <option value="1350">1350</option>
                                            <option value="1349">1349</option>
                                            <option value="1348">1348</option>
                                            <option value="1347">1347</option>
                                            <option value="1346">1346</option>
                                            <option value="1345">1345</option>
                                            <option value="1344">1344</option>
                                            <option value="1343">1343</option>
                                            <option value="1342">1342</option>
                                            <option value="1341">1341</option>
                                            <option value="1340">1340</option>
                                            <option value="1339">1339</option>
                                            <option value="1338">1338</option>
                                            <option value="1337">1337</option>
                                            <option value="1336">1336</option>
                                            <option value="1335">1335</option>
                                            <option value="1334">1334</option>
                                            <option value="1333">1333</option>
                                            <option value="1332">1332</option>
                                            <option value="1331">1331</option>
                                            <option value="1330">1330</option>
                                            <option value="1329">1329</option>
                                            <option value="1328">1328</option>
                                            <option value="1327">1327</option>
                                            <option value="1326">1326</option>
                                            <option value="1325">1325</option>
                                            <option value="1324">1324</option>
                                            <option value="1323">1323</option>
                                            <option value="1322">1322</option>
                                            <option value="1321">1321</option>
                                            <option value="1320">1320</option>
                                            <option value="1319">1319</option>
                                            <option value="1318">1318</option>
                                            <option value="1317">1317</option>
                                            <option value="1316">1316</option>
                                            <option value="1315">1315</option>
                                            <option value="1314">1314</option>
                                            <option value="1313">1313</option>
                                            <option value="1312">1312</option>
                                            <option value="1311">1311</option>
                                            <option value="1310">1310</option>
                                            <option value="1309">1309</option>
                                            <option value="1308">1308</option>
                                            <option value="1307">1307</option>
                                            <option value="1306">1306</option>
                                            <option value="1305">1305</option>
                                            <option value="1304">1304</option>
                                            <option value="1303">1303</option>
                                            <option value="1302">1302</option>
                                            <option value="1301">1301</option>
                                            <option value="1300">1300</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{--جنسیت--}}
                            <div class="customDisable form-group row g-mb-15" style="pointer-events: none">
                                <label
                                    class="col-sm-2 col-form-label align-self-center">جنسیت</label>
                                <div class="col-sm-10 force-col-12">
                                    <div class="btn-group-lg d-flex">
                                        <label class="u-check col-md-4 g-pa-0">
                                            <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0" name="gender"
                                                   type="radio"
                                                   {{ ($customer->Gender === 0) ?  'checked':''}} value="0">
                                            <span
                                                class="btn btn-md btn-block g-brd-gray-light-v2 g-bg-gray-light-v5 g-brd-left-none g-brd-left-1--lg g-bg-primary--checked rounded-0 g-color-white--checked">زن</span>
                                        </label>
                                        <label class="u-check col-md-4 g-pa-0">
                                            <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0" name="gender"
                                                   type="radio"
                                                   {{ ($customer->Gender === 1) ?  'checked':''}} value="1">
                                            <span
                                                class="btn btn-md btn-block g-brd-gray-light-v2 g-bg-gray-light-v5 g-brd-left-none g-brd-left-1--lg g-bg-primary--checked rounded-0 g-color-white--checked">مرد</span>
                                        </label>
                                        <label class="u-check col-md-4 g-pa-0">
                                            <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0" name="gender"
                                                   type="radio"
                                                   {{ ($customer->Gender === 2) ?  'checked':''}} value="2">
                                            <span
                                                class="btn btn-md btn-block g-brd-gray-light-v2 g-bg-gray-light-v5 g-bg-primary--checked rounded-0 g-color-white--checked">کودک</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{--تلفن ثابت--}}
                            <div class="form-group row g-mb-15">
                                <label class="col-sm-2 col-form-label align-self-center">تلفن
                                    ثابت</label>
                                <div class="col-sm-10 force-col-12 d-flex">
                                    <input
                                        style="direction: ltr"
                                        class="text-left col-8 form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16"
                                        id="phoneNumber"
                                        name="phone"
                                        type="text"
                                        oninput="forceEnglishNumber($(this).val(), $(this),'#stateSelect',8)"
                                        pattern="\d*"
                                        value="{{ $customer->Phone }}"
                                        placeholder="xxxxxxxx"
                                        readonly="">
                                    <input
                                        style="direction: ltr"
                                        id="phonePreNumber"
                                        name="prePhone"
                                        class="text-left col-4 form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16 g-brd-right-none"
                                        pattern="\d*"
                                        value="{{ $customer->PrePhone }}"
                                        oninput="forceEnglishNumber($(this).val(), $(this),'#phoneNumber',3)"
                                        placeholder="0xx"
                                        readonly="">
                                </div>
                            </div>
                            {{--آدرس سکونت--}}
                            <div class="customDisable form-group row g-mb-15" style="pointer-events: none">
                                <label class="col-sm-2 col-form-label align-self-center">آدرس
                                    سکونت</label>
                                <div class="col-sm-10 force-col-12">
                                    <div class="d-lg-flex">
                                        <!--ورودی زیر فقط برای دریافت استان جاوااسکریپت استفاده می شود-->
                                        <input id="state" class="d-none" value="{{ $customer->State }}">
                                        <select id="stateSelect" style="direction: rtl; padding-right: 30px !important"
                                                class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none--lg g-bg-gray-light-v5 g-mb-10 g-mb-0--lg"
                                                tabindex="3"
                                                name="state"
                                                onchange="changeState('stateSelect','citySelect')">
                                            <option value="0">استان</option>
                                            <option value="1">آذربایجان شرقی</option>
                                            <option value="2">آذربایجان غربی</option>
                                            <option value="3">اردبیل</option>
                                            <option value="4">اصفهان</option>
                                            <option value="5">البرز</option>
                                            <option value="6">ایلام</option>
                                            <option value="7">بوشهر</option>
                                            <option value="8">تهران</option>
                                            <option value="9">چهارمحال و بختیاری</option>
                                            <option value="10">خراسان جنوبی</option>
                                            <option value="11">خراسان رضوی</option>
                                            <option value="12">خراسان شمالی</option>
                                            <option value="13">خوزستان</option>
                                            <option value="14">زنجان</option>
                                            <option value="15">سمنان</option>
                                            <option value="16">سیستان و بلوچستان</option>
                                            <option value="17">فارس</option>
                                            <option value="18">قزوین</option>
                                            <option value="19">قم</option>
                                            <option value="20">کردستان</option>
                                            <option value="21">کرمان</option>
                                            <option value="22">کرمانشاه</option>
                                            <option value="23">کهگیلویه و بویراحمد</option>
                                            <option value="24">گلستان</option>
                                            <option value="25">گیلان</option>
                                            <option value="26">لرستان</option>
                                            <option value="27">مازندران</option>
                                            <option value="28">مرکزی</option>
                                            <option value="29">هرمزگان</option>
                                            <option value="30">همدان</option>
                                            <option value="31">یزد</option>
                                        </select>

                                        <!--ورودی زیر فقط برای دریافت شهر جاوااسکریپت استفاده می شود-->
                                        <input id="city" class="d-none" value="{{ $customer->City }}">
                                        <select id="citySelect" style="direction: rtl; padding-right: 30px !important"
                                                class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-bg-gray-light-v5"
                                                name="city"
                                                tabindex="4">
                                            <option value="">شهر</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div style="direction: ltr" class="g-mx-60--lg g-mt-60--lg g-mb-30--lg g-my-30 g-mx-15">
                        <button id="edit" type="button"
                                class="btn btn-md u-btn-outline-primary g-bg-white g-bg-primary--hover rounded-0 force-col-12 g-mb-15"
                                onclick="editUserData()">
                            ویرایش مشخصات فردی
                        </button>
                        <button id="save" style="display: none" type="button"
                                class="btn btn-md u-btn-primary rounded-0 force-col-12 g-mb-15"
                                onclick="saveUserData()">
                            ثبت اطلاعات
                        </button>
                    </div>
                </div>
            </div>
            <!-- End Content -->
        </div>
    </div>
@endsection
