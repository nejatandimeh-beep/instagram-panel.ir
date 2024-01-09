@section('CustomerJsFunction')
    <script>
        let lastScrollTop = 0, gender = [], category = [], size = [], priceMin = 9999, priceMax = 100000000, color = [],
            file_upload, file_type, stopLoadProduct = false;

        window.addEventListener("pageshow", function (event) {
            let historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
        });

        function windowScrollTo() {
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#regulationContainer").offset().top
            }, 1000);
        }

        function copy(textToCopy){
            navigator.clipboard.writeText(textToCopy).then(
                function() {
                    /* clipboard successfully set */
                    window.alert('متن کپی شد.')
                },
                function() {
                    /* clipboard write failed */
                    window.alert('ناموفق')
                }
            )
        }

        function carousel(ele) {
            $('#' + ele).slick('setOption', 'responsive', [{
                breakpoint: 992,
                settings: {
                    slidesToShow: 1
                }
            }], true);
        }

        $(document).ready(function () {
            if(('.regulation').length>0){
                switch ($('#regulationTab').text()) {
                    case 'returnRegulation':
                        setTimeout(function () {
                            $('#returnProduct').trigger('click');
                        }, 100);
                        break;
                    default:
                }
            }

            if ($('.rtlPosition').length > 0)
                $('.table-responsive').animate({scrollLeft: $('.rtlPosition').position().left}, 1);

            let $modal = $('#modal'),
                image = document.getElementById('sample_image'),
                cropper;

            $('#upload_image').on('change', function (event) {
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
                    viewMode: 2,
                    zoomable: true,
                    background: true,
                    minCropBoxWidth: 400,
                    minCropBoxHeight: 400,
                    dragCrop: true,
                    dragMode: 'move',
                    movable: true,
                    // preview: '.preview'
                });
            });

            $modal.on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            $('#crop').on('click', function () {
                $('#cropText').hide();
                $('#waitingCrop').show();
                $(this).prop('disabled', true);
                let canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
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
                            url: '/Customer-Profile-Image',
                            data: form,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function () {
                                location.reload();
                            }
                        });
                    }
                });
            });

            function urltoFile(url, filename, mimeType) {
                return (fetch(url)
                        .then(function (res) {
                            return res.arrayBuffer();
                        })
                        .then(function (buf) {
                            return new File([buf], filename, {type: mimeType});
                        })
                );
            }

            let mq = window.matchMedia("(max-width: 900px)");
            if (mq.matches) {
                $('#bigDevice').remove();
                $('.bigDevice').remove();
                if($('.regulation').length>0){
                    $('.regulation').removeClass('row');
                }

                $('#smallFilterDiv').on('click', function () {
                    showSideBar();
                });

                $('#showSortBtn').on('click', function () {
                    $('#showSortBtn').hide();
                    $('#closeSortBtn').show();
                });

                $(document).on('click', function () {
                    $('#closeSortBtn').hide();
                    $('#showSortBtn').show();
                });

            } else {
                $('#smallDevice').remove();
                $('.smallDevice').remove();

                $('#smallFilterDiv').on('click', function () {
                    showSideBar();
                });
            }
        });

        // check pressed browser back button
        // $(function() {
        //     if(performance.navigation.type == 2) {
        //         if(window.location.href.toLowerCase().indexOf("/product/")){
        //             location.reload();
        //         }
        //     }
        // });

        $(document).bind("mouseup touchend", function (e) {
            let container = $(".outSideClick");

            // if click on out side container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $('.outSideClick').addClass('d-none');
            }
        });

        function newConnection() {
            if ($('#loginAlert').text() === 'login') {
                window.location = '/Customer-Connection';
            } else
                customerLogin();
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

        function customerLogin() {
            window.location = '/Login-Mode';
        }

        // ------------------------------------------فیلترینگ صفحه محصولات-----------------------------------------------
        // Select  Input Text onFocus Customer Data Form
        $('input').on('focus', function () {
            $(this).select();
        })
        // set state when page loading
        $("#stateSelect > option").each(function () {
            if ($(this).val() === $('#state').val()) {
                $(this).attr('selected', true);
                changeState('stateSelect', 'citySelect');
            }
        });

        // set city when page loading
        $("#citySelect > option").each(function () {
            if ($(this).val() === $('#city').val()) {
                $(this).attr('selected', true);
            }
        });

        // set state when page loading
        $("select[id^='stateSelectReceiver-'] > option").each(function () {
            let id = $(this).parent().attr('id').replace(/[^0-9]/gi, '');
            if ($(this).val() === $('#stateReceiver' + id).val()) {
                $(this).attr('selected', true);
                changeState('stateSelectReceiver-' + id, 'citySelectReceiver-' + id);
            }
        });

        // set city when page loading
        $("select[id^='citySelectReceiver-'] > option").each(function () {
            let id = $(this).parent().attr('id').replace(/[^0-9]/gi, '');
            if ($(this).val() === $('#cityReceiver' + id).val()) {
                $(this).attr('selected', true);
            }
        });

        let
            persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g],
            arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g],
            fixNumbers = function (str) {
                if (typeof str === 'string') {
                    for (var i = 0; i < 10; i++) {
                        str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
                    }
                }
                return str;
            };

        function forceEnglishNumber(val, ele, nextFocus, len) {
            if (val.length >= len) {
                val = val.slice(0, len);
                ele.val(val);
                if (ele.attr('name') === 'receiver-postalCode') {
                    ele.removeClass('g-brd-red');
                    $(nextFocus).focus();
                } else if (ele.attr('name') === 'receiver-mobile') {
                    if (val.substring(0, 2) === '09') {
                        ele.removeClass('g-brd-red');
                        $(nextFocus).focus();
                    }
                }

            } else {
                if (ele.attr('name') === 'receiver-postalCode' || (ele.attr('name') === 'receiver-mobile')) {
                    ele.addClass('g-brd-red');
                }
            }
            ele.val(fixNumbers(val));
        }

        function checkAllIsOff(filterDiv, filter) {
            setTimeout(function () {
                switch (filter) {
                    case 'gender':
                        if ($.isEmptyObject(gender))
                            $(filterDiv).append('<span class="btn cursor-default btn-sm u-btn-outline-lightred u-btn-hover-v2-1 g-font-weight-600 g-letter-spacing-0_5 g-brd-2 rounded-0 g-mr-5 g-mb-5">جنسیت: خاموش</span>');
                        break;
                    case 'category':
                        if ($.isEmptyObject(category))
                            $(filterDiv).append('<span class="btn cursor-default btn-sm u-btn-outline-lightred u-btn-hover-v2-1 g-font-weight-600 g-letter-spacing-0_5 g-brd-2 rounded-0 g-mr-5 g-mb-5">طبقه بندی: خاموش</span>');
                        break;
                    case 'size':
                        if ($.isEmptyObject(size))
                            $(filterDiv).append('<span class="btn cursor-default btn-sm u-btn-outline-lightred u-btn-hover-v2-1 g-font-weight-600 g-letter-spacing-0_5 g-brd-2 rounded-0 g-mr-5 g-mb-5">سایز: خاموش</span>');
                        break;
                    default:
                        break;
                }
            }, 1);
        }
        // ---------------------------------------------------My Function-----------------------------------------------
        // هایلت آپشن آدرس در هنگام قرار گرفتن ماوس بروی هر سط آدرس
        function optionHover(id) {
            $('#addressOption' + id).removeClass('g-color-gray-dark-v3');
            $('#addressOption' + id).addClass('g-color-primary');
        }

        function optionUnHover(id) {
            $('#addressOption' + id).removeClass('g-color-primary');
            $('#addressOption' + id).addClass('g-color-gray-dark-v3');
        }

        // Add FileName and Check Mark when Uploaded Image
        function addPathCheckMark(picID, filePathID, checkMarkID) {
            let locationElement = '';
            if (picID === 'pic5')
                locationElement = '#';
            else
                locationElement = '.custombox-content #';

            console.log(locationElement + picID);
            let pic = $(locationElement + picID),
                ext = $(locationElement + picID).val().split('.').pop().toLowerCase(),
                filePath = $(locationElement + filePathID),
                checkMark = $(locationElement + checkMarkID);

            if ((pic.val() !== '') && ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) !== -1)) {
                let fileName = pic.val().split("\\").pop();
                filePath.attr("value", fileName);
                filePath.removeClass('g-color-red');
                filePath.addClass('g-color-primary');
                checkMark.css('display', 'inline');
            } else {
                filePath.attr("value", 'فاقد تصویر');
                filePath.removeClass('g-color-primary');
                filePath.addClass('g-color-red');
                checkMark.css('display', 'none');
            }
        }

        function isEmpty(el) {
            return !$.trim(el.html())
        }

        function showPanel(ele) {
            switch (ele) {
                case 'data':
                    $('#user-data').css('display', 'block');
                    $('#user-address').css('display', 'none');
                    $('#user-interAction').css('display', 'none');

                    $('.filter a').removeClass('g-color-primary').addClass('g-color-main');
                    $('#filter-user-data').removeClass('g-color-main').addClass('g-color-primary');
                    $('html, body').animate({scrollTop: $('#user-data').offset().top}, 800);
                    break;
                case 'address':
                    $('#user-address').css('display', 'block');
                    $('#user-data').css('display', 'none');
                    $('#user-interAction').css('display', 'none');

                    $('.filter a').removeClass('g-color-primary').addClass('g-color-main');
                    $('#filter-user-address').removeClass('g-color-main').addClass('g-color-primary');
                    $('html, body').animate({scrollTop: $('#user-address').offset().top}, 800);
                    break;
                case 'interaction':
                    $('#user-interAction').css('display', 'block');
                    $('#user-address').css('display', 'none');
                    $('#user-data').css('display', 'none');

                    $('.filter a').removeClass('g-color-primary').addClass('g-color-main');
                    $('#filter-user-interAction').removeClass('g-color-main').addClass('g-color-primary');
                    $('html, body').animate({scrollTop: $('#user-interAction').offset().top}, 800);
                    break;
                default:
                    break;
            }
        }

        //  تابع زیر جهت فوکوس خودکار روی عنصری خاص در هر جای سند
        // کافیست نام تابع زیر در رویداد مورد نظر صدا زده شود
        function manuelFocus() {
            setTimeout(function () {
                $('.focusInput').focus();
            }, 500);
        }

        function closeOtherMenu() {
            if ($('#btnMenu').attr('aria-expanded') === 'false') {
                $('#otherMenu').attr("style", "display: none !important;");
            } else
                $('#otherMenu').removeAttr('style');
        }

        function confirmLogout() {
            $.confirm({
                title: 'خروج',
                content: 'آیا مطمئن هستید؟',
                buttons: {
                    تایید: function () {
                        location.href = 'logout';
                        event.preventDefault();
                        document.getElementById('logout-customer-form').submit();
                    },
                    انصراف: function () {
                        $.alert('عملیات خروج از حساب لغو شد.');
                    },
                }
            });
        }

        function manuelAutoFocus(id) {
            $('#' + id).focus();
            $('#' + id).on('focus', function () {
                document.body.scrollTop = $(this).offset().top;
            });
        }

        function editUserData() {
            $('#edit').hide();
            $('#save').show();

            let clone = $('#user-data :input');
            clone.attr("readonly", false);
            clone.removeClass("g-bg-gray-light-v5");

            clone = $('.customDisable');
            clone.css('pointer-events', 'all');
            clone = $('.u-check .btn');
            clone.removeClass('g-bg-gray-light-v5');

            manuelAutoFocus('user-name');
        }

        function saveUserData() {
            $.confirm({
                title: 'بروز رسانی مشخصات فردی',
                content: 'آیا مطمئن هستید؟',
                buttons: {
                    تایید: function () {
                        $('#profileUpdate').submit();
                    },
                    انصراف: function () {
                        $('#save').hide();
                        $('#edit').show();
                        let clone = $('#user-data :input');
                        clone.attr("readonly", true);
                        clone.addClass("g-bg-gray-light-v5");
                        $('#edit').removeClass("g-bg-gray-light-v5");

                        clone = $('.customDisable');
                        clone.css('pointer-events', 'none');
                        clone = $('.u-check .btn');
                        clone.addClass('g-bg-gray-light-v5');
                    },
                }
            });
        }

        // -------------------------------------------------State And City----------------------------------------------
        function changeState(state, city) {
            if (city !== 'citySelectReceiver-new') {
                $('#' + city).find('option').remove().end();
                autoCity($('#' + state).val(), city, 'createOptions');
            } else {
                $('.custombox-content #' + city).find('option').remove().end();
                autoCity($('.custombox-content #' + state).val(), city, 'createOptions');
            }
        }

        // تابع انتخاب شهر به ازای هر استان
        function autoCity(state, city, type) {
            let s = [], i,
                select = '';
            if (city === 'citySelectReceiver-new')
                select = $('.custombox-content #citySelectReceiver-new');
            else
                select = document.getElementById(city);

            switch (state) {
                case '1':
                    s[0] = "آذرشهر";
                    s[1] = "اهر";
                    s[2] = "اسکو";
                    s[3] = "بستان آباد";
                    s[4] = "بناب";
                    s[5] = "تبریز";
                    s[6] = "چاراویماق";
                    s[7] = "خداآفرین";
                    s[8] = "سراب";
                    s[9] = "شبستر";
                    s[10] = "عجب شیر";
                    s[11] = "کلیبر";
                    s[12] = "مراغه";
                    s[13] = "مرند";
                    s[14] = "ملکان";
                    s[15] = "میانه";
                    s[16] = "ورزقان";
                    s[17] = "هریس";
                    s[18] = "هشترود";
                    s[19] = "هوراند";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 19; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'آذربایجان شرقی ' + s[city];

                case '2':
                    s[0] = "آواجیق";
                    s[1] = "ارومیه";
                    s[2] = "اشنویه";
                    s[3] = "ایواوغلی";
                    s[4] = "باروق";
                    s[5] = "بازرگان";
                    s[6] = "بوکان";
                    s[7] = "پلدشت";
                    s[8] = "پیرانشهر";
                    s[9] = "تازه شهر";
                    s[10] = "تکاب";
                    s[11] = "چهار برج";
                    s[12] = "خلیفان";
                    s[13] = "خوی";
                    s[14] = "دیزج دیز";
                    s[15] = "ربط";
                    s[16] = "زرآباد";
                    s[17] = "سردشت";
                    s[18] = "سرو";
                    s[19] = "سلماس";
                    s[20] = "سیلوانه";
                    s[21] = "سیمینه";
                    s[22] = "سیاه چشمه";
                    s[23] = "شاهین دژ";
                    s[24] = "شوط";
                    s[25] = "فیروق";
                    s[26] = "قره ضیاالدین";
                    s[27] = "قطور";
                    s[28] = "قطورقوشچی";
                    s[29] = "کشاورز";
                    s[30] = "لاجان";
                    s[31] = "گوگ تپه";
                    s[32] = "ماکو";
                    s[33] = "محمدیار";
                    s[34] = "محمودآباد";
                    s[35] = "مرگنلر";
                    s[36] = "مهاباد";
                    s[37] = "میاندوآب";
                    s[38] = "میر آباد";
                    s[39] = "نازک علیا";
                    s[40] = "نالوس";
                    s[41] = "نقده";
                    s[42] = "نلاس";
                    s[43] = "نوشین شهر";
                    s[44] = "یولاگادی";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 44; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'آذربایجان غربی ' + s[city];

                case '3':
                    s[0] = "اردبیل";
                    s[1] = "پارس آباد";
                    s[2] = "مشگین شهر";
                    s[3] = "خلخال";
                    s[4] = "گرمی";
                    s[5] = "نمین";
                    s[6] = "بیله‌سوار";
                    s[7] = "اصلاندوز";
                    s[8] = "کوثر";
                    s[9] = "نیر";
                    s[10] = "سرعین";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 10; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'اردبیل ' + s[city];

                case '4':
                    s[0] = "اصفهان";
                    s[1] = "کاشان";
                    s[2] = "خمینی‌شهر";
                    s[3] = "نجف‌آباد";
                    s[4] = "لنجان";
                    s[5] = "فلاورجان";
                    s[6] = "شاهین‌شهر و میمه";
                    s[7] = "شهرضا";
                    s[8] = "مبارکه";
                    s[9] = "برخوار";
                    s[10] = "آران و بیدگل";
                    s[11] = "گلپایگان";
                    s[12] = "سمیرم";
                    s[13] = "تیران و کرون";
                    s[14] = "فریدن";
                    s[15] = "نطنز";
                    s[16] = "اردستان";
                    s[17] = "نائین";
                    s[18] = "فریدون‌شهر";
                    s[19] = "دهاقان";
                    s[20] = "خوانسار";
                    s[21] = "چادگان";
                    s[22] = "بوئین و میاندشت";
                    s[23] = "خور و بیابانک";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 23; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'اصفهان ' + s[city];

                case '5':
                    s[0] = "کرج";
                    s[1] = "فردیس";
                    s[2] = "ساوجبلاغ";
                    s[3] = "نظرآباد";
                    s[4] = "اشتهارد";
                    s[5] = "طالقان";
                    s[6] = "ایلام";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 6; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'البرز ' + s[city];

                case '6':
                    s[0] = "ایلام";
                    s[1] = "دهلران";
                    s[2] = "چرداول";
                    s[3] = "ایوان";
                    s[4] = "آبدانان";
                    s[5] = "دره‌شهر";
                    s[6] = "مهران";
                    s[7] = "ملکشاهی";
                    s[8] = "بدره";
                    s[9] = "سیروان";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 9; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'ایلام ' + s[city];

                case '7':
                    s[0] = "بوشهر";
                    s[1] = "دشتستان";
                    s[2] = "کنگان";
                    s[3] = "گناوه";
                    s[4] = "دشتی";
                    s[5] = "تنگستان";
                    s[6] = "عسلویه";
                    s[7] = "جم";
                    s[8] = "دیر";
                    s[9] = "دیلم";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 9; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'بوشهر ' + s[city];

                case '8':
                    s[0] = "تهران";
                    s[1] = "شهریار";
                    s[2] = "اسلامشهر";
                    s[3] = "بهارستان";
                    s[4] = "ملارد";
                    s[5] = "پاکدشت";
                    s[6] = "ری";
                    s[7] = "قدس";
                    s[8] = "مبارکه";
                    s[9] = "رباط‌کریم";
                    s[10] = "ورامین";
                    s[11] = "قرچک";
                    s[12] = "پردیس";
                    s[13] = "دماوند";
                    s[14] = "پیشوا";
                    s[15] = "شمیرانات";
                    s[16] = "فیروزکوه";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 16; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'تهران ' + s[city];

                case '9':
                    s[0] = "شهرکرد";
                    s[1] = "لردگان";
                    s[2] = "بروجن";
                    s[3] = "فارسان";
                    s[4] = "کیار";
                    s[5] = "اردل";
                    s[6] = "کوهرنگ";
                    s[7] = "سامان";
                    s[8] = "بن";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 8; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'چهارمحال و بختیاری ' + s[city];

                case '10':
                    s[0] = "بیرجند";
                    s[1] = "قائنات";
                    s[2] = "طبس";
                    s[3] = "درمیان";
                    s[4] = "نهبندان";
                    s[5] = "فردوس";
                    s[6] = "سربیشه";
                    s[7] = "زیرکوه";
                    s[8] = "سرایان";
                    s[9] = "خوسف";
                    s[10] = "بشرویه";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 10; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'خراسان جنوبی ' + s[city];

                case '11':
                    s[0] = "مشهد";
                    s[1] = "نیشابور";
                    s[2] = "سبزوار";
                    s[3] = "تربت جام";
                    s[4] = "تربت حیدریه";
                    s[5] = "قوچان";
                    s[6] = "کاشمر";
                    s[7] = "شهرضا";
                    s[8] = "چناران";
                    s[9] = "خواف";
                    s[10] = "تایباد";
                    s[11] = "فریمان";
                    s[12] = "سرخس";
                    s[13] = "گناباد";
                    s[14] = "بردسکن";
                    s[15] = "درگز";
                    s[16] = "بینالود";
                    s[17] = "زاوه";
                    s[18] = "رشتخوار";
                    s[19] = "باخرز";
                    s[20] = "جوین";
                    s[21] = "خلیل‌آباد";
                    s[22] = "مه‌ولات";
                    s[23] = "جغتای";
                    s[24] = "فیروزه";
                    s[25] = "خوشاب";
                    s[26] = "کلات";
                    s[27] = "بجستان";
                    s[28] = "داورزن";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 28; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'خراسان رضوی ' + s[city];

                case '12':
                    s[0] = "بجنورد";
                    s[1] = "شیروان";
                    s[2] = "اسفراین";
                    s[3] = "مانه و سملقان";
                    s[4] = "فاروج";
                    s[5] = "راز و جرگلان";
                    s[6] = "جاجرم";
                    s[7] = "گرمه";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 7; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'خراسان شمالی ' + s[city];

                case '13':
                    s[0] = "اهواز";
                    s[1] = "دزفول";
                    s[2] = "آبادان";
                    s[3] = "بندر ماهشهر";
                    s[4] = "شوش";
                    s[5] = "ایذه";
                    s[6] = "شوشتر";
                    s[7] = "بهبهان";
                    s[8] = "اندیمشک";
                    s[9] = "خرمشهر";
                    s[10] = "شادگان";
                    s[11] = "رامهرمز";
                    s[12] = "مسجدسلیمان";
                    s[13] = "دشت آزادگان";
                    s[14] = "کارون";
                    s[15] = "باغ‌ملک";
                    s[16] = "باوی";
                    s[17] = "امیدیه";
                    s[18] = "گتوند";
                    s[19] = "رامشیر";
                    s[20] = "حمیدیه";
                    s[21] = "اندیکا";
                    s[22] = "هویزه";
                    s[23] = "هندیجان";
                    s[24] = "لالی";
                    s[25] = "هفتکل";
                    s[26] = "آغاجاری";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 26; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'خوزستان ' + s[city];

                case '14':
                    s[0] = "زنجان";
                    s[1] = "خدابنده";
                    s[2] = "ابهر";
                    s[3] = "خرمدره";
                    s[4] = "طارم";
                    s[5] = "ماه‌نشان";
                    s[6] = "ایجرود";
                    s[7] = "سلطانیه";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 7; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'زنجان ' + s[city];

                case '15':
                    s[0] = "شاهرود";
                    s[1] = "سمنان";
                    s[2] = "دامغان";
                    s[3] = "گرمسار";
                    s[4] = "مهدی‌شهر";
                    s[5] = "میامی";
                    s[6] = "سرخه";
                    s[7] = "آرادان";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 7; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'سمنان ' + s[city];

                case '16':
                    s[0] = "زاهدان";
                    s[1] = "چابهار";
                    s[2] = "ایرانشهر";
                    s[3] = "سراوان";
                    s[4] = "راسک";
                    s[5] = "خاش";
                    s[6] = "زابل";
                    s[7] = "نیک شهر";
                    s[8] = "کنارک";
                    s[9] = "سیب و سوران";
                    s[10] = "زهک";
                    s[11] = "مهرستان";
                    s[12] = "دلگان";
                    s[13] = "هیرمند";
                    s[14] = "قصرقند";
                    s[15] = "فنوج";
                    s[16] = "نیمروز";
                    s[17] = "میرجاوه";
                    s[18] = "هامون";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 18; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'سیستان و بلوچستان ' + s[city];

                case '17':
                    s[0] = "شیراز";
                    s[1] = "مرودشت";
                    s[2] = "کازرون";
                    s[3] = "جهرم";
                    s[4] = "لارستان";
                    s[5] = "فسا";
                    s[6] = "داراب";
                    s[7] = "فیروزآباد";
                    s[8] = "ممسنی";
                    s[9] = "نی ریز";
                    s[10] = "آباده";
                    s[11] = "اقلید";
                    s[12] = "لامرد";
                    s[13] = "سپیدان";
                    s[14] = "کوار";
                    s[15] = "زرین‌دشت";
                    s[16] = "قیر و کارزین";
                    s[17] = "استهبان";
                    s[18] = "مهر";
                    s[19] = "خرامه";
                    s[20] = "گراش";
                    s[21] = "خرم‌بید";
                    s[22] = "بوانات";
                    s[23] = "فراشبند";
                    s[24] = "رستم";
                    s[25] = "ارسنجان";
                    s[26] = "خنج";
                    s[27] = "سروستان";
                    s[28] = "پاسارگاد";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 28; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'فارس ' + s[city];

                case '18':
                    s[0] = "قزوین";
                    s[1] = "البرز";
                    s[2] = "تاکستان";
                    s[3] = "بوئین‌زهرا";
                    s[4] = "آبیک";
                    s[5] = "آوج";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 5; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'قزوین ' + s[city];

                case '19':
                    s[0] = "قم";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 0; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'قم ' + s[city];

                case '20':
                    s[0] = "سنندج";
                    s[1] = "سقز";
                    s[2] = "مریوان";
                    s[3] = "بانه";
                    s[4] = "قروه";
                    s[5] = "کامیاران";
                    s[6] = "بیجار";
                    s[7] = "دیواندره";
                    s[8] = "دهگلان";
                    s[9] = "سروآباد";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 9; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'کردستان ' + s[city];

                case '21':
                    s[0] = "کرمان";
                    s[1] = "سیرجان";
                    s[2] = "رفسنجان";
                    s[3] = "جیرفت";
                    s[4] = "بم";
                    s[5] = "زرند";
                    s[6] = "رودبار جنوب";
                    s[7] = "شهربابک";
                    s[8] = "کهنوج";
                    s[9] = "ریگان";
                    s[10] = "بافت";
                    s[11] = "عنبرآباد";
                    s[12] = "بردسیر";
                    s[13] = "قلعه گنج";
                    s[14] = "فهرج";
                    s[15] = "منوجان";
                    s[16] = "نرماشیر";
                    s[17] = "راور";
                    s[18] = "ارزوئیه";
                    s[19] = "انار";
                    s[20] = "رابر";
                    s[21] = "فاریاب";
                    s[22] = "کوهبنان";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 22; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'کرمان ' + s[city];

                case '22':
                    s[0] = "کرمانشاه";
                    s[1] = "اسلام‌آبادغرب";
                    s[2] = "سرپل ذهاب";
                    s[3] = "سنقر";
                    s[4] = "هرسین";
                    s[5] = "کنگاور";
                    s[6] = "جوانرود";
                    s[7] = "صحنه";
                    s[8] = "پاوه";
                    s[9] = "گیلانغرب";
                    s[10] = "روانسر";
                    s[11] = "دالاهو";
                    s[12] = "ثلاث باباجانی";
                    s[13] = "قصرشیرین";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 13; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'کرمانشاه ' + s[city];

                case '23':
                    s[0] = "بویراحمد";
                    s[1] = "کهگیلویه";
                    s[2] = "گچساران";
                    s[3] = "دنا";
                    s[4] = "بهمئی";
                    s[5] = "چرام";
                    s[6] = "لنده";
                    s[7] = "باشت";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 7; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'کهگیلویه و بویراحمد ' + s[city];

                case '24':
                    s[0] = "گرگان";
                    s[1] = "گنبد کاووس";
                    s[2] = "علی‌آباد";
                    s[3] = "آق‌قلا";
                    s[4] = "کلاله";
                    s[5] = "آزادشهر";
                    s[6] = "رامیان";
                    s[7] = "ترکمن";
                    s[8] = "مینودشت";
                    s[9] = "کردکوی";
                    s[10] = "گمیشان";
                    s[11] = "گالیکش";
                    s[12] = "مراوه‌تپه";
                    s[13] = "بندر گز";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 7; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'گلستان ' + s[city];

                case '25':
                    s[0] = "رشت";
                    s[1] = "تالش";
                    s[2] = "لاهیجان";
                    s[3] = "رودسر";
                    s[4] = "لنگرود";
                    s[5] = "بندر انزلی";
                    s[6] = "صومعه‌سرا";
                    s[7] = "آستانه اشرفیه";
                    s[8] = "رودبار";
                    s[9] = "فومن";
                    s[10] = "آستارا";
                    s[11] = "رضوانشهر";
                    s[12] = "شفت";
                    s[13] = "ماسال";
                    s[13] = "سیاهکل";
                    s[13] = "املش";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 13; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'گیلان ' + s[city];

                case '26':
                    s[0] = "خرم‌آباد";
                    s[1] = "بروجرد";
                    s[2] = "دورود";
                    s[3] = "کوهدشت";
                    s[4] = "دلفان";
                    s[5] = "الیگودرز";
                    s[6] = "سلسله";
                    s[7] = "ازنا";
                    s[8] = "پلدختر";
                    s[9] = "دوره";
                    s[10] = "رومشکان";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 10; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'لرستان ' + s[city];

                case '27':
                    s[0] = "بابل";
                    s[1] = "ساری";
                    s[2] = "آمل";
                    s[3] = "قائم‌شهر";
                    s[4] = "بهشهر";
                    s[5] = "تنکابن";
                    s[6] = "نوشهر";
                    s[7] = "بابلسر";
                    s[8] = "نور";
                    s[9] = "نکا";
                    s[10] = "چالوس";
                    s[11] = "نوشهر";
                    s[12] = "بابلسر";
                    s[13] = "نور";
                    s[14] = "نکا";
                    s[15] = "چالوس";
                    s[16] = "محمودآباد";
                    s[17] = "جویبار";
                    s[18] = "رامسر";
                    s[19] = "فریدونکنار";
                    s[20] = "میاندرود";
                    s[21] = "عباس‌آباد";
                    s[22] = "سوادکوه";
                    s[23] = "گلوگاه";
                    s[24] = "سوادکوه شمالی";
                    s[25] = "کلاردشت";
                    s[26] = "سیمرغ";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 26; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'مازندران ' + s[city];

                case '28':
                    s[0] = "اراک";
                    s[1] = "ساوه";
                    s[2] = "شازند";
                    s[3] = "خمین";
                    s[4] = "زرندیه";
                    s[5] = "محلات";
                    s[6] = "خنداب";
                    s[7] = "دلیجان";
                    s[8] = "کمیجان";
                    s[9] = "فراهان";
                    s[10] = "تفرش";
                    s[11] = "آشتیان";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 11; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'مرکزی ' + s[city];

                case '29':
                    s[0] = "بندرعباس";
                    s[1] = "میناب";
                    s[2] = "بندر لنگه";
                    s[3] = "قشم";
                    s[4] = "رودان";
                    s[5] = "بستک";
                    s[6] = "حاجی‌آباد";
                    s[7] = "جاسک";
                    s[8] = "خمیر";
                    s[9] = "پارسیان";
                    s[10] = "سیریک";
                    s[11] = "بشاگرد";
                    s[12] = "ابوموسی";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 12; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'هرمزگان ' + s[city];

                case '30':
                    s[0] = "همدان";
                    s[1] = "ملایر";
                    s[2] = "نهاوند";
                    s[3] = "کبودرآهنگ";
                    s[4] = "بهار";
                    s[5] = "رزن";
                    s[6] = "تویسرکان";
                    s[7] = "اسدآباد";
                    s[8] = "فامنین";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 8; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'همدان ' + s[city];

                case '31':
                    s[0] = "یزد";
                    s[1] = "میبد";
                    s[2] = "اردکان";
                    s[3] = "مهریز";
                    s[4] = "ابرکوه";
                    s[5] = "بافق";
                    s[6] = "تفت";
                    s[7] = "خاتم";
                    s[8] = "اشکذر";
                    s[9] = "بهاباد";

                    if (type === 'createOptions') {
                        for (i = 0; i <= 9; i++) {
                            let opt = document.createElement('option');
                            opt.value = i;
                            opt.innerHTML = s[i];
                            select.append(opt);
                        }
                        break;
                    } else
                        return 'یزد ' + s[city];
            }
        }

        // ---------------------------------------------------Now Date--------------------------------------------------
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
