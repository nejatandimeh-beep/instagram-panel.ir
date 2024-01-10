@section('FeedJsFunction')
    <script>
        $(document).mouseup(function (e) {
            if (window.location.pathname.indexOf('/Customer-SellerMajor-Search') >= 0 || window.location.pathname === '/Customer-Following-SellerMajor') {
                let container1 = $("#searchResult"), container2 = $("#searchInput");
                console.log('click')

                // if the target of the click isn't the container nor a descendant of the container
                if ((!container1.is(e.target) && container1.has(e.target).length === 0) && (!container2.is(e.target) && container2.has(e.target).length === 0)) {
                    $('#catList').collapse("hide");
                    container1.empty();
                }
            }
        });

        // detect leave document by time
        document.addEventListener("visibilitychange", function () {
            let thisTime = new Date(), milliseconds, seconds, urlAddress;
            if (document.hidden) {
                hideTime = thisTime.getTime();
                console.log("Browser tab is hidden", hideTime)
            } else {
                showTime = thisTime.getTime();
                milliseconds = showTime - hideTime;
                seconds = Math.floor(milliseconds / (1000));
                console.log("Browser tab is visible", showTime, seconds, ' sec');
                switch (window.location.pathname) {
                    case '/Feed':
                        if (seconds > 300) {
                            console.log('refresh page..');
                            window.location.href = '/Feed';
                        }
                        break;
                    case '/Customer-SellerMajor-Saved':
                        if (seconds > 300) {
                            console.log('refresh page..');
                            window.location.href = '/Customer-SellerMajor-Saved';
                        }
                        break;
                    case window.location.pathname.indexOf("/Customer-SellerMajor-Panel") >= 0:
                        if (seconds > 300) {
                            console.log('refresh page..');
                            window.location.href = '/Customer-SellerMajor-Panel';
                        }
                        break;
                    case window.location.pathname.indexOf("/Customer-SellerMajor-Search") >=0:
                        if (seconds > 300) {
                            console.log('refresh page..');
                            window.location.href = '/Customer-SellerMajor-Search/'+'all';
                        }
                        break;
                    default:
                }
            }
        });

        function search(val, page) {
            if (val !== '') {
                $.ajax({
                    type: 'GET',
                    url: '/Customer-SellerMajor-LiveSearch/' + val + '/' + page,
                    success: function (data) {
                        $('#catList').collapse("hide");
                        $('#searchResult').empty();
                        $('#searchResult').html(data);
                    },
                })
            } else {
                $('#searchResult').empty();
            }
        }

        function checkLogin(thisElement, sellerMajorID) {
            if ($('#loginAlert').text() === 'login') {
                if (!leavePage) {
                    leavePage = true;
                    console.log('click profile')
                    thisElement.attr('href', '/Customer-SellerMajor-Panel/' + sellerMajorID);
                    thisElement.trigger('click');
                }
            } else {
                alert('ابتدا باید داخل شوید..');
                window.location.href = '/Login-Mode';
            }
        }

        // stop fancy box additional url
        if ($('.js-fancybox').length > 0) {
            $.fancybox.defaults.hash = false;

        }

        $("#postRail").on("touchmove", function (e) {
            console.log(e.originalEvent.touches.length)
            if (dragging && e.originalEvent.touches.length > 1)
                e.preventDefault();
        });

        $(document).ready(function () {
            console.log('load status:', sessionStorage.getItem("loadStatus"));
            let urlAddress = window.location.pathname, swiperItems = 0;
            if (urlAddress.indexOf("/Feed") >= 0 ||
                urlAddress === '/Customer-SellerMajor-Saved' ||
                urlAddress.indexOf('/Customer-SellerMajor-Panel') >= 0 ||
                urlAddress.indexOf('/Customer-SellerMajor-Search') >= 0) {
                if (sessionStorage.getItem("loadStatus") === null) {
                    sessionStorage.setItem("loadStatus", 'newLoad');
                }
                if (sessionStorage.getItem("loadStatus") === 'backPressed') {
                    let cacheData,cacheSampleData;
                    $.ajax({
                        type: 'GET',
                        url: '/Customer-Browser-backPressed/'+1+'/free',
                        async:false,
                        success: function (data) {
                          console.log('backPressed:',data)
                        },
                    })
                    $('#postRail').empty();
                    switch (true) {
                        case urlAddress==="/Feed":
                            cacheData = sessionStorage.getItem("feedData");
                            $(cacheData).appendTo($('#postRail'));
                            break;
                        case urlAddress==='/Customer-SellerMajor-Saved':
                            cacheData = sessionStorage.getItem("savedData");
                            cacheSampleData = sessionStorage.getItem("savedSampleData");
                            $('#postSampleContainer').empty();
                            $(cacheData).appendTo($('#postRail'));
                            $(cacheSampleData).appendTo($('#postSampleContainer'));
                            break;
                        case urlAddress.indexOf('/Customer-SellerMajor-Panel') >= 0:
                            cacheData = sessionStorage.getItem("panelData");
                            cacheSampleData = sessionStorage.getItem("panelSampleData");
                            $('#postSampleContainer').empty();
                            $(cacheData).appendTo($('#postRail'));
                            $(cacheSampleData).appendTo($('#postSampleContainer'));
                            break;
                        case urlAddress.indexOf('/Customer-SellerMajor-Search') >= 0:
                            cacheData = sessionStorage.getItem("searchData");
                            cacheSampleData = sessionStorage.getItem("searchSampleData");
                            $('#postSampleContainer').empty();
                            $(cacheData).appendTo($('#postRail'));
                            $(cacheSampleData).appendTo($('#postSampleContainer'));
                            break;
                        default:
                    }
                    swiperItems = parseInt($('#postLoaded').text());
                } else {
                    let url=urlAddress.replace(/\//g,'*');
                    console.log(urlAddress);
                    $.ajax({
                        type: 'GET',
                        url: '/Customer-Browser-backPressed/'+0+'/'+url,
                        async: false,
                        success: function (data) {
                            console.log('urlAddress:',data)
                        },
                    })
                }
                console.log('swiperItems', swiperItems)
                sessionStorage.setItem("loadStatus", 'newLoad')
            }

            setTimeout(function () {
                if (urlAddress.indexOf("/Feed") >= 0 ||
                    urlAddress === '/Customer-SellerMajor-Saved' ||
                    urlAddress.indexOf('/Customer-SellerMajor-Panel') >= 0 ||
                    urlAddress.indexOf('/Customer-SellerMajor-Search') >= 0) {
                    console.log('swiper run')
                    for (let i = 0; i < swiperItems + 6 && i < $('#postLen').text(); i++) {
                        console.log(i)
                        const swiperPost = new Swiper('#postRail .swiper' + i, {
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
            }, 1000)
        });

        function isScrolledIntoView(elem) {
            let docViewTop = $(window).scrollTop(),
                docViewBottom = docViewTop + $(window).height(),
                elemTop = $(elem).offset().top,
                elemBottom = elemTop + $(elem).height();

            return (((elemBottom - 100) <= docViewBottom) && (elemTop >= docViewTop));
        }

        window.onbeforeunload = function () {
            let urlAddress = window.location.pathname;
            sessionStorage.setItem("loadStatus", 'newLoad')
            switch (true) {
                case urlAddress==="/Feed":
                    sessionStorage.setItem("feedData", $('#postRail').html());
                    break;
                case urlAddress==='/Customer-SellerMajor-Saved':
                    sessionStorage.setItem("savedData", $('#postRail').html());
                    sessionStorage.setItem("savedSampleData", $('#postSampleContainer').html());
                    break;
                case urlAddress.indexOf('/Customer-SellerMajor-Panel') >= 0:
                    sessionStorage.setItem("panelData", $('#postRail').html());
                    sessionStorage.setItem("panelSampleData", $('#postSampleContainer').html());
                    break;
                case urlAddress.indexOf('/Customer-SellerMajor-Search') >= 0:
                    sessionStorage.setItem("searchData", $('#postRail').html());
                    sessionStorage.setItem("searchSampleData", $('#postSampleContainer').html());
                    break;
                default:
            }
        }

        if (!!window.performance && window.performance.navigation.type === 2) {
            console.log('backPressed')
            sessionStorage.setItem("loadStatus", 'backPressed');
        }

        document.addEventListener('scroll', function (event) {
            let urlAddress = window.location.pathname;
            if (urlAddress.indexOf("/Feed") >= 0 ||
                urlAddress === '/Customer-SellerMajor-Saved' ||
                urlAddress.indexOf('/Customer-SellerMajor-Panel') >= 0 ||
                urlAddress.indexOf('/Customer-SellerMajor-Search') >= 0) {
                let st = $(this).scrollTop(),
                    scrollLocation = st - lastScrollTop;
                if (scrollLocation > 30 && parseInt($('#postLen').text()) >= parseInt($('#postLoaded').text())) {
                    $('.load').removeClass('d-none');
                    if (completeLoad) {
                        if (sessionStorage.getItem("loadStatus") !== 'backPressed') {
                            console.log('run load post...')
                            loadPost();
                        }
                        completeLoad = false;
                    }
                    $('.load').addClass('d-none');
                    lastScrollTop = st;
                }
                // if ($('#loginAlert').text() === 'login' && !$('.sellerMajorPanel').length > 0) {
                //     $('[id^="detailPost"]').each(function (i) {
                //         if (isScrolledIntoView($('#detailPost-' + i))) {
                //             postID = $('#detailPost-' + i + ' .postID').text();
                //             if (tempPostID !== postID) {
                //                 $.ajax({
                //                     type: 'GET',
                //                     url: '/Customer-Post-Visit/' + postID,
                //                     success: function (data) {
                //                         console.log('postID:', postID, 'increment');
                //                     }
                //                 })
                //             }
                //         }
                //     })
                // }
                tempPostID = postID;
            }
        }, true /*Capture event*/);

        function eventShow(key) {
            // $('#circleBorder-' + key).removeClass('circleBorder');
            // $('#borderAnimate-' + key).removeClass('borderAnimate');
            $('#allEvents').modal('show');
            startSlide = key;
        }

        let swiperTemp, swiperFinished = false, startSlide,
            postID = 0, tempPostID = 0, imgRowID = [], imgRowIdTemp, lastScrollTop = 0, lastScrollTopModal = 0,
            dragging, postNumber = 0, completeLoad = true, asset = $('#asset').text(), hideTime, showTime,
            leavePage = false;

        $('#allEvents').on('shown.bs.modal', function () {
            let touchStart;
            swiperFinished = false;
            const swiper = new Swiper('#allEvents .swiper', {
                // Optional parameters
                speed: 200,
                direction: 'horizontal',
                allowTouchMove: false,
                autoplay: {
                    delay: 5000,
                    stopOnLastSlide: true,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: false,
                },
                loop: false,

                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },

                on: {
                    autoplayTimeLeft(s, time, progress) {
                        $('#progress-' + s.activeIndex).css({
                            width: 100 * (1 - progress) + '%',
                        });
                        if (swiperFinished && time < 100) {
                            $('#allEvents').modal('hide');
                        }
                    },
                }
            });
            swiperTemp = swiper;
            swiper.slideTo(startSlide, 1);
            $.ajax({
                type: 'GET',
                url: '/Customer-Event-Visit/' + $('#eventID-' + startSlide).text(),
                success: function (data) {
                    console.log('event load..')
                }
            })

            setTimeout(function () {
                $('#eventContainer').removeClass('opacity-0')
            }, 100)

            swiper.on('reachEnd', function () {
                console.log('end')
                swiperFinished = true;
            })

            swiper.on('slideChange', function () {
                $.ajax({
                    type: 'GET',
                    url: '/Customer-Event-Visit/' + $('#eventID-' + swiper.activeIndex).text(),
                    success: function (data) {
                        console.log('slide change..')
                    }
                })
                console.log(swiper.activeIndex, $("#eventCount").text())
                swiperFinished = swiper.activeIndex === parseInt($("#eventCount").text()) - 1;
            });

            swiper.on('touchStart', function () {
                touchStart = swiper.touches.startX;
                if (!$('#answer-' + swiper.activeIndex).is(':focus'))
                    swiper.autoplay.pause();
            }).on('touchEnd', function () {
                let touchEnd = swiper.touches.currentX;
                if (touchStart - touchEnd > 20) {
                    swiper.slideNext();
                    console.log('right dragged')
                }
                if (touchEnd - touchStart > 20) {
                    swiper.slidePrev();
                    console.log('left dragged')
                }
                if (!$('#answer-' + swiper.activeIndex).is(':focus'))
                    swiper.autoplay.resume();
            });
        });

        $('#allEvents').on('hide.bs.modal', function () {
            $('#eventContainer').addClass('opacity-0')
            $('#eventAnimeBorder').remove();
            swiperTemp.destroy();
            swiperFinished = false;
        });

        $(".growingToTop").on("input", function () {
            let key = $(this).attr('id').replace(/[^0-9]/gi, '');
            if ($(this).val() !== '') {
                $('#replyEventBtn-' + key).show()
            } else {
                $('#replyEventBtn-' + key).hide()
            }
            this.style.height = 0;
            this.style.height = (this.scrollHeight) + "px";
        });

        function replyEvent(eventID, key) {
            let text = $('#answer-' + key);
            $.ajax({
                type: 'GET',
                url: '/Customer-Event-Reply/' + eventID + '/' + text.val(),
                success: function (data) {
                    console.log(data)
                    text.val('');
                }
            })
        }

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
        })

        $('#postRail').on('scroll', function () {
            console.log('scroll')
            let st = $(this).scrollTop(),
                scrollLocation = st - lastScrollTopModal;
            if (scrollLocation > 150 && parseInt($('#postLen').text()) >= (parseInt($('#postLoaded').text()) + 6)) {
                $('.load').removeClass('d-none');
                if (completeLoad) {
                    if (sessionStorage.getItem("loadStatus") !== 'backPressed') {
                        console.log('run load post.....')
                        loadPost();
                    }
                    completeLoad = false;
                }
                $('.load').addClass('d-none');
                lastScrollTopModal = st;
            }
            $('[id^="detailPost"]').each(function (i) {
                if (isScrolledIntoView($('#detailPost-' + i))) {
                    postID = $('#detailPost-' + i + ' .postID').text();
                    // if (tempPostID !== postID) {
                    //     $.ajax({
                    //         type: 'GET',
                    //         url: '/Customer-Post-Visit/' + postID,
                    //         success: function (data) {
                    //             console.log('postID:', postID, 'increment');
                    //         }
                    //     })
                    // }
                }
            })
            tempPostID = postID;
        });

        $('#postRail').on('shown.bs.modal', function () {
            $(this).scrollTop($(this).scrollTop() + $('#detailPost-'+postNumber).position().top-45);
            $.ajax({
                type: 'GET',
                url: '/Customer-Post-Visit/' + $('#detailPost-' + postNumber + ' .postID').text(),
                success: function (data) {
                    console.log('postID:', postNumber, 'increment');
                }
            })
        });

        $('#postRail').on('hide.bs.modal hidden.bs.modal', function () {
            $('html').css('overflow', 'auto');
            $('.postChart').addClass('d-none');
            $('.icon-chart').addClass('fa-ellipsis-h');
            $('.icon-chart').removeClass('g-color-primary');
            $('.icon-chart').removeClass('icon-chart');
        });

        function loadPost() {
            let postSampleCopy = '.postSampleCopy', url,
                originalContainer = '#postSampleContainer';
            if (window.location.pathname.indexOf('/Customer-SellerMajor-Search/') >= 0) {
                url = '/Customer-Search-LoadPost/' + $('#postCat').text();
            } else if (window.location.pathname.indexOf('/Customer-SellerMajor-Saved') >= 0) {
                url = '/Customer-Saved-LoadPost/';
            } else if (window.location.pathname.indexOf('/Customer-SellerMajor-Panel') >= 0) {
                console.log(window.location.pathname);
                url = '/Customer-SellerMajor-Load-Post/' + $('#sellerMajorPanel').text();
            } else {
                url = '/Customer-Load-Post/';
            }
            $.ajax({
                type: 'GET',
                url: url,
                cache: true,
                success: function (data) {
                    let j = data[1];
                    console.log(data[0])
                    for (let i = 0; i < data[0].length; i++) {
                        $(postSampleCopy).attr('id', 'postSample-' + j);
                        $(postSampleCopy + ' a').attr('id', 'samplePost-' + j);
                        $(postSampleCopy + ' a').attr('onclick', 'postNumber=' + j);
                        $(postSampleCopy + ' img').attr('src', asset + data[0][i]['postPic'] + '/' + data[0][i]['postID'] + '/sample.jpg');
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

        function createDetailPost(posts, key, postHowDay, commentCount, customerProfileImg) {
            let copyContainer = '.postContainerCopy',
                postDetailContainer = '#postDetailContainer',
                detailPost = '.detailPost',
                postID = posts['postID'],
                slide, src, profileImg = '';
            // post created
            $(copyContainer + ' ' + detailPost).attr('id', 'detailPost-' + key);
            if (posts['following'] === null) {
                $(copyContainer + ' .followingBtn').attr('onclick', 'following($(this),' + posts['sellerMajorID'] + ')');
                $(copyContainer + ' .followingBtn').removeClass('d-none');
                $(copyContainer + ' .followingBtn').addClass('user-' + posts['sellerMajorID']);
            }

            $(copyContainer + ' .containerSwiper').addClass('swiper' + key);
            setTimeout(function () {
                const swiper = new Swiper('#postRail .swiper' + key, {
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
            $(copyContainer + ' .sellerMajorID').attr('id', 'sellerMajorID-' + key);
            $(copyContainer + ' .sellerMajorID').text(posts['sellerMajorID']);
            $(copyContainer + ' .postID').text(postID);
            profileImg = posts['sellerMajorPic'] == 'img/SellerMajorProfileImage/Default/icon.jpg' ? 'img/SellerMajorProfileImage/Default/icon.jpg' : posts['sellerMajorPic'] + '/profileImg.jpg';
            $(copyContainer + ' #postProfileImg').attr('src', asset + profileImg);
            $(copyContainer + ' #postProfileImg').parent().attr('onclick', 'checkLogin($(this),' + posts["sellerMajorID"] + ')');
            $(copyContainer + ' #postProfileName').text(posts['name']);
            $(copyContainer + ' .sellerMajorPanelBtn').attr('onclick', 'checkLogin($(this),' + posts["sellerMajorID"] + ')');
            $(copyContainer + ' .followingBtn').addClass('user-' + posts["sellerMajorID"] + ')');
            $(copyContainer + ' .followingBtn').addClass(posts["following"] == null ? '' : 'd-none');
            $(copyContainer + ' .followingBtn').attr('onclick', 'following($(this),' + posts["sellerMajorID"] + ')');
            $(copyContainer + ' .instagramBtn').addClass(posts["following"] == null ? 'd-none' : '');
            $(copyContainer + ' .instagramBtn').addClass('instagramLink' + posts["sellerMajorID"]);
            $(copyContainer + ' .instagramBtn a').attr('href', 'https://www.instagram.com/' + posts["Instagram"] + ')');
            $(copyContainer + ' .instagramBtn a').text(posts["Instagram"] == null ? '' : 'حساب اینستاگرام');
            $(copyContainer + ' #postImage').attr('src', asset + posts['postPic'] + '/' + postID + '.jpg');
            $(copyContainer + ' #deletePost').attr('onclick', 'deletePost(' + postID + ',' + key + ')');
            $(copyContainer + ' #likePost').attr('onclick', 'likePost($(this),' + postID + ',' + key + ',' + posts["sellerMajorID"] + ')');
            $(copyContainer + ' #likePost i').removeClass('fa');
            $(copyContainer + ' #likePost i').removeClass(' fa-heart');
            $(copyContainer + ' #likePost i').removeClass(' fa-heart-o');
            $(copyContainer + ' #likePost i').removeClass('g-color-red');
            $(copyContainer + ' #likePost i').addClass(posts['Like'] === 1 ? 'fa fa-heart g-color-red' : 'fa fa-heart-o');
            $(copyContainer + ' .likeCount small').text(posts['LikeCount'] === 0 ? '' : posts['LikeCount'] + ' پسند');
            $(copyContainer + ' #savePost').attr('onclick', 'savePost(' + postID + ',$(this))');
            $(copyContainer + ' .postMsg').attr('onclick', 'showPostMsg(' + postID + ',"' + asset + posts['postPic'] + '/' + postID + '/0.jpg","' + posts['name'] + '")');
            if (posts['save'] == null) {
                $(copyContainer + ' #savePost i').removeClass('fa-bookmark');
                $(copyContainer + ' #savePost i').addClass('fa-bookmark-o');
            } else {
                $(copyContainer + ' #savePost i').removeClass('fa-bookmark-o');
                $(copyContainer + ' #savePost i').addClass('fa-bookmark');
            }


            // comment created
            $(copyContainer + ' .accordionBtnComment').attr('href', '#accordion-04-body-' + key);
            $(copyContainer + ' .accordionBtnComment').attr('id', 'accordionBtn-' + key);
            $(copyContainer + ' .accordionBtnComment').attr('aria-controls', 'accordion-04-body-' + key);
            $(copyContainer + ' .accordionBtnComment').attr('onclick', 'addComments(' + postID + ',' + key + ',' + posts['sellerMajorID'] + ')');
            $(copyContainer + ' .postCaption #name').text(posts['name']);
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
            $(copyContainer + ' .postCaption #detail').text(posts['Text']);
            $(copyContainer + ' .commentReplyShow').addClass(commentCount !== 0 ? '' : 'd-none');
            $(copyContainer + ' #allCommentContainer').attr('onclick', "$('#accordionBtn-" + key + "').trigger('click')");
            $(copyContainer + ' .allComment').text(commentCount);
            $(copyContainer + ' .postHowDay').text(postHowDay);
            $(copyContainer + ' #accordion-04 .accBody').attr('id', 'accordion-04-body-' + key);
            $(copyContainer + ' #accordion-04 .accBody').attr('aria-labelledby', 'accordion-04-heading-' + key);
            $(copyContainer + ' .accBody .commentContainer').attr('id', 'commentContainer-' + key);
            $(copyContainer + ' .accBody .commentText').attr('id', 'comment-' + key);
            $(copyContainer + ' .accBody .commentText').attr('name', 'comment-' + key);
            $(copyContainer + ' .accBody .commentText').attr('oninput', "if($(this).val()==='') $('#sendCommentBtn-" + key + "').addClass('d-none'); else $('#sendCommentBtn-" + key + "').removeClass('d-none');");
            $(copyContainer + ' .accBody .commenterProfileImg').attr('src', customerProfileImg);
            $(copyContainer + ' .accBody .sendCommentBtn').attr('id', 'sendCommentBtn-' + key);
            $(copyContainer + ' .accBody .sendCommentBtn a').attr('onclick', "sendComment(" + postID + ",'comment-" + key + "')");


            $(copyContainer).clone().appendTo(postDetailContainer);
            $(postDetailContainer + ' .postID-').addClass('postID-' + postID);
            $(postDetailContainer + ' .postID-').removeClass('postID-');
            $(postDetailContainer + ' ' + copyContainer).removeClass('d-none postContainerCopy');
            $(copyContainer + ' .containerSwiper').removeClass('swiper' + key);
            $(copyContainer + ' .paginationSwiper').removeClass('swiper-pagination' + key);
            $(copyContainer + ' .containerSwiper .swiper-wrapper').empty();
            $(copyContainer + ' .containerSwiper .swiper-notification').remove();
            $(copyContainer + ' ' + detailPost).removeAttr('id');
            $(copyContainer + ' .commentReplyShow').removeClass('d-none');
            $(copyContainer + ' .postCaption div').addClass('d-none');
            $(copyContainer + ' .accBody .commentText').removeAttr('id');
        }

        function likePost(a, postID, key, sellerMajorID) {
            if ($('#loginAlert').text() === 'login') {
                let icon = $(a).find('.fa');
                if (icon.hasClass('fa-heart-o')) {
                    icon.removeClass('fa-heart-o');
                    icon.addClass('fa-heart');
                    icon.addClass('g-color-red');
                    $.ajax({
                        type: 'GET',
                        url: '/Customer-Like-Post/' + postID + '/' + 'like' + '/' + sellerMajorID,
                        success: function (data) {
                            console.log(data)
                            $('#detailPost-' + key + ' .likeCount').find('small').text(data + ' پسند')
                        }
                    })
                } else {
                    icon.removeClass('fa-heart');
                    icon.addClass('fa-heart-o');
                    icon.removeClass('g-color-red');
                    $.ajax({
                        type: 'GET',
                        url: '/Customer-Like-Post/' + postID + '/' + 'dislike',
                        success: function (data) {
                            console.log(data)
                            $('#detailPost-' + key + ' .likeCount').find('small').text(data + ' پسند')
                        }
                    })
                }
            } else {
                alert('ابتدا باید داخل شوید..')
                window.location.href = '/Login-Mode';
            }
        }

        function savePost(postId, thisEle) {
            if ($('#loginAlert').text() === 'login') {
                let bookmark = thisEle.find('i');
                if (bookmark.hasClass('fa-bookmark-o')) {
                    bookmark = 'save'
                } else {
                    bookmark = 'remove'
                }
                $.ajax({
                    type: 'GET',
                    url: '/Customer-Save-Post/' + postId + '/' + bookmark,
                    success: function (data) {
                        if (bookmark === 'save') {
                            thisEle.find('i').removeClass('fa-bookmark-o')
                            thisEle.find('i').addClass('fa-bookmark')
                        } else {
                            thisEle.find('i').removeClass('fa-bookmark')
                            thisEle.find('i').addClass('fa-bookmark-o')
                        }
                        console.log(data)
                    }
                })
            } else {
                alert('ابتدا باید داخل شوید..')
                window.location.href = '/Login-Mode';
            }
        }

        function isEmpty(el) {
            return !$.trim(el.html())
        }

        function addComments(postID, key, sellerMajorID) {
            if ($('#loginAlert').text() === 'login') {
                if (isEmpty($('#commentContainer-' + key))) {
                    console.log('empty');
                    $('.loadCommentWaiting').removeClass('d-none');
                    $.ajax({
                        type: 'GET',
                        url: '/Customer-AddComment/' + postID,
                        async: false,
                        success: function (data) {
                            let showReplyCommentBtn = '<div style="direction: rtl; cursor: pointer" class="countCommentReply g-pr-25"><small>...دیدن پاسخ ها...</small></div>',
                                profileImg = '';
                            for (let i = 0; i < data[0].length; i++) {
                                if (data[0][i]['Commenter'] === 'customer') {
                                    let username = data[0][i]['customerName'] !== null ? data[0][i]['customerName'] : 'کاربر' + data[0][i]['CommenterID'];
                                    $('.postCommentCopy .userInfo span').text(username);
                                    $('.postCommentCopy .userInfo img').attr('src', asset + data[0][i]['PicPath']);
                                    $('.postCommentCopy .commentReplying').attr('onclick', 'commentReplying(' + data[0][i]['commentId'] + ',"' + username + '",' + key + ')');
                                    console.log(data[0][i]['customerID'] == $('#customerId').text())
                                    if (data[0][i]['customerID'] == $('#customer_Id').text()) {
                                        $('.postCommentCopy .deleteComment').removeClass('d-none');
                                        $('.postCommentCopy .deleteComment').attr('onclick', 'deleteComment(' + data[0][i]['commentId'] + ',"comment",$(this),' + data[0][i]['PostID'] + ')');
                                    }
                                } else {
                                    profileImg = data[0][i]['Pic'] == 'img/SellerMajorProfileImage/Default/icon.jpg' ? 'img/SellerMajorProfileImage/Default/icon.jpg' : data[0][i]['Pic'] + '/profileImg.jpg';
                                    $('.postCommentCopy .userInfo span').text(data[0][i]['sellerMajorName']);
                                    $('.postCommentCopy .userInfo img').attr('src', asset + profileImg);
                                    $('.postCommentCopy .commentReplying').attr('onclick', 'commentReplying(' + data[0][i]['commentId'] + ',"' + data[0][i]['sellerMajorName'] + '",' + key + ')');
                                    $('.postCommentCopy .deleteComment').addClass('d-none');
                                }
                                $('.postCommentCopy .commentText').text(data[0][i]['CommentText']);
                                $('.postCommentCopy .commentLike').text(data[0][i]['CommentLike'] + ' پسند');
                                $('.postCommentCopy .commentLike').attr('id', 'commentLike-' + data[0][i]['commentId']);
                                $('.postCommentCopy .commentLikeIcon').attr('id', 'commentLikeIcon-' + data[0][i]['commentId']);
                                $('.postCommentCopy .commentTime').text(data[1][i]);
                                $('.postCommentCopy .commentLiking').attr('onclick', 'commentLiking(' + data[0][i]['commentId'] + ',' + data[0][i]['commentId'] + ',"comment",)');
                                $('.commentReply').attr('id', 'commentReply-' + data[0][i]['commentId']);
                                $('.postCommentCopy').removeClass('d-none');
                                $('.postCommentCopy').clone().appendTo("#commentContainer-" + key);
                                $('.postCommentCopy').attr('id', 'commentID-' + data[0][i]['commentId']);
                                $('#commentReply-' + data[0][i]['commentId']).removeClass('commentReply');
                                $('#commentContainer-' + key + ' .postCommentCopy').removeClass('postCommentCopy');
                                if (!$('.postCommentCopy .deleteComment').hasClass('d-none')) {
                                    $('.postCommentCopy .deleteComment').addClass('d-none')
                                }
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
                                        let username = data[2][j]['customerName'] !== null ? data[2][j]['customerName'] : 'کاربر' + data[2][j]['replyCustomerID'];
                                        if (data[2][j]['CommenterReply'] === 'customer') {
                                            $('.postCommentReplyCopy .userInfo span').text(username);
                                            $('.postCommentReplyCopy .userInfo img').attr('src', asset + data[2][j]['PicPath']);
                                            $('.postCommentReplyCopy .commentReplying').attr('onclick', 'commentReplying(' + data[0][i]['commentId'] + ',"' + username + '",' + key + ')');

                                            if (data[2][j]['replyCustomerID'] == $('#customer_Id').text()) {
                                                $('.postCommentReplyCopy .deleteCommentReply').removeClass('d-none');
                                                $('.postCommentReplyCopy .deleteCommentReply').attr('onclick', 'deleteComment(' + data[2][j]['commentReplyID'] + ',"commentReply",$(this),' + data[0][i]['PostID'] + ')');
                                            }
                                        } else {
                                            profileImg = data[2][j]['Pic'] == 'img/SellerMajorProfileImage/Default/icon.jpg' ? 'img/SellerMajorProfileImage/Default/icon.jpg' : data[2][j]['Pic'] + '/profileImg.jpg';
                                            $('.postCommentReplyCopy .userInfo span').text(data[2][j]['sellerMajorName']);
                                            $('.postCommentReplyCopy .userInfo img').attr('src', asset + profileImg);
                                            $('.postCommentReplyCopy .commentReplying').attr('onclick', 'commentReplying(' + data[0][i]['commentId'] + ',"' + data[0][i]['sellerMajorName'] + '",' + key + ')');
                                            $('.postCommentReplyCopy .deleteCommentReply').addClass('d-none');
                                        }
                                        $('.postCommentReplyCopy .commentText').text(data[2][j]['CommentReplyText']);
                                        $('.postCommentReplyCopy .commentLike').text(data[2][j]['CommentReplyLike'] + ' پسند');
                                        $('.postCommentReplyCopy .commentLike').attr('id', 'commentReplyLike-' + data[2][j]['commentReplyID']);
                                        $('.postCommentReplyCopy .commentLikeIcon').attr('id', 'commentReplyLikeIcon-' + data[2][j]['commentReplyID']);
                                        $('.postCommentReplyCopy .commentTime').text(data[3][j]);
                                        $('.postCommentReplyCopy .commentLiking').attr('onclick', 'commentLiking(' + data[0][i]['commentId'] + ',' + data[2][j]['commentReplyID'] + ',"reply")');
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
                                        if (!$('.postCommentReplyCopy .deleteCommentReply').hasClass('d-none')) {
                                            $('.postCommentReplyCopy .deleteCommentReply').addClass('d-none')
                                        }
                                    }
                                }
                            }
                        }
                    }).done(function () {
                        $('.postCommentReplyCopy .deleteCommentReply').removeClass('d-none');
                        $('.postCommentCopy .deleteComment').removeClass('d-none');
                        $('.loadCommentWaiting').addClass('d-none');
                    })
                    $('.postCommentCopy').addClass('d-none');
                }
                setTimeout(function () {
                    $('#comment-' + key).focus();
                }, 100)
            } else {
                alert('ابتدا باید داخل شوید..')
                window.location.href = '/Login-Mode';
            }
        }

        function sendComment(postID, textElement) {
            if ($('#loginAlert').text() === 'login') {
                let key = textElement.replace(/[^0-9]/gi, ''), allCommentCount,
                    replyID = $('#commentReplyID').text(),
                    sellerName = $('#sellerName-' + key).length > 0 ? '@' + $('#sellerName-' + key).text() + ' ' : '',
                    commentValue = sellerName + $('#' + textElement).val();

                $('#sendCommentBtn-' + key + ' i').removeClass('fa-arrow-left');
                $('#sendCommentBtn-' + key + ' i').addClass('fa-spin')
                $('#sendCommentBtn-' + key + ' i').addClass('fa-spinner')
                $.ajax({
                    type: 'GET',
                    url: '/Customer-Send-Comment/' + postID + '/' + commentValue + '/' + (replyID === '' ? 'comment' : replyID) + '/' + $('#sellerMajorID-' + key).text(),

                    success: function (data) {
                        let commentText = 'CommentText',
                            commentLike = 'CommentLike',
                            commentLikeID = 'commentLike-' + data[0]['commentId'],
                            commentLikeIcon = 'commentLikeIcon-' + data[0]['commentId'],
                            commentLiking = 'commentLiking(' + data[0]['commentId'] + ',' + data[0]['commentId'] + ',"comment")',
                            commentContainer = "#commentContainer-" + key,
                            tempCopy = '.postCommentCopy',
                            username = data[0]['name'] !== null ? data[0]['name'] : 'کاربر' + data[0]['customerID'];
                        if (replyID !== '') {
                            commentText = 'CommentReplyText';
                            commentLike = 'CommentReplyLike';
                            commentLikeID = 'commentReplyLike-' + data[0]['commentReplyId'];
                            commentLikeIcon = 'commentReplyLikeIcon-' + data[0]['commentReplyId'];
                            commentLiking = 'commentLiking(' + data[0]['commentId'] + ',' + data[0]['commentReplyId'] + ',"reply")';
                            commentContainer = "#commentReply-" + data[0]['commentId'];
                            tempCopy = '.postCommentReplyCopy';
                            console.log('postID:', data[0]['PostID']);
                            $(tempCopy).find('.deleteCommentReply').attr('onclick', 'deleteComment(' + data[0]['commentReplyId'] + ',"commentReply",$(this),' + data[0]['PostID'] + ')');
                        } else {
                            $(tempCopy + ' .commentReply').attr('id', "commentReply-" + data[0]['commentId']);
                            $(tempCopy).find('.deleteComment').attr('onclick', 'deleteComment(' + data[0]['commentId'] + ',"comment",$(this),' + data[0]['PostID'] + ')');
                        }
                        $(tempCopy + ' .userInfo span').text(username);
                        $(tempCopy + ' .userInfo img').attr('src', asset + data[0]['PicPath']);
                        $(tempCopy + ' .commentText').text(data[0][commentText]);
                        $(tempCopy + ' .commentLike').text(data[0][commentLike] + ' پسند');
                        $(tempCopy + ' .commentLike').attr('id', commentLikeID);
                        $(tempCopy + ' .commentTime').text(data[1]);
                        $(tempCopy + ' .commentLikeIcon').attr('id', commentLikeIcon);
                        $(tempCopy + ' .commentLiking').attr('onclick', commentLiking);
                        $(tempCopy + ' .commentReplying').attr('onclick', 'commentReplying(' + data[0]['commentId'] + ',"' + username + '",' + key + ')');
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
                    $('.postCommentCopy').addClass('d-none');
                })
            } else {
                alert('ابتدا باید داخل شوید..')
                window.location.href = '/Login-Mode';
            }
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
                            url: '/Customer-Comment-Delete/' + id + '/' + status,
                            success: function (data) {
                                let allCommentCount, count = 1;
                                $(thisElement).find('i').removeClass('fa fa-spin fa-spinner').addClass('icon-trash');
                                $('#commentReply-' + data[0] + ' .commentReplyDetail').each(function () {
                                    count++;
                                    console.log(count)
                                })
                                console.log(data[0])
                                allCommentCount = parseInt($('.postID-' + postID + ' .allComment').text()) - count;
                                if (data[1] === 'comment') {
                                    $('#commentID-' + data[0]).remove();
                                } else {
                                    $('#commentReplyID-' + data[0]).remove();
                                }
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
            if ($('#loginAlert').text() === 'login') {
                commenterName = '@' + commenterName + ' ';
                $('#commentReplyID').text(commentID);
                $('#comment-' + key).val(commenterName);
                $('#comment-' + key).focus();
            }
        }

        function commentLiking(id, replyID, status) {
            if ($('#loginAlert').text() === 'login') {
                let commentLike = '#commentLike-' + id,
                    commentLikeIcon = '#commentLikeIcon-' + id;
                if (status === 'reply') {
                    commentLike = '#commentReplyLike-' + replyID;
                    commentLikeIcon = '#commentReplyLikeIcon-' + replyID;
                }
                let likeStatus = 0;
                if ($(commentLikeIcon).hasClass('fa-heart')) {
                    likeStatus = 1;
                }
                $.ajax({
                    type: 'GET',
                    url: '/Customer-LikeComment/' + id + '/' + replyID + '/' + status + '/' + likeStatus,
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
            } else {
                alert('ابتدا باید داخل شوید..')
                window.location.href = '/Login-Mode';
            }
        }

        function eventLike(thisElement, eventID, sellerMajorID) {
            let icon = thisElement.find('i'), status;
            if (icon.hasClass('fa-heart-o')) {
                icon.removeClass('fa-heart-o').addClass('fa-heart g-color-red')
                status = 'like'
            } else {
                icon.removeClass('fa-heart g-color-red').addClass('fa-heart-o')
                status = 'unLike'
            }
            $.ajax({
                type: 'GET',
                url: '/Customer-Event-Like/' + eventID + '/' + status + '/' + sellerMajorID,
                success: function (data) {
                    console.log('success like!');
                }
            })
        }

        function eventSave(thisElment, eventID) {
            let icon = thisElment.find('i'), status;
            if (icon.hasClass('fa-bookmark-o')) {
                icon.removeClass('fa-bookmark-o').addClass('fa-bookmark')
                status = 'save'
            } else {
                icon.removeClass('fa-bookmark').addClass('fa-bookmark-o')
                status = 'unSave'
            }
            $.ajax({
                type: 'GET',
                url: '/Customer-Event-Save/' + eventID + '/' + status,
                success: function (data) {
                    console.log('success save!');
                }
            })
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
                            url: '/Customer-SellerMajor-Messages-Delete/' + msgDetailID,
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
                            url: '/Customer-Seller-Major-UserMessages-Delete/' + msgID,
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

        function postMsg(postId) {
            if ($('#loginAlert').text() === 'login') {
                $('#postMsgModal i').removeClass('icon-paper-plane').addClass('fa fa-spin fa-spinner');
                $.ajax({
                    type: 'GET',
                    url: '/Customer-Msg-Post/' + postId + '/' + $('#postMsgModal textarea').val(),
                    success: function (data) {
                        $('#postMsgModal i').removeClass('fa fa-spin fa-spinner').addClass('icon-paper-plane');
                        $('#postMsgModal textarea').val();
                        $('#postMsgModal').modal('hide');
                        console.log(data)
                    }
                })
            } else {
                alert('لطفا ابتدا داخل شوید..')
                window.location.href = '/Login-Mode';
            }
        }

        function showPostMsg(postId, imgSrc, name) {
            $('#postMsgModal img').attr('src', imgSrc);
            $('#postMsgModal .sendMsgBtn').attr('onclick', 'postMsg(' + postId + ')');
            $('#postMsgModal .sendMsgBtn').addClass('d-none');
            $('#postMsgModal textarea').attr('placeholder', 'پیام شما به ' + name + '..');
            $('#postMsgModal textarea').val('');
            setTimeout(function () {
                $('#postMsgModal textarea').focus();
            }, 1000)
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

        function following(thisElement, sellerMajorID) {
            if ($('#loginAlert').text() === 'login') {
                let icon = '<i class="fa fa-spin fa-spinner followWaiting"></i>';
                thisElement.text('');
                $(icon).appendTo(thisElement);
                $.ajax({
                    type: 'GET',
                    url: '/Customer-Follow-SellerMajor/' + sellerMajorID,
                    success: function (data) {
                        $(thisElement).find('i').removeClass('fa-spin fa-spinner').addClass('fa-check g-color-primary');
                        setTimeout(function () {
                            $('.user-' + sellerMajorID).remove();
                            $('.instagramLink' + sellerMajorID).removeClass('d-none');
                        }, 1000);
                        console.log(data);
                    }
                })
            } else {
                alert('ابتدا باید داخل شوید..');
                window.location.href = '/Login-Mode';
            }
        }

        function panelFollowing(thisElement, sellerMajorID) {
            $.ajax({
                type: 'GET',
                url: '/Customer-Follow-SellerMajor/' + sellerMajorID,
                beforeSend: function () {
                    let icon = '<i class="fa fa-spin fa-spinner followWaiting"></i>';
                    thisElement.find('span').text('');
                    thisElement.find('i').removeClass('d-none').addClass('fa-spin fa-spinner');
                    $(icon).appendTo(thisElement);
                },
                success: function (data) {
                    $(thisElement).find('i').removeClass('fa-spin fa-spinner').addClass('fa-check g-color-primary');
                    setTimeout(function () {
                        $(thisElement).find('i').remove();
                        thisElement.find('span').text('دنبال کردن');
                        $(thisElement).addClass('d-none');
                        $('#unFollowingBtn').removeClass('d-none');
                    }, 1000);
                    console.log(data);
                }
            })
        }

        function deleteFollowing(id, thisElement) {
            $(thisElement).find('i').removeClass('icon-user-unfollow').addClass('fa fa-spin fa-spinner');
            $.confirm({
                title: 'لغو دنبال کردن',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        $.ajax({
                            type: 'GET',
                            url: '/Customer-Following-Delete/' + id,
                            success: function (data) {
                                $('#sellerMajor-' + id).remove();
                            }
                        })
                    },
                    انصراف: function () {
                        $(thisElement).find('i').removeClass('fa fa-spin fa-spinner').addClass('icon-user-unfollow');
                    },
                }
            });
        }

        function panelDeleteFollowing(id, thisElement) {
            $.confirm({
                title: 'لغو دنبال کردن',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        $.ajax({
                            type: 'GET',
                            url: '/Customer-Following-Delete/' + id,
                            beforeSend: function () {
                                let icon = '<i class="fa fa-spin fa-spinner followWaiting"></i>';
                                thisElement.find('span').text('');
                                thisElement.find('i').removeClass('d-none').addClass('fa-spin fa-spinner');
                                $(icon).appendTo(thisElement);
                            },
                            success: function (data) {
                                $(thisElement).find('i').removeClass('fa-spin fa-spinner').addClass('fa-check g-color-primary');
                                setTimeout(function () {
                                    $(thisElement).find('i').remove();
                                    thisElement.find('span').text('لغو دنبال کردن');
                                    $(thisElement).addClass('d-none');
                                    $('#followingBtn').removeClass('d-none');
                                }, 1000);
                            }
                        })
                    },
                    انصراف: function () {
                    },
                }
            });
        }
    </script>
@endsection
