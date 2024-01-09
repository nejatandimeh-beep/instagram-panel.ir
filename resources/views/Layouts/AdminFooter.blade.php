@section('AdminFooter')
    <footer class="g-bg-black-opacity-0_9 g-color-white-opacity-0_8 text-center g-pt-60 g-pb-40">
        <!-- Footer Content -->
        <div class="container">
            <div class="rowSeller">
                <div class="col-sm-6 col-lg g-mb-30 g-mb-0--lg">
                    <h6 class="g-font-weight-600 g-mb-20"><a class="g-color-white-opacity-0_8 g-color-primary--hover g-text-underline--none--hover" href="{{route('administratorMaster')}}">پیشخوان</a></h6>
                </div>

                <!-- Footer Content -->
                <div class="col-sm-6 col-lg g-mb-30 g-mb-0--lg">
                    <h6 class="g-font-weight-600 g-mb-20"><a class="g-color-white-opacity-0_8 g-color-primary--hover g-text-underline--none--hover" href="{{route('sellerMajorList')}}">صفحه ها</a></h6>
                </div>
                <!-- End Footer Content -->

                <!-- Footer Content -->
                <div class="col-sm-6 col-lg g-mb-30 g-mb-0--lg">
                    <h6 class="g-font-weight-600 g-mb-20 g-mb-0--lg"><a class="g-color-white-opacity-0_8 g-color-primary--hover g-text-underline--none--hover" href="{{route('customerList')}}">بازدیدکنندگان</a></h6>
                </div>
                <!-- End Footer Content -->

                <div class="col-sm-6 col-lg g-mb-30 g-mb-0--lg">
                    <h6 class="g-font-weight-600 g-mb-20 g-mb-0--lg"><a class="g-color-white-opacity-0_8 g-color-primary--hover g-text-underline--none--hover" href="{{route('sellerMajorAdList')}}">کانون انعکاس</a></h6>
                </div>

                <div class="col-sm-6 col-lg g-mb-30 g-mb-0--lg">
                    <h6 class="g-font-weight-600 g-mb-20 g-mb-0--lg"><a class="g-color-white-opacity-0_8 g-color-primary--hover g-text-underline--none--hover" href="{{route('adminRegister')}}">ثبت نام پرسنل</a></h6>
                </div>

                <div class="col-sm-6 col-lg g-mb-30 g-mb-0--lg">
                    <h6 class="g-font-weight-600 g-mb-20 g-mb-0--lg"><a class="g-color-white-opacity-0_8 g-color-primary--hover g-text-underline--none--hover" href="{{route('adminInvitation')}}">دعوت نامه</a></h6>
                </div>
                <!-- End Footer Content -->
            </div>
        </div>
        <!-- End Footer Content -->
    </footer>
@endsection
