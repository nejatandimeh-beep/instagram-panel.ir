@extends('Layouts.IndexAdmin')
@section('Content')
    <div style="margin-bottom: 250px" class="container messageMenu">
        <ul style="direction: rtl" class="list-unstyled p-0">
            @foreach($msg as $key => $row)
                <li id="msg-{{$row->msgID}}"
                    class="media g-brd-around g-brd-gray-light-v4 g-pa-20--lg g-pa-10 g-mb-5">
                    <div class="d-flex p-0 col-12">
                        <form style="display: none" id="msgDetailForm-{{$key}}"  action="{{route('adminSellerMajorMessagesDetail')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="customerID" value="{{$row->customerID}}">
                            <input type="text" name="sellerMajorID" value="{{$_SESSION['userProfileID']}}">
                        </form>
                        <a href="#" onclick="$('{{'#msgDetailForm-'.$key}}').submit()" class="w-100 nav-link g-px-0 g-pb-5 g-pt-0">
                            <div class="p-0">
                                <div class="d-flex">
                                    <img class="g-width-40 g-height-40 rounded-circle g-ml-10--lg g-ml-5"
                                         src="{{asset($row->PicPath)}}" alt="Image Description">

                                        <div class="d-flex flex-column g-pt-10">
                                            <div class="d-flex">
                                                <strong>{{!is_null($row->name)?$row->name:'کاربر '.$row->customerID}}</strong>
                                                <span style="direction: rtl"
                                                     class="align-self-center g-mx-5 text-nowrap  g-font-size-10 g-color-gray-light-v1">{{$howDay[$key]}}</span>
                                            </div>
                                                 <span style="direction: rtl"
                                                       class="{{$row->Status === '0'? '' : 'd-none'}} align-self-center g-font-size-10 text-nowrap g-color-primary">پیغام جدید</span>
                                        </div>
                                </div>
                            </div>
                        </a>
                        <span class="g-color-gray-light-v1 align-self-center g-mr-5"
                              onclick="deleteUserMsg({{$row->msgID}})"><i class="icon-trash"></i></span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
