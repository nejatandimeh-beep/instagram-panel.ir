@extends('Layouts.IndexCustomer')
@section('Content')
    <span id="commentReplyID" class="d-none"></span>
    <div style="margin-bottom: 250px" class="container messageMenu">
        <div style="direction: rtl" class="p-0 g-mb-5">
            @foreach($postsCommentReply as $key => $row)
                <span id="sellerMajorID-{{$key}}" class="d-none">{{$row->SellerMajorID}}</span>
                <div id="commentReplyID-{{$row->commentReplyID}}"
                    class="g-brd-bottom g-brd-gray-light-v4 g-pa-20--lg g-pa-10 g-mb-minus-1 g-mb-5">
                    <div class="d-flex p-0 col-12">
                        <div class="w-100 nav-link g-pa-0">
                            <div class="p-0">
                                <div class="d-flex">
                                    <div class="text-center g-width-40 g-height-40">
                                      <span style="direction: rtl"
                                            class="align-self-center"><i class="fa fa-comment-o g-font-size-20"></i></span>
                                    </div>
                                    <div>
                                        <small class="align-self-center g-color-gray-light-v1">دیدگاه</small>
                                    </div>
                                </div>
                            </div>
                            <div class="g-pr-25">
                                <div class="text-right g-mb-10">
                                    <div class="commentReplyDetail">
                                        <div>
                                            <span class="d-none">{{$row->sellerImg=='img/SellerMajorProfileImage/Default/icon.jpg'?$sellerProfileImg=asset($row->sellerImg):$sellerProfileImg=asset($row->sellerImg).'/profileImg.jpg?'.date('Y-m-d H:i:s')}}</span>
                                            <a href="{{$row->CommenterReply==='seller'? route('cSmPanel',$row->SellerMajorID):'#'}}" class="userInfo">
                                                <img
                                                    class="g-width-30 g-height-30 rounded-circle"
                                                    src="{{$row->commenterReplyID===-1?$sellerProfileImg:$row->PicPath}}"
                                                    alt="Image Description">
                                                <span id="sellerName-{{$key}}"
                                                    class="g-font-size-12 g-font-weight-600 g-color-gray-dark-v2">{{$row->commenterReplyID===-1?$row->sellerName:(!is_null($row->customerName)?$row->customerName:'کاربر'.$row->commenterReplyID.' ')}}</span>
                                            </a>
                                        </div>
                                        <div style="direction: rtl">
                                            <div class="g-pr-30 g-pl-0">
                                                <div class="g-pr-5">
                                                    <p style="min-width: 150px; border-radius: 6px 0 6px 6px"
                                                       class="g-font-size-13 g-color-gray-dark-v1 g-pb-0 m-0 commentText">
                                                        {{$row->CommentReplyText}}
                                                    </p>
                                                    <div class="m-0 g-mb-10">
                                                        <a class="g-color-gray-dark-v2 g-pl-5 commentLiking"
                                                           href="#!"
                                                           onclick="commentLiking({{$row->CommentID}},{{$row->commentReplyID}}, 'reply')">
                                                            <small><i id="commentReplyLikeIcon-{{$row->commentReplyID}}" class="{{$row->LikeStatus===1?'fa fa-heart g-color-red':'fa fa-heart-o'}} commentLikeIcon"></i></small>
                                                        </a>
                                                        <small
                                                            class="g-mx-5 g-color-gray-dark-v5 commentTime">{{$postsCommentReplyHowDay[$key]}}</small>
                                                        <small id="commentReplyLike-{{$row->commentReplyID}}"
                                                               class="g-mx-5 g-color-gray-dark-v5 commentLike">{{$row->CommentReplyLike.' پسند'}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="position: relative" class="g-pr-10">
                                    <div class="d-flex">
                                        <div class="g-pl-5">
                                            <img
                                                class="g-width-30 g-height-30 rounded-circle"
                                                src="{{isset($row->commentReplyID)?asset($data->PicPath):''}}"
                                                alt="Image Description">
                                        </div>
                                        <textarea style="direction: rtl"
                                                  class="form-control p-0 g-pt-10 growingToTop col-10 ml-auto hideScrollBar g-brd-none form-control-md g-resize-none rounded-0 text-right g-font-size-16"
                                                  tabindex="1"
                                                  value=""
                                                  oninput="if($(this).val()==='') $('#sendCommentBtn-{{$key}}').addClass('d-none'); else $('#sendCommentBtn-{{$key}}').removeClass('d-none');"
                                                  placeholder="نظر شما.."
                                                  name="commentReply-{{$key}}"
                                                  id="commentReply-{{$key}}"
                                                  maxlength="300"></textarea>
                                    </div>
                                    <div id="sendCommentBtn-{{$key}}"
                                         style="position: absolute; left:0; bottom: -5px;"
                                         class="d-none">
                                        <a class="g-color-gray-dark-v3" href="#!"
                                           onclick="$('#commentReplyID').text({{$row->CommentID}}); sendComment({{$row->PostID}},'commentReply-{{$key}}')">
                                            <i class="fa fa-arrow-left g-pa-10"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <img class="g-width-50 g-height-50"
                                 src="{{asset($row->postImg.'/'.$row->PostID.'/sample.jpg')}}" alt="Image Description">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
