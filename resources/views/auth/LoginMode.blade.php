@extends('Layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header text-right">ورود یا ایجاد حساب کاربری</h5>

                    <div class="card-body">
                        <div class="text-center g-pa-20">
                            <p style="direction: rtl" class="text-center mx-auto col-12 g-px-0 g-mb-15 g-px-20--lg">کاربر گرانقدر قبل از ادامه کار، ابتدا باید وارد سایت شوید. اگر قبلا ثبت نام کرده اید دکمه ورود را فشار دهید یا در غیر اینصورت ثبت نام کنید.</p>
                            <a href="{{ url('/request-customer-mobile','register') }}" class="btn btn-xl rounded-0 u-btn-insta force-col-12 u-btn-content g-font-weight-600 g-letter-spacing-0_5 text-uppercase g-brd-2 g-mr-10 g-mb-15">
                            <span class="text-center">
                              ثبت نام
                              <span class="d-block g-font-size-11">قبلا ثبت نام نکرده ام</span>
                            </span>
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-xl u-btn-insta u-btn-content rounded-0 g-font-weight-600 force-col-12 g-letter-spacing-0_5 text-uppercase g-brd-2 g-mr-10 g-mb-15">
                            <span class="text-center">
                              ورود
                              <span class="d-block g-font-size-11">قبلا ثبت نام کرده ام</span>
                            </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
