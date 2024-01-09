@extends('Layouts.IndexDelivery')
@section('Content')
    <div class="container-fluid">
        <div class="row g-my-40">
            <div class="col-lg-12">
                <!-- Figure -->
                <figure style="background-color: rgba(246,246,246,0.5)"
                        class="u-block-hover g-rounded-0 g-brd-around g-brd-gray-light-v4 g-py-15">
                    <div style="direction: rtl;" class="d-flex justify-content-start align-items-center">
                        <div class="col-md-9 d-flex g-pr-15--lg g-pr-0">
                        @if($deliveryManActive->PicPath !== '0')
                            <!-- Figure Image -->
                                <img class="g-width-80 g-height-80 rounded-circle g-ml-15"
                                     id="userImage"
                                     src="{{ asset($deliveryManActive->PicPath.'?'.time()) }}"
                                     {{--use ? and time() for refresh image--}}
                                     alt="Image Description">
                                <!-- Figure Image -->
                            @else
                                <img src="{{ asset('img/Other/user-add-icon.png') }}" id="uploaded_image"
                                     class="g-width-80 g-height-80 rounded-circle g-ml-15 g-brd-around g-brd-gray-light-v2">
                        @endif
                        <!-- Figure Info -->
                            <div class="d-flex flex-column justify-content-center">
                                <div class="g-mb-5">
                                    <h4 class="h5 g-mb-0">{{ $deliveryManActive->name.' '.$deliveryManActive->family }}</h4>
                                </div>
                                <em class="d-block g-color-gray-dark-v5 g-font-style-normal g-font-size-13 g-mb-2">{{$deliveryManActive->email}}</em>
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
                               aria-expanded="true" aria-controls="accordion-01-body-01">محصولات فروش رفته در صف
                                انتظار</a>
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
                                        <th class="g-brd-white-opacity-0_1">مبداً</th>
                                        <th class="g-brd-white-opacity-0_1">وضعیت رسیدگی</th>
                                        <th class="g-brd-white-opacity-0_1">تصویر محصول</th>
                                        <th class="g-brd-white-opacity-0_1">تصویر تحویل دهنده</th>
                                    </tr>
                                    </thead>

                                    <tbody class="g-font-size-12 g-color-white-opacity-0_5 g-font-weight-600">
                                    @if($data!==null)
                                        @foreach($data as $key => $row)
                                            <span id="deliveryDestination{{$key}}"
                                                  class="d-none">{{$row->DeliveryStatus==='0'?'1':'3'}}</span>
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
                                                    @if($row->DeliveryStatus === '0')
                                                        <span class="g-font-size-16 g-color-yellow">
                                                            {{$row->Address.' پلاک '.$row->ShopNumber}}
                                                    </span>
                                                    @endif
                                                    @if($row->DeliveryStatus === '2')
                                                        <span class="g-font-size-16 g-color-yellow">
                                                         کیوسک
                                                    </span>
                                                    @endif
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
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    @if($row->DeliveryStatus === '0')
                                                        <img class="d-flex g-width-60 g-my-10 g-height-60 mx-auto"
                                                             src="{{ asset($row->sellerPic) }}" alt="Image Description">
                                                    @endif
                                                    @if($row->DeliveryStatus === '2')
                                                        <i class="icon-home g-font-size-20 g-color-primary"></i>
                                                    @endif
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
            <div id="accordion-02" role="tablist" aria-multiselectable="true">
                <!-- برگشتی -->
                <div class="card g-mb-5 rounded-0">
                    <div id="accordion-02-heading-02" class="card-header" role="tab">
                        <h5 class="mb-0">
                            <a class="d-block u-link-v5 g-color-main g-color-primary--hover"
                               href="#accordion-02-body-02" data-toggle="collapse" data-parent="#accordion-02"
                               aria-expanded="true" aria-controls="accordion-02-body-02">محصولات برگشتی در صف
                                انتظار</a>
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
                                        <th class="g-brd-white-opacity-0_1">مبداً</th>
                                        <th class="g-brd-white-opacity-0_1">وضعیت رسیدگی</th>
                                        <th class="g-brd-white-opacity-0_1">تصویر محصول</th>
                                        <th class="g-brd-white-opacity-0_1">تاییدیه</th>
                                    </tr>
                                    </thead>

                                    <tbody class="g-font-size-12 g-color-white-opacity-0_5 g-font-weight-600">
                                    @if($return!==null)
                                        @foreach($return as $key => $row)
                                            <span id="returnDestination{{$key}}"
                                                  class="d-none">{{$row->ReturnStatus==='4'?'3':'1'}}</span>
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
                                                    @if($row->ReturnStatus === '4')
                                                        <span class="g-font-size-16 g-color-yellow">
                                                            اداره پست مرکزی
                                                        </span>
                                                    @endif
                                                    @if($row->ReturnStatus === '2')
                                                        <span class="g-font-size-16 g-color-yellow">
                                                            کیوسک
                                                        </span>
                                                    @endif
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
                                                    <div id="returnSignatureDiv{{$key}}" class="col-9 d-inline-block">
                                                        <div class="input-group justify-content-center">
                                                          <span class="input-group-btn">
                                                            <button class="btn u-btn-primary rounded-0"
                                                                    onclick="returnCourier({{$key}})"
                                                                    type="button"><i
                                                                    class="fa fa-check align-middle g-font-size-16"></i></button>
                                                          </span>
                                                        </div>
                                                    </div>

                                                    <form id="returnForm{{ $key }}" method="POST" action="{{route('returnCourier',[$row->OrderDetailID,$row->ReturnStatus==='4'?'3':'1'])}}">
                                                        @csrf
                                                    </form>

                                                    <i id="returnWaitingIconTd{{$key}}"
                                                       class="d-none fa fa-spinner fa-spin m-0 g-font-size-20 g-color-primary"></i>

                                                    <svg id="returnCheckMark{{$key}}" class="d-none checkmark"
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
            <div id="accordion-03" role="tablist" aria-multiselectable="true">
                <!-- سبد من -->
                <div class="card g-mb-5 rounded-0">
                    <div id="accordion-03-heading-03" class="card-header" role="tab">
                        <h5 class="mb-0">
                            <a class="d-block u-link-v5 g-color-main g-color-primary--hover"
                               href="#accordion-03-body-03" data-toggle="collapse" data-parent="#accordion-03"
                               aria-expanded="true" aria-controls="accordion-03-body-03">سبد من</a>
                        </h5>
                    </div>
                    <div id="accordion-03-body-03" class="collapse show" role="tabpanel"
                         aria-labelledby="accordion-03-heading-03">
                        <div class="card-block">
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
                                        <th class="g-brd-white-opacity-0_1">مقصد</th>
                                        <th class="g-brd-white-opacity-0_1">وضعیت رسیدگی</th>
                                        <th class="g-brd-white-opacity-0_1">تصویر محصول</th>
                                        <th class="g-brd-white-opacity-0_1">تاییده</th>
                                    </tr>
                                    </thead>

                                    <tbody id="returnTBody"
                                           class="g-font-size-12 g-color-white-opacity-0_5 g-font-weight-600">
                                    <span class="d-none">{{ $counter=0 }}</span>
                                    @if($deliveryManBasket!==null)
                                        @foreach($deliveryManBasket as $key => $row)
                                            <span id="destination{{$counter}}"
                                                  class="d-none">{{$row->DeliveryStatus==='1'?'22':'4'}}</span>
                                            <tr id="basketRow{{$counter}}">
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$counter+1}}</span>
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
                                                    @if($row->DeliveryStatus === '1')
                                                        <span class="g-font-size-16 g-color-yellow">
                                                             کیوسک
                                                        </span>
                                                    @endif
                                                    @if($row->DeliveryStatus === '3')
                                                        <span class="g-font-size-16 g-color-yellow">
                                                            اداره پست مرکزی
                                                        </span>
                                                    @endif
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
                                                @if($row->DeliveryStatus==='1')
                                                    <td style="direction: ltr"
                                                        class="g-brd-white-opacity-0_1 align-middle">
                                                        <div id="kioskSignatureDiv{{$counter}}"
                                                             class="col-9 d-inline-block">
                                                            <div class="input-group">
                                                                <div class="input-group-btn">
                                                                    <button class="btn u-btn-primary rounded-0"
                                                                            onclick="deliveryKiosk({{$row->OrderDetailID}}, {{$counter}},'delivery')"
                                                                            type="button"><i
                                                                            class="fa fa-check align-middle g-font-size-16"></i>
                                                                    </button>
                                                                </div>
                                                                <input
                                                                    class="form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16"
                                                                    type="password"
                                                                    id="pass{{$counter}}"
                                                                    placeholder="رمز امضا">
                                                            </div>
                                                        </div>

                                                        <i id="kioskWaitingIconTd{{$counter}}"
                                                           class="d-none fa fa-spinner fa-spin m-0 g-font-size-20 g-color-primary"></i>

                                                        <svg id="kioskCheckMark{{$counter}}" class="d-none checkmark"
                                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                            <circle class="checkmark__circle" cx="26" cy="26" r="25"
                                                                    fill="none"/>
                                                            <path class="checkmark__check" fill="none"
                                                                  d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                        </svg>
                                                    </td>
                                                @else
                                                    <td style="direction: ltr"
                                                        class="g-brd-white-opacity-0_1 align-middle">
                                                        <div id="postSignatureDiv{{$counter}}"
                                                             class="col-9 d-inline-block">
                                                            <div class="input-group justify-content-center">
                                                                <div class="input-group-btn">
                                                                    <button class="btn u-btn-primary rounded-0"
                                                                            onclick="destinationFinal({{$row->OrderDetailID}}, {{$counter}},'delivery')"
                                                                            type="button"><i
                                                                            class="fa fa-check align-middle g-font-size-16"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <i id="postWaitingIconTd{{$counter}}"
                                                           class="d-none fa fa-spinner fa-spin m-0 g-font-size-20 g-color-primary"></i>

                                                        <svg id="postCheckMark{{$counter}}" class="d-none checkmark"
                                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                            <circle class="checkmark__circle" cx="26" cy="26" r="25"
                                                                    fill="none"/>
                                                            <path class="checkmark__check" fill="none"
                                                                  d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                        </svg>
                                                    </td>
                                                @endif
                                            </tr>
                                            <span class="d-none">{{ $counter=$counter+1 }}</span>
                                        @endforeach
                                    @endif
                                    @if($returnManBasket!==null)
                                        @foreach($returnManBasket as $key => $row)
                                            <span id="destination{{$counter}}"
                                                  class="d-none">{{$row->ReturnStatus==='3'?'22':'0'}}</span>
                                            <tr id="basketRow{{$counter}}">
                                                <td class="g-brd-white-opacity-0_1 align-middle">
                                                    <span class="g-color-white">{{$counter}}</span>
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
                                                    @if($row->ReturnStatus === '1')
                                                        <span class="g-font-size-16 g-color-yellow">
                                                             فروشنده
                                                        </span>
                                                    @endif
                                                    @if($row->ReturnStatus === '3')
                                                        <span class="g-font-size-16 g-color-yellow">
                                                            کیوسک
                                                        </span>
                                                    @endif
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
                                                @if($row->ReturnStatus==='3')
                                                    <td style="direction: ltr" class="g-brd-white-opacity-0_1 align-middle">
                                                        <div id="kioskSignatureDiv{{$counter}}"
                                                             class="col-9 d-inline-block">
                                                            <div class="input-group">
                                                                <div class="input-group-btn">
                                                                    <button class="btn u-btn-primary rounded-0"
                                                                            onclick="deliveryKiosk({{$row->OrderDetailID}}, {{$counter}},'return')"
                                                                            type="button"><i
                                                                            class="fa fa-check align-middle g-font-size-16"></i>
                                                                    </button>
                                                                </div>
                                                                <input
                                                                    class="form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16"
                                                                    id="pass{{$counter}}"
                                                                    type="password"
                                                                    placeholder="رمز امضا">
                                                            </div>
                                                        </div>
                                                        <i id="kioskWaitingIconTd{{$counter}}"
                                                           class="d-none fa fa-spinner fa-spin m-0 g-font-size-20 g-color-primary"></i>
                                                        <svg id="kioskCheckMark{{$counter}}" class="d-none checkmark"
                                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                            <circle class="checkmark__circle" cx="26" cy="26" r="25"
                                                                    fill="none"/>
                                                            <path class="checkmark__check" fill="none"
                                                                  d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                        </svg>
                                                    </td>
                                                @else
                                                    <td style="direction: ltr" class="g-brd-white-opacity-0_1 align-middle">
                                                        <div id="postSignatureDiv{{$counter}}"
                                                             class="col-9 d-inline-block">
                                                            <div class="input-group">
                                                                <div class="input-group-btn">
                                                                    <button class="btn u-btn-primary rounded-0"
                                                                            onclick="destinationFinal({{$row->OrderDetailID}}, {{$counter}},'return')"
                                                                            type="button"><i
                                                                            class="fa fa-check align-middle g-font-size-16"></i>
                                                                    </button>
                                                                </div>
                                                                <input
                                                                    class="form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16"
                                                                    id="sellerPass{{$counter}}"
                                                                    type="password"
                                                                    placeholder="رمز امضا">
                                                            </div>
                                                            <span id="sellerID{{$counter}}" class="d-none">{{$row->SellerID}}</span>
                                                        </div>
                                                        <i id="postWaitingIconTd{{$counter}}"
                                                           class="d-none fa fa-spinner fa-spin m-0 g-font-size-20 g-color-primary"></i>
                                                        <svg id="postCheckMark{{$counter}}" class="d-none checkmark"
                                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                            <circle class="checkmark__circle" cx="26" cy="26" r="25"
                                                                    fill="none"/>
                                                            <path class="checkmark__check" fill="none"
                                                                  d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                        </svg>
                                                    </td>
                                                @endif
                                            </tr>
                                            <span class="d-none">{{ $counter=$counter+1 }}</span>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection
