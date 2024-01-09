@include('Layouts.BaseCssLink')
@include('Layouts.CustomerNavigation')
@include('Layouts.BaseJsLink')
@include('Layouts.BaseJsFunction')
@switch($_SERVER['REQUEST_URI'])
    @case(strpos($_SERVER['REQUEST_URI'],'/Feed'))
    @case('/Customer-SellerMajor-Reactions')
    @case('/Customer-Following-SellerMajor')
    @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Messages'))
    @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Panel'))
    @case('/Customer-SellerMajor-Saved')
    @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Search'))
    @include('Layouts.CustomerFeedJsFunctions')
    @include('Layouts.CustomerFeedFooter')
    @break
    @case(strpos($_SERVER['REQUEST_URI'],'/Customer-Profile'))
    @include('Layouts.CustomerFeedFooter')
    @include('Layouts.CustomerJsFunctions')
    @break
    @default
    @include('Layouts.CustomerFooter')
    @include('Layouts.CustomerJsFunctions')
@endswitch

@yield('BaseCssLink')
@switch($_SERVER['REQUEST_URI'])
    @case(strpos($_SERVER['REQUEST_URI'],'/Feed'))
    @case('/Customer-SellerMajor-Reactions')
    @case('/Customer-Following-SellerMajor')
    @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Panel'))
    @case('/Customer-SellerMajor-Saved')
    @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Search'))
    <link rel="stylesheet" href="{{ asset('assets/vendor/icon-hs/style.css') }}">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{ asset('owlCarouselAssets/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('owlCarouselAssets/owlcarousel/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.css') }}">
    @break
    @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Messages'))
    <link rel="stylesheet" href="{{ asset('assets/vendor/fancybox/jquery.fancybox.min.css') }}">
    @endswitch
    </head>
    @yield('CustomerNavigation')
    @yield('Content')
    @if(strpos($_SERVER['REQUEST_URI'],'/Feed') || strpos($_SERVER['REQUEST_URI'],'/Customer-Profile'))
        @yield('CustomerFeedFooter')
    @else
        @yield('CustomerFooter')
    @endif
    @yield('BaseJsLinks')
    {{--{{dd($_SERVER['REQUEST_URI'])}}--}}
    @switch($_SERVER['REQUEST_URI'])
        @case(strpos($_SERVER['REQUEST_URI'],'/Customer-Profile'))
        <!--Side Menu-->
        <script
            src="{{ asset('assets/vendor/revolution-slider/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
        <script
            src="{{ asset('assets/vendor/revolution-slider/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
        <!--Modal and cropper-->
        <script src="{{ asset('assets/js/cropper.js') }}"></script>
        <script src="{{ asset('assets/vendor/custombox/custombox.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        @break
        @case(strpos($_SERVER['REQUEST_URI'],'/Feed'))
        @case('/Customer-SellerMajor-Reactions')
        @case('/Customer-Following-SellerMajor')
        @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Panel'))
        @case('/Customer-SellerMajor-Saved')
        @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Search'))
        <script src="{{ asset('assets/js/cropper.js') }}"></script>
        <script src="{{ asset('assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        <script src="{{ asset('owlCarouselAssets/owlcarousel/owl.carousel.js') }}"></script>
        <script src="{{ asset('owlCarouselAssets/vendors/highlight.js') }}"></script>
        <script src="{{ asset('owlCarouselAssets/js/app.js') }}"></script>
        <script src="{{ asset('js/swiper-bundle.js') }}"></script>
        @break
        @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Messages'))
        <script src="{{ asset('assets/vendor/fancybox/jquery.fancybox.min.js') }}"></script>
        @break
        @endswitch
        </body>
        @switch($_SERVER['REQUEST_URI'])
            @case(strpos($_SERVER['REQUEST_URI'],'/Feed'))
            @case('/Customer-SellerMajor-Reactions')
            @case('/Customer-SellerMajor-Reactions')
            @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Messages'))
            @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Panel'))
            @case('/Customer-Following-SellerMajor')
            @case('/Customer-SellerMajor-Saved')
            @case(strpos($_SERVER['REQUEST_URI'],'/Customer-SellerMajor-Search'))
            @yield('FeedJsFunction')
            @break
            @default
            @yield('CustomerJsFunction')
        @endswitch
        @yield('BaseJsFunction')
