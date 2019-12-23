<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $like=new Like();
        $like->like_id=uniqid();
        $like->post_id=$request->post_id;
        $like->student_id=$request->student_id;
        $matchthese=['post_id'=>$request->post_id, 'student_id'=>$request->student_id];
        $check=$like->where($matchthese)->first();
        if ($check==null)
        {
            if ($like->save()){
                return response()->json(['response'=>'success'], 200);
            }else{
                return response()->json(['response'=>'failure'], 500);
            }
        }else{
            return response("error", 500);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $like=Like::where('like_id', $id);
        if ($like->delete()){
            return response()->json(['response'=>'success'], 200);
        }else{
            return response()->json(['response'=>'failure'], 500);
        }
    }


    public function is_liked($student_id,$post_id)
    {
        $matchthese=['post_id'=>$post_id, 'student_id'=>$student_id];

        $like=Like::where($matchthese)->first();
        if ($like!=null){
            return response()->json(['is_liked'=>true], 200);
        }else{
            return response()->json(['is_liked'=>false], 200);
        }
    }

    public function get_like($student_id, $post_id)
    {
        $matchthese=['post_id'=>$post_id, 'student_id'=>$student_id];

        $like=Like::where($matchthese)->first();
        if($like!=null)
        {
           return response()->json(['response'=>$like->like_id], 200);
        }
    }

}
