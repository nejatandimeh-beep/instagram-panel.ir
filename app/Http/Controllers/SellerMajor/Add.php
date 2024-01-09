<?php

namespace App\Http\Controllers\SellerMajor;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

//use function GuzzleHttp\default_user_agent;


class Add extends Controller
{

    public function __construct()
    {
        $this->middleware('IsSellerMajor');
    }
}

