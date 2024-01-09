@extends('Layouts.IndexAdmin')
@section('Content')
    <div class="g-bg-gray-dark-v2 g-color-white g-px-15 g-py-30">
        <!-- Nav tabs -->
        <ul class="nav nav-fill u-nav-v4-1 u-nav-light adminPanelResponsive" role="tablist" data-target="nav-4-1-primary-hor-fill"
            data-tabs-mobile-type="slide-up-down" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-white">
            <li class="nav-item">
                <a class="nav-link" href="{{route('customerList')}}">خریداران</a>
            </li>

            <!--پشتیبانی-->
            <li class="nav-item">
                <a id="customerSupport" class="nav-link" href="{{route('customerControlPanel',['id'=>$customerInfo->id,'tab'=>'support'])}}">
                    پشتیبانی
                </a>
            </li>

            <!--محصولات برگشتی-->
            <li class="nav-item">
                <a id="sellerOrder" class="nav-link g-mb-minus-1" href="{{route('adminCustomerReturn',$customerInfo->id)}}">
                    محصولات برگشتی</a>
            </li>

            <!--تحویل محصول-->
            <li class="nav-item">
                <a id="customerDelivery" class="nav-link g-mb-minus-1" href="{{route('customerControlPanel',['id'=>$customerInfo->id,'tab'=>'delivery'])}}">
                    <span id="deliveryAlarm" class="d-none g-mr-10">
                        <i class="fa fa-exclamation-triangle g-font-size-18 g-color-lightred"></i>
                    </span>
                    تحویل محصول
                </a>
            </li>

            <!--فاکتور-->
            <li class="nav-item">
                <a id="sellerOrder" class="nav-link g-mb-minus-1 active" data-toggle="tab" href="#nav-4-1-primary-hor-fill--4" role="tab">
                    <span id="deliveryAlarm" class="{{$pf==='' ? 'd-none ': ''}}g-mr-10">
                        <i class="fa fa-exclamation-triangle g-font-size-18 g-color-lightred"></i>
                    </span>
                    فاکتورهای خرید</a>
            </li>

            <!--آدرسها-->
            <li class="nav-item">
                <a id="customerAddress" class="nav-link" href="{{route('customerControlPanel',['id'=>$customerInfo->id,'tab'=>'addressTab'])}}"
                   role="tab">آدرس های تحویل</a>
            </li>

            <!--اطلاعات کاربری-->
            <li class="nav-item">
                <a id="customerInfo" class="nav-link" href="{{route('customerControlPanel',['id'=>$customerInfo->id,'tab'=>'user'])}}"
                   role="tab">اطلاعات
                    کاربری</a>
            </li>
        </ul>
        <!-- End Nav tabs -->

        <!-- Tab panes -->
        <div id="nav-4-1-primary-hor-fill" class="tab-content g-pt-40 g-mb-150">
            <!--فاکتور-->
            <div class="tab-pane fade show active" id="nav-4-1-primary-hor-fill--4" role="tabpanel">
                <div style="padding-bottom: 120px" class="container">
                    {{-- Total Info--}}
                    <div class="rowSeller g-mt-30 g-mb-20 g-mr-0 g-ml-0 opacity-0-bigDevice">

                        <!-- Icon Blocks -->
                        <div
                            class="col-lg-4 text-center g-pt-25 g-pb-25 g-mb-5 g-pr-0 g-pl-0">

                            <h3 class="h6 g-color-white mb-3">فاکتورهای فروش امروز</h3>
                            <span class="u-label g-bg-bluegray g-mb-5">برابر است با<span
                                    class="g-mr-5 g-ml-5 g-color-aqua">{{ $saleSum['todayOrder'] }}</span>عدد </span>
                        </div>
                        <!-- End Icon Blocks -->

                        <!-- Icon Blocks -->
{{--                        <div--}}
{{--                            class="col-lg-3 text-center g-pt-25 g-pb-25 g-mb-5 g-pr-0 g-pl-0">--}}

{{--                            <h3 class="h6 g-color-white mb-3">فاکتورهای فروش در طول یک ماه</h3>--}}
{{--                            <span class="u-label g-bg-bluegray g-mb-5">برابر است با<span--}}
{{--                                    class="g-mr-5 g-ml-5 g-color-aqua">{{ $saleSum['monthOrder'] }}</span>عدد </span>--}}
{{--                        </div>--}}
                        <!-- End Icon Blocks -->

                        <!-- Icon Blocks -->
                        <div
                            class="col-lg-4 text-center g-pt-25 g-pb-25 g-mb-5 g-pr-0 g-pl-0">

                            <h3 class="h6 g-color-white mb-3">تعداد کل فاکتورهای فروش</h3>
                            <span class="u-label g-bg-bluegray g-mb-5">برابر است با<span
                                    class="g-mr-5 g-ml-5 g-color-aqua">{{ $saleSum['allOrder'] }}</span>عدد </span>
                        </div>
                        <!-- End Icon Blocks -->

                        <!-- Icon Blocks -->
                        <div
                            class="col-lg-4 text-center g-pt-25 g-pb-25 g-mb-5 g-pr-0 g-pl-0">
                            <h3 class="h6 g-color-white mb-3">کل درآمد حاصل از فاکتورهای فروش</h3>
                            <span class="u-label g-bg-bluegray g-mr-5 g-mb-5">برابر است با<span
                                    class="g-mr-5 g-ml-5 g-color-aqua">{{ number_format($saleSum['totalSaleAmount']) }}</span>تومان </span>
                        </div>
                        <!-- End Icon Blocks -->
                    </div>

                    {{-- Filters --}}
                    <div id="accordion-13" class="u-accordion u-accordion-color-primary" role="tablist"
                         aria-multiselectable="true">
                        <!-- Card -->
                        <div class="card g-brd-none rounded-0 g-mb-15">
                            <div id="accordion-13-heading-01" class="u-accordion__header g-pa-0 text-right" role="tab">
                                <h5 class="mb-0">
                                    <a
                                        class="d-block g-color-gray-light-v3 g-bg-gray-dark-v3 g-text-underline--none--hover g-brd-around g-brd-gray-dark-v5 g-rounded-0 g-pa-10-15 g-font-size-16 collapsed"
                                        href="#accordion-13-body-01" data-toggle="collapse" data-parent="#accordion-13"
                                        aria-expanded="false" aria-controls="accordion-13-body-01">
                                      <span class="u-accordion__control-icon g-mr-10">
                                        <i class="fa fa-angle-down"></i>
                                        <i class="fa fa-angle-up"></i>
                                      </span>
                                        فیلترها<i class="fa fa-sliders g-ml-5"></i>
                                    </a>
                                </h5>
                            </div>
                            <div id="accordion-13-body-01" class="collapse g-bg-gray-dark-v2" role="tabpanel"
                                 aria-labelledby="accordion-13-heading-01">
                                <div class="u-accordion__body g-color-gray-dark-v5 p-0 pt-2">
                                    <div class="m-0 p-0">
                                        <div
                                            class="g-pr-10 g-pl-10 g-mb-0 g-pt-20 g-mb-25">
                                            <div class="rowSeller">
                                                {{--                    Name Filter--}}
                                                <div class="form-group g-mb-10 text-right col-lg-6 mx-auto">
                                                    <div class="input-group g-brd-primary--focus g-mb-10">
                                                        <input style="direction: rtl"
                                                               class="form-control form-control-md rounded-0 g-bg-gray-dark-v2 g-color-gray-light-v4 pl-0 text-right g-font-size-16"
                                                               type="text" id="saleProduct_search"
                                                               tabindex="1"
                                                               placeholder=""
                                                               value="">
                                                        <div
                                                            class="input-group-addon d-flex align-items-center g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0 w-50">
                                                            براساس نام
                                                        </div>
                                                    </div>
                                                    <ul id="saleName" class="ajaxDropDown"></ul>
                                                </div>

                                                {{--                    Gender Filter--}}
                                                <div class="form-group g-mb-10 text-right col-lg-6 mx-auto">
                                                    <div class="input-group g-brd-primary--focus g-mb-10">
                                                        <select
                                                            class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                            name="brand"
                                                            tabindex="2"
                                                            id="saleGender">
                                                            <option
                                                                value="">همه
                                                            </option>
                                                            <option value="0">زنانه</option>
                                                            <option value="1">مردانه</option>
                                                            <option value="2">نوزادی</option>
                                                            <option value="3">دخترانه</option>
                                                            <option value="4">پسرانه</option>
                                                        </select>
                                                        <div
                                                            class="input-group-addon d-flex align-items-center g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0 w-50">
                                                            براساس جنسیت
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--                Date Calender Filter For Big Device--}}
                                                <div class="form-group g-mb-10 text-right col-lg-6 mx-auto bigDevice">
                                                    <div class="input-group g-brd-primary--focus g-mb-0">

                                                        <select
                                                            class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                            id="startYearBD"
                                                            tabindex="5">
                                                            <option value="">سال</option>
                                                            <option value="1399">1399</option>
                                                        </select>

                                                        <select
                                                            class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                            id="startMonBD"
                                                            tabindex="4">
                                                            <option value="">ماه</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                        </select>

                                                        <select
                                                            class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                            id="startDayBD"
                                                            tabindex="3">
                                                            <option value="">روز</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
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

                                                        <div
                                                            class="input-group-addon d-flex align-items-center g-bg-white g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0">
                                                            از
                                                        </div>
                                                        <div
                                                            class="input-group-addon d-flex align-items-center g-bg-white g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0">
                                                            محدوده تاریخ فاکتور
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group g-mb-20 text-right col-lg-6 mx-auto bigDevice">
                                                    <div class="input-group g-brd-primary--focus">
                                                        <button type="button"
                                                                class="btn btn-md u-btn-primary rounded-0"
                                                                id="filterDateBtnBD"
                                                                disabled
                                                                onclick="applyDateFilter('sale', 'startDayBD', 'startMonBD', 'startYearBD', 'endDayBD', 'endMonBD', 'endYearBD')">
                                                            اعمال
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-md u-btn-orange rounded-0"
                                                                id="ResetDateBtnBD"
                                                                disabled
                                                                onclick="resetDate('startDayBD', 'startMonBD', 'startYearBD', 'endDayBD', 'endMonBD', 'endYearBD', 'ResetDateBtnBD')">
                                                            از نو
                                                        </button>
                                                        <select
                                                            class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                            id="endYearBD"
                                                            tabindex="8">
                                                            <option value="">سال</option>
                                                            <option value="1399">1399</option>
                                                        </select>

                                                        <select
                                                            class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                            id="endMonBD"
                                                            tabindex="7">
                                                            <option value="">ماه</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                        </select>

                                                        <select
                                                            class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                            id="endDayBD"
                                                            tabindex="6">
                                                            <option value="">روز</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
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

                                                        <div
                                                            class="input-group-addon d-flex align-items-center g-bg-white g-bg-gray-dark-v2 g-color-gray-light-v4  rounded-0">
                                                            تا
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--                Price Filter For Big Device--}}
                                                <div class="form-group g-mb-10 text-right col-lg-6 mx-auto bigDevice">
                                                    <div class="input-group g-brd-primary--focus g-mb-0">
                                                        <button type="button"
                                                                class="btn btn-md u-btn-primary rounded-0"
                                                                id="filterPriceBtnBD"
                                                                disabled
                                                                onclick="applyPriceFilter('sale')">
                                                            اعمال
                                                        </button>
                                                        {{--             Hide Tempority Input--}}
                                                        <input class="d-none" type="number" id="MaxPriceTemp">
                                                        <input class="d-none" type="number" id="MinPriceTemp">

                                                        <input
                                                            class="form-control form-control-md rounded-0 text-center g-font-size-16 g-bg-gray-dark-v2 g-color-gray-light-v4"
                                                            type="text"
                                                            id="saleMaxPriceBD"
                                                            tabindex="9"
                                                            placeholder="بیش ترین"
                                                            onfocus="selectText('saleMaxPriceBD')"
                                                            oninput="filterPriceCheck('saleMinPriceBD', 'saleMaxPriceBD', 'filterPriceBtnBD')"
                                                            value="">
                                                        <div
                                                            class="input-group-addon d-flex align-items-center g-bg-white g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0">
                                                            تا
                                                        </div>
                                                        <input
                                                            class="form-control form-control-md rounded-0 text-center g-font-size-16 g-bg-gray-dark-v2 g-color-gray-light-v4"
                                                            type="text"
                                                            id="saleMinPriceBD"
                                                            tabindex="10"
                                                            placeholder="کم ترین"
                                                            onfocus="selectText('saleMinPriceBD')"
                                                            oninput="filterPriceCheck('saleMinPriceBD', 'saleMaxPriceBD', 'filterPriceBtnBD')"
                                                            value="">
                                                        <div
                                                            class="input-group-addon d-flex align-items-center g-bg-white g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0">
                                                            از
                                                        </div>
                                                        <div
                                                            class="input-group-addon d-flex align-items-center g-bg-white g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0">
                                                            مبلغ فاکتور
                                                        </div>
                                                    </div>
                                                    <ul id="product_list" class="ajaxDropDown"></ul>
                                                </div>

                                                {{--                    Data Mistake Filters--}}
                                                <div
                                                    class="g-brd-around g-brd-gray-light-v2 rounded-0 g-pt-6 text-center g-mb-5 g-mr-15 g-ml-15 smallDevice w-100">
                                                    <label style="direction: rtl"
                                                           class="g-color-gray-light-v1 align-self-center">مشخصات</label>
                                                </div>
                                                <div
                                                    class="btn-group justified-content text-center col-lg-6 mx-auto g-mb-20">
                                                    <label class="u-check m-0"
                                                           tabindex="11">
                                                        <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0"
                                                               name="mistak"
                                                               type="radio" id="false"
                                                               onclick="trueInfo('saleInfoStatus')">
                                                        <span
                                                            class="btn btn-lg btn-block u-btn-outline-lightgray g-color-gray-light-v3 g-color-primary--hover g-color-white--checked g-bg-primary--checked rounded-0">اشتباه</span>
                                                    </label>
                                                    <label class="u-check m-0"
                                                           tabindex="12">
                                                        <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0"
                                                               name="mistak"
                                                               type="radio" id="true"
                                                               onclick="trueInfo('saleInfoStatus')">
                                                        <span
                                                            class="btn btn-lg btn-block u-btn-outline-lightgray g-color-gray-light-v3 g-color-primary--hover g-color-white--checked g-bg-primary--checked g-brd-left-none--md rounded-0">صحیح</span>
                                                    </label>
                                                    <label class="u-check m-0" style="pointer-events: none">
                                                        <span
                                                            class="btn btn-lg btn-block u-btn-outline-lightgray g-color-gray-light-v1 g-brd-left-none--md rounded-0">مشخصات</span>
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Card -->

                    </div>

                    {{-- Table --}}
                    <div class="g-pb-15">

                        @if ($saleTable->count()!==0)
                            <h6 style="direction: rtl"
                                class="card-header g-bg-orange-opacity-0_1 g-brd-around g-brd-gray-light-v4 g-color-gray-dark rounded-0 g-mb-5 text-right tableHint">
                                <i class="fa fa-hand-o-right g-font-size-18"></i>
                                <span class="g-font-size-13">جدول را به سمت راست بکشید.</span>
                            </h6>
                        @endif
                        @if ($saleTable->count()===0)
                        <!-- Danger Alert -->
                            <div style="direction: rtl" class="alert alert-danger alert-dismissible fade show"
                                 role="alert">
                                <div class="media">
                                    <span class="d-flex ml-2 g-mt-5">
                                        <i class="fa fa-minus-circle"></i>
                                    </span>
                                    <div class="media-body">
                                        <strong>موردی یافت نشد.</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Danger Alert -->
                        @else
                            <div class="table-responsive">
                                <table style="direction: rtl" class="table table-bordered u-table--v2">
                                    <thead>
                                    <tr>
                                        <th class="align-middle text-center focused rtlPosition">کد محصول</th>
                                        <th class="align-middle text-center">نام</th>
                                        <th class="align-middle text-center">جنسیت</th>
                                        <th class="align-middle text-center">تعداد</th>
                                        <th class="align-middle text-center text-nowrap">مبلغ فاکتور<span
                                                class="g-font-size-10 g-mr-3">(تومان)</span>
                                        </th>
                                        <th class="align-middle text-center">تاریخ</th>
                                        <th class="align-middle text-center text-nowrap">شماره فاکتور</th>
                                        <th class="align-middle text-center">روش ارسال</th>
                                        <th class="align-middle text-center">عکس</th>
                                        <th class="align-middle text-center">جزییات</th>
                                        <th class="align-middle text-center">مشخصات</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($saleTable as $key => $rec)
                                        <tr>
                                            <td class="align-middle text-nowrap text-center text-nowrap">{{ $rec->pDetailID }}</td>
                                            <td class="align-middle text-nowrap text-center text-nowrap">{{ $rec->Name }}</td>

                                            @if($rec->Gender == 'زنانه')
                                                <td class="align-middle text-center">زنانه</td>
                                            @elseif($rec->Gender == 'مردانه')
                                                <td class="align-middle text-center">مردانه</td>
                                            @elseif($rec->Gender == 'دخترانه')
                                                <td class="align-middle text-center">دخترانه</td>
                                            @elseif($rec->Gender == 'پسرانه')
                                                <td class="align-middle text-center">پسرانه</td>
                                            @elseif($rec->Gender == 'نوزادی دخترانه')
                                                <td class="align-middle text-center">نوزادی دخترانه</td>
                                            @else
                                                <td class="align-middle text-center">نوزادی پسرانه</td>
                                            @endif

                                            <td class="align-middle text-center">{{ $rec->Qty }}</td>
                                            <td class="align-middle text-center">{{ number_format($rec->OrderDetailFinalPrice * $rec->Qty) }}</td>
                                            <td class="align-middle text-center text-nowrap">{{ $persianDate[$key][0].'/'.$persianDate[$key][1].'/'.$persianDate[$key][2] }}</td>
                                            <td class="align-middle text-center">{{ $rec->orderID.'/'.$rec->orderDetailID }}</td>
                                            <td class="align-middle text-center text-nowrap">{{ $rec->PostMethod }}</td>
                                            <td class="align-middle">
                                                <div class="media">
                                                    <img class="d-flex g-width-60 g-height-60 g-rounded-3 mx-auto"
                                                         src="{{ file_exists(public_path($rec->PicPath.$rec->SampleNumber.'.jpg'))?$rec->PicPath.$rec->SampleNumber:$rec->PicPath.'sample1' }}.jpg" alt="">
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a style="cursor: pointer"
                                                   href="{{ route('adminCustomerOrderDetail',['addressId'=>$rec->AddressID, 'id'=>$rec->orderDetailID]) }}"
                                                   class="g-color-gray-light-v3 g-text-underline--none--hover g-color-primary--hover g-pa-5"
                                                   data-toggle="tooltip"
                                                   data-placement="top" data-original-title="مشاهده جزئیات فاکتور">
                                                    <i class="fa fa-eye g-font-size-18"></i>
                                                </a>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if (isset($rec->fpID))
                                                    <a class="g-color-gray-dark-v5 g-text-underline--none--hover g-pa-5"
                                                       data-toggle="tooltip"
                                                       data-placement="top" data-original-title="حاوی اشتباه">
                                                        <i class="fa fa-exclamation-triangle g-font-size-18 g-color-lightred"></i>
                                                    </a>
                                                @else
                                                    <a class="g-color-gray-dark-v5 g-text-underline--none--hover g-pa-5"
                                                       data-toggle="tooltip"
                                                       data-placement="top" data-original-title="صحیح">
                                                        <i class="fa fa-check g-font-size-18 g-color-primary"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        {{-- End Table --}}
                    </div>

                    {{-- Pagination --}}
                    {{ $saleTable->links('General.Pagination', ['result' => $saleTable]) }}
                </div>
            </div>
        </div>

@endsection
