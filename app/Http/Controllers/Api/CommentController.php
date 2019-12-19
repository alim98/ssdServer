<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
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
            return response()->json(['success'=>true], 200);
        }else{
            return response()->json(['success'=>false], 200);

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


}
