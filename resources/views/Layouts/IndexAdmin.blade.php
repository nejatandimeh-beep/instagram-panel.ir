@switch($_SERVER['REQUEST_URI'])
    @case(str_contains($_SERVER['REQUEST_URI'],'/Administrator-SellerMajor-Panel'))
    @case(str_contains($_SERVER['REQUEST_URI'],'/Administrator-SellerMajor-Message'))
    @case(str_contains($_SERVER['REQUEST_URI'],'/Administrator-SellerMajor-Reactions'))
    @include('Layouts.BaseCssLink')
    @include('Layouts.AdminSellerMajorNavigation')
    @include('Layouts.AdminSellerMajorFooter')
    @include('Layouts.BaseJsLink')
    @include('Layouts.BaseJsFunction')
    @include('Layouts.AdminJsFunctionsSellerMajorPanel')
    <link rel="stylesheet" href="{{ asset('assets/vendor/icon-hs/style.css') }}">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{ asset('owlCarouselAssets/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('owlCarouselAssets/owlcarousel/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fancybox/jquery.fancybox.min.css') }}">
    @break
    @default
    @include('Layouts.BaseCssLink')
    @include('Layouts.AdminNavigation')
    @include('Layouts.AdminFooter')
    @include('Layouts.BaseJsLink')
    @include('Layouts.BaseJsFunction')
    @include('Layouts.AdminJsFunctions')
@endswitch

@yield('BaseCssLink')
</head>
@switch($_SERVER['REQUEST_URI'])
    @case(str_contains($_SERVER['REQUEST_URI'],'/Administrator-SellerMajor-Panel'))
    @case(str_contains($_SERVER['REQUEST_URI'],'/Administrator-SellerMajor-Message'))
    @case(str_contains($_SERVER['REQUEST_URI'],'/Administrator-SellerMajor-Reactions'))
    @yield('AdminSellerMajorNavigation')
    @yield('Content')
    @yield('AdminSellerMajorFooter')
    @yield('BaseJsLinks')
    @yield('BaseJsFunction')
    @yield('SellerMajorPanelJsFunction')
    <script src="{{ asset('assets/js/cropper.js') }}"></script>
    <script src="{{ asset('assets/vendor/custombox/custombox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/hs.modal-window.js') }}"></script>
    <script src="{{ asset('owlCarouselAssets/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('owlCarouselAssets/vendors/highlight.js') }}"></script>
    <script src="{{ asset('owlCarouselAssets/js/app.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/fancybox/jquery.fancybox.min.js') }}"></script>
    @break
    @default
    @yield('AdminNavigation')
    @yield('Content')
    @yield('AdminFooter')
    @yield('BaseJsLinks')
    @yield('BaseJsFunction')
    @yield('AdminJsFunction')
@endswitch
