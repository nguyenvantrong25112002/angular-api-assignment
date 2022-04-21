<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderByDesc('id')->with('quizs')->get();
        return response()->json($subjects, 200);
    }

    public function show($id)
    {
        $subject = Subject::find($id);
        if (is_null($subject)) {
            return response()->json(['payload' => 'Không tồn tại trong cơ sở dữ liệu !'], 500);
        } else {
            return response()->json($subject, 200);
        }
    }
}