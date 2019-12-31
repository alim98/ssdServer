<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Like;
use App\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function store(Request $request)
    {
        //

        $like = new Like();
        $like->like_id = uniqid();
        $like->post_id = $request->post_id;
        $like->student_id = $request->student_id;
        $matchthese = ['post_id' => $request->post_id, 'student_id' => $request->student_id];
        $check = $like->where($matchthese)->first();
        if ($check == null) {
            if ($like->save()) {
                if ($this->increase_likes_count($like->post_id)) {
                    return response()->json(['response' => 'success'], 200);
                }else{
                    $like->delete();
                    return  response()->json(['response'=>'error in increasing likes_count', 443]);
                }
            } else {
                return response()->json(['response' => 'failure'], 500);
            }
        } else {
            return response("error", 500);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($student_id, $post_id)
    {
        //
        $matchthese = ['post_id' => $post_id, 'student_id' => $student_id];

        $like = Like::where($matchthese);
        if ($like->delete()) {
            if ($this->decrease_likes_count($post_id)){
                return response()->json(['response' => 'success'], 200);
            }else{
                return response()->json(['response' => 'error in decreasing likes count'], 443);
            }

        } else {
            return response()->json(['response' => 'failure'], 500);
        }
    }


    public function is_liked($student_id, $post_id)
    {
        $matchthese = ['post_id' => $post_id, 'student_id' => $student_id];

        $like = Like::where($matchthese)->first();
        if ($like != null) {
            return response()->json(['is_liked' => true], 200);
        } else {
            return response()->json(['is_liked' => false], 200);
        }
    }

    public function get_like($student_id, $post_id)
    {
        $matchthese = ['post_id' => $post_id, 'student_id' => $student_id];

        $like = Like::where($matchthese)->first();
        if ($like != null) {
            return response()->json(['response' => $like->like_id], 200);
        }
    }

    private function increase_likes_count($post_id)
    {
        $post = Post::find($post_id)->first();
        $post->likes_count = $post->likes_count + 1;
        if ($post->save()) {
            return true;
        } else {
            return false;
        }
    }

    private function decrease_likes_count($post_id)
    {
        $post = Post::find($post_id)->first();
        $post->likes_count = $post->likes_count - 1;
        if ($post->save()) {
            return true;
        } else {
            return false;
        }
    }
}
