@extends('Layouts.SellerMajor.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header text-right">{{($source==='register'?'ثبت نام در سایت':'درخواست رمز جدید')}}</h5>
                    <div class="card-body">
                        <form method="GET" action="{{ route('checkMobileSellerMajor') }}" style="direction: rtl"
                              novalidate>
                            @csrf
                            <input class="d-none" type="text" name="source" value="{{$source}}">
                            <div class="form-group row">
                                <label for="mobile"
                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">شماره
                                    موبایل</label>

                                <div class="col-md-6">
                                    <input style="direction: ltr"
                                           id="mobile"
                                           type="number"
                                           class="form-control @error('mobile') is-invalid @enderror @if(session()->has('message')) is-invalid @endif input-outline-insta rounded-0 g-font-size-18 g-font-size-16--md forceEnglishNumber"
                                           name="mobile"
                                           pattern="\d*"
                                           placeholder="فقط اعداد انگلیسی"
                                           onKeyPress="if(this.value.length===11) return false;"
                                           value="{{ old('mobile') }}"
                                           required autocomplete="off"
                                           autofocus>

                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    @if (session()->has('message'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{!! Session::get('message') !!}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row g-mb-60--lg g-mt-20">
                                <div class="col-md-10 text-left">
                                    <button  id="submitText"
                                             type="submit"
                                            onclick="$('#submitText').hide(); $('#waitingSubmit').show();"
                                            onsubmit="$(this).prop('disabled',true)"
                                            class="btn u-btn-insta rounded-0 g-font-size-16">
                                      ارسال کد
                                    </button>
                                    <button id="waitingSubmit" style="display:none; direction: rtl" type="button" disabled="disabled"
                                            class="btn u-btn-primary rounded-0 g-font-size-16">
                                                <span
                                                    class="m-0 g-color-white">منتظر بمانید..</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
