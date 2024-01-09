@extends('Layouts.IndexAdmin')
@section('Content')
    @if(session()->has('status'))
        <div class="modal fade" id="overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-right g-bg-gray-light-v5">
                        <button type="button" class="close g-font-size-20" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title"><span
                                class="fa fa-check-square g-color-primary g-font-size-25 g-ml-15"></span></h4>
                    </div>
                    <div class="modal-body text-right">
                        <p style="direction: rtl">پیام با موفقیت ارسال شد.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="mx-auto col-12 col-lg-6 g-py-40">
        <div>
            <div class="text-center g-pa-20">
                <img alt="دعوت نامه" width="150" height="150" src="{{asset('img/Other/invite.png')}}">
                <h3 class="g-mb-20">دعوت نامه</h3>
            </div>
            <div class="d-flex g-my-5">
                <input type="text"
                       name="name"
                       id="name"
                       class="form-control text-right g-font-size-16 col-8 rounded-0 form-control-md">
                <div class="input-group-append col-4 text-right">
                    <h5><label>نام</label></h5>
                </div>
            </div>
            <div class="d-flex g-my-5">
                <input type="text"
                       name="family"
                       id="family"
                       class="form-control text-right g-font-size-16 col-8 rounded-0 form-control-md">
                <div class="input-group-append col-4 text-right">
                    <h5><label>فامیلی</label></h5>
                </div>
            </div>
            <div class="d-flex g-my-5">
                <input type="text" oninput="inviteCheckMobile($(this))"
                       name="mobile"
                       id="mobile"
                       class="form-control g-font-size-16 col-8 rounded-0 form-control-md"
                       placeholder="0xxxxxxxxxx">
                <div class="input-group-append col-4 text-right">
                    <h5><label>موبایل</label></h5>
                </div>
            </div>
        </div>
        <div class="input-group-append g-mt-10">
            <button class="btn btn-md u-btn-insta rounded-0" id="submitBtn" onclick="submitInvite()" disabled type="button">ارسال</button>
        </div>
    </div>

@endsection
