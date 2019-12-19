<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    //
    public function update(Request $request)
    {
        $token = Str::random(60);

        $student=Student::where('phone_number', $request->phone_number)->first();
        $student->phone_number=$request->phone_number;
        $student->api_token=$token;
        $student->save();
        return ['response' => $token];
    }
}
