<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class Cd_QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_quiz)
    {
        $questions = Question::where('quiz_id', $id_quiz)->orderByDesc('id')->get()->load('answers');
        return response()->json($questions, 200,);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jsons = json_decode(Http::get('http://localhost:3000/JSPR'));
        foreach ($jsons as $json) {
            $true = $json->AnswerId;
            $id_question = Question::create([
                'text' => $json->Text,
                'quiz_id' => 190,
            ])->id;
            if ($json->Answers) {
                foreach ($json->Answers as $as) {
                    if ($true === $as->Id) {
                        Answer::create([
                            'text' => $as->Text,
                            'question_id' => $id_question,
                            'is_correct' => 'true'
                        ]);
                    } else {
                        Answer::create([
                            'text' => $as->Text,
                            'question_id' => $id_question,
                            'is_correct' => 'false'
                        ]);
                    }
                }
                // var_dump('dsfsdf');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        Db::beginTransaction();
        try {
            $id_question = Question::create([
                'text' => $request->text,
                'quiz_id' => $request->quiz_id,
            ])->id;
            foreach ($request->answers as $answerKey) {
                Answer::create([
                    'text' => $answerKey['text'],
                    'question_id' => $id_question,
                    'is_correct' => $answerKey['is_correct'],
                ]);
            }
            Db::commit();
            return response()->json(200);
        } catch (\Throwable $th) {
            Db::rollBack();
        }
    }

    public function show($id_question)
    {
        $questions = Question::find($id_question);
        return response()->json($questions, 200,);
    }

    public function edit($id)
    {
        $questions = Question::find($id)->load('answers');
        return response()->json($questions, 200,);
    }


    public function update(Request $request, $id)
    {
        // foreach ($request->answers as $answerKey) {
        // echo $answerKey['id'];
        // return response()->json($answerKey, 200);
        // if (is_null($answerKey['id'])) {
        //     Answer::create([
        //         'text' => $answerKey['text'],
        //         'question_id' => $id,
        //         'is_correct' => $answerKey['is_correct'],
        //     ]);
        // } else {
        //     Answer::find($answerKey['id'])->update([
        //         'text' => $answerKey['text'],
        //         'question_id' => $id,
        //         'is_correct' => $answerKey['is_correct'],
        //     ]);
        // }

        // }
        $question = Question::find($id);
        $answers = Answer::where('question_id', $id)->get();
        DB::beginTransaction();
        try {
            if (is_null($question)) {
                return response()->json([
                    'payload' => "Lỗi không tồn tại trong cơ sở dữ liệu !"
                ], 404);
            } else {
                $question->text = $request->text;
                $question->quiz_id = $request->quiz_id;
                $question->save();
                if ($question) {
                    foreach ($request->answers as $answerKey) {
                        if (is_null($answerKey['id'])) {
                            Answer::create([
                                'text' => $answerKey['text'],
                                'question_id' => $id,
                                'is_correct' => $answerKey['is_correct'],
                            ]);
                        } else {

                            Answer::find($answerKey['id'])->update([
                                'text' => $answerKey['text'],
                                'question_id' => $id,
                                'is_correct' => $answerKey['is_correct'],
                            ]);
                        }
                    }
                }
                DB::commit();
                return response()->json($question, 200);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }


    public function destroy($id)
    {
        $question = Question::find($id);
        if (is_null($question)) {
            return response()->json([
                'payload' => "Lỗi không tồn tại trong cơ sở dữ liệu !"
            ], 404);
        } else {
            $question->destroy($id);
            Answer::where('question_id', $id)->delete();
            return response()->json(200);
        }
    }
}