@section('SellerMajorFooter')
    <footer style="position: fixed; bottom: 0; z-index: 100" class="w-100 g-bg-white text-center g-brd-top g-brd-gray-light-v4">
        <!-- Footer Content -->
        <div class="container p-0">
            <ul class="row no-gutters list-inline g-mb-0">
                <li class="col list-inline-item g-mr-0 g-pt-2">
                    <div style="position: relative">
                        <a href="{{ url('/Seller-Major-Reactions') }}" id="login"
                           class="nav-link g-px-0 g-color-primary--hover">
                            {{--                                @if(Auth::user()->name===null || Auth::user()->name==='') {{'(کاربر'.Auth::user()->id.') '.Auth::user()->Mobile}} @else  {{Auth::user()->name}} @endif--}}

                            <i id="voteMenu" class="g-font-size-25 g-font-weight-600 icon-heart align-middle g-ml-5"></i>
                        </a>
                        <div style="position: absolute; top: -5px; right: 32%; width: 20px; height: 20px" class="{{$notification>0 || $notificationLike>0|| $notificationEventLike>0? '':'d-none'}} g-bg-red text-center rounded-circle">
                            <span style="color: white !important;">{{$notification+$notificationLike+$notificationEventLike}}</span>
                        </div>
                    </div>
                </li>
                <li class="col list-inline-item g-mr-0 g-pt-2">
                    <a href="{{ route('sellerMajorAddPostForm') }}" class="nav-link g-px-0 g-color-primary--hover">
                        <i class="g-font-size-25 g-font-weight-600 icon-plus align-middle g-ml-5"></i>
                    </a>
                </li>
                <li class="col list-inline-item g-mr-0">
                    <!-- user logo -->
                    <a href="{{ url('/Seller-Major-Panel') }}" class="nav-link overFlow-dots" title="{{$_SESSION['userName']}}">
                        <img id="profileMenu" style="width: 30px" class="g-rounded-50x g-brd-gray-dark-v2 align-middle g-brd-1 g-ml-5" alt="miss" src="{{$_SESSION['userProfileImg']=='img/SellerMajorProfileImage/Default/icon.jpg'?asset($_SESSION['userProfileImg']):asset($_SESSION['userProfileImg']).'/profileImg.jpg?'.date('Y-m-d H:i:s')}}">
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Footer Content -->
    </footer>
@endsection
