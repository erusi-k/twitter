<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function index(Request $request) {
        $likes = Like::where('share_id',$request->share_id)->count();
        
        $user = Like::where('share_id',$request->share_id)->where('user_id',$request->user_id)->first();
        return response()->json([
            'data'=>$likes,
            'user'=>$user
            
        ],200);
    }

    public function store(Request $request){
        $item = Like::create([
            'share_id'=>$request->share_id,
            'user_id'=>$request->user_id
        ]);

    return response()->json([
        'data'=>$item
    ],201);

    }

    public function destroy(Request $request ,$id){
        $item = Like::where('user_id',$request->user_id)->where('share_id',$id)->delete();
        if($item) {
            return response()->json([
                'message'=>'deleted successfully',
            ],200);
            }else {
                return response()->json([
                    'message'=>'失敗',
                ],404);
            }
    }
}
