<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    
    public function list()
    {
        $banners = Banner::where('status',1)->get();
        return response()->json([
            'result' => 'true',
            'banner immage path' => '/storage/banner/',
            'banners' => $banners
        ]);
    }

}
