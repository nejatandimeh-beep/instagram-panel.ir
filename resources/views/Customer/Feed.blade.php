@extends('Layouts.IndexCustomer')
@section('Content')
    <div id="pageInfo">
        <span id="asset" class="d-none">{{asset('/')}}</span>
        <span id="eventCount" class="d-none">{{count($events)}}</span>
        <span id="commentReplyID" class="d-none"></span>
        <span id="customer_Id" class="d-none">{{isset(Auth::user()->id)?Auth::user()->id:-1}}</span>
    </div>
    <ul style="overflow-x: scroll" id="catList"
        class="list-inline hideScrollBar-x hideScrollBar g-flex-middle-item--bottom p-0 g-width--360 mx-auto d-flex {{isset($events[0]->ID) ? 'g-brd-bottom':''}} g-pb-20 g-brd-gray-light-v5 feed">
        <span class="d-none">{{$temp=0}}</span>
        @foreach($events as $key => $row)
            @if($temp !== $row->sellerMajorID)
                <li style="{{$key==0 ? 'margin: 0 11px 0 0':'margin: 0 11px'}}"
                    class="list-inline-item align-middle g-rounded-50x g-pa-5">
                    <div class="d-flex flex-column align-items-center">
                        <div>
                            <a class="u-icon-v1 u-icon-size--md g-color-white"
                               onclick="eventShow({{$key}})"
                               href="#!">
                                <div id="circleBorder-{{$key}}" class="circleBorder"></div>
                                <img id="borderAnimate-{{$key}}"
                                     class="rounded-circle borderAnimate g-brd-around g-brd-2 g-brd-gray-light-v2"
                                     width="60" height="60"
                                     src="{{$row->Pic=='img/SellerMajorProfileImage/Default/icon.jpg'?asset($row->Pic):asset($row->Pic).'/profileImg.jpg?'.date('Y-m-d H:i:s')}}"
                                     alt="Image Description">
                            </a>
                        </div>
                    </div>
                </li>
            @endif
            <span class="d-none">{{$temp=$row->sellerMajorID}}</span>
        @endforeach
    </ul>
    <!--مودال ریل رویدادها-->
    <div style="padding: 0 !important; overflow: hidden; z-index: 10001" class="modal fade hideScrollBar"
         id="allEvents"
         tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
            <div style="height: 100vh;" class="modal-content">
                <div style="position: relative;" id="eventContainer" class="opacity-0">
                    <div class="g-width--360 mx-auto">
                        <button
                            style="cursor: pointer; outline: 0; position: fixed; z-index: 1000"
                            type="button"
                            class="g-brd-none g-bg-transparent g-px-15 g-color-white align-self-center"
                            data-dismiss="modal"
                            aria-label="Close">
                            <span style="text-shadow: 1px 1px 3px #939393;" aria-hidden="true" class="g-font-size-40">&times;</span>
                        </button>
                    </div>
                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            @foreach($events as $key => $row)
                                <span class="d-none" id="eventID-{{$key}}">{{$row->eventID}}</span>
                                <div class="swiper-slide pauseTimer">
                                    <div style="position: relative; height: 90%">
                                        <div style="width: 98%; border-radius: 5px; position: fixed; top: 2px; left: 1%"
                                             class="g-bg-white-opacity-0_5">
                                            <div id="progress-{{$key}}"
                                                 class="g-bg-primary g-height-3 g-rounded-5 slide-width-0"></div>
                                        </div>
                                        <div
                                            style="direction: rtl; position: fixed; top: 10px; right:10px; width: inherit"
                                            class="d-flex g-pa-5 text-right">
                                            <a href="#" onclick="checkLogin($(this),{{$row->sellerMajorID}})"
                                               class="p-0 text-right d-flex">
                                                <img
                                                    class="g-width-45 g-height-45 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                                                    src="{{$row->Pic=='img/SellerMajorProfileImage/Default/icon.jpg'?asset($row->Pic):asset($row->Pic).'/profileImg.jpg?'.date('Y-m-d H:i:s')}}"
                                                    alt="Image Description">
                                                <span style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3)"
                                                      class="g-font-size-16 g-color-white g-font-weight-600 align-self-center g-mr-5">{{$row->name}}</span>
                                            </a>
                                            <small style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3); cursor: pointer"
                                                   class="{{is_null($row->following)?'':'d-none'}} g-color-primary g-font-weight-600 align-self-center g-mr-5 g-mb-0 user-{{$row->sellerMajorID}}"
                                                   onclick="following($(this),{{$row->sellerMajorID}})">دنبال کن</small>
                                        </div>
                                        <img style="height: 100%; object-fit: cover" class="w-100" alt=""
                                             src="{{asset($row->eventPic.'/'.$row->eventID.'.jpg')}}">
                                        <div style="direction:rtl; position: fixed; bottom:85px"
                                             class="text-center w-100">
                                            <span
                                                class="{{is_null($row->Text) ? 'd-none':''}} g-py-15 g-px-30 g-color-white g-bg-black-opacity-0_1 g-rounded-10"><span>{{$row->Text}}</span></span>
                                        </div>
                                        <div style="position: absolute; bottom:20px" class="w-100 text-center">
                                            <div class="d-flex justify-content-between">
                                                <div class="align-self-center col-1 g-pl-10">
                                                    <a class="d-inline-block g-color-gray-light-v3 g-height-40 g-width-40 g-rounded-50x g-bg-black-opacity-0_4"
                                                       href="#!"
                                                       onclick="eventSave($(this),{{$row->eventID}})">
                                                        <i style="padding-top: 13px"
                                                           class="{{is_null($row->eventSave)?'fa fa-bookmark-o':'fa fa-bookmark'}} align-middle"></i>
                                                    </a>
                                                </div>
                                                <div class="align-self-center col-1 g-pl-0">
                                                    <a class="d-inline-block g-color-gray-light-v3 g-height-40 g-width-40 g-rounded-50x g-bg-black-opacity-0_4"
                                                       href="#!"
                                                       onclick="eventLike($(this),{{$row->eventID}},{{$row->sellerMajorID}})">
                                                        <i style="padding-top: 13px"
                                                           class="{{is_null($row->eventLike)?'fa fa-heart-o':'fa fa-heart g-color-red'}} align-middle"></i>
                                                    </a>
                                                </div>
                                                <div style="padding-right: 15px; padding-left: 13px; width: 100%"
                                                     class="d-flex justify-content-between g-bg-black-opacity-0_4 g-pt-10 g-rounded-20 g-mr-10">
                                                    <div id="replyEventBtn-{{$key}}" style="display: none"
                                                         class="align-self-center">
                                                        <a class="g-color-gray-light-v3 g-pr-10" href="#!"
                                                           onclick="replyEvent({{$row->eventID}},{{$key}})">
                                                            <i class="icon-action-undo g-font-size-18"></i>
                                                        </a>
                                                    </div>
                                                    <textarea
                                                        style="direction: rtl; height: 30px"
                                                        class="form-control growingToTop g-color-white g-brd-none form-control-md g-resize-none rounded-0 g-py-0 g-bg-transparent pr-0 g-pl-5 text-right g-font-size-16"
                                                        tabindex="1"
                                                        value=""
                                                        placeholder="پیام شما.."
                                                        onfocus="swiperTemp.autoplay.pause();"
                                                        onblur="swiperTemp.autoplay.resume();"
                                                        name="answer"
                                                        id="answer-{{$key}}"
                                                        maxlength="200"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div style="height: 90%; top: 0; padding-left: 25%" class="swiper-button-prev"></div>
                        <div style="height: 80%; top: 70px; padding-left: 25%" class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--ریل پست ها-->
    <div id="postRail" class="hideScrollBar g-pb-50">
        <span id="postLoaded" class="d-none">0</span>
        <span id="postLen" class="d-none">{{$postsCount}}</span>
        <div class="large-12 columns p-0" id="postDetailContainer">
            @foreach($posts as $key => $rec)
                <span id="sellerMajorID-{{$key}}" class="d-none">{{$rec->sellerMajorID}}</span>
                <div class="col-12 col-lg-3 mx-auto p-0 postID-{{$rec->postID}}"
                     id="detailPost-{{$key}}">
                    <span class="d-none postID">{{$rec->postID}}</span>
                    <!--پروفایل کاربر-->
                    <div style="direction: rtl" class="g-pa-5 text-right">
                        <div class="col-12 p-0 text-right d-flex justify-content-between">
                            <a href="#" onclick="checkLogin($(this),{{$rec->sellerMajorID}})"
                               class="g-color-gray-dark-v3">
                                <img
                                    class="g-width-45 g-height-45 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                                    src="{{$rec->Pic=='img/SellerMajorProfileImage/Default/icon.jpg'?asset($rec->Pic):asset($rec->Pic).'/profileImg.jpg?'.date('Y-m-d H:i:s')}}"
                                    alt="Image Description">
                                <span
                                    class="g-font-size-16 g-font-weight-600">{{$rec->name}}</span>
                            </a>
                            <h6 style="cursor: pointer"
                                class="{{is_null($rec->following)?'':'d-none'}} g-color-primary align-self-center g-ml-10 g-mb-0 user-{{$rec->sellerMajorID}}"
                                onclick="following($(this),{{$rec->sellerMajorID}})">دنبال کن</h6>
                            <h6 style="cursor: pointer"
                                class="{{is_null($rec->following)?'d-none':''}} instagramLink{{$rec->sellerMajorID}} g-color-primary align-self-center g-mb-0">
                                <a style="color: #7fc242 !important;"
                                   href="https://www.instagram.com/{{$rec->Instagram}}"
                                   class="g-ml-5">{{is_null($rec->Instagram) ? '':'حساب اینستاگرام'}}</a>
                            </h6>
                        </div>
                    </div>

                    <!--تصویر محصول تاناکورا مهاباد-->
                    <div style="position: relative" class="d-block">
                        <div style="height: auto" class="swiper swiper{{$key}}">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                @for($i=0;$i<$rec->PicCount;$i++)
                                    <div class="swiper-slide">
                                        <div class="swiper-zoom-container">
                                            <img class="w-100"
                                                 src="{{asset($rec->postPic.'/'.$rec->postID.'/'.$i.'.jpg')}}"
                                                 alt="Image Description">
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div style="bottom: -31px;"
                             class="swiper-pagination swiper-pagination{{$key}}"></div>
                    </div>

                    <!--ذخیره پست-->
                    <div style="position:relative; z-index: 100" class="g-pa-10 g-pb-0">
                        <div>
                            <div class="text-left d-flex justify-content-between">
                                <div>
                                    <a class="g-color-gray-dark-v1" href="#!"
                                       onclick="savePost({{$rec->postID}},$(this))">
                                        <i class="fa {{is_null($rec->save) ? 'fa-bookmark-o':'fa-bookmark'}} g-font-size-22 g-font-weight-600 g-line-height-0_7"></i>
                                    </a>
                                </div>
                                <div>
                                    <a class="g-color-gray-dark-v1 g-ml-15"
                                       href="#postMsgModal"
                                       id="postMsgModalBtn"
                                       data-toggle="modal"
                                       data-target="#postMsgModal"
                                       onclick="showPostMsg({{$rec->postID}},'{{asset($rec->postPic.'/'.$rec->postID.'/0.jpg')}}','{{$rec->name}}')">
                                        <i class="icon-paper-plane u-line-icon-pro g-font-size-20 g-font-weight-600 g-line-height-0_7"></i>
                                    </a>
                                    <a class="g-color-gray-dark-v1 g-ml-15 accordionBtn"
                                       href="#accordion-04-body-{{$key}}"
                                       data-toggle="collapse"
                                       id="accordionBtn-{{$key}}"
                                       data-parent="#accordion-04" aria-expanded="true"
                                       aria-controls="accordion-04-body-{{$key}}"
                                       onclick="addComments({{$rec->postID}},{{$key}},{{$rec->sellerMajorID}})">
                                        <i class="icon-bubble u-line-icon-pro g-font-size-20 g-font-weight-600 g-line-height-0_7"></i>
                                    </a>
                                    <a class="g-color-gray-dark-v1 g-ml-15" href="#!"
                                       onclick="likePost($(this),{{$rec->postID}},{{$key}},{{$rec->sellerMajorID}})">
                                        <i class="{{$rec->Like === 1 ? 'fa fa-heart g-color-red':'fa fa-heart-o'}} u-line-icon-pro g-font-size-20 g-font-weight-600 g-line-height-0_7"></i>
                                    </a>
                                </div>
                            </div>

                            <h6 style="direction: rtl" class="p-0 m-0 text-right likeCount">
                                <small>{{$rec->LikeCount===0?'':$rec->LikeCount.' پسند'}}</small>
                            </h6>
                        </div>
                    </div>

                    <!--کامنت ها-->
                    <div class="g-px-10">
                        <div style="direction: rtl;">
                            <p
                                class="p-0 g-mt-10 text-right g-mb-0 g-color-black col-10 ml-auto g-font-size-16 g-font-weight-600">{{$rec->name}}</p>
                            <div class="{{is_null($rec->Cat) ? 'd-none':''}} g-font-size-14"><span
                                    class="g-font-weight-600">دسته بندی</span>{{' '.$rec->Cat}}</div>
                            <div class="{{is_null($rec->ProductName) ? 'd-none':''}} g-font-size-14"><span
                                    class="g-font-weight-600">نام محصول</span>{{' '.$rec->ProductName.' '.$rec->Gender}}
                            </div>
                            <div class="{{is_null($rec->Size) ? 'd-none':''}} g-font-size-14"><span
                                    class="g-font-weight-600">سایز</span>{{' '.$rec->Size}}</div>
                            <div class="{{is_null($rec->Color) ? 'd-none':''}} g-font-size-14"><span
                                    class="g-font-weight-600">رنگ</span>{{' '.$rec->Color}}</div>
                            <div class="{{is_null($rec->Price) ? 'd-none':''}} g-font-size-14"><span
                                    class="g-font-weight-600">قیمت</span>{{' '.number_format($rec->Price).' تومان'}}
                            </div>
                            <div class="{{is_null($rec->Discount) ? 'd-none':''}} g-font-size-14"><span
                                    class="g-font-weight-600">تخفیف</span>{{' '.$rec->Discount.' %'}}</div>
                            <div class="{{is_null($rec->FinalPrice) ? 'd-none':''}} g-font-size-14"><span
                                    class="g-font-weight-600">قیمت نهایی</span>{{' '.number_format($rec->FinalPrice).' تومان'}}
                            </div>
                            <p style=" white-space: pre-wrap;">{{$rec->Text}}</p>
                        </div>

                        <div class="{{$commentCount[$key] !== 0 ? '':'d-none'}}">
                            <a class="g-color-gray-dark-v2 w-100"
                               href="#!">
                                <div style="cursor: pointer"
                                     class="g-font-weight-600 g-mx-5 g-font-size-12 g-color-gray-dark-v4 d-flex col-12 g-px-5 justify-content-end"
                                     onclick="$('#accordionBtn-{{$key}}').trigger('click')">
                                    <span class="g-mr-5">نظر</span>
                                    <span class="allComment">{{$commentCount[$key]}}</span>
                                    <span class="g-ml-5">دیدن</span>
                                </div>
                            </a>
                        </div>
                        <div style="direction: rtl" class="text-right">
                            <small
                                class="g-color-gray-dark-v1 text-center">{{$postHowDay[$key]}}</small>
                        </div>
                        <div id="accordion-04" class="u-accordion" role="tablist"
                             aria-multiselectable="false">
                            <!-- Card -->
                            <div class="card rounded-0 g-mb-5 g-brd-none">
                                <div id="accordion-04-body-{{$key}}"
                                     class="collapse g-pa-10 g-pr-0 g-pb-0 accBody"
                                     role="tabpanel"
                                     aria-labelledby="accordion-04-heading-{{$key}}"
                                     data-parent="#accordion-04">
                                    <div style="max-height: 300px; height: auto !important;"
                                         class="u-accordion__body g-color-gray-dark-v5 customScrollBar p-0 g-pr-10">
                                        <div id="commentContainer-{{$key}}">

                                        </div>
                                        <div
                                            style="width: 100%; height: 38px; background-size: contain; position: relative; background-position: center center"
                                            class="d-none load loadCommentWaiting g-mt-20"></div>
                                        <div style="position: relative" class="g-mt-2">
                                            <div class="d-flex">
                                                <textarea style="direction: rtl"
                                                          class="form-control growingToTop col-10 ml-auto hideScrollBar g-pt-10 g-brd-none form-control-md g-resize-none rounded-0 p-0 text-right g-font-size-16"
                                                          tabindex="1"
                                                          value=""
                                                          oninput="if($(this).val()==='') $('#sendCommentBtn-{{$key}}').addClass('d-none'); else $('#sendCommentBtn-{{$key}}').removeClass('d-none');"
                                                          placeholder="نظر شما.."
                                                          name="comment-{{$key}}"
                                                          id="comment-{{$key}}"
                                                          maxlength="300"></textarea>
                                                <div class="g-pl-5">
                                                    <img
                                                        class="g-width-30 g-height-30 rounded-circle"
                                                        src="{{isset(Auth::user()->PicPath) ? asset(Auth::user()->PicPath) : ''}}"
                                                        alt="Image Description">
                                                </div>
                                            </div>
                                            <div id="sendCommentBtn-{{$key}}"
                                                 style="position: absolute; left:0; bottom: -5px;"
                                                 class="d-none">
                                                <a class="g-color-gray-dark-v3" href="#!"
                                                   onclick="sendComment({{$rec->postID}},'comment-{{$key}}')">
                                                    <i class="fa fa-arrow-left g-pa-10"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Card -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div
            style="width: 100%; height: 60px; position: relative; background-position: center center"
            class="d-none load g-mt-20"></div>
        <div style="padding: 0 !important; overflow: hidden; z-index: 10001"
             class="modal fade hideScrollBar g-width--360 mx-auto"
             id="postMsgModal"
             tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div style="position: relative" class="d-block g-ma-20">
                        <img class="w-100"
                             src=""
                             alt="Image Description">
                        <div class="g-width--360 mx-auto">
                            <button
                                style="cursor: pointer; outline: 0; position: fixed; top: 20px; left:20px; text-shadow: 2px 2px #444444; z-index: 1000"
                                type="button"
                                class="g-brd-none g-bg-transparent g-px-15 g-color-white align-self-center"
                                data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true" class="g-font-size-40">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="text-right g-px-20">
                          <textarea style="direction: rtl"
                                    class="form-control col-10 ml-auto hideScrollBar g-brd-none form-control-md g-resize-none rounded-0 p-0 g-mb-20 text-right g-font-size-16"
                                    tabindex="1"
                                    value=""
                                    oninput="if($(this).val()==='') $('.sendMsgBtn').addClass('d-none'); else $('.sendMsgBtn').removeClass('d-none');"
                                    maxlength="300"></textarea>
                    </div>
                    <div class="g-px-20 g-mb-20">
                        <a class="text-left d-none sendMsgBtn">
                            <div style="cursor: pointer" class="d-inline-block g-py-10 g-px-20 g-color-gray-dark-v1">
                                <span><i
                                        class="icon-paper-plane u-line-icon-pro g-font-size-16 align-middle"></i></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--کپی کامنت پست ها-->
    <div id="commentID-" class="d-none text-right g-mb-10 postCommentCopy">
        <div>
            <div class="userInfo">
                <span
                    class="g-font-size-13 g-font-weight-600 g-color-gray-dark-v2"></span>
                <img
                    class="g-width-30 g-height-30 rounded-circle"
                    src=""
                    alt="Image Description">
            </div>
        </div>
        <div>
            <div style="direction: rtl" class="d-flex">
                <div class="p-0 col-10">
                    <div class="g-pr-20">
                        <p style="min-width: 150px; border-radius: 6px 0 6px 6px"
                           class="g-font-size-13 g-color-gray-dark-v1 g-px-5 g-pb-0 m-0 commentText">

                        </p>
                        <p class="m-0 g-mb-10">
                            <small
                                class="g-mx-5 g-color-gray-dark-v5 commentTime"></small>
                            <small
                                class="g-mx-5 g-color-gray-dark-v5 commentLike"></small>
                            <a class="g-color-gray-dark-v2 commentReplying"
                               href="#!">
                                <small
                                    class="g-font-weight-600 g-mx-5 g-color-gray-dark-v4">پاسخ</small>
                            </a>
                            <span id="" style="cursor: pointer"
                                  class="deleteComment d-none g-font-weight-600 g-mx-5 g-color-gray-dark-v4">
                                <i class="icon-trash"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-2 p-0 g-pt-10 text-center">
                    <a class="g-color-gray-dark-v2 commentLiking"
                       href="#!"
                       onclick="">
                        <i class="fa fa-heart-o commentLikeIcon"></i>
                    </a>
                </div>
            </div>
            <div class="commentReply">
            </div>
        </div>
    </div>

    <!--کپی پاسخ کامنت پست ها-->
    <div class="d-none text-right g-mb-10 postCommentReplyCopy">
        <div class="commentReplyDetail d-none">
            <div class="g-pr-25">
                <div class="userInfo">
                    <span
                        class="g-font-size-13 g-font-weight-600 g-color-gray-dark-v2"></span>
                    <img
                        class="g-width-30 g-height-30 rounded-circle"
                        src=""
                        alt="Image Description">
                </div>
            </div>
            <div style="direction: rtl" class="d-flex">
                <div class="g-pr-25 col-10">
                    <div class="g-pr-10 postButtons">
                        <p style="min-width: 150px; border-radius: 6px 0 6px 6px"
                           class="g-font-size-13 g-color-gray-dark-v1 g-px-5 g-pb-0 m-0 commentText">

                        </p>
                        <p class="m-0 g-mb-10">
                            <small
                                class="g-mx-5 g-color-gray-dark-v5 commentTime"></small>
                            <small
                                class="g-mx-5 g-color-gray-dark-v5 commentLike"></small>
                            <a class="g-color-gray-dark-v2 commentReplying"
                               href="#!">
                                <small
                                    class="g-font-weight-600 g-mx-5 g-color-gray-dark-v4">پاسخ</small>
                            </a>
                            <span id="" style="cursor: pointer"
                                  class="deleteCommentReply d-none g-font-weight-600 g-mx-5 g-color-gray-dark-v4">
                                <i class="icon-trash"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-2 p-0 g-pt-10 text-center">
                    <a class="g-color-gray-dark-v2 commentLiking"
                       href="#!"
                       onclick="">
                        <i class="fa fa-heart-o commentLikeIcon"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!--کپی ریل پست ها-->
    <div class="d-none postContainerCopy">
        <div class="col-12 col-lg-3 mx-auto p-0 postID- detailPost">
            <span class="d-none sellerMajorID"></span>
            <span class="d-none postID"></span>
            <!--پروفایل کاربر-->
            <div style="direction: rtl" class="g-pa-5 text-right">
                <div class="col-12 p-0 text-right d-flex justify-content-between">
                    <a href="#" class="sellerMajorPanelBtn">
                        <img id="postProfileImg"
                             class="g-width-45 g-height-45 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                             src=""
                             alt="Image Description">
                        <span id="postProfileName"
                              class="g-font-size-16 g-color-gray-dark-v3 g-font-weight-600"></span>
                    </a>
                    <h6 style="cursor: pointer"
                        class="followingBtn g-color-primary align-self-center g-ml-10 g-mb-0">دنبال کن</h6>
                    <h6 style="cursor: pointer"
                        class="g-color-primary instagramBtn align-self-center g-mb-0">
                        <a style="color: #7fc242 !important;" class="g-ml-5"></a>
                    </h6>
                </div>
            </div>

            <!--وضعیت بازدید پست-->
            <div style="position: relative;" class="d-block">
                <div style="height: auto" class="swiper containerSwiper">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                    </div>
                </div>
                <div style="bottom: -31px;" class="paginationSwiper swiper-pagination"></div>
            </div>

            <div style="position:relative; z-index: 100" class="g-pa-10 g-pb-0">
                <div>
                    <div class="text-left d-flex justify-content-between">
                        <div>
                            <a id="savePost" class="g-color-gray-dark-v1" href="#!">
                                <i class="fa fa-bookmark-o g-font-size-22 g-line-height-0_7"></i>
                            </a>
                        </div>
                        <div>
                            <a class="g-color-gray-dark-v1 g-ml-15 postMsg"
                               href="#postMsgModal"
                               data-toggle="modal"
                               data-target="#postMsgModal">
                                <i class="icon-paper-plane u-line-icon-pro g-font-size-20 g-font-weight-600 g-line-height-0_7"></i>
                            </a>
                            <a class="g-color-gray-dark-v1 g-ml-15 accordionBtn accordionBtnComment"
                               data-toggle="collapse"
                               data-parent="#accordion-04" aria-expanded="true">
                                <i class="icon-bubble u-line-icon-pro g-font-size-20 g-font-weight-600 g-line-height-0_7"></i>
                            </a>
                            <a id="likePost" class="g-color-gray-dark-v1 g-ml-15" href="#!">
                                <i class="g-font-size-20 g-font-weight-600 g-line-height-0_7"></i>
                            </a>
                        </div>
                    </div>

                    <h6 style="direction: rtl" class="p-0 m-0 text-right likeCount">
                        <small></small>
                    </h6>
                </div>
            </div>
            <!--کامنت ها-->
            <div class="g-px-10">
                <div class="postCaption" style="direction: rtl;">
                    <p id="name"
                       class="p-0 g-mt-10 text-right g-mb-0 g-color-black col-10 ml-auto g-font-size-16 g-font-weight-600"></p>
                    <div class="d-none g-font-size-14 cat"><span class="g-font-weight-600">دسته بندی</span><span
                            id="cat"></span></div>
                    <div class="d-none g-font-size-14 productName"><span class="g-font-weight-600">نام محصول</span><span
                            id="productName"></span></div>
                    <div class="d-none g-font-size-14 size"><span class="g-font-weight-600">سایز</span><span
                            id="size"></span></div>
                    <div class="d-none g-font-size-14 color"><span class="g-font-weight-600">رنگ</span><span
                            id="color"></span></div>
                    <div class="d-none g-font-size-14 price"><span class="g-font-weight-600">قیمت</span><span
                            id="price"></span>تومان
                    </div>
                    <div class="d-none g-font-size-14 discount"><span class="g-font-weight-600">تخفیف</span><span
                            id="discount"></span>%
                    </div>
                    <div class="d-none g-font-size-14 finalPrice"><span class="g-font-weight-600">قیمت نهایی</span><span
                            id="finalPrice"></span>تومان
                    </div>
                    <p id="detail" style="white-space: pre-wrap;"></p>
                </div>
                <div class="commentReplyShow">
                    <a class="g-color-gray-dark-v2 w-100"
                       href="#!">
                        <div style="cursor: pointer" id="allCommentContainer"
                             class="g-font-weight-600 g-mx-5 g-font-size-13 g-color-gray-dark-v4 d-flex col-12 g-px-5 justify-content-end">
                            <span class="g-mr-5">نظر</span>
                            <span class="allComment"></span>
                            <span class="g-ml-5">دیدن</span>
                        </div>
                    </a>
                </div>
                <div style="direction: rtl" class="text-right">
                    <small
                        class="g-color-gray-dark-v1 text-center postHowDay"></small>
                </div>
                <div id="accordion-04" class="u-accordion" role="tablist"
                     aria-multiselectable="false">
                    <!-- Card -->
                    <div class="card rounded-0 g-mb-5 g-brd-none">
                        <div
                            class="collapse g-pa-10 g-pr-0 g-pb-0 accBody"
                            role="tabpanel"
                            data-parent="#accordion-04">
                            <div style="max-height: 300px; height: auto !important;"
                                 class="u-accordion__body g-color-gray-dark-v5 customScrollBar p-0 g-pr-10">
                                <div class="commentContainer">

                                </div>
                                <div
                                    style="width: 100%; height: 38px; background-size: contain; position: relative; background-position: center center"
                                    class="d-none load loadCommentWaiting g-mt-20"></div>
                                <div style="position: relative" class="g-mt-2">
                                    <div class="d-flex">
                                            <textarea style="direction: rtl"
                                                      class="form-control commentText growingToTop col-10 ml-auto hideScrollBar g-pt-10 g-brd-none form-control-md g-resize-none rounded-0 p-0 text-right g-font-size-16"
                                                      tabindex="1"
                                                      value=""
                                                      placeholder="نظر شما.."
                                                      maxlength="300"></textarea>
                                        <div class="g-pl-5">
                                            <img
                                                class="g-width-30 g-height-30 rounded-circle commenterProfileImg"
                                                src=""
                                                alt="Image Description">
                                        </div>
                                    </div>
                                    <div
                                        style="position: absolute; left:0; bottom: -5px;"
                                        class="d-none sendCommentBtn">
                                        <a class="g-color-gray-dark-v3" href="#!">
                                            <i class="fa fa-arrow-left g-pa-10"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>
            </div>
        </div>
    </div>
@endsection
