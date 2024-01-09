@extends('Layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header text-right">ثبت نام در سایت</h5>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" style="direction: rtl" novalidate>
                            @csrf
                            <div class="form-group row g-mb-15">
                                <label
                                    class="col-sm-4 col-form-label text-right text-md-left g-font-size-16">نام
                                    کاربری</label>
                                <div class="col-md-6">
                                    <div style="position: relative" class="input-group g-brd-primary--focus">
                                        <div style="display: none; position: absolute; z-index: 100; top: 10px; right: 10px" class="userNameSpinner">
                                            <i class="fa fa-spin fa-spinner g-font-size-16"></i>
                                        </div>
                                        <input style="direction: ltr" id="user-name"
                                               class="form-control form-control-md rounded-0 g-bg-gray-light-v5 g-font-size-16 g-brd-red need text-left"
                                               type="text"
                                               value=""
                                               autofocus
                                               autocomplete="off"
                                               spellcheck="false"
                                               oninput="checkUserName($(this).val())"
                                               tabindex="0"
                                               name="name"
                                               maxlength="50"
                                               onblur=" if($(this).val().length>1 && $('.checkUserAlarm').is(':hidden') && $('.checkUserAlarm2').is(':hidden')) $(this).removeClass('g-brd-red'); else $(this).addClass('g-brd-red');">
                                    </div>
                                    <div style="display: none" class="text-right checkUserAlarm">
                                        <small class="g-color-red">نام کاربری موجود است</small>
                                    </div>
                                    <div style="display: none" class="text-right checkUserAlarm2">
                                        <small class="g-color-red">نام کاربری مجاز نیست</small>
                                    </div>
                                    <div style="display: none" class="text-right checkUserAlarm3">
                                        <small class="g-color-red">نام کاربری باید بیشتر از 1 حرف باشد</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row g-mb-0">
                                <label for="password"
                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">رمز</label>

                                <div class="col-md-6">
                                    <input style="direction:ltr;"
                                           id="password"
                                           type="password"
                                           class="form-control @error('password') is-invalid @enderror input-outline-insta rounded-0 g-font-size-18 g-font-size-16--md text-left pass"
                                           name="password"
                                           autofocus
                                           value="{{ old('password') }}"
                                           required
                                           tabindex="1"
                                           autocomplete="off">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row g-mb-0">
                                <label for="password-confirm" class="col-md-4 col-form-label g-py-1 text-md-left"></label>
                                <div id="passwordHint"
                                     class="col-md-6">
                                    <div id="length" class="d-inline-block g-bg-red g-mb-5 g-mb-0--lg g-mt-5 align-top g-py-1 col-2"></div>
                                    <div id="number" class="d-inline-block g-bg-red g-mb-5 g-mb-0--lg align-top g-mt-5 g-py-1 col-2"></div>
                                    <div id="uppercase" class="d-inline-block g-bg-red g-mb-5 g-mb-0--lg align-top g-mt-5 g-py-1 col-2"></div>
                                    <div id="lowercase" class="d-inline-block g-bg-red g-mb-5 g-mb-0--lg align-top g-mt-5 g-py-1 col-2"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">تکرار
                                    رمز</label>

                                <div class="col-md-6">
                                    <input id="password-confirm"
                                           type="password"
                                           class="form-control input-outline-insta rounded-0 g-font-size-18 g-font-size-16--md text-left pass"
                                           name="password_confirmation"
                                           tabindex="2"
                                           required
                                           autocomplete="off">
                                </div>
                            </div>

                            <div style="direction: rtl" class="form-group row g-mt-30">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-left"></label>
                                <div class="col-lg-6 text-right g-px-15">
                                    <small class="text-muted g-font-size-12">* رمز عبور باید شامل اعداد، حروف بزرگ، حروف کوچک و بیشتر از 8 کاراکتر باشد.</small>
                                </div>
                            </div>

                            <input type="hidden" value="{{Session::get('mobile')}}" name="mobile">

                            <div class="form-group row g-mb-60--lg g-mt-20">
                                <div class="col-md-10 text-left">
                                    <button type="button" class="force-col-12 btn u-btn-insta rounded-0 g-font-size-16" id="save" onclick="checkPass()">
                                        ثبت نام
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
