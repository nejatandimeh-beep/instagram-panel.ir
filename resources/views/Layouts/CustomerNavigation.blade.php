@section('CustomerNavigation')
    <body class="customerPanel">
    {{--    <div id="load" class="load"></div>--}}
    <span id="loginAlert" class="d-none">{{ (isset(Auth::user()->id)) ? 'login':'logout' }}</span>
    <div class="container g-brd-bottom g-brd-gray-light-v5 g-py-10 customerNavigation" id="HeaderContainer">
        <!-- Search and Login -->
        <div class="d-flex w-100 justify-content-between">
            <a style="width: 100px" href="{{route('Master')}}" class="g-ml-10 g-ml-0--lg">
                <img style="height: 50px" class="img-fluid" loading="lazy"
                     src="{{asset('img/Logo/logo.png')}}"
                     alt="">
            </a>
            <div class="align-self-center">
                <a href="{{route('Master')}}" id="login"
                   class="d-flex nav-link g-color-gray-dark-v2 m-0 g-text-underline--none--hover p-0 g-color-primary--hover loginBtn">
                    <h6 class="align-self-center m-0">دستیار اینستاگرام</h6>
                </a>
            </div>
        </div>
    </div>
@endsection
