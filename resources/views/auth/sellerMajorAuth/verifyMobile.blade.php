@extends('Layouts.SellerMajor.app')
@section('content')
    <div class="content">
        <div class="links">
            <form action="{{route('verifySellerMajorMobile')}}" method="post" enctype="multipart/form-data">
                <div style="direction: rtl" class="container">
                    <div class="col-lg-6 col-12 mx-auto">
                        <div class="form-group row">
                            <label for="mobile"
                                   class="col-md-3 col-form-label text-right text-md-left g-font-size-16">کد
                                ارسالی</label>

                            <div class="col-md-9">
                                <input style="direction: ltr"
                                    type="number"
                                    class="form-control text-left input-outline-insta rounded-0 g-font-size-18 g-font-size-16--md forceEnglishNumber"
                                    name="verifyCode"
                                    pattern="\d*"
                                    placeholder="فقط اعداد انگلیسی"
                                    onKeyPress="if(this.value.length==10) return false; $('#alarmVerify').hide();"
                                    required autocomplete="off"
                                    autofocus>
                                <span class="g-color-red small g-mt-5" role="alert">
                                    <strong style="display: none" id="alarmVerify" class="text-left">کد وارد شده اشتباه است!</strong>
                                </span>
                            </div>
                        </div>
                        <div id="timeDiv">زمان <span id="time">{{ (isset($timer) ? '':'02:00') }}</span> دقیقه!</div>
                        <span id="timer" class="d-none">{{isset($timer) ? $timer:120}}</span>
                        <a style="display: none" href="" id="try" class="g-color-insta">ارسال مجدد</a>

                        <div style="direction: ltr" class="form-group row g-mb-60--lg g-mt-20">
                            <div class="col-md-10 text-left">
                                <button id="submitText"
                                        type="submit"
                                        class="btn u-btn-insta rounded-0 g-font-size-16">
                                    ادامه
                                </button>
                                <button id="waitingSubmit" style="display:none; direction: rtl" type="button" disabled="disabled"
                                        class="btn u-btn-primary rounded-0 g-font-size-16">
                                                <span
                                                    class="m-0 g-color-white">منتظر بمانید..</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $('form').on('submit',function (e) {
            e.preventDefault();
            $('#submitText').hide();
            $('#waitingSubmit').show();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'Post',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data)
                    if(data==='false'){
                        $('#alarmVerify').show();
                        $('#submitText').show();
                        $('#waitingSubmit').hide();
                    } else {
                        if(data[1]==='register'){
                            window.location='/register/sellerMajor';
                        } else {
                            window.location='/reset/sellerMajor/password';
                        }
                    }
                }
            })
        })

        function startTimer(duration, display) {
            let minutes, seconds, interval;
            interval = setInterval(function () {
                minutes = parseInt(duration / 60);
                seconds = parseInt(duration % 60);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--duration < 0) {
                    $('#try').css('display', 'block');
                    $('#timeDiv').css('color', 'red');
                    clearInterval(interval);
                }
            }, 1000);
        }

        window.onload = function () {
            let display = document.querySelector('#time');
            startTimer(parseInt($('#timer').text()), display);
        };
    </script>
@endsection
