<?php


namespace App\Http\Controllers\Api;



use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController
{
    public function register(Request $request)
    {
        $student=new Student();
        $student->phone_number=$request->phone_number;
        $student->first_name=$request->first_name;
        $student->last_name=$request->last_name;
        if ($student->last_name !=null){
            $student->full_name=$student->first_name." ".$student->last_name;
        }else{
            $student->full_name=$student->first_name;
        }
        $student->uni_code=$request->uni_code;
        $student->password=Hash::make($request->password);
        $student->username=$request->username;
        $student->api_token=Str::random(60);
        $student->timestamps;
        $file=$request->file('profile_uri');
        $im_name='st_pr_im_'.uniqid().'.jpg';
        if ($file!=null){
            $file->move(public_path('\st_img'), $im_name);
            $student->profile_uri=public_path('\st_img'.$im_name);
        }
        if ($student->save()){
            return response()->json(['response'=>'success'], 200);
        }else{
            return response()->json(['response'=>'failure'], 500);
        }
    }
}
