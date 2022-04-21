<?php

namespace App\Http\Controllers\Backend;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Cd_QuizController extends Controller
{

    public function index()
    {
        $quiz = Quiz::all();
        return response()->json($quiz, 200);
    }
    public function subjectQuizList($id_subject)
    {
        $quizs = Quiz::where('subject_id', $id_subject)->get();
        return response()->json($quizs, 200);
    }
    public function store(Request $request)
    {
        $quiz = Quiz::create($request->all());
        return response()->json($quiz, 200);
    }
    public function show($id)
    {
        $quiz = Quiz::find($id);
        return response()->json($quiz, 200);
    }
    public function update($id, Request $request)
    {
        // return response()->json($request->all());
        $quiz = Quiz::find($id);
        if (is_null($quiz)) {
            return response()->json(['payload' => 'Không tồn tại trong cơ sở dữ liệu !'], 500);
        } else {
            $quiz->update([
                'name' => $request->name,
                'subject_id' => $request->subject_id,
                'duration_minutes' => $request->duration_minutes,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => 0,
                'is_shuffle' => $request->is_shuffle
            ]);
            // $quiz->update([$request->all()]);
            return response()->json($quiz, 200);
        }
    }
    public function updateShuffle($id, Request $request)
    {
        // return response()->json($request->all());
        $quiz = Quiz::find($id);
        if (is_null($quiz)) {
            return response()->json(['payload' => 'Không tồn tại trong cơ sở dữ liệu !'], 500);
        } else {
            if ($request->data == 0) {
                $quiz->is_shuffle = 1;
            } else {
                $quiz->is_shuffle = 0;
            }
            $quiz->save();
            // $quiz->update([$request->all()]);
            return response()->json($quiz, 200);
        }
    }
    public function destroy($id)
    {
        $quiz = Quiz::find($id);
        if (is_null($quiz)) {
            return response()->json(['payload' => 'Không tồn tại trong cơ sở dữ liệu !'], 500);
        } else {
            $quiz->destroy($id);
            // $quiz->update([$request->all()]);
            return response()->json(200);
        }
    }
}