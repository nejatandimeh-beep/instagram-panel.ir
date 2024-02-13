@section('CustomerFooter')
    <footer style="position: fixed; bottom: 0; z-index: 100" class="w-100 g-bg-white text-center g-pb-25 g-brd-top g-pt-5 g-brd-gray-light-v4">
        <!-- Footer Content -->
        <div class="container">
            <ul class="row no-gutters list-inline g-mb-5">
                <li class="{{isset(Auth::user()->id) ? 'col-3':'col-4'}} g-mt-2">
                    <a href="{{route('feed')}}"
                       title="پست ها"
                       class="g-color-black m-0 g-text-underline--none--hover p-0 g-color-primary--hover loginBtn">
                        <i class="icon-home g-font-size-25"></i>
                    </a>
                </li>
                <li class="{{isset(Auth::user()->id) ? 'col-3':'col-4'}} g-mt-2">
                    <a href="{{route('cSSearch','all')}}"
                       class="g-color-black m-0 g-text-underline--none--hover p-0 g-color-primary--hover loginBtn">
                        <i class="icon-magnifier g-font-size-25"></i>
                    </a>
                </li>
                <li class="col-3 g-mt-2 {{isset(Auth::user()->id) ? '':'d-none'}}">
                    <div class="d-inline-block">
                        <div style="position: relative">
                            <a href="{{route('customerReaction')}}" id="login"
                               title="نظرات"
                               class="g-color-black m-0 g-text-underline--none--hover p-0 g-color-primary--hover loginBtn">
                                <i class="icon-bubble g-font-size-25"></i>
                            </a>
                            <div style="position: absolute; top: -10px; right: -10px; width: 20px; height: 20px" class="{{$notification===0 ? 'd-none':''}} g-bg-red text-center rounded-circle">
                                <span style="color: white !important;">{{$notification}}</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="{{isset(Auth::user()->id) ? 'col-3':'col-4'}}">
                    <div class="d-inline-block">
                        <!-- Login -->
                        @guest
                            <div class="d-inline-block g-valign-middle">
                                <a href="{{ route('loginMode') }}" id="login"
                                   title="ورود یا ثبت نام"
                                   class="g-color-black m-0 g-text-underline--none--hover p-0 g-color-primary--hover loginBtn">
                                    {{--                                @if(Auth::user()->name===null || Auth::user()->name==='') {{'(کاربر'.Auth::user()->id.') '.Auth::user()->Mobile}} @else  {{Auth::user()->name}} @endif--}}

                                    <i id="login" class="icon-user g-font-size-25 g-ml-5"></i>
                                </a>
                            </div>
                        @else
                            <div style="position: relative">
                                <a href="{{route('userProfile')}}" id="login"
                                   title="اطلاعات کاربری"
                                   class="g-color-black m-0 g-text-underline--none--hover p-0 g-color-primary--hover loginBtn">
                                    {{--                                @if(Auth::user()->name===null || Auth::user()->name==='') {{'(کاربر'.Auth::user()->id.') '.Auth::user()->Mobile}} @else  {{Auth::user()->name}} @endif--}}

                                    <img class="g-width-30 g-height-30 rounded-circle g-brd-around g-brd-1 g-brd-gray-dark-v2"
                                         id="userImage"
                                         src="{{ asset($_SESSION['userProfilePic'].'?'.time()) }}"
                                         {{--use ? and time() for refresh image--}}
                                         alt="Image Description">
                                </a>
                                <div style="position: absolute; top: -10px; right: -10px; width: 20px; height: 20px" class="{{$notificationMsg===0 ? 'd-none':''}} g-bg-red text-center rounded-circle">
                                    <span style="color: white !important;">{{$notificationMsg}}</span>
                                </div>
                            </div>
                        @endguest
                    </div>
                </li>
            </ul>
        </div>
        <!-- End Footer Content -->
    </footer>
@endsection
