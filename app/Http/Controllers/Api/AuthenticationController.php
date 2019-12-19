<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    //
    public function login(Request $request)
    {
        $student=Student::where('phone_number', $request->phone_number)->first();

        if ($student)
        {
            $password=Hash::check($request->password, $student->password);
            if ($password){
                $apic=new ApiTokenController();
                $token=$apic->update($request);
                return response($token, 200);
            }else{
                $response="password mismatch";
                return response($response, 422);
            }
        }else
        {
            $response='user doesn\'t exists';
            return response($response, 422);
        }
    }

    public function logout(Request $request)
    {

        $student=Student::where('phone_number', $request->phone_number)->first();
        $header = $request->bearerToken();
        if ($header==$student->api_token) {
            $student->api_token=null;
            if ($student->save())
            {
                return response()->json(['response'=>'success'], 200);
            }else{
                return response()->json(['response'=>'failure'], 500);

            }
        }else{
            return response()->json(['response'=>'api token is invalid'], 442);
        }
    }
}
