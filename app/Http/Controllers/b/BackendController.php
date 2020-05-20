<?php

namespace App\Http\Controllers\b;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BackendController extends Controller
{
    protected $limit = 10;
    protected $pathBackground = 'img/bg';
    protected function bcrum($current, $urlSecond = null, $nameSecond = null)
    {
        return [
            'url-first' => route('home'),
            'name-first' => 'Home',
            'url-second' => $urlSecond,
            'name-second' => $nameSecond,
            'current' => $current
        ];
    }
    protected function notification($level,$title,$message)
    {

       return  Session::flash('flash_notification', [
            'title'   => $title,
            'level'   => $level,
            'message' => $message
        ]);
    }
}
