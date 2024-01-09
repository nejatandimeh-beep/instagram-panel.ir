@extends('Layouts.appAdmin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header text-right">ثبت نام کارمندان</h5>

                    <div class="card-body">
                        <form method="POST" action="{{ route('adminSave') }}" style="direction: rtl" novalidate>
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">نام</label>

                                <div class="col-md-6">
                                    <input id="name"
                                           type="text"
                                           class="form-control @error('name') is-invalid @enderror input-outline-primary rounded-0 g-font-size-18 g-font-size-16--md"
                                           name="name"
                                           placeholder="الزاما فارسی"
                                           {{--                                           lang="fa"--}}
                                           onkeyup="if (!(/^[\u0600-\u06FF\s]+$/.test($(this).val()))) {
                                                        str = $(this).val();
                                                        str = str.substring(0, str.length - 1);
                                                        $(this).val(str);
                                                        $(this).attr('autocomplete', 'off');
                                                    } else
                                                        $(this).attr('autocomplete', 'name');"

                                           value="{{ old('name') }}"
                                           required autocomplete="off"
                                           autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="family"
                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">نام
                                    خانوادگی</label>

                                <div class="col-md-6">
                                    <input id="family"
                                           type="text"
                                           class="form-control @error('family') is-invalid @enderror input-outline-primary rounded-0 g-font-size-18 g-font-size-16--md"
                                           name="family"
                                           value="{{ old('family') }}"
                                           required>

                                    @error('family')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

{{--                            <div class="form-group row">--}}
{{--                                <label for="address"--}}
{{--                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">آدرس</label>--}}

{{--                                <div class="col-md-6">--}}
{{--                                    <input id="address"--}}
{{--                                           type="text"--}}
{{--                                           class="form-control @error('address') is-invalid @enderror input-outline-primary rounded-0 g-font-size-18 g-font-size-16--md"--}}
{{--                                           name="address"--}}
{{--                                           value="{{ old('address') }}"--}}
{{--                                           required>--}}

{{--                                    @error('address')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}


                            <div class="form-group row">
                                <label for="mobile"
                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">موبایل</label>

                                <div class="col-md-6">
                                    <input style="direction: ltr"
                                           id="mobile"
                                           type="number"
                                           class="form-control @error('mobile') is-invalid @enderror input-outline-primary rounded-0 g-font-size-18 g-font-size-16--md"
                                           name="mobile"
                                           value="{{ old('mobile') }}"
                                           required>

                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">ایمیل</label>

                                <div class="col-md-6">
                                    <input style="direction:ltr;"
                                           id="email"
                                           type="email"
                                           class="form-control @error('email') is-invalid @enderror input-outline-primary rounded-0 g-font-size-18 g-font-size-16--md text-left"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required=""
                                           autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">رمز</label>

                                <div class="col-md-6">
                                    <input style="direction:ltr;"
                                           id="password"
                                           type="text"
                                           class="form-control @error('password') is-invalid @enderror input-outline-primary rounded-0 g-font-size-18 g-font-size-16--md text-left"
                                           name="password"
                                           value="{{ old('password') }}"
                                           required=""
                                           autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="role"
                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">نقش</label>
                                <div class="col-md-6">
                                    <select style="direction: ltr"
                                            id="role"
                                            class="form-control form-control-md custom-select rounded-0 p-0 pl-3  g-font-size-16 g-bg-gray-light-v5"
                                            name="role"
                                            tabindex="4">
                                        <option value="1">ادمین</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row g-mb-30--lg g-mt-20">
                                <div class="col-md-10 text-left">
                                    <button type="submit" class="btn u-btn-primary rounded-0 g-font-size-16">
                                        ثبت نام
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
