@section('SellerMajorJsFunction')
    <script>
        $(document).ready(function () {
            $('.js-go-to').remove();
        });

        function eventShow(userID) {
            $('#allEvents').modal('show');
        }

        let swiperTemp, swiperFinished = false, startSlide = 0;

        $('#allEvents').on('shown.bs.modal', function () {
            let touchStart;
            swiperFinished = false;
            const swiper = new Swiper('.swiper', {
                // Optional parameters
                speed: 200,
                direction: 'horizontal',
                allowTouchMove: false,
                autoplay: {
                    delay: 5000,
                    stopOnLastSlide: true,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
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

            if(startSlide>0){
                $('#progress-0').css('width', '100%')
            }

            if(startSlide === parseInt($("#eventCount").text()) - 1){
                swiperFinished = true;
            }

            $('#eventContainer').removeClass('opacity-0')

            swiper.on('reachEnd', function () {
                console.log('end')
                swiperFinished = true;
            })

            swiper.on('slideChange', function () {
                $('#progress-' + swiper.previousIndex).css({
                    width: '100%',
                });

                if (swiper.activeIndex === parseInt($("#eventCount").text()) - 1)
                    swiperFinished = true;
            });

            swiper.on('touchStart', function () {
                touchStart=swiper.touches.startX;
                swiper.autoplay.pause();
                console.log('pause','x',touchStart)
            }).on('touchEnd', function () {
                let touchEnd=swiper.touches.currentX;
                if(touchStart-touchEnd>100)
                    console.log('right dragged')
                if(touchEnd-touchStart>100)
                    console.log('left dragged')
                swiper.autoplay.resume();
            });
        });

        $('#allEvents').on('hide.bs.modal', function () {
            for (let i = 0; i <= swiperTemp.activeIndex; i++) {
                $('#progress-' + i).css('width', '100%')
                $('#progress-' + i).removeClass('slide-width-0');
            }
            if (swiperTemp.activeIndex < parseInt($("#eventCount").text()) - 1){
                startSlide=swiperTemp.activeIndex+1;
            } else {
                startSlide=0;
            }
            $('#eventContainer').addClass('opacity-0')
            swiperTemp.destroy();
        });

        // برای قسمت کاستومر لازم است
        $(".growingToTop").on("input", function () {
            this.style.height = 0;
            this.style.height = (this.scrollHeight) + "px";
        });

        function isEmpty(el) {
            return !$.trim(el.html())
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
    </script>
@endsection
