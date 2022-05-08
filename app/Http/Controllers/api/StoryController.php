<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    
    public function stories()
    {
        $stories = Story::get();
        return response()->json([
            'result' => true,
            'image path' =>'/storage/story/',
            'stories' => $stories
        ],200);
    }

    public function activestories()
    {
        $stories = Story::where('status',1)->get();
        return response()->json([
            'result' => true,
            'image path' =>'/storage/story/',
            'stories' => $stories
        ],200);
    }

    public function userstories(Request $request)
    {
        $stories = Story::where('status',1)->where('user_id',$request->id)->get();
        return response()->json([
            'result' => true,
            'image path' =>'/storage/story/',
            'stories' => $stories
        ],200);
    }

}
