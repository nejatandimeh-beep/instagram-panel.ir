@extends('Layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-right">
                    <span>تایید صحت ایمیل شما</span>
                </div>

                <div style="direction: rtl" class="card-body text-right">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            لینک فعال سازی به آدرس ایمیل شما ارسال شد. برای اتمام فرآیند لطفا ایمیل خود را چک کرده و روی لینک ارسال شده از طرف <span class="g-font-weight-500">Tanastyle.ir</span> کلیک کنید.
                        </div>
                    @endif

                    <p>کاربر گرامی شما هنوز تاییده ایمیل خود را ارسال نکرده اید.</p>
                    <p>برای تاییده ایمیل خود از طریق لینک زیر اقدام فرمایید.</p>
                    <p>مراحل تاییده ایمیل تنها یکبار برای همیشه انجام می گردد.</p>
                    <form class="text-left" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">لینک فعال سازی ایمیل شما</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
