@extends('Layouts.IndexAdmin')
@section('Content')
    <div class="g-bg-gray-dark-v2 g-color-white g-px-15 g-py-30">
        <ul class="nav nav-fill u-nav-v4-1 u-nav-light adminPanelResponsive" role="tablist" data-target="nav-4-1-primary-hor-fill"
            data-tabs-mobile-type="slide-up-down" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-white">
            <li class="nav-item">
                <a class="nav-link"
                   href="#">پشتیبانی</a>
            </li>
            <li class="nav-item">
                <a id="sellerSupport" class="nav-link active" data-toggle="tab" href="#nav-4-1-primary-hor-fill--1"
                   role="tab">جزئیات گفتگو</a>
            </li>
        </ul>
        <div id="nav-4-1-primary-hor-fill" class="tab-content g-pt-40">
            <!-- End Info Panel -->
            <div class="tab-pane fade show active g-bg-gray-dark-v2" id="nav-4-1-primary-hor-fill--1" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <div class="container">
                            {{-- Total Info--}}
                            <div class="rowSeller g-mt-30 g-mb-20 g-mr-0 g-ml-0">

                                <!-- Icon Blocks -->
                                <div
                                    class="col-12 g-pt-25 g-mb-5 g-px-60 text-right">
                                    <div class="d-inline-block">
                                        <div class="d-block text-center">
                                            <span class="u-icon-v2 g-color-teal rounded-circle g-mb-20">
                                                <i class="et-icon-chat g-font-size-25"></i>
                                            </span>
                                        </div>
                                        <div class="d-block text-center">
                                            <h6 class="g-color-white mb-3">عنوان گفتگو</h6>
                                        </div>
                                        <span
                                            class="u-label g-color-teal g-mb-5 g-font-size-14">{{ (isset($data)) ? $data[0]->Subject : $title }}</span>
                                    </div>
                                </div>
                                <!-- End Icon Blocks -->
                            </div>
                            @if (isset($data))
                            @foreach($data as $key => $rec)
                                @if ($rec->Replay === 1)
                                    @if($rec->Question!=='')
                                    <div class="media g-mb-5">
                                        <div style="border-radius: 8px 0 8px 8px;"
                                             class="media-body g-brd-around g-brd-gray-light-v2 g-pa-30 text-right">
                                            <div  style="direction: rtl" class="g-mb-15 text-right">
                                                <h5 class="h5 g-color-gray-light-v3 mb-0">
                                                    <span class="d-block">{{ $rec->Name}}</span>
                                                </h5>
                                                @if (isset($questionHowDay[$key]))
                                                    <span
                                                          class="g-color-gray-light-v3 g-font-size-12">{{ $questionHowDay[$key] }}</span>
                                                @else
                                                    <span style="direction: rtl"
                                                          class="g-color-gray-light-v3 g-font-size-12">{{ $qPersianDate[$key][0].'/'.$qPersianDate[$key][1].'/'.$qPersianDate[$key][2] }}</span>
                                                @endif
                                            </div>

                                            <p
                                                style="direction: rtl; resize: none; opacity: 1;"
                                                class="text-justify text-right col-12 g-brd-none g-color-gray-light-v5 g-bg-transparent g-line-height-2 msg"
                                                disabled>{{ $rec->Question }}</p>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="media g-mb-5 g-mr-30--lg sdCommentPadding-20">
                                        <div style="border-radius: 8px 0 8px 8px;"
                                             class="media-body g-brd-around g-brd-primary g-pa-30 text-right">
                                            <div  style="direction: rtl" class="g-mb-15 text-right">
                                                <h5 class="g-color-primary h5 mb-0">
                                                    <span class="d-block">تانا استایل</span>
                                                </h5>
                                                @if (isset($answerHowDay[$key]))
                                                    <span
                                                          class="g-color-gray-light-v3 g-font-size-12">{{ $answerHowDay[$key] }}</span>
                                                @else
                                                    <span style="direction: rtl"
                                                          class="g-color-gray-light-v3 g-font-size-12">{{ $aPersianDate[$key][0].'/'.$aPersianDate[$key][1].'/'.$aPersianDate[$key][2] }}</span>
                                                @endif
                                            </div>

                                            <p
                                                style="direction: rtl; resize: none; opacity: 1;"
                                                class="text-justify text-right g-color-gray-light-v5 col-12 g-brd-none g-bg-transparent g-line-height-2 msg"
                                                disabled>{{ $rec->Answer }}</p>
                                        </div>
                                    </div>
                                @else
                                    @if($rec->Question!=='')
                                    <div class="media g-mb-5">
                                        <div style="border-radius: 8px 0 8px 8px;"
                                             class="media-body g-brd-around g-brd-gray-light-v2 g-pa-30 text-right">
                                            <div class="g-mb-15 text-right">
                                                <h5 class="d-flex justify-content-between align-items-center h5 g-color-gray-light-v3 mb-0 flex-row-reverse">
                                                    <span class="d-block">{{ $rec->Name}}</span>
                                                </h5>
                                                @if (isset($questionHowDay[$key]))
                                                    <span style="direction: rtl"
                                                          class="g-color-gray-light-v3 g-font-size-12">{{ $questionHowDay[$key] }}</span>
                                                @else
                                                    <span style="direction: rtl"
                                                          class="g-color-gray-light-v3 g-font-size-12">{{ $qPersianDate[$key][0].'/'.$qPersianDate[$key][1].'/'.$qPersianDate[$key][2] }}</span>
                                                @endif
                                            </div>

                                            <p
                                                style="direction: rtl; resize: none; opacity: 1;"
                                                class="text-justify text-right col-12 g-color-gray-light-v5 g-brd-none g-bg-transparent g-line-height-2 msg"
                                                disabled>{{ $rec->Question }}</p>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            @endforeach
                            @endif
                            <div class="g-mt-100 p-0">
                                <form action="{{ route('adminSellerMajorConnectionNewMsg')}}" method="post"
                                      enctype='multipart/form-data'>
                                    @csrf
                                    {{--                Hidden Input--}}
                                    <input style="display: none" type="text" name="conversationID"
                                           value="{{ isset($data) ? $data[0]->ConversationID: '' }}">
                                    @if (!isset($data))
                                        <input style="display: none" type="text" name="title" value="{{ $title }}">
                                        <input style="display: none" type="text" name="priority"
                                               value="{{ $priority }}">
                                        <input style="display: none" type="text" name="section" value="{{ $section }}">
                                    @endif
                                    <div class="form-group g-mb-20 text-right">
                                        <label class="h5 g-mb-10 g-color-gray-light-v3">پیام جدید</label>
                                        <div class="input-group g-brd-primary--focus g-mb-10">
                                            <textarea style="direction: rtl"
                                                      class="form-control form-control-md g-resize-none g-bg-gray-dark-v2 g-color-gray-light-v5 rounded-0 pl-0 text-right g-font-size-16"
                                                      rows="6"
                                                      tabindex="1"
                                                      value=""
                                                      placeholder="پیامتان را شروع کنید.. (300 حرف)"
                                                      name="answer"
                                                      id="answer"
                                                      maxlength="300"></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="sellerMajorID" value="{{ isset($data) ? $data[0]->SellerMajorID: '' }}">
                                    <input type="hidden" name="detailId" value="{{ isset($data) ? $data[$key]->ID: '' }}">
                                    <button type="submit"
                                            class="btn btn-md u-btn-primary rounded-0 force-col-12 g-mb-25">
                                        ارسال پیام
                                    </button>
                                </form>
                            </div>
                            @if (isset($data))
                                {{-- Pagination --}}
                                {{ $data->links('General.Pagination', ['result' => $data]) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

