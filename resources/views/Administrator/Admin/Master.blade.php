@extends('Layouts.IndexAdmin')
@section('Content')
    {{--    <h1 class="g-color-black">{{Auth::guard('admin')->user()->name}}</h1>--}}

    <div class="g-z-index-1 g-py-100 g-bg-black">
        <!-- Testimonials -->
        <div class="row justify-content-center">
            <div class="text-center g-z-index-1 text-uppercase">
                <blockquote class="g-color-white g-font-size-28 g-mb-20">پنل مدیریت سیستم</blockquote>
                <!-- Logo -->
                <div class="navbar-brand g-mb-20">
                    <img src="{{asset('img/Logo/logo.png')}}" alt="Image Description" width="100">
                </div>
                <h4 class="h6 g-color-white-opacity-0_6 g-mb-0">
                    <div class="text-center hidden-lg-down">
                        <span class="mb-0" id="persianDate"></span>
                        <span class="mb-0"> ساعت </span>
                        <span class="mb-0" id="persianTime"></span>
                    </div>
                </h4>
                <!-- End Logo -->
            </div>
        </div>
        <!-- End Testimonials -->
    </div>
    <div class="g-pa-60 g-pt-0 g-bg-black">
        <!-- Icon Blocks -->
        <div style="direction: rtl" class="row">
            <div class="col-lg-4 g-mb-30">
                <!-- Icon Blocks -->
                <a class="d-block g-text-underline--none--hover g-brd-around g-brd-white--hover g-bg-pink g-color-white text-center g-py-60 g-px-30"
                   href="{{route('sellerMajorList')}}">
                    <span class="u-icon-v2  g-mb-25">
                        <i class="icon-layers"></i>
                    </span>
                    <h3 class="h4 g-font-weight-600 mb-30">پنل صفحه ها</h3>
                </a>
                <!-- End Icon Blocks -->
            </div>
            <div class="col-lg-4 g-mb-30">
                <!-- Icon Blocks -->
                <a class="d-block g-text-underline--none--hover g-brd-around g-brd-white--hover g-bg-teal g-color-white text-center g-py-60 g-px-30"
                   href="{{route('customerList')}}">
                    <span class="u-icon-v2  g-mb-25">
                    <i class="icon-user-female"></i>
                    </span>
                    <h3 class="h4 g-font-weight-600 mb-30">پنل بازدیدکنندگان</h3>
                </a>
                <!-- End Icon Blocks -->
            </div>
            <div class="col-lg-4 g-mb-30">
                <!-- Icon Blocks -->
                <a class="d-block g-text-underline--none--hover g-brd-around g-brd-white--hover g-bg-pink g-color-white text-center g-py-60 g-px-30"
                   href="{{route('adminRegister')}}">
                    <span class="u-icon-v2  g-mb-25">
                    <i class="icon-user-follow"></i>
                    </span>
                    <h3 class="h4 g-font-weight-600 mb-30">ثبت نام پرسنل</h3>
                </a>
                <!-- End Icon Blocks -->
            </div>
            <div class="col-lg-4 g-mb-30">
                <!-- Icon Blocks -->
                <a class="d-block g-text-underline--none--hover g-brd-around g-brd-white--hover g-bg-teal g-color-white text-center g-py-60 g-px-30"
                   href="{{route('sellerMajorAdList')}}">
                    <span class="u-icon-v2  g-mb-25">
                    <i class="fa fa-bullhorn"></i>
                    </span>
                    <h3 class="h4 g-font-weight-600 mb-30">کانون انعکاس</h3>
                </a>
                <!-- End Icon Blocks -->
            </div>
            <div class="col-lg-4 g-mb-30">
                <!-- Icon Blocks -->
                <a class="d-block g-text-underline--none--hover g-brd-around g-brd-white--hover g-bg-pink g-color-white text-center g-py-60 g-px-30"
                   href="{{route('adminInvitation')}}">
                    <span class="u-icon-v2  g-mb-25">
                    <i class="icon-speech"></i>
                    </span>
                    <h3 class="h4 g-font-weight-600 mb-30">دعوت نامه</h3>
                </a>
                <!-- End Icon Blocks -->
            </div>
            <div class="col-lg-4 g-mb-30">
                <!-- Icon Blocks -->
                <a class="d-block g-text-underline--none--hover g-brd-around g-brd-white--hover g-bg-teal g-color-white text-center g-py-60 g-px-30"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();"
                   href="{{ route('adminLogout') }}">
                    <span class="u-icon-v2  g-mb-25">
                    <i class="icon-logout"></i>
                    </span>
                    <h3 class="h4 g-font-weight-600 mb-30">خروج</h3>
                </a>

                <form id="logout-form" action="{{route('adminLogout')}}" method="POST" style="display: none;">
                    @csrf
                </form>
                <!-- End Icon Blocks -->
            </div>
        </div>

        <!-- End Icon Blocks -->
    </div>
@endsection
