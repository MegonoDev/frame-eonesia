<?php

namespace App\Http\Controllers\f;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    protected $pathResult = 'img/result';
    public function index()
    {
        // return view('frontend.index');
        return redirect('https://eonesia.id');
    }
}
