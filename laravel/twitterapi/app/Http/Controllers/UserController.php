<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserName;

class UserController extends Controller
{
    public function index(Request $request) {
        $item = UserName::where('email',$request->email)->get();
        return response()->json([
            'data' => $item
        ],200);
    }
    
    
    public function  store(Request $request) {
        $item = UserName::create($request->all());
        return response()->json([
            'data'=>$item,
        ],201);
    }
}
