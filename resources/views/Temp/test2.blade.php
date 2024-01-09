// owl.carousel document
// owl.on('changed.owl.carousel', function(e) {
//     console.log('start')
// });
// owl.on('initialize.owl.carousel initialized.owl.carousel ' +
//     'initialize.owl.carousel initialize.owl.carousel ' +
//     'resize.owl.carousel resized.owl.carousel ' +
//     'refresh.owl.carousel refreshed.owl.carousel ' +
//     'update.owl.carousel updated.owl.carousel ' +
//     'drag.owl.carousel dragged.owl.carousel ' +
//     'translate.owl.carousel translated.owl.carousel ' +
//     'to.owl.carousel changed.owl.carousel', function(e) {
//     console.log(e.type)
// });


@section('SellerMajorJsFunction')
    <script>
        $('.modal').on('shown.bs.modal', function () {
            $(this).find('[autofocus]').focus();
        });
        $(document).ready(function () {
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
                        $('#imageUrl').val(reader.result);
                        $('#profileImgBox').attr('src', url);
                        $modal.modal('hide');
                        $("#imageUrl").clone().appendTo("#imageUploadForm");
                        $('#imageUploadForm').submit();
                    };
                });
            });

            $('#imageUploadForm').on('submit', (function (e) {
                $('#profileImgSubmitIcon').addClass('d-none');
                $('#waitingCrop').removeClass('d-none');
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $('#profileImgSubmitIcon').removeClass('d-none');
                        $('#waitingCrop').addClass('d-none');
                    }
                })
            }));

            $('.nowDate').text(nowDate());
        });

        $(document).ready(function () {
            let $eventModal = $('#eventModal'),
                eventImage = document.getElementById('event_sample_image'),
                eventCropper;
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
                }
            });

            $eventModal.on('shown.bs.modal', function () {
                eventCropper = new Cropper(eventImage, {
                    aspectRatio: 8 / 16,
                    viewMode: 1,
                    zoomable: true,
                    background: true,
                    minCropBoxWidth: 960,
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
                    width: 960,
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
                });
            });

            $('#eventUploadForm').on('submit', (function (e) {
                $('#eventSubmitIcon').addClass('d-none');
                $('#waitingEventCrop').removeClass('d-none');
                $('#eventText').val($('#eventTextTemp').val());
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $('#eventSubmitIcon').removeClass('d-none');
                        $('#waitingEventCrop').addClass('d-none');
                    }
                })
            }));
        });

        $('#allEvents').on('shown.bs.modal', function () {
            let owl = $('.owl-carousel'),
                restart = 5000,
                items = $('.item').length,
                width = 100 / items,
                block = false,
                currentTime = 0;
            $('.owlDots').attr('style', 'width:' + width + '%');

            owl.on('initialized.owl.carousel translated.owl.carousel', function (e) {
                startProgressBar(e.item.index,restart);
            });

            owl.on('translate.owl.carousel', function (e) {
                resetProgressBar(e.item.index);
            });

            owl.on('drag.owl.carousel', function (e) {
                console.log('drag: '+e.item.index);
                $('.slide-'+e.item.index).attr('style','width:100% !important;');
            });

            startProgressBar(0,restart);
            owl.trigger('play.owl.autoplay', [restart]);
            owl.owlCarousel({
                loop: false,
                autoplay: true,
                autoplayTimeout: restart,
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
                    index=carousel.relative($(this).index()),
                    slide=$('.slide-'+index),
                    slideWidth=100;

                if (!block) {
                    block = true;
                    // slide.attr('style','transition :width 0ms linear !important; width:'+slideWidth+'% !important;');

                    slide.animate({
                        width: slideWidth
                    }, {
                        duration: restart,
                        step: function (now, fx) {
                            currentTime = Math.round((now * restart) / slideWidth);
                            console.log('current time: ',currentTime,'now: ',now)
                        },
                        easing: 'linear'
                    });
                    slide.stop();
                    owl.trigger('stop.owl.autoplay');
                    block = false;
                }
            }).bind('touchend mouseup', function (e) {
                let carousel = $('.owl-carousel').data('owl.carousel'),
                    index=carousel.relative($(this).index());
                if (!block) {
                    block = true;
                    $('.slide-'+index).attr('style','transition :width '+restart+ 'ms linear !important; width: 100% !important;');
                    owl.trigger('play.owl.autoplay', [restart]);
                    block = false;
                }
            });
        });

        $(document).on('click', '.owl-stage-outer', function (e) {
            $(".owl-carousel").trigger('next.owl.carousel');
        });

        $('.owl-carousel').on('click', '.owl-item', function(e) {
            let carousel = $('.owl-carousel').data('owl.carousel'),
                index=carousel.relative($(this).index());
            $('.slide-'+index).attr('style','width:100% !important;');
            console.log('clicked',index);
        });

        function startProgressBar(index,time) {
            console.log('start: ',index);
            $('#dot-'+index).removeClass('d-none');
            // apply keyframe animation
            $('.slide-'+index).css({
                width: "100%",
                transition: 'width '+time+ 'ms linear'
            });
        }

        function resetProgressBar(index) {
            console.log('end: ',index);
            $('.slide-'+index).css({
                width: 0,
                transition: "width 0s"
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




@extends('Layouts.IndexSellerMajor')
@section('Content')
    <span id="eventLen" class="d-none">{{count($events)}}</span>
    <section class="g-mb-100 g-brd-top--lg g-brd-gray-light-v4 g-pt-20--lg g-pt-0">
        <!--Bio-->
        <div class="container">
            <div style="direction: rtl" class="row">
                <div class="col-lg-4 g-mb-0">
                    <!-- User Details -->
                    <div class="smallDevice d-flex align-items-center justify-content-between g-mb-5">
                        <h4 class="g-font-weight-500 g-ml-10 g-mb-0">
                            {{$data->name}}
                            <span class="u-label g-mb-0 g-color-gray-dark-v3" title="پست ها">
                              <i class="icon-layers g-mr-3"></i> 14
                             </span>
                            <span class="u-label g-mb-0 g-color-gray-dark-v3" title="دنبال کنندگان">
                                  <i class="icon-people g-mr-3"></i> 22
                             </span>
                        </h4>

                        <ul style="direction: ltr" class="list-inline mb-0">
                            <li class="list-inline-item g-mx-2">
                                <a class="u-icon-v1 u-icon-size--sm u-icon-slide-up--hover g-color-gray-light-v1 g-bg-gray-light-v5 g-color-gray-light-v1--hover rounded-circle"
                                   data-toggle="modal"
                                   data-target="#instagramModal"
                                   onclick="$('#instagram').val('')"
                                   href="#!">
                                    <i class="g-line-height-1 u-icon__elem-regular fa fa-instagram g-font-size-16"></i>
                                    <i class="g-line-height-0_8 u-icon__elem-hover fa fa-instagram g-font-size-16"></i>
                                </a>
                                <!--modalInstagram-->
                                <div style="direction: rtl" class="modal fade text-center" id="instagramModal" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header g-pr-20 g-pl-20">
                                                <h5 class="m-0">آدرس اکانت اینستاگرام</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fa fa-close g-font-size-16"></i>
                                                </button>
                                            </div>
                                            <div style="direction: rtl" class="modal-body mx-3 text-right">
                                                <div style="direction: ltr" class="form-group row g-mb-25">
                                                    <div class="input-group justify-content-center">
                                                        <div class="col-lg-10">
                                                            <h6 class="d-flex justify-content-between"><span id="instagramLink" class="g-ml-5 g-color-gray-light-v1">{{$data->Instagram !== '' ? $data->Instagram : 'خالی'}}</span><span>آدرس فعلی</span></h6>
                                                            <div class="input-group">
                                                               <textarea id="instagram"
                                                                         autofocus
                                                                         class="form-control form-control-md g-resize-none g-brd-0 rounded-0 pl-0 g-bg-transparent"
                                                                         maxlength="300" rows="4" placeholder="آدرس جدید.."></textarea>
                                                            </div>
                                                            <div class="text-left">
                                                                <a href="#" onclick="socialAddressUpdate('instagram')" class="g-text-underline--none--hover g-color-gray-dark-v3 g-color-primary--hover">
                                                                <span class="u-icon-v3 u-icon-size--sm g-mr-15 g-mb-15 g-rounded-50x">
                                                                    <i id="instagramUpdateIcon" class="fa fa-check u-line-icon-pro"></i>
                                                                    <i id="instagramUpdateWaiting"
                                                                       class="d-none fa fa-spinner fa-spin g-line-height-0 align-middle"></i>
                                                                </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item g-mx-2">
                            </li>
                        </ul>
                    </div>
                    <!-- End User Details -->
                    <!-- User Image -->
                    <div class="g-mb-5">
                        <div class="u-block-hover g-pos-rel">
                            <figure>
                                <img id="profileImgBox" class="img-fluid w-100 u-block-hover__main--zoom-v1"
                                     src="{{$data->Pic!=''?$data->Pic.'/profileImg.jpg':'/img/SellerMajorProfileImage/Default/icon.jpg'}}" alt="Image Description">
                            </figure>

                            <!-- Figure Caption -->
                            <figcaption class="u-block-hover__additional--fade g-bg-black-opacity-0_5 g-pa-30">
                                <div
                                    class="u-block-hover__additional--fade u-block-hover__additional--fade-up g-flex-middle">
                                    <!-- Figure Social Icons -->
                                    <ul class="list-inline text-center g-flex-middle-item--bottom g-mb-20 p-0">
                                        <li class="list-inline-item align-middle g-mx-7">
                                            <a onclick="$('#profileImg').trigger('click')" class="u-icon-v1 u-icon-size--md g-color-white" href="#!">
                                                <i class="icon-camera u-line-icon-pro"></i>
                                            </a>

                                            <div style="display: none">
                                                <input id="profileImg"
                                                       value=""
                                                       type="file"
                                                       name="profileImg"
                                                       accept="image/*">
                                                <input style="display: none" type="text" id="imageUrl" name="imageUrl">
                                            </div>

                                            <form action="{{route('sellerMajorEditProfileImg')}}" id="imageUploadForm"
                                                  method="post" enctype="multipart/form-data">
                                                @csrf
                                            </form>
                                        </li>

                                        <li class="list-inline-item align-middle g-mx-7">
                                            <a onclick="$('#eventImg').trigger('click')"
                                               class="u-icon-v1 u-icon-size--md g-color-white" href="#!">
                                                <i class="icon-plus u-line-icon-pro"></i>
                                            </a>

                                            <div style="display: none">
                                                <input id="eventImg"
                                                       value=""
                                                       type="file"
                                                       name="eventImg"
                                                       accept="image/*">
                                                <input style="display: none" type="text" id="eventImageUrl" name="eventImageUrl">
                                            </div>

                                            <form action="{{route('sellerMajorAddEvent')}}" id="eventUploadForm"
                                                  method="post" enctype="multipart/form-data">
                                                @csrf
                                                <textarea id="eventText"
                                                          name="eventText"
                                                          autofocus
                                                          class="d-none"
                                                          maxlength="300" rows="4" placeholder="متن.."></textarea>
                                            </form>
                                        </li>

                                        <li class="list-inline-item align-middle g-mx-7">
                                            <a class="u-icon-v1 u-icon-size--md g-color-white"
                                               data-toggle="modal"
                                               data-target="#allEvents"
                                               href="#!">
                                                <i class="icon-event u-line-icon-pro"></i>
                                            </a>
                                        </li>

                                        <li class="list-inline-item align-middle g-mx-7">
                                            <a class="u-icon-v1 u-icon-size--md g-color-white" href="#" onclick="removeProfileImg()">
                                                <i class="icon-trash u-line-icon-pro"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- End Figure Social Icons -->
                                </div>
                            </figcaption>
                            <!-- End Figure Caption -->
                        </div>
                    </div>
                    <!-- User Image -->
                    <a style="border-radius: 0" class="btn btn-block u-btn-darkgray g-py-12 g-mb-20" href="#!">
                        <i class="icon-user-follow g-pos-rel g-top-1 g-ml-5"></i> دنبالم کن
                    </a>
                    <!-- End User Contact Buttons -->
                </div>

                <div class="col-lg-8">
                    <!-- User Details -->
                    <div class="bigDevice d-flex align-items-center justify-content-between g-mb-5">
                        <h4 class="g-font-weight-500 g-ml-10 g-mb-0">
                            {{$data->name}}
                            <span class="u-label g-mb-0 g-color-gray-dark-v3" title="پست ها">
                              <i class="icon-layers g-mr-3"></i> 14
                             </span>
                            <span class="u-label g-mb-0 g-color-gray-dark-v3" title="دنبال کنندگان">
                                  <i class="icon-people g-mr-3"></i> 22
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
                                <div style="direction: rtl" class="modal fade text-center" id="instagramModal" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header g-pr-20 g-pl-20">
                                                <h5 class="m-0">آدرس اکانت اینستاگرام</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fa fa-close g-font-size-16"></i>
                                                </button>
                                            </div>
                                            <div style="direction: rtl" class="modal-body mx-3 text-right">
                                                <div style="direction: ltr" class="form-group row g-mb-25">
                                                    <div class="input-group justify-content-center">
                                                        <div class="col-lg-10">
                                                            <h6 class="d-flex justify-content-between"><span id="instagramLink" class="g-ml-5 g-color-gray-light-v1">{{$data->Instagram !== '' ? $data->Instagram : 'خالی'}}</span><span>آدرس فعلی</span></h6>
                                                            <div class="input-group">
                                                               <textarea id="instagram"
                                                                         autofocus
                                                                         class="form-control form-control-md g-resize-none g-brd-0 rounded-0 pl-0 g-bg-transparent"
                                                                         maxlength="300" rows="4" placeholder="آدرس جدید.."></textarea>
                                                            </div>
                                                            <div class="text-left">
                                                                <a href="#" onclick="socialAddressUpdate('instagram')" class="g-text-underline--none--hover g-color-gray-dark-v3 g-color-primary--hover">
                                                                <span class="u-icon-v3 u-icon-size--sm g-mr-15 g-mb-15 g-rounded-50x">
                                                                    <i id="instagramUpdateIcon" class="fa fa-check u-line-icon-pro"></i>
                                                                    <i id="instagramUpdateWaiting"
                                                                       class="d-none fa fa-spinner fa-spin g-line-height-0 align-middle"></i>
                                                                </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item g-mx-2">
                            </li>
                        </ul>
                    </div>
                    <!-- End User Details -->

                    <!-- User Position -->
                    <h4 class="h6 g-font-weight-300 g-mb-10">
                        <i class="icon-badge g-pos-rel g-top-1 g-ml-5 g-color-gray-dark-v5"></i> {{$data->HintCategory}}
                    </h4>
                    <!-- End User Position -->

                    <!-- User Info -->
                    <ul class="list-inline g-font-weight-300 g-pl-40 g-pr-0">
                        <li class="list-inline-item g-ml-20 g-mr-0">
                            <i class="icon-check g-pos-rel g-top-1 g-color-gray-dark-v5 g-ml-5"></i> اعتبارسنجی
                        </li>
                        <li class="list-inline-item g-ml-20">
                            <a class="g-text-underline--none--hover"
                               data-toggle="modal"
                               data-target="#modalAddress"
                               href="#">
                                <i class="icon-location-pin g-color-gray-dark-v5 g-pos-rel g-top-1 g-ml-5"></i><span id="addressLink">{{$data->Address !=='' ? $data->Address:'آدرس'}}</span>
                            </a>
                            <!--address modal-->
                            <div class="modal fade text-center" id="modalAddress" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header g-pr-20 g-pl-20">
                                            <h5 class="m-0">آدرس محل شما</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-close g-font-size-16"></i>
                                            </button>
                                        </div>
                                        <div style="direction: rtl" class="modal-body mx-3 text-right">
                                            <div style="direction: ltr" class="form-group row g-mb-25">
                                                <div class="input-group justify-content-center">
                                                    <div class="col-lg-10">
                                                        <div class="input-group">
                                                               <textarea style="direction: rtl" id="address"
                                                                         autofocus
                                                                         class="form-control form-control-md g-resize-none g-brd-0 rounded-0 pl-0 g-bg-transparent"
                                                                         maxlength="300" rows="4" placeholder="آدرس جدید.."></textarea>
                                                        </div>
                                                        <div class="text-left">
                                                            <a href="#" onclick="addressUpdate()" class="g-text-underline--none--hover g-color-gray-dark-v3 g-color-primary--hover">
                                                                <span class="u-icon-v3 u-icon-size--sm g-mr-15 g-mb-15 g-rounded-50x">
                                                                    <i id="addressUpdateIcon" class="fa fa-check u-line-icon-pro"></i>
                                                                    <i id="waitingAddressUpdate"
                                                                       class="d-none fa fa-spinner fa-spin g-line-height-0 align-middle"></i>
                                                                </span>
                                                            </a>
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
                    <!-- End User Skills -->
                    <!-- bio -->
                    <div class="g-mb-10 g-mb-0--lg">
                        <div class="form-group g-mb-20">
                            <div class="input-group g-brd-primary--focus g-mb-10">
                            <textarea id="bioText"
                                      onfocus="if($('#edited').text()==='0'){$('#bioTextCopy').val($(this).val()); $('#edited').text('1')}"
                                      class="form-control form-control-md g-resize-none g-brd-0 rounded-0 g-px-5 g-pt-0 g-color-gray-dark-v4 g-bg-transparent"
                                      maxlength="300" rows="4" placeholder="بایوگرافی.."
                                      readonly>{{$data->Bio}}</textarea>
                                <textarea id="bioTextCopy" onfocus="" class="d-none" maxlength="300" rows="4"></textarea>
                                <span class="d-none" id="edited">0</span>
                            </div>
                        </div>

                        <div id="bioSubmit" class="d-none text-left">
                            <label class="u-check g-mr-15 mb-0"
                                   onclick="$('#bioSubmit').addClass('d-none'); $('#bioText').prop('readonly','readonly'); $('#bioEdit').removeClass('d-none'); $('#bioText').val($('#bioTextCopy').val())">
                                <div
                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-lightred--hover">
                                    <i class="fa fa-close g-absolute-centered"></i>
                                </div>
                            </label>
                            <label class="u-check g-mr-15 mb-0"
                                   onclick="updateBio()">
                                <div
                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-primary--hover">
                                    <i id="bioEditIcon" class="fa fa-check g-absolute-centered"></i>
                                    <i style="margin: -7px" id="waitingBioUpdate"
                                       class="d-none fa fa-spinner fa-spin g-absolute-centered g-color-gray-dark-v3"></i>
                                </div>
                            </label>
                        </div>

                        <div id="bioEdit" class="text-left">
                            <label class="u-check g-mr-15 mb-0"
                                   onclick="$('#bioText').removeAttr('readonly'); $('#bioText').focus(); $('#bioEdit').addClass('d-none'); $('#bioSubmit').removeClass('d-none');">
                                <div
                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-primary--hover">
                                    <i class="fa fa-edit g-absolute-centered g-font-size-16"></i>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <hr class="{{isset($posts[0])?'':'d-none'}} g-brd-gray-light-v3 g-mt-0 g-mb-5">

        <!--Post-->
        <div class="container g-px-15--lg g-px-0">
            <div class="row g-mx-1">
                @foreach($posts as $key => $rec)
                    <div class="col-lg-2 col-4 g-brd-around g-brd-white p-0">
                        <a class="d-block u-block-hover u-bg-overlay g-bg-black-opacity-0_3--after g-bg-transparent--hover--after"
                           href="#">
                            <img class="img-fluid u-block-hover__main--zoom-v1" src="{{$rec->Pic.'/'.$rec->postID.'-sample.jpg'}}"
                                 alt="Image Description">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{--مودال ساخت رویدادها--}}
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
                                     class="form-control form-control-md g-resize-none g-brd-0 rounded-0 pl-0 g-bg-transparent"
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

        {{--مودال تصاویر--}}
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

        {{--مودال همه رویدادها--}}
        <div style="padding: 0 !important; overflow: hidden" class="modal fade bd-example-modal-lg" id="allEvents"
             tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
                <div style="height: 1000px;" class="modal-content">
                    <div>
                        <div class="home-demo p-0">
                            <div>
                                <div class="large-12 columns p-0">
                                    <div style="float: none; margin: auto; position: relative" class="owl-demo g-width-350--lg">
                                        <div id="leftSlide" style="position: absolute; height: 70%; width: 25%; top: 15%; left: 0; z-index: 9999"></div>
                                        <div id="rightSlide" style="position: absolute; height: 70%; width: 25%; top: 15%; right: 0; z-index: 9999"></div>
                                        <!--owl dots-->
                                        <div class="d-flex owlContainer">
                                            @foreach($events as $key => $row)
                                                <div id="dot-{{$key}}" class="owlDots {{$key ==0?'g-ml-0':'g-ml-2'}}">
                                                    <div class="slide-progress-main">
                                                        <div class="slide-progress {{$key == 0 ?'slide-width-0 slide-0':'slide-width-100 otherTimeBar slide-'.$key}}"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!--owl items-->
                                        <div class="owl-carousel owl-theme">
                                            @foreach($events as $key => $row)
                                                <div style="position: relative" id="item-{{$key}}" class="item">
                                                    <div style="position: relative; background-image: url({{asset($row->Pic.'/'.$row->eventID.'.jpg')}});
                                                        background-position: center;
                                                        background-size: cover;
                                                        background-repeat: no-repeat;
                                                        background-color: #3a3f50;
                                                        top: 0;
                                                        left: 0;
                                                        height: 100vh;"
                                                         class="eventContainer vw-100">
                                                        <div style="position: absolute; bottom: 0;" class="w-100 g-pa-20">
                                                            <div class="text-center">
                                                                <h5 style="direction: rtl; border-radius: 20px 20px 0 0" class="{{$row->Text=='' ? 'd-none ':''}}g-color-white text-center g-bg-black-opacity-0_7 g-pa-20">{{$row->Text}}</h5>
                                                                <div class="g-color-white text-left g-bg-black-opacity-0_7 g-py-5 g-px-5">
                                                                    <div class="d-flex justify-content-between">
                                                                     <span class="u-label g-mb-0 g-color-white g-font-size-15 g-font-weight-500 align-self-center g-line-height-0" title="مشاهده شده">
                                                                          <i class="icon-eye g-mr-3"></i>
                                                                         <span class="align-middle">{{$row->Count===null?'0':$row->Count}}</span>
                                                                     </span>
                                                                        <a class="u-icon-v1 u-icon-size--md g-color-white" href="#!" onclick="removeEvent({{$row->ID}})">
                                                                            <i class="icon-trash u-line-icon-pro"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="direction: ltr; border: 0 !important; position: absolute; top:20px; left: 10px; z-index: 9999">
                                                        <button style="outline: 0; cursor:pointer;" type="button" id="closeEventModal"
                                                                class="g-brd-none g-mt-5 g-pa-10 g-bg-transparent g-font-size-20 g-line-height-0 align-self-center"
                                                                data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span class="g-font-size-30 g-color-white g-font-weight-600" aria-hidden="true">&times;</span>
                                                        </button>
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

        {{--مودال ریل پست ها--}}
        <div style="padding: 0 !important; overflow: hidden" class="modal fade bd-example-modal-lg" id="postRail"
             tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
                <div style="height: 1000px;" class="modal-content">
                    <div>
                        <div class="home-demo p-0">
                            <div>
                                <div class="large-12 columns p-0">
                                    <div style="float: none; margin: auto; position: relative" class="owl-demo g-width-350--lg">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
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
            let link=$('#'+app).val().replace(/\//g, '88888888888888888888888'),
                url='/Seller-Major-'+app+'Update/' + link;
            console.log(url);
            $('#'+app+'UpdateIcon').addClass('d-none');
            $('#'+app+'UpdateWaiting').removeClass('d-none');
            $.ajax({
                type: 'GET',
                async: false,
                url: url,
                success: function (data) {
                    $('#'+app+'Modal').modal('toggle');
                    $('#'+app+'Link').text(data);
                    $('#'+app+'UpdateIcon').removeClass('d-none');
                    $('#'+app+'UpdateWaiting').addClass('d-none');
                    console.log(data);
                }
            });
        }
    </script>
@endsection




{{--تغییرات قدیم--}}
@section('SellerMajorJsFunction')
    <script>
        let imgRowID=[],imgRowIdTemp;

        $('.modal').on('shown.bs.modal', function () {
            $(this).find('[autofocus]').focus();
        });

        // تنظیم تصویر پروفایل
        $(document).ready(function () {
            $('[id^="eventBackground-"]').each(function (i, obj) {
                imgRowIdTemp=$(this).attr('id').split('-');
                imgRowID[i]=imgRowIdTemp[2];
            });
            //چک کردن ابعاد تصویر
            let windowWidth = $(window).width(),
                windowHeight = $(window).height();
            switch (true) {
                case (windowWidth>1000):
                    $('.eventContainer').css('width','auto !important')
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
                        $('#imageUrl').val(reader.result);
                        $('#profileImgBox').attr('src', url);
                        $modal.modal('hide');
                        $("#imageUrl").clone().appendTo("#imageUploadForm");
                        $('#imageUploadForm').submit();
                    };
                });
            });

            $('#imageUploadForm').on('submit', (function (e) {
                $('#profileImgSubmitIcon').addClass('d-none');
                $('#waitingCrop').removeClass('d-none');
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $('#profileImgSubmitIcon').removeClass('d-none');
                        $('#waitingCrop').addClass('d-none');
                    }
                })
            }));

            $('.nowDate').text(nowDate());
        });

        // افزودن رویداد
        $(document).ready(function () {
            let $eventModal = $('#eventModal'),
                eventImage = document.getElementById('event_sample_image'),
                eventCropper;
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
                }
            });

            $eventModal.on('shown.bs.modal', function () {
                eventCropper = new Cropper(eventImage, {
                    aspectRatio: 8 / 16,
                    viewMode: 1,
                    zoomable: true,
                    background: true,
                    minCropBoxWidth: 960,
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
                    width: 960,
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
                });
            });

            $('#eventUploadForm').on('submit', (function (e) {
                $('#eventSubmitIcon').addClass('d-none');
                $('#waitingEventCrop').removeClass('d-none');
                $('#eventText').val($('#eventTextTemp').val());
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $('#eventSubmitIcon').removeClass('d-none');
                        $('#waitingEventCrop').addClass('d-none');
                        window.location.href = "/Seller-Major-Panel";
                    }
                })
            }));
        });

        // افزودن پست
        $(document).ready(function () {
            let $postModal = $('#postModal'),
                postImage = document.getElementById('post_sample_image'),
                postCropper;
            $('#postImg').on('change', function (event) {
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
                }
            });

            $postModal.on('shown.bs.modal', function () {
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
                    movable: true
                    // preview: '.preview'
                });
            });

            $postModal.on('hidden.bs.modal', function () {
                postCropper.destroy();
                postCropper = null;
            });

            $('#postCrop').on('click', function () {
                let canvas = postCropper.getCroppedCanvas({
                    width: 1400,
                    height: 1750
                });

                canvas.toBlob(function (blob) {
                    let url = URL.createObjectURL(blob),
                        reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        $('#postImageUrl').val(reader.result);
                        // $('#profileImgBox').attr('src', url);
                        $postModal.modal('hide');
                        $("#postImageUrl").clone().appendTo("#postUploadForm");
                        $('#postUploadForm').submit();
                    };
                });
            });

            $('#postUploadForm').on('submit', (function (e) {
                $('#postSubmitIcon').addClass('d-none');
                $('#waitingPostCrop').removeClass('d-none');
                $('#postText').val($('#postTextTemp').val());
                // e.preventDefault();
                // let formData = new FormData(this);
                // $.ajax({
                //     type: 'POST',
                //     url: $(this).attr('action'),
                //     data: formData,
                //     cache: false,
                //     contentType: false,
                //     processData: false,
                //     success: function (data) {
                //         console.log(data);
                //         $('#postSubmitIcon').removeClass('d-none');
                //         $('#waitingPostCrop').addClass('d-none');
                //         window.location.href = "/Seller-Major-Panel";
                //     }
                // })
            }));
        });

        $('#allEvents').on('hide.bs.modal hidden.bs.modal', function () {
            let owl = $('.owl-carousel');
            owl.owlCarousel('destroy');
            window.clearTimeout(mouseUpTimer);
            window.clearTimeout(lastSlideTimer);
            $('.slide-0').attr('style','width:0 !important;');
            $('.otherTimeBar').attr('style','width:100% !important;');
        });

        let mouseUpTimer,lastSlideTimer;
        $('#allEvents').on('shown.bs.modal', function () {
            let owl = $('.owl-carousel'),
                restart = 5000,
                items = $('.item').length,
                width = 100 / items,
                block = false,
                currentTime = 0,
                userID=$('#userID').text(),
                remaining=restart;
            $('.owlDots').attr('style', 'width:' + width + '%');

            owl.on('initialized.owl.carousel translated.owl.carousel', function (e) {
                startProgressBar(e.item.index,restart);
            });

            owl.on('translate.owl.carousel', function (e) {
                let index=e.item.index;
                $('#eventBackground-'+index+'-'+imgRowID[index]).css('background-image','url(http://127.0.0.1:8000/img/SellerMajor/Events/'+userID+'/'+imgRowID[index]+'.jpg)');
                owl.trigger('stop.owl.autoplay');
                owl.trigger('play.owl.autoplay', [restart]);
                resetProgressBar(index);
            });


            owl.on('drag.owl.carousel', function (e) {
                console.log('drag: '+e.item.index);
                $('.slide-'+e.item.index).attr('style','width:100% !important;');
            });

            $(".owl-carousel").on('translated.owl.carousel', function (e) {
                if (!e.namespace) return;
                let carousel = e.relatedTarget,
                    current = carousel.current()+1;
                if (current == $('#eventLen').text()) {
                    lastSlideTimer=setTimeout(function () {
                        $('#closeEventModal').trigger('click');
                    },restart);
                }
            });

            owl.on('changed.owl.carousel', function (e) {
                if (!e.namespace) return;
                let current = e.relatedTarget.current();
                if (slideDirection==='r'){
                    console.log('.slide-'+(current-1))
                    $('.slide-'+(current-1)).attr('style','width:100% !important;');
                }
                if (slideDirection==='l'){
                    $('.slide-'+(current+1)).attr('style','width:100% !important;');
                }
            });

            $('#eventBackground-0-'+imgRowID[0]).css('background-image','url(http://127.0.0.1:8000/img/SellerMajor/Events/12/'+imgRowID[0]+'.jpg)');
            startProgressBar(0,restart);
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
                    index=carousel.relative($(this).index()),
                    slide=$('.slide-'+index),
                    slideWidth=100;

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
                            if (now>99) {
                                currentTime=0;
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
                    index=carousel.relative($(this).index());
                if (!block) {
                    block = true;
                    remaining=restart-currentTime;
                    if ((index+1) == $('#eventLen').text()) {
                        $('.slide-'+index).attr('style','transition :width '+remaining+ 'ms linear !important; width: 100% !important;');
                        owl.trigger('play.owl.autoplay', [remaining]);
                        mouseUpTimer=setTimeout(function () {
                            $('#closeEventModal').trigger('click');
                        },remaining);
                    } else {
                        $('.slide-'+index).attr('style','transition :width '+remaining+ 'ms linear !important; width: 100% !important;');
                        owl.trigger('play.owl.autoplay', [remaining]);
                    }
                    block = false;
                }
            });
        });

        let slideDirection='';
        $('#leftSlide').on('click', function () {
            window.clearTimeout(mouseUpTimer);
            window.clearTimeout(lastSlideTimer);
            slideDirection='l';
            $(".owl-carousel").trigger('prev.owl.carousel');
        });

        $('#rightSlide').on('click', function () {

            window.clearTimeout(mouseUpTimer);
            slideDirection='r';
            $(".owl-carousel").trigger('next.owl.carousel');
        });

        function startProgressBar(index,time) {
            $('#dot-'+index).removeClass('d-none');
            // apply keyframe animation
            $('.slide-'+index).css({
                width: "100%",
                transition: 'width '+time+ 'ms linear'
            });
        }

        function resetProgressBar(index) {
            $('.slide-'+index).css({
                width: 0,
                transition: "width 0s"
            });
        }

        function removeProfileImg(){
            $.confirm({
                title: 'حذف تصویر پروفایل',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        window.location='/Seller-Major-profileImgRemove';
                    },
                    انصراف: function () {
                    },
                }
            });
        }

        function removeEvent(item){
            $.confirm({
                title: 'حذف رویداد',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        window.location='/Seller-Major-removeEvent/'+item;
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
            let link=$('#'+app).val().replace(/\//g, '88888888888888888888888'),
                url='/Seller-Major-'+app+'Update/' + link;
            console.log(url);
            $('#'+app+'UpdateIcon').addClass('d-none');
            $('#'+app+'UpdateWaiting').removeClass('d-none');
            $.ajax({
                type: 'GET',
                async: false,
                url: url,
                success: function (data) {
                    $('#'+app+'Modal').modal('toggle');
                    $('#'+app+'Link').text(data);
                    $('#'+app+'UpdateIcon').removeClass('d-none');
                    $('#'+app+'UpdateWaiting').addClass('d-none');
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
    </script>
@endsection


{{--تغییرات جدید--}}
<?php
   public function panel()
    {
        $sellerMajorId=Auth::guard('sellerMajor')->user()->id;
        $data=DB::table('sellersmajor')
            ->where('id',$sellerMajorId)
            ->first();

        $events=DB::table('seller_major_event as e')
            ->select('*','e.ID as eventID','e.Time as eventTime','ev.Time as visitTime')
            ->leftJoin('seller_major_event_visit as ev','ev.EventID','e.ID')
            ->where('e.SellerMajorID',$sellerMajorId)
            ->orderBy('e.ID','ASC')
            ->get();

        $posts=DB::table('seller_major_post as p')
            ->select('*','p.ID as postID')
            ->leftJoin('seller_major_post_visit as pv','pv.PostID','p.ID')
            ->where('p.SellerMajorID',$sellerMajorId)
            ->orderBy('p.ID','ASC')
            ->get();
        $eventDate = array();
        $eventTime = array();
        $eventHowDay = array();
        $unreadEvent=null;
        foreach ($events as $key => $rec) {
            if($rec->visitTime === null){
                $unreadEvent[$key][0]=$key;
                $unreadEvent[$key][1]=$rec->eventID;
            }
            $temp=explode(' ',$rec->eventTime);
            $eventDate[$key] = $this->convertDateToPersian($temp[0]);
            $eventDate[$key]=$this->addZero($eventDate[$key]);
            $eventTime[$key] = $this->dateLenToNow($temp[0], $temp[1]);

            if ($eventTime[$key] < 11520) {
                $eventHowDay[$key] = $this->howDays($eventTime[$key]);
            } else {
                $eventHowDay[$key] = $eventDate[$key];
            }
        }
        $unreadEvent=is_null($unreadEvent)?null:array_values($unreadEvent);
        return view('SellerMajor.Panel',compact('sellerMajorId','data','events','posts','eventHowDay','unreadEvent'));
    }
?>
@extends('Layouts.IndexSellerMajor')
@section('Content')
    <span id="eventLen" class="d-none">{{count($events)}}</span>
    <span id="unreadEventIndex" class="d-none">{{$unreadEvent!==null?$unreadEvent[0][0]:'-1'}}</span>
    <span id="unreadEventPic" class="d-none">{{$unreadEvent!==null?$unreadEvent[0][1]:'-1'}}</span>
    <span id="userID" class="d-none">{{Auth::guard('sellerMajor')->user()->id}}</span>
    <section class="g-mb-100 g-brd-top--lg g-brd-gray-light-v4 g-pt-20--lg g-pt-0">
        <!--Bio-->
        <div class="container">
            <div style="direction: rtl" class="row">
                <div class="col-lg-4 g-mb-0">
                    <!-- User Details -->
                    <div class="smallDevice d-flex align-items-center justify-content-between g-mb-5">
                        <h4 class="g-font-weight-500 g-ml-10 g-mb-0">
                            {{$data->name}}
                            <span class="u-label g-mb-0 g-color-gray-dark-v3" title="پست ها">
                              <i class="icon-layers g-mr-3"></i> 14
                             </span>
                            <span class="u-label g-mb-0 g-color-gray-dark-v3" title="دنبال کنندگان">
                                  <i class="icon-people g-mr-3"></i> 22
                             </span>
                        </h4>

                        <ul style="direction: ltr" class="list-inline mb-0">
                            <li class="list-inline-item g-mx-2">
                                <a class="u-icon-v1 u-icon-size--sm u-icon-slide-up--hover g-color-gray-light-v1 g-bg-gray-light-v5 g-color-gray-light-v1--hover rounded-circle"
                                   data-toggle="modal"
                                   data-target="#instagramModal"
                                   onclick="$('#instagram').val('')"
                                   href="#!">
                                    <i class="g-line-height-1 u-icon__elem-regular fa fa-instagram g-font-size-16"></i>
                                    <i class="g-line-height-0_8 u-icon__elem-hover fa fa-instagram g-font-size-16"></i>
                                </a>
                                <!--modalInstagram-->
                                <div style="direction: rtl" class="modal fade text-center" id="instagramModal" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header g-pr-20 g-pl-20">
                                                <h5 class="m-0">آدرس اکانت اینستاگرام</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fa fa-close g-font-size-16"></i>
                                                </button>
                                            </div>
                                            <div style="direction: rtl" class="modal-body mx-3 text-right">
                                                <div style="direction: ltr" class="form-group row g-mb-25">
                                                    <div class="input-group justify-content-center">
                                                        <div class="col-lg-10">
                                                            <h6 class="d-flex justify-content-between"><span id="instagramLink" class="g-ml-5 g-color-gray-light-v1">{{$data->Instagram !== '' ? $data->Instagram : 'خالی'}}</span><span>آدرس فعلی</span></h6>
                                                            <div class="input-group">
                                                               <textarea id="instagram"
                                                                         autofocus
                                                                         class="form-control form-control-md g-resize-none g-brd-0 rounded-0 pl-0 g-bg-transparent"
                                                                         maxlength="300" rows="4" placeholder="آدرس جدید.."></textarea>
                                                            </div>
                                                            <div class="text-left">
                                                                <a href="#" onclick="socialAddressUpdate('instagram')" class="g-text-underline--none--hover g-color-gray-dark-v3 g-color-primary--hover">
                                                                <span class="u-icon-v3 u-icon-size--sm g-mr-15 g-mb-15 g-rounded-50x">
                                                                    <i id="instagramUpdateIcon" class="fa fa-check u-line-icon-pro"></i>
                                                                    <i id="instagramUpdateWaiting"
                                                                       class="d-none fa fa-spinner fa-spin g-line-height-0 align-middle"></i>
                                                                </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item g-mx-2">
                            </li>
                        </ul>
                    </div>
                    <!-- End User Details -->
                    <!-- User Image -->
                    <div class="g-mb-5 {{$unreadEvent!==null?'ContainerAnimateBorder':''}}">
                        <div class="g-pos-rel">
                            <figure>
                                <img id="profileImgBox" class="img-fluid w-100 u-block-hover__main--zoom-v1"
                                     src="{{$data->Pic!=''?$data->Pic.'/profileImg.jpg':'/img/SellerMajorProfileImage/Default/icon.jpg'}}" alt="Image Description">
                            </figure>

                            <!-- Figure Caption -->
                            <figcaption class="g-pa-20 w-100 g-pos-abs g-bottom-0">
                                <div
                                    class="g-flex-middle">
                                    <!-- Figure Social Icons -->
                                    <ul class="list-inline text-center g-flex-middle-item--bottom g-mb-20 p-0">
                                        <li class="list-inline-item align-middle g-mx-7">
                                            <a onclick="$('#profileImg').trigger('click')" class="u-icon-v1 u-icon-size--md g-color-white" href="#!">
                                                <i class="icon-camera u-line-icon-pro"></i>
                                            </a>

                                            <div style="display: none">
                                                <input id="profileImg"
                                                       value=""
                                                       type="file"
                                                       name="profileImg"
                                                       accept="image/*">
                                                <input style="display: none" type="text" id="imageUrl" name="imageUrl">
                                            </div>

                                            <form action="{{route('sellerMajorEditProfileImg')}}" id="imageUploadForm"
                                                  method="post" enctype="multipart/form-data">
                                                @csrf
                                            </form>
                                        </li>

                                        <li class="list-inline-item align-middle g-mx-7">
                                            <a onclick="$('#eventImg').trigger('click')"
                                               class="u-icon-v1 u-icon-size--md g-color-white" href="#!">
                                                <i class="icon-plus u-line-icon-pro"></i>
                                            </a>

                                            <div style="display: none">
                                                <input id="eventImg"
                                                       value=""
                                                       type="file"
                                                       name="eventImg"
                                                       accept="image/*">
                                                <input style="display: none" type="text" id="eventImageUrl" name="eventImageUrl">
                                            </div>

                                            <form action="{{route('sellerMajorAddEvent')}}" id="eventUploadForm"
                                                  method="post" enctype="multipart/form-data">
                                                @csrf
                                                <textarea id="eventText"
                                                          name="eventText"
                                                          autofocus
                                                          class="d-none"
                                                          maxlength="300" rows="4" placeholder="متن.."></textarea>
                                            </form>
                                        </li>

                                        <li class="list-inline-item align-middle g-mx-7">
                                            <a class="u-icon-v1 u-icon-size--md g-color-white"
                                               data-toggle="modal"
                                               data-target="#allEvents"
                                               href="#!" onclick="$('.borderContainer').remove()">
                                                <i class="icon-event u-line-icon-pro"></i>
                                            </a>
                                        </li>

                                        <li class="list-inline-item align-middle g-mx-7">
                                            <a class="u-icon-v1 u-icon-size--md g-color-white" href="#" onclick="removeProfileImg()">
                                                <i class="icon-trash u-line-icon-pro"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- End Figure Social Icons -->
                                </div>
                            </figcaption>
                            <!-- End Figure Caption -->
                        </div>
                        <div class="{{$unreadEvent!==null?'':'d-none'}} borderContainer">
                            <span class="topAnimateBorder lineAnimateBorder"></span>
                            <span class="rightAnimateBorder lineAnimateBorder"></span>
                            <span class="bottomAnimateBorder lineAnimateBorder"></span>
                            <span class="leftAnimateBorder lineAnimateBorder"></span>
                        </div>

                    </div>
                    <!-- User Image -->
                    <a style="border-radius: 0" class="btn btn-block u-btn-darkgray g-py-12 g-mb-20" href="#!">
                        <i class="icon-user-follow g-pos-rel g-top-1 g-ml-5"></i> دنبالم کن
                    </a>
                    <!-- End User Contact Buttons -->
                </div>

                <div class="col-lg-8">
                    <!-- User Details -->
                    <div class="bigDevice d-flex align-items-center justify-content-between g-mb-5">
                        <h4 class="g-font-weight-500 g-ml-10 g-mb-0">
                            {{$data->name}}
                            <span class="u-label g-mb-0 g-color-gray-dark-v3" title="پست ها">
                              <i class="icon-layers g-mr-3"></i> 14
                             </span>
                            <span class="u-label g-mb-0 g-color-gray-dark-v3" title="دنبال کنندگان">
                                  <i class="icon-people g-mr-3"></i> 22
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
                                <div style="direction: rtl" class="modal fade text-center" id="instagramModal" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header g-pr-20 g-pl-20">
                                                <h5 class="m-0">آدرس اکانت اینستاگرام</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fa fa-close g-font-size-16"></i>
                                                </button>
                                            </div>
                                            <div style="direction: rtl" class="modal-body mx-3 text-right">
                                                <div style="direction: ltr" class="form-group row g-mb-25">
                                                    <div class="input-group justify-content-center">
                                                        <div class="col-lg-10">
                                                            <h6 class="d-flex justify-content-between"><span id="instagramLink" class="g-ml-5 g-color-gray-light-v1">{{$data->Instagram !== '' ? $data->Instagram : 'خالی'}}</span><span>آدرس فعلی</span></h6>
                                                            <div class="input-group">
                                                               <textarea id="instagram"
                                                                         autofocus
                                                                         class="form-control form-control-md g-resize-none g-brd-0 rounded-0 pl-0 g-bg-transparent"
                                                                         maxlength="300" rows="4" placeholder="آدرس جدید.."></textarea>
                                                            </div>
                                                            <div class="text-left">
                                                                <a href="#" onclick="socialAddressUpdate('instagram')" class="g-text-underline--none--hover g-color-gray-dark-v3 g-color-primary--hover">
                                                                <span class="u-icon-v3 u-icon-size--sm g-mr-15 g-mb-15 g-rounded-50x">
                                                                    <i id="instagramUpdateIcon" class="fa fa-check u-line-icon-pro"></i>
                                                                    <i id="instagramUpdateWaiting"
                                                                       class="d-none fa fa-spinner fa-spin g-line-height-0 align-middle"></i>
                                                                </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item g-mx-2">
                            </li>
                        </ul>
                    </div>
                    <!-- End User Details -->

                    <!-- User Position -->
                    <h4 class="h6 g-font-weight-300 g-mb-10">
                        <i class="icon-badge g-pos-rel g-top-1 g-ml-5 g-color-gray-dark-v5"></i> {{$data->HintCategory}}
                    </h4>
                    <!-- End User Position -->

                    <!-- User Info -->
                    <ul class="list-inline g-font-weight-300 g-pl-40 g-pr-0">
                        <li class="list-inline-item g-ml-20 g-mr-0">
                            <i class="icon-check g-pos-rel g-top-1 g-color-gray-dark-v5 g-ml-5"></i> اعتبارسنجی
                        </li>
                        <li class="list-inline-item g-ml-20">
                            <a class="g-text-underline--none--hover"
                               data-toggle="modal"
                               data-target="#modalAddress"
                               href="#">
                                <i class="icon-location-pin g-color-gray-dark-v5 g-pos-rel g-top-1 g-ml-5"></i><span id="addressLink">{{$data->Address !=='' ? $data->Address:'آدرس'}}</span>
                            </a>
                            <!--address modal-->
                            <div class="modal fade text-center" id="modalAddress" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header g-pr-20 g-pl-20">
                                            <h5 class="m-0">آدرس محل شما</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-close g-font-size-16"></i>
                                            </button>
                                        </div>
                                        <div style="direction: rtl" class="modal-body mx-3 text-right">
                                            <div style="direction: ltr" class="form-group row g-mb-25">
                                                <div class="input-group justify-content-center">
                                                    <div class="col-lg-10">
                                                        <div class="input-group">
                                                               <textarea style="direction: rtl" id="address"
                                                                         autofocus
                                                                         class="form-control form-control-md g-resize-none g-brd-0 rounded-0 pl-0 g-bg-transparent"
                                                                         maxlength="300" rows="4" placeholder="آدرس جدید.."></textarea>
                                                        </div>
                                                        <div class="text-left">
                                                            <a href="#" onclick="addressUpdate()" class="g-text-underline--none--hover g-color-gray-dark-v3 g-color-primary--hover">
                                                                <span class="u-icon-v3 u-icon-size--sm g-mr-15 g-mb-15 g-rounded-50x">
                                                                    <i id="addressUpdateIcon" class="fa fa-check u-line-icon-pro"></i>
                                                                    <i id="waitingAddressUpdate"
                                                                       class="d-none fa fa-spinner fa-spin g-line-height-0 align-middle"></i>
                                                                </span>
                                                            </a>
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
                    <!-- End User Skills -->
                    <!-- bio -->
                    <div class="g-mb-10 g-mb-0--lg">
                        <div class="form-group g-mb-20">
                            <div class="input-group g-brd-primary--focus g-mb-10">
                            <textarea id="bioText"
                                      onfocus="if($('#edited').text()==='0'){$('#bioTextCopy').val($(this).val()); $('#edited').text('1')}"
                                      class="form-control form-control-md g-resize-none g-brd-0 rounded-0 g-px-5 g-pt-0 g-color-gray-dark-v4 g-bg-transparent"
                                      maxlength="300" rows="4" placeholder="بایوگرافی.."
                                      readonly>{{$data->Bio}}</textarea>
                                <textarea id="bioTextCopy" onfocus="" class="d-none" maxlength="300" rows="4"></textarea>
                                <span class="d-none" id="edited">0</span>
                            </div>
                        </div>

                        <div id="bioSubmit" class="d-none text-left">
                            <label class="u-check g-mr-15 mb-0"
                                   onclick="$('#bioSubmit').addClass('d-none'); $('#bioText').prop('readonly','readonly'); $('#bioEdit').removeClass('d-none'); $('#bioText').val($('#bioTextCopy').val())">
                                <div
                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-lightred--hover">
                                    <i class="fa fa-close g-absolute-centered"></i>
                                </div>
                            </label>
                            <label class="u-check g-mr-15 mb-0"
                                   onclick="updateBio()">
                                <div
                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-primary--hover">
                                    <i id="bioEditIcon" class="fa fa-check g-absolute-centered"></i>
                                    <i style="margin: -7px" id="waitingBioUpdate"
                                       class="d-none fa fa-spinner fa-spin g-absolute-centered g-color-gray-dark-v3"></i>
                                </div>
                            </label>
                        </div>

                        <div id="bioEdit" class="text-left">
                            <label class="u-check g-mr-15 mb-0"
                                   onclick="$('#bioText').removeAttr('readonly'); $('#bioText').focus(); $('#bioEdit').addClass('d-none'); $('#bioSubmit').removeClass('d-none');">
                                <div
                                    class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-primary--hover">
                                    <i class="fa fa-edit g-absolute-centered g-font-size-16"></i>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <hr class="{{isset($posts[0])?'':'d-none'}} g-brd-gray-light-v3 g-mt-0 g-mb-5">

        <!--Post-->
        <div class="container g-px-15--lg g-px-0">
            <div class="row g-mx-1">
                @foreach($posts as $key => $rec)
                    <div class="col-lg-2 col-4 g-brd-around g-brd-white p-0">
                        <a class="d-block u-block-hover u-bg-overlay g-bg-black-opacity-0_3--after g-bg-transparent--hover--after"
                           href="#">
                            <img class="img-fluid u-block-hover__main--zoom-v1" src="{{$rec->Pic.'/'.$rec->postID.'-sample.jpg'}}"
                                 alt="Image Description">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{--مودال ساخت رویدادها--}}
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
                                     class="form-control form-control-md g-resize-none g-brd-0 rounded-0 pl-0 g-bg-transparent"
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

        {{--مودال تصویر پروفایل--}}
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

        {{--مودال همه رویدادها--}}
        <div style="padding: 0 !important; overflow: hidden" class="modal fade bd-example-modal-lg" id="allEvents"
             tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
                <div style="height: 1000px;" class="modal-content">
                    <div>
                        <div class="home-demo p-0">
                            <div>
                                <div class="large-12 columns p-0">
                                    <div style="float: none; margin: auto; position: relative" class="owl-demo g-width-350--lg">
                                        <div id="leftSlide" style="position: absolute; height: 70%; width: 25%; top: 15%; left: 0; z-index: 9999"></div>
                                        <div id="rightSlide" style="position: absolute; height: 70%; width: 25%; top: 15%; right: 0; z-index: 9999"></div>
                                        <!--owl dots-->
                                        <div class="d-flex owlContainer">
                                            @foreach($events as $key => $row)
                                                <div id="dot-{{$key}}" class="owlDots {{$key ==0?'g-ml-0':'g-ml-2'}}">
                                                    <div class="slide-progress-main">
                                                        <div class="slide-progress {{($key == 0 && is_null($unreadEvent)) ?'slide-width-0':''}} {{'slide-'.$key}}"></div>
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
                                                        <div style="position: absolute; bottom: 0;" class="w-100 g-pa-20">
                                                            <div class="text-center">
                                                                <h5 style="direction: rtl;" class="{{$row->Text=='' ? 'd-none ':''}}g-color-white text-center g-bg-black-opacity-0_7 g-pa-20">{{$row->Text}}</h5>
                                                                <div class="g-color-white text-left g-bg-black-opacity-0_7 g-py-5 g-px-5">
                                                                    <div class="d-flex justify-content-between">
                                                                     <span class="u-label g-mb-0 g-color-white g-font-size-15 g-font-weight-500 align-self-center g-line-height-0" title="مشاهده شده">
                                                                          <i class="icon-eye g-mr-3"></i>
                                                                         <span class="align-middle">{{$row->Count===null?'0':$row->Count}}</span>
                                                                     </span>
                                                                        <a class="u-icon-v1 u-icon-size--md g-color-white" href="#!" onclick="removeEvent({{$row->ID}})">
                                                                            <i class="icon-trash u-line-icon-pro"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div style="direction: ltr; border: 0 !important; position: absolute; top:20px; z-index: 9999"
                                                         class="w-100">
                                                        <div class="d-flex justify-content-between col-12 g-px-10">
                                                            <button style="outline: 0; cursor:pointer;" type="button" id="closeEventModal"
                                                                    class="g-brd-none g-bg-transparent g-font-size-20 g-line-height-0_7 align-self-center"
                                                                    data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span class="g-font-size-30 g-color-white g-font-weight-600" aria-hidden="true">&times;</span>
                                                            </button>
                                                            <small style="direction: rtl" class="g-color-white text-center g-px-5">{{$eventHowDay[$key]}}</small>
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

        {{--مودال ریل پست ها--}}
        <div style="padding: 0 !important; overflow: hidden" class="modal fade bd-example-modal-lg" id="postRail"
             tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
                <div style="height: 1000px;" class="modal-content">
                    <div>
                        <div class="home-demo p-0">
                            <div>
                                <div class="large-12 columns p-0">
                                    <div style="float: none; margin: auto; position: relative" class="owl-demo g-width-350--lg">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('SellerMajorJsFunction')
    <script>
        let imgRowID=[],imgRowIdTemp;

        $('.modal').on('shown.bs.modal', function () {
            $(this).find('[autofocus]').focus();
        });

        // تنظیم تصویر پروفایل
        $(document).ready(function () {
            $('[id^="eventBackground-"]').each(function (i, obj) {
                imgRowIdTemp=$(this).attr('id').split('-');
                imgRowID[i]=imgRowIdTemp[2];
            });
            //چک کردن ابعاد تصویر
            let windowWidth = $(window).width(),
                windowHeight = $(window).height();
            switch (true) {
                case (windowWidth>1000):
                    $('.eventContainer').css('width','auto !important')
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
                        $('#imageUrl').val(reader.result);
                        $('#profileImgBox').attr('src', url);
                        $modal.modal('hide');
                        $("#imageUrl").clone().appendTo("#imageUploadForm");
                        $('#imageUploadForm').submit();
                    };
                });
            });

            $('#imageUploadForm').on('submit', (function (e) {
                $('#profileImgSubmitIcon').addClass('d-none');
                $('#waitingCrop').removeClass('d-none');
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $('#profileImgSubmitIcon').removeClass('d-none');
                        $('#waitingCrop').addClass('d-none');
                    }
                })
            }));

            $('.nowDate').text(nowDate());
        });

        // افزودن رویداد
        $(document).ready(function () {
            let $eventModal = $('#eventModal'),
                eventImage = document.getElementById('event_sample_image'),
                eventCropper;
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
                }
            });

            $eventModal.on('shown.bs.modal', function () {
                eventCropper = new Cropper(eventImage, {
                    aspectRatio: 8 / 16,
                    viewMode: 1,
                    zoomable: true,
                    background: true,
                    minCropBoxWidth: 960,
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
                    width: 960,
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
                });
            });

            $('#eventUploadForm').on('submit', (function (e) {
                $('#eventSubmitIcon').addClass('d-none');
                $('#waitingEventCrop').removeClass('d-none');
                $('#eventText').val($('#eventTextTemp').val());
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $('#eventSubmitIcon').removeClass('d-none');
                        $('#waitingEventCrop').addClass('d-none');
                        window.location.href = "/Seller-Major-Panel";
                    }
                })
            }));
        });

        // افزودن پست
        $(document).ready(function () {
            let $postModal = $('#postModal'),
                postImage = document.getElementById('post_sample_image'),
                postCropper;
            $('#postImg').on('change', function (event) {
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
                }
            });

            $postModal.on('shown.bs.modal', function () {
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
                    movable: true
                    // preview: '.preview'
                });
            });

            $postModal.on('hidden.bs.modal', function () {
                postCropper.destroy();
                postCropper = null;
            });

            $('#postCrop').on('click', function () {
                let canvas = postCropper.getCroppedCanvas({
                    width: 1400,
                    height: 1750
                });

                canvas.toBlob(function (blob) {
                    let url = URL.createObjectURL(blob),
                        reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        $('#postImageUrl').val(reader.result);
                        // $('#profileImgBox').attr('src', url);
                        $postModal.modal('hide');
                        $("#postImageUrl").clone().appendTo("#postUploadForm");
                        $('#postUploadForm').submit();
                    };
                });
            });

            $('#postUploadForm').on('submit', (function (e) {
                $('#postSubmitIcon').addClass('d-none');
                $('#waitingPostCrop').removeClass('d-none');
                $('#postText').val($('#postTextTemp').val());
            }));
        });

        $('#allEvents').on('hide.bs.modal hidden.bs.modal', function () {
            let owl = $('.owl-carousel');
            owl.owlCarousel('destroy');
            window.clearTimeout(mouseUpTimer);
            window.clearTimeout(lastSlideTimer);
            window.clearTimeout(owlToTimer);
            $(borderAnimation).stop();
            resetProgressBar(0);
        });

        let mouseUpTimer,lastSlideTimer,owlToTimer,borderAnimation;
        $('#allEvents').on('shown.bs.modal', function () {
            let owl = $('.owl-carousel'),
                restart = 5000,
                items = $('.item').length,
                width = 100 / items,
                block = false,
                currentTime = 0,
                userID=$('#userID').text(),
                remaining=restart,
                unreadEventIndex=parseInt($('#unreadEventIndex').text()),
                unreadEventPic=$('#unreadEventPic').text();
            $('.owlDots').attr('style', 'width:' + width + '%');

            owl.on('translate.owl.carousel', function (e) {
                let index=e.item.index;
                $('#eventBackground-'+index+'-'+imgRowID[index]).css('background-image','url(http://127.0.0.1:8000/img/SellerMajor/Events/'+userID+'/'+imgRowID[index]+'.jpg)');
                owl.trigger('stop.owl.autoplay');
                owl.trigger('play.owl.autoplay', [restart]);
                resetProgressBar(index);
            });

            owl.on('drag.owl.carousel', function (e) {
                console.log('drag: '+e.item.index);
                $('.slide-'+e.item.index).attr('style','width:100% !important;');
            });

            owl.on('translated.owl.carousel', function (e) {
                startProgressBar(e.item.index,restart);
                if (!e.namespace) return;
                let carousel = e.relatedTarget,
                    current = carousel.current()+1;
                if (current == $('#eventLen').text()) {
                    lastSlideTimer=setTimeout(function () {
                        $('#closeEventModal').trigger('click');
                    },restart);
                }
            });

            owl.on('changed.owl.carousel', function (e) {
                if (!e.namespace) return;
                let current = e.relatedTarget.current();
                if (slideDirection==='r'){
                    console.log('.slide-'+(current-1))
                    $('.slide-'+(current-1)).attr('style','width:100% !important;');
                }
                if (slideDirection==='l'){
                    $('.slide-'+(current+1)).attr('style','width:100% !important;');
                }
            });

            owl.on('to.owl.carousel', function (e) {
                if (unreadEventIndex+1 == $('#eventLen').text()) {
                    lastSlideTimer=setTimeout(function () {
                        $('#closeEventModal').trigger('click');
                    },restart);
                }
            });

            (function () {
                if(unreadEventIndex===-1){
                    $('#eventBackground-0-'+imgRowID[0]).css('background-image','url(http://127.0.0.1:8000/img/SellerMajor/Events/'+userID+'/'+imgRowID[0]+'.jpg)');
                    resetProgressBar(0);
                    startProgressBar(0,restart);
                    owl.trigger('play.owl.autoplay', [restart]);
                } else {
                    resetProgressBar(unreadEventIndex);
                    $('#eventBackground-'+unreadEventIndex+'-'+unreadEventPic).css('background-image','url(http://127.0.0.1:8000/img/SellerMajor/Events/'+userID+'/'+unreadEventPic+'.jpg)');
                    startProgressBar(unreadEventIndex,restart);
                    owlToTimer=setTimeout(function () {
                        owl.trigger("to.owl.carousel", [unreadEventIndex, 0]);
                    },100);
                }
            })();

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
                    index=carousel.relative($(this).index()),
                    slide=$('.slide-'+index),
                    slideWidth=100;

                if (!block) {
                    block = true;
                    window.clearTimeout(mouseUpTimer);
                    window.clearTimeout(lastSlideTimer);
                    window.clearTimeout(owlToTimer);
                    $(borderAnimation).stop();
                    slide.animate({
                        width: slideWidth
                    }, {
                        duration: restart,
                        step: function (now, fx) {
                            currentTime = Math.round((now * restart) / slideWidth);
                            if (now>99) {
                                currentTime=0;
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
                    index=carousel.relative($(this).index());
                if (!block) {
                    block = true;
                    remaining=restart-currentTime;
                    if ((index+1) == $('#eventLen').text()) {
                        $('.slide-'+index).attr('style','transition :width '+remaining+ 'ms linear !important; width: 100% !important;');
                        owl.trigger('play.owl.autoplay', [remaining]);
                        mouseUpTimer=setTimeout(function () {
                            $('#closeEventModal').trigger('click');
                        },remaining);
                    } else {
                        $('.slide-'+index).attr('style','transition :width '+remaining+ 'ms linear !important; width: 100% !important;');
                        owl.trigger('play.owl.autoplay', [remaining]);
                    }
                    block = false;
                }
            });
        });

        let slideDirection='';
        $('#leftSlide').on('click', function () {
            window.clearTimeout(mouseUpTimer);
            window.clearTimeout(lastSlideTimer);
            window.clearTimeout(owlToTimer);
            $(borderAnimation).stop();
            slideDirection='l';
            $(".owl-carousel").trigger('prev.owl.carousel');
        });

        $('#rightSlide').on('click', function () {
            window.clearTimeout(mouseUpTimer);
            window.clearTimeout(owlToTimer);
            $(borderAnimation).stop();
            slideDirection='r';
            $(".owl-carousel").trigger('next.owl.carousel');
        });

        function startProgressBar(index,time) {
            borderAnimation='.slide-'+index;
            $('.slide-'+index).animate({width:"100%"},time,'linear')
        }

        function resetProgressBar(index) {
            $('.slide-'+index).css({
                width: 0,
            });
        }

        function removeProfileImg(){
            $.confirm({
                title: 'حذف تصویر پروفایل',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        window.location='/Seller-Major-profileImgRemove';
                    },
                    انصراف: function () {
                    },
                }
            });
        }

        function removeEvent(item){
            $.confirm({
                title: 'حذف رویداد',
                content: 'آیا اطمینان دارید؟',
                buttons: {
                    تایید: function () {
                        window.location='/Seller-Major-removeEvent/'+item;
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
            let link=$('#'+app).val().replace(/\//g, '88888888888888888888888'),
                url='/Seller-Major-'+app+'Update/' + link;
            console.log(url);
            $('#'+app+'UpdateIcon').addClass('d-none');
            $('#'+app+'UpdateWaiting').removeClass('d-none');
            $.ajax({
                type: 'GET',
                async: false,
                url: url,
                success: function (data) {
                    $('#'+app+'Modal').modal('toggle');
                    $('#'+app+'Link').text(data);
                    $('#'+app+'UpdateIcon').removeClass('d-none');
                    $('#'+app+'UpdateWaiting').addClass('d-none');
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
    </script>
@endsection

