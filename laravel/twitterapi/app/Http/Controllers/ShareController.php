<?php

namespace App\Http\Controllers;

use App\Models\Share;
use App\Models\Like;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $likes= [];
        $userId = $request->user_id;
        $items= Share::where('user_id',$request->user_id)->get();
        
        foreach($items as $item) {
            
            $like = $item->like()->where('share_id',$item->id)->count();
            $likes[] = $like;
            $likeUser = like()->get();
            
            $likeUsers[] = $likeUser;
        }
        $i=0;
        foreach($likes as $itm){
        // for($i=0;$i<5;$i++){  
            
            if($i<=count($items)){
                $items[$i]['like'] = $itm;
                $i++;
            }

            // }
        }

        $i=0;
        foreach($likeUsers as $itm){
        // for($i=0;$i<5;$i++){  
            
            if($i<=count($items)){
                $items[$i]['likeUser'] = $itm->user_id;
                $i++;
            }

            // }
        }

        
        return response()->json([
            'data' => $items,
            'user' => $userId,
        ],200);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Share::create($request->all());
        return response()->json([
            'data' => $item
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Share  $share
     * @return \Illuminate\Http\Response
     */
    public function show(Share $share)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Share  $share
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Share $share)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Share  $share
     * @return \Illuminate\Http\Response
     */
    public function destroy(Share $share)
    {
        $item = Share::where('id',$share->id)->delete();
        if($item) {
        return response()->json([
            'message'=>'deleted successfully',
        ],200);
        }else {
            return response()->json([
                'message'=>'Not found',
            ],404);
        }
    }


}
