@section('SellerMajorPanelJsFunction')
    <script>
        // stop fancy box additional url
        if ($('.js-fancybox').length > 0) {
            $.fancybox.defaults.hash = false;

        }

        function windowScrollTo(){
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#regulationContainer").offset().top
            }, 1000);
        }

        function submitButton(ele, waitingIcon) {
            ele.hide();
            $('#' + waitingIcon).show();
            if ($('#question').val().length < 4) {
                $('#waitingSendMsg').hide();
                ele.show();
                alert('پیغامتان را کامل بنویسید.');
            } else
                $('#customerMsgForm').submit();
        }

        let imgRowID = [], imgRowIdTemp, lastScrollTop = 0, lastScrollTopModal = 0, postNumber = 0, completeLoad = true,
            touchtime = 0, postDeleteItems = [], imgWorking = 0, asset = $('#asset').text(), imgNumber = 0, file_type,
            dragging = false;
        // click any location in screen close all accordion exept clicked accordion
        document.addEventListener('click', function (event) {
            if ($('.accordionBtn').length > 0) {
                let popElement = document.getElementsByClassName("accordionBtn"),
                    popEl, isClickInside, thisBtn = event.target.id, key = thisBtn.replace(/[^0-9]/gi, ''),
                    accBtn = '.accordionBtn', accBody = '.accBody';
                popEl = popElement[0];
                isClickInside = popEl.contains(event.target);
                if (!isClickInside && popElement[0].id !== thisBtn) {
                    if (!event.target.closest('.u-accordion')) {
                        $(accBtn).addClass('collapsed');
                        $(accBtn).attr('aria-expanded', 'false');
                        $(accBody).removeClass('show');
                        $(accBody).attr('aria-expanded', 'false');
                    }
                }
            }
            if ($('#postModal').length > 0) {
                let popEl, isClickInside;
                popEl = document.getElementById("categoryContainer");
                isClickInside = popEl.contains(event.target);
                if (!isClickInside) {
                    $('#allCategory').hide();
                }
                popEl = document.getElementById("productNameContainer");
                isClickInside = popEl.contains(event.target);
                if (!isClickInside) {
                    $('#allProductName').hide();
                }
            }
        })

        $(window).scroll(function (event) {
            if ($('.allPost').length > 0) {
                let st = $(this).scrollTop(),
                    scrollLocation = st - lastScrollTop;
                if (scrollLocation > 80 && parseInt($('#postLen').text()) >= (parseInt($('#postLoaded').text()) + 6) && !$('#postRail').hasClass('in')) {
                    console.log('window scroll..')
                    $('.load').removeClass('d-none');
                    if (completeLoad) {
                        loadPost();
                        completeLoad = false;
                    }
                    $('.load').addClass('d-none');
                    lastScrollTop = st;
                }
            }
        });

        $('#postRail').on('scroll', function () {
            let st = $(this).scrollTop(),
                scrollLocation = st - lastScrollTopModal;
            if (scrollLocation > 150 && parseInt($('#postLen').text()) >= (parseInt($('#postLoaded').text()) + 6)) {
                $('.load').removeClass('d-none');
                if (completeLoad) {
                    loadPost();
                    completeLoad = false;
                }
                $('.load').addClass('d-none');
                lastScrollTopModal = st;
            }
        });

        $('#postRail').on('shown.bs.modal', function () {
            // $('html').css({overflow: 'hidden', height: '100%'});
            let sumHeight = 0;
            $('[id^="detailPost-"]').each(function (index) {
                if (index < postNumber) {
                    sumHeight += $('#detailPost-' + index).outerHeight();
                }
            })
            $(this).scrollTop(sumHeight + Math.round(0.85 * sumHeight / 100));
        });

        $('#postRail').on('hide.bs.modal hidden.bs.modal', function () {
            // $('html').css('overflow', 'auto');
            $('.postChart').addClass('d-none');
            $('.icon-chart').addClass('fa-ellipsis-h');
            $('.icon-chart').removeClass('g-color-primary');
            $('.icon-chart').removeClass('icon-chart');
            $('[class^="captionInfo-"]').addClass('d-none');
            $('[id^="editPostCaption-"]').find('p').removeClass('d-none');
            $('[id^="editPostCaption-"]').find('div').addClass('d-none');
        });

        function loadPost() {
            let postSampleCopy = '.postSampleCopy',
                originalContainer = '#postSampleContainer';
            $.ajax({
                type: 'GET',
                url: '/Administrator-SellerMajor-Load-Post',
                success: function (data) {
                    console.log(data)
                    let j = data[1];
                    for (let i = 0; i < data[0].length; i++) {
                        $(postSampleCopy).attr('id', 'postSample-' + j);
                        $(postSampleCopy + ' a').attr('id', 'samplePost-' + j);
                        $(postSampleCopy + ' a').attr('onclick', 'postNumber=' + j);
                        $(postSampleCopy + ' img').attr('src', asset + data[0][i]['postPic'] + '/' + data[0][i]['postID'] + '/' + 'sample.jpg');
                        $(originalContainer).append($(postSampleCopy).clone());
                        $(originalContainer + ' ' + postSampleCopy).removeClass('d-none postSampleCopy');
                        createDetailPost(data[0][i], j, data[2][i], data[3][i], data[4]);
                        j++;
                    }
                    $('#postLoaded').text(data[1]);
                }
            }).done(function () {
                completeLoad = true;
            })
        }

        function createDetailPost(posts, key, postHowDay, commentCount, userProfile) {
            let copyContainer = '.postContainerCopy',
                postDetailContainer = '#postDetailContainer',
                detailPost = '.detailPost',
                postID = posts['postID'],
                slide, src;

            // post created
            $(copyContainer + ' ' + detailPost).attr('id', 'detailPost-' + key);
            $(copyContainer + ' .postID').text(postID);
            $(copyContainer + ' #postProfileImg').attr('src', asset + userProfile['Pic'] + '/profileImg.jpg');
            $(copyContainer + ' #postProfileName').text(userProfile['name']);
            $(copyContainer + ' .containerSwiper').addClass('swiper' + key);
            setTimeout(function () {
                const swiper = new Swiper('.swiper' + key, {
                    // Optional parameters
                    direction: 'horizontal',
                    loop: false,
                    speed: 200,
                    zoom: {
                        maxRatio: 3,
                        minRatio: 1,
                    },
                    // If we need pagination
                    pagination: {
                        el: '.swiper-pagination' + key,
                    },
                    on: {
                        click: function (s, e) {
                            s.zoom.in(3);
                        },
                        doubleClick: function (s, e) {
                            e.preventDefault();
                        },
                        touchStart: function (s, e) {
                            dragging = true;
                        },
                        touchEnd: function (s, e) {
                            s.zoom.out();
                            dragging = false;
                        },
                    },
                });
                for (let n = 0; n < posts['PicCount']; n++) {
                    src = asset + posts['postPic'] + '/' + postID + '/' + n + '.jpg';
                    slide = '<div class="swiper-slide swiper-lazy"><div class="swiper-zoom-container"><img class="w-100" src="' + src + '" alt="Image Description"></div><div class="swiper-lazy-preloader"></div></div>';
                    swiper.appendSlide(slide);
                }
            }, 100)


            $(copyContainer + ' .paginationSwiper').addClass('swiper-pagination' + key);
            $(copyContainer + ' .deletePost').attr('onclick', 'deletePost(' + postID + ',' + key + ')');
            $(copyContainer + ' .likeCount small').text(posts['LikeCount'] === 0 ? '' : posts['LikeCount'] + ' پسند');
            $(copyContainer + ' #postChart').attr('onclick', 'postChart($(this),' + postID + ',' + key + ')');

            // comment created
            $(copyContainer + ' .accordionBtnComment').attr('href', '#accordion-04-body-' + key);
            $(copyContainer + ' .accordionBtnComment').attr('id', 'accordionBtn-' + key);
            $(copyContainer + ' .accordionBtnComment').attr('aria-controls', 'accordion-04-body-' + key);
            $(copyContainer + ' .accordionBtnComment').attr('onclick', 'addComments(' + postID + ',' + key + ')');
            $(copyContainer + ' .postCaption #name').text(userProfile['name']);
            $(copyContainer + ' .postCaption #cat').text(posts['Cat']);
            if (posts['Cat'] !== null) {
                $(copyContainer + ' .postCaption #cat').text(' ' + posts['Cat']);
                $(copyContainer + ' .postCaption .cat').removeClass('d-none');
            }
            if (posts['ProductName'] !== null) {
                $(copyContainer + ' .postCaption #productName').text(' ' + posts['ProductName']);
                $(copyContainer + ' .postCaption .productName').removeClass('d-none');
            }
            if (posts['Size'] !== null) {
                $(copyContainer + ' .postCaption #size').text(' ' + posts['Size']);
                $(copyContainer + ' .postCaption .size').removeClass('d-none');
            }
            if (posts['Color'] !== null) {
                $(copyContainer + ' .postCaption #color').text(' ' + posts['Color']);
                $(copyContainer + ' .postCaption .color').removeClass('d-none');
            }
            if (posts['Price'] !== null) {
                $(copyContainer + ' .postCaption #price').text(' ' + posts['Price']);
                $(copyContainer + ' .postCaption .price').removeClass('d-none');
            }
            if (posts['Discount'] !== null) {
                $(copyContainer + ' .postCaption #discount').text(' ' + posts['Discount']);
                $(copyContainer + ' .postCaption .discount').removeClass('d-none');
            }
            if (posts['FinalPrice'] !== null) {
                $(copyContainer + ' .postCaption #finalPrice').text(' ' + posts['FinalPrice']);
                $(copyContainer + ' .postCaption .finalPrice').removeClass('d-none');
            }
            $(copyContainer + ' .postCaption').attr('onclick', 'copy($(this).text())');
            $(copyContainer + ' .postCaption .editPostCaption').attr('id', 'editPostCaption-' + postID);
            $(copyContainer + ' .postCaption .editPostCaption p').text(posts['Text']);
            $(copyContainer + ' .postCaption .editPostCaption textarea').val(posts['Text']);
            $(copyContainer + ' .postCaption .editPostCaption .saveCaptionBtn').attr('onclick', 'saveCaption($(this),' + postID + ')');
            $(copyContainer + ' .postCaption .editPostCaption .cancelEditCaptionBtn').attr('onclick', 'cancelEditCaption(' + postID + ')');
            $(copyContainer + ' .catDelete').attr('id', 'cat-' + postID).attr('onclick', "deletePostInfo(" + postID + ",'cat')");
            $(copyContainer + ' .catDelete').addClass('captionInfo-' + postID);
            $(copyContainer + ' .productNameDelete').attr('id', 'productName-' + postID).attr('onclick', "deletePostInfo(" + postID + ",'productName')");
            $(copyContainer + ' .productNameDelete').addClass('captionInfo-' + postID);
            $(copyContainer + ' .sizeDelete').attr('id', 'size-' + postID).attr('onclick', "deletePostInfo(" + postID + ",'size')");
            $(copyContainer + ' .sizeDelete').addClass('captionInfo-' + postID);
            $(copyContainer + ' .colorDelete').attr('id', 'color-' + postID).attr('onclick', "deletePostInfo(" + postID + ",'color')");
            $(copyContainer + ' .colorDelete').addClass('captionInfo-' + postID);
            $(copyContainer + ' .priceDelete').attr('id', 'price-' + postID).attr('onclick', "deletePostInfo(" + postID + ",'price')");
            $(copyContainer + ' .priceDelete').addClass('captionInfo-' + postID);
            $(copyContainer + ' .discountDelete').attr('id', 'discount-' + postID).attr('onclick', "deletePostInfo(" + postID + ",'discount')");
            $(copyContainer + ' .discountDelete').addClass('captionInfo-' + postID);
            $(copyContainer + ' .finalPriceDelete').attr('id', 'finalPrice-' + postID).attr('onclick', "deletePostInfo(" + postID + ",'finalPrice')");
            $(copyContainer + ' .finalPriceDelete').addClass('captionInfo-' + postID);
            $(copyContainer + ' .editCaption').attr('onclick', 'editPost(' + postID + ')');
            $(copyContainer + ' .commentReplyShow').addClass(commentCount > 0 ? '' : 'd-none');
            $(copyContainer + ' #allCommentContainer').attr('onclick', "$('#accordionBtn-" + key + "').trigger('click')");
            $(copyContainer + ' .allComment').text(commentCount);
            $(copyContainer + ' .postHowDay').text(postHowDay);
            $(copyContainer + ' #accordion-04 .accBody').attr('id', 'accordion-04-body-' + key);
            $(copyContainer + ' #accordion-04 .accBody').attr('aria-labelledby', 'accordion-04-heading-' + key);
            $(copyContainer + ' .accBody .commentContainer').attr('id', 'commentContainer-' + key);
            $(copyContainer + ' .accBody .commentText').attr('id', 'comment-' + key);
            $(copyContainer + ' .accBody .commentText').attr('name', 'comment-' + key);
            $(copyContainer + ' .accBody .commentText').attr('oninput', "if($(this).val()==='') $('#sendCommentBtn-" + key + "').addClass('d-none'); else $('#sendCommentBtn-" + key + "').removeClass('d-none');");
            $(copyContainer + ' .accBody .commenterProfileImg').attr('src', asset + userProfile['Pic'] + '/profileImg.jpg');
            $(copyContainer + ' .accBody .sendCommentBtn').attr('id', 'sendCommentBtn-' + key);
            $(copyContainer + ' .accBody .sendCommentBtn a').attr('onclick', "sendComment(" + postID + ",'comment-" + key + "')");


            $(copyContainer).clone().appendTo(postDetailContainer);
            $(postDetailContainer + ' .postID-').addClass('postID-' + postID);
            $(postDetailContainer + ' .postID-').removeClass('postID-');
            $(postDetailContainer + ' ' + copyContainer).removeClass('d-none postContainerCopy');
            $(copyContainer + ' .containerSwiper').removeClass('swiper' + key);
            $(copyContainer + ' .paginationSwiper').removeClass('swiper-pagination' + key);
            $(copyContainer + ' .containerSwiper .swiper-wrapper .swiper-zoom-container').empty();
            $(copyContainer + ' .containerSwiper .swiper-notification').remove();
            $(copyContainer + ' ' + detailPost).removeAttr('id');
            $(copyContainer + ' .commentReplyShow').removeClass('d-none');
            $(copyContainer + ' .postCaption .extraInfo').addClass('d-none');
            $(copyContainer + ' .accBody .commentText').removeAttr('id');
            $(copyContainer + ' .postCaption .editPostCaption').removeAttr('id');
            $(copyContainer + ' .catDelete').removeClass('captionInfo-' + postID);
            $(copyContainer + ' .productNameDelete').removeClass('captionInfo-' + postID);
            $(copyContainer + ' .sizeDelete').removeClass('captionInfo-' + postID);
            $(copyContainer + ' .colorDelete').removeClass('captionInfo-' + postID);
            $(copyContainer + ' .priceDelete').removeClass('captionInfo-' + postID);
            $(copyContainer + ' .discountDelete').removeClass('captionInfo-' + postID);
            $(copyContainer + ' .finalPriceDelete').removeClass('captionInfo-' + postID);
        }

        function addComments(postID, key) {
            if (isEmpty($('#commentContainer-' + key))) {
                $('.loadCommentWaiting').removeClass('d-none');
                $.ajax({
                    type: 'GET',
                    url: '/Administrator-SellerMajor-AddComment/' + postID,
                    async: false,
                    success: function (data) {
                        let showReplyCommentBtn = '<div style="direction: rtl; cursor: pointer" class="countCommentReply g-pr-25"><small>...دیدن پاسخ ها...</small></div>';
                        for (let i = 0; i < data[0].length; i++) {
                            if (data[0][i]['Commenter'] === 'customer') {
                                let username = data[0][i]['customerName'] !== null ? data[0][i]['customerName'] : 'کاربر' + data[0][i]['CommenterID'];
                                $('.postCommentCopy .userInfo span').text(username);
                                $('.postCommentCopy .userInfo img').attr('src', asset+data[0][i]['PicPath']);
                                $('.postCommentCopy .commentReplying').attr('onclick', 'commentReplying(' + data[0][i]['commentId'] + ',"' + username + '",' + key + ')');
                                $('.postCommentCopy .commentLiking').attr('onclick', 'commentLiking(' + data[0][i]['commentId'] + ',-1,"comment",)');
                                $('.postCommentCopy .commentLike').attr('id', 'commentLike-' + data[0][i]['commentId']);
                                $('.postCommentCopy .commentLiking').removeClass('d-none');
                            } else {
                                $('.postCommentCopy .userInfo span').text(data[0][i]['sellerMajorName']);
                                $('.postCommentCopy .userInfo img').attr('src', asset+data[0][i]['Pic'] + '/profileImg.jpg');
                                $('.postCommentCopy .commentReplying').attr('onclick', 'commentReplying(' + data[0][i]['commentId'] + ',"' + data[0][i]['sellerMajorName'] + '",' + key + ')');
                                $('.postCommentCopy .commentLiking').addClass('d-none');
                            }
                            $('.postCommentCopy .deleteComment').attr('onclick', 'deleteComment(' + data[0][i]['commentId'] + ',"comment",$(this),' + data[0][i]['PostID'] + ')');
                            $('.postCommentCopy .commentLike').text(data[0][i]['CommentLike'] + ' پسند');
                            $('.postCommentCopy .commentText').text(data[0][i]['CommentText']);
                            $('.postCommentCopy .commentLikeIcon').attr('id', 'commentLikeIcon-' + data[0][i]['commentId']);
                            $('.postCommentCopy .commentTime').text(data[1][i]);
                            $('.commentReply').attr('id', 'commentReply-' + data[0][i]['commentId']);
                            $('.postCommentCopy').removeClass('d-none');
                            $('.postCommentCopy').clone().appendTo("#commentContainer-" + key);
                            $('.postCommentCopy').attr('id', 'commentID-' + data[0][i]['commentId']);

                            $('#commentReply-' + data[0][i]['commentId']).removeClass('commentReply');
                            $('#commentContainer-' + key + ' .postCommentCopy').removeClass('postCommentCopy');
                            if (data[0][i]['LikeStatus'] === 1) {
                                $('#commentLikeIcon-' + data[0][i]['commentId']).removeClass('fa-heart-o');
                                $('#commentLikeIcon-' + data[0][i]['commentId']).addClass('fa-heart');
                                $('#commentLikeIcon-' + data[0][i]['commentId']).addClass('g-color-red');
                            }
                        }
                        for (let i = 0; i < data[0].length; i++) {
                            let temp = -1;
                            for (let j = 0; j < data[2].length; j++) {
                                if (data[0][i]['commentId'] === data[2][j]['CommentID']) {
                                    if (data[2][j]['CommenterReply'] === 'customer') {
                                        let username = data[2][j]['customerName'] !== null ? data[2][j]['customerName'] : 'کاربر' + data[2][j]['customerID'];
                                        $('.postCommentReplyCopy .userInfo span').text(username);
                                        $('.postCommentReplyCopy .userInfo img').attr('src', asset+data[2][j]['PicPath']);
                                        $('.postCommentReplyCopy .commentReplying').attr('onclick', 'commentReplying(' + data[0][i]['commentId'] + ',"' + username + '",' + key + ')');
                                        $('.postCommentReplyCopy .commentLike').attr('id', 'commentReplyLike-' + data[2][j]['commentReplyID']);
                                        $('.postCommentReplyCopy .commentLikeIcon').attr('id', 'commentReplyLikeIcon-' + data[2][j]['commentReplyID']);
                                        $('.postCommentReplyCopy .commentLiking').attr('onclick', 'commentLiking(' + data[0][i]['commentId'] + ',' + data[2][j]['commentReplyID'] + ',"reply")');
                                        $('.postCommentReplyCopy .commentLiking').removeClass('d-none');
                                    } else {
                                        $('.postCommentReplyCopy .userInfo span').text(data[2][j]['sellerMajorName']);
                                        $('.postCommentReplyCopy .userInfo img').attr('src', asset+data[2][j]['Pic'] + '/profileImg.jpg');
                                        $('.postCommentReplyCopy .commentReplying').attr('onclick', 'commentReplying(' + data[0][i]['commentId'] + ',"' + data[2][j]['sellerMajorName'] + '",' + key + ')');
                                        $('.postCommentReplyCopy .commentLiking').addClass('d-none');
                                    }
                                    $('.postCommentReplyCopy .deleteCommentReply').attr('onclick', 'deleteComment(' + data[2][j]['commentReplyID'] + ',"commentReply",$(this),' + data[0][i]['PostID'] + ')');
                                    $('.postCommentReplyCopy .commentText').text(data[2][j]['CommentReplyText']);
                                    $('.postCommentReplyCopy .commentLike').text(data[2][j]['CommentReplyLike'] + ' پسند');
                                    $('.postCommentReplyCopy .commentTime').text(data[3][j]);
                                    $('.postCommentReplyCopy').removeClass('d-none');
                                    $('.postCommentReplyCopy').clone().appendTo('#commentReply-' + data[0][i]['commentId']);
                                    $('.postCommentReplyCopy').attr('id', 'commentReplyID-' + data[2][j]['commentReplyID']);
                                    if (temp !== data[2][j]['CommentID']) {
                                        $(showReplyCommentBtn).appendTo('#commentReply-' + data[0][i]['commentId'] + ' .postCommentReplyCopy');
                                        $('.postCommentReplyCopy .countCommentReply').attr('onclick', '$(this).addClass("d-none"); $("#commentReply-' + data[0][i]['commentId'] + ' .commentReplyDetail").removeClass("d-none")');
                                        temp = data[2][j]['CommentID'];
                                    }
                                    if (data[2][j]['LikeStatus'] === 1) {
                                        $('#commentReplyLikeIcon-' + data[2][j]['commentReplyID']).removeClass('fa-heart-o');
                                        $('#commentReplyLikeIcon-' + data[2][j]['commentReplyID']).addClass('fa-heart');
                                        $('#commentReplyLikeIcon-' + data[2][j]['commentReplyID']).addClass('g-color-red');
                                    }
                                    $('#commentReply-' + data[0][i]['commentId'] + ' .postCommentReplyCopy').removeClass('postCommentReplyCopy');
                                }
                            }
                        }
                    }
                }).done(function () {
                    $('.loadCommentWaiting').addClass('d-none');
                })
                $('.postCommentCopy').addClass('d-none');
            }
            setTimeout(function () {
                $('#comment-' + key).focus();
            }, 100)
        }

        function deleteComment(id, status, thisElement, postID) {
            $(thisElement).find('i').removeClass('icon-trash').addClass('fa fa-spin fa-spinner');
            $.confirm({
                title: 'حذف دیدگاه',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        $.ajax({
                            type: 'GET',
                            url: '/Administrator-SellerMajor-Comment-Delete/' + id + '/' + status,
                            success: function (data) {
                                let allCommentCount, count = 1;
                                $(thisElement).find('i').removeClass('fa fa-spin fa-spinner').addClass('icon-trash');
                                $('#commentReply-' + data[0] + ' .commentReplyDetail').each(function () {
                                    count++;
                                    console.log(count)
                                })
                                console.log(data[0])
                                if (data[1] === 'comment') {
                                    $('#commentID-' + data[0]).remove();
                                } else {
                                    $('#commentReplyID-' + data[0]).remove();
                                }
                                allCommentCount = parseInt($('.postID-' + postID + ' .allComment').text()) - count;
                                $('.postID-' + postID + ' .allComment').text(allCommentCount)
                            }
                        })
                    },
                    انصراف: function () {
                        $(thisElement).find('i').removeClass('fa fa-spin fa-spinner').addClass('icon-trash');
                    },
                }
            });
            console.log(id, status)
        }

        function deletePost(postID, key) {
            let icon = $('.deleteIcon');
            icon.removeClass('icon-trash');
            icon.addClass('fa fa-spinner fa-spin');
            $.confirm({
                title: 'حذف پست',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        $.ajax({
                            type: 'GET',
                            url: '/Administrator-SellerMajor-Delete-Post/' + postID,
                            success: function (data) {
                                console.log(data)
                                $('#detailPost-' + key).remove();
                                $('#postSample-' + key).remove();
                                icon.addClass('icon-trash');
                                icon.removeClass('fa fa-spinner fa-spin');
                                $('#allPostCount').text(parseInt($('#allPostCount').text()) - 1);
                            }
                        })
                    },
                    انصراف: function () {
                        icon.removeClass('fa fa-spinner fa-spin');
                        icon.addClass('icon-trash');
                    },
                }
            });
        }

        function postChart(a, postID, key) {
            let icon = $(a).find('.fa'), chart = '#detailPost-' + key + ' .postChart', temp,
                commentCount = $('#detailPost-' + key).find('.allComment').text();
            if (icon.hasClass('fa-ellipsis-h')) {
                $('.postChart').addClass('d-none');
                $('.icon-chart').addClass('fa-ellipsis-h');
                $('.icon-chart').removeClass('g-color-primary');
                $('.icon-chart').removeClass('icon-chart');
                icon.removeClass('fa-ellipsis-h');
                icon.addClass('fa-spinner spin');
                $.ajax({
                    type: 'GET',
                    url: '/Administrator-SellerMajor-Chart-Post/' + postID,
                    success: function (data) {
                        console.log(data[0]['ID'])
                        icon.removeClass('fa-spinner spin');
                        icon.addClass('icon-chart');
                        icon.addClass('g-color-primary');
                        $(chart).removeClass('d-none');
                        $(chart + ' .allVisitCount').text(data[0]['VisitCount']);
                        $(chart + ' .visitCount').text(data[0]['UniqueVisitCount']);
                        $(chart + ' .likeCount').text(data[0]['LikeCount']);
                        $(chart + ' .saveCount').text(data[0]['SaveCount']);
                        $(chart + ' .commentCount').text(commentCount);
                        if (data[0]['UniqueVisitCount'] > 0) {
                            if ((data[0]['UniqueVisitCount'] / data[0]['LikeCount']) < 1) {
                                temp = 100;
                            } else {
                                temp = Math.round(100 / (data[0]['UniqueVisitCount'] / data[0]['LikeCount']));
                            }
                            $(chart + ' .likePercent').text(temp + '%');
                            if ((parseInt(commentCount) + parseInt(data[0]['SaveCount']) + parseInt(data[0]['LikeCount'])) > 100) {
                                temp = 100;
                            } else {
                                temp = Math.round(100 / (data[0]['VisitCount'] / (parseInt(commentCount) + parseInt(data[0]['SaveCount']) + parseInt(data[0]['LikeCount']))));
                            }
                            $(chart + ' .engagementPercent').text(temp + '%');
                        }

                        temp = data[0]['Time'].split(' ');
                        $(chart + ' .postDate').text(temp[0]);
                        $(chart + ' .postTime').text(temp[1]);
                    }
                })
            } else {
                $(chart).addClass('d-none');
                icon.removeClass('fa-spinner spin');
                icon.removeClass('icon-chart');
                icon.addClass('fa-ellipsis-h');
                icon.removeClass('g-color-primary');
            }
        }

        $("#postRail").on("touchmove", function (e) {
            console.log(e.originalEvent.touches.length)
            if (dragging && e.originalEvent.touches.length > 1)
                e.preventDefault();
        });

        $(document).ready(function () {
            $('.js-go-to').remove();
            if ($('.profileMenu').length > 0) {
                $('#profileMenu').css({
                    border: '2px solid black'
                })
            }
            if (window.location.pathname === '/Administrator-SellerMajor-Messages-Detail') {
                setTimeout(function () {
                    $('#answer').focus();
                }, 100)
            }
            $('[id^="eventBackground-"]').each(function (i, obj) {
                imgRowIdTemp = $(this).attr('id').split('-');
                imgRowID[i] = imgRowIdTemp[2];
            });
            if (~window.location.pathname.indexOf('/Administrator-SellerMajor-Panel')) {
                for (let i = 0; i < parseInt($('#postLen').text()) && i < 6; i++) {
                    const swiper = new Swiper('.swiper' + i, {
                        // Optional parameters
                        direction: 'horizontal',
                        loop: false,
                        speed: 200,
                        zoom: {
                            maxRatio: 3,
                            minRatio: 1,
                        },
                        // If we need pagination
                        pagination: {
                            el: '.swiper-pagination' + i,
                        },
                        on: {
                            click: function (s, e) {
                                s.zoom.in(3);
                            },
                            doubleClick: function (s, e) {
                                e.preventDefault();
                            },
                            touchStart: function (s, e) {
                                dragging = true;
                            },
                            touchEnd: function (s, e) {
                                s.zoom.out();
                                dragging = false;
                            },
                        },
                    });
                }
            }
            if ($('.messageMenu').length > 0) {
                let $wrapper = $('.messageMenuCopy');

                $wrapper.find('.replyRow').sort(function (a, b) {
                    return +a.dataset.time - +b.dataset.time;
                }).appendTo($('.messageMenu ul'));
                $wrapper.remove();
            }
            if ($('.messageDetailMenu').length > 0) {
                imgNumber = $('.imgNumber').last().text();
            }
        })

        $('#messageForm').on('submit', function (e) {
            e.preventDefault();
            $('#attachImgBtn').text('');
            $('<i class="fa fa-spin fa-spinner"></i>').appendTo($('#attachImgBtn'));
            $('#attachImgBtn').prop('disable', true);
            if ($('#answer').val() !== '') {
                let formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        let msg = data[0];
                        $('.msgRow').attr('id', 'msg-' + msg['ID']);
                        $('.msgRow').removeClass('d-none');
                        if (msg['AttachPath'] === '') {
                            $('.msgRow #attachPath').addClass('d-none');
                        } else {
                            $('.msgRow .fancy').addClass('js-fancybox');
                            $('.msgRow .js-fancybox').attr('data-src', msg['AttachPath'] + '/0.jpg');
                            $('.msgRow .js-fancybox').attr('data-fancybox', 'lightbox-gallery');
                            $('.msgRow .js-fancybox').attr('data-caption', 'Lightbox Gallery');
                            $('.msgRow .js-fancybox').attr('data-speed', '200');
                            $('.msgRow .js-fancybox').attr('data-is-infinite', 'true');
                            $('.msgRow .js-fancybox').attr('data-slideshow-speed', '5000');
                            $('.msgRow img').attr('src', msg['AttachPath'] + '/sample.jpg');
                            $('.msgRow #imgNumber').text(imgNumber++);
                        }
                        if (msg['Reply'] === '') {
                            console.log(msg['Reply']);
                            $('.msgRow p').addClass('d-none');
                            $('.msgRow p').removeClass('d-inline-block');
                        } else {
                            $('.msgRow p a').attr('onclick', 'deleteMsg(' + msg['ID'] + ')');
                            $('.msgRow #replyText').text(msg['Reply']);
                        }
                        $('.msgRow').appendTo($('.msgContainer'));
                        $('.msgRow').removeClass('msgRow');
                        $('.msgRow .fancy').removeClass('js-fancybox');
                        $('.msgRow .js-fancybox').removeAttr('data-fancybox');
                        $('.msgRow .js-fancybox').removeAttr('data-caption');
                        $('.msgRow .js-fancybox').removeAttr('data-speed');
                        $('.msgRow .js-fancybox').removeAttr('data-is-infinite');
                        $('.msgRow .js-fancybox').removeAttr('data-slideshow-speed');
                        $('.msgRow #attachPath').removeClass('d-none');
                        $('.msgRow p').removeClass('d-none');
                        $('.msgRow p').addClass('d-inline-block');
                        $('.msgRow').addClass('d-none');
                        $('#imgPreview').css('background-image', 'none')
                        $('#attachImgBtn i').removeClass('fa fa-spin fa-spinner');
                        $('#attachImgBtn i').addClass('icon-camera');
                    }
                }).done(function () {
                    $('#attachImgBtn').prop('disable', false);
                    $('#attachImgBtn i').remove();
                    $('#attachImgBtn').text('ارسال پیام');
                })
            }
        });

        function insertImg(key) {
            $('#postImg-' + key).trigger('click');
            $('#imgWorking').text('#addImgBtn-' + key)
        }

        function eventShow(key) {
            // $('#circleBorder-' + key).removeClass('circleBorder');
            // $('#borderAnimate-' + key).removeClass('borderAnimate');
            $('#allEvents').modal('show');
            startSlide = key;
        }

        $('#allEvents').on('hide.bs.modal hidden.bs.modal', function () {
            let owl = $('.owl-carousel');

            owl.owlCarousel('destroy');
            //clear all timer
            window.clearTimeout(mouseUpTimer);
            window.clearTimeout(lastSlideTimer);
            $('.slide-0').attr('style', 'width:0 !important;');
            $('.otherTimeBar').attr('style', 'width:100% !important;');
        });

        let mouseUpTimer, lastSlideTimer;
        $('#allEvents').on('shown.bs.modal', function () {
            let owl = $('.owl-carousel'),
                restart = 5000,
                items = $('.item').length,
                width = 100 / items,
                block = false,
                currentTime = 0,
                userID = $('#userID').text(),
                remaining = restart;
            $('.owlDots').attr('style', 'width:' + width + '%');

            owl.on('translate.owl.carousel', function (e) {
                let index = e.item.index;
                $('#eventBackground-' + index + '-' + imgRowID[index]).css('background-image', 'url(' + $('#asset').text() + 'img/SellerMajor/Events/' + userID + '/' + imgRowID[index] + '.jpg)');
                owl.trigger('stop.owl.autoplay');
                owl.trigger('play.owl.autoplay', [restart]);
                resetProgressBar(index);
            });


            owl.on('drag.owl.carousel', function (e) {
                console.log('drag: ' + e.item.index);
                $('.slide-' + e.item.index).attr('style', 'width:100% !important;');
            });

            $(".owl-carousel").on('initialized.owl.carousel translated.owl.carousel', function (e) {
                startProgressBar(e.item.index, restart);
                if (!e.namespace) return;
                let carousel = e.relatedTarget,
                    current = carousel.current() + 1;
                window.clearTimeout(mouseUpTimer);
                window.clearTimeout(lastSlideTimer);
                if (current == $('#eventLen').text()) {
                    lastSlideTimer = setTimeout(function () {
                        $('#closeEventModal').trigger('click');
                    }, restart);
                }
                console.log('ok')
            });

            owl.on('changed.owl.carousel', function (e) {
                if (!e.namespace) return;
                let current = e.relatedTarget.current();
                if (slideDirection === 'r') {
                    $('.slide-' + (current - 1)).attr('style', 'width:100% !important;');
                }
                if (slideDirection === 'l') {
                    $('.slide-' + (current + 1)).attr('style', 'width:100% !important;');
                }
            });

            console.log('background-image', 'url(' + $('#asset').text() + 'img/SellerMajor/Events/' + $('#userID').text() + '/' + imgRowID[0] + '.jpg)')
            $('#eventBackground-0-' + imgRowID[0]).css('background-image', 'url(' + $('#asset').text() + 'img/SellerMajor/Events/' + $('#userID').text() + '/' + imgRowID[0] + '.jpg)');
            owl.trigger('play.owl.autoplay', [restart]);
            owl.owlCarousel({
                loop: false,
                autoplay: true,
                autoplayTimeout: restart,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });

            $(".owl-item").bind('touchstart mousedown', function (e) {
                let carousel = $('.owl-carousel').data('owl.carousel'),
                    index = carousel.relative($(this).index()),
                    slide = $('.slide-' + index),
                    slideWidth = 100;

                if (!block) {
                    block = true;
                    window.clearTimeout(mouseUpTimer);
                    window.clearTimeout(lastSlideTimer);
                    slide.animate({
                        width: slideWidth
                    }, {
                        duration: restart,
                        step: function (now, fx) {
                            currentTime = Math.round((now * restart) / slideWidth);
                            if (now > 99) {
                                currentTime = 0;
                            }
                        },
                        easing: 'linear'
                    });
                    slide.stop();
                    owl.trigger('stop.owl.autoplay');
                    block = false;
                }
            }).bind('touchend mouseup', function (e) {
                let carousel = $('.owl-carousel').data('owl.carousel'),
                    index = carousel.relative($(this).index()),
                    eventLen = parseInt($('#eventLen').text());
                if (!block) {
                    block = true;
                    remaining = restart - currentTime;
                    if ((index + 1) === eventLen && eventLen > 1) {
                        $('.slide-' + index).attr('style', 'transition :width ' + remaining + 'ms linear !important; width: 100% !important;');
                        owl.trigger('play.owl.autoplay', [remaining]);
                        mouseUpTimer = setTimeout(function () {
                            $('#closeEventModal').trigger('click');
                        }, remaining);
                    } else {
                        $('.slide-' + index).attr('style', 'transition :width ' + remaining + 'ms linear !important; width: 100% !important;');
                        owl.trigger('play.owl.autoplay', [remaining]);
                    }

                    block = false;
                }
            });
        });

        let slideDirection = '';
        $('#leftSlide').on('click', function () {
            window.clearTimeout(mouseUpTimer);
            window.clearTimeout(lastSlideTimer);
            slideDirection = 'l';
            $(".owl-carousel").trigger('prev.owl.carousel');
        });

        $('#rightSlide').on('click', function () {
            window.clearTimeout(mouseUpTimer);
            slideDirection = 'r';
            $(".owl-carousel").trigger('next.owl.carousel');
        });

        function isEmpty(el) {
            return !$.trim(el.html())
        }

        function startProgressBar(index, time) {
            $('#dot-' + index).removeClass('d-none');
            // apply keyframe animation
            $('.slide-' + index).css({
                width: "100%",
                transition: 'width ' + time + 'ms linear'
            });
        }

        function resetProgressBar(index) {
            $('.slide-' + index).css({
                width: 0,
                transition: "width 0s"
            });
        }

        function removeProfileImg() {
            $.confirm({
                title: 'حذف تصویر پروفایل',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        window.location = '/Administrator-SellerMajor-profileImgRemove';
                    },
                    انصراف: function () {
                    },
                }
            });
        }

        function removeEvent(item) {
            let id = window.setTimeout(function () {
            }, 0);
            //clear all timer
            while (id--) {
                window.clearTimeout(id);
            }
            $.confirm({
                title: 'حذف رویداد',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        window.location = '/Administrator-SellerMajor-removeEvent/' + item;
                    },
                    انصراف: function () {
                    },
                }
            });
        }

        function nowDate() {
            let week = ["يكشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه", "شنبه"],
                months = ["فروردين", "ارديبهشت", "خرداد", "تير", "مرداد", "شهريور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"],
                today = new Date(),
                d = today.getDay(),
                day = today.getDate(),
                month = today.getMonth() + 1,
                year = today.getFullYear() - (1900);
            let i, y;
            year = (window.navigator.userAgent.indexOf('MSIE') > 0) ? year : 1900 + year;
            if (year === 0) {
                year = 2000;
            }
            if (year < 100) {
                year += 1900;
            }
            y = 1;
            for (i = 0; i < 3000; i += 4) {
                if (year === i) {
                    y = 2;
                }
            }
            for (i = 1; i < 3000; i += 4) {
                if (year === i) {
                    y = 3;
                }
            }
            if (y === 1) {
                year -= ((month < 3) || ((month === 3) && (day < 21))) ? 622 : 621;
                switch (month) {
                    case 1:
                        (day < 21) ? (month = 10, day += 10) : (month = 11, day -= 20);
                        break;
                    case 2:
                        (day < 20) ? (month = 11, day += 11) : (month = 12, day -= 19);
                        break;
                    case 3:
                        (day < 21) ? (month = 12, day += 9) : (month = 1, day -= 20);
                        break;
                    case 4:
                        (day < 21) ? (month = 1, day += 11) : (month = 2, day -= 20);
                        break;
                    case 5:
                    case 6:
                        (day < 22) ? (month -= 3, day += 10) : (month -= 2, day -= 21);
                        break;
                    case 7:
                    case 8:
                    case 9:
                        (day < 23) ? (month -= 3, day += 9) : (month -= 2, day -= 22);
                        break;
                    case 10:
                        (day < 23) ? (month = 7, day += 8) : (month = 8, day -= 22);
                        break;
                    case 11:
                    case 12:
                        (day < 22) ? (month -= 3, day += 9) : (month -= 2, day -= 21);
                        break;
                    default:
                        break;
                }
            }
            if (y === 2) {
                year -= ((month < 3) || ((month === 3) && (day < 20))) ? 622 : 621;
                switch (month) {
                    case 1:
                        (day < 21) ? (month = 10, day += 10) : (month = 11, day -= 20);
                        break;
                    case 2:
                        (day < 20) ? (month = 11, day += 11) : (month = 12, day -= 19);
                        break;
                    case 3:
                        (day < 20) ? (month = 12, day += 10) : (month = 1, day -= 19);
                        break;
                    case 4:
                        (day < 20) ? (month = 1, day += 12) : (month = 2, day -= 19);
                        break;
                    case 5:
                        (day < 21) ? (month = 2, day += 11) : (month = 3, day -= 20);
                        break;
                    case 6:
                        (day < 21) ? (month = 3, day += 11) : (month = 4, day -= 20);
                        break;
                    case 7:
                        (day < 22) ? (month = 4, day += 10) : (month = 5, day -= 21);
                        break;
                    case 8:
                        (day < 22) ? (month = 5, day += 10) : (month = 6, day -= 21);
                        break;
                    case 9:
                        (day < 22) ? (month = 6, day += 10) : (month = 7, day -= 21);
                        break;
                    case 10:
                        (day < 22) ? (month = 7, day += 9) : (month = 8, day -= 21);
                        break;
                    case 11:
                        (day < 21) ? (month = 8, day += 10) : (month = 9, day -= 20);
                        break;
                    case 12:
                        (day < 21) ? (month = 9, day += 10) : (month = 10, day -= 20);
                        break;
                    default:
                        break;
                }
            }
            if (y === 3) {
                year -= ((month < 3) || ((month === 3) && (day < 21))) ? 622 : 621;
                switch (month) {
                    case 1:
                        (day < 20) ? (month = 10, day += 11) : (month = 11, day -= 19);
                        break;
                    case 2:
                        (day < 19) ? (month = 11, day += 12) : (month = 12, day -= 18);
                        break;
                    case 3:
                        (day < 21) ? (month = 12, day += 10) : (month = 1, day -= 20);
                        break;
                    case 4:
                        (day < 21) ? (month = 1, day += 11) : (month = 2, day -= 20);
                        break;
                    case 5:
                    case 6:
                        (day < 22) ? (month -= 3, day += 10) : (month -= 2, day -= 21);
                        break;
                    case 7:
                    case 8:
                    case 9:
                        (day < 23) ? (month -= 3, day += 9) : (month -= 2, day -= 22);
                        break;
                    case 10:
                        (day < 23) ? (month = 7, day += 8) : (month = 8, day -= 22);
                        break;
                    case 11:
                    case 12:
                        (day < 22) ? (month -= 3, day += 9) : (month -= 2, day -= 21);
                        break;
                    default:
                        break;
                }
            }
            // let now = week[d] + " " + day + " " + months[month - 1] + " " + year;
            let now = day + " " + months[month - 1] + " " + year;
            return now;
        }

        function deleteMsg(msgDetailID) {
            console.log(msgDetailID);
            $.confirm({
                title: 'حذف پیام',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        $.ajax({
                            type: 'GET',
                            url: '/Administrator-SellerMajor-Messages-Delete/' + msgDetailID,
                            success: function (data) {
                                $('#msg-' + msgDetailID).remove();
                                console.log(data);
                            }
                        })
                    },
                    انصراف: function () {
                    },
                }
            });
        }

        function deleteUserMsg(msgID) {
            console.log(msgID);
            $.confirm({
                title: 'حذف پیام',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        $.ajax({
                            type: 'GET',
                            url: '/Administrator-SellerMajor-UserMessages-Delete/' + msgID,
                            success: function (data) {
                                $('#msg-' + msgID).remove();
                                console.log(data);
                            }
                        })
                    },
                    انصراف: function () {
                    },
                }
            });
        }

        $('.modal').on('shown.bs.modal', function () {
            $(this).find('[autofocus]').focus();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    let img = $('#imgPreview'),
                        time = new Date();
                    img.css('background-image', 'url(' + e.target.result + ')');
                    img.css('background-size', 'cover');
                    img.css('height', '100%');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        // add post code
        $('#postModal').mouseup(function (e) {
            let container = $(".listContainer");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $('.listItems').hide();
            }
        });

        function addComa(thisElement) {
            if ($('#price').val() !== '') {
                let price = thisElement.val();
                $('#tempPrice').text(price.replace(new RegExp(',', 'g'), ""));
                $('#tempFinalPrice').text(price.replace(new RegExp(',', 'g'), ""));
                $('#price').val(price.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#finalPrice').val(price.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                console.log(parseInt(price.replace(new RegExp(',', 'g'), "")))
                if (parseInt(price.replace(new RegExp(',', 'g'), "")) >= 10000) {
                    $('#lblPrice').removeClass('g-color-red');
                    $('#lblFinalPrice').removeClass('g-color-red');
                } else {
                    $('#lblPrice').addClass('g-color-red');
                    $('#lblFinalPrice').addClass('g-color-red');
                }
            } else {
                $('#discount').val('');
                $('#finalPrice').val('...');
                $('#tempPrice').text('');
                $('#tempFinalPrice').text('');
                $('#lblPrice').addClass('g-color-red');
            }
        }
    </script>
@endsection
