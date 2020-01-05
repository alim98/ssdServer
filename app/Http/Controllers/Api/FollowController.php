<?php

namespace App\Http\Controllers\Api;

use App\Follow;
use App\Http\Controllers\Controller;
use App\Student;
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
        $student=Student::where('phone_number', $request->follower_id)->first();
        $header=$request->bearerToken();
        if($student->api_token!=$header)
        {
            return response()->json(['response'=>'error in Authorization'], 442);
        }
        $follow = new Follow();
        $follow->follower_id = $request->follower_id;
        $follow->following_id = $request->following_id;
        if ($follow->save()) {
            if($this->increase_followers_count($follow->following_id)){
                if ($this->increase_followings_count($follow->follower_id))
                {
                    return response()->json(['success'=>true], 200);
                }else{
                    $follow->delete();
                    return response()->json(['success'=>false], 443);
                }
            }else{
                $follow->delete();
                return response()->json(['success'=>false], 443);
            }
        }
    }

    public function unfollow($follower_id, $following_id, Request $request)
    {
        $student=Student::where('phone_number', $follower_id)->first();
        $header=$request->bearerToken();
        if($student->api_token!=$header)
        {
            return response()->json(['response'=>'error in Authorization'], 442);
        }
        $matchThese=['follower_id'=>$follower_id, 'following_id'=>$following_id];

        $follow = Follow::where($matchThese);
        if ($follow->delete()) {
            if ($this->decrease_followers_count($following_id))
            {
                if ($this->decrease_followings_count($follower_id))
                {
                    return response()->json(['success'=>true], 200);
                }else{
                    return response()->json(['success'=>true], 443);
                }
            }else{
                return response()->json(['success'=>true], 200);
            }
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


    private function increase_followers_count($student_id)
    {
        $student = Student::where('phone_number', $student_id)->first();
        $student->followers_count = $student->followers_count + 1;
        if ($student->save()) {
            return true;
        } else {
            return false;
        }
    }

    private function decrease_followers_count($student_id)
    {
        $student = Student::where('phone_number', $student_id)->first();
        $student->followers_count = $student->followers_count - 1;
        if ($student->save()) {
            return true;
        } else {
            return false;
        }
    }

    private function increase_followings_count($student_id)
    {
        $student = Student::where('phone_number', $student_id)->first();
        $student->followings_count = $student->followings_count + 1;
        if ($student->save()) {
            return true;
        } else {
            return false;
        }
    }

    private function decrease_followings_count($student_id)
    {
        $student = Student::where('phone_number', $student_id)->first();
        $student->followings_count = $student->followings_count - 1;
        if ($student->save()) {
            return true;
        } else {
            return false;
        }
    }
}
