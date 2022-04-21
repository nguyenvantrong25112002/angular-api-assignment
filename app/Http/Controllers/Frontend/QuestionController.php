<?php

namespace App\Http\Controllers\Frontend;

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

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $quiz_id)
    {

        // $quiz_id = 107;


        Db::beginTransaction();
        try {
            foreach ($request->all() as  $dbvalueQuestion) {
                $id_question = Question::create([
                    'text' => $dbvalueQuestion['Text'],
                    'quiz_id' =>  $quiz_id,
                ])->id;
                foreach ($dbvalueQuestion['Answers'] as $dbvalueAnswers) {

                    // echo ($dbvalueAnswers['Text']);
                    if ($dbvalueQuestion['AnswerId'] === $dbvalueAnswers['Id']) {
                        Answer::create([
                            'text' => $dbvalueAnswers['Text'],
                            'question_id' => $id_question,
                            'is_correct' => 'true'
                        ]);
                    } else {
                        Answer::create([
                            'text' => $dbvalueAnswers['Text'],
                            'question_id' => $id_question,
                            'is_correct' => 'false'
                        ]);
                    }
                }
            }
            Db::commit();
            dd('OK', $quiz_id);
        } catch (Exception $ex) {
            Db::rollBack();
            dd($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_quiz)
    {

        $questions = Question::where('quiz_id', $id_quiz)->get()->load('answers');
        return response()->json($questions, 200,);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}