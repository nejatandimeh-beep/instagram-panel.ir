@extends('Layouts.IndexCustomer')
@section('Content')
    <div style="direction: rtl" class="g-pa-15 g-pt-40 g-mb-100 regulation container">
        <div class="col-12 p-0">
                <h5 class="text-center text-lg-right g-my-20 g-mt-0--lg">راهنمای تصویری استفاده از پنل دستیار اینستاگرام</h5>
                <p>برای استفاده صحیح و آسانتر از سامانه، تمامی منوها و آپشن های پنل دستیار به صورت ویدیوی آموزشی تقدیم حضورتان می گردد.</p>
                <div>
                    <div class="d-flex justify-content-start g-mb-30">
                        <div style="direction: rtl" class="col-md-2 p-0">
                            <!--Nav tabs -->
                            <ul class="nav flex-column u-nav-v1-2 u-nav-primary g-pa-0" role="tablist"
                                data-target="nav-2-2-primary-ver"
                                data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-primary g-mb-20">
                                <li class="nav-item col-12 p-0">
                                    <a class="nav-link active g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                       data-toggle="tab"
                                       href="#nav-2-2-primary-ver--11" onclick="windowScrollTo()" role="tab">ثبت نام</a>
                                </li>
                                <li class="nav-item col-12 p-0">
                                    <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                       id="falseProduct"
                                       data-toggle="tab" href="#nav-2-2-primary-ver--13" onclick="windowScrollTo()"
                                       role="tab">منوها</a>
                                </li>
                                <li class="nav-item col-12 p-0">
                                    <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                       id="falseProduct"
                                       data-toggle="tab" href="#nav-2-2-primary-ver--14" onclick="windowScrollTo()"
                                       role="tab">پروفایل</a>
                                </li>
                                <li class="nav-item col-12 p-0">
                                    <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                       id="emptyProduct"
                                       data-toggle="tab" href="#nav-2-2-primary-ver--15" onclick="windowScrollTo()"
                                       role="tab">استوری</a>
                                </li>
                                <li class="nav-item col-12 p-0">
                                    <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                       id="emptyProduct"
                                       data-toggle="tab" href="#nav-2-2-primary-ver--16" onclick="windowScrollTo()"
                                       role="tab">پست</a>
                                </li>
                                <li class="nav-item col-12 p-0">
                                    <a class="nav-link g-brd-bottom g-brd-gray-light-v3 g-my-10 g-my-5--lg"
                                       id="deliveryProduct"
                                       data-toggle="tab" href="#nav-2-2-primary-ver--17" onclick="windowScrollTo()"
                                       role="tab">واکنش ها</a>
                                </li>
                            </ul>
                            <!--End Nav tabs -->
                        </div>
                    </div>
                    <div id="regulationContainer" class="col-md-12 p-0">
                        <div id="nav-2-2-primary-ver" class="tab-content g-mb-100">
                            <!-- کالای مورد مبادله -->
                            <div style="background-color: white; direction: rtl"
                                 class="tab-pane fade show active text-justify"
                                 id="nav-2-2-primary-ver--11" role="tabpanel">
                                <div>
                                    <h5>ثبت نام</h5>
                                    <div>
                                        <p>این قسمت شامل ویدیوی آموزشی ثبت نام است. جهت استفاده از پنل دستیار لینستاگرام می بایست ابتدا یک حساب کاربری ایجاد نمایید.</p>
                                        <div class="col-md-6 p-0">
                                            <div class="embed-responsive embed-responsive-16by9 g-mb-60">
                                                <video preload="auto" controls="controls" poster="../../assets/media-temp/video-bg/video-bg-poster.jpg" __idm_id__="933889">
                                                    <source src="../../assets/media-temp/video-bg/video-bg.webm" type="video/webm;">
                                                    <source src="../../assets/media-temp/video-bg/video-bg.mp4" type="video/mp4;">
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- محتوای نامناسب -->
                            <div style="background-color: white; direction: rtl" class="tab-pane fade text-justify"
                                 id="nav-2-2-primary-ver--13" role="tabpanel">
                                <div>
                                    <h5>منوها</h5>
                                    <div>
                                        <p>راهنمای استفاده از منوهای عمومی پنل دستیار اینستاگرام</p>
                                    </div>
                                </div>
                            </div>
                            <!-- مبادلات مالی و بانکی -->
                            <div style="background-color: white; direction: rtl" class="tab-pane fade text-justify"
                                 id="nav-2-2-primary-ver--14" role="tabpanel">
                                <div>
                                    <h5>پروفایل</h5>
                                    <div>
                                        <p>راهنمای امکانات موجود در پروفایل</p>
                                    </div>
                                </div>
                            </div>
                            <!-- کپی رایت -->
                            <div style="background-color: white; direction: rtl" class="tab-pane fade text-justify"
                                 id="nav-2-2-primary-ver--15" role="tabpanel">
                                <div>
                                    <h5>استوری ها</h5>
                                    <div>
                                        <p>در این قسمت کار با استوریها مانند افزودن، ویرایش، حذف، آمار بازدید استوری و ... آموزش داده خواهد شد.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- به روز رسانی -->
                            <div style="background-color: white; direction: rtl" class="tab-pane fade text-justify"
                                 id="nav-2-2-primary-ver--16" role="tabpanel">
                                <div>
                                    <h5>پست ها</h5>
                                    <div>
                                        <p>در این قسمت کار با پستها مانند افزودن، حذف، آمار بازدید پست و ... آموزش داده خواهد شد.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- به روز رسانی -->
                            <div style="background-color: white; direction: rtl" class="tab-pane fade text-justify"
                                 id="nav-2-2-primary-ver--17" role="tabpanel">
                                <div>
                                    <h5>واکنش ها</h5>
                                    <div>
                                        <p>در این قسمت کار نحوه تعامل سریع با کاربران آموزش داده خواهد شد.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
    </div>
@endsection
