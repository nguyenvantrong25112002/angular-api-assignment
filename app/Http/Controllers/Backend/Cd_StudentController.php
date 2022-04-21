<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class Cd_StudentController extends Controller
{
    public function index()
    {
        $student = Student::all();
        return response()->json($student, 200);
    }
}