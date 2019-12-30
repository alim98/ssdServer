<?php

namespace App\Http\Controllers\Api;

use App\Follow;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    //
    public function is_followed($follower_id, $following_id)
    {
        $matchThese=['follower_id'=>$follower_id, 'following_id'=>$following_id];
        $follow = Follow::where($matchThese)->first();
        if ($follow!=null){
            return response()->json(['success'=>true], 200);
        }else{
            return response()->json(['success'=>false], 200);

        }
    }
    public function follow(Request $request)
    {
        $follow = new Follow();
        $follow->follower_id = $request->follower_id;
        $follow->following_id = $request->following_id;
        if ($follow->save()) {
            return response()->json(['success'=>true], 200);
        }
    }

    public function unfollow($follower_id, $following_id)
    {
        $matchThese=['follower_id'=>$follower_id, 'following_id'=>$following_id];

        $follow = Follow::where($matchThese);
        if ($follow->delete()) {
            return response()->json(['success'=>true], 200);
        } else {
            return response()->json(['success'=>false], 200);
        }
    }

    public function student_followers($st_id)
    {
        $follow = Follow::where(['following_id' => $st_id])->get();
        if ($follow != null) {
            return response()->json($follow, 200);
        } else {
            return response()->json($follow, 200);
        }
    }

    public function student_followings($st_id)
    {
        $follow = Follow::where(['follower_id' => $st_id])->get();
        if ($follow != null) {
            return response()->json($follow, 200);
        } else {
            return response()->json($follow, 200);
        }
    }

}
