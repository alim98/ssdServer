<?php

namespace App\Http\Controllers\Api;

use App\Follow;
use App\Http\Controllers\Controller;
use App\Post;
use App\Student;
use Illuminate\Http\Request;

class PostController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $post = new Post();
        $post->id = uniqid();
        $post->title = $request->title;
        $post->desc = $request->desc;
        $post->student_id = $request->student_id;
        $file = $request->file('profile_url');
        if ($file != null) {
            $file_name = public_path('\images') . 'image_' . $post->id . '.jpg';
            $post->profile_url = $file_name;

            $file->move(public_path('\images'), $file_name);

        }

        if ($post->save()) {
            return response()->json(['response' => 'success'], 200);
        } else {
            return response()->json(['response' => 'Error'], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        if ($post != null) {
            return response()->json($post, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $post = Post::find($id);
        $student = Student::where('phone_number', $request->student_id);
        $post->desc = $request->desc;
        $file = $request->file('profile_url');
        if ($file != null) {
            $file_name = public_path('\images') . 'image_' . $post->id . '.jpg';
            $post->profile_url = $file_name;

            $file->move(public_path('\images'), $file_name);
        }

        if ($post->save()) {
            return response()->json(['response' => 'success'], 200);
        } else {
            return response()->json(['response' => 'Error'], 500);
        }


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_posts_of_followings($phone_number, Request $request)
    {
        $header = $request->bearerToken();
        $student = Student::where('phone_number', $phone_number)->first();
        if ($student==null)
        {
            return response('student not found', 404);
        }
        if ($student->api_token == $header)
        {
            $follow=Follow::where('follower_id', $phone_number)->get();
            if ($follow==null)
            {
                return response('followings is empty', 500);
            }
            $post=null;
            for($i=0; $i<$follow->count();$i++)
            {
                $followings[$i]=$follow[$i]->following_id;
                $post[$i]=Post::where('student_id', $followings[$i])->get();

            }
            return response()->json( $post[0], 200);


        }else{
            return response('Error in authorization!', 442);
        }

    }

    public function update_likes_count(Request $request, $id)
    {
        $post = Post::find($id);

        $post->likes_count = $request->likes_count;

        if ($post->save()) {
            return response()->json(['response' => 'success'], 200);
        } else {
            return response()->json(['response' => 'Error'], 500);
        }
    }

    public function get_comments($id)
    {
        $post = Post::find($id);
        $comments = $post->comments;

        return response()->json($comments, 200);

    }
}
