@extends('Layouts.SellerMajor.Index')
@section('Content')
    <span id="eventCount" class="d-none">{{count($events)}}</span>
    <ul class="list-inline g-flex-middle-item--bottom g-mb-5 p-0 g-brd-bottom g-brd-gray-light-v4">
        <span class="d-none">{{$temp=0}}</span>
        @foreach($events as $key => $row)
            @if($temp !== $row->sellerMajorID)
                <li class="list-inline-item align-middle g-mx-5 g-rounded-50x g-pa-5">
                    <div class="d-flex flex-column align-items-center">
                        <a class="u-icon-v1 u-icon-size--md g-color-white"
                           onclick="eventShow({{$row->sellerMajorID}})"
                           href="#!">
                            <img
                                class="g-width-40 g-height-40 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v1"
                                src="{{asset($row->Pic.'/profileImg.jpg')}}"
                                alt="Image Description">
                        </a>
                        <div class="g-mt-5">
                            <span>{{$row->name}}</span>
                        </div>
                    </div>
                </li>
            @endif
            <span class="d-none">{{$temp=$row->sellerMajorID}}</span>
        @endforeach
    </ul>

    <!--مودال ریل رویدادها-->
    <div style="padding: 0 !important; overflow: hidden; z-index: 10001" class="modal fade"
         id="allEvents"
         tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div style="max-width: 100%" class="modal-dialog m-0 modal-dialog-centered" role="document">
            <div style="height: 100vh;" class="modal-content">
                <div style="position: relative;" id="eventContainer" class="opacity-0">
                    <div style="position: fixed; top: 5px; z-index:10000" class="w-100">
                        <div class="g-width--360 mx-auto g-pr-2 gp-l-1">
                            <div class="d-flex">
                                @foreach($events as $key => $row)
                                    <div style="width: {{100/count($events).'%'}}; border-radius: 5px" class="g-bg-white-opacity-0_5 g-mx-1">
                                        <div id="progress-{{$key}}" class="g-bg-primary g-height-3 g-rounded-5 slide-width-0"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            @foreach($events as $key => $row)
                                <div class="swiper-slide pauseTimer">
                                    <div style="position: relative">
                                        <div style="direction: rtl; position: fixed; top: 10px; right:10px; width: inherit" class="g-pa-5 text-right">
                                            <div class="col-12 p-0 text-right">
                                                <img
                                                    class="g-width-30 g-height-30 rounded-circle g-brd-around g-brd-2 g-brd-gray-light-v4"
                                                    src="{{asset($row->profileImage.'/profileImg.jpg')}}"
                                                    alt="Image Description">
                                                <span style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3)"
                                                      class="g-font-size-13 g-color-white g-font-weight-600">{{$row->name}}</span>
                                            </div>
                                        </div>
                                        <img style="height: 100vh; object-fit: cover" class="w-100" alt="" src="{{$row->eventPic.'/'.$row->eventID.'.jpg'}}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div style="height: 100%; top: 0; padding-left: 20%" class="swiper-button-prev"></div>
                        <div style="height: 100%; top: 0; padding-left: 20%" class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
