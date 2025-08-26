<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class ChinaDiscoverController extends Controller
{
    public function index()
    {
        $banners = Banner::where('location', 'both' )->orWhere('location', 'mobile_app')->get();
        return view('mobile.china-discovers.index', compact('banners'));
    }
}
