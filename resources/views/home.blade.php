@extends('Layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div style="direction: rtl" class="card">
                <div class="card-header text-right">خوش آمدید</div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <a href="{{ route('Master') }}" class="btn btn-xl rounded-0 u-btn-primary force-col-12 u-btn-content g-font-weight-600 g-letter-spacing-0_5 text-uppercase g-brd-2 g-mb-15">
                            <span class="text-center">
                              صفحه نخست
                              <span class="d-block g-font-size-11">ورود مجددتان بخیر</span>
                            </span>
                        </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
