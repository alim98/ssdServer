<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SavedPost;
use App\Student;
use http\Env\Response;
use Illuminate\Http\Request;

class SavedPostsController extends Controller
{
    //

    public function store(Request $request)
    {
        $student = Student::where('phone_number', $request->student_id)->first();
        $header = $request->bearerToken();
        if ($student->api_token == $header) {
            $sp = new SavedPost();
            $sp->saved_id=uniqid();
            $sp->student_id = $request->student_id;
            $sp->post_id = $request->post_id;
            if ($sp->save()) {
                return response()->json(['success' => true], 200);
            } else {
                return response()->json(['success' => false], 500);
            }
        } else {
            return response()->json(['success' => false], 442);
        }
    }

    public function destroy($id, Request $request)
    {
        $sp = SavedPost::where('saved_id', $id)->first();
        $student_id = $sp->student_id;
        $student = Student::where('phone_number', $student_id)->first();
        $header = $request->bearerToken();
        if ($student->api_token == $header) {
            if ($sp->delete()) {
                return response()->json(['success' => true], 200);
            } else {
                return response()->json(['success' => false], 500);

            }
        }else {
            return response()->json(['success' => false], 442);
        }
    }

}
