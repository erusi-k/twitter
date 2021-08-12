<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;


class CommentController extends Controller
{
    public function index(Request $request) {
        $items = Comment::where('share_id',$request->shareId)->get();
        return response()->json([
            'data'=>$items
        ],200);
    }
    
    
    
    public function store(Request $request){
        $item = Comment::create($request->all());
        return response()->json([
            'data'=>$item
        ],201);
    }
}
