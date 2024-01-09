@extends('Layouts.SellerMajor.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header text-right">ورود به حساب کاربری</h5>
                    <div class="card-body">
                        <div class="text-center g-pa-20">
                            <p style="direction: rtl" class="text-center mx-auto col-12 g-px-0 g-mb-15 g-px-20--lg">از کدام سطح حساب کاربری استفاده می کنید؟</p>
                            <a href="{{ route('sellerLog') }}" class="btn btn-xl u-btn-bluegray u-btn-content rounded-0 g-font-weight-600 force-col-12 g-letter-spacing-0_5 text-uppercase g-brd-2 g-mr-10 g-mb-15">
                            <span class="text-center">
                              ورود حرفه ای
                              <span class="d-block g-font-size-11">حساب کاربری حرفه ای</span>
                            </span>
                            </a>
                            <a href="{{ route('sellerMajorLog') }}" class="btn btn-xl rounded-0 u-btn-bluegray force-col-12 u-btn-content g-font-weight-600 g-letter-spacing-0_5 text-uppercase g-brd-2 g-mr-10 g-mb-15">
                            <span class="text-center">
                              ورود ساده
                              <span class="d-block g-font-size-11">حساب کاربری ساده</span>
                            </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
