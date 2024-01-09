@extends('Layouts.IndexCustomer')
@section('Content')
    <div class="container g-mt-15">
        <div class="input-group">
            <div style="position: absolute; top:10px; left:10px; z-index: 10" class="input-group-prepend">
                <span class="input-group-text rounded-0 g-bg-white g-color-gray-light-v1"><i class="icon-magnifier"></i></span>
            </div>
            <input id="searchInput"
                   class="form-control form-control-md g-rounded-10 g-pl-30"
                   oninput="search($(this).val(),'following')"
                   type="text"
                   onclick="$('#catList').collapse('show')"
                   placeholder="..">
        </div>
        <ul id="searchResult" class="list-unstyled"></ul>
    </div>
    <div style="margin-bottom: 250px" class="container messageMenu">
        <ul style="direction: rtl" class="list-unstyled p-0">
            @foreach($data as $key => $row)
                <li id="sellerMajor-{{$row->SellerMajorID}}"
                    class="media g-pa-20--lg g-pa-10 g-mb-minus-1">
                    <div class="d-flex p-0 col-12">
                        <a href="{{route('cSmPanel',$row->SellerMajorID)}}" class="w-100 nav-link g-px-0 g-pb-5 g-pt-0">
                            <div class="d-flex">
                                <img class="g-width-40 g-height-40 rounded-circle g-ml-10--lg g-ml-5"
                                     src="{{$row->Pic=='img/SellerMajorProfileImage/Default/icon.jpg'?asset($row->Pic):asset($row->Pic).'/profileImg.jpg?'.date('Y-m-d H:i:s')}}" alt="Image Description">

                                <strong class="align-self-center">{{$row->name}}</strong>
                            </div>
                        </a>
                        <span style="cursor: pointer;" class="align-self-center g-mr-5 g-font-size-20 g-font-weight-600"
                              onclick="deleteFollowing({{$row->SellerMajorID}},$(this))"><i style="color: red !important;" class="icon-user-unfollow"></i></span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
