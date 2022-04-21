<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;

class Cd_StudentQuizController extends Controller
{
    public function index()
    {
        $studentQuiz = StudentQuiz::all();
        return response()->json($studentQuiz, 200);
    }
    public function show()
    {
    }
}