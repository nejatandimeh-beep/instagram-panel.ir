@section('AdminSellerMajorFooter')
    <footer style="position: fixed; bottom: 0; z-index: 100" class="w-100 g-bg-white text-center g-brd-top g-brd-gray-light-v4">
        <!-- Footer Content -->
        <div class="container p-0">
            <ul class="row no-gutters list-inline g-mb-0">
                <li class="col list-inline-item g-mr-0">
                    <a href="{{ route('adminSellerMajorReaction',$_SESSION['userProfileID']) }}" class="nav-link g-px-0 g-color-primary--hover">
                        <i id="voteMenu" class="g-font-size-22 g-font-weight-600 icon-heart align-middle g-ml-5"></i>
                    </a>
                </li>
                <li class="col list-inline-item g-mr-0">
                    <!-- user logo -->
                    <a href="{{ route('adminSellerMajorPanel',$_SESSION['userProfileID']) }}" class="nav-link overFlow-dots" title="{{$_SESSION['userName']}}">
                        <img id="profileMenu" style="width: 25px" class="g-rounded-50x align-middle g-ml-5" alt="miss" src="{{asset($_SESSION['userProfileImg'].'/profileImg.jpg')}}">
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Footer Content -->
    </footer>
@endsection
