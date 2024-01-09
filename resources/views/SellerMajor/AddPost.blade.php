@extends('Layouts.SellerMajor.Index')
@section('Content')
    <span id="userCategory" class="d-none">{{Auth::guard('sellerMajor')->user()->Category}}</span>
    <span class="d-none" id="imgWorking"></span>
    <div class="mx-auto col-12 col-lg-8">
        <h5 class="text-right g-py-10">افزودن پست</h5>
        <label id="lblImg" class="d-block text-right g-font-weight-600 g-color-red necessary">تصاویر</label>
    </div>

    <!--تصاویر-->
    <div id="imgBtn" class="d-flex justify-content-center g-px-10">
        <div style="position:relative;" id="addImgBtn-0" class="list-inline-item g-mx-3">
            <div
                style="position:relative; width: 70px; min-height: 70px; border-radius: 10px; background-color: #fdfdfd"
                onclick="insertImg('0')" id="insertImgBtn0"
                class="previewBox g-brd-around g-brd-gray-light-v4">
                <h3 style="position:absolute; top:20px; left:27px; cursor: pointer; text-shadow: 1px 1px  #FFFFFF;" class="g-color-primary">+</h3>
                <img id="loadingImg0" style="position:absolute; top:17px; left:17px; width: 34px;"
                     src="{{asset('img/Other/loadingImg.gif')}}" class="d-none g-rounded-5 loadingImg">
                <img id="imgPreview0" style="width: 100%;" src="" class="g-rounded-5 img-0">
            </div>
            <div style="display: none">
                <input id="postImg-0"
                       value=""
                       type="file"
                       name="postImg"
                       accept="image/png, image/jpeg">
            </div>
            <div style="display: none; position: absolute; bottom: -40px; width: 100%; cursor: pointer" class="text-center"
                 id="stopImgLoad0" onclick="resetImg('0')">
                <span class="g-color-red h4"><i class="icon-trash"></i></span>
            </div>
        </div>
        <div style="position:relative;" id="addImgBtn-1" class="d-none list-inline-item g-mx-3">
            <div
                style="position:relative; width: 70px; min-height: 70px; border-radius: 10px; background-color: #fdfdfd"
                onclick="insertImg('1')" id="insertImgBtn1"
                class="previewBox g-brd-around g-brd-gray-light-v4">
                <h3 style="position:absolute; top:20px; left:27px; cursor: pointer; text-shadow: 1px 1px  #FFFFFF;" class="g-color-primary">+</h3>
                <img id="loadingImg1" style="position:absolute; top:17px; left:17px; width: 34px;"
                     src="{{asset('img/Other/loadingImg.gif')}}" class="d-none g-rounded-5 loadingImg">
                <img id="imgPreview1" style="width: 100%;" src="" class="g-rounded-5">
            </div>
            <div style="display: none">
                <input id="postImg-1"
                       value=""
                       type="file"
                       name="postImg"
                       accept="image/png, image/jpeg">
            </div>
            <div style="display: none; position: absolute; bottom: -40px; width: 100%; cursor: pointer" class="text-center"
                 id="stopImgLoad1" onclick="resetImg('1')">
                <span class="g-color-red h4"><i class="icon-trash"></i></span>
            </div>
        </div>
        <div style="position:relative;" id="addImgBtn-2" class="d-none list-inline-item g-mx-3">
            <div
                style="position:relative; width: 70px; min-height: 70px; border-radius: 10px; background-color: #fdfdfd"
                onclick="insertImg('2')" id="insertImgBtn2"
                class="previewBox g-brd-around g-brd-gray-light-v4">
                <h3 style="position:absolute; top:20px; left:27px; cursor: pointer; text-shadow: 1px 1px  #FFFFFF;" class="g-color-primary">+</h3>
                <img id="loadingImg2" style="position:absolute; top:17px; left:17px; width: 34px;"
                     src="{{asset('img/Other/loadingImg.gif')}}" class="d-none g-rounded-5 loadingImg">
                <img id="imgPreview2" style="width: 100%;" src="" class="g-rounded-5">
            </div>
            <div style="display: none">
                <input id="postImg-2"
                       value=""
                       type="file"
                       name="postImg"
                       accept="image/png, image/jpeg">
            </div>
            <div style="display: none; position: absolute; bottom: -40px; width: 100%; cursor: pointer" class="text-center"
                 id="stopImgLoad2" onclick="resetImg('2')">
                <span class="g-color-red h4"><i class="icon-trash"></i></span>
            </div>
        </div>
        <div style="position:relative;" id="addImgBtn-3" class="d-none list-inline-item g-mx-3">
            <div
                style="position:relative; width: 70px; min-height: 70px; border-radius: 10px; background-color: #fdfdfd"
                onclick="insertImg('3')" id="insertImgBtn3"
                class="previewBox g-brd-around g-brd-gray-light-v4">
                <h3 style="position:absolute; top:20px; left:27px; cursor: pointer; text-shadow: 1px 1px  #FFFFFF;" class="g-color-primary">+</h3>
                <img id="loadingImg3" style="position:absolute; top:17px; left:17px; width: 34px;"
                     src="{{asset('img/Other/loadingImg.gif')}}" class="d-none g-rounded-5 loadingImg">
                <img id="imgPreview3" style="width: 100%;" src="" class="g-rounded-5">
            </div>
            <div style="display: none">
                <input id="postImg-3"
                       value=""
                       type="file"
                       name="postImg"
                       accept="image/png, image/jpeg">
            </div>
            <div style="display: none; position: absolute; bottom: -40px; width: 100%; cursor: pointer" class="text-center"
                 id="stopImgLoad3" onclick="resetImg('3')">
                <span class="g-color-red h4"><i class="icon-trash"></i></span>
            </div>
        </div>
    </div>

    <!--فرم ارسال تصاویر از طریق آژاکس-->
    <form action="{{route('sellerMajorAddPost')}}" id="postUploadForm" class="d-none"
          method="post" enctype="multipart/form-data">
        @csrf
        <textarea id="postText"
                  name="postText"
                  autofocus
                  maxlength="300" rows="4" placeholder="متن.."></textarea>
        <input type="text" id="formCat" name="cat" class="listBox g-color-gray-dark-v3">
        <input type="text" id="formCatCode" name="catCode" class="listBox g-color-gray-dark-v3">
        <input type="text" id="formName" name="name" class="listBox g-color-gray-dark-v3">
        <input type="text" id="formNameCode" name="nameCode" class="listBox g-color-gray-dark-v3">
        <input type="text" id="formGender" name="gender" class="listBox g-color-gray-dark-v3">
        <input type="text" id="formGenderCode" name="genderCode" class="listBox g-color-gray-dark-v3">
        <input type="text" id="formSize" name="size" class="listBox g-color-gray-dark-v3">
        <input type="number" id="formPrice" name="price" class="listBox g-color-gray-dark-v3">
        <input type="number" id="formDiscount" name="discount" class="listBox g-color-gray-dark-v3">
        <input type="number" id="formFinalPrice" name="finalPrice" class="listBox g-color-gray-dark-v3">
        <input type="text" id="formColor" name="color" class="listBox g-color-gray-dark-v3">
        <input type="text" id="formColorCode" name="colorCode" class="listBox g-color-gray-dark-v3">
        <input type="number" id="picCount" value="0" name="picCount" class="listBox g-color-gray-dark-v3">
    </form>

    <!--مودال افزودن تصویر پست-->
    <div style="direction: rtl; z-index: 11000; max-height: 100vh"
         class="modal g-bg-white fade bd-example-modal-lg hideScrollBar" id="postModal"
         tabindex="-1" role="dialog"
         aria-labelledby="postModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered m-0 mx-lg-auto" role="document">
            <div style="height: 85vh" class="modal-content g-brd-none">
                <div class="modal-body">
                    <div class="img-container">
                        <div class="col-md-12 p-0">
                            <img style="width: 100%;" src="" id="post_sample_image" alt="تصویر نادرست است!">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="addPostButton" class="text-left">
                        <label class="u-check g-mr-15 mb-0" data-dismiss="modal">
                            <div data-dismiss="modal"
                                 aria-label="Close"
                                 class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-lightred--hover">
                                <i class="fa fa-close g-absolute-centered"></i>
                            </div>
                        </label>
                        <label class="u-check g-mr-15 mb-0 postCrop">
                            <div
                                class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-primary--hover">
                                <i id="postSubmitIcon" class="fa fa-check g-absolute-centered"></i>
                                <i style="margin: -7px" id="waitingPostCrop"
                                   class="d-none fa fa-spinner fa-spin g-absolute-centered g-color-gray-dark-v3"></i>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--مشخصات پست-->
    <div style="direction: rtl" class="mx-auto col-12 col-lg-8 g-mt-40">
        <div id="captionContainer" class="{{$_SESSION['jobCategory'] === 'clothes' ? '':'d-none'}}">
            <!--دسته بندی-->
            <div class="listSearch col-12 p-0 g-my-20">
                <label id="lblCat" class="g-mb-5 g-font-weight-600 g-color-red necessary">دسته بندی</label>
                <div class="dropdown">
                    <div id="categoryContainer" class="listContainer dropdown-content">
                        <input type="text"
                               id="productCat"
                               class="listBox g-color-gray-dark-v3"
                               placeholder="انتخاب کنید.."
                               value=""
                               onchange="$('#lblCat').removeClass('g-color-red'); $('#lblName').removeClass('g-color-red')"
                               readonly
                               onfocus="$('#allCategory').show()">
                        <span id="catCode" class="d-none"></span>
                        <div style="display: none" id="allCategory"
                             class="g-py-10 customScrollBar listItems">
                            <div class="g-mb-15">
                                <span class="g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10">لباس</span>
                                <a href="#" onclick="setProductName('a','لباس زیر')" class="g-font-size-14">لباس زیر</a>
                                <a href="#" onclick="setProductName('b','لباس پایین تنه')" class="g-font-size-14">لباس
                                    پایین تنه</a>
                                <a href="#" onclick="setProductName('c','لباس بالا تنه')" class="g-font-size-14">لباس
                                    بالا تنه</a>
                                <a href="#" onclick="setProductName('d','لباس تمام تنه')" class="g-font-size-14">لباس
                                    تمام تنه</a>
                            </div>
                            <div class="g-mb-15">
                                            <span
                                                class="g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10">کفش و کیف</span>
                                <a href="#" onclick="setProductName('e','کیف')"
                                   class="g-font-size-14">کیف</a>
                                <a href="#" onclick="setProductName('f','کفش')"
                                   class="g-font-size-14">کفش</a>
                            </div>
                            <div class="g-mb-15">
                                <span class="g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10">ورزشی</span>
                                <a href="#" onclick="setProductName('g','لباس زیر ورزشی')" class="g-font-size-14">لباس
                                    زیر</a>
                                <a href="#" onclick="setProductName('h','لباس پایین تنه ورزشی')" class="g-font-size-14">لباس
                                    پایین تنه</a>
                                <a href="#" onclick="setProductName('i','لباس بالا تنه ورزشی')" class="g-font-size-14">لباس
                                    بالا تنه</a>
                                <a href="#" onclick="setProductName('j','لباس تمام ورزشی')" class="g-font-size-14">لباس
                                    تمام تنه</a>
                                <a href="#" onclick="setProductName('k','کیف ورزشی')"
                                   class="g-font-size-14">کیف</a>
                                <a href="#" onclick="setProductName('l','کفش ورزشی')"
                                   class="g-font-size-14">کفش</a>
                                <a href="#" onclick="setProductName('m','اکسسوری ورزشی')" class="g-font-size-14">اکسسوری
                                    ورزشی</a>
                            </div>
                            <div class="g-mb-15">
                                            <span
                                                class="g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10">اکسسوری</span>
                                <a href="#" onclick="setProductName('n','بدلیجات')" class="g-font-size-14">بدلیجات</a>
                                <a href="#" onclick="setProductName('o','اکسسوری مو')" class="g-font-size-14">اکسسوری
                                    مو</a>
                                <a href="#" onclick="setProductName('p','سر پوش')" class="g-font-size-14">سر
                                    پوش</a>
                                <a href="#" onclick="setProductName('q','اکسسوری سایر')" class="g-font-size-14">اکسسوری
                                    سایر</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--نام محصول-->
            <div id="productNameContainer" class="listSearch col-12 p-0 g-my-20">
                <label id="lblName" class="g-mb-5 g-font-weight-600 g-color-red necessary">نام محصول</label>
                <div class="dropdown">
                    <div class="listContainer dropdown-content">
                        <input type="text"
                               id="productName"
                               class="listBox g-color-gray-dark-v3"
                               placeholder="انتخاب کنید.."
                               value=""
                               readonly
                               onfocus="$('#allProductName').show()">
                        <span id="productCode" class="d-none"></span>
                        <div style="display: none" id="allProductName"
                             class="g-py-10 listItems">
                            <div class="g-mb-5 productNameContainer">
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 lebasZir">لباس زیر</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 lebasPaeinTane">لباس پایین تنه</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 lebasBalaTane">لباس بالا تنه</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 lebasTamamTane">لباس تمام تنه</span>
                                <span class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 kafsh">کفش</span>
                                <span class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 kif">کیف</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 varzeshiZir">لباس زیر ورزشی</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 varzeshiPaein">لباس پایین تنه ورزشی</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 varzeshiBala">لباس بالا تنه ورزشی</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 varzeshiTamam">لباس تمام تنه ورزشی</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 varzeshiKif">کیف ورزشی</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 varzeshiKafsh">کفش ورزشی</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 varzeshiAksesori">اکسسوری ورزشی</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 aksesoriBadalijat">اکسسوری بدلیجات</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 aksesoriMoo">اکسسوری مو</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 aksesoriSarpoosh">اکسسوری سرپوش</span>
                                <span
                                    class="d-none g-font-size-14 g-font-weight-600 g-pr-15 g-pb-10 aksesoriSayer">اکسسوری سایر</span>
                                <ul style="direction: rtl"
                                    class="list-unstyled p-0 m-0 g-font-size-14">
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasZir d-none"><span
                                                class="d-none">00</span>شورت</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasZir d-none"><span
                                                class="d-none">01</span>سوتین</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasZir d-none"><span
                                                class="d-none">02</span>ست لباس زیر</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasZir d-none"><span
                                                class="d-none">03</span>زیر پوش</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasZir d-none"><span
                                                class="d-none">04</span>گن</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasPaeinTane d-none"><span
                                                class="d-none">10</span>شلوارک</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasPaeinTane d-none"><span
                                                class="d-none">11</span>شلوار</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasPaeinTane d-none"><span
                                                class="d-none">12</span>شلوار راحتی</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasPaeinTane d-none">دامن<span
                                                class="d-none">13</span></a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasPaeinTane d-none">لگ<span
                                                class="d-none">14</span></a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasPaeinTane d-none"><span
                                                class="d-none">15</span>جوراب</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">20</span>تیشرت</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">21</span>پولوشرت</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">22</span>تاپ</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">23</span>تونیک</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">24</span>پیراهن</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">216</span>پیراهن مجلسی</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">25</span>شومیز</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">26</span>بلوز</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">27</span>پلیور</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">28</span>ژاکت</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">29</span>جلیقه</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">210</span>هودی</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">211</span>سویشرت</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">212</span>کت تک</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none">
                                            <span class="d-none">213</span>کت پاییزه</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none">
                                            <span class="d-none">214</span>کت زمستانه</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasBalaTane d-none"><span
                                                class="d-none">215</span>کاپشن</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasTamamTane d-none">
                                            <span class="d-none">30</span>لباس خواب</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasTamamTane d-none"><span
                                                class="d-none">31</span>مانتو</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasTamamTane d-none"><span
                                                class="d-none">38</span>پیراهن مجلسی</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasTamamTane d-none"><span
                                                class="d-none">32</span>پانچو</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasTamamTane d-none"><span
                                                class="d-none">33</span>رویه</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasTamamTane d-none"><span
                                                class="d-none">34</span>شنل</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="lebasTamamTane d-none"><span
                                                class="d-none">35</span>کت شلوار</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasTamamTane d-none">
                                            <span class="d-none">36</span>ست لباس مجلسی</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="lebasTamamTane d-none">
                                            <span class="d-none">37</span>ست لباس اداری</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kafsh d-none"><span
                                                class="d-none">50</span>دمپایی</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kafsh d-none"><span
                                                class="d-none">51</span>صندل</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kafsh d-none"><span
                                                class="d-none">52</span>تخت</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kafsh d-none"><span
                                                class="d-none">53</span>پاشنه دار</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kafsh d-none"><span
                                                class="d-none">54</span>روزمره</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kafsh d-none"><span
                                                class="d-none">55</span>نیم بوت</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kafsh d-none"><span
                                                class="d-none">56</span>بوت</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kafsh d-none"><span
                                                class="d-none">00</span>مراقبت کفش</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kif d-none"><span
                                                class="d-none">40</span>پول</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kif d-none"><span
                                                class="d-none">41</span>کارت</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kif d-none"><span
                                                class="d-none">42</span>دستی</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kif d-none"><span
                                                class="d-none">43</span>دوشی</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kif d-none"><span
                                                class="d-none">44</span>اداری</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kif d-none"><span
                                                class="d-none">45</span>سفری</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="kif d-none"><span
                                                class="d-none">46</span>کوله
                                            پشتی</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="varzeshiZir d-none">مایو<span
                                                class="d-none">600</span></a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiPaein d-none"><span
                                                class="d-none">610</span>شورت</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiPaein d-none"><span
                                                class="d-none">611</span>شلوارک</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiPaein d-none">
                                            <span class="d-none">612</span>شلوار اسلش</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiPaein d-none"><span
                                                class="d-none">613</span>دامن</a>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiBala d-none"><span
                                                class="d-none">620</span>تیشرت</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiBala d-none"><span
                                                class="d-none">621</span>پولوشرت</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiBala d-none"><span
                                                class="d-none">622</span>تاپ</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiBala d-none"><span
                                                class="d-none">623</span>پیراهن</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiBala d-none"><span
                                                class="d-none">624</span>جلیقه</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiBala d-none"><span
                                                class="d-none">625</span>هودی</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiBala d-none"><span
                                                class="d-none">626</span>سویشرت</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiBala d-none"><span
                                                class="d-none">627</span>کاپشن</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiTamam d-none"><span
                                                class="d-none">630</span>ست ورزشی</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="varzeshiKif d-none"><span
                                                class="d-none">640</span>ساک</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="varzeshiKif d-none"><span
                                                class="d-none">641</span>کوله پشتی</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiKafsh d-none"><span
                                                class="d-none">650</span>کفش ساده</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiKafsh d-none"><span
                                                class="d-none">651</span>کتانی</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiKafsh d-none"><span
                                                class="d-none">652</span>کفش حرفه ای</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiAksesori d-none">
                                            <span class="d-none">ProSportCap</span>کلاه حرفه ای</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiAksesori d-none">هد
                                            بند<span
                                                class="d-none">SportHeadBand</span></a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="varzeshiAksesori d-none"><span
                                                class="d-none">SportGlasses</span>عینک</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="varzeshiAksesori d-none"><span
                                                class="d-none">SwimmingNoseClip</span>بینی بند</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="varzeshiAksesori d-none"><span
                                                class="d-none">Earplugs
                                                            </span>گوش بند</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="varzeshiAksesori d-none"><span
                                                class="d-none">ArmBand
                                                            </span>بازو بند</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiAksesori d-none">مچ
                                            بند<span class="d-none">SportWristBand</span></a>
                                    </li>
                                    <li><a ohref="#" nclick="setProductCode($(this))"
                                           class="varzeshiAksesori d-none"><span
                                                class="d-none">SportGloves</span>دستکش</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="varzeshiAksesori d-none"><span
                                                class="d-none">CalfSupport</span>ساق</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="varzeshiAksesori d-none">
                                            <span class="d-none">SportSocks</span>انواع جوراب</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="varzeshiAksesori d-none"><span
                                                class="d-none">CanteenBottle</span>قم قمه</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="aksesoriBadalijat d-none"><span
                                                class="d-none">700</span>گوشواره</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="aksesoriBadalijat d-none"><span
                                                class="d-none">701</span>گردن بند</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="aksesoriBadalijat d-none"><span
                                                class="d-none">702</span>النگو</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="aksesoriBadalijat d-none"><span
                                                class="d-none">703</span>دست بند</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="aksesoriBadalijat d-none"><span
                                                class="d-none">704</span>انگشتر</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriBadalijat d-none">
                                            <span class="d-none">705</span>پا بند</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriBadalijat d-none">
                                            <span class="d-none">706</span>ست بدلیجات</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="aksesoriBadalijat d-none"><span
                                                class="d-none">710</span>تاج</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriMoo d-none"><span
                                                class="d-none">711</span>گیره مو</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriMoo d-none"><span
                                                class="d-none">712</span>کش مو</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriMoo d-none"><span
                                                class="d-none">713</span>کلیپس</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriMoo d-none"><span
                                                class="d-none">714</span>سنجاقک</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriMoo d-none">
                                            <span class="d-none">715</span>آرایش و مراقبت مو</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSarpoosh d-none">
                                            <span class="d-none">720</span>کلاه زمستانی</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="aksesoriSarpoosh d-none"><span
                                                class="d-none">721</span>روسری</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="aksesoriSarpoosh d-none"><span
                                                class="d-none">722</span>شال</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))"
                                           class="aksesoriSarpoosh d-none"><span
                                                class="d-none">723</span>شال گردن</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSarpoosh d-none">
                                            <span class="d-none">724</span>ست کلاه و شال گردن</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSayer d-none"><span
                                                class="d-none">730</span>عینک</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSayer d-none"><span
                                                class="d-none">731</span>بند عینک</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSayer d-none"><span
                                                class="d-none">732</span>کراوات</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSayer d-none"><span
                                                class="d-none">733</span>پاپیون</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSayer d-none"><span
                                                class="d-none">734</span>ساس بند</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSayer d-none"><span
                                                class="d-none">735</span>ساعت</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSayer d-none"><span
                                                class="d-none">736</span>کمر بند</a>
                                    </li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSayer d-none"><span
                                                class="d-none">737</span>چتر</a></li>
                                    <li><a href="#" onclick="setProductCode($(this))" class="aksesoriSayer d-none"><span
                                                class="d-none">738</span>ست هدیه</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--جنسیت-->
            <div class="col-12 p-0 g-my-20">
                <span id="genderCode" class="d-none"></span>
                <span id="gender" class="d-none"></span>
                <label id="lblGender" class="g-mb-5 g-font-weight-600 g-color-red necessary">جنسیت</label>
                <div>
                    <div class="btn-group-lg d-flex">
                        <label class="u-check col-md-4 g-pa-0 m-0">
                            <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0" name="gender"
                                   onclick="$('#gender').text('زنانه');$('#genderCode').text('0')"
                                   type="radio" value="0">
                            <span onclick="$('#lblGender').removeClass('g-color-red')"
                                  class="btn btn-md btn-block g-brd-gray-light-v3 g-bg-gray-light-v5 g-brd-left-none g-brd-left-1--lg g-bg-primary--checked rounded-0 g-color-white--checked">زنانه</span>
                        </label>
                        <label class="u-check col-md-4 g-pa-0 m-0">
                            <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0" name="gender"
                                   onclick="$('#gender').text('مردانه');$('#genderCode').text('1')"
                                   type="radio" value="1">
                            <span onclick="$('#lblGender').removeClass('g-color-red')"
                                  class="btn btn-md btn-block g-brd-gray-light-v3 g-bg-gray-light-v5 g-brd-left-none g-brd-left-1--lg g-bg-primary--checked rounded-0 g-color-white--checked">مردانه</span>
                        </label>
                        <label class="u-check col-md-4 g-pa-0 m-0">
                            <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0" name="gender"
                                   onclick="$('#gender').text('کودکانه');$('#genderCode').text('2')"
                                   type="radio" value="2">
                            <span onclick="$('#lblGender').removeClass('g-color-red')"
                                  class="btn btn-md btn-block g-brd-gray-light-v3 g-bg-gray-light-v5 g-bg-primary--checked rounded-0 g-color-white--checked">کودکانه</span>
                        </label>
                    </div>
                </div>
            </div>
            <!--سایز-->
            <div class="col-12 p-0 g-my-20">
                <label id="lblSize" class="g-mb-5 g-font-weight-600 g-color-red necessary">سایز</label>
                <span id="size" class="d-none"></span>
                <div>
                    <select style="height: 40px" onchange="$('#size').text($(this).val())"
                            oninput="$('#lblSize').removeClass('g-color-red')"
                            class="form-control form-control-md custom-select g-brd-gray-light-v3 rounded-0 text-right g-pr-30 g-font-size-16">
                        <option style="direction: rtl" value="--">--</option>
                        <option style="direction: rtl" value="FreeSize">FreeSize</option>
                        <option style="direction: rtl" value="XXS">XXS</option>
                        <option style="direction: rtl" value="XS">XS</option>
                        <option style="direction: rtl" value="S">S</option>
                        <option style="direction: rtl" value="M">M</option>
                        <option style="direction: rtl" value="L">L</option>
                        <option style="direction: rtl" value="XL">XL</option>
                        <option style="direction: rtl" value="XXL">XXL</option>
                        <option style="direction: rtl" value="XXXL">XXXL</option>
                    </select>
                </div>
            </div>
            <!--قیمت-->
            <div class="col-12 p-0 g-my-20">
                <label id="lblPrice" class="g-mb-5 g-font-weight-600 g-color-red necessary">قیمت</label>
                <span id="tempPrice" class="d-none"></span>
                <div>
                    <input
                        class="form-control g-brd-gray-light-v3 form-control-md rounded-0 pl-0 text-right g-font-size-16"
                        type="text"
                        tabindex="6"
                        oninput="addComa($(this))"
                        placeholder="تومان"
                        id="price"
                        pattern="\d*"
                        value="">
                </div>
            </div>
            <!--تخفیف-->
            <div class="col-12 p-0 g-my-20">
                <label class="g-mb-5 g-font-weight-600">تخفیف</label>
                <div>
                    <input
                        class="form-control g-brd-gray-light-v3 form-control-md rounded-0 pl-0 text-right g-font-size-16"
                        type="text"
                        oninput="setFinalPrice($(this))"
                        placeholder="99..1 درصد"
                        id="discount"
                        maxlength="2"
                        pattern="\d*">
                </div>
            </div>
            <!--قیمت نهایی-->
            <div class="col-12 p-0 g-my-20">
                <label id="lblFinalPrice" class="g-mb-5 g-font-weight-600 g-color-red necessary">قیمت نهایی</label>
                <span id="tempFinalPrice" class="d-none"></span>
                <div>
                    <input
                        class="form-control g-bg-white g-brd-gray-light-v3 form-control-md g-color-blue rounded-0 pl-0 text-right g-font-size-16"
                        type="text"
                        tabindex="6"
                        placeholder="..."
                        id="finalPrice"
                        readonly
                        pattern="\d*"
                        value="">
                </div>
            </div>
            <!--رنگ-->
            <div class="col-12 p-0 g-my-20">
                <label id="lblColor" class="g-mb-5 g-font-weight-600 g-color-red necessary">رنگ</label>
                <div class="g-px-15 g-brd-around g-brd-gray-light-v3">
                    <input
                        class="form-control g-bg-white g-brd-none form-control-md rounded-0 g-px-0 text-right g-font-size-16"
                        type="text"
                        tabindex="6"
                        placeholder="..."
                        id="color"
                        onclick="$(this).hide(); $('#accordion').show()"
                        readonly
                        pattern="\d*">
                    <span id="colorCode" class="d-none"></span>
                    <!--پالت رنگ-->
                    <div style="display: none" id="accordion"
                         class="u-accordion u-accordion-color-primary g-py-15" role="tablist"
                         aria-multiselectable="true">
                        <!-- White -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-01" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-01" data-toggle="collapse"
                                       data-parent="#accordion" aria-expanded="true"
                                       aria-controls="accordion-body-01">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          خانواده رنگ های سفید
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-01" class="collapse show" role="tabpanel"
                                 aria-labelledby="accordion-heading-01">
                                <div id="0" class="u-accordion__body g-pa-20">
                                    <div style="background-color: white; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">سفید</span>
                                    </div>
                                    <div style="background-color: #FFFAFA; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">صورتی محو</span>
                                    </div>
                                    <div style="background-color: #F0FFF0; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">یشمی محو</span>
                                    </div>
                                    <div style="background-color: #F5FFFA; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">سفید نعنائی</span>
                                    </div>
                                    <div style="background-color: #F0FFFF; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">آبی محو</span>
                                    </div>
                                    <div style="background-color: #F0F8FF; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">نیلی محو</span>
                                    </div>
                                    <div style="background-color: #F8F8FF; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">سفید بنفشه</span>
                                    </div>
                                    <div style="background-color: #F5F5F5; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">خاکستری محو</span>
                                    </div>
                                    <div style="background-color: #FFF5EE; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">بژ باز</span>
                                    </div>
                                    <div style="background-color: #F5F5DC; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">هلی</span>
                                    </div>
                                    <div style="background-color: #FDF5D6; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">بژ روشن</span>
                                    </div>
                                    <div style="background-color: #FFFAF0; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">پوست پیازی</span>
                                    </div>
                                    <div style="background-color: #FFFFF0; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">استخوانی</span>
                                    </div>
                                    <div style="background-color: #FAEBD7; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">بژ تیره</span>
                                    </div>
                                    <div style="background-color: #FAF0E6; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">کتانی</span>
                                    </div>
                                    <div style="background-color: #FFF0F5; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">صورتی مات</span>
                                    </div>
                                    <div style="background-color: #F5EDDA; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('0',$(this))">
                                        <span class="toolTipText">بژ</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Red -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-02" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="collapsed d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-02" data-toggle="collapse"
                                       data-parent="#accordion" aria-expanded="false"
                                       aria-controls="accordion-body-02">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          خانواده رنگ های قرمز
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-02" class="collapse" role="tabpanel"
                                 aria-labelledby="accordion-heading-02">
                                <div id="1" class="u-accordion__body g-pa-20">
                                    <div style="background-color: #6C2E1F; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('1',$(this))">
                                        <span class="toolTipText">جگری</span>
                                    </div>
                                    <div style="background-color: #F08080; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('1',$(this))">
                                        <span class="toolTipText">مرجانی روشن</span>
                                    </div>
                                    <div style="background-color: #FA8072; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('1',$(this))">
                                        <span class="toolTipText">سالمون</span>
                                    </div>
                                    <div style="background-color: #FFA07A; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('1',$(this))">
                                        <span class="toolTipText">کرم نارنجی</span>
                                    </div>
                                    <div style="background-color: #FF0000; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('1',$(this))">
                                        <span class="toolTipText">قرمز</span>
                                    </div>
                                    <div style="background-color: #990000; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('1',$(this))">
                                        <span class="toolTipText">زرشکی</span>
                                    </div>
                                    <div style="background-color: #B22222; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('1',$(this))">
                                        <span class="toolTipText">شرابی</span>
                                    </div>
                                    <div style="background-color: #CD001A; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('1',$(this))">
                                        <span class="toolTipText">آلوبالویی</span>
                                    </div>
                                    <div style="background-color: #B84E59; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('1',$(this))">
                                        <span class="toolTipText">عنابی تند</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pink -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-03" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="collapsed d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-03" data-toggle="collapse"
                                       data-parent="#accordion" aria-expanded="false"
                                       aria-controls="accordion-body-03">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          خانواده رنگ های صورتی
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-03" class="collapse" role="tabpanel"
                                 aria-labelledby="accordion-heading-03">
                                <div id="2" class="u-accordion__body g-pa-20">
                                    <div style="background-color: #FFC0CB; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('2',$(this))">
                                        <span class="toolTipText">صورتی</span>
                                        <span class="d-none"></span>
                                    </div>
                                    <div style="background-color: #FF68C4; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('2',$(this))">
                                        <span class="toolTipText">صورتی پر رنگ</span>
                                        <span class="d-none"></span>
                                    </div>
                                    <div style="background-color: #DB7093; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('2',$(this))">
                                        <span class="toolTipText">شرابی روشن</span>
                                        <span class="d-none"></span>
                                    </div>
                                    <div style="background-color: #FF69B4; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('2',$(this))">
                                        <span class="toolTipText">سرخ آبی</span>
                                        <span class="d-none"></span>
                                    </div>
                                    <div style="background-color: #FF00FF; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('2',$(this))">
                                        <span class="toolTipText">سرخابی روشن</span>
                                    </div>
                                    <div style="background-color: #FF1493; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('2',$(this))">
                                        <span class="toolTipText">شفقی</span>
                                        <span class="d-none"></span>
                                    </div>
                                    <div style="background-color: #C71585; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('2',$(this))">
                                        <span class="toolTipText">ارغوانی</span>
                                        <span class="d-none"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orange -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-04" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="collapsed d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-04"
                                       data-toggle="collapse"
                                       data-parent="#accordion"
                                       aria-expanded="false"
                                       aria-controls="accordion-body-04">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          خانواده رنگ های نارنجی
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-04"
                                 class="collapse"
                                 role="tabpanel"
                                 aria-labelledby="accordion-heading-04">
                                <div id="3" class="u-accordion__body g-pa-20">
                                    <div style="background-color: #FFA07A; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('3',$(this))">
                                        <span class="toolTipText">کرم نارنجی</span>
                                    </div>
                                    <div style="background-color: #FFA500; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('3',$(this))">
                                        <span class="toolTipText">نارنجی</span>
                                    </div>
                                    <div style="background-color: #FF8C00; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('3',$(this))">
                                        <span class="toolTipText">نارنجی سیر</span>
                                    </div>
                                    <div style="background-color: #FF7F50; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('3',$(this))">
                                        <span class="toolTipText">نارنجی پر رنگ</span>
                                    </div>
                                    <div style="background-color: #FF6347; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('3',$(this))">
                                        <span class="toolTipText">قرمز گوجه ای</span>
                                    </div>
                                    <div style="background-color: #FF4500; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('3',$(this))">
                                        <span class="toolTipText">قرمز نارنجی</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Yellow -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-05" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="collapsed d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-05"
                                       data-toggle="collapse"
                                       data-parent="#accordion"
                                       aria-expanded="false"
                                       aria-controls="accordion-body-05">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          خانواده رنگ های زرد
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-05"
                                 class="collapse"
                                 role="tabpanel"
                                 aria-labelledby="accordion-heading-05">
                                <div id="4" class="u-accordion__body g-pa-20">
                                    <div style="background-color: #FFFFE0; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">شیری</span>
                                    </div>
                                    <div style="background-color: #FFFACD; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">شیری شکری</span>
                                    </div>
                                    <div style="background-color: #FAFAD2; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">لیمویی روشن</span>
                                    </div>
                                    <div style="background-color: #FFEFD5; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">هلویی روشن</span>
                                    </div>
                                    <div style="background-color: #FFE4B5; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">هلویی</span>
                                    </div>
                                    <div style="background-color: #FFDAB9; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">هلویی پر رنگ</span>
                                    </div>
                                    <div style="background-color: #EEE8AA; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">نخودی</span>
                                    </div>
                                    <div style="background-color: #F0E683; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">خاکی</span>
                                    </div>
                                    <div style="background-color: #FFFF00; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">زرد</span>
                                    </div>
                                    <div style="background-color: #FFD700; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">طلایی</span>
                                    </div>
                                    <div style="background-color: #e89783; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">رز گلد</span>
                                    </div>
                                    <div style="background-color: #BDB76B; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('4',$(this))">
                                        <span class="toolTipText">ماشی</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Green -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-06" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="collapsed d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-06"
                                       data-toggle="collapse"
                                       data-parent="#accordion"
                                       aria-expanded="false"
                                       aria-controls="accordion-body-06">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          خانواده رنگ های سبز
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-06"
                                 class="collapse"
                                 role="tabpanel"
                                 aria-labelledby="accordion-heading-06">
                                <div id="5" class="u-accordion__body g-pa-20">
                                    <div style="background-color: #ADFF2F; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">مغز پسته ای روشن</span>
                                    </div>
                                    <div style="background-color: #7FFF00; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">مغز پسته ای</span>
                                    </div>
                                    <div style="background-color: #7CFc00; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">مغز پسته ای پر رنگ</span>
                                    </div>
                                    <div style="background-color: #00FF00; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز کم رنگ</span>
                                    </div>
                                    <div style="background-color: #98FB98; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز کدر</span>
                                    </div>
                                    <div style="background-color: #68c7a5; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">یشمی کم رنگ</span>
                                    </div>
                                    <div style="background-color: #00a86b; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">یشمی</span>
                                    </div>
                                    <div style="background-color: #004129; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">یشمی سیر</span>
                                    </div>
                                    <div style="background-color: #9ACD32; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز لجنی</span>
                                    </div>
                                    <div style="background-color: #32CD32; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز چمنی</span>
                                    </div>
                                    <div style="background-color: #3CB371; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">خزه ای</span>
                                    </div>
                                    <div style="background-color: #2E8B57; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">خزه ای پر نگ</span>
                                    </div>
                                    <div style="background-color: #228B22; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">شویدی</span>
                                    </div>
                                    <div style="background-color: #008000; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز</span>
                                    </div>
                                    <div style="background-color: #6B8E23; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز ارتشی</span>
                                    </div>
                                    <div style="background-color: #808000; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">زیتونی</span>
                                    </div>
                                    <div style="background-color: #556B2F; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">زیتونی سیر</span>
                                    </div>
                                    <div style="background-color: #006400; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز آواکادو</span>
                                    </div>
                                    <div style="background-color: #66CDAA; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز دریایی</span>
                                    </div>
                                    <div style="background-color: #40E0D0; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز دریایی روشن</span>
                                    </div>
                                    <div style="background-color: #8FBC8F; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز دریایی تیره</span>
                                    </div>
                                    <div style="background-color: #20B2AA; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز کبریتی روشن</span>
                                    </div>
                                    <div style="background-color: #008B8B; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز کبریتی تیره</span>
                                    </div>
                                    <div style="background-color: #008080; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('5',$(this))">
                                        <span class="toolTipText">سبز دودی</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Blue -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-07" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="collapsed d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-07"
                                       data-toggle="collapse"
                                       data-parent="#accordion"
                                       aria-expanded="false"
                                       aria-controls="accordion-body-07">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          خانواده رنگ های آبی
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-07"
                                 class="collapse"
                                 role="tabpanel"
                                 aria-labelledby="accordion-heading-07">
                                <div id="6" class="u-accordion__body g-pa-20">
                                    <div style="background-color: #00FFFF; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">فیروزه ای</span>
                                    </div>
                                    <div style="background-color: #E0FFFF; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی آسمانی</span>
                                    </div>
                                    <div style="background-color: #AFEEEE; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">فیروزه ای کدر</span>
                                    </div>
                                    <div style="background-color: #00FFFF; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">فیروزه ای</span>
                                    </div>
                                    <div style="background-color: #48D1CC; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">فیروزه ای تیره</span>
                                    </div>
                                    <div style="background-color: #00CED1; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">فیروزه ای سیر</span>
                                    </div>
                                    <div style="background-color: #B0E0E6; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی کبریتی روشن</span>
                                    </div>
                                    <div style="background-color: #B0C4DE; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی مایل به بنفش</span>
                                    </div>
                                    <div style="background-color: #ADD8E6; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی کبریتی</span>
                                    </div>
                                    <div style="background-color: #87CEFB; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی آسمانی سیر</span>
                                    </div>
                                    <div style="background-color: #87CEFA; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی روشن</span>
                                    </div>
                                    <div style="background-color: #00BFFF; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی کم رنگ</span>
                                    </div>
                                    <div style="background-color: #6495ED; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی کدر</span>
                                    </div>
                                    <div style="background-color: #4682B4; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">نیلی متالیک</span>
                                    </div>
                                    <div style="background-color: #5F9EA0; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی لجنی</span>
                                    </div>
                                    <div style="background-color: #7B68EE; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی متالیک روشن</span>
                                    </div>
                                    <div style="background-color: #1E90FF; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">نیلی</span>
                                    </div>
                                    <div style="background-color: #4169E1; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">فیروزه ای فسفری</span>
                                    </div>
                                    <div style="background-color: #0000FF; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی</span>
                                    </div>
                                    <div style="background-color: #0000CD; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی سیر</span>
                                    </div>
                                    <div style="background-color: #00008B; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">سرمه ای</span>
                                    </div>
                                    <div style="background-color: #000080; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">لاجوردی</span>
                                    </div>
                                    <div style="background-color: #191970; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('6',$(this))">
                                        <span class="toolTipText">آبی نفتی</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Magenta -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-08" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="collapsed d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-08"
                                       data-toggle="collapse"
                                       data-parent="#accordion"
                                       aria-expanded="false"
                                       aria-controls="accordion-body-08">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          خانواده رنگ های بنفش
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-08"
                                 class="collapse"
                                 role="tabpanel"
                                 aria-labelledby="accordion-heading-08">
                                <div id="7" class="u-accordion__body g-pa-20">
                                    <div style="background-color: #E6E6FA; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">نیلی کم رنگ</span>
                                    </div>
                                    <div style="background-color: #D8BFD8; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">بادمجانی روشن</span>
                                    </div>
                                    <div style="background-color: #DDA0DD; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">بنفش کدر</span>
                                    </div>
                                    <div style="background-color: #EE82EE; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">بنفش روشن</span>
                                    </div>
                                    <div style="background-color: #DA70D6; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">ارکیده</span>
                                    </div>
                                    <div style="background-color: #BA55D3; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">ارکیده سیر</span>
                                    </div>
                                    <div style="background-color: #9370DB; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">آبی بنفش</span>
                                    </div>
                                    <div style="background-color: #6A5ACD; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">آبی فولادی</span>
                                    </div>
                                    <div style="background-color: #8A2BE2; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">آبی بنفش سیر</span>
                                    </div>
                                    <div style="background-color: #9400D3; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">بنفش باز</span>
                                    </div>
                                    <div style="background-color: #9932CC; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">ارکیده بنفش</span>
                                    </div>
                                    <div style="background-color: #8B008B; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">مخملی</span>
                                    </div>
                                    <div style="background-color: #800080; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">بنفش</span>
                                    </div>
                                    <div style="background-color: #483D8B; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">آبی دودی</span>
                                    </div>
                                    <div style="background-color: #4B0082; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('7',$(this))">
                                        <span class="toolTipText">نیلی سیر</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Brown -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-09" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="collapsed d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-09"
                                       data-toggle="collapse"
                                       data-parent="#accordion"
                                       aria-expanded="false"
                                       aria-controls="accordion-body-09">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          خانواده رنگ های قهوه ای
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-09"
                                 class="collapse"
                                 role="tabpanel"
                                 aria-labelledby="accordion-heading-09">
                                <div id="8" class="u-accordion__body g-pa-20">
                                    <div style="background-color: #FFF8DC; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">کاهی</span>
                                    </div>
                                    <div style="background-color: #FFEBCD; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">کاهگلی</span>
                                    </div>
                                    <div style="background-color: #755A36; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">حنایی</span>
                                    </div>
                                    <div style="background-color: #FFE4C4; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">کرم</span>
                                    </div>
                                    <div style="background-color: #FFDEAD; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">کرم سیر</span>
                                    </div>
                                    <div style="background-color: #F5DEBC; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">گندمی</span>
                                    </div>
                                    <div style="background-color: #DEB887; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">خاکی</span>
                                    </div>
                                    <div style="background-color: #D2B48C; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">برنزه ای کدر</span>
                                    </div>
                                    <div style="background-color: #BC8F8F; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">بادمجانی</span>
                                    </div>
                                    <div style="background-color: #F4A460; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">هلویی سیر</span>
                                    </div>
                                    <div style="background-color: #DAA520; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">خردلی</span>
                                    </div>
                                    <div style="background-color: #B8860B; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">ماشی سیر</span>
                                    </div>
                                    <div style="background-color: #CD853F; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">بادامی سیر</span>
                                    </div>
                                    <div style="background-color: #D2691E; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">عسلی پر رنگ</span>
                                    </div>
                                    <div style="background-color: #3A1D04; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">کاکائویی</span>
                                    </div>
                                    <div style="background-color: #A0522D; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">قهوه ای متوسط</span>
                                    </div>
                                    <div style="background-color: #663D14; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('8',$(this))">
                                        <span class="toolTipText">قهوه ای</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Black -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-10" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="collapsed d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-10"
                                       data-toggle="collapse"
                                       data-parent="#accordion"
                                       aria-expanded="false"
                                       aria-controls="accordion-body-10">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          خانواده رنگ های سیاه
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-10"
                                 class="collapse"
                                 role="tabpanel"
                                 aria-labelledby="accordion-heading-10">
                                <div id="9" class="u-accordion__body g-pa-20">
                                    <div style="background-color: #DCDCDC; cursor: pointer" onclick=""
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">خاکستری مات</span>
                                    </div>
                                    <div style="background-color: #D3D3D3; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">نقره ای</span>
                                    </div>
                                    <div style="background-color: #C0C0C0; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">توسی</span>
                                    </div>
                                    <div style="background-color: #A9A9A9; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">خاکستری سیر</span>
                                    </div>
                                    <div style="background-color: #808080; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">خاکستری</span>
                                    </div>
                                    <div style="background-color: #696969; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">دودی</span>
                                    </div>
                                    <div style="background-color: #778899; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">سربی</span>
                                    </div>
                                    <div style="background-color: #708090; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">سربی تیره</span>
                                    </div>
                                    <div style="background-color: #2F4F4F; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">لجنی تیره</span>
                                    </div>
                                    <div style="background-color: #36454F; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">ذغالی</span>
                                    </div>
                                    <div style="background-color: #1E1E1E; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">ذغالی سیر</span>
                                    </div>
                                    <div style="background-color: #0e0e0e; cursor: pointer"
                                         class="customTooltip g-pa-15 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover"
                                         onclick="setColor('9',$(this))">
                                        <span class="toolTipText">سیاه</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Multi Color -->
                        <div class="card rounded-0 g-brd-none">
                            <div id="accordion-heading-11" class="u-accordion__header g-pa-0" role="tab">
                                <p class="mb-0 text-uppercase g-font-size-default mb-0">
                                    <a class="collapsed d-block g-color-main g-text-underline--none--hover"
                                       href="#accordion-body-11"
                                       data-toggle="collapse"
                                       data-parent="#accordion"
                                       aria-expanded="false"
                                       aria-controls="accordion-body-11">
                                        <span
                                            class="u-accordion__control-icon d-inline-block g-brd-right g-brd-gray-light-v4 g-color-primary text-center">
                                          <i class="fa fa-plus"></i>
                                          <i class="fa fa-minus"></i>
                                        </span>
                                        <span class="d-inline-block g-px-15 g-py-5">
                                          رنگ های مالتی کالر
                                        </span>
                                    </a>
                                </p>
                            </div>
                            <div id="accordion-body-11"
                                 class="collapse"
                                 role="tabpanel"
                                 aria-labelledby="accordion-heading-11">
                                <div class="u-accordion__body g-pa-20">
                                    <div id="10" class="d-lg-block d-flex flex-column">
                                        <div style="cursor: pointer"
                                             class="multiColor d-inline-block g-mb-5 g-px-10 g-py-5 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover g-bg-primary--hover g-color-white--hover"
                                             onclick="setColor('10',$(this))">
                                            <span class="toolTipText">دو رنگ</span>
                                        </div>
                                        <div style="cursor: pointer"
                                             class="multiColor d-inline-block g-px-10 g-mb-5 g-py-5 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover g-bg-primary--hover g-color-white--hover"
                                             onclick="setColor('10',$(this))">
                                            <span class="toolTipText">سه رنگ</span>
                                        </div>
                                        <div style="cursor: pointer"
                                             class="multiColor d-inline-block g-px-10 g-mb-5 g-py-5 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover g-bg-primary--hover g-color-white--hover"
                                             onclick="setColor('10',$(this))">
                                            <span class="toolTipText">چهار رنگ</span>
                                        </div>
                                        <div style="cursor: pointer"
                                             class="multiColor d-inline-block g-px-10 g-mb-5 g-py-5 g-brd-around g-brd-gray-light-v3 g-ml-1 g-brd-primary--hover g-bg-primary--hover g-color-white--hover"
                                             onclick="setColor('10',$(this))">
                                            <span class="toolTipText">رنگارنگ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--توضیحات-->
        <div class="col-12 p-0 g-my-20">
            <label class="g-mb-5 g-font-weight-600">توضیحات</label>
            <div>
                  <textarea id="postTextTemp"
                            class="form-control g-font-size-16 hideScrollBar g-brd-gray-light-v4 form-control-md g-resize-none g-rounded-15 pl-0"
                            maxlength="600" rows="4" placeholder="100 حرف.."></textarea>
            </div>
        </div>
    </div>

    <!--افزودن-->
    <div class="text-left container g-mb-50 mx-auto col-12 col-lg-8">
        <label class="u-check g-mr-15 mb-0" id="addImg">
            <div
                class="u-check-icon-checkbox-v3 g-brd-gray-light-v4 g-bg-gray-light-v4 g-color-gray-dark-v3 g-color-primary--hover">
                <i class="fa fa-check g-absolute-centered"></i>
            </div>
        </label>
    </div>

@endsection
