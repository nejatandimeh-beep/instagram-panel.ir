@extends('Layouts.IndexAdmin')
@section('Content')
    <div style="background: linear-gradient(to right, rgb(243 243 243), rgb(255 255 255));" class="container messageDetailMenu g-pt-15">
        <div class="msgContainer">
{{--            <span class="d-none">{{$temp=''}}</span>--}}
        @foreach($msg as $key => $row)
                <div id="msg-{{$row->ID}}" class="{{$row->Sender === 'customer' ? 'text-left':'text-right'}} g-mb-20">
                    <div class="g-mb-8 {{$row->Sender === 'customer' ? '':'d-none'}}">
                        <div>
                            <img class="g-width-40 g-height-40 rounded-circle"
                                 src="{{asset($row->customerPic)}}"
                                 alt="Image Description">
                            <span
                                class="g-font-size-13 g-font-weight-600">{{!is_null($row->customerName)?$row->customerName:'کاربر '.$row->customerID}}</span>
                        </div>
                    </div>
                    <div class="{{$row->Sender === 'customer' ? 'mr-auto':'ml-auto'}} p-0 col-10">
                        <div class="g-mb-5 {{$row->AttachPath!=='' ? '':'d-none'}}">
                            <div style="position: relative;" class="d-inline-block msgImgSize">
                                @if($row->AttachPath!=='')
                                    <a class="js-fancybox"
                                       href="javascript:;"
                                       data-fancybox="lightbox-gallery"
                                       data-src="{{is_null($row->EventID)?asset($row->AttachPath.'/0.jpg'):asset($row->AttachPath.'.jpg')}}"
                                       data-caption="Lightbox Gallery"
                                       data-speed="200"
                                       onclick="setTimeout(function() {$('.fancybox-caption-wrap').remove();},1)"
                                       data-is-infinite="true"
                                       data-slideshow-speed="5000">
                                        <img style="width: 100%; border-radius: 5px; border: 2px solid rgba(0,0,0,0.22)"
                                             src="{{is_null($row->EventID)?asset($row->AttachPath.'/sample.jpg'):asset($row->AttachPath.'.jpg')}}"
                                             alt="Image Description">
                                        <span style="position: absolute; left: 10px; top: 10px"
                                              class="u-label g-bg-black-opacity-0_3 g-font-size-12 g-font-weight-600 g-color-white align-middle g-py-3 g-px-5">
                                            <span><i class="icon-paper-clip g-mr-3"></i><span class="imgNumber">{{$key}}</span></span>
                                         </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div style="direction: rtl">
                            <p style="min-width: 100px; {{$row->Sender === 'customer' ? ' border-radius: 0 6px 6px 6px' : 'border-radius: 6px 0 6px 6px'}}"
                               class="g-font-size-13 m-0 {{$row->Reply !== '' ? 'd-inline-block':'d-none'}}">
                                <span class="d-flex {{$row->Sender === 'customer' ? 'justify-content-end':''}}">
                                    <span>{{$row->Reply}}</span>
                                    <a class="g-color-gray-light-v1 g-mr-5 {{$row->Sender === 'customer'?'d-none':''}}"
                                       onclick="deleteMsg({{$row->ID}})"
                                       href="#"><i class="icon-trash"></i></a>
                                </span>

                            </p>
                            <small class="d-block g-color-gray-light-v1 g-mb-5">{{$msgHowDay[$key]}}</small>
                        </div>
                    </div>
                </div>
{{--                <span class="d-none">{{$temp=$row->SenderReplyID}}</span>--}}
        @endforeach
        </div>
    </div>

    <!--msg style template-->
    <div id="msg-" class="text-right g-mb-20 msgRow d-none">
        <div class="ml-auto p-0 col-10">
            <div id="attachPath" class="g-mb-5">
                <div style="position: relative;" class="d-inline-block msgImgSize">
                    <a class="fancy"
                       href="javascript:;"
                       onclick="setTimeout(function() {$('.fancybox-caption-wrap').remove();},1)">
                        <img style="width: 100%; border-radius: 5px; border: 2px solid rgba(0,0,0,0.22)"
                             src=""
                             alt="Image Description">
                        <span style="position: absolute; left: 10px; top: 10px"
                              class="u-label g-bg-black-opacity-0_3 g-font-size-12 g-font-weight-600 g-color-white align-middle g-py-3 g-px-5">
                              <span><i class="icon-paper-clip g-mr-3"></i><span id="imgNumber"></span></span>
                         </span>
                    </a>
                </div>
            </div>
            <div style="direction: rtl">
                <p style="min-width: 100px; {{$row->Sender === 'customer' ? ' border-radius: 0 6px 6px 6px' : 'border-radius: 6px 0 6px 6px'}}"
                   class="g-font-size-13 m-0 d-inline-block">
                    <span class="d-flex">
                        <span id="replyText"></span>
                        <a class="g-color-gray-light-v1 g-mr-5"
                           href="#"><i class="icon-trash"></i></a>
                    </span>
                </p>
                <small class="d-block g-color-gray-light-v1 g-mb-5">لحظاتی پیش</small>
            </div>
        </div>
    </div>
@endsection

