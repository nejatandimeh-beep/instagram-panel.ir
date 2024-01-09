@extends('Layouts.IndexAdmin')
@section('Content')
    @switch($tab)
        @case('user')
        <span id="user" class="d-none">1</span>
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
                        <p style="direction: rtl">اطلاعات کاربری فروشنده ساده به روز رسانی شد.</p>
                    </div>
                </div>
            </div>
        </div>
        @break

        @case('delete')
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
                        <p style="direction: rtl">محصول مورد نظر حذف گردید.</p>
                    </div>
                </div>
            </div>
        </div>
        <span id="store" class="d-none">1</span>
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
        <ul class="nav nav-fill u-nav-v4-1 u-nav-light adminPanelResponsive" role="tablist"
            data-target="nav-4-1-primary-hor-fill"
            data-tabs-mobile-type="slide-up-down" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-white">
            <li class="nav-item">
                <a class="nav-link" href="{{route('sellerMajorList')}}">مدیریت صفحه ها</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('adminSellerMajorPanel',$sellerMajorInfo->id)}}">محتویات پنل</a>
            </li>

            <li class="nav-item">
                <a id="sellerBlock" class="nav-link" data-toggle="tab" href="#nav-4-1-primary-hor-fill--3"
                   role="tab">اعمال محدودیت</a>
            </li>

            <!--پشتیبانی-->
            <li class="nav-item">
                <a id="sellerSupport" class="nav-link" data-toggle="tab" href="#nav-4-1-primary-hor-fill--1" role="tab">
                    <div style="width: 20px; height: 20px"
                         class="{{$newSupport===0 ? 'd-none ': 'd-inline-block '}}text-center g-color-black g-bg-lightred g-rounded-50x g-mr-10">
                        {{$newSupport}}
                    </div>
                    پشتیبانی
                </a>
            </li>

            <!--اطلاعات کاربری-->
            <li class="nav-item">
                <a id="sellerInfo" class="nav-link active" data-toggle="tab" href="#nav-4-1-primary-hor-fill--2"
                   role="tab">اطلاعات
                    کاربری</a>
            </li>
        </ul>
        <!-- End Nav tabs -->

        <!-- Tab panes -->
        <div id="nav-4-1-primary-hor-fill" class="tab-content g-pt-40">
            <!-- پشتیبانی -->
            <div class="tab-pane g-bg-gray-dark-v2" id="nav-4-1-primary-hor-fill--1" role="tabpanel">
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
                                    <form action="{{ route('adminToSellerMajorMsg')}}" method="post"
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
                                        <input class="d-none" type="text" value="{{$sellerMajorInfo->id}}" name="userID">
                                        <input class="d-none" type="text" value="{{$sellerMajorInfo->Mobile}}" name="mobile">
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
                                                       href="{{ route('adminSellerMajorConnectionDetail',['id'=>$rec->ID, 'status'=>$rec->Status])}}"
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
            <!--اطلاعات کاربری -->
            <div class="tab-pane fade show active" id="nav-4-1-primary-hor-fill--2" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <form action="{{route('updateSellerMajor')}}"
                              method="POST"
                              style="direction: rtl"
                              id="sellerForm"
                              disabled=""
                              enctype="multipart/form-data">
                            @csrf
                            <fieldset id="userData" disabled="disabled">
                                <div class="container g-py-30--lg g-px-60--lg">
                                    {{--id--}}
                                    <input type="hidden" name="id" value="{{$sellerMajorInfo->id}}">
                                    {{--نام--}}
                                    <div class="form-group row g-mb-15">
                                        <label
                                            class="col-sm-3 col-form-label align-self-center text-right">نام</label>
                                        <div class="col-sm-9 force-col-12">
                                            <input id="user-name"
                                                   class="form-control form-control-md rounded-0 g-bg-gray-dark-v2 g-color-gray-light-v4 g-font-size-16"
                                                   type="text"
                                                   value="{{$sellerMajorInfo->name}}"
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
                                                   value="{{$sellerMajorInfo->email}}"
                                                   placeholder="مثال: najatAndimeh@gmail.com"
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
                                                   value="{{$sellerMajorInfo->Mobile}}"
                                                   placeholder="09xxxxxxxx">
                                        </div>
                                    </div>

                                    {{--دسته شغلی--}}
                                    <div class="customDisable form-group row g-mb-15">
                                        <label class="col-sm-3 col-form-label align-self-center text-right">دسته
                                            شغلی</label>
                                        <div class="col-sm-9 force-col-12">
                                            <div id="accordion-04" class="u-accordion" role="tablist"
                                                 aria-multiselectable="true">
                                                <!-- Card -->
                                                <div class="card rounded-0 g-mb-5">
                                                    <div id="accordion-04-heading-01"
                                                         class="u-accordion__header g-bg-gray-dark-v2 g-brd-bottom g-brd-gray-light-v4 "
                                                         role="tab">
                                                        <h5 class="mb-0 g-font-weight-300">
                                                            <a class="u-link-v5 g-color-white g-font-size-16 d-block text-right"
                                                               href="#accordion-04-body-01" data-toggle="collapse"
                                                               data-parent="#accordion-04" aria-expanded="true"
                                                               aria-controls="accordion-04-body-01" id="selectedItem">
                                                                {{$sellerMajorInfo->HintCategory}}
                                                            </a>
                                                            <input style="display: none" id="hintCategory"
                                                                   name="hintCategory" value="{{$sellerMajorInfo->HintCategory}}">
                                                            <input style="display: none" id="category" name="category"
                                                                   value="{{$sellerMajorInfo->Category}}">
                                                        </h5>
                                                    </div>
                                                    <div id="accordion-04-body-01" class="collapse g-py-10 g-px-5"
                                                         role="tabpanel"
                                                         aria-labelledby="accordion-04-heading-01"
                                                         data-parent="#accordion-04">
                                                        <div style="height: 230px !important;"
                                                             class="u-accordion__body g-color-gray-dark-v5 customScrollBar">
                                                            <div class="text-right">
                                                                <strong>پوشاک</strong>
                                                                <ul class="g-pt-15">
                                                                    <li>
                                                                        <span style="cursor: pointer"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this).text(),'clothes')">زنانه</span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="cursor: pointer"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this).text(),'clothes')">مردانه</span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="cursor: pointer"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this).text(),'clothes')">دخترانه</span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="cursor: pointer"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this).text(),'clothes')">پسرانه</span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="cursor: pointer"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this).text(),'clothes')">نوزادی</span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="cursor: pointer"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this).text(),'clothes')">مخلوط</span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="cursor: pointer"
                                                                              class="g-font-weight-500 g-color-primary--hover"
                                                                              onclick="categorySelect($(this).text(),'clothes')">همه</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            {{--                                                            <div class="text-right">--}}
                                                            {{--                                                                <strong>وسایل نقلیه</strong>--}}
                                                            {{--                                                                <ul class="g-pt-15">--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">خودرو</span>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">موتور--}}
                                                            {{--                                                                            سیکلت</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">خودرو--}}
                                                            {{--                                                                            کلاسیک</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">سنگین--}}
                                                            {{--                                                                            و نیمه سنگین</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">کشاورزی--}}
                                                            {{--                                                                            و عمرانی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">لوازم--}}
                                                            {{--                                                                            و قطعات وسایل نقلیه</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">سایر--}}
                                                            {{--                                                                            وسایل نقلیه</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">اجاره--}}
                                                            {{--                                                                            خودرو</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">اجاره--}}
                                                            {{--                                                                            کشاورزی و عمرانی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">قایق--}}
                                                            {{--                                                                            و تفریحات آبی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'vehicles')">سایر وسایل نقلیه</span></li>--}}
                                                            {{--                                                                </ul>--}}
                                                            {{--                                                            </div>--}}
                                                            {{--                                                            <div class="text-right">--}}
                                                            {{--                                                                <strong>وسایل ورزشی</strong>--}}
                                                            {{--                                                                <ul class="g-pt-15">--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'sports')">دوچرخه</span>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'sports')">تور--}}
                                                            {{--                                                                            مسافرتی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'sports')">کتاب--}}
                                                            {{--                                                                            و لوازم تحریر</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'sports')">سرگرمی--}}
                                                            {{--                                                                            و اسباب بازی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'sports')">حیوانات--}}
                                                            {{--                                                                            و لوازم</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'sports')">انواع--}}
                                                            {{--                                                                            ساز و آلات موسیقی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'sports')">هنر--}}
                                                            {{--                                                                            و صنایع دستی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'sports')">کلکسیونی</span>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'sports')">--}}
                                                            {{--                                                                            سرگرمی ها</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'')">--}}
                                                            {{--                                                                            سایر وسایل ورزشی</span></li>--}}
                                                            {{--                                                                </ul>--}}
                                                            {{--                                                            </div>--}}
                                                            {{--                                                            <div class="text-right">--}}
                                                            {{--                                                                <strong>املاک</strong>--}}
                                                            {{--                                                                <ul class="g-pt-15">--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'estate')">رهن--}}
                                                            {{--                                                                            و اجاره خانه و آپارتمان</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'estate')">خرید--}}
                                                            {{--                                                                            و فروش خانه و آپارتمان</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'estate')">اجاره--}}
                                                            {{--                                                                            کوتاه مدت ویلا، سوئیت</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'estate')">رهن--}}
                                                            {{--                                                                            و اجاره اداری، تجاری و صنعتی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'estate')">خرید--}}
                                                            {{--                                                                            و فروش اداری، تجاری و صنعتی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'estate')">زمین--}}
                                                            {{--                                                                            و باغ</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'estate')">سایر--}}
                                                            {{--                                                                            املاک</span></li>--}}
                                                            {{--                                                                </ul>--}}
                                                            {{--                                                            </div>--}}
                                                            {{--                                                            <div class="text-right">--}}
                                                            {{--                                                                <strong>لوازم الکترونیکی</strong>--}}
                                                            {{--                                                                <ul class="g-pt-15">--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'electronic')">لپ--}}
                                                            {{--                                                                            تاپ و کامپیوتر</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'electronic')">صوتی--}}
                                                            {{--                                                                            و تصویری</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'electronic')">دوربین--}}
                                                            {{--                                                                            عکاسی و فیلمبرداری و لوازم</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'electronic')">کنسول--}}
                                                            {{--                                                                            بازی و لوازم</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'electronic')">بازی--}}
                                                            {{--                                                                            های اینترنتی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'electronic')">سایر--}}
                                                            {{--                                                                            لوازم الکترونیکی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'electronic')">لوازم--}}
                                                            {{--                                                                            کامپیوتر و پرینتر</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'electronic')">سایر وسایل الکتریکی</span></li>--}}
                                                            {{--                                                                </ul>--}}
                                                            {{--                                                            </div>--}}
                                                            {{--                                                            <div class="text-right">--}}
                                                            {{--                                                                <strong>صنعتی، اداری و تجاری</strong>--}}
                                                            {{--                                                                <ul class="g-pt-15">--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'industrial')">ماشین--}}
                                                            {{--                                                                            الات و تجهیزات صنعتی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'industrial')">ابزار--}}
                                                            {{--                                                                            و یراق آلات</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'industrial')">لوازم--}}
                                                            {{--                                                                            اداری</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'industrial')">تجهیزات--}}
                                                            {{--                                                                            پزشکی و آزمایشگاهی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'industrial')">تجهیزات--}}
                                                            {{--                                                                            و لوازم کافه و رستوران</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'industrial')">تجهیزات--}}
                                                            {{--                                                                            تجاری و فروشگاه</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'industrial')">تجهیزات--}}
                                                            {{--                                                                            عمرانی و ساختمانی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'industrial')">تجهیزات--}}
                                                            {{--                                                                            کشاورزی و دامداری</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'industrial')">اجاره--}}
                                                            {{--                                                                            تجهیزات صنعتی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'')">سایر وسایل صنعتی</span>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'')">سایر وسایل اداری</span>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'')">سایر وسایل تجاری</span>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                </ul>--}}
                                                            {{--                                                            </div>--}}
                                                            {{--                                                            <div class="text-right">--}}
                                                            {{--                                                                <strong>خدمات و کسب و کار</strong>--}}
                                                            {{--                                                                <ul class="g-pt-15">--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">آرایشگری--}}
                                                            {{--                                                                            و زیبایی</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">آموزش</span>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">اجاره--}}
                                                            {{--                                                                            لوازم</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">اسباب--}}
                                                            {{--                                                                            کشی و حمل و نقل</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">اینترنت--}}
                                                            {{--                                                                            ، رایانه و موبایل</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">باغبانی--}}
                                                            {{--                                                                            و فضای سبز</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">پزشکی--}}
                                                            {{--                                                                            و درمانی</span></li>--}}
                                                            {{--                                                                    <li class=""><a--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">ترجمه--}}
                                                            {{--                                                                            و تایپ</a></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">تعمیرات</span>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">خرید--}}
                                                            {{--                                                                            و فروش عمده</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">خودرو--}}
                                                            {{--                                                                            و موتورسیکلت</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">رویدادهای--}}
                                                            {{--                                                                            اجتماعی</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">ساختمان--}}
                                                            {{--                                                                            و دکوراسیون داخلی</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">گرافیک،--}}
                                                            {{--                                                                            تبلیغات و چاپ</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">مالی،--}}
                                                            {{--                                                                            حقوقی و بیمه</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">مراسم--}}
                                                            {{--                                                                            و کترینگ</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">معرفی--}}
                                                            {{--                                                                            و تبلیغات کسب و کار</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">مواد--}}
                                                            {{--                                                                            غذایی</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">نظافت--}}
                                                            {{--                                                                            و خدمات منزل</span></li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'services')">هنری</span>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                    <li class=""><span--}}
                                                            {{--                                                                            style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'')">سایر--}}
                                                            {{--                                                                            خدمات و کسب و کار</span></li>--}}
                                                            {{--                                                                </ul>--}}
                                                            {{--                                                            </div>--}}
                                                            {{--                                                            <div class="text-right">--}}
                                                            {{--                                                                <strong>وسایل ارتباطی</strong>--}}
                                                            {{--                                                                <ul class="g-pt-15">--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'connections')">موبایل--}}
                                                            {{--                                                                            و تبلت</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'connections')">لوازم--}}
                                                            {{--                                                                            موبایل</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'connections')">--}}
                                                            {{--                                                                            آیفون و تلفن</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'')">--}}
                                                            {{--                                                                            سایر وسایل ارتباطی</span></li>--}}
                                                            {{--                                                                </ul>--}}
                                                            {{--                                                            </div>--}}
                                                            {{--                                                            <div class="text-right">--}}
                                                            {{--                                                                <strong>لوازم خانگی</strong>--}}
                                                            {{--                                                                <ul class="g-pt-15">--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'appliances')">مبلمان--}}
                                                            {{--                                                                            و لوازم چوبی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'appliances')">وسایل--}}
                                                            {{--                                                                            برقی خانه و آشپزخانه</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'appliances')">ظروف--}}
                                                            {{--                                                                            و لوازم آشپزخانه</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'appliances')">دکوراسیون--}}
                                                            {{--                                                                            داخلی و روشنایی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'appliances')">فرش،--}}
                                                            {{--                                                                            گلیم و قالیچه</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'appliances')">آنتیک</span>--}}
                                                            {{--                                                                    </li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'appliances')">سایر--}}
                                                            {{--                                                                            لوازم خانه و حیاط</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'appliances')">لوازم--}}
                                                            {{--                                                                            سرمایش و گرمایش</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'')">سایر لوازم خانگی</span></li>--}}
                                                            {{--                                                                </ul>--}}
                                                            {{--                                                            </div>--}}
                                                            {{--                                                            <div class="text-right">--}}
                                                            {{--                                                                <strong>لوازم شخصی</strong>--}}
                                                            {{--                                                                <ul class="g-pt-15">--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'personal')">لوازم آرایشی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'personal')">لوازم بهداشتی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'personal')">لوازم پزشکی</span></li>--}}
                                                            {{--                                                                    <li>--}}
                                                            {{--                                                                        <span style="cursor: pointer" class="g-font-weight-500 g-color-primary--hover" onclick="categorySelect($(this).text(),'')">سایر لوازم شخصی</span></li>--}}
                                                            {{--                                                                </ul>--}}
                                                            {{--                                                            </div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Card -->
                                            </div>
                                        </div>
                                    </div>

                                    {{--اینستاگرام--}}
                                    <div id="instaContainer" class="form-group row g-mb-15">
                                        <label
                                            class="col-sm-3 col-form-label align-self-center text-right">نام
                                            کاربری اینستاگرام</label>
                                        <div class="col-sm-9 force-col-12">
                                            <div class="input-group g-brd-primary--focus">
                                                <input style="direction: ltr"
                                                       class="form-control form-control-md rounded-0 g-color-white g-bg-gray-dark-v2 g-font-size-16 text-left"
                                                       type="text"
                                                       value="{{$sellerMajorInfo->Instagram}}"
                                                       autofocus
                                                       spellcheck="false"
                                                       tabindex="1"
                                                       id="instaAccount"
                                                       name="instaAccount"
                                                       maxlength="50">
                                                <div
                                                    class="input-group-addon g-brd-around g-brd-gray-light-v2 g-brd-right-none d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                                                    <i class="fa fa-instagram g-font-size-18"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--تلگرام--}}
                                    <div id="instaContainer" class="form-group row g-mb-15">
                                        <label
                                            class="col-sm-3 col-form-label align-self-center text-right">نام
                                            کاربری تلگرام</label>
                                        <div class="col-sm-9 force-col-12">
                                            <div class="input-group g-brd-primary--focus">
                                                <input style="direction: ltr"
                                                       class="form-control form-control-md rounded-0 g-color-white g-bg-gray-dark-v2 g-font-size-16 text-left"
                                                       type="text"
                                                       value="{{$sellerMajorInfo->Telegram}}"
                                                       autofocus
                                                       spellcheck="false"
                                                       tabindex="1"
                                                       id="telegramAccount"
                                                       name="telegramAccount"
                                                       maxlength="50">
                                                <div
                                                    class="input-group-addon g-brd-around g-brd-gray-light-v2 g-brd-right-none d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                                                    <i class="fa fa-telegram g-font-size-18"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--بایوگرافی--}}
                                    <div class="form-group row g-mb-15">
                                        <label
                                            class="col-sm-3 col-form-label align-self-center text-right">بایوگرافی</label>
                                        <div class="col-sm-9 force-col-12">
                                            <div class="input-group g-brd-primary--focus">
                                            <textarea id="bioText"
                                                      onfocus="if($('#edited').text()==='0'){$('#bioTextCopy').val($(this).val()); $('#edited').text('1')}"
                                                      class="form-control form-control-md g-resize-none g-font-size-16 g-brd-1 rounded-0 g-color-white g-bg-transparent"
                                                      maxlength="300"  name="bio" rows="4" placeholder="بایوگرافی..">{{$sellerMajorInfo->Bio}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{--آدرس--}}
                                    <div class="form-group row g-mb-25">
                                        <label
                                            class="col-sm-3 col-form-label align-self-center text-right">آدرس</label>
                                        <div class="col-sm-9 force-col-12">
                                            <div class="input-group justify-content-center">
                                                   <textarea style="direction: rtl" id="address" name="address"
                                                             autofocus
                                                             class="form-control form-control-md g-resize-none g-brd-1 g-color-white rounded-0 pl-0 g-bg-transparent"
                                                             maxlength="300" rows="4"
                                                             placeholder="آدرس جدید..">{{$sellerMajorInfo->Address}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{--تصویر پروفایل--}}
                                    <div class="form-group row justify-content-center">
                                        <label class="col-sm-3 col-form-label align-self-center text-right">تصویر
                                            پروفایل</label>
                                        <div dir="ltr" class="d-flex col-sm-9 force-col-12">
                                            <div class="col-md-4 p-0 g-mr-15">
                                                <a class="js-fancybox"
                                                   href="{{asset($sellerMajorInfo->Pic.'/profileImg.jpg')}}"
                                                   data-fancybox-animate-in="zoomIn" data-fancybox-animate-out="zoomOut"
                                                   data-fancybox-speed="200" data-fancybox-blur-bg="blur"
                                                   data-fancybox-bg="rgba(0,0,0, 1)">
                                                    <img class="img-fluid"
                                                         src="{{asset($sellerMajorInfo->Pic.'/profileImg.jpg')}}"
                                                         alt="Image Description">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="d-none" type="text" name="userImage"
                                           value="{{$sellerMajorInfo->Pic.'/profileImg.jpg'}}">
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
            <!--اعمال محدودیت -->
            <div style="min-height: 100vh" class="tab-pane fade" id="nav-4-1-primary-hor-fill--3" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-9 g-mt-30">
                        <div style="direction: rtl" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="h5">
                                <i class="fa fa-minus-circle"></i>
                                شرکت در کمپین تبلیغاتی
                            </h4>
                            <p class="g-mb-10">جهت اعمال محدودیت و عدم دسترسی فروشندگان ساده به حساب کاربری خود لطفا از کلید اعمال محدودیت و در صورت رفع محدودیت از کلید مربوطه استفاده نمایید و همچنین جهت اخطار به فروشنده ساده از کلید اخطار استفاده کنید.</p>
                            <a id="limitWarning" href="#!" onclick="AdLimit({{$sellerMajorInfo->id}},'danger')" class="{{$sellerMajorInfo->AdBlock === '0' ?'':'d-none'}} btn u-btn-outline-orange btn-xs g-brd-2 rounded-0">
                                <i class="fa fa-info-circle g-mr-2"></i>
                                {{$sellerMajorInfo->AdWarning ==0 ?'اخطار':'اخطار شماره '.($sellerMajorInfo->AdWarning+1)}}
                            </a>
                            <a id="limitOn" href="#!" onclick="AdLimit({{$sellerMajorInfo->id}},'on')" class="{{$sellerMajorInfo->AdBlock === '0' ?'':'d-none'}} btn u-btn-outline-lightred btn-xs g-brd-2 rounded-0">
                                <i class="fa fa-minus-circle g-mr-2"></i>
                                اعمال محدودیت
                            </a>
                            <a id="limitOff" href="#!" onclick="AdLimit({{$sellerMajorInfo->id}},'off')" class="{{$sellerMajorInfo->AdBlock === '1' ?'':'d-none'}} btn u-btn-outline-bluegray btn-xs g-brd-2 rounded-0">
                                <i class="fa fa-check-circle g-mr-2"></i>
                                رفع محدودیت
                            </a>
                        </div>
                        <div style="direction: rtl" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="h5">
                                <i class="fa fa-minus-circle"></i>
                                محدود سازی حساب کاربری
                            </h4>
                            <p class="g-mb-10">جهت اعمال محدودیت و عدم دسترسی فروشندگان ساده به کمپین تبلیغاتی لطفا از کلید اعمال محدودیت و در صورت رفع محدودیت از کلید مربوطه استفاده نمایید.</p>
                            <a id="blockOn" href="#!" onclick="accountBlock({{$sellerMajorInfo->id}},'on','sellerMajor')" class="{{$sellerMajorInfo->status == 1 ?'':'d-none'}} btn u-btn-outline-lightred btn-xs g-brd-2 rounded-0">
                                <i class="fa fa-minus-circle g-mr-2"></i>
                                اعمال محدودیت
                            </a>
                            <a id="blockOff" href="#!" onclick="accountBlock({{$sellerMajorInfo->id}},'off','sellerMajor')" class="{{$sellerMajorInfo->status == 0 ?'':'d-none'}} btn u-btn-outline-bluegray btn-xs g-brd-2 rounded-0">
                                <i class="fa fa-check-circle g-mr-2"></i>
                                رفع محدودیت
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
