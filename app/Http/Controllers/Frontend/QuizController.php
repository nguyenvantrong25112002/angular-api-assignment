<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{

    public function store(Request $request)
    {
        $quiz = Quiz::create($request->all());
        return response()->json($quiz, 200);
    }
    public function show($id)
    {
        $quizs = Quiz::where('subject_id', $id)->get();
        return response()->json($quizs, 200);
    }
    public function update($id, Request $request)
    {
        $quiz = Quiz::find($id);
        if (is_null($quiz)) {
            return response()->json(['payload' => 'Không tồn tại trong cơ sở dữ liệu !'], 500);
        } else {
            // $quiz->update([
            //     'name' => $request->name,
            //     'subject_id' => $request->subject_id,
            //     'duration_minutes' => $request->duration_minutes,
            //     'start_time' => $request->start_time,
            //     'end_time' => $request->end_time,
            //     'status' => $request->status,
            //     'is_shuffle' => $request->is_shuffle
            // ]);
            $quiz->update([$request->all()]);
            return response()->json($quiz, 200);
        }
    }
}