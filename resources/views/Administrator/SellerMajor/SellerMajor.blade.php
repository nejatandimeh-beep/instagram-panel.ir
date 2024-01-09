@extends('Layouts.IndexAdmin')
@section('Content')

    <div style="direction: rtl; min-height: 100vh" class="g-bg-gray-dark-v2 d-lg-flex">
        <div class="col-12 col-lg-3 g-brd-left g-brd-white-opacity-0_8 text-center g-pt-20 g-pb-40">
            <span class="d-block g-font-size-25 g-color-pink g-mb-15 g-pb-20 g-brd-bottom g-brd-white-opacity-0_8">پنل مدیریت صفحه ها</span>
            <a href="{{route('sellerMajorSupport')}}" class="d-block btn btn-md u-btn-darkgray rounded-0 u-btn-hover-v2-1 g-mb-40">
                پشتیبانی صفحه ها
                <div style="width: 20px; height: 20px"
                     class="{{$newSupportSellerMajor===0 ? 'd-none ': 'd-inline-block '}}text-center g-color-black g-bg-lightred g-rounded-50x g-mr-10">
                    {{$newSupportSellerMajor}}
                </div>
            </a>
            <div class="navbar-brand g-mr-0 g-mb-20 d-lg-block d-none">
                <img style="width: 100px" src="{{asset('img/Logo/logo.png')}}" alt="Image Description" width="150">
            </div>
            <h4 class="h6 g-color-white-opacity-0_6 g-mb-0">
                <div class="text-center hidden-lg-down">
                    <span class="mb-0" id="persianDate"></span>
                    <span class="mb-0"> ساعت </span>
                    <span class="mb-0" id="persianTime"></span>
                </div>
            </h4>
        </div>
        <div class="col-12 col-lg-9 g-pt-25 g-pb-40">
            <div class="d-flex justify-content-between g-mb-15">
                <h5 class="g-mb-0 g-color-gray-light-v2 align-self-center">لیست صفحه ها</h5>
                <div class="g-pl-0">
                    <div style="direction: ltr" class="input-group">
                        <form class="revtp-searchform">
                            <input oninput="smSearchName($(this).attr('value'))" id="sName"
                                   style="direction:ltr; outline: none; box-shadow: none; width: 150px; font-family: Vazir, serif; opacity: 0.95; font-size: 16px;"
                                   type="text" placeholder="..جستجو با نام" maxlength="10" class="g-brd-around g-brd-gray-light-v1">
                            <input oninput="smSearchMobile($(this).attr('value'))" id="sMobile"
                                   style="direction:ltr; outline: none; box-shadow: none; width: 150px; font-family: Vazir, serif; opacity: 0.95; font-size: 16px;"
                                   type="text" placeholder="..جستجو با موبایل" maxlength="10" class="g-mt-5 g-brd-around g-brd-gray-light-v1">
                        </form>
                    </div>
                </div>
            </div>
            <div id="searchContainer" class="d-none col-12 g-pa-5 g-bg-primary g-mt-15">
                <div style="min-height: 80px" class="g-bg-gray-light-v3">
                    <h5 class="g-color-gray-dark-v2 g-pa-10">نتایج</h5>
                    <ul style="direction: ltr" id="resultContainer"
                        class="ajaxDropDown p-0 m-0"></ul>
                </div>
            </div>
            <!--Basic Table-->
            <div class="table-responsive p-1">
                <table class="table table-bordered u-table--v2">
                    <thead class="text-uppercase g-letter-spacing-1">
                    <tr>
                        <th class="g-font-weight-600 g-color-white text-center">ردیف</th>
                        <th class="g-font-weight-600 g-color-white text-center">نام</th>
                        <th class="g-font-weight-600 g-color-white text-center">موبایل</th>
                        <th class="g-font-weight-600 g-color-white text-center">شرکت در کمپین</th>
                        <th class="g-font-weight-600 g-color-white text-center">دسترسی به کمپین</th>
                        <th class="g-font-weight-600 g-color-white text-center">دسترسی به حساب</th>
                        <th class="g-font-weight-600 g-color-white text-center">جزئیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($data as $key =>$row)
                        <tr>
                            <td class="align-middle text-nowrap text-center g-color-gray-light-v2">
                                {{$key+1}}
                            </td>

                            <td class="align-middle text-nowrap text-center">
                                <a class="nav-link g-color-primary" href="{{route('adminSellerMajorPanel',$row->id)}}">{{$row->name}}</a>
                            </td>
                            <td class="align-middle text-center g-color-gray-light-v2">
                                {{$row->Mobile}}
                            </td>
                            <td class="align-middle text-center g-color-gray-light-v2">
                                @if ($row->Advertising==='1')
                                    <a class="g-color-gray-dark-v5 g-text-underline--none--hover g-pa-5"
                                       data-toggle="tooltip"
                                       data-placement="top" data-original-title="عضو کمپین است">
                                        <i class="fa fa-check g-font-size-18 g-color-primary"></i>
                                    </a>
                                @else
                                    <a class="g-color-gray-dark-v5 g-text-underline--none--hover g-pa-5"
                                       data-toggle="tooltip"
                                       data-placement="top" data-original-title="عضو کمپین نیست">
                                        ---
                                    </a>
                                @endif
                            </td>
                            <td class="align-middle text-center g-color-gray-light-v2">
                                @if ($row->AdBlock==='0')
                                    <a class="g-color-gray-dark-v5 g-text-underline--none--hover g-pa-5"
                                       data-toggle="tooltip"
                                       data-placement="top" data-original-title="بدون محدودیت">
                                        <i class="fa fa-check g-font-size-18 g-color-primary"></i>
                                    </a>
                                @else
                                    <a class="g-color-gray-dark-v5 g-text-underline--none--hover g-pa-5"
                                       data-toggle="tooltip"
                                       data-placement="top" data-original-title="محدود شده است">
                                        <i class="fa fa-minus-circle g-font-size-18 g-color-red"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="align-middle text-center g-color-gray-light-v2">
                                @if ($row->status===1)
                                    <a class="g-color-gray-dark-v5 g-text-underline--none--hover g-pa-5"
                                       data-toggle="tooltip"
                                       data-placement="top" data-original-title="بدون محدودیت">
                                        <i class="fa fa-check g-font-size-18 g-color-primary"></i>
                                    </a>
                                @else
                                    <a class="g-color-gray-dark-v5 g-text-underline--none--hover g-pa-5"
                                       data-toggle="tooltip"
                                       data-placement="top" data-original-title="محدود شده است">
                                        <i class="fa fa-minus-circle g-font-size-18 g-color-red"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="align-middle text-nowrap text-center">
                                <a class="g-color-aqua g-text-underline--none--hover g-pa-5"
                                   href="{{route('sellerMajorControlPanel',['id'=>$row->id,'tab'=>'user'])}}">
                                    <i class="icon-eye g-font-size-18 g-mr-7"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!--End Basic Table-->
        </div>
    </div>

@endsection
