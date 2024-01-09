@extends('Layouts.IndexAdmin')
@section('Content')
    <div class="g-bg-gray-dark-v2 g-color-white g-px-15 g-py-30">
        <ul class="nav nav-fill u-nav-v4-1 u-nav-light" role="tablist" data-target="nav-4-1-primary-hor-fill"
            data-tabs-mobile-type="slide-up-down" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-white">
            <li class="nav-item">
                <a class="nav-link"
                   href="{{route('administratorMaster')}}">پیشخوان</a>
            </li>
            <li class="nav-item">
                <a id="sellerSupport" class="nav-link active" data-toggle="tab" href="#nav-4-1-primary-hor-fill--4"
                   role="tab">کدهای رهگیری پست</a>
            </li>
        </ul>

        <div class="tab-pane fade show active g-bg-gray-dark-v2" id="nav-4-1-primary-hor-fill--4" role="tabpanel">
            <div style="padding-bottom: 400px" class="container">
                {{-- Table --}}
                <div class="g-pb-15 g-mt-60">
                    <div class="g-pl-0 g-mb-20">
                        <div style="direction: ltr" class="input-group">
                            <form class="revtp-searchform">
                                <input oninput="trackingCodeSearch($(this).attr('value'))"
                                       onclick="trackingCodeSearch($(this).attr('value'))"
                                       style="direction:ltr; outline: none; font-family: Vazir, serif; opacity: 0.95; font-size: 16px;"
                                       type="text" placeholder="..جستجو بر اساس کد پیگیری">
                                <ul style="direction: ltr" id="customerNationalID"
                                    class="d-none ajaxDropDown p-0 outSideClick"></ul>
                            </form>
                        </div>
                    </div>

                    @if ($data->count()!==0)
                        <h6 style="direction: rtl"
                            class="card-header g-bg-orange-opacity-0_1 g-brd-around g-brd-gray-light-v4 g-color-gray-dark rounded-0 g-mb-5 text-right tableHint">
                            <i class="fa fa-hand-o-right g-font-size-18"></i>
                            <span class="g-font-size-13">جدول را به سمت راست بکشید.</span>
                        </h6>
                    @endif
                    @if ($data->count()===0)
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
                                        <th class="align-middle text-center text-nowrap focused rtlPosition">نام محصول
                                        </th>
                                        <th class="align-middle text-center text-nowrap">تاریخ فروش</th>
                                        <th class="align-middle text-center text-nowrap">ساعت فروش</th>
                                        <th class="align-middle text-center text-nowrap">شماره فاکتور</th>
                                        <th class="align-middle text-center text-nowrap">عکس</th>
                                        <th class="align-middle text-center">کد رهگیری</th>
                                        <th class="align-middle text-center">پیغام سیستمی</th>
                                        <th class="align-middle text-center">توضیحات</th>
                                    </tr>
                                    </thead>

                                    <tbody id="tableBody">
                                    @foreach($data as $key => $rec)
                                        <tr>
                                            <td class="align-middle text-nowrap text-center">{{ $rec->Name }}</td>
                                            <td class="align-middle text-center text-nowrap">{{ $persianDate[$key][0].'/'.$persianDate[$key][1].'/'.$persianDate[$key][2] }}</td>
                                            <td class="align-middle text-center text-nowrap">{{ $rec->Time }}</td>
                                            <td class="align-middle text-center text-nowrap">{{ $rec->OrderId.'/'.$rec->ID }}</td>
                                            <td class="align-middle text-center text-nowrap">
                                                <div class="media">
                                                    <img class="d-flex g-width-60 g-height-60 g-rounded-3 mx-auto"
                                                         src="{{ $rec->PicPath }}pic1.jpg" alt="">
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-nowrap">
                                                {{$rec->TrackingCode}}
                                            </td>
                                            <td class="align-middle text-center text-nowrap">{{ $rec->DeliveryProblem }}</td>
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
@endsection
