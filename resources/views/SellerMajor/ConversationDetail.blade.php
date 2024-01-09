@extends('Layouts.SellerMajor.Index')
@section('Content')
    <span class="d-none">{{$result=isset($data[0])?$data[0]->Priority:$priority}}</span>
    <!-- End Info Panel -->
    {{--Hidden Input--}}
    <div class="container">
        {{-- Total Info--}}
        <div class="rowSeller g-mt-30 g-mr-0 g-ml-0">
            <!-- Icon Blocks -->
            <div class="col-12 g-pt-25 px-0 text-right">
                <div class="d-inline-block">

                    <div style="direction: rtl" class="d-flex justify-content-start">
                        <div>
                            <span class="h5 g-color-black g-ma-5">عنوان گفتگو</span>
                            <span class="u-label g-color-gray-dark-v2 p-0 g-font-size-16">{{$title}}</span>
                        </div>

                        <div class="g-mr-5">
                            <span class="h5 g-color-black g-ma-5">اولویت</span>
                            @if ($result === '2')
                                <span class="align-middle g-color-gray-dark-v2 g-font-size-16 text-center text-nowrap">معمولی</span>
                            @elseif ($result === '1')
                                <span class="align-middle g-color-gray-dark-v2 g-font-size-16 text-center text-nowrap">مهم</span>
                            @elseif ($result === '0')
                                <span class="align-middle g-color-gray-dark-v2 g-font-size-16 text-center text-nowrap">فوری</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Icon Blocks -->
        </div>
        @if (isset($data))
            <hr class="g-brd-gray-light-v4 g-mt-10">
            @foreach($data as $key => $rec)
                @if ($rec->Replay === 1)
                    @if($rec->Question!=='')
                       <div class="media g-mb-5">
                        <div style="border-radius: 8px 0 8px 8px;"
                             class="media-body g-brd-around g-brd-gray-light-v2 g-bg-gray-light-v5 g-pa-30 text-right">
                            <div  style="direction: rtl" class="g-mb-15 text-right">
                                <h6 class="h5 g-color-gray-dark-v1 mb-0">
                                    <span class="d-block">{{ $rec->Name}}</span>
                                </h6>
                                @if (isset($questionHowDay[$key]))
                                    <span
                                          class="g-color-gray-dark-v4 g-font-size-12">{{ $questionHowDay[$key] }}</span>
                                @else
                                    <span style="direction: rtl"
                                          class="g-color-gray-dark-v4 g-font-size-12">{{ $qPersianDate[$key][0].'/'.$qPersianDate[$key][1].'/'.$qPersianDate[$key][2] }}</span>
                                @endif
                            </div>

                            <p
                                style="direction: rtl; resize: none; -webkit-text-fill-color: #2a2734; opacity: 1;"
                                class="text-justify text-right col-12 g-brd-none g-bg-transparent g-line-height-2"
                                disabled>{{ $rec->Question }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="media g-mb-5 g-mr-30--lg sdCommentPadding-20">
                        <div style="border-radius: 8px 0 8px 8px;"
                             class="media-body g-brd-around g-brd-primary g-bg-gray-light-v5 g-pa-30 text-right">
                            <div  style="direction: rtl" class="g-mb-15 text-right">
                                <h6 class="g-color-primary h5 mb-0">
                                    <span class="d-block">تانا استایل</span>
                                </h6>
                                @if (isset($answerHowDay[$key]))
                                    <span
                                          class="g-color-gray-dark-v4 g-font-size-12">{{ $answerHowDay[$key] }}</span>
                                @else
                                    <span style="direction: rtl"
                                          class="g-color-gray-dark-v4 g-font-size-12">{{ $aPersianDate[$key][0].'/'.$aPersianDate[$key][1].'/'.$aPersianDate[$key][2] }}</span>
                                @endif
                            </div>

                            <p
                                style="direction: rtl; resize: none; -webkit-text-fill-color: #2a2734; opacity: 1;"
                                class="text-justify text-right col-12 g-brd-none g-bg-transparent g-line-height-2"
                                disabled>{{ $rec->Answer }}</p>
                        </div>
                    </div>
                @else
                    @if($rec->Question!=='')
                    <div class="media g-mb-5">
                        <div style="border-radius: 8px 0 8px 8px;"
                             class="media-body g-brd-around g-brd-gray-light-v2 g-bg-gray-light-v5 g-pa-30 text-right">
                            <div  style="direction: rtl" class="g-mb-15 text-right">
                                <h6 class="h5 g-color-gray-dark-v1 mb-0">
                                    <span class="d-block">{{ $rec->Name}}</span>
                                </h6>
                                @if (isset($questionHowDay[$key]))
                                    <span
                                          class="g-color-gray-dark-v4 g-font-size-12">{{ $questionHowDay[$key] }}</span>
                                @else
                                    <span style="direction: rtl"
                                          class="g-color-gray-dark-v4 g-font-size-12">{{ $qPersianDate[$key][0].'/'.$qPersianDate[$key][1].'/'.$qPersianDate[$key][2] }}</span>
                                @endif
                            </div>

                            <p
                                style="direction: rtl; resize: none; -webkit-text-fill-color: #2a2734; opacity: 1;"
                                class="text-justify text-right col-12 g-brd-none g-bg-transparent g-line-height-2"
                                disabled>{{ $rec->Question }}</p>
                        </div>
                    </div>
                    @endif
                @endif
            @endforeach
        @endif
        <hr class="g-brd-gray-light-v4 g-mt-10">
        <div class="m-0 p-0">
            <form action="{{ route('sellerMajorConnectionNewMsg')}}" method="post" id="customerMsgForm" enctype='multipart/form-data'>
                @csrf
                {{--                Hidden Input--}}
                <input style="display: none" type="text" name="conversationID"
                       value="{{ isset($data) ? $data[0]->ConversationID: '' }}">
                @if (!isset($data))
                    <input style="display: none" type="text" name="title" value="{{ $title }}">
                    <input style="display: none" type="text" name="priority" value="{{ $priority }}">
                    <input style="display: none" type="text" name="section" value="{{ $section }}">
                @endif
                <div class="form-group g-mb-20 text-right">
                    <label class="h5 g-mb-10 g-color-gray-dark-v1">پیام جدید</label>
                    <div class="input-group g-brd-primary--focus g-mb-10">
                    <textarea style="direction: rtl"
                              class="form-control form-control-md g-resize-none rounded-0 pl-0 text-right g-font-size-16"
                              rows="6"
                              tabindex="1"
                              value=""
                              placeholder="پیامتان را شروع کنید.. (300 حرف)"
                              name="question"
                              id="question"
                              maxlength="300"></textarea>
                    </div>
                    <div style="direction: rtl">
                        <small class="d-inline-block text-muted g-font-size-12">بخش پشتیبانی شرکت آماده پاسخ گویی سریع به شما عزیزان در
                            طول
                            شبانه روز است.</small><br>
                        <small class="d-inline-block text-muted g-font-size-12">پیام ها ظرف 5 الی 60 دقیقه بسته به سوال شما و بخش
                            مربوطه
                            پاسخ داده خواهند شد.</small><br>
                        <small class="d-inline-block text-muted g-font-size-12">امید است سیستم پاسخگویی ما بهترین کارایی را برای رفع
                            سریع
                            سوالات و مشکلات موجود داشته باشد.</small>
                    </div>
                </div>
                <button id="sendMsgSubmit" type="button" onclick="submitButton($(this),'waitingSendMsg');"
                        class="btn btn-md u-btn-primary rounded-0 force-col-12 g-mb-100">
                    ارسال پیام
                </button>
                <i id="waitingSendMsg"
                   style="display: none"
                   class="fa fa-spinner fa-spin m-0 force-col-12 g-mb-100 g-font-size-20 g-color-primary"></i>
            </form>
        </div>
        @if (isset($data))
            {{-- Pagination --}}
            {{ $data->links('General.Pagination', ['result' => $data]) }}
        @endif
    </div>
@endsection

