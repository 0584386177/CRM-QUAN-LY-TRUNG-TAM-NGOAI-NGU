<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{


    public function searchNavbar(Request $request)
    {
        $keyword = $request->input('keyword');
        $student = Student::when($keyword, function ($query, $keyword) {
            $query->where('email', 'LIKE', "%{$keyword}%")
                ->orWhere('fullname', 'LIKE', "%{$keyword}%")
                ->orWhere('phone', 'LIKE', "%{$keyword}%");
        })->get();
        return response()->json([
            'message' => 'Successfully',
            'data' => $student,
        ], 200);
    }
}
