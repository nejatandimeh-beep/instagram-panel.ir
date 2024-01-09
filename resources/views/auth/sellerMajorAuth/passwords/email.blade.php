@extends('Layouts.appSeller')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header text-right">تنظیم مجدد رمز (فروشنده)</h5>
                <div class="card-body">
                    @if (session('status'))
                        <div style="direction: rtl;" class="g-mt-40">
                            <h3 class="g-color-primary text-center">وضعیت ارسال</h3>
                            <h6 class="text-center">لینک تنظیم مجدد رمز به ایمیل شما ارسال شد. لطفا به ایمیل خود سر بزنید تا به صفحه تغییر رمز هدایت شوید.</h6>
                        </div>
                        <div>
                            <svg id="checkMark" class="checkmark g-my-30"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="checkmark__circle" cx="26" cy="26" r="25"
                                        fill="none"/>
                                <path class="checkmark__check" fill="none"
                                      d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>
                    @else
                    <form method="POST" action="{{route('sellers.sendResetLink')}}" style="direction: rtl" novalidate>
                        @csrf

                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-right text-md-left g-font-size-16">ایمیل</label>

                            <div class="col-md-6">
                                <input id="email"
                                       type="email"
                                       class="form-control @error('email') is-invalid @enderror input-outline-primary rounded-0 g-font-size-18 g-font-size-16--md"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row g-mb-60--lg g-mt-30">
                            <div class="col-md-10 text-left">
                                <button type="submit" class="btn u-btn-primary rounded-0 g-font-size-16">
                                    ارسال لینک تنظیم مجدد
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
