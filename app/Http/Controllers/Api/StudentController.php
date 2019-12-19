<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class  StudentController extends Controller
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
        $student=Student::where('phone_number', $id)->first();
        if($student!=null){
           return response()->json($student, 200);
        }else{
          return  response("null");
        }
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
    }
    public function get_posts($id, Request $request)
    {

        $student=Student::where('phone_number', $id)->first();
        $header = $request->bearerToken();
        if ($header==$student->api_token){
            return response()->json($student->posts, 200);
        }
    }

    public function search($keyword)
    {
       /* $student=Student::where('first_name', 'LIKE',  $keyword.'%'  )
            ->orwhere('last_name', 'LIKE',  $keyword . '%')
           // ->orwhere('last_name', 'sounds like', '%' . $keyword . '%')


            ->get();*/

        $student=Student::where('full_name', 'LIKE',  $keyword.'%'  )
           // ->orwhere('full_name','sounds like', $keyword.'%')

            ->get();
        return response()->json($student, 200);
    }

    public function check_token(Request $request, $id)
    {
        $student=Student::where('phone_number', $id)->first();
        $header = $request->bearerToken();
        if ($header==$student->api_token) {
            return response()->json(['success'=> true], 200);
        }else{
            return response()->json(['success'=> false], 200);
        }
    }

    public function get_saved_posts($id, Request $request)
    {
        $student=Student::where('phone_number', $id)->first();
        $header = $request->bearerToken();
        if ($header==$student->api_token){
            return response()->json($student->saved_posts, 200);
        }
    }


}
