<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function index(Request $request) {
        $items = Like::where('share_id',$request->share_id)->get()->count();
        return response()->json([
            'data'=>$items
        ],200);
    }
}
