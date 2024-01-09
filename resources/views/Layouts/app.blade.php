<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TanaStyle') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/FarsiType.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myStyle.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/unify_1.css') }}">

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body>
<div id="currentPage" class="d-none">{{$_SERVER['REQUEST_URI']}}</div>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container text-right g-py-5">
            <a style="width: 100px" href="{{route('Master')}}" class="text-left">
                <img style="height: 50px" class="img-fluid"
                     src="{{asset('img/Logo/logo.png')}}"
                     alt="">
            </a>
            <button style="border: none !important;" class="navbar-toggler rounded-0" type="button"
                    data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul id="customerNavigation" class="navbar-nav ml-auto p-0" style="direction: rtl">
                    <li class="nav-item">
                        <a class="nav-link g-mt-20 g-mt-0--lg g-color-primary--hover" id="homePage"
                           href="{{ url('/') }}">صفحه
                            نخست</a>
                    </li>

                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link g-color-primary--hover" href="{{ route('login') }}">ورود</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link g-color-primary--hover"
                                   href="{{ url('/request-customer-mobile','register') }}">ثبت نام</a>
                            </li>
                        @endif
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
<script>
    $(".forceEnglishNumber").keypress(function (event) {
        let ew = event.which;
        if (48 <= ew && ew <= 57)
            return true;
        return false;
    });

    // change persian num to english num
    let persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g],
        arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g],
        fixNumbers = function (str) {
            if (typeof str === 'string') {
                for (let i = 0; i < 10; i++) {
                    str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
                }
            }
            return str;
        };
    $('.pass').on('input', function () {
        $(this).val(fixNumbers($(this).val()));
    })


    $(document).on('ready', function () {
        if ($('#password').length > 0) {
            let myInput = $('#password'),
                letter = $("#lowercase"),
                capital = $("#uppercase"),
                number = $("#number"),
                length = $("#length");

            myInput.on('keyup', function () {
                // Validate lowercase letters
                let lowerCaseLetters = /[a-z]/g;
                if (myInput.val().match(lowerCaseLetters)) {
                    letter.removeClass("g-bg-red");
                    letter.addClass("g-bg-primary");
                } else {
                    letter.removeClass("g-bg-primary");
                    letter.addClass("g-bg-red");
                }

                // Validate capital letters
                let upperCaseLetters = /[A-Z]/g;
                if (myInput.val().match(upperCaseLetters)) {
                    capital.removeClass("g-bg-red");
                    capital.addClass("g-bg-primary");
                } else {
                    capital.removeClass("g-bg-primary");
                    capital.addClass("g-bg-red");
                }

                // Validate numbers
                let numbers = /[0-9]/g;
                if (myInput.val().match(numbers)) {
                    number.removeClass("g-bg-red");
                    number.addClass("g-bg-primary");
                } else {
                    number.removeClass("g-bg-primary");
                    number.addClass("g-bg-red");
                }

                // Validate length
                if (myInput.val().length >= 8) {
                    length.removeClass("g-bg-red");
                    length.addClass("g-bg-primary");
                } else {
                    length.removeClass("g-bg-primary");
                    length.addClass("g-bg-red");
                }
            });
        }
        //-------------------------
        if ($('#currentPage').text() === '/change-seller-password') {
            $('#homePage').hide();
        } else {
            $('#sellerProfile').hide();
        }
    });

    function checkPass() {
        let name=$('#user-name'),myInput = $('#password'),
            letter = $("#lowercase"),
            capital = $("#uppercase"),
            number = $("#number"),
            length = $("#length");

        if(!name.hasClass('g-brd-red')){
            if (letter.hasClass('g-bg-red') || capital.hasClass('g-bg-red') || number.hasClass('g-bg-red') || length.hasClass('g-bg-red')) {
                alert('لطفا قواعد رمزگذاری را رعایت کنید.');
            } else {
                if (myInput.val() === $('#password-confirm').val()) {
                    $('#submitText').hide();
                    $('#waitingSubmit').hide();
                    $('#save').prop('disabled', true);
                    $('form').submit();
                } else {
                    alert('رمز و تکرار رمز یکسان نیستند.')
                }
            }
        } else {
            alert('نام کاربری مجاز نیست')
        }
    }

    function checkUserName(userName) {
        $('.checkUserAlarm').hide();
        $('.checkUserAlarm2').hide();
        $('.checkUserAlarm3').hide();
        let re = new RegExp(/^[a-z\d\._\s]+$/i),
            p = new RegExp(/^[\u0600-\u06FF\s]+$/),
            result = new RegExp(re.source + "|" + p.source);
        if (userName !== '') {
            if (result.test(userName)) {
                $.ajax({
                    url: '/Customer-checkUserName/' + userName,
                    type: 'GET',
                    async: false,
                    beforeSend: function () {
                        $('.checkUserAlarm').hide();
                        $('.checkUserAlarm2').hide();
                        $('.checkUserAlarm3').hide();
                        $('.userNameSpinner').show();
                    },
                    success: function (data) {
                        if (data === 'exist') {
                            $('.checkUserAlarm').show();
                            $('#user-name').addClass('g-brd-red');
                        } else {
                            if (userName.length > 1) {
                                $('#user-name').removeClass('g-brd-red');
                            } else {
                                $('.checkUserAlarm3').show();
                                $('#user-name').addClass('g-brd-red');
                            }
                        }
                        $('.userNameSpinner').hide();
                    }
                });
            } else {
                $('.checkUserAlarm2').show();
                $('#user-name').addClass('g-brd-red');
            }
        }
    }

    $('#user-name').on('keypress', function (e) {
        if (e.which === 32)
            return false;
    })
</script>
</html>

