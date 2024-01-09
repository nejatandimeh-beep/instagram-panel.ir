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
                <a id="sellerOrder" class="nav-link g-mb-minus-1 active" data-toggle="tab" href="#nav-4-1-primary-hor-fill--4" role="tab">
                    <span id="deliveryAlarm" class="d-none g-mr-10">
                        <i class="fa fa-exclamation-triangle g-font-size-18 g-color-lightred"></i>
                    </span>
                    محصولات برگشتی
                </a>
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
                <a id="sellerOrder" class="nav-link g-mb-minus-1" href="{{route('adminCustomerSale',$customerInfo->id)}}">
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
        <div id="nav-4-1-primary-hor-fill" class="tab-content g-pt-40">
            <!--فاکتور-->
            <div class="tab-pane fade show active" id="nav-4-1-primary-hor-fill--4" role="tabpanel">
                <div style="padding-bottom: 120px" class="container">
                    {{-- Table --}}
                    <div class="g-pb-15 g-mt-40">
                        @if ($data->count()!==0)
                            <div style="direction: rtl" class="row g-my-40">
                                <div class="col-md-12">
                                    <div class="alert alert-warning" role="alert">
                                        <strong class="g-font-size-25 g-mr-10">توجه</strong>
                                        <p class="g-mr-10 g-mt-15">محصولات زیر از سوی مشتری برگشت خورده اند. لطفا در اسرع وقت اقدام فرمایید.</p>
{{--                                        <a href="{{route('sellerRegulation','returnProduct')}}" class="alert-link g-mr-10">شرایط برگشت محصول</a>--}}
                                    </div>
                                </div>
                            </div>
                            <h6 style="direction: rtl"
                                class="card-header g-bg-orange-opacity-0_1 g-brd-around g-brd-gray-light-v4 g-color-gray-dark rounded-0 g-mb-5 text-right tableHint">
                                <i class="fa fa-hand-o-right g-font-size-18"></i>
                                <span class="g-font-size-13">جدول را به سمت راست بکشید.</span>
                            </h6>
                        @endif
                        @if ($data->count()===0)
                            <div style="direction: rtl" class="row">
                                <div class="col-lg-12 g-mt-15">
                                    <!-- Border Alert -->
                                    <div class="alert fade show g-brd-around g-brd-gray-light-v3 rounded-0 g-pt-100--lg g-pb-100--lg d-flex justify-content-center" role="alert">
                                        <div class="media">
                                            <div class="d-flex g-ml-10">
                                <span class="u-icon-v3 u-icon-size--md g-bg-lightred g-color-white g-rounded-50x">
                                  <i class="icon-envelope g-font-size-30"></i>
                                </span>
                                            </div>
                                            <div class="media-body">
                                                <div class="d-flex justify-content-between">
                                                    <p class="m-0 g-font-size-20"><strong>فروشنده گرامی</strong></p>
                                                </div>
                                                <p class="m-0 g-font-size-16">هیچ کدام از محصولات خریدار مورد نظر در لیست محصولات برگشتی نمی باشند.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Border Alert -->
                                </div>
                            </div>
                        @else
                        <!--Table-->
                            <h3 style="direction: rtl"
                                class="card-header g-bg-dark g-brd-around g-brd-gray-light-v4 g-color-gray-dark g-font-size-16 rounded-0 g-mb-5 text-right">
                                لیست محصولات برگشتی
                            </h3>
                            <div class="table-responsive">
                                <table style="direction: rtl" class="table table-bordered u-table--v2">
                                    <thead>
                                    <tr>
                                        <th class="align-middle text-center focused">کد محصول</th>
                                        <th class="align-middle text-center">نام</th>
                                        <th class="align-middle text-center">برند</th>
                                        <th class="align-middle text-center">جنسیت</th>
                                        <th class="align-middle text-center">تعداد</th>
                                        <th class="align-middle text-center text-nowrap">مبلغ فاکتور<span
                                                class="g-font-size-10 g-mr-3">(تومان)</span>
                                        </th>
                                        <th class="align-middle text-center">تاریخ فاکتور</th>
                                        <th class="align-middle text-center">تاریخ برگشت</th>
                                        <th class="align-middle text-center text-nowrap">دلیل برگشت</th>
                                        <th class="align-middle text-center">عکس</th>
                                        <th class="align-middle text-center">فاکتور</th>
                                        <th class="align-middle text-center">توضیحات</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($data as $key => $rec)
                                        <tr>
                                            <td class="align-middle text-nowrap text-center text-nowrap">{{ $rec->pDetailID }}</td>
                                            <td class="align-middle text-nowrap text-center text-nowrap">{{ $rec->Name }}</td>
                                            <td class="align-middle text-center">{{ $rec->Brand }}</td>
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
                                            <td class="align-middle text-center g-color-primary">{{ number_format($rec->PriceWithDiscount * $rec->Qty) }}</td>
                                            <td class="align-middle text-center text-nowrap">{{ $returnPersianDate[$key][0].'/'.$returnPersianDate[$key][1].'/'.$returnPersianDate[$key][2] }}</td>
                                            <td class="align-middle text-center text-nowrap">{{ $persianDate[$key][0].'/'.$persianDate[$key][1].'/'.$persianDate[$key][2] }}</td>
                                            <td class="align-middle text-center">
                                                @switch($rec->Reason)
                                                    @case('1')
                                                    ایراد در ظاهر
                                                    @break
                                                    @case('2')
                                                    مغایرت مشخصات
                                                    @break
                                                @endswitch
                                            </td>
                                            <td class="align-middle">
                                                <div class="media">
                                                    <img class="d-flex g-width-48 g-height-60 g-rounded-3 mx-auto"
                                                         src="{{ file_exists(public_path($rec->PicPath.$rec->SampleNumber.'.jpg'))?$rec->PicPath.$rec->SampleNumber:$rec->PicPath.'sample1' }}.jpg" alt="">
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a style="cursor: pointer"
                                                   href="{{ route('adminCustomerOrderDetail',['addressId'=>$rec->AddressID, 'id'=>$rec->orderDetailID]) }}"
                                                   class="g-color-gray-light-v5 g-text-underline--none--hover g-color-primary--hover g-pa-5"
                                                   data-toggle="tooltip"
                                                   data-placement="top" data-original-title="مشاهده جزئیات فاکتور">
                                                    <i class="fa fa-eye g-font-size-18"></i>
                                                </a>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a style="cursor: pointer"
                                                   href=""
                                                   class="g-color-gray-light-v5 g-text-underline--none--hover g-color-primary--hover g-pa-5"
                                                   data-toggle="modal"
                                                   data-target="#modalPrice{{$key}}">
                                                    <i class="fa fa-eye g-font-size-18"></i>
                                                </a>
                                                <div class="modal fade text-center" id="modalPrice{{$key}}" tabindex="-1" role="dialog"
                                                     aria-labelledby="myModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header g-pr-20 g-pl-20">
                                                                <h4>دلایل برگشت محصول از جانب خریدار</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <i class="fa fa-close"></i>
                                                                </button>
                                                            </div>

                                                            <div style="direction: rtl" class="modal-body mx-3 text-right">
                                                                <p style="text-align: justify;" class="g-color-red">{{$rec->ReasonDetail}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                    {{ $data->links('General.Pagination', ['result' => $data]) }}
                </div>
            </div>
        </div>
    </div>
@endsection

