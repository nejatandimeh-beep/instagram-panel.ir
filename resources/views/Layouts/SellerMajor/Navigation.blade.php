@section('SellerMajorNavigation')
    <body>
    <header id="js-header" class="u-header u-header--static g-brd-bottom g-brd-gray-light-v4 g-mb-5">
        <div class="u-header__section u-header__section--light g-bg-white g-transition-0_3">
            <nav class="js-mega-menu hs-menu-initialized hs-menu-horizontal navbar navbar-toggleable-md">
                <div class="container g-px-0 customerNavigation" id="HeaderContainer">
                    <!-- Responsive Toggle Button -->
                    <button
                        class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0 g-pos-abs g-right-0"
                        type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar"
                        data-toggle="collapse" data-target="#navBar"
                        id="btnMenu">
                          <span class="hamburger hamburger--slider">
                            <span class="hamburger-box">
                              <span class="hamburger-inner"></span>
                            </span>
                          </span>
                    </button>
                    <!-- End Responsive Toggle Button -->

                    <!-- user logo -->
                    <a style="width: 80%" href="{{ url('/Seller-Major-Panel') }}" class="g-pt-10 navbar-brand overFlow-dots"
                       title="{{$_SESSION['userName']}}">
                        <span class="align-self-center">{{$_SESSION['userName']}}</span>
                    </a>

                    <!-- Navigation -->
                    <div
                        class="collapse navbar-collapse align-items-center flex-sm-row g-py-40 g-pb-0--lg g-px-15 g-px-0--lg g-pt-5--lg"
                        id="navBar">
                        <ul style="direction: rtl" class="navbar-nav g-font-weight-600 ml-auto p-0">
                            <li class="nav-item g-mx-20--lg">
                                <div style="position: relative">
                                    <a href="{{ route('sellerMajorMessages') }}"
                                       class="nav-link g-px-0 g-color-insta">
                                        <i class="g-font-size-20 g-font-weight-600 icon-paper-plane align-middle g-ml-5"></i>
                                        <span class="align-self-center">پیام ها</span>
                                    </a>
                                    <div style="position: absolute; top: -5px; right: -10px; width: 20px; height: 20px"
                                         class="{{$notificationMsg===0 ? 'd-none':''}} g-bg-red text-center rounded-circle">
                                        <span style="color: white !important;">{{$notificationMsg}}</span>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item g-mx-20--lg">
                                <a href="{{route('sellerMajorConnection')}}"
                                   class="nav-link g-px-0 g-color-primary--hover">
                                    <i class="g-font-size-20 g-font-weight-600 icon-earphones-alt  align-middle g-ml-5"></i>
                                    <span class="align-self-center">پشتیبانی</span>
                                </a>
                            </li>

                            <li class="nav-item g-mx-20--lg">
                                <a href="{{route('sellerMajorRegulation')}}"
                                   class="nav-link g-px-0 g-color-primary--hover">
                                    <i class="g-font-size-20 g-font-weight-600 icon-book-open align-middle g-ml-5"></i>
                                    <span class="align-self-center">قوانین</span>
                                </a>
                            </li>

                            <li class="nav-item g-mx-20--lg">
                                <a href="{{route('requestSellerMajorMobile',['source'=>'forget'])}}"
                                   class="nav-link g-px-0 g-color-primary--hover">
                                    <i class="g-font-size-20 g-font-weight-600 icon-lock align-middle g-ml-5"></i>
                                    <span class="align-self-center">تغییر رمز</span>
                                </a>
                            </li>

                            <li class="nav-item g-mx-20--lg">
                                <a href="#" onclick="document.getElementById('logoutForm').submit();"
                                   class="nav-link g-px-0 g-color-primary--hover">
                                    <i class="g-font-size-20 g-font-weight-600 icon-logout align-middle g-ml-5"></i>
                                    <span class="align-self-center">خروج</span>
                                </a>
                                <form id="logoutForm" action="{{route('sellerMajorLogout')}}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
@endsection
