@extends('Layouts.IndexCustomer')
@section('Content')
    <span id="asset" class="d-none">{{asset('/')}}</span>
    <span class="d-none sellerMajorPanel"></span>
    <span id="postLen" class="d-none">{{$postsCount}}</span>
    <span id="postLoaded" class="d-none">0</span>
    <span id="postCat" class="d-none">{{$cat}}</span>
    <span id="commentReplyID" class="d-none"></span>
    <span id="customer_Id" class="d-none">{{isset(Auth::user()->id)?Auth::user()->id:-1}}</span>

    <div class="container g-mt-15">
        <div class="input-group">
            <div style="position: absolute; top:13px; left:10px; z-index: 10" class="input-group-prepend">
                <span class="input-group-text rounded-0 g-bg-white g-color-gray-light-v1"><i class="icon-magnifier"></i></span>
            </div>
            <input id="searchInput" autocomplete="off"
                   class="form-control form-control-md g-rounded-10 g-pl-30"
                   oninput="search($(this).val(),'explore')"
                   type="text"
                   onclick="$('#catList').collapse('show')"
                   placeholder="..">
        </div>
        <ul id="searchResult" class="list-unstyled"></ul>
        <div class="text-right">
            <div class="collapse" id="catList">
                <div class="card card-body">
                    <div style="overflow-x: scroll" class="hideScrollBar-x hideScrollBar row g-pa-20">
                        <a href="{{route('cSSearch','all')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/all.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">همه</h6>
                        </a>
                        <a href="{{route('cSSearch','clothes')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/clothe.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">پوشاک</h6>
                        </a>
                        <a href="{{route('cSSearch','vehicles')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/cars.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">وسایل نقلیه</h6>
                        </a>
                        <a href="{{route('cSSearch','sports')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/sport.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">وسایل ورزشی</h6>
                        </a>
                        <a href="{{route('cSSearch','estate')}}"  class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/build.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">املاک</h6>
                        </a>
                        <a href="{{route('cSSearch','electronic')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/electric.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">لوازم الکترونیکی</h6>
                        </a>
                        <a href="{{route('cSSearch','industrial')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/office.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">صنعتی، اداری و تجاری</h6>
                        </a>
                        <a href="{{route('cSSearch','services')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/service.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">خدمات و کسب و کار</h6>
                        </a>
                        <a href="{{route('cSSearch','connections')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/connect.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">وسایل ارتباطی</h6>
                        </a>
                        <a href="{{route('cSSearch','appliances')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/homeTools.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">لوازم خانگی</h6>
                        </a>
                        <a href="{{route('cSSearch','personal')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/personal.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">لوازم شخصی</h6>
                        </a>
                        <a href="{{route('cSSearch','content')}}" class="col-3 col-lg-1 g-color-gray-dark-v3 text-center">
                            <div class="g-pa-20 g-pb-0">
                                <img class="w-100"
                                     src="{{asset('img/icons/content.png')}}"
                                     alt="">
                            </div>
                            <h6 class="g-font-weight-600 g-mt-10">تولید محتوا</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--پیش نمایش پست ها-->
    <div style="min-height: 100vh" class="container g-px-10--lg g-px-0 searchPage">
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
        <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
            <span id="postLen" class="d-none">{{$postsCount}}</span>
            <span id="postLoaded" class="d-none">0</span>
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
                                                <a onclick="checkLogin($(this),{{$rec->sellerMajorID}})"
                                                   class="g-color-gray-dark-v3">
                                                    <img
                                                        class="g-width-45 g-height-45 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                                                        src="{{$rec->sellerMajorPic=='img/SellerMajorProfileImage/Default/icon.jpg'?asset($rec->sellerMajorPic):asset($rec->sellerMajorPic).'/profileImg.jpg?'.date('Y-m-d H:i:s')}}"
                                                        alt="Image Description">
                                                    <span
                                                        class="g-font-size-16 g-font-weight-600">{{$rec->name}}</span>
                                                </a>
                                                <h6 style="cursor: pointer"
                                                    class="{{is_null($rec->following)?'':'d-none'}} g-color-primary align-self-center g-ml-10 g-mb-0 user-{{$rec->sellerMajorID}}"
                                                    onclick="following($(this),{{$rec->sellerMajorID}})">دنبال کن</h6>
                                                <h6 style="cursor: pointer"
                                                    class="{{is_null($rec->following)?'d-none':''}} instagramLink{{$rec->sellerMajorID}} g-color-primary align-self-center g-mb-0">
                                                    <a style="color: #7fc242 !important;" href="https://www.instagram.com/{{$rec->Instagram}}"
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
                                        <div style="position:relative; z-index: 100"  class="g-pa-10 g-pb-0">
                                            <div>
                                                <div class="text-left d-flex justify-content-between">
                                                    <div>
                                                        <a class="g-color-gray-dark-v3" href="#!"
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
                        class="g-font-size-12 g-font-weight-600 g-color-gray-dark-v2"></span>
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
                                <i class="fa fa-bookmark-o g-font-size-22 g-line-height-0_7"></i>
                            </a>
                        </div>
                        <div>
                            <a class="g-color-gray-dark-v1 g-ml-10 postMsg"
                               href="#postMsgModal"
                               data-toggle="modal"
                               data-target="#postMsgModal">
                                <i class="icon-paper-plane u-line-icon-pro g-font-size-20 g-font-weight-600 g-line-height-0_7"></i>
                            </a>
                            <a class="g-color-gray-dark-v1 g-ml-10 accordionBtn accordionBtnComment"
                               data-toggle="collapse"
                               data-parent="#accordion-04" aria-expanded="true">
                                <i class="icon-bubble u-line-icon-pro g-font-size-20 g-font-weight-600 g-line-height-0_7"></i>
                            </a>
                            <a id="likePost" class="g-color-gray-dark-v1 g-ml-10" href="#!">
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
                                                  class="form-control commentText growingToTop col-10 ml-auto hideScrollBar g-brd-none form-control-md g-resize-none rounded-0 p-0 text-right g-font-size-16"
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
