@extends('Layouts.IndexAdmin')
@section('Content')
    @switch($tab)
        @case('user')
            <span id="customerUser" class="d-none">1</span>
        @break

        @case('userInfo')
            <div class="modal" id="overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-right g-bg-gray-light-v5">
                        <button type="button" class="close g-font-size-20" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title"><span
                                class="fa fa-check-square g-color-primary g-font-size-25 g-ml-15"></span></h4>
                    </div>
                    <div class="modal-body text-right">
                        <p style="direction: rtl">اطلاعات کاربری خریدار به روز رسانی شد.</p>
                    </div>
                </div>
            </div>
        </div>
        @break

        @case('support')
            <span id="cusSupport" class="d-none">1</span>
        @if(session()->has('status'))
            <div class="modal fade" id="overlay">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-right g-bg-gray-light-v5">
                            <button type="button" class="close g-font-size-20" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title"><span
                                    class="fa fa-check-square g-color-primary g-font-size-25 g-ml-15"></span></h4>
                        </div>
                        <div class="modal-body text-right">
                            <p style="direction: rtl">پیام با موفقیت ارسال شد.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @break
        @default
    @endswitch

    <div class="g-bg-gray-dark-v2 g-color-white g-px-15 g-py-30">
        <!-- Nav tabs -->
        <ul class="nav nav-fill u-nav-v4-1 u-nav-light adminPanelResponsive" role="tablist" data-target="nav-4-1-primary-hor-fill"
            data-tabs-mobile-type="slide-up-down" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-white">
            <li class="nav-item">
                <a class="nav-link" href="{{route('customerList')}}">بازدیدکنندگان</a>
            </li>

            <!--پشتیبانی-->
            <li class="nav-item">
                <a id="customerSupport" class="nav-link" data-toggle="tab" href="#nav-4-1-primary-hor-fill--1" role="tab">
                    <div style="width: 20px; height: 20px"
                         class="{{$newSupport===0 ? 'd-none ': 'd-inline-block '}}text-center g-color-black g-bg-lightred g-rounded-50x g-mr-10">
                        {{$newSupport}}
                    </div>
                    پشتیبانی
                </a>
            </li>

            <!--اعمال محدودیت -->
            <li class="nav-item">
                <a id="sellerBlock" class="nav-link" data-toggle="tab" href="#nav-4-1-primary-hor-fill--9"
                   role="tab">اعمال محدودیت</a>
            </li>

            <!--اطلاعات کاربری-->
            <li class="nav-item">
                <a id="customerInfo" class="nav-link active" data-toggle="tab" href="#nav-4-1-primary-hor-fill--8"
                   role="tab">اطلاعات
                    کاربری</a>
            </li>
        </ul>
        <!-- End Nav tabs -->

        <!-- Tab panes -->
        <div id="nav-4-1-primary-hor-fill" class="tab-content g-pt-40">
            <!--پشتیبانی-->
            <div class="tab-pane fade" id="nav-4-1-primary-hor-fill--1" role="tabpanel">
                <div class="container g-pb-170">
                    {{-- Total Info--}}
                    <div class="rowSeller g-mt-30 g-mb-20 g-mr-0 g-ml-0">
                        <!-- Icon Blocks -->
                        <div style="padding-right: 60px;"
                             class="text-header-responsive col-12 g-pt-25 g-pb-25 g-mb-5 g-pl-0">
                            <div class="d-inline-block text-center">
                                <a
                                    class="u-icon-v2 g-color-teal rounded-circle g-mb-20 g-color-orange--hover"
                                    data-toggle="modal"
                                    data-target="#modalLoginForm"
                                    href="#">
                                    <i class="icon-earphones-alt g-font-size-25"></i>
                                </a>
                                <h6 class="g-color-white mb-3">ارسال پیام</h6>
                            </div>
                        </div>
                        <!-- End Icon Blocks -->
                    </div>
                    <div style="direction: rtl" class="text-left">
                        <div class="modal fade text-center" id="modalLoginForm" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="g-bg-gray-dark-v2 modal-content">
                                    <div style="background-color: #333" class="modal-header">
                                        <h5>ارسال پیام</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-close"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('adminToCustomersMsg')}}" method="post"
                                          enctype='multipart/form-data'>
                                        @csrf
                                        {{--                            Hidden input--}}
                                        <div style="direction: rtl; background-color: #333"
                                             class="modal-body g-pr-10 g-pl-10 g-pt-40">
                                            <div class="form-group row g-mb-25">
                                                <div class="input-group col-sm-10 force-col-12 mx-auto">
                                                <span style="border-right: 1px solid lightgrey"
                                                      class="input-group-addon g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none w-25">عنوان پیام</span>
                                                    <input
                                                        class="form-control form-control-md rounded-0 g-color-white g-font-size-16 g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                        type="text"
                                                        value=""
                                                        id="login"
                                                        name="title"
                                                        autocomplete="off" {{-- hide popup box when clicked --}}
                                                        tabindex="1"
                                                        autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row g-mb-25">
                                                <div class="input-group col-sm-10 force-col-12 mx-auto">
                                                    <span style="border-right: 1px solid lightgrey;"
                                                          class="input-group-addon g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none g-pa-10 w-25">اولویت</span>
                                                    <select style="height: 100%"
                                                            class="form-control form-control-md custom-select rounded-0 text-right g-font-size-16 g-height-70 g-pr-25 g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                            tabindex="2"
                                                            name="priority">
                                                        <option value="2">معمولی</option>
                                                        <option value="1">مهم</option>
                                                        <option value="0">فوری</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row g-mb-25">
                                                <div class="input-group col-sm-10 force-col-12 mx-auto">
                                                    <span style="border-right: 1px solid lightgrey;"
                                                          class="input-group-addon g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none g-pa-10 w-25">بخش مربوطه</span>
                                                    <select style="height: 100%"
                                                            class="form-control form-control-md custom-select rounded-0 text-right g-font-size-16 g-height-70 g-pr-25 g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                            tabindex="3"
                                                            name="section">
                                                        <option value="0">فنی</option>
                                                        <option value="1">تحویل کالا</option>
                                                        <option value="2">مالی</option>
                                                        <option value="3">مدیریت</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row g-mb-25">
                                                <div class="input-group col-sm-10 force-col-12 mx-auto">
                                                <span style="border-right: 1px solid lightgrey"
                                                      class="input-group-addon g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none w-25">متن پیام</span>
                                                    <textarea style="direction: rtl"
                                                              class="form-control g-bg-gray-dark-v3 g-color-white form-control-md g-resize-none rounded-0 pl-0 text-right g-font-size-16"
                                                              rows="6"
                                                              tabindex="1"
                                                              value=""
                                                              placeholder="پیامتان را شروع کنید.. (300 حرف)"
                                                              name="msg"
                                                              id="msg"
                                                              maxlength="300"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row g-mb-25">
                                                <div class="input-group col-sm-10 force-col-12 mx-auto">
                                                <span style="border-right: 1px solid lightgrey"
                                                      class="input-group-addon g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none w-25">لینک پیام</span>
                                                    <input style="direction: ltr"
                                                           class="form-control form-control-md rounded-0 g-color-white g-font-size-16 g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                           type="text"
                                                           value=""
                                                           oninput="$('#linkHint').text('https://tanastyle.ir/'+$(this).val())"
                                                           id="msgLink"
                                                           placeholder="https://tanastyle.ir/..."
                                                           name="msgLink"
                                                           autocomplete="off" {{-- hide popup box when clicked --}}
                                                           tabindex="1">
                                                </div>
                                            </div>
                                            <div style="direction: ltr" class="form-group row g-mb-25">
                                                <div class="input-group col-sm-10 force-col-12 mx-auto">
                                                    <h5 class="text-left" id="linkHint"></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit"
                                                class="btn btn-md u-btn-primary col-12 rounded-0 g-pa-15 g-color-white">
                                            ارسال پیام
                                        </button>
                                        <input class="d-none" type="text" value="{{$customerInfo->id}}" name="userID">
                                        <input class="d-none" type="text" value="{{$customerInfo->Mobile}}" name="mobile">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Table --}}
                    <div class="g-pb-15">
                        @if ($support->count()!==0)
                            <h6 style="direction: rtl"
                                class="card-header g-bg-orange-opacity-0_1 g-brd-around g-brd-gray-light-v4 g-color-gray-dark rounded-0 g-mb-5 text-right tableHint">
                                <i class="fa fa-hand-o-right g-font-size-18"></i>
                                <span class="g-font-size-13">جدول را به سمت راست بکشید.</span>
                            </h6>
                        @endif

                        @if ($support->count()===0)
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
                                        <th class="align-middle text-center text-nowrap focused rtlPosition">عنوان
                                            گفتگو
                                        </th>
                                        <th class="align-middle text-center text-nowrap">بخش مربوطه</th>
                                        <th class="align-middle text-center text-nowrap">اولویت</th>
                                        <th class="align-middle text-center text-nowrap">زمان ایجاد گفتگو</th>
                                        <th class="align-middle text-center text-nowrap">جزئیات</th>
                                        <th class="align-middle text-center text-nowrap">وضعیت گفتگو</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    {{--                                GroupBy Variable Hidden input--}}
                                    {{--                        groupBy for grouping msg with one title--}}
                                    <input style="display: none" value=" {{ $groupBy = '' }}">

                                    @foreach($support as $key => $rec)
                                        @if (($rec->ConversationID) !== $groupBy)
                                            <tr>
                                                <td class="align-middle text-nowrap text-center g-font-weight-600 g-color-aqua">{{ $rec->Subject }}</td>
                                                {{--                                Section--}}
                                                @if ($rec->Section === '0')
                                                    <td class="align-middle text-center text-nowrap">فنی</td>
                                                @elseif ($rec->Section === '1')
                                                    <td class="align-middle text-center text-nowrap">تحویل کالا</td>
                                                @elseif ($rec->Section === '2')
                                                    <td class="align-middle text-center text-nowrap">مالی</td>
                                                @elseif ($rec->Section === '3')
                                                    <td class="align-middle text-center text-nowrap">مدیریت</td>
                                                @endif

                                                {{--                                Priority--}}
                                                @if ($rec->Priority === '2')
                                                    <td class="align-middle text-center text-nowrap">معمولی</td>
                                                @elseif ($rec->Priority === '1')
                                                    <td class="align-middle text-center text-nowrap {{ ($rec->Status == 2) ? '' : 'g-color-orange' }}">
                                                        مهم
                                                    </td>
                                                @elseif ($rec->Priority === '0')
                                                    <td class="align-middle text-center text-nowrap {{ ($rec->Status == 2) ? '' : 'g-color-red' }}">
                                                        فوری
                                                    </td>
                                                @endif
                                                <td class="align-middle text-center text-nowrap">
                                                    {{ $supportPersianDate[$key][0].'/'.$supportPersianDate[$key][1].'/'.$supportPersianDate[$key][2] }}
                                                    <p class="g-font-size-13 g-color-primary m-0 p-0">{{ $rec->Time }}</p>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    <a style="cursor: pointer"
                                                       href="{{ route('adminCustomerConnectionDetail',['id'=>$rec->ID, 'status'=>$rec->Status])}}"
                                                       class="g-color-gray-light-v3 g-text-underline--none--hover g-color-primary--hover g-pa-5"
                                                       data-toggle="tooltip"
                                                       data-placement="top" data-original-title="مشاهده جزئیات گفتگو">
                                                        <i class="fa fa-eye g-font-size-18"></i>
                                                    </a>
                                                </td>
                                                @if ($rec->Status === '0')
                                                    <td class="align-middle text-center text-nowrap"><i
                                                            class="fa fa-check g-ml-5"></i>پاسخ داده شد
                                                    </td>
                                                @elseif ($rec->Status === '1')
                                                    <td class="align-middle text-center text-nowrap g-color-lightred"><i
                                                            class="fa fa-spinner fa-spin g-ml-5"></i>در انتضار پاسخ
                                                    </td>
                                                @elseif ($rec->Status === '2')
                                                    <td class="align-middle text-center text-nowrap">خوانده شده
                                                    </td>
                                                @elseif ($rec->Status === '3')
                                                    <td class="align-middle text-center text-nowrap">بدون پیام
                                                    </td>
                                                @endif
                                            </tr>

                                            {{--                                GroupBy Variable Hidden input--}}
                                            <input style="display: none" value=" {{ $groupBy = $rec->ConversationID }}">
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        {{-- End Table --}}
                    </div>

                    {{-- Table --}}
                    <div class="g-pb-15">
                        <h4 class="text-right g-my-30 g-color-white">پیام های سیستمی</h4>
                        @if ($alarmMsg->count()!==0)
                            <h6 style="direction: rtl"
                                class="card-header g-bg-orange-opacity-0_1 g-brd-around g-brd-gray-light-v4 g-color-gray-dark rounded-0 g-mb-5 text-right tableHint">
                                <i class="fa fa-hand-o-right g-font-size-18"></i>
                                <span class="g-font-size-13">جدول را به سمت راست بکشید.</span>
                            </h6>
                        @endif

                        @if ($alarmMsg->count()===0)
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
                                        <th class="align-middle text-center text-nowrap focused rtlPosition">عنوان
                                            گفتگو
                                        </th>
                                        <th class="align-middle text-center text-nowrap">بخش مربوطه</th>
                                        <th class="align-middle text-center text-nowrap">اولویت</th>
                                        <th class="align-middle text-center text-nowrap">زمان پیام</th>
                                        <th class="align-middle text-center text-nowrap">جزئیات</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    {{--                                GroupBy Variable Hidden input--}}
                                    {{--                        groupBy for grouping msg with one title--}}
                                    <input style="display: none" value=" {{ $groupBy = '' }}">

                                    @foreach($alarmMsg as $key => $rec)
                                        <tr>
                                            <td class="align-middle text-nowrap text-center g-font-weight-600 g-color-aqua">{{ $rec->Title }}</td>
                                            {{--                                Section--}}
                                            @if ($rec->Section === '0')
                                                <td class="align-middle text-center text-nowrap">فنی</td>
                                            @elseif ($rec->Section === '1')
                                                <td class="align-middle text-center text-nowrap">تحویل کالا</td>
                                            @elseif ($rec->Section === '2')
                                                <td class="align-middle text-center text-nowrap">مالی</td>
                                            @elseif ($rec->Section === '3')
                                                <td class="align-middle text-center text-nowrap">مدیریت</td>
                                            @endif

                                            {{--                                Priority--}}
                                            @if ($rec->Priority === '2')
                                                <td class="align-middle text-center text-nowrap">معمولی</td>
                                            @elseif ($rec->Priority === '1')
                                                <td class="align-middle text-center text-nowrap">
                                                    مهم
                                                </td>
                                            @elseif ($rec->Priority === '0')
                                                <td class="align-middle text-center text-nowrap">
                                                    فوری
                                                </td>
                                            @endif
                                            <td class="align-middle text-center text-nowrap">
                                                <p style="direction: ltr" class="g-font-size-13 g-color-primary m-0 p-0">{{ $rec->Time }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="g-font-size-13 g-color-white m-0 p-0">{{ $rec->Message }}</p>
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
                    {{--        {{ $data->links('General.Pagination', ['result' => $data]) }}--}}
                </div>
            </div>
            <!--اعمال محدودیت -->
            <div style="min-height: 100vh" class="tab-pane fade" id="nav-4-1-primary-hor-fill--9" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-9 g-mt-30">
                        <div style="direction: rtl" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="h5">
                                <i class="fa fa-minus-circle"></i>
                                محدود سازی حساب کاربری
                            </h4>
                            <p class="g-mb-10">جهت اعمال محدودیت و عدم دسترسی فروشندگان ساده به حساب کاربری خود لطفا از کلید اعمال محدودیت و در صورت رفع محدودیت از کلید مربوطه استفاده نمایید و همچنین جهت اخطار به فروشنده ساده از کلید اخطار استفاده کنید.</p>
                            <a id="blockOn" href="#!" onclick="accountBlockCustomer({{$customerInfo->id}},'on')" class="{{$customerInfo->status==1?'':'d-none'}} btn u-btn-outline-lightred btn-xs g-brd-2 rounded-0">
                                <i class="fa fa-minus-circle g-mr-2"></i>
                                اعمال محدودیت
                            </a>
                            <a id="blockOff" href="#!" onclick="accountBlockCustomer({{$customerInfo->id}},'off')" class="{{$customerInfo->status==0?'':'d-none'}} btn u-btn-outline-bluegray btn-xs g-brd-2 rounded-0">
                                <i class="fa fa-check-circle g-mr-2"></i>
                                رفع محدودیت
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--اطلاعات کاربری-->
            <div class="tab-pane fade show active" id="nav-4-1-primary-hor-fill--8" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <form action="{{route('updateCustomer')}}"
                              method="POST"
                              style="direction: rtl"
                              id="sellerForm"
                              disabled=""
                              enctype="multipart/form-data">
                            @csrf
                            <fieldset id="userData" disabled="disabled">
                                <div class="container g-py-30--lg g-px-60--lg">
                                    <input type="hidden" name="id" value="{{$customerInfo->id}}">
                                    {{--نام--}}
                                    <div class="form-group row g-mb-15">
                                        <label
                                            class="col-sm-3 col-form-label align-self-center text-right">نام</label>
                                        <div class="col-sm-9 force-col-12">
                                            <input id="user-name"
                                                   class="form-control form-control-md rounded-0 g-bg-gray-dark-v2 g-color-gray-light-v4 g-font-size-16"
                                                   type="text"
                                                   value="{{$customerInfo->name}}"
                                                   name="name"
                                                   autofocus
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
                                            >
                                        </div>
                                    </div>

                                    {{--نام خانوادگی--}}
                                    <div class="form-group row g-mb-15">
                                        <label class="col-sm-3 col-form-label align-self-center text-right">نام
                                            خانوادگی</label>
                                        <div class="col-sm-9 force-col-12">
                                            <input
                                                class="form-control form-control-md rounded-0 g-bg-gray-dark-v2 g-color-gray-light-v4 g-font-size-16"
                                                id="user-family"
                                                name="family"
                                                maxlength="15"
                                                type="text"
                                                value="{{$customerInfo->Family}}"
                                                placeholder="الزاما فارسی"
                                                {{--                                           lang="fa"--}}
                                                onkeyup="if (!(/^[\u0600-\u06FF\s]+$/.test($(this).val()))) {
                                                        str = $(this).val();
                                                        str = str.substring(0, str.length - 1);
                                                        $(this).val(str);
                                                        $(this).attr('autocomplete', 'off');
                                                    } else
                                                        $(this).attr('autocomplete', 'name');"
                                            >
                                        </div>
                                    </div>

                                    {{--ایمیل--}}
                                    <div class="form-group row g-mb-15">
                                        <label
                                            class="col-sm-3 col-form-label align-self-center text-right">ایمیل</label>
                                        <div class="col-sm-9 force-col-12">
                                            <input style="direction: ltr"
                                                   class="form-control form-control-md rounded-0 g-bg-gray-dark-v2 g-color-gray-light-v4 g-font-size-16"
                                                   id="email"
                                                   name="email"
                                                   type="email"
                                                   value="{{$customerInfo->email}}"
                                                   placeholder="مثال: najatAndimeh@gmail.com"
                                            >
                                        </div>
                                    </div>

                                    {{--کد ملی--}}
                                    <div class="form-group row g-mb-15">
                                        <label class="col-sm-3 col-form-label align-self-center text-right">کد
                                            ملی</label>
                                        <div dir="ltr" class="col-sm-9 force-col-12">
                                            <input
                                                class="form-control form-control-md rounded-0 g-bg-gray-dark-v2 g-color-gray-light-v4 g-font-size-16"
                                                id="nationalId"
                                                name="nationalId"
                                                value="{{$customerInfo->NationalID}}"
                                                maxlength="10"
                                                placeholder="فقط اعداد"
                                            >
                                        </div>
                                    </div>

                                    {{--تاریخ تولد--}}
                                    <div class="customDisable form-group row g-mb-15">
                                        <label class="col-sm-3 col-form-label align-self-center text-right">تاریخ
                                            تولد</label>
                                        <div class="col-sm-9 force-col-12">
                                            <div class="d-flex">
                                                <select style="direction: ltr"
                                                        class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                        id="birthday-day"
                                                        name="day"
                                                        tabindex="3">
                                                    <option
                                                        value="{{$customerInfo->BirthdayD}}">{{$customerInfo->BirthdayD}}</option>
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
                                                        class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                        name="mon"
                                                        tabindex="4">
                                                    <option
                                                        value="{{$customerInfo->BirthdayM}}">{{$customerInfo->BirthdayM}}</option>
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
                                                        class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                        name="year"
                                                        tabindex="5">
                                                    <option
                                                        value="{{$customerInfo->BirthdayY}}">{{$customerInfo->BirthdayY}}</option>
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
                                    <div class="customDisable form-group row g-mb-15">
                                        <label
                                            class="col-sm-3 col-form-label align-self-center text-right">جنسیت</label>
                                        <div class="col-sm-9 force-col-12">
                                            <div class="btn-group-lg d-flex">
                                                <label class="u-check col-md-4 g-pa-0">
                                                    <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0"
                                                           name="gender"
                                                           type="radio"
                                                           {{($customerInfo->Gender===0 ? 'checked':'')}}
                                                           value="0">
                                                    <span style="color: #555"
                                                          class="btn btn-md btn-block g-brd-white g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none g-brd-left-1--lg g-bg-primary--checked rounded-0 g-color-white--checked">زن</span>
                                                </label>
                                                <label class="u-check col-md-4 g-pa-0">
                                                    <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0"
                                                           name="gender"
                                                           type="radio"
                                                           {{($customerInfo->Gender===1 ? 'checked':'')}}
                                                           value="1">
                                                    <span style="color: #555"
                                                          class="btn btn-md btn-block g-brd-white g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none g-brd-left-1--lg g-bg-primary--checked rounded-0 g-color-white--checked">مرد</span>
                                                </label>
                                                <label class="u-check col-md-4 g-pa-0">
                                                    <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0"
                                                           name="gender"
                                                           type="radio"
                                                           {{($customerInfo->Gender===2 ? 'checked':'')}}
                                                           value="1">
                                                    <span style="color: #555"
                                                          class="btn btn-md btn-block g-brd-white g-bg-gray-dark-v2 g-color-gray-light-v4 g-bg-primary--checked rounded-0 g-color-white--checked">کودک</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{--تلفن ثابت--}}
                                    <div class="form-group row g-mb-15">
                                        <label class="col-sm-3 col-form-label align-self-center text-right">تلفن
                                            ثابت</label>
                                        <div class="col-sm-9 force-col-12 d-flex">
                                            <input
                                                style="direction: ltr"
                                                class="text-left col-8 form-control form-control-md rounded-0 g-bg-gray-dark-v2 g-color-gray-light-v4 g-font-size-16"
                                                id="phoneNumber"
                                                name="phone"
                                                type="text"
                                                maxlength="8"
                                                value="{{$customerInfo->Phone}}"
                                                placeholder="xxxxxxxx"
                                            >
                                            <input
                                                style="direction: ltr"
                                                id="phonePreNumber"
                                                name="prePhone"
                                                class="text-left col-4 form-control form-control-md rounded-0 g-bg-gray-dark-v2 g-color-gray-light-v4 g-font-size-16 g-brd-right-none"
                                                maxlength="3"
                                                value="{{$customerInfo->PrePhone}}"
                                                oninput="if($(this).val().length === 3) $('#phoneNumber').focus();"
                                                placeholder="0xx"
                                            >
                                        </div>
                                    </div>

                                    {{--موبایل--}}
                                    <div class="form-group row g-mb-15">
                                        <label
                                            class="col-sm-3 col-form-label align-self-center text-right">تلفن
                                            همراه</label>
                                        <div class="col-sm-9 force-col-12">
                                            <input style="direction: ltr"
                                                   class="text-left form-control form-control-md rounded-0 g-bg-gray-dark-v2 g-color-gray-light-v4 g-font-size-16"
                                                   id="mobile"
                                                   name="mobile"
                                                   maxlength="11"
                                                   value="{{$customerInfo->Mobile}}"
                                                   placeholder="09xxxxxxxx"
                                            >
                                        </div>
                                    </div>

                                    {{--استان/شهر--}}
                                    <div class="customDisable form-group row g-mb-15">
                                        <label
                                            class="col-sm-3 col-form-label align-self-center text-right">استان/شهر
                                            سکونت</label>
                                        <div class="col-sm-9 force-col-12">
                                            <div class="d-lg-flex">
                                                <!--ورودی زیر فقط برای دریافت استان جاوااسکریپت استفاده می شود-->
                                                <input id="state" class="d-none" value="{{$customerInfo->State}}">
                                                <select id="stateSelect"
                                                        style="direction: rtl; padding-right: 30px !important"
                                                        class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-brd-left-none--lg g-bg-gray-dark-v3 g-color-gray-light-v4 g-mb-10 g-mb-0--lg"
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
                                                <input id="city" class="d-none" value="{{$customerInfo->City}}">
                                                <select id="citySelect"
                                                        style="direction: rtl; padding-right: 30px !important"
                                                        class="form-control form-control-md custom-select rounded-0 h-25 g-font-size-16 g-bg-gray-dark-v3 g-color-gray-light-v4"
                                                        name="city"
                                                        tabindex="4">
                                                    <option value="">شهر</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{--تصویر چهره--}}
                                    <div class="form-group row justify-content-center">
                                        <label class="col-sm-3 col-form-label align-self-center text-right">تصویر
                                            پروفایل</label>
                                        <div dir="ltr" class="d-flex col-sm-9 force-col-12">
                                            <div class="col-md-4 p-0 g-mr-15">
                                                <a class="js-fancybox" href="{{asset($customerInfo->PicPath)}}"
                                                   data-fancybox-animate-in="zoomIn" data-fancybox-animate-out="zoomOut"
                                                   data-fancybox-speed="200" data-fancybox-blur-bg="blur"
                                                   data-fancybox-bg="rgba(0,0,0, 1)">
                                                    <img class="img-fluid" src="{{asset($customerInfo->PicPath)}}"
                                                         alt="Image Description">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="d-none" type="text" name="userImage"
                                           value="{{$customerInfo->PicPath}}">
                                </div>
                            </fieldset>
                        </form>
                        <div style="direction: ltr" class="g-mx-60--lg g-mt-60--lg g-mb-30--lg g-my-30 g-mx-15">
                            <button id="edit" type="button"
                                    class="btn btn-md u-btn-outline-primary g-bg-white g-bg-primary--hover rounded-0 force-col-12 g-mb-15"
                                    onclick="editUserData()">
                                ویرایش اطلاعات کاربری
                            </button>
                            <button id="save" style="display: none" type="button"
                                    class="btn btn-md u-btn-primary rounded-0 force-col-12 g-mb-15"
                                    onclick="saveUserData()">
                                ثبت اطلاعات
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tab panes -->
        </div>

@endsection
