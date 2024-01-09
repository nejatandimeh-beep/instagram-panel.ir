@extends('Layouts.IndexAdmin')
@section('Content')
    <span id="asset" class="d-none">{{asset('/')}}</span>
    <span id="sellerMajorID" class="d-none">{{$data->id}}</span>
    <span id="eventLen" class="d-none">{{count($events)}}</span>
    <span id="postLen" class="d-none">{{$postsCount}}</span>
    <span id="postLoaded" class="d-none">0</span>
    <span id="userID" class="d-none">{{$data->id}}</span>
    <span id="commentReplyID" class="d-none"></span>
    <section class="allPost profileMenu">
        <!--Bio-->
        <div class="container">
            <div style="direction: rtl" class="row">
                <div class="col-lg-4 g-mb-0">
                    <!-- End User Details -->
                    <!-- User Image -->
                    <div class="g-mb-5 g-mt-10 {{isset($events[0]) ? 'ContainerAnimateBorder':''}}">
                        <div class="g-pos-rel">
                            <figure>
                                <img id="profileImgBox" class="img-fluid w-100 u-block-hover__main--zoom-v1"
                                     style="cursor:pointer;"
                                     src="{{$data->Pic!=''?asset($data->Pic.'/profileImg.jpg'):asset('/img/SellerMajorProfileImage/Default/icon.jpg')}}"
                                     alt="Image Description"
                                     onclick="{{isset($events[0]) ? 'eventShow(0)':''}}">
                            </figure>

                            <!-- Figure Caption -->
                            <figcaption class="g-pa-20 w-100 g-pos-abs g-bottom-0">
                                <div
                                    class="g-flex-middle">
                                    <!-- Figure Social Icons -->
                                    <ul class="list-inline text-center g-flex-middle-item--bottom g-mb-20 p-0">
                                        <li class="list-inline-item align-middle g-mx-5 g-bg-black-opacity-0_4 g-rounded-50x g-pa-5">
                                            <a class="u-icon-v1 u-icon-size--md g-color-white" href="#"
                                               onclick="removeProfileImg()">
                                                <i class="icon-trash u-line-icon-pro"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- End Figure Social Icons -->
                                </div>
                            </figcaption>
                            <!-- End Figure Caption -->
                        </div>
                        <div class="{{isset($events[0]) ? '':'d-none'}}">
                            <span class="topAnimateBorder lineAnimateBorder"></span>
                            <span class="rightAnimateBorder lineAnimateBorder"></span>
                            <span class="bottomAnimateBorder lineAnimateBorder"></span>
                            <span class="leftAnimateBorder lineAnimateBorder"></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 p-0 g-px-20 g-px-0--lg">
                    <!-- User Details -->
                    <div class="d-flex align-items-center g-mt-10 g-mt-0--lg justify-content-between g-mb-5">
                        <h4 class="g-font-weight-500 g-ml-10 g-mb-0">
                            {{$data->name}}
                            <span class="u-label g-mb-0 g-color-gray-dark-v3 g-font-size-16" title="پست ها">
                              <i class="icon-layers g-mr-3"></i> <span id="allPostCount">{{$data->Posts}}</span>
                             </span>
                            <span class="u-label g-mb-0 g-color-gray-dark-v3 g-font-size-16" title="دنبال کنندگان">
                                  <i class="icon-people g-mr-3"></i> {{$data->Followers}}
                             </span>
                        </h4>

                        <ul style="direction: ltr" class="list-inline mb-0">
                            <li class="list-inline-item g-mx-2">
                                <a style="width: 3rem; height: 3rem;"
                                   class="d-inline-block text-center g-color-gray-dark-v3 g-bg-gray-light-v5 rounded-circle"
                                   data-toggle="modal"
                                   data-target="#instagramModal"
                                   onclick="$('#instagram').val('')"
                                   href="#!">
                                    <i style="padding-top: 13px"
                                       class="fa fa-instagram align-middle g-font-size-16 g-color-gray-dark-v2"></i>
                                </a>
                                <!--modalInstagram-->
                                <div style="direction: rtl; overflow-y: scroll" class="modal fade text-center" id="instagramModal"
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
                                                            <h6 class="d-flex justify-content-between">
                                                                <a href="{{$data->Instagram !== '' ? 'https://instagram.com/'.$data->Instagram : '#'}}"
                                                                   class="g-text-underline--none--hover g-color-primary">
                                                                        <span id="instagramLink"
                                                                              class="h5 g-ml-5">{{$data->Instagram !== '' ? $data->Instagram : 'خالی'}}</span>
                                                                </a>
                                                                <span>آدرس فعلی</span>
                                                            </h6>
                                                            <div class="input-group">
                                                               <textarea id="instagram"
                                                                         autofocus
                                                                         oninput="if($(this).val()==='') $('#submitInstagram').addClass('d-none'); else $('#submitInstagram').removeClass('d-none')"
                                                                         class="form-control g-font-size-16 form-control-md g-resize-none g-brd-0 rounded-0 pl-0 g-bg-transparent"
                                                                         maxlength="300" rows="4"
                                                                         placeholder="آدرس جدید.."></textarea>
                                                            </div>
                                                            <div class="d-flex">
                                                                <a href="#" onclick="socialAddressUpdate('instagram',$(this))" id="submitInstagram"
                                                                   class="d-none g-text-underline--none--hover g-color-gray-dark-v3 g-color-primary--hover">
                                                                    <span
                                                                        class="u-icon-v3 u-icon-size--sm g-mr-15 g-mb-15 g-rounded-50x">
                                                                        <i id="instagramUpdateIcon"
                                                                           class="fa fa-check u-line-icon-pro"></i>
                                                                        <i id="instagramUpdateWaiting"
                                                                           class="d-none fa fa-spinner fa-spin g-line-height-0 align-middle"></i>
                                                                    </span>
                                                                </a>
                                                                <div id="adContainer" class="g-mt-10 {{$data->Instagram !== '' ? '' : 'd-none'}}">
                                                                    <div style="direction: rtl" class="form-group m-0">
                                                                        <label
                                                                            class="d-flex align-items-center justify-content-between m-0">
                                                                            <span class="h5 m-0">شرکت در کمپین تبلیغات</span>
                                                                            <div class="u-check g-mr-10">
                                                                                <input
                                                                                    class="hidden-xs-up g-pos-abs g-top-0 g-right-0 radioBtn radioBtn"
                                                                                    name="advertising"
                                                                                    {{$data->Advertising === '1' ? 'checked=""':''}}
                                                                                    onchange="membership($(this))"
                                                                                    type="checkbox">
                                                                                <div style="width: 53px; height: 26px" class="u-check-icon-radio-v8">
                                                                                    <i class="fa"
                                                                                       style="color: #72c02c !important"
                                                                                       data-check-icon=""></i>
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                    <h4 class="h6 g-font-size-16 g-font-weight-300 g-mb-5">
                        <i class="icon-badge g-pos-rel g-top-1 g-ml-5 g-color-gray-dark-v5"></i> {{$data->HintCategory}}
                    </h4>
                    <!-- End User Position -->

                    <!-- User Info -->
                    <ul class="list-inline g-mb-5 g-mb-15--lg g-font-weight-300 g-pl-40 g-pr-0">
                        <li class="list-inline-item g-ml-20 g-mr-0 d-none">
                            <i class="icon-check g-pos-rel g-top-1 g-color-gray-dark-v5 g-ml-5"></i> اعتبارسنجی
                        </li>
                        <li class="list-inline-item g-ml-20">
                            <a class="g-text-underline--none--hover"
                               data-toggle="modal"
                               data-target="#modalAddress"
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
        <div style="min-height: 100px" class="container g-px-10--lg g-px-0 g-pb-80--lg g-pb-20">
            <div class="row g-mx-1 g-pb-25 g-pb-200--lg" id="postSampleContainer">
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
        <div style="padding: 0 !important;" class="hideScrollBar g-bg-white modal fade bd-example-modal-lg"
             id="postRail"
             tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
                <div style="min-height: 100vh" class="g-brd-none modal-content g-pb-80">
                    <div>
                        <div class="p-0">
                            <div>
                                <div class="large-12 columns p-0" id="postDetailContainer">
                                    <div style="position: sticky; top: 0; z-index: 11000"
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
                                        <div class="col-12 col-lg-3 mx-auto p-0 postID-{{$rec->postID}}"
                                             id="detailPost-{{$key}}">
                                            <span class="d-none postID">{{$rec->postID}}</span>
                                            <!--پروفایل کاربر-->
                                            <div style="direction: rtl" class="g-pa-5 text-right">
                                                <div class="col-12 p-0 text-right">
                                                    <img
                                                        class="g-width-45 g-height-45 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                                                        src="{{asset($data->Pic.'/profileImg.jpg')}}"
                                                        alt="Image Description">
                                                    <span
                                                        class="g-font-size-16 g-font-weight-600">{{$data->name}}</span>
                                                </div>
                                            </div>

                                            <!--وضعیت بازدید پست-->
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
                                                <div
                                                    style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index:9999"
                                                    class="g-bg-black-opacity-0_5 postChart d-none">
                                                    <div class="g-pa-30">
                                                        <div class="g-mb-10">
                                                            <h6 class="g-color-white g-mb-5 text-right">وضعیت بازدید
                                                                پست</h6>
                                                        </div>
                                                        <div
                                                            class="d-flex g-brd-top g-brd-gray-light-v5 g-pt-5 justify-content-around text-right">
                                                            <div>
                                                                <div>
                                                                        <span
                                                                            class="u-icon-v1 g-mb-5 g-bg-black-opacity-0_3">
                                                                          <i class="fa fa-bookmark g-color-gray-light-v5"></i>
                                                                        </span>
                                                                </div>
                                                                <p class="text-center g-font-size-18 g-color-white saveCount">
                                                                    0</p>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                        <span
                                                                            class="u-icon-v1 g-mb-5 g-bg-black-opacity-0_3">
                                                                          <i class="fa fa-comment g-color-gray-light-v5"></i>
                                                                        </span>
                                                                </div>
                                                                <p class="text-center g-font-size-18 g-color-white commentCount">
                                                                    0</p>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                        <span
                                                                            class="u-icon-v1 g-mb-5 g-bg-black-opacity-0_3">
                                                                          <i class="fa fa-heart g-color-gray-light-v5"></i>
                                                                        </span>
                                                                </div>
                                                                <p class="text-center g-font-size-18 g-color-white likeCount">
                                                                    0</p>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                        <span
                                                                            class="u-icon-v1 g-mb-5 g-bg-black-opacity-0_3">
                                                                          <i class="fa fa-eye g-color-gray-light-v5"></i>
                                                                        </span>
                                                                </div>
                                                                <p class="text-center g-font-size-18 g-color-white visitCount">
                                                                    0</p>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                        <span
                                                                            class="u-icon-v1 g-mb-5 g-bg-black-opacity-0_3">
                                                                          <i class="fa fa-bullseye g-color-gray-light-v5"></i>
                                                                        </span>
                                                                </div>
                                                                <p class="text-center g-font-size-18 g-color-white allVisitCount">
                                                                    0</p>
                                                            </div>
                                                        </div>

                                                        <!-- Progress Bar -->
                                                        <div style="direction: rtl" class="g-mb-10">
                                                            <h6 class="g-color-white g-mb-5 text-right">میزان علاقه
                                                                مندی</h6>
                                                            <span class="likePercent g-color-white">نامعلوم</span>
                                                        </div>

                                                        <div class="g-mb-10 text-right">
                                                            <h6 class="g-color-white g-mb-5 text-right">میزان تعامل</h6>
                                                            <span class="engagementPercent g-color-white">نامعلوم</span>
                                                        </div>

                                                        <!-- End Progress Bar -->

                                                        <div class="g-mb-30">
                                                            <h6 class="g-color-white g-mb-5 text-right">تاریخ افزودن
                                                                پست</h6>
                                                            <em class="d-block g-color-white g-font-style-normal g-font-size-13 postDate text-right"></em>
                                                            <em class="d-block g-color-white g-font-style-normal g-font-size-11 postTime g-mb-5 text-right"></em>
                                                        </div>
                                                    </div>
                                                    <div style="position: absolute; bottom: 35px; width: 100%"
                                                         class="d-flex col-12">
                                                        <div class="">
                                                            <span style="cursor: pointer"
                                                                  onclick="deletePost({{$rec->postID}},{{$key}})"
                                                                  class="g-pa-10">
                                                                <i class="icon-trash g-font-size-20 g-color-white deleteIcon"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- If we need pagination -->
                                                <div style="bottom: -31px;"
                                                     class="swiper-pagination swiper-pagination{{$key}}"></div>
                                            </div>

                                            <!--اشتراک گذاری-->
                                            <div style="position: relative; z-index: 100" class="g-pa-10 g-pb-0">
                                                <div>
                                                    <div class="text-left d-flex justify-content-between">
                                                        <div>
                                                            <a class="g-color-gray-dark-v3" href="#!"
                                                               onclick="postChart($(this),{{$rec->postID}},{{$key}})">
                                                                <i class="fa fa-ellipsis-h align-middle g-font-size-23 g-line-height-0_7"></i>
                                                            </a>
                                                        </div>
                                                        <div style="direction: rtl">
                                                            <h6 class="d-inline-block p-0 m-0 text-right likeCount">
                                                                <small
                                                                    class="g-font-weight-600">{{$rec->LikeCount===0?'':$rec->LikeCount.' پسند'}}</small>
                                                            </h6>
                                                            <a class="g-color-gray-dark-v1 accordionBtn"
                                                               href="#accordion-04-body-{{$key}}"
                                                               data-toggle="collapse"
                                                               id="accordionBtn-{{$key}}"
                                                               data-parent="#accordion-04" aria-expanded="true"
                                                               aria-controls="accordion-04-body-{{$key}}"
                                                               onclick="addComments({{$rec->postID}},{{$key}})">
                                                                <i class="icon-bubble u-line-icon-pro align-middle g-font-size-20 g-pr-5 g-font-weight-600 g-line-height-0_7"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--کامنت ها-->
                                            <div class="g-px-10">
                                                <div onclick="copy($(this).text())" style="direction: rtl;">
                                                    <p
                                                        class="p-0 g-mt-10 text-right g-mb-0 g-color-black col-10 ml-auto g-font-size-16 g-font-weight-600">{{$data->name}}</p>
                                                    <div class="{{is_null($rec->Cat) ? 'd-none':''}} g-font-size-14">
                                                        <span
                                                            class="g-font-weight-600">دسته بندی</span>{{' '.$rec->Cat}}
                                                        <span id="cat-{{$rec->postID}}"
                                                              class="d-none captionInfo-{{$rec->postID}} g-py-5 g-px-10"
                                                              onclick="deletePostInfo({{$rec->postID}},'cat')"><i
                                                                class="fa fa-close g-color-red"></i></span></div>
                                                    <div
                                                        class="{{is_null($rec->ProductName) ? 'd-none':''}} g-font-size-14">
                                                        <span
                                                            class="g-font-weight-600">نام محصول</span>{{' '.$rec->ProductName.' '.$rec->Gender}}
                                                        <span id="productName-{{$rec->postID}}"
                                                              class="d-none captionInfo-{{$rec->postID}} g-py-5 g-px-10"
                                                              onclick="deletePostInfo({{$rec->postID}},'productName')"><i
                                                                class="fa fa-close g-color-red"></i></span></div>
                                                    <div class="{{is_null($rec->Size) ? 'd-none':''}} g-font-size-14">
                                                        <span class="g-font-weight-600">سایز</span>{{' '.$rec->Size}}
                                                        <span id="size-{{$rec->postID}}"
                                                              class="d-none captionInfo-{{$rec->postID}} g-py-5 g-px-10"
                                                              onclick="deletePostInfo({{$rec->postID}},'size')"><i
                                                                class="fa fa-close g-color-red"></i></span></div>
                                                    <div class="{{is_null($rec->Color) ? 'd-none':''}} g-font-size-14">
                                                        <span class="g-font-weight-600">رنگ</span>{{' '.$rec->Color}}
                                                        <span id="color-{{$rec->postID}}"
                                                              class="d-none captionInfo-{{$rec->postID}} g-py-5 g-px-10"
                                                              onclick="deletePostInfo({{$rec->postID}},'color')"><i
                                                                class="fa fa-close g-color-red"></i></span></div>
                                                    <div class="{{is_null($rec->Price) ? 'd-none':''}} g-font-size-14">
                                                        <span
                                                            class="g-font-weight-600">قیمت</span>{{' '.number_format($rec->Price).' تومان'}}
                                                        <span id="price-{{$rec->postID}}"
                                                              class="d-none captionInfo-{{$rec->postID}} g-py-5 g-px-10"
                                                              onclick="deletePostInfo({{$rec->postID}},'price')"><i
                                                                class="fa fa-close g-color-red"></i></span></div>
                                                    <div
                                                        class="{{is_null($rec->Discount) ? 'd-none':''}} g-font-size-14">
                                                        <span
                                                            class="g-font-weight-600">تخفیف</span>{{' '.$rec->Discount.' %'}}
                                                        <span id="discount-{{$rec->postID}}"
                                                              class="d-none captionInfo-{{$rec->postID}} g-py-5 g-px-10"
                                                              onclick="deletePostInfo({{$rec->postID}},'discount')"><i
                                                                class="fa fa-close g-color-red"></i></span></div>
                                                    <div
                                                        class="{{is_null($rec->FinalPrice) ? 'd-none':''}} g-font-size-14">
                                                        <span
                                                            class="g-font-weight-600">قیمت نهایی</span>{{' '.number_format($rec->FinalPrice).' تومان'}}
                                                        <span id="finalPrice-{{$rec->postID}}"
                                                              class="d-none captionInfo-{{$rec->postID}} g-py-5 g-px-10"
                                                              onclick="deletePostInfo({{$rec->postID}},'finalPrice')"><i
                                                                class="fa fa-close g-color-red"></i></span></div>
                                                    <div id="editPostCaption-{{$rec->postID}}">
                                                        <p style=" white-space: pre-wrap;">{{$rec->Text}}</p>
                                                        <div class="d-none">
                                                            <textarea style="height: 200px; white-space: pre-wrap;"
                                                                      class="form-control growingToTop col-10 ml-auto hideScrollBar g-brd-none form-control-md g-resize-none rounded-0 p-0 text-right g-font-size-16">{{$rec->Text}}</textarea>
                                                            <label class="u-check g-mr-15 mb-0 pull-left"
                                                                   onclick="saveCaption($(this),{{$rec->postID}})">
                                                                <div
                                                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-primary--hover">
                                                                    <i class="fa fa-check g-absolute-centered"></i>
                                                                </div>
                                                            </label>
                                                            <label class="u-check g-mr-15 mb-0 pull-left"
                                                                   onclick="cancelEditCaption({{$rec->postID}})">
                                                                <div
                                                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-lightred--hover">
                                                                    <i class="fa fa-close g-absolute-centered"></i>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
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
                                                                                src="{{asset($data->Pic.'/profileImg.jpg')}}"
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--مودال ساخت رویدادها-->
        <div style="direction: rtl" class="modal fade bd-example-modal-lg" id="eventModal"
             tabindex="-1" role="dialog"
             aria-labelledby="eventModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered m-0 mx-lg-auto" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="eventModalCenterTitle">افزودن رویداد</h6>
                        <button type="button"
                                class="g-brd-none g-bg-transparent g-font-size-20 g-line-height-0 align-self-center"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="col-md-12 p-0">
                                <img style="width: 100%;" src="" id="event_sample_image">
                            </div>
                            {{--                        <div class="col-md-4">--}}
                            {{--                            <div class="preview rounded-circle mx-auto g-mt-20"></div>--}}
                            {{--                        </div>--}}
                        </div>
                        <div>
                            <div class="input-group">
                           <textarea id="eventTextTemp"
                                     autofocus
                                     class="form-control form-control-md g-font-size-16 g-resize-none g-brd-0 rounded-0 pl-0 g-bg-transparent"
                                     maxlength="100" rows="4" placeholder="متن..(100) کاراکتر"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="addEventButton" class="text-left">
                            <label class="u-check g-mr-15 mb-0" data-dismiss="modal">
                                <div
                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-lightred--hover">
                                    <i class="fa fa-close g-absolute-centered"></i>
                                </div>
                            </label>
                            <label class="u-check g-mr-15 mb-0" id="eventCrop">
                                <div
                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-primary--hover">
                                    <i id="eventSubmitIcon" class="fa fa-check g-absolute-centered"></i>
                                    <i style="margin: -7px" id="waitingEventCrop"
                                       class="d-none fa fa-spinner fa-spin g-absolute-centered g-color-gray-dark-v3"></i>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--مودال ریل رویدادها-->
        <div style="padding: 0 !important; overflow: hidden; z-index: 10001" class="modal fade bd-example-modal-lg"
             id="allEvents"
             tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
                <div style="height: 100vh;" class="modal-content">
                    <div>
                        <div class="home-demo p-0">
                            <div>
                                <div class="large-12 columns p-0">
                                    <div style="float: none; margin: auto; position: relative"
                                         class="owl-demo g-width-350--lg">
                                        <div id="leftSlide"
                                             style="position: absolute; height: 70%; width: 25%; top: 15%; left: 0; z-index: 9999"></div>
                                        <div id="rightSlide"
                                             style="position: absolute; height: 70%; width: 25%; top: 15%; right: 0; z-index: 9999"></div>
                                        <!--owl dots-->
                                        <div class="d-flex owlContainer">
                                            @foreach($events as $key => $row)
                                                <div id="dot-{{$key}}" class="owlDots {{$key ==0?'g-ml-0':'g-ml-2'}}">
                                                    <div class="slide-progress-main g-bg-gray-light-v2">
                                                        <div
                                                            class="slide-progress {{$key == 0 ?'slide-width-0 slide-0':'slide-width-100 otherTimeBar slide-'.$key}}"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!--owl items-->
                                        <div class="owl-carousel owl-theme">
                                            @foreach($events as $key => $row)
                                                <div style="position: relative" id="item-{{$key}}" class="item">
                                                    <div style="position: relative;
                                                        background-position: center;
                                                        background-size: cover;
                                                        background-repeat: no-repeat;
                                                        background-color: #3a3f50;
                                                        top: 0;
                                                        left: 0;
                                                        height: 100vh;"
                                                         id="eventBackground-{{$key.'-'.$row->eventID}}"
                                                         class="eventContainer vw-100">
                                                        <div style="position: absolute; bottom: 0;"
                                                             class="w-100 g-pa-15">
                                                            <div class="text-center">
                                                                <h5 style="direction: rtl;"
                                                                    class="{{$row->Text=='' ? 'd-none ':''}}g-color-white text-center g-bg-black-opacity-0_7 g-pa-10 h6 g-mb-3">{{$row->Text}}</h5>
                                                                <div
                                                                    class="g-color-white text-left g-bg-black-opacity-0_7">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div class="align-self-center">
                                                                             <span style="position: relative"
                                                                                   class="u-label g-mb-0 g-color-white g-font-size-15 g-font-weight-500 align-middle g-line-height-0 p-0 g-px-5"
                                                                                   title="ذخیره شده">
                                                                                <i class="fa fa-bookmark-o g-mr-5"></i>
                                                                                <small
                                                                                    style="position: absolute; bottom: 0; right:3px"
                                                                                    class="align-middle g-font-size-10">{{$row->SaveCount}}</small>
                                                                             </span>
                                                                            <span style="position: relative"
                                                                                  class="u-label g-mb-0 g-color-white g-font-size-15 g-font-weight-500 align-middle g-line-height-0 p-0 g-px-5"
                                                                                  title="علاقه مندی">
                                                                                <i class="fa fa-heart-o g-mr-5"></i>
                                                                                <small
                                                                                    style="position: absolute; bottom: 0; right:5px"
                                                                                    class="align-middle g-font-size-10">{{$row->LikeCount}}</small>
                                                                             </span>
                                                                            <span style="position: relative"
                                                                                  class="u-label g-mb-0 g-color-white g-font-size-15 g-font-weight-500 align-middle g-line-height-0 p-0 g-px-5"
                                                                                  title="مشاهده شده">
                                                                                <i class="icon-eye g-mr-5"></i>
                                                                                <small
                                                                                    style="position: absolute; bottom: 0;"
                                                                                    class="align-middle g-font-size-10">{{$row->VisitCount}}</small>
                                                                             </span>
                                                                        </div>
                                                                        <a class="u-icon-v1 u-icon-size--md g-color-white"
                                                                           href="#!"
                                                                           onclick="removeEvent({{$row->eventID}})">
                                                                            <i class="icon-trash u-line-icon-pro"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        style="direction: ltr; border: 0 !important; position: absolute; top:20px; z-index: 9999"
                                                        class="w-100">
                                                        <div class="d-flex justify-content-between col-12 g-px-10">
                                                            <button style="outline: 0; cursor:pointer;" type="button"
                                                                    id="closeEventModal"
                                                                    class="g-brd-none g-bg-transparent g-font-size-20 g-line-height-0_7 align-self-center"
                                                                    data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span
                                                                    class="g-font-size-30 g-color-white g-font-weight-600"
                                                                    aria-hidden="true">&times;</span>
                                                            </button>
                                                            <small style="direction: rtl"
                                                                   class="g-color-white text-center g-px-5">{{$eventHowDay[$key]}}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--مودال تصویر پروفایل-->
        <div style="direction: rtl" class="modal fade bd-example-modal-lg" id="modal"
             tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">تنظیم تصویر پروفایل</h5>
                        <button type="button"
                                class="g-brd-none g-pa-15 g-bg-transparent g-font-size-20 g-line-height-0 align-self-center"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="col-md-12 p-0">
                                <img style="width: 100%;" src="" id="sample_image">
                            </div>
                            {{--                        <div class="col-md-4">--}}
                            {{--                            <div class="preview rounded-circle mx-auto g-mt-20"></div>--}}
                            {{--                        </div>--}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="addEventButton" class="text-left">
                            <label class="u-check g-mr-15 mb-0"
                                   data-dismiss="modal">
                                <div
                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-lightred--hover">
                                    <i class="fa fa-close g-absolute-centered"></i>
                                </div>
                            </label>
                            <label class="u-check g-mr-15 mb-0" id="crop">
                                <div
                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-primary--hover">
                                    <i id="profileImgSubmitIcon" class="fa fa-check g-absolute-centered"></i>
                                    <i style="margin: -7px" id="waitingCrop"
                                       class="d-none fa fa-spinner fa-spin g-absolute-centered g-color-gray-dark-v3"></i>
                                </div>
                            </label>
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
                            <div class="m-0 g-mb-10">
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
                                      class="deleteComment g-font-weight-600 g-mx-5 g-color-gray-dark-v4">
                                    <i class="icon-trash"></i>
                                </span>
                            </div>
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
                        <div class="g-pr-10">
                            <p style="min-width: 150px; border-radius: 6px 0 6px 6px"
                               class="g-font-size-13 g-color-gray-dark-v1 g-px-5 g-pb-0 m-0 commentText">

                            </p>
                            <div class="m-0 g-mb-10">
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
                                      class="deleteCommentReply g-font-weight-600 g-mx-5 g-color-gray-dark-v4">
                                    <i class="icon-trash"></i>
                                </span>
                            </div>
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
                <span class="d-none postID"></span>
                <!--پروفایل کاربر-->
                <div style="direction: rtl" class="g-pa-5 text-right">
                    <div class="col-12 p-0 text-right">
                        <img id="postProfileImg"
                             class="g-width-45 g-height-45 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                             src=""
                             alt="Image Description">
                        <span id="postProfileName"
                              class="g-font-size-16 g-font-weight-600"></span>
                    </div>
                </div>
                <!--وضعیت بازدید پست-->
                <div style="position: relative" class="d-block">
                    <div style="position: relative" class="d-block">
                        <div style="height: auto" class="swiper containerSwiper">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                            </div>
                        </div>
                    </div>
                    <div
                        style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index:9999"
                        class="g-bg-black-opacity-0_5 postChart d-none">
                        <div class="g-pa-30">
                            <div class="g-mb-10">
                                <h6 class="g-color-white g-mb-5 text-right">وضعیت بازدید پست</h6>
                            </div>
                            <div
                                class="d-flex g-brd-top g-brd-gray-light-v5 g-pt-5 justify-content-around text-right">
                                <div>
                                    <div>
                                        <span
                                            class="u-icon-v1 g-mb-5 g-bg-black-opacity-0_3">
                                          <i class="fa fa-bookmark g-color-gray-light-v5"></i>
                                        </span>
                                    </div>
                                    <p class="text-center g-font-size-18 g-color-white saveCount">0</p>
                                </div>
                                <div>
                                    <div>
                                        <span
                                            class="u-icon-v1 g-mb-5  g-bg-black-opacity-0_3">
                                          <i class="fa fa-comment g-color-gray-light-v5"></i>
                                        </span>
                                    </div>
                                    <p class="text-center g-font-size-18 g-color-white commentCount">0</p>
                                </div>
                                <div>
                                    <div>
                                        <span
                                            class="u-icon-v1 g-mb-5  g-bg-black-opacity-0_3">
                                          <i class="fa fa-heart g-color-gray-light-v5"></i>
                                        </span>
                                    </div>
                                    <p class="text-center g-font-size-18 g-color-white likeCount">0</p>
                                </div>
                                <div>
                                    <div>
                                        <span
                                            class="u-icon-v1 g-mb-5  g-bg-black-opacity-0_3">
                                          <i class="fa fa-eye g-color-gray-light-v5"></i>
                                        </span>
                                    </div>
                                    <p class="text-center g-font-size-18 g-color-white visitCount">0</p>
                                </div>
                                <div>
                                    <div>
                                        <span
                                            class="u-icon-v1 g-mb-5  g-bg-black-opacity-0_3">
                                          <i class="fa fa-bullseye g-color-gray-light-v5"></i>
                                        </span>
                                    </div>
                                    <p class="text-center g-font-size-18 g-color-white allVisitCount">0</p>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div style="direction: rtl" class="g-mb-10">
                                <h6 class="g-color-white g-mb-5 text-right">میزان علاقه
                                    مندی</h6>
                                <span class="likePercent g-color-white">نامعلوم</span>
                            </div>

                            <!-- End Progress Bar -->

                            <div class="g-mb-10 text-right">
                                <h6 class="g-color-white g-mb-5 text-right">میزان تعامل</h6>
                                <span class="engagementPercent g-color-white">نامعلوم</span>
                            </div>

                            <div class="g-mb-30">
                                <h6 class="g-color-white g-mb-5 text-right">تاریخ افزودن پست</h6>
                                <em class="d-block g-color-white g-font-style-normal g-font-size-13 postDate text-right"></em>
                                <em class="d-block g-color-white g-font-style-normal g-font-size-11 postTime g-mb-5 text-right"></em>
                            </div>
                        </div>
                        <div style="position: absolute; bottom: 35px; width: 100%" class="d-flex col-12">
                            <div class="deletePost">
                                <span style="cursor: pointer" class="g-pa-10">
                                    <i class="icon-trash g-font-size-20 g-color-white deleteIcon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div style="bottom: -31px;" class="paginationSwiper swiper-pagination"></div>
                </div>
                <!--لینک نظرات-->
                <div style="position: relative; z-index: 100" class="g-pa-10 g-pb-0">
                    <div>
                        <div class="text-left d-flex justify-content-between">
                            <div>
                                <a id="postChart" class="g-color-gray-dark-v3" href="#!">
                                    <i class="fa fa-ellipsis-h align-middle g-font-size-23 g-line-height-0_7"></i>
                                </a>
                            </div>
                            <div style="direction: rtl">
                                <h6 class="d-inline-block p-0 m-0 text-right likeCount">
                                    <small class="g-font-weight-600"></small>
                                </h6>
                                <a class="g-color-gray-dark-v1 accordionBtn accordionBtnComment"
                                   data-toggle="collapse"
                                   data-parent="#accordion-04" aria-expanded="true">
                                    <i class="icon-bubble align-middle u-line-icon-pro g-font-size-20 g-pr-5 g-font-weight-600 g-line-height-0_7"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--کامنت ها-->
                <div class="g-px-10">
                    <div class="postCaption" style="direction: rtl;">
                        <p id="name"
                           class="p-0 g-mt-10 text-right g-mb-0 g-color-black col-10 ml-auto g-font-size-16 g-font-weight-600"></p>
                        <div class="d-none extraInfo g-font-size-14 cat"><span
                                class="g-font-weight-600">دسته بندی</span><span id="cat"></span><span
                                class="d-none catDelete g-py-5 g-px-10"><i class="fa fa-close g-color-red"></i></span>
                        </div>
                        <div class="d-none extraInfo g-font-size-14 productName"><span class="g-font-weight-600">نام محصول</span><span
                                id="productName"></span><span class="d-none productNameDelete g-py-5 g-px-10"><i
                                    class="fa fa-close g-color-red"></i></span></div>
                        <div class="d-none extraInfo g-font-size-14 size"><span
                                class="g-font-weight-600">سایز</span><span id="size"></span><span
                                class="d-none sizeDelete g-py-5 g-px-10"><i class="fa fa-close g-color-red"></i></span>
                        </div>
                        <div class="d-none extraInfo g-font-size-14 color"><span
                                class="g-font-weight-600">رنگ</span><span id="color"></span><span
                                class="d-none colorDelete g-py-5 g-px-10"><i class="fa fa-close g-color-red"></i></span>
                        </div>
                        <div class="d-none extraInfo g-font-size-14 price"><span
                                class="g-font-weight-600">قیمت</span><span id="price"></span>تومان<span
                                class="d-none priceDelete g-py-5 g-px-10"><i class="fa fa-close g-color-red"></i></span>
                        </div>
                        <div class="d-none extraInfo g-font-size-14 discount"><span
                                class="g-font-weight-600">تخفیف</span><span id="discount"></span>%<span
                                class="d-none discountDelete g-py-5 g-px-10"><i
                                    class="fa fa-close g-color-red"></i></span></div>
                        <div class="d-none extraInfo g-font-size-14 finalPrice"><span class="g-font-weight-600">قیمت نهایی</span><span
                                id="finalPrice"></span>تومان<span class="d-none finalPriceDelete g-py-5 g-px-10"><i
                                    class="fa fa-close g-color-red"></i></span></div>

                        <div class="editPostCaption">
                            <p id="detail" style="white-space: pre-wrap;"></p>
                            <div class="d-none">
                                <textarea style="height: 200px; white-space: pre-wrap;"
                                          class="form-control growingToTop col-10 ml-auto hideScrollBar g-brd-none form-control-md g-resize-none rounded-0 p-0 text-right g-font-size-16"></textarea>
                                <label class="u-check g-mr-15 mb-0 pull-left saveCaptionBtn">
                                    <div
                                        class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-primary--hover">
                                        <i class="fa fa-check g-absolute-centered"></i>
                                    </div>
                                </label>
                                <label class="u-check g-mr-15 mb-0 pull-left cancelEditCaptionBtn">
                                    <div
                                        class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-lightred--hover">
                                        <i class="fa fa-close g-absolute-centered"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
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
    </section>
@endsection
