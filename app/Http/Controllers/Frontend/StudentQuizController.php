<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Question;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\StudentQuizsDetail;
use Illuminate\Support\Facades\Session;

class StudentQuizController extends Controller
{
    public function addToStudentQuizs(Request $request)
    {
        DB::beginTransaction();
        try {
            $studentQuiz = StudentQuiz::create([
                'student_id' => $request->student_id,
                'quiz_id' => $request->quiz_id,
                'score' => 0,
            ]);
            DB::commit();
            return response()->json($studentQuiz, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['payload' => $th], 500);
        }
    }
    public function checkAnswer(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $score = 0;
            $studentQuizDetail = StudentQuizsDetail::where('student_quiz_id', $id)->get();
            if (!is_null($studentQuizDetail)) {
                StudentQuizsDetail::where('student_quiz_id', $id)->delete();
            }
            foreach ($request->all() as  $re) {
                $questionsCount = count(Question::where('quiz_id', $re['quiz_id'])->get()) / 10;
                foreach ($re['questionsAnswer'] as  $vl) {
                    $answers = Answer::where('question_id', $vl['question_id'])->get();
                    StudentQuizsDetail::create([
                        'student_quiz_id' => $id,
                        'answer_id' => $vl['answer_id']
                    ]);
                    foreach ($answers as $answer) {
                        if ($answer->id === $vl['answer_id'] && $answer->is_correct === "true") {
                            $score += $questionsCount;
                        }
                    }
                }
            }
            StudentQuiz::find($id)->update([
                'score' => $score,
            ]);
            DB::commit();
            return response()->json(['payload' => $score], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['payload' => $th], 500);
        }
    }

    public function listStudentQuizs()
    {
        $studentQuiz = StudentQuiz::where('student_id', 37)->get();
        $studentQuiz->load(['studentQuizDetail', 'quizs']);
        return response()->json($studentQuiz, 200);
    }
    public function detailStudentQuizs($id)
    {

        // $studentQuizDetail = StudentQuiz::find($id)->load([
        //     'studentQuizDetail' => function ($q) {
        //         return $q->with([
        //             'answers',
        //         ]);
        //     },
        //     'quizs' => function ($q) {
        //         return $q->with(
        //             [
        //                 'subjects',
        //                 'questions' => function ($q) {
        //                     return $q->with('answers');
        //                 }
        //             ]
        //         );
        //     },
        //     'students',
        // ]);
        $studentQuizDetail = StudentQuiz::find($id)->load(['studentQuizDetail', 'quizs']);
        return response()->json(
            [
                'payload' => $studentQuizDetail
            ],
            200
        );
    }
}