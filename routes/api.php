<?php

use App\Http\Controllers\Backend\Cd_AnswerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\MarkController;
use App\Http\Controllers\Frontend\QuizController;
use App\Http\Controllers\Backend\Cd_QuizController;
use App\Http\Controllers\Frontend\SubjectController;
use App\Http\Controllers\Frontend\QuestionController;
use App\Http\Controllers\Backend\Cd_SubjectController;
use App\Http\Controllers\Backend\Cd_QuestionController;
use App\Http\Controllers\Backend\Cd_StudentController;
use App\Http\Controllers\Backend\Cd_StudentQuizController;
use App\Http\Controllers\Frontend\StudentController;
use App\Http\Controllers\Frontend\StudentQuizController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('')->group(function () {
    Route::prefix('subject')->group(function () {
        Route::get('', [SubjectController::class, "index"]);
        Route::get('/{id}', [SubjectController::class, 'show']);
    });
    Route::prefix('quiz')->group(function () {
        Route::get('/{id}', [QuizController::class, 'show']);
    });
    Route::prefix('question')->group(function () {
        Route::get('/{id_quiz}', [QuestionController::class, 'show']);
    });
    Route::prefix('student-quiz')->group(function () {
        Route::get('', [StudentQuizController::class, 'listStudentQuizs']);
        Route::get('{id}', [StudentQuizController::class, 'detailStudentQuizs']);
        Route::post('', [StudentQuizController::class, 'addToStudentQuizs']);
        Route::put('{id}', [StudentQuizController::class, 'checkAnswer']);
    });
    Route::prefix('student')->group(function () {
        Route::post('login_google', [StudentController::class, 'login_google']);
    });
});

Route::prefix('admin')->group(function () {

    Route::prefix('subject')->group(function () {
        Route::get('', [Cd_SubjectController::class, "index"]);
        Route::post('', [Cd_SubjectController::class, "store"]);
        Route::delete('/{id}', [Cd_SubjectController::class, 'destroy']);
        Route::get('/{id}', [Cd_SubjectController::class, 'show']);
        Route::put('/{id}', [Cd_SubjectController::class, 'update']);
    });
    Route::prefix('quiz')->group(function () {
        Route::get('', [Cd_QuizController::class, 'index']);
        Route::post('', [Cd_QuizController::class, "store"]);
        Route::get('/{id}', [Cd_QuizController::class, 'show']);
        Route::put('/{id}', [Cd_QuizController::class, 'update']);
        Route::put('update-shuffle/{id}', [Cd_QuizController::class, 'updateShuffle']);
        Route::delete('/{id}', [Cd_QuizController::class, 'destroy']);
        Route::get('subject-quiz-list/{id_subject}', [Cd_QuizController::class, 'subjectQuizList']);
    });
    Route::prefix('question')->group(function () {
        Route::get('list/{id_quiz}', [Cd_QuestionController::class, 'index']);
        Route::get('edit/{id_quiz}', [Cd_QuestionController::class, 'edit']);
        Route::get('{id_question}', [Cd_QuestionController::class, 'show']);
        Route::post('', [Cd_QuestionController::class, 'store']);
        Route::put('{id}', [Cd_QuestionController::class, 'update']);
        Route::delete('{id}', [Cd_QuestionController::class, 'destroy']);
    });
    Route::prefix('answer')->group(function () {
        // Route::get('list-quiz/{question_id}', [Cd_AnswerController::class, 'answerListQuiz']);
    });

    Route::prefix('student-quiz')->group(function () {
        Route::get('', [Cd_StudentQuizController::class, 'index']);
        Route::get('{id}', [Cd_StudentQuizController::class, 'show']);
    });
    Route::prefix('student')->group(function () {
        Route::get('', [Cd_StudentController::class, 'index']);
    });
});