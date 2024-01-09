@extends('Layouts.IndexCustomer')
@section('Content')
    <span id="asset" class="d-none">{{asset('/')}}</span>
    <span id="sellerMajorPanel" class="d-none sellerMajorPanel">{{$sellerMajorID}}</span>
    <span id="eventCount" class="d-none">{{count($events)}}</span>
    <span id="postLen" class="d-none">{{$postsCount}}</span>
    <span id="postLoaded" class="d-none">0</span>
    <span id="commentReplyID" class="d-none"></span>
    <span id="customer_Id" class="d-none">{{isset(Auth::user()->id)?Auth::user()->id:-1}}</span>
    <!--Bio-->
    <div class="container">
        <div style="direction: rtl" class="row">
            <div class="col-lg-4 g-mb-0">
                <!-- End User Details -->
                <!-- User Image -->
                <div class="g-mb-5 {{isset($events[0]) ? 'ContainerAnimateBorder':''}}">
                    <div>
                        <figure>
                            <img id="profileImgBox" class="img-fluid w-100 u-block-hover__main--zoom-v1"
                                 style="cursor:pointer;"
                                 src="{{$data->Pic=='img/SellerMajorProfileImage/Default/icon.jpg'?asset($data->Pic):asset($data->Pic).'/profileImg.jpg?'.date('Y-m-d H:i:s')}}"
                                 alt="Image Description"
                                 onclick="{{isset($events[0]) ? 'eventShow(0)':''}}">
                        </figure>
                    </div>
                    <div id="eventAnimeBorder" class="{{isset($events[0]) ? '':'d-none'}}">
                        <span class="topAnimateBorder lineAnimateBorder"></span>
                        <span class="rightAnimateBorder lineAnimateBorder"></span>
                        <span class="bottomAnimateBorder lineAnimateBorder"></span>
                        <span class="leftAnimateBorder lineAnimateBorder"></span>
                    </div>
                </div>
                <div class="d-flex">
                    <a style="border-radius: 0"
                       class="{{$data->following == null ? '':'d-none'}} btn g-ml-1 col-6 u-btn-darkgray g-py-12 g-mb-20"
                       id="followingBtn"
                       onclick="panelFollowing($(this),{{$data->id}})"
                       href="#!"><span class="g-mx-5">دنبال کن</span>
                    </a>
                    <a style="border-radius: 0"
                       class="{{$data->following == null ? 'd-none':''}} btn g-ml-1 col-6 u-btn-darkgray g-py-12 g-mb-20"
                       id="unFollowingBtn"
                       onclick="panelDeleteFollowing({{$data->id}},$(this))"
                       href="#!"><span class="g-mx-5">لغو دنبال کردن</span>
                    </a>
                    <a style="border-radius: 0"
                       class="btn g-mr-1 col-6 u-btn-darkgray g-py-12 g-mb-20"
                       id="unFollowingBtn"
                       href="{{route('cSmDetail',$sellerMajorID)}}"><span class="g-mx-5">پیام</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-8 p-0 g-px-20 g-px-0--lg">
                <!-- User Details -->
                <div class="d-flex align-items-center g-mt-10 g-mt-0--lg justify-content-between g-mb-5">
                    <h4 class="g-font-weight-500 g-ml-10 g-mb-0">
                        {{$data->name}}
                        <span class="u-label g-mb-0 g-color-gray-dark-v3 g-font-size-16" title="پست ها">
                              <i class="icon-layers g-mr-3"></i> {{$data->Posts}}
                             </span>
                        <span class="u-label g-mb-0 g-color-gray-dark-v3 g-font-size-16" title="دنبال کنندگان">
                                  <i class="icon-people g-mr-3"></i> {{$data->Followers}}
                             </span>
                    </h4>

                    <ul style="direction: ltr" class="list-inline mb-0">
                        <li class="list-inline-item g-mx-2">
                            <a class="u-icon-v1 u-icon-size--sm u-icon-slide-up--hover g-color-gray-light-v1 g-bg-gray-light-v5 g-color-gray-light-v1--hover rounded-circle"
                               data-toggle="modal"
                               data-target="#instagramModal"
                               onclick="$('#instagram').val('')"
                               href="#!">
                                <i class="g-line-height-1 u-icon__elem-regular fa fa-instagram g-font-size-16 g-color-gray-dark-v4"></i>
                                <i class="g-line-height-0_8 u-icon__elem-hover fa fa-instagram g-font-size-16 g-color-gray-dark-v4"></i>
                            </a>
                            <!--modalInstagram-->
                            <div style="direction: rtl" class="modal fade text-center" id="instagramModal"
                                 tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header g-pr-20 g-pl-20">
                                            <h5 class="m-0">آدرس اکانت اینستاگرام</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <i class="fa fa-close g-font-size-16"></i>
                                            </button>
                                        </div>
                                        <div style="direction: rtl" class="modal-body mx-3 text-right">
                                            <div style="direction: ltr" class="form-group row g-mb-25">
                                                <div class="input-group justify-content-center">
                                                    <div class="col-lg-10">
                                                        <span class="h6 d-flex justify-content-between">
                                                            <a style="color: #7fc242 !important;" id="instagramLink" href="https://www.instagram.com/{{$data->Instagram}}"
                                                               class="g-ml-5">{{$data->Instagram !== '' ? '@'.$data->Instagram : 'خالی'}}</a><span>آدرس فعلی</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- End User Details -->

                <!-- User Position -->
                <h4 class="h6 g-font-weight-300 g-mb-5">
                    <i class="icon-badge g-pos-rel g-top-1 g-font-size-16 g-ml-5 g-color-gray-dark-v1"></i> {{$data->HintCategory}}
                </h4>
                <!-- End User Position -->

                <!-- User Info -->
                <ul class="list-inline g-mb-5 g-mb-15--lg g-font-weight-300 g-pl-40 g-pr-0">
                    <li class="list-inline-item g-ml-20 g-mr-0 d-none">
                        <i class="icon-check g-pos-rel g-top-1 g-color-gray-dark-v5 g-ml-5"></i> اعتبارسنجی
                    </li>
                    <li class="list-inline-item g-ml-20">
                        <a class="g-text-underline--none--hover"
                           href="#">
                            <i class="icon-location-pin g-font-size-16 g-color-gray-dark-v5 g-pos-rel g-top-1 g-ml-5"></i><span
                                id="addressLink">{{$data->Address !=='' ? $data->Address:'آدرس'}}</span>
                        </a>
                    </li>
                </ul>
                <!-- End User Skills -->
                <!-- bio -->
                <div class="g-mb-10 g-mb-0--lg">
                    <div class="form-group g-mb-20">
                        <div class="input-group g-brd-primary--focus g-mb-10">
                            <textarea id="bioText"
                                      onfocus="if($('#edited').text()==='0'){$('#bioTextCopy').val($(this).val()); $('#edited').text('1')}"
                                      class="form-control form-control-md g-resize-none g-font-size-16 g-brd-0 rounded-0 g-px-5 g-pt-0 g-color-gray-dark-v4 g-bg-transparent"
                                      maxlength="300" rows="4" placeholder="بایوگرافی.."
                                      readonly>{{$data->Bio}}</textarea>
                            <textarea id="bioTextCopy" onfocus="" class="d-none" maxlength="300"
                                      rows="4"></textarea>
                            <span class="d-none" id="edited">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="{{isset($posts[0])?'':'d-none'}} g-brd-gray-light-v3 g-my-5">

    <!--پیش نمایش پست ها-->
    <div class="container g-px-10--lg g-px-0 g-pb-80--lg g-pb-20">
        <div class="row g-mx-1 g-pb-20 g-pb-200--lg" id="postSampleContainer">
            @foreach($posts as $key => $rec)
                <div class="col-lg-2 col-4 g-brd-around g-brd-white p-0" id="postSample-{{$key}}">
                    <a class="d-block u-block-hover u-bg-overlay g-bg-black-opacity-0_3--after g-bg-transparent--hover--after"
                       href="#"
                       data-toggle="modal"
                       id="samplePost-{{$key}}"
                       onclick="postNumber = {{$key}};"
                       data-target="#postRail">
                        <img class="img-fluid u-block-hover__main--zoom-v1"
                             src="{{asset($rec->postPic.'/'.$rec->postID.'/sample.jpg')}}"
                             alt="Image Description">
                    </a>
                </div>
            @endforeach
        </div>
        <div style="width: 100%; height: 60px; position: relative; background-position: center center"
             class="d-none load g-mt-20"></div>
    </div>

    <!--مودال ریل پست ها-->
    <div style="padding: 0 !important;" class="hideScrollBar modal g-bg-white fade bd-example-modal-lg" id="postRail"
         tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <span id="postLen" class="d-none">{{$postsCount}}</span>
        <span id="postLoaded" class="d-none">0</span>
        <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
            <div style="height: auto" class="g-brd-none modal-content g-pb-80">
                <div>
                    <div class="p-0">
                        <div>
                            <div class="large-12 columns p-0" id="postDetailContainer">
                                <div style="position: sticky; top: 0; z-index: 9999"
                                     class="g-pa-10 col-12 col-lg-3 g-bg-white mx-auto g-brd-bottom g-brd-gray-light-v4">
                                    <a class="g-color-gray-dark-v1" href="#!">

                                    </a>
                                    <button style="outline: 0; cursor:pointer;" type="button"
                                            class="g-brd-none g-bg-transparent"
                                            data-dismiss="modal"
                                            aria-label="Close"><i
                                            class="icon-arrow-left g-font-weight-600 align-middle g-font-size-16 g-line-height-0_7"></i>
                                    </button>
                                </div>
                                @foreach($posts as $key => $rec)
                                    <span id="sellerMajorID-{{$key}}" class="d-none">{{$rec->sellerMajorID}}</span>
                                    <div class="col-12 col-lg-3 mx-auto p-0 postID-{{$rec->postID}}"
                                         id="detailPost-{{$key}}">
                                        <span class="d-none postID">{{$rec->postID}}</span>
                                        <!--پروفایل کاربر-->
                                        <div style="direction: rtl" class="g-pa-5 text-right">
                                            <div class="col-12 p-0 text-right d-flex justify-content-between">
                                                <div>
                                                    <img
                                                        class="g-width-45 g-height-45 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                                                        src="{{$rec->sellerMajorPic=='img/SellerMajorProfileImage/Default/icon.jpg'?asset($rec->sellerMajorPic):asset($rec->sellerMajorPic).'/profileImg.jpg?'.date('Y-m-d H:i:s')}}"
                                                        alt="Image Description">
                                                    <span
                                                        class="g-font-size-16 g-font-weight-600">{{$rec->name}}</span>
                                                </div>
                                                <h6 class="{{is_null($rec->following)?'':'d-none'}} align-self-center g-ml-10 g-mb-0 g-color-primary user-{{$rec->sellerMajorID}}"
                                                    onclick="following($(this),{{$rec->sellerMajorID}})">دنبال کن</h6>
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
                                                            <img class="w-100"
                                                                 src="{{asset($rec->postPic.'/'.$rec->postID.'/'.$i.'.jpg')}}"
                                                                 alt="Image Description">
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
                                                            <i class="fa {{is_null($rec->save) ? 'fa-bookmark-o':'fa-bookmark'}} g-font-size-22 g-line-height-0_7"></i>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <a class="g-color-gray-dark-v1 g-ml-10"
                                                           href="#postMsgModal"
                                                           data-toggle="modal"
                                                           data-target="#postMsgModal"
                                                           onclick="showPostMsg({{$rec->postID}},'{{asset($rec->postPic.'/'.$rec->postID.'/0.jpg')}}','{{$rec->name}}')">
                                                            <i class="icon-paper-plane u-line-icon-pro g-font-size-20 g-font-weight-600 g-line-height-0_7"></i>
                                                        </a>
                                                        <a class="g-color-gray-dark-v1 g-ml-10 accordionBtn"
                                                           href="#accordion-04-body-{{$key}}"
                                                           data-toggle="collapse"
                                                           id="accordionBtn-{{$key}}"
                                                           data-parent="#accordion-04" aria-expanded="true"
                                                           aria-controls="accordion-04-body-{{$key}}"
                                                           onclick="addComments({{$rec->postID}},{{$key}},{{$rec->sellerMajorID}})">
                                                            <i class="icon-bubble u-line-icon-pro g-font-size-20 g-font-weight-600 g-line-height-0_7"></i>
                                                        </a>
                                                        <a class="g-color-gray-dark-v1 g-ml-10" href="#!"
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
                                                        class="g-font-weight-600">دسته بندی</span>{{' '.$rec->Cat}}
                                                </div>
                                                <div
                                                    class="{{is_null($rec->ProductName) ? 'd-none':''}} g-font-size-14">
                                                    <span
                                                        class="g-font-weight-600">نام محصول</span>{{' '.$rec->ProductName.' '.$rec->Gender}}
                                                </div>
                                                <div class="{{is_null($rec->Size) ? 'd-none':''}} g-font-size-14"><span
                                                        class="g-font-weight-600">سایز</span>{{' '.$rec->Size}}</div>
                                                <div class="{{is_null($rec->Color) ? 'd-none':''}} g-font-size-14"><span
                                                        class="g-font-weight-600">رنگ</span>{{' '.$rec->Color}}</div>
                                                <div class="{{is_null($rec->Price) ? 'd-none':''}} g-font-size-14"><span
                                                        class="g-font-weight-600">قیمت</span>{{' '.number_format($rec->Price).' تومان'}}
                                                </div>
                                                <div class="{{is_null($rec->Discount) ? 'd-none':''}} g-font-size-14">
                                                    <span
                                                        class="g-font-weight-600">تخفیف</span>{{' '.$rec->Discount.' %'}}
                                                </div>
                                                <div class="{{is_null($rec->FinalPrice) ? 'd-none':''}} g-font-size-14">
                                                    <span
                                                        class="g-font-weight-600">قیمت نهایی</span>{{' '.number_format($rec->FinalPrice).' تومان'}}
                                                </div>
                                                <p style=" white-space: pre-wrap;">{{$rec->Text}}</p>
                                            </div>
                                            <div class="{{$commentCount[$key] !== 0 ? '':'d-none'}}">
                                                <a class="g-color-gray-dark-v2 w-100"
                                                   href="#!">
                                                    <div style="cursor: pointer"
                                                         class="g-font-weight-600 g-mx-5 g-font-size-13 g-color-gray-dark-v4 d-flex col-12 g-px-5 justify-content-end"
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
                                                                              class="form-control growingToTop col-10 ml-auto hideScrollBar g-brd-none form-control-md g-resize-none rounded-0 p-0 text-right g-font-size-16"
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
                                <div
                                    style="width: 100%; height: 60px; position: relative; background-position: center center"
                                    class="d-none load g-mt-20"></div>
                                <div style="padding: 0 !important; overflow: hidden; z-index: 10001"
                                     class="modal fade hideScrollBar g-width--360 mx-auto"
                                     id="postMsgModal"
                                     tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalCenterTitle"
                                     aria-hidden="true">
                                    <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered"
                                         role="document">
                                        <div class="modal-content">
                                            <div style="position: relative" class="d-block g-ma-20">
                                                <img class="w-100"
                                                     src=""
                                                     alt="Image Description">
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
                                                    <div style="cursor: pointer"
                                                         class="d-inline-block g-py-10 g-px-20 g-color-gray-dark-v1">
                                                        <span><i
                                                                class="icon-paper-plane u-line-icon-pro g-font-size-16 align-middle"></i></span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    style="width: 100%; height: 60px; position: relative; background-position: center center"
                                    class="d-none load g-mt-20"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--مودال ریل رویدادها-->
    <div style="padding: 0 !important; overflow: hidden; z-index: 10001" class="modal fade hideScrollBar"
         id="allEvents"
         tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
            <div style="height: 100vh;" class="modal-content">
                <div style="position: relative;" id="eventContainer" class="opacity-0">
                    <div style="position: relative;" class="g-width--360 mx-auto">
                        <button
                            style=" cursor: pointer; outline: 0; position: absolute; z-index: 1000"
                            type="button"
                            class="g-brd-none g-bg-transparent g-px-15 g-color-white align-self-center"
                            data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true" class="g-font-size-40">&times;</span>
                        </button>
                    </div>
                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            @foreach($events as $key => $row)
                                <span class="d-none" id="eventID-{{$key}}">{{$row->eventID}}</span>
                                <div class="swiper-slide pauseTimer">
                                    <div style="position: relative">
                                        <div style="width: 98%; border-radius: 5px; position: fixed; top: 2px; left: 1%"
                                             class="g-bg-white-opacity-0_5">
                                            <div id="progress-{{$key}}"
                                                 class="g-bg-primary g-height-3 g-rounded-5 slide-width-0"></div>
                                        </div>
                                        <div
                                            style="direction: rtl; position: fixed; top: 10px; right:10px; width: inherit"
                                            class="g-pa-5 text-right">
                                            <div class="p-0 text-right d-flex">
                                                <img
                                                    class="g-width-45 g-height-45 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                                                    src="{{$row->profileImage=='img/SellerMajorProfileImage/Default/icon.jpg'?asset($row->profileImage):asset($row->profileImage).'/profileImg.jpg?'.date('Y-m-d H:i:s')}}"
                                                    alt="Image Description">
                                                <span style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3)"
                                                      class="g-font-size-16 g-color-white g-font-weight-600 align-self-center g-mr-5">{{$row->name}}</span>
                                                <small style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3); cursor: pointer"
                                                       class="{{is_null($row->following) || $row->FollowStatus===''?'':'d-none'}} g-font-weight-600 align-self-center g-color-primary g-mr-5 g-mb-0 user-{{$row->sellerMajorID}}"
                                                       onclick="following($(this),{{$row->sellerMajorID}})">دنبال
                                                    کن</small>
                                            </div>
                                        </div>
                                        <img style="height: 100vh; object-fit: cover" class="w-100" alt=""
                                             src="{{asset($row->eventPic.'/'.$row->eventID.'.jpg')}}">
                                        <div style="position: fixed; bottom:20px" class="w-100 text-center">
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
                        <div style="height: 90%; top: 0; padding-left: 25%" class="swiper-button-next"></div>
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

    <!--کپی پیش نمایش پست ها-->
    <div class="col-lg-2 col-4 g-brd-around g-brd-white p-0 d-none postSampleCopy" id="postSample-">
        <a class="d-block u-block-hover u-bg-overlay g-bg-black-opacity-0_3--after g-bg-transparent--hover--after"
           href="#"
           data-toggle="modal"
           data-target="#postRail">
            <img class="img-fluid u-block-hover__main--zoom-v1"
                 src=""
                 alt="Image Description">
        </a>
    </div>

    <!--کپی ریل پست ها-->
    <div class="d-none postContainerCopy">
        <div class="col-12 col-lg-3 mx-auto p-0 postID- detailPost">
            <span class="d-none sellerMajorID"></span>
            <span class="d-none postID"></span>
            <!--پروفایل کاربر-->
            <div style="direction: rtl" class="g-pa-5 text-right">
                <div class="col-12 p-0 text-right d-flex justify-content-between">
                    <div>
                        <img id="postProfileImg"
                             class="g-width-30 g-height-30 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                             src=""
                             alt="Image Description">
                        <span id="postProfileName"
                              class="g-font-size-13 g-font-weight-600"></span>
                    </div>
                    <h6 class="d-none align-self-center g-ml-10 g-mb-0 g-color-primary followingBtn">دنبال کن</h6>
                </div>
            </div>

            <!--وضعیت بازدید پست-->
            <div style="position: relative" class="d-block">
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
                            <a id="savePost" class="g-color-gray-dark-v3" href="#!">
                                <i class="fa fa-bookmark-o g-font-size-20 g-line-height-0_7"></i>
                            </a>
                        </div>
                        <div>
                            <a class="g-color-gray-dark-v1 g-ml-10 postMsg"
                               href="#postMsgModal"
                               data-toggle="modal"
                               data-target="#postMsgModal">
                                <i class="icon-paper-plane u-line-icon-pro g-font-size-17 g-font-weight-600 g-line-height-0_7"></i>
                            </a>
                            <a class="g-color-gray-dark-v1 g-ml-10 accordionBtn accordionBtnComment"
                               data-toggle="collapse"
                               data-parent="#accordion-04" aria-expanded="true">
                                <i class="icon-bubble u-line-icon-pro g-font-size-17 g-font-weight-600 g-line-height-0_7"></i>
                            </a>
                            <a id="likePost" class="g-color-gray-dark-v1 g-ml-10" href="#!">
                                <i class="g-font-size-17 g-font-weight-600 g-line-height-0_7"></i>
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
                       class="p-0 g-mt-10 text-right g-mb-0 g-color-black col-10 ml-auto g-font-size-13 g-font-weight-600"></p>
                    <div class="d-none g-font-size-13 cat"><span class="g-font-weight-600">دسته بندی</span><span
                            id="cat"></span></div>
                    <div class="d-none g-font-size-13 productName"><span class="g-font-weight-600">نام محصول</span><span
                            id="productName"></span></div>
                    <div class="d-none g-font-size-13 size"><span class="g-font-weight-600">سایز</span><span
                            id="size"></span></div>
                    <div class="d-none g-font-size-13 color"><span class="g-font-weight-600">رنگ</span><span
                            id="color"></span></div>
                    <div class="d-none g-font-size-13 price"><span class="g-font-weight-600">قیمت</span><span
                            id="price"></span>تومان
                    </div>
                    <div class="d-none g-font-size-13 discount"><span class="g-font-weight-600">تخفیف</span><span
                            id="discount"></span>%
                    </div>
                    <div class="d-none g-font-size-13 finalPrice"><span class="g-font-weight-600">قیمت نهایی</span><span
                            id="finalPrice"></span>تومان
                    </div>
                    <p id="detail" style="white-space: pre-wrap;"></p>
                </div>
                <div class="commentReplyShow">
                    <a class="g-color-gray-dark-v2 w-100"
                       href="#!">
                        <div style="cursor: pointer" id="allCommentContainer"
                             class="g-font-weight-600 g-mx-5 g-font-size-12 g-color-gray-dark-v4 d-flex col-12 g-px-5 justify-content-end">
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
                                                      class="form-control commentText growingToTop col-10 ml-auto hideScrollBar g-brd-none form-control-md g-resize-none rounded-0 p-0 text-right g-font-size-16"
                                                      tabindex="1"
                                                      value=""
                                                      placeholder="نظر شما.."
                                                      maxlength="300"></textarea>
                                        <div class="g-pl-5">
                                            <img
                                                class="g-width-20 g-height-20 rounded-circle commenterProfileImg"
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
