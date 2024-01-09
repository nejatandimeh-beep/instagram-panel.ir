@extends('Layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header text-right">خرید محصول</h5>

                    <div class="card-body">
                        <form method="POST" action="{{ route('requestPdId') }}" style="direction: rtl" novalidate>
                            @csrf

                            <div class="form-group row">
                                <label for="pdId"
                                       class="col-md-4 col-form-label text-right text-md-left g-font-size-16">شناسه
                                    محصول</label>

                                <div class="col-md-6">
                                    <input id="pdId"
                                           type="number"
                                           pattern="\d*"
                                           class="form-control @if(session()->has('error')) is-invalid @endif text-left input-outline-primary rounded-0 g-font-size-18 g-font-size-16--md"
                                           name="pdId"
                                           placeholder="شناسه را وارد کنید"
                                           value="{{ old('pdId') }}"
                                           autofocus>

                                    @if(session()->has('error'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>شناسه وارد شده صحیح نمی باشد.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-10 col-12 text-left g-color-orange g-mt-10">
                                    <small>شناسه با اعداد انگلیسی</small>
                                </div>
                            </div>
                            <div class="form-group row g-mb-60--lg g-mt-20">
                                <div class="col-md-10 text-left">
                                    <button type="button"
                                            onclick="
                                            if($('#pdId').val() !== ''){
                                               $('form').submit();
                                            } else alert('شناسه محصول الزامیست.')"
                                            class="btn u-btn-primary rounded-0 g-font-size-16">
                                        نمایش محصول
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
