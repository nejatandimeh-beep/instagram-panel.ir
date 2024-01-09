@include('Layouts.BaseCssLink')
@include('Layouts.SellerMajor.Navigation')
@include('Layouts.SellerMajor.Footer')
@include('Layouts.BaseJsLink')
@include('Layouts.BaseJsFunction')
@include('Layouts.SellerMajor.JsFunctions')

@yield('BaseCssLink')
@switch($_SERVER['REQUEST_URI'])
    @case('/Seller-Major-Panel')
    @case('/Seller-Major-addPostForm')
    <link rel="stylesheet" href="{{ asset('assets/vendor/icon-hs/style.css') }}">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{ asset('owlCarouselAssets/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('owlCarouselAssets/owlcarousel/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.css') }}">
    @break
    @case('/Seller-Major-addPostForm')
    <link rel="stylesheet" href="{{ asset('assets/vendor/icon-hs/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.css') }}">
    @break
    @case('/Seller-Major-Messages-Detail')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fancybox/jquery.fancybox.min.css') }}">
    @break
    @endswitch

    </head>
    @yield('SellerMajorNavigation')
    @yield('Content')
    @yield('SellerMajorFooter')
    @yield('BaseJsLinks')
    @switch($_SERVER['REQUEST_URI'])
        @case('/Seller-Major-Panel')
        <!--Modal and cropper-->
        <script src="{{ asset('assets/js/cropper.js') }}"></script>
        <script src="{{ asset('assets/vendor/custombox/custombox.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        <script src="{{ asset('owlCarouselAssets/owlcarousel/owl.carousel.js') }}"></script>
        <script src="{{ asset('owlCarouselAssets/vendors/highlight.js') }}"></script>
        <script src="{{ asset('owlCarouselAssets/js/app.js') }}"></script>
        <script src="{{ asset('js/swiper-bundle.js') }}"></script>
        @break
        @case('/Seller-Major-addPostForm')
        <script src="{{ asset('assets/js/cropper.js') }}"></script>
        <script src="{{ asset('js/swiper-bundle.js') }}"></script>
        @break
        @case('/Seller-Major-Messages-Detail')
        <script src="{{ asset('assets/js/components/hs.popup.js') }}"></script>
        <script src="{{ asset('assets/vendor/fancybox/jquery.fancybox.min.js') }}"></script>
        @break
        @endswitch
        </body>
        @yield('SellerMajorJsFunction')
        @yield('BaseJsFunction')
