@extends('Layouts.IndexDelivery')
@section('Content')
    <div id="kiosk-panel"></div>
    <div class="container-fluid">
        <div class="row g-my-40">
            <div class="col-lg-12">
                <!-- Figure -->
                <figure style="background-color: rgba(246,246,246,0.5)"
                        class="u-block-hover g-rounded-0 g-brd-around g-brd-gray-light-v4 g-py-15">
                    <div style="direction: rtl;" class="d-flex justify-content-start align-items-center">
                        <div class="col-md-9 d-flex g-pr-15--lg g-pr-0">
                        @if($kiosk->PicPath !== '0')
                            <!-- Figure Image -->
                                <img class="g-width-80 g-height-80 rounded-circle g-ml-15"
                                     id="userImage"
                                     src="{{ asset($kiosk->PicPath.'?'.time()) }}"
                                     {{--use ? and time() for refresh image--}}
                                     alt="Image Description">
                                <!-- Figure Image -->
                            @else
                                <img src="{{ asset('img/DeliveryImg/'.$kiosk->NationalID.'.png') }}" id="uploaded_image"
                                     class="g-width-80 g-height-80 rounded-circle g-ml-15 g-brd-around g-brd-gray-light-v2">
                        @endif
                        <!-- Figure Info -->
                            <div class="d-flex flex-column justify-content-center">
                                <div class="g-mb-5">
                                    <h4 class="h5 g-mb-0">{{ $kiosk->name.' '.$kiosk->family }}</h4>
                                </div>
                                <em class="d-block g-color-gray-dark-v5 g-font-style-normal g-font-size-13 g-mb-2">
                                    {{$kiosk->email}}</em>
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
                                            <i class="icon-lock-open"></i>
                                        </span>
                                        <a class="customLink" href="">تغییر رمز
                                            عبور</a>
                                    </li>
                                    <li class="list-inline-item justify-content-center g-mx-7">
                                        <span
                                            class="g-color-gray-dark-v5 g-color-primary--hover g-font-size-20">
                                            <i class="icon-lock-open"></i>
                                        </span>
                                        <a class="customLink" href="#"
                                           onclick="$('#signature').removeClass('d-none')">تغییر رمز
                                            امضاء</a>
                                    </li>
                                    <li id="signature" style="direction: ltr" class="d-none list-inline-item justify-content-center g-mx-7">
                                        <div id="signatureEditContainer" class="g-width-200">
                                            <div class="input-group">
                                              <span class="input-group-btn">
                                                <button class="btn u-btn-primary rounded-0" onclick="signatureEdit({{$kiosk->ID}})" type="button">تغییر</button>
                                              </span>
                                                <input id="newSignature" type="text" class="form-control form-control-md rounded-0"
                                                       placeholder="رمز امضاء جدید">
                                            </div>
                                        </div>
                                        <i id="waitingSignatureEdit"
                                           style="display: none"
                                           class="fa fa-spinner fa-spin m-0 g-font-size-20 g-color-primary"></i>

                                        <i id="successSignatureEdit"
                                           style="display: none"
                                           class="fa fa-check m-0 g-font-size-20 g-color-primary"></i>
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
        <div style="direction: rtl">
            <div id="accordion-01" role="tablist" aria-multiselectable="true">
                <!-- محصولات در صف انتظار -->
                <div class="card g-mb-5 rounded-0">
                    <div id="accordion-01-heading-01" class="card-header" role="tab">
                        <h5 class="mb-0">
                            <a class="d-block u-link-v5 g-color-main g-color-primary--hover"
                               href="#accordion-01-body-01" data-toggle="collapse" data-parent="#accordion-01"
                               aria-expanded="true" aria-controls="accordion-01-body-01">محصولات فروش رفته موجود در
                                کیوسک</a>
                        </h5>
                    </div>
                    <div id="accordion-01-body-01" class="collapse show" role="tabpanel"
                         aria-labelledby="accordion-01-heading-01">
                        <div class="card-block">
                            <!-- Table Schedule -->
                            <div class="table-responsive">
                                <table style="direction: rtl"
                                       class="table table-bordered table-hover table-inverse u-table--v2 text-center text-uppercase g-col-border-side-0">
                                    <thead>
                                    <tr class="g-bg-primary g-col-border-top-0">
                                        <th class="g-brd-white-opacity-0_1">ردیف</th>
                                        <th class="g-brd-white-opacity-0_1">نام محصول</th>
                                        <th class="g-brd-white-opacity-0_1">مدل</th>
                                        <th class="g-brd-white-opacity-0_1">سایز</th>
                                        <th class="g-brd-white-opacity-0_1">رنگ</th>
                                        <th class="g-brd-white-opacity-0_1">کد محصول</th>
                                        <th class="g-brd-white-opacity-0_1">کد فاکتور</th>
                                        <th class="g-brd-white-opacity-0_1">وضعیت رسیدگی</th>
                                        <th class="g-brd-white-opacity-0_1">تصویر محصول</th>
                                    </tr>
                                    </thead>

                                    <tbody class="g-font-size-12 g-color-white-opacity-0_5 g-font-weight-600">
                                    @if($kioskBasket!==null)
                                        @foreach($kioskBasket as $key => $row)
                                            <tr id="row{{$key}}">
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$key+1}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$row->Name}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$row->Model}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$row->Size}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$row->Color}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                <span
                                                    class="g-color-white">{{$row->ProductID.'/'.$row->ProductDetailID}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                <span
                                                    class="g-color-white">{{$row->OrderId.'/'.$row->OrderDetailID}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    @if($row->DeliveryProblem === 0)
                                                        <div class="d-flex justify-content-around align-items-center">
                                                            <a class="btn-floating btn-primary rounded-circle">
                                                                <div style="width: 15px; height: 15px"></div>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="d-flex justify-content-around align-items-center">
                                                            <a class="btn-floating g-bg-red pulse rounded-circle">
                                                                <div style="width: 20px; height: 20px"></div>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <img
                                                        class="d-flex g-width-60 g-height-60 g-my-10 mx-auto g-bg-white"
                                                        src="{{ $row->productPicPath.$row->PicNumber }}.jpg"
                                                        title="{{ $row->Color }}" alt="Image Description">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table Schedule -->
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <div id="accordion-01" role="tablist" aria-multiselectable="true">
                <!-- برگشتی -->
                <div class="card g-mb-5 rounded-0">
                    <div id="accordion-02-heading-02" class="card-header" role="tab">
                        <h5 class="mb-0">
                            <a class="d-block u-link-v5 g-color-main g-color-primary--hover"
                               href="#accordion-02-body-02" data-toggle="collapse" data-parent="#accordion-02"
                               aria-expanded="true" aria-controls="accordion-02-body-02">محصولات برگشتی موجود در
                                کیوسک</a>
                        </h5>
                    </div>
                    <div id="accordion-02-body-02" class="collapse show" role="tabpanel"
                         aria-labelledby="accordion-02-heading-02">
                        <div class="card-block">
                            <!-- Table Schedule -->
                            <div class="table-responsive">
                                <table style="direction: rtl"
                                       class="table table-bordered table-hover table-inverse u-table--v2 text-center text-uppercase g-col-border-side-0">
                                    <thead>
                                    <tr class="g-bg-primary g-col-border-top-0">
                                        <th class="g-brd-white-opacity-0_1">ردیف</th>
                                        <th class="g-brd-white-opacity-0_1">نام محصول</th>
                                        <th class="g-brd-white-opacity-0_1">مدل</th>
                                        <th class="g-brd-white-opacity-0_1">سایز</th>
                                        <th class="g-brd-white-opacity-0_1">رنگ</th>
                                        <th class="g-brd-white-opacity-0_1">کد محصول</th>
                                        <th class="g-brd-white-opacity-0_1">کد فاکتور</th>
                                        <th class="g-brd-white-opacity-0_1">وضعیت رسیدگی</th>
                                        <th class="g-brd-white-opacity-0_1">تصویر محصول</th>
                                        <th class="g-brd-white-opacity-0_1">درخواست پیک</th>
                                    </tr>
                                    </thead>

                                    <tbody class="g-font-size-12 g-color-white-opacity-0_5 g-font-weight-600">
                                    @if($returnKioskBasket!==null)
                                        @foreach($returnKioskBasket as $key => $row)
                                            <tr id="returnRow{{$key}}">
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$key+1}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$row->Name}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$row->Model}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$row->Size}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$row->Color}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span
                                                        class="g-color-white">{{$row->ProductID.'/'.$row->ProductDetailID}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span
                                                        class="g-color-white">{{$row->OrderId.'/'.$row->OrderDetailID}}</span>
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    @if($row->ReturnProblem === 0)
                                                        <div class="d-flex justify-content-around align-items-center">
                                                            <a class="btn-floating btn-primary rounded-circle">
                                                                <div style="width: 15px; height: 15px"></div>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="d-flex justify-content-around align-items-center">
                                                            <a class="btn-floating g-bg-red pulse rounded-circle">
                                                                <div style="width: 20px; height: 20px"></div>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <img
                                                        class="d-flex g-width-60 g-height-60 g-my-10 mx-auto g-bg-white"
                                                        src="{{ $row->productPicPath.$row->PicNumber }}.jpg"
                                                        title="{{ $row->Color }}" alt="Image Description">
                                                </td>
                                                <td style="direction: ltr" class="g-brd-white-opacity-0_1 align-middle">
                                                    <div id="returnSignatureDiv{{$key}}"
                                                         class="{{$row->ReturnStatus === '2'?'d-none ':'d-inline-block '}}col-9">
                                                        <div class="input-group justify-content-center">
                                                            <div class="input-group-btn">
                                                                <button
                                                                    class="btn u-btn-primary rounded-0"
                                                                    onclick="returnCourierRequest({{$row->OrderDetailID}}, {{$key}})"
                                                                    type="button"><i
                                                                        class="fa fa-check align-middle g-font-size-16"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <i id="returnWaitingIconTd{{$key}}"
                                                       class="d-none fa fa-spinner fa-spin m-0 g-font-size-20 g-color-primary"></i>

                                                    <svg id="returnCheckMark{{$key}}"
                                                         class="{{$row->ReturnStatus === '22'?'d-none':''}} checkmark"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                        <circle class="checkmark__circle" cx="26" cy="26" r="25"
                                                                fill="none"/>
                                                        <path class="checkmark__check" fill="none"
                                                              d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                    </svg>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table Schedule -->
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection
