@section('SellerMajorJsFunction')
    <script>
        // stop fancy box additional url
        if ($('.js-fancybox').length > 0) {
            $.fancybox.defaults.hash = false;

        }

        function copy(textToCopy) {
            navigator.clipboard.writeText(textToCopy).then(
                function () {
                    /* clipboard successfully set */
                    window.alert('متن کپی شد.')
                },
                function () {
                    /* clipboard write failed */
                    window.alert('ناموفق')
                }
            )
        }

        let imgRowID = [], imgRowIdTemp, lastScrollTop = 0, lastScrollTopModal = 0, postNumber = 0, completeLoad = true,
            touchtime = 0, postDeleteItems = [], imgWorking = 0, asset = $('#asset').text(), imgNumber = 0, file_type, dragging=false;
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
            $('html').css({overflow: 'hidden', height: '100%'});
            let sumHeight = 0;
            $('[id^="detailPost-"]').each(function (index) {
                if (index < postNumber) {
                    sumHeight += $('#detailPost-' + index).outerHeight();
                }
            })
            $(this).scrollTop(sumHeight + Math.round(0.85 * sumHeight / 100));
        });

        $('#postRail').on('hide.bs.modal hidden.bs.modal', function () {
            $('html').css('overflow', 'auto');
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
                url: '/Seller-Major-Load-Post',
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
                            dragging=true;
                        },
                        touchEnd: function (s, e) {
                            s.zoom.out();
                            dragging=false;
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
                    url: '/Seller-Major-AddComment/' + postID,
                    async: false,
                    success: function (data) {
                        let showReplyCommentBtn = '<div style="direction: rtl; cursor: pointer" class="countCommentReply g-pr-25"><small>...دیدن پاسخ ها...</small></div>';
                        for (let i = 0; i < data[0].length; i++) {
                            if (data[0][i]['Commenter'] === 'customer') {
                                let username = data[0][i]['customerName'] !== null ? data[0][i]['customerName'] : 'کاربر' + data[0][i]['CommenterID'];
                                $('.postCommentCopy .userInfo span').text(username);
                                $('.postCommentCopy .userInfo img').attr('src', data[0][i]['PicPath']);
                                $('.postCommentCopy .commentReplying').attr('onclick', 'commentReplying(' + data[0][i]['commentId'] + ',"' + username + '",' + key + ')');
                                $('.postCommentCopy .commentLiking').attr('onclick', 'commentLiking(' + data[0][i]['commentId'] + ',-1,"comment",)');
                                $('.postCommentCopy .commentLike').attr('id', 'commentLike-' + data[0][i]['commentId']);
                                $('.postCommentCopy .commentLiking').removeClass('d-none');
                            } else {
                                $('.postCommentCopy .userInfo span').text(data[0][i]['sellerMajorName']);
                                $('.postCommentCopy .userInfo img').attr('src', data[0][i]['Pic'] + '/profileImg.jpg');
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
                                        $('.postCommentReplyCopy .userInfo img').attr('src', data[2][j]['PicPath']);
                                        $('.postCommentReplyCopy .commentReplying').attr('onclick', 'commentReplying(' + data[0][i]['commentId'] + ',"' + username + '",' + key + ')');
                                        $('.postCommentReplyCopy .commentLike').attr('id', 'commentReplyLike-' + data[2][j]['commentReplyID']);
                                        $('.postCommentReplyCopy .commentLikeIcon').attr('id', 'commentReplyLikeIcon-' + data[2][j]['commentReplyID']);
                                        $('.postCommentReplyCopy .commentLiking').attr('onclick', 'commentLiking(' + data[0][i]['commentId'] + ',' + data[2][j]['commentReplyID'] + ',"reply")');
                                        $('.postCommentReplyCopy .commentLiking').removeClass('d-none');
                                    } else {
                                        $('.postCommentReplyCopy .userInfo span').text(data[2][j]['sellerMajorName']);
                                        $('.postCommentReplyCopy .userInfo img').attr('src', data[2][j]['Pic'] + '/profileImg.jpg');
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

        function sendComment(postID, textElement) {
            let key = textElement.replace(/[^0-9]/gi, ''), allCommentCount,
                replyID = $('#commentReplyID').text(),
                customerName = $('#customerName-' + key).length > 0 ? '@' + $('#customerName-' + key).text() + ' ' : '',
                commentValue = customerName + $('#' + textElement).val();

            $('#sendCommentBtn-' + key + ' i').removeClass('fa-arrow-left');
            $('#sendCommentBtn-' + key + ' i').addClass('fa-spin')
            $('#sendCommentBtn-' + key + ' i').addClass('fa-spinner')
            $.ajax({
                type: 'GET',
                url: '/Seller-Major-Send-Comment/' + postID + '/' + commentValue + '/' + (replyID === '' ? 'comment' : replyID) + '/',
                success: function (data) {
                    let commentText = 'CommentText',
                        commentLike = 'CommentLike',
                        commentContainer = "#commentContainer-" + key,
                        tempCopy = '.postCommentCopy';

                    if (replyID !== '') {
                        commentText = 'CommentReplyText';
                        commentLike = 'CommentReplyLike';
                        commentContainer = "#commentReply-" + data[0]['commentId'];
                        tempCopy = '.postCommentReplyCopy';
                        $('.postCommentReplyCopy .deleteCommentReply').attr('onclick', 'deleteComment(' + data[0]['commentReplyId'] + ',"commentReply",$(this),' + data[0]['PostID'] + ')');
                    } else {
                        $(tempCopy + ' .commentReply').attr('id', "commentReply-" + data[0]['commentId']);
                        $('.postCommentCopy .deleteComment').attr('onclick', 'deleteComment(' + data[0]['commentId'] + ',"comment",$(this),' + data[0]['PostID'] + ')');
                    }

                    $(tempCopy + ' .userInfo span').text(data[0]['name']);
                    $(tempCopy + ' .userInfo img').attr('src', data[0]['Pic'] + '/profileImg.jpg');
                    $(tempCopy + ' .commentText').text(data[0][commentText]);
                    $(tempCopy + ' .commentLike').text(data[0][commentLike] + ' پسند');
                    $(tempCopy + ' .commentLiking').addClass('d-none');
                    $(tempCopy + ' .commentTime').text(data[1]);
                    $(tempCopy + ' .commentReplying').attr('onclick', 'commentReplying(' + data[0]['commentId'] + ',"' + data[0]['name'] + '",' + key + ')');
                    allCommentCount = parseInt($('.postID-' + postID + ' .allComment').text()) + 1;
                    $('.postID-' + postID + ' .allComment').text(allCommentCount)
                    $(tempCopy).removeClass('d-none');
                    $(tempCopy).clone().appendTo(commentContainer);
                    if (replyID !== '') {
                        $('.postCommentReplyCopy').attr('id', 'commentReplyID-' + data[0]['commentReplyId']);
                    } else {
                        $('.postCommentCopy').attr('id', 'commentID-' + data[0]['commentId']);
                    }
                    $(commentContainer + ' .postCommentCopy').removeClass('postCommentCopy');
                    $(commentContainer + ' .postCommentReplyCopy').removeClass('postCommentReplyCopy');
                    if (commentText === 'CommentReplyText') {
                        $(commentContainer + ' .commentReplyDetail').removeClass('d-none')
                        $(commentContainer + ' .countCommentReply').remove();
                    }
                }
            }).done(function () {
                $('#sendCommentBtn-' + key + ' i').removeClass('fa-spin');
                $('#sendCommentBtn-' + key + ' i').removeClass('fa-spinner');
                $('#sendCommentBtn-' + key + ' i').addClass('fa-check g-color-primary');

                setTimeout(function () {
                    $('#sendCommentBtn-' + key).addClass('d-none');
                    $('#sendCommentBtn-' + key + ' i').removeClass('fa-check g-color-primary');
                    $('#sendCommentBtn-' + key + ' i').addClass('fa-arrow-left');
                    $('#' + textElement).val('');
                }, 1000)

                $('#commentReplyID').text('')
            })
            $('.postCommentCopy').addClass('d-none');
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
                            url: '/Seller-Major-Comment-Delete/' + id + '/' + status,
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

        function commentReplying(commentID, commenterName, key) {
            console.log(commenterName);
            commenterName = '@' + commenterName + ' ';
            $('#commentReplyID').text(commentID);
            $('#comment-' + key).val(commenterName);
            $('#comment-' + key).focus();
        }

        function commentLiking(id, replyID, status) {
            let commentLike = '#commentLike-' + id,
                commentLikeIcon = '#commentLikeIcon-' + id,
                likeStatus = 0;
            if (status === 'reply') {
                commentLike = '#commentReplyLike-' + replyID;
                commentLikeIcon = '#commentReplyLikeIcon-' + replyID;
            }
            if ($(commentLikeIcon).hasClass('fa-heart')) {
                likeStatus = 1;
            }
            $.ajax({
                type: 'GET',
                url: '/Seller-Major-LikeComment/' + id + '/' + replyID + '/' + status + '/' + likeStatus,
                async: false,
                success: function (data) {
                    if (likeStatus === 1) {
                        $(commentLike).text((parseInt($(commentLike).text()) - 1) + ' پسند');
                        $(commentLikeIcon).removeClass('fa-heart');
                        $(commentLikeIcon).addClass('fa-heart-o');
                        $(commentLikeIcon).removeClass('g-color-red');
                    } else {
                        $(commentLike).text((parseInt($(commentLike).text()) + 1) + ' پسند');
                        $(commentLikeIcon).removeClass('fa-heart-o');
                        $(commentLikeIcon).addClass('fa-heart');
                        $(commentLikeIcon).addClass('g-color-red');
                    }

                }
            })
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
                            url: '/Seller-Major-Delete-Post/' + postID,
                            success: function (data) {
                                console.log(data)
                                $('#detailPost-' + key).remove();
                                $('#postSample-' + key).remove();
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

        function editPost(postID) {
            $('.captionInfo-' + postID).removeClass('d-none');
            $('#editPostCaption-' + postID + ' p').addClass('d-none');
            $('#editPostCaption-' + postID + ' div').removeClass('d-none');
            $('#editPostCaption-' + postID + ' textarea').focus();
        }

        function saveCaption(thisElement, postID) {
            let text = $('#editPostCaption-' + postID + ' textarea').val(),
                items = JSON.stringify(postDeleteItems);
            thisElement.find('i').removeClass('fa-check').addClass('fa-spin fa-spinner').css('margin', '-7px');
            $.confirm({
                title: 'ویرایش اطلاعات',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: '/Seller-Major-Edit-Post',
                            data: {'postID': postID, 'items': items, 'text': text},
                            success: function (data) {
                                console.log(data);
                                $('.captionInfo-' + postID).addClass('d-none');
                                $('#editPostCaption-' + postID + ' p').removeClass('d-none');
                                $('#editPostCaption-' + postID + ' p').text(text);
                                $('#editPostCaption-' + postID + ' div').addClass('d-none');
                                thisElement.find('i').addClass('fa-check').removeClass('fa-spin fa-spinner').css('margin', '0');
                            }
                        })
                    },
                    انصراف: function () {
                        $('.captionInfo-' + postID).addClass('d-none');
                        $('#editPostCaption-' + postID + ' p').removeClass('d-none');
                        $('#editPostCaption-' + postID + ' div').addClass('d-none');
                        thisElement.find('i').addClass('fa-check').removeClass('fa-spin fa-spinner').css('margin', '0');
                    },
                }
            })
        }

        function cancelEditCaption(postID) {
            let item;
            $('.captionInfo-' + postID).addClass('d-none');
            $('#editPostCaption-' + postID + ' p').removeClass('d-none');
            $('#editPostCaption-' + postID + ' div').addClass('d-none');
            for (let i = 0; i < postDeleteItems.length; i++) {
                item = postDeleteItems[i] + '-' + postID;
                if (typeof (postDeleteItems[i]) != "undefined" && postDeleteItems[i] !== null) {
                    $('#' + item).parent('div').eq(0).removeClass('d-none');
                }
            }
        }

        function deletePostInfo(postID, item) {
            switch (item) {
                case 'cat':
                    postDeleteItems[0] = item;
                    $('#cat-' + postID).parent().closest('div').eq(0).addClass('d-none');
                    break;
                case 'productName':
                    postDeleteItems[1] = item;
                    $('#productName-' + postID).parent().closest('div').eq(0).addClass('d-none');
                    break;
                case 'size':
                    postDeleteItems[2] = item;
                    $('#size-' + postID).parent().closest('div').eq(0).addClass('d-none');
                    break;
                case 'color':
                    postDeleteItems[3] = item;
                    $('#color-' + postID).parent().closest('div').eq(0).addClass('d-none');
                    break;
                case 'price':
                    postDeleteItems[4] = item;
                    $('#price-' + postID).parent().closest('div').eq(0).addClass('d-none');
                    break;
                case 'discount':
                    postDeleteItems[5] = item;
                    $('#discount-' + postID).parent().closest('div').eq(0).addClass('d-none');
                    break;
                case 'finalPrice':
                    postDeleteItems[6] = item;
                    $('#finalPrice-' + postID).parent().closest('div').eq(0).addClass('d-none');
                    break;
                default:
            }
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
                    url: '/Seller-Major-Chart-Post/' + postID,
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
            if (window.location.pathname === '/Seller-Major-Messages-Detail') {
                setTimeout(function () {
                    $('#answer').focus();
                }, 100)
            }

            if (window.location.pathname === '/Seller-Major-Panel') {
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
                                dragging=true;
                            },
                            touchEnd: function (s, e) {
                                s.zoom.out();
                                dragging=false;
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

        // تنظیم تصویر پروفایل
        $(document).ready(function () {
            // scroll to 0 postion when refresh page in panel
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }
            $(document).scrollTop(0);
            //------

            //چک کردن ابعاد تصویر
            let windowWidth = $(window).width(),
                windowHeight = $(window).height();
            switch (true) {
                case (windowWidth > 1000):
                    $('.eventContainer').css('width', 'auto !important')
                    break;
            }

            //تنظیم تصویر پروفایل
            let mq = window.matchMedia("(max-width: 900px)");
            if (mq.matches) {
                $('#bigDevice').remove();
                $('.bigDevice').remove();

            } else {
                $('#smallDevice').remove();
                $('.smallDevice').remove();
            }

            let $modal = $('#modal'),
                image = document.getElementById('sample_image'),
                cropper;
            $('#profileImg').on('change', function (event) {
                let files = event.target.files,
                    done = function (url) {
                        image.src = url;
                        $modal.modal('show');
                    };

                if (files && files.length > 0) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                    file_type = files[0].type;
                }
            });

            $modal.on('shown.bs.modal', function () {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    zoomable: true,
                    background: true,
                    minCropBoxWidth: 500,
                    minCropBoxHeight: 500,
                    dragCrop: true,
                    dragMode: 'move',
                    multiple: true,
                    movable: true
                    // preview: '.preview'
                });
            });

            $modal.on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            $('#crop').on('click', function () {
                let canvas = cropper.getCroppedCanvas({
                    width: 500,
                    height: 500
                });

                canvas.toBlob(function (blob) {
                    let url = URL.createObjectURL(blob),
                        reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        let type = file_type.split('/'), form;
                        file_upload = new File([blob], "pic." + type[1]);
                        form = new FormData();
                        form.append('imageUrl', file_upload);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/Seller-Major-profileImgUpdate',
                            data: form,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            beforeSend: function () {
                                $('#profileImgSubmitIcon').addClass('d-none');
                                $('#waitingCrop').removeClass('d-none');
                            },
                            success: function () {
                                console.log('uploaded');
                                $modal.modal('hide');
                                $('#profileImgSubmitIcon').removeClass('d-none');
                                $('#waitingCrop').addClass('d-none');
                                location.reload();
                            }
                        });
                    };
                });
            });

            $('.nowDate').text(nowDate());
        });

        // افزودن رویداد
        $(document).ready(function () {
            let $eventModal = $('#eventModal'),
                eventImage = document.getElementById('event_sample_image'),
                eventCropper;

            $('[id^="eventBackground-"]').each(function (i, obj) {
                imgRowIdTemp = $(this).attr('id').split('-');
                imgRowID[i] = imgRowIdTemp[2];
            });

            $('#eventImg').on('change', function (event) {
                let files = event.target.files,
                    done = function (url) {
                        eventImage.src = url;
                        $eventModal.modal('show');
                    };

                if (files && files.length > 0) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                    file_type = files[0].type;
                }
            });

            $eventModal.on('shown.bs.modal', function () {
                eventCropper = new Cropper(eventImage, {
                    aspectRatio: 9 / 16,
                    viewMode: 1,
                    zoomable: true,
                    background: true,
                    minCropBoxWidth: 1080,
                    minCropBoxHeight: 1920,
                    dragCrop: true,
                    dragMode: 'move',
                    multiple: true,
                    movable: true
                    // preview: '.preview'
                });
            });

            $eventModal.on('hidden.bs.modal', function () {
                eventCropper.destroy();
                eventCropper = null;
            });

            $('#eventCrop').on('click', function () {
                let canvas = eventCropper.getCroppedCanvas({
                    width: 1080,
                    height: 1920
                });

                canvas.toBlob(function (blob) {
                    let url = URL.createObjectURL(blob),
                        reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        $('#eventImageUrl').val(reader.result);
                        // $('#profileImgBox').attr('src', url);
                        $eventModal.modal('hide');
                        $("#eventImageUrl").clone().appendTo("#eventUploadForm");
                        $('#eventUploadForm').submit();
                    };
                    reader.onloadend = function () {
                        let type = file_type.split('/'), form;
                        file_upload = new File([blob], "pic." + type[1]);
                        form = new FormData();
                        form.append('imageUrl', file_upload);
                        form.append('text', $('#eventTextTemp').val());
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/Seller-Major-addEvent',
                            data: form,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            beforeSend: function () {
                                $('#eventSubmitIcon').addClass('d-none');
                                $('#waitingEventCrop').removeClass('d-none');
                            },
                            success: function () {
                                console.log('uploaded');
                                $('#eventSubmitIcon').removeClass('d-none');
                                $('#waitingEventCrop').addClass('d-none');
                                location.reload();
                            }
                        });
                    };
                });
            });
        });

        function insertImg(key) {
            $('#postImg-' + key).trigger('click');
            $('#imgWorking').text('#addImgBtn-' + key)
        }

        // افزودن پست
        $(document).ready(function () {
            let $postModal = $('#postModal'),
                postImage = null,
                postCropper;
            $('#postImg-0').on('change', function (event) {
                imgWorking = $('#imgWorking').text();
                let files = event.target.files,
                    done = function (url) {
                        (async () => {
                            const res = await fetch(url)
                            const blob = await res.blob()
                            const img = new Image()
                            img.src = URL.createObjectURL(blob)

                            // newer promise based version of img.onload
                            await img.decode()

                            $('.uploadImage').append(img)
                            $('.uploadImage img').attr('id','post_sample_image');
                            $('.uploadImage img').css('width','100%');
                            postImage = document.getElementById('post_sample_image');

                            // Don't forget to revoke the blob url when
                            // you no longer need it (to release memory)
                            URL.revokeObjectURL(img.src)
                        })()
                        $postModal.modal('show');
                    };

                if (files && files.length > 0) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                    file_type = files[0].type;
                }
            });
            $('#postImg-1').on('change', function (event) {
                imgWorking = $('#imgWorking').text();
                let files = event.target.files,
                    done = function (url) {
                        postImage.src = url;
                        $postModal.modal('show');
                    };

                if (files && files.length > 0) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                    file_type = files[0].type;
                }
            });
            $('#postImg-2').on('change', function (event) {
                imgWorking = $('#imgWorking').text();
                let files = event.target.files,
                    done = function (url) {
                        postImage.src = url;
                        $postModal.modal('show');
                    };

                if (files && files.length > 0) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                    file_type = files[0].type;
                }
            });
            $('#postImg-3').on('change', function (event) {
                imgWorking = $('#imgWorking').text();
                let files = event.target.files,
                    done = function (url) {
                        postImage.src = url;
                        $postModal.modal('show');
                    };

                if (files && files.length > 0) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                    file_type = files[0].type;
                }
            });

            $postModal.on('shown.bs.modal', function () {
                console.log(postImage)
                postCropper = new Cropper(postImage, {
                    aspectRatio: 4 / 5,
                    viewMode: 1,
                    zoomable: true,
                    background: true,
                    minCropBoxWidth: 1400,
                    minCropBoxHeight: 1750,
                    dragCrop: true,
                    dragMode: 'move',
                    multiple: true,
                    movable: true,
                });
            });

            $postModal.on('hidden.bs.modal', function () {
                postCropper.destroy();
                $('[name^="postImg"]').val(null);
                postCropper = null;
            });

            $('.postCrop').on('click', function () {
                let canvas = postCropper.getCroppedCanvas({
                    width: 1400,
                    height: 1750
                });

                canvas.toBlob(function (blob) {
                    let url = URL.createObjectURL(blob),
                        reader = new FileReader(), key = imgWorking.replace(/[^0-9]/gi, '');
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        let type = file_type.split('/'), form;
                        file_upload = new File([blob], "pic." + type[1]);
                        form = new FormData();
                        form.append('imageUrl', file_upload);
                        form.append('imgNumber', key);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/Seller-Major-uploadImage',
                            data: form,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            beforeSend: function () {
                                $postModal.modal('hide');
                                $('#addImgBtn-' + key + ' h3').addClass('d-none');
                                $('#addImgBtn-' + key + ' .loadingImg').removeClass('d-none');
                            },
                            success: function () {
                                console.log('uploaded');
                                $('#addImgBtn-' + key + ' .loadingImg').addClass('d-none');
                                $('#picCount').val(parseInt($('#picCount').val()) + 1);
                                $(imgWorking + ' .previewBox img').attr('src', reader.result);
                            }
                        });
                    };
                });
            });

            $('#postUploadForm').on('submit', (function (e) {
                $('#postSubmitIcon').addClass('d-none');
                $('#waitingPostCrop').removeClass('d-none');
                $('#formCat').val($('#productCat').val());
                $('#formCatCode').val($('#catCode').text());
                $('#formName').val($('#productName').val());
                $('#formNameCode').val($('#productCode').text());
                $('#formGender').val($('#gender').text());
                $('#formGenderCode').val($('#genderCode').text());
                $('#formSize').val($('#size').text());
                $('#formPrice').val($('#tempPrice').text());
                $('#formFinalPrice').val($('#tempFinalPrice').text());
                $('#formDiscount').val($('#discount').val());
                $('#formColor').val($('#color').val());
                $('#formColorCode').val($('#colorCode').text());
                $('#postText').val($('#postTextTemp').val());
            }));
        });

        $('#addImg').on('click', function () {
            $(this).find('i').removeClass('fa-check').addClass('fa-spin fa-spinner');
            $(this).find('i').css('margin', '-7px');
            $(this).prop('disabled', true);
            $('#postUploadForm').submit();
        });

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

        // برای قسمت کاستومر لازم است
        $(".growingToTop").on("input", function () {
            this.style.height = 0;
            this.style.height = (this.scrollHeight) + "px";
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
                        window.location = '/Seller-Major-profileImgRemove';
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
                        window.location = '/Seller-Major-removeEvent/' + item;
                    },
                    انصراف: function () {
                    },
                }
            });
        }

        function updateBio() {
            $('#bioEditIcon').addClass('d-none');
            $('#waitingBioUpdate').removeClass('d-none');
            $.ajax({
                type: 'GET',
                async: false,
                url: '/Seller-Major-bioUpdate/' + $('#bioText').val(),
                success: function (data) {
                    $('#bioSubmit').addClass('d-none');
                    $('#bioEditIcon').removeClass('d-none');
                    $('#waitingBioUpdate').addClass('d-none');
                    $('#bioEdit').removeClass('d-none');
                    $('#edited').text('0');
                    console.log(data);
                }
            });
        }

        function addressUpdate() {
            $('#addressUpdateIcon').addClass('d-none');
            $('#waitingAddressUpdate').removeClass('d-none');
            console.log('/Seller-Major-addressUpdate/' + $('#address').val());
            $.ajax({
                type: 'GET',
                async: false,
                url: '/Seller-Major-addressUpdate/' + $('#address').val(),
                success: function (data) {
                    $('#modalAddress').modal('toggle');
                    $('#addressLink').text(data);
                    $('#addressUpdateIcon').removeClass('d-none');
                    $('#waitingAddressUpdate').addClass('d-none');
                    console.log(data);
                }
            });
        }

        function socialAddressUpdate(app) {
            let link = $('#' + app).val().replace(/\//g, '88888888888888888888888'),
                url = '/Seller-Major-' + app + 'Update/' + link;
            console.log(url);
            $('#' + app + 'UpdateIcon').addClass('d-none');
            $('#' + app + 'UpdateWaiting').removeClass('d-none');
            $.ajax({
                type: 'GET',
                async: false,
                url: url,
                success: function (data) {
                    $('#' + app + 'Modal').modal('toggle');
                    $('#' + app + 'Link').text(data);
                    $('#' + app + 'UpdateIcon').removeClass('d-none');
                    $('#' + app + 'UpdateWaiting').addClass('d-none');
                    console.log(data);
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

        function attachImg() {
            $('#attachmentImg').trigger('click');
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
                            url: '/Seller-Major-Messages-Delete/' + msgDetailID,
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
                            url: '/Seller-Major-UserMessages-Delete/' + msgID,
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

        $('#attachmentImg').on('change', function (event) {
            readURL(this);
        });

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

        function setColor(colorCode, thisElement) {
            console.log('click')
            let color = thisElement.find('span').text();
            if (touchtime === 0) {
                // set first click
                touchtime = new Date().getTime();
            } else {
                // compare first click to this click and see if they occurred within double click threshold
                if (((new Date().getTime()) - touchtime) < 500) {
                    $('#colorCode').text(colorCode);
                    $('#color').val(color);
                    $('#accordion').hide();
                    $('#color').show();
                    touchtime = 0;
                    console.log('dbclick')
                } else {
                    // not a double click so set as a new first click
                    touchtime = new Date().getTime();
                }
            }
        }

        function setProductName(cat, catName) {
            $('.productNameContainer span').removeClass('d-none');
            $('.productNameContainer span').addClass('d-none');
            $('.productNameContainer a').removeClass('d-none');
            $('.productNameContainer a').addClass('d-none');
            $('.listItems').hide();
            $('#productCat').val(catName);
            $('#catCode').text(cat);
            switch (cat) {
                case 'a':
                    $('.lebasZir').removeClass('d-none');
                    $('#productName').val('شورت');
                    break;
                case 'b':
                    $('.lebasPaeinTane').removeClass('d-none');
                    $('#productName').val('شلوارک');
                    break;
                case 'c':
                    $('.lebasBalaTane').removeClass('d-none');
                    $('#productName').val('تیشرت');
                    break;
                case 'd':
                    $('.lebasTamamTane').removeClass('d-none');
                    $('#productName').val('لباس خواب');
                    break;
                case 'e':
                    $('.kif').removeClass('d-none');
                    $('#productName').val('پول');
                    break;
                case 'f':
                    $('.kafsh').removeClass('d-none');
                    $('#productName').val('دمپایی');
                    break;
                case 'g':
                    $('.varzeshiZir').removeClass('d-none');
                    $('#productName').val('مایو');
                    break;
                case 'h':
                    $('.varzeshiPaein').removeClass('d-none');
                    $('#productName').val('شورت');
                    break;
                case 'i':
                    $('.varzeshiBala').removeClass('d-none');
                    $('#productName').val('تیشرت');
                    break;
                case 'j':
                    $('.varzeshiTamam').removeClass('d-none');
                    $('#productName').val('ست ورزشی');
                    break;
                case 'k':
                    $('.varzeshiKif').removeClass('d-none');
                    $('#productName').val('ساک');
                    break;
                case 'l':
                    $('.varzeshiKafsh').removeClass('d-none');
                    $('#productName').val('کفش ساده');
                    break;
                case 'm':
                    $('.varzeshiAksesori').removeClass('d-none');
                    $('#productName').val('کلاه حرفه ای');
                    break;
                case 'n':
                    $('.aksesoriBadalijat').removeClass('d-none');
                    $('#productName').val('گوشواره');
                    break;
                case 'o':
                    $('.aksesoriMoo').removeClass('d-none');
                    $('#productName').val('گیره مو');
                    break;
                case 'p':
                    $('.aksesoriSarpoosh').removeClass('d-none');
                    $('#productName').val('کلاه زمستانی');
                    break;
                case 'q':
                    $('.aksesoriSayer').removeClass('d-none');
                    $('#productName').val('عینک');
                    break;
                default:
                    $('.aksesoriSayer').removeClass('d-none');
                    $('#productCat').val('');
                    $('#productName').val('');
            }
        }

        function setProductCode(thisElement) {
            let str = thisElement.text(),
                name = str.replace(str.match(/(\d+)/g)[0], '').trim(),
                code = str.replace(/[^0-9]/gi, '');
            $('#productName').val(name);
            $('#productCode').text(code);
            $('.listItems').hide();
        }

        function setFinalPrice(discount) {
            if (discount.val() !== '') {
                if ($('#price').val() !== '') {
                    if (discount.val() === '0') discount.val(''); else {
                        let p = parseInt($('#tempPrice').text()),
                            d = parseInt(discount.val()),
                            result = p - ((p * d) / 100);
                        $('#tempFinalPrice').text(result);
                        $('#finalPrice').val(result.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                }
            } else {
                $('#finalPrice').val($('#price').val());
                $('#tempFinalPrice').text($('#tempPrice').text());
            }

        }

        function addComa(thisElement) {
            if ($('#price').val() !== '') {
                let price = thisElement.val();
                $('#tempPrice').text(price.replace(new RegExp(',', 'g'), ""));
                $('#tempFinalPrice').text(price.replace(new RegExp(',', 'g'), ""));
                $('#price').val(price.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#finalPrice').val(price.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            } else {
                $('#discount').val('');
                $('#finalPrice').val('...');
                $('#tempPrice').text('');
                $('#tempFinalPrice').text('');
            }
        }
    </script>
@endsection
