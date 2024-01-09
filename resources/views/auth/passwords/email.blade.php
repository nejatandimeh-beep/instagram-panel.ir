@extends('Layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header text-right">تنظیم مجدد رمز</h5>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}" style="direction: rtl" novalidate>
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
                    @if (session('status'))
                        <div style="direction: rtl" class="alert alert-success text-center" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
