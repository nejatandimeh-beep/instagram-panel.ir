@section('AdminSellerMajorNavigation')
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
                    <a style="width: 80%" href="{{ route('adminSellerMajorPanel',$_SESSION['userProfileID'])}}" class="navbar-brand overFlow-dots"
                       title="{{$_SESSION['userName']}}">
                        <span class="align-self-center">{{$_SESSION['userName']}}</span>
                    </a>

                    <!-- Navigation -->
                    <div
                        class="collapse navbar-collapse align-items-center flex-sm-row g-pt-10 g-pb-20 g-pb-0--lg g-pt-5--lg"
                        id="navBar">
                        <ul style="direction: rtl" class="navbar-nav g-font-weight-600 ml-auto p-0">
                            <li class="nav-item g-mx-20--lg">
                                <a href="{{ route('adminSellerMajorMessages',$_SESSION['userProfileID']) }}"
                                   class="nav-link g-px-0 g-color-primary--hover">
                                    <i class="g-font-size-16 g-font-weight-600 {{isset($message[0]) ? 'g-color-primary':''}} icon-bubbles align-middle g-ml-5"></i>
                                    <span class="align-self-center">پیام ها</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
@endsection
