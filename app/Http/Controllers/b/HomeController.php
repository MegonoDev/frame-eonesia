<?php

namespace App\Http\Controllers\b;
use App\Http\Controllers\b\BackendController;
use App\Models\Background;
use App\Models\Frame;
use App\Models\Photo;

class HomeController extends BackendController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bcrum = $this->bcrum('Dashboard');
        $frame = Frame::all()->count();
        $photo = Photo::all()->count();
        $bg    = Background::all()->count();

        return view('backend.home',compact('bcrum','frame','photo','bg'));
    }
}
