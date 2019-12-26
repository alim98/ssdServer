<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    //
    public function get_uni($code)
    {
        $university=University::where('uni_code', $code)->first();
        return response()->json($university, 200);
    }
}
