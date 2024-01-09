<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;

use App\Rules\MatchOldPasswordForSeller;
use App\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.adminAuth.passwords.change');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPasswordForSeller],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        Seller::find(Auth::guard('admin')->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('profile','changePass');
    }
}
