<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class  StudentController extends Controller
{

    public function show($id)
    {
        //
        $student = Student::where('phone_number', $id)->first();
        if ($student != null) {
            return response()->json($student, 200);
        } else {
            return response("null");
        }
    }



    public function update(Request $request, $id)
    {
        //
    }



    public function get_posts($id, Request $request)
    {

        $student = Student::where('phone_number', $id)->first();
        $header = $request->bearerToken();
        if ($header == $student->api_token) {
            $post = $student->posts;
            return response()->json($post, 200);
        }
    }

    public function search($keyword)
    {
        /* $student=Student::where('first_name', 'LIKE',  $keyword.'%'  )
             ->orwhere('last_name', 'LIKE',  $keyword . '%')
            // ->orwhere('last_name', 'sounds like', '%' . $keyword . '%')


             ->get();*/

        $student = Student::where('full_name', 'LIKE', $keyword . '%')
            // ->orwhere('full_name','sounds like', $keyword.'%')

            ->get();
        return response()->json($student, 200);
    }

    public function check_token(Request $request, $id)
    {
        $student = Student::where('phone_number', $id)->first();
        $header = $request->bearerToken();
        if ($header == $student->api_token) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 200);
        }
    }

    public function get_saved_posts($id, Request $request)
    {
        $student = Student::where('phone_number', $id)->first();
        $header = $request->bearerToken();
        if ($header == $student->api_token) {
            return response()->json($student->saved_posts, 200);
        }
    }

    public function get_public_info($id)
    {
        $student = Student::where('phone_number', $id)->first();
        $stpub = new Student();
        $stpub->first_name = $student->first_name;
        $stpub->last_name = $student->last_name;
        $stpub->username = $student->username;
        $stpub->profile_url = $student->profile_url;
        $stpub->uni_code = $student->uni_code;
        $stpub->created_at = $student->created_at;
        $stpub->updated_at = $student->updated_at;
        $stpub->followers_count=$student->followers_count;
        $stpub->followings_count=$student->followings_count;
        $stpub->posts_count=$student->posts_count;
        return response()->json($stpub, 200);
    }






}
