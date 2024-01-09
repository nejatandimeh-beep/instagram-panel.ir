@extends('Layouts.IndexAdmin')
@section('Content')
    <span id="commentReplyID" class="d-none"></span>
    <span id="loopConter" class="d-none">{{$i=0}}</span>
    <span class="d-none">{{$allRow=0}}</span>
    <div style="margin-bottom: 250px" class="container messageMenuCopy">
        <ul style="direction: rtl" class="list-unstyled p-0 g-mb-5">
            @foreach($eventLike as $key => $row)
                <li id="event-{{$row->EventID}}" data-time="{{$rowTime[$allRow]}}"
                    class="media replyRow g-brd-bottom g-brd-gray-light-v4 g-pa-20--lg g-pa-10 g-mb-minus-1 g-mb-5">
                    <div class="d-flex p-0 col-12">
                        <a href="{{route('sellerMajorMessagesDetail')}}" class="w-100 nav-link g-pa-0">
                            <div class="p-0">
                                <div class="d-flex">
                                    <img class="g-width-40 g-height-40 rounded-circle g-ml-10--lg g-ml-5"
                                         src="{{asset($row->PicPath)}}" alt="Image Description">

                                            <div class="d-flex">
                                                <strong class="align-self-center">{{$row->name}}</strong>
                                                <span style="direction: rtl"
                                                     class="align-self-center g-mx-5 text-nowrap  g-font-size-10 g-color-gray-light-v1">{{$eventLikeHowDay[$key]}}</span>
                                                <small class="align-self-center g-color-gray-light-v1">قبل پسندید</small>
                                            </div>
                                </div>
                            </div>
                        </a>
                        <div class="d-flex flex-column ">
                            <img class="g-width-40 g-height-40"
                                 src="{{asset($row->Pic.'/'.$row->EventID.'.jpg')}}" alt="Image Description">
                            <div class="text-center">
                                  <span style="direction: rtl"
                                        class="align-self-center g-font-size-10 g-color-red"><i class="fa fa-heart"></i></span>
                            </div>
                        </div>
                    </div>
                </li>
                <span class="d-none">{{$allRow++}}</span>
            @endforeach
        </ul>
        <ul style="direction: rtl" class="list-unstyled p-0 g-mb-5">
            @foreach($postsLike as $key => $row)
                <li id="post-{{$row->PostID}}" data-time="{{$rowTime[$allRow]}}"
                    class="media g-brd-bottom replyRow g-brd-gray-light-v4 g-pa-20--lg g-pa-10 g-mb-minus-1 g-mb-5">
                    <div class="d-flex p-0 col-12">
                        <a href="{{route('sellerMajorMessagesDetail')}}" class="w-100 nav-link g-pa-0">
                            <div class="p-0">
                                <div class="d-flex">
                                    <img class="g-width-40 g-height-40 rounded-circle g-ml-10--lg g-ml-5"
                                         src="{{asset($row->PicPath)}}" alt="Image Description">

                                    <div class="d-flex">
                                        <strong class="align-self-center">{{$row->name}}</strong>
                                        <span style="direction: rtl"
                                              class="align-self-center g-mx-5 text-nowrap  g-font-size-10 g-color-gray-light-v1">{{$postsLikeHowDay[$key]}}</span>
                                        <small class="align-self-center g-color-gray-light-v1">قبل پسندید</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="d-flex flex-column ">
                            <img class="g-width-40 g-height-40"
                                 src="{{asset($row->Pic.'/'.$row->PostID.'/sample.jpg')}}" alt="Image Description">
                            <div class="text-center">
                                  <span style="direction: rtl"
                                        class="align-self-center g-font-size-10 g-color-red"><i class="fa fa-heart"></i></span>
                            </div>
                        </div>
                    </div>
                </li>
                <span class="d-none">{{$allRow++}}</span>
            @endforeach
        </ul>
        <ul style="direction: rtl" class="list-unstyled p-0 g-mb-5">
            @foreach($postsComment as $key => $row)
                <li id="commentID-{{$row->commentID}}" data-time="{{$rowTime[$allRow]}}"
                    class="g-brd-bottom replyRow g-brd-gray-light-v4 g-pa-20--lg g-pa-10 g-mb-minus-1 g-mb-5">
                    <div class="d-flex p-0 col-12">
                        <div class="w-100 nav-link g-pa-0">
                            <div class="p-0">
                                <div class="d-flex">
                                    <div class="text-center g-width-40 g-height-40">
                                      <span style="direction: rtl"
                                            class="align-self-center"><i class="fa fa-comment-o g-font-size-18"></i></span>
                                    </div>
                                    <div>
                                        <small class="align-self-center g-color-gray-light-v1">دیدگاه</small>
                                    </div>
                                </div>
                            </div>
                            <div class="g-pr-25">
                                <div class="text-right g-mb-10">
                                    <div class="commentReplyDetail">
                                        <div class="g-pr-10">
                                            <div class="userInfo">
                                                <img
                                                    class="g-width-20 g-height-20 rounded-circle"
                                                    src="{{asset($row->PicPath)}}"
                                                    alt="Image Description">
                                                <span id="customerName-{{$key}}"
                                                    class="g-font-size-12 g-font-weight-600 g-color-gray-dark-v2">{{!is_null($row->name)?$row->name:'کاربر'.$row->userId.' '}}</span>
                                            </div>
                                        </div>
                                        <div style="direction: rtl">
                                            <div class="g-pr-30 g-pl-0">
                                                <div class="g-pr-5">
                                                    <p style="min-width: 150px; border-radius: 6px 0 6px 6px"
                                                       class="g-font-size-13 g-color-gray-dark-v1 g-pb-0 m-0 commentText">
                                                        {{$row->CommentText}}
                                                    </p>
                                                    <div class="m-0 g-mb-10">
                                                        <a class="g-color-gray-dark-v2 g-pl-5 commentLiking"
                                                           href="#!"
                                                           onclick="commentLiking({{$row->commentID}},-1, 'comment')">
                                                            <small><i id="commentLikeIcon-{{$row->commentID}}" class="{{$row->LikeStatus===1?'fa fa-heart g-color-red':'fa fa-heart-o'}} commentLikeIcon"></i></small>
                                                        </a>
                                                        <small
                                                            class="g-mx-5 g-color-gray-dark-v5 commentTime">{{$postsCommentHowDay[$key]}}</small>
                                                        <small id="commentLike-{{$row->commentID}}"
                                                            class="g-mx-5 g-color-gray-dark-v5 commentLike">{{$row->CommentLike.' پسند'}}</small>
                                                        <span id="" style="cursor: pointer"
                                                               onclick="deleteComment({{$row->commentID}},'comment',$(this),{{$row->PostID}})"
                                                               class="deleteCommentReply g-font-weight-600 g-mx-5 g-color-gray-dark-v4">
                                                            <i class="icon-trash"></i>
                                                        </span>
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
                                                class="g-width-20 g-height-20 rounded-circle"
                                                src="{{asset($data->Pic.'/profileImg.jpg')}}"
                                                alt="Image Description">
                                        </div>
                                    </div>
                                    <div id="sendCommentBtn-{{$key}}"
                                         style="position: absolute; left:0; bottom: -5px;"
                                         class="d-none">
                                        <a class="g-color-gray-dark-v3" href="#!"
                                           onclick="$('#commentReplyID').text({{$row->commentID}}); sendComment({{$row->PostID}},'comment-{{$key}}')">
                                            <i class="fa fa-arrow-left g-pa-10"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <img class="g-width-40 g-height-40"
                                 src="{{asset($row->Pic.'/'.$row->PostID.'/sample.jpg')}}" alt="Image Description">
                        </div>
                    </div>
                    <span id="loopConter" class="d-none">{{$i++}}</span>
                </li>
                <span class="d-none">{{$allRow++}}</span>
            @endforeach
        </ul>
        <ul style="direction: rtl" class="list-unstyled p-0 g-mb-5">
            @foreach($postsCommentReply as $key => $row)
                <li id="commentReplyID-{{$row->commentReplyID}}" data-time="{{$rowTime[$allRow]}}"
                    class="g-brd-bottom replyRow g-brd-gray-light-v4 g-pa-20--lg g-pa-10 g-mb-minus-1 g-mb-5">
                    <div class="d-flex p-0 col-12">
                        <div class="w-100 nav-link g-pa-0">
                            <div class="p-0">
                                <div class="d-flex">
                                    <div class="text-center g-width-40 g-height-40">
                                      <span style="direction: rtl"
                                            class="align-self-center"><i class="fa fa-comment-o g-font-size-18"></i></span>
                                    </div>
                                    <div>
                                        <small class="align-self-center g-color-gray-light-v1">دیدگاه</small>
                                    </div>
                                </div>
                            </div>
                            <div class="g-pr-25">
                                <div class="text-right g-mb-10">
                                    <div class="commentReplyDetail">
                                        <div class="g-pr-10">
                                            <div class="userInfo">
                                                <img
                                                    class="g-width-20 g-height-20 rounded-circle"
                                                    src="{{asset($row->PicPath)}}"
                                                    alt="Image Description">
                                                <span id="customerName-{{$i}}"
                                                    class="g-font-size-12 g-font-weight-600 g-color-gray-dark-v2">{{!is_null($row->name)?$row->name:'کاربر'.$row->userId.' '}}</span>
                                            </div>
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
                                                        <span id="" style="cursor: pointer"
                                                               onclick="deleteComment({{$row->commentReplyID}},'commentReply',$(this),{{$row->PostID}})"
                                                               class="deleteCommentReply g-font-weight-600 g-mx-5 g-color-gray-dark-v4">
                                                            <i class="icon-trash"></i>
                                                        </span>
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
                                                class="g-width-20 g-height-20 rounded-circle"
                                                src="{{asset($data->Pic.'/profileImg.jpg')}}"
                                                alt="Image Description">
                                        </div>
                                    </div>
                                    <div id="sendCommentBtn-{{$i}}"
                                         style="position: absolute; left:0; bottom: -5px;"
                                         class="d-none">
                                        <a class="g-color-gray-dark-v3" href="#!"
                                           onclick="$('#commentReplyID').text({{$row->CommentID}}); sendComment({{$row->PostID}},'commentReply-{{$i}}')">
                                            <i class="fa fa-arrow-left g-pa-10"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <img class="g-width-40 g-height-40"
                                 src="{{asset($row->Pic.'/'.$row->PostID.'/sample.jpg')}}" alt="Image Description">
                        </div>
                    </div>
                    <span id="loopConter" class="d-none">{{$i++}}</span>
                </li>
                <span class="d-none">{{$allRow++}}</span>
            @endforeach
        </ul>
    </div>
    <div style="margin-bottom: 250px" class="container messageMenu">
        <ul style="direction: rtl" class="list-unstyled p-0 g-mb-5">
        </ul>
    </div>
@endsection
