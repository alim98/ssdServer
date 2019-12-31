<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        //
        $comment =new Comment();
        $comment->comment_id=uniqid();
        $comment->post_id=$request->post_id;
        $comment->student_id=$request->student_id;
        $comment->comment=$request->comment;
        $comment->timestamps;
        if ($comment->save()){
            if ($this->increase_comments_count($comment->post_id))
            {
                return response()->json(['success'=>true], 200);
            }else{
                $comment->delete();
                return response()->json(['success'=>false], 443);
                //443 means error in increasing
            }
        }else{
            return response()->json(['success'=>false], 500);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }






    public function delete($id)
    {
        $comment=Comment::where('comment_id', $id);
        if ($comment->delete()){
            return response()->json(['success'=>true], 200);
        }else{
            return response()->json(['success'=>false], 200);

        }
    }
    private function increase_comments_count($post_id)
    {
        $post=Post::find($post_id)->first();
        $last_comments_count=$post->comments_count;
        $new_comments_cont=$last_comments_count+1;
        $post->comments_count=$new_comments_cont;
        if ($post->save())
        {
            return true;
        }else{
            return false;
        }
    }

}
