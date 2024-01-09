@extends('Layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-right">تغییر رمز عبور</div>

                    <div style="direction: rtl" class="card-body">
                        <form method="POST" action="{{ route('change.password') }}">
                            @csrf

                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-left">پسورد جدید</label>

                                <div class="col-md-6">
                                    <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-left">تکرار پسورد جدید</label>

                                <div class="col-md-6">
                                    <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-10 text-left">
                                    <button type="submit"
                                            onclick="$('#submitText').hide(); $('#waitingSubmit').show();"
                                            onsubmit="$(this).prop('disabled',true)"
                                            class="btn u-btn-primary rounded-0 g-font-size-16">
                                        <span id="submitText">ورود</span>
                                        <span id="waitingSubmit"
                                              style="display: none"
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
