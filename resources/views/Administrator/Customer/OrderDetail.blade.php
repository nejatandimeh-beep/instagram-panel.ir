@extends('Layouts.IndexAdmin')
@section('Content')
    <div class="g-bg-gray-dark-v2 g-color-white g-px-15 g-py-30 orderDetail">
        <ul class="nav nav-fill u-nav-v4-1 u-nav-light adminPanelResponsive" role="tablist" data-target="nav-4-1-primary-hor-fill"
            data-tabs-mobile-type="slide-up-down" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-white">
            <li class="nav-item">
                <a class="nav-link"
                   href="{{route('customerControlPanel',['id'=>$data->CustomerID,'tab'=>'sale'])}}">فاکتورهای فروش</a>
            </li>
            <li class="nav-item">
                <a id="sellerSupport" class="nav-link active" data-toggle="tab" href="#nav-4-1-primary-hor-fill--1"
                   role="tab">جزئیات فاکتور</a>
            </li>
        </ul>
        <div style="direction: rtl" id="nav-4-1-primary-hor-fill" class="tab-content g-pt-40">
            <!-- End Info Panel -->
            <div class="tab-pane fade show active g-bg-gray-dark-v2" id="nav-4-1-primary-hor-fill--1" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <form class="g-pa-15 g-mb-17 g-mt-17">
                            {{--Order Info--}}
                            <div class="row g-mb-10 text-right">
                                {{--                Number--}}
                                <div class="input-group col-lg-6">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        شماره فاکتور
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ $data->OrderId.'/'.$data->orderDetailID }}">
                                </div>
                                {{--                Date--}}
                                <div class="input-group col-lg-6">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        تاریخ فاکتور
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ $persianDate[0].'/'.$persianDate[1].'/'.$persianDate[2] }}">
                                </div>
                            </div>

                            <div class="row g-mb-10 text-right">
                                {{--                Name--}}
                                <div class="input-group col-lg-6 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        نام محصول
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ $data->Name }}">
                                </div>
                                {{--                Gender--}}
                                <div class="input-group col-lg-6 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        جنسیت محصول
                                    </div>
                                    @if($data->Gender == 0)
                                        <input
                                            class="form-control form-control-md  g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0 text-center g-font-size-16"
                                            type="text"
                                            tabindex="1"
                                            placeholder=""
                                            disabled
                                            value="زنانه">
                                    @elseif($rec->Gender == 1)
                                        <input
                                            class="form-control form-control-md  g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0 text-center g-font-size-16"
                                            type="text"
                                            tabindex="1"
                                            placeholder=""
                                            disabled
                                            value="مردانه">
                                    @elseif($rec->Gender == 2)
                                        <input
                                            class="form-control form-control-md  g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0 text-center g-font-size-16"
                                            type="text"
                                            tabindex="1"
                                            placeholder=""
                                            disabled
                                            value="بچگانه نوزادی">
                                    @elseif($rec->Gender == 3)
                                        <input
                                            class="form-control form-control-md  g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0 text-center g-font-size-16"
                                            type="text"
                                            tabindex="1"
                                            placeholder=""
                                            disabled
                                            value="بچگانه دخترانه">
                                    @else
                                        <input
                                            class="form-control form-control-md  g-bg-gray-dark-v2 g-color-gray-light-v4 rounded-0 text-center g-font-size-16"
                                            type="text"
                                            tabindex="1"
                                            placeholder=""
                                            disabled
                                            value="بچگانه پسرانه">
                                    @endif
                                </div>
                                {{--                Model--}}
                                <div class="input-group col-lg-6 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        مدل محصول
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ $data->Model }}">
                                </div>
                                {{--                Brand--}}
                                <div class="input-group col-lg-6 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        برند محصول
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ $data->Brand }}">
                                </div>
                                {{--                Size--}}
                                <div class="input-group col-lg-6 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        سایز محصول
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ $data->Size }}">
                                </div>
                                {{--                Color--}}
                                <div class="input-group col-lg-6 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        رنگ محصول
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ $data->Color }}">
                                </div>
                                {{--                Detail--}}
                                <div class="input-group col-lg-12 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        توضیحات
                                    </div>
                                    <textarea
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-right g-font-size-16 text-truncate"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled>
                        {{ $data->Detail }}
                    </textarea>
                                </div>
                                {{--                UnitPrice--}}
                                <div class="input-group col-lg-12 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        قیمت پایه
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ number_format($data->OrderDetailPrice) }}">
                                    <span style="border-left: 1px solid #ccc"
                                          class="input-group-addon g-color-gray-light-v1  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-right-none g-width-100 bigDevice">تومان</span>
                                </div>
                                {{--                Discount--}}
                                <div class="input-group col-lg-12 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        تخفیف
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ $data->Discount }}">
                                    <span style="border-left: 1px solid #ccc"
                                          class="input-group-addon g-color-gray-light-v1  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-right-none g-width-100 bigDevice">درصد</span>
                                </div>
                                {{--                FinalPrice--}}
                                <div class="input-group col-lg-12 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        قیمت نهایی
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ number_format($data->OrderDetailFinalPrice) }}">
                                    <span style="border-left: 1px solid #ccc"
                                          class="input-group-addon g-color-gray-light-v1  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-right-none g-width-100 bigDevice">تومان</span>
                                </div>
                                {{--                Qty--}}
                                <div class="input-group col-lg-12 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        تعداد خرید
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0  g-bg-gray-dark-v2 g-color-gray-light-v4 text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ $data->Qty }}">
                                    <span style="border-left: 1px solid #ccc"
                                          class="input-group-addon g-color-gray-light-v1  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-right-none g-width-100 bigDevice">عدد</span>
                                </div>
                                {{--                AllPrice--}}
                                <div class="input-group col-lg-12 g-mb-10">
                                    <div style="border-right: 1px solid #ccc"
                                         class="input-group-addon d-flex align-items-center  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-left-none rounded-0 w-50">
                                        مبلغ کل فاکتور
                                    </div>
                                    <input
                                        class="form-control form-control-md rounded-0 g-bg-primary g-color-white text-center g-font-size-16"
                                        type="text"
                                        tabindex="1"
                                        placeholder=""
                                        disabled
                                        value="{{ number_format($data->OrderDetailFinalPrice * $data->Qty) }}">
                                    <span style="border-left: 1px solid #ccc"
                                          class="input-group-addon g-color-gray-light-v1  g-bg-gray-dark-v2 g-color-gray-light-v4 g-brd-right-none g-width-100 bigDevice">تومان</span>
                                </div>
                                <div class="input-group col-lg-12 g-mb-10">
                                    <div style="direction: rtl" id="addressContainer" class="text-right g-mt-15">
                                        <div
                                            class="d-lg-inline-block g-font-size-16 g-font-weight-300 g-mr-5--lg g-pt-10 g-pt-0--lg text-right">
                                            <h5 class="d-lg-inline-block d-block">آدرس
                                                ارسال:</h5>
                                            <span id="receiverState" class="d-none">{{ $data->State }}</span>
                                            <span id="receiverCity" class="d-none">{{ $data->City }}</span>
                                            <span class="receiverStateCity g-color-yellow"></span>
                                            <span id="addressID"
                                                  class="d-block d-lg-inline-block g-font-size-16 g-font-weight-300 g-mr-5--lg g-pt-10 g-color-yellow"> {{$data->Address}}
                                                        <strong class="g-mr-5 g-color-white">گیرنده:</strong> {{$data->ReceiverName.' '.$data->ReceiverFamily}}
                                                        <strong class="g-mr-5 g-color-white">شماره تماس:</strong> {{$data->Mobile}}
                                                        <strong class="g-mr-5 g-color-white">کد پستی:</strong> {{$data->PostalCode}}
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row g-mb-25">
                                <label for="example-text-input" class="col-sm-2 col-form-label g-font-size-16 g-font-weight-300"></label>
                                <div style="direction: ltr" class="col-sm-10 text-left p-0">
                                    <div class="col-sm-3 g-mb-10">
                                        <img class="img-fluid img-thumbnail g-rounded-1"
                                             src="{{ file_exists(public_path($data->PicPath.$data->SampleNumber.'.jpg'))?$data->PicPath.$data->SampleNumber:$data->PicPath.'sample1' }}.jpg"
                                             alt="Image Description">
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if (isset($data->falseProduct))
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Danger Alert -->
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <h4 class="h5"><i class="fa fa-minus-circle g-ml-5"></i>فاکتور حاوی مشخصات
                                            اشتباه است.</h4>
                                    </div>
                                    <!-- Danger Alert -->
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

